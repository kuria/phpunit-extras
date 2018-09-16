<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use Kuria\PhpUnitExtras\Helper\ComparisonHelper;
use Kuria\PhpUnitExtras\Helper\LooseExporter;
use PHPUnit\Framework\Constraint\Constraint;
use SebastianBergmann\Comparator\ComparisonFailure;

class IsLooselyIdentical extends Constraint
{
    /** @var mixed */
    private $value;

    function __construct($value)
    {
        parent::__construct();

        $this->exporter = new LooseExporter();
        $this->value = $value;
    }

    function toString(): string
    {
        return 'is loosely identical to ' . $this->exporter->export($this->value);
    }

    function evaluate($other, $description = '', $returnResult = false)
    {
        $success = parent::evaluate($other, $description, true);

        if ($returnResult) {
            return $success;
        }

        if (!$success) {
            $this->fail(
                $other,
                $description,
                new ComparisonFailure(
                    $this->value,
                    $other,
                    $this->exporter->export($this->value),
                    $this->exporter->export($other)
                )
            );
        }
    }

    protected function matches($other): bool
    {
        return ComparisonHelper::isLooselyIdentical($this->value, $other);
    }
}
