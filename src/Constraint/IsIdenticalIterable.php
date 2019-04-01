<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use Kuria\Iterable\IterableHelper;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsIdentical;

class IsIdenticalIterable extends Constraint
{
    /** @var IsIdentical */
    private $inner;

    function __construct(iterable $value)
    {
        $this->inner = new IsIdentical(IterableHelper::toArray($value));
    }

    function toString(): string
    {
        return $this->inner->toString();
    }

    function evaluate($other, string $description = '', bool $returnResult = false)
    {
        if (!is_iterable($other)) {
            if ($returnResult) {
                return false;
            }

            $this->fail($other, $description);
        }

        return $this->inner->evaluate(IterableHelper::toArray($other), $description, $returnResult);
    }

    function failureDescription($other): string
    {
        return $this->inner->additionalFailureDescription($other);
    }
}
