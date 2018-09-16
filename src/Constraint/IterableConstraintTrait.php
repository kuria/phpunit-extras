<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use Kuria\Iterable\IterableHelper;
use SebastianBergmann\Comparator\ComparisonFailure;

trait IterableConstraintTrait
{
    function __construct(iterable $value)
    {
        parent::__construct(IterableHelper::toArray($value));
    }

    function evaluate($other, $description = '', $returnResult = false)
    {
        if (!is_iterable($other)) {
            if ($returnResult) {
                return false;
            }

            $this->fail($other, $description);
        }

        return parent::evaluate(IterableHelper::toArray($other), $description, $returnResult);
    }

    abstract protected function fail($other, $description, ?ComparisonFailure $comparisonFailure = null): void;
}
