<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use Kuria\Iterable\IterableHelper;
use PHPUnit\Framework\Constraint\IsIdentical;

class IsIdenticalIterable extends IsIdentical
{
    use IterableConstraintTrait;

    function __construct(iterable $value)
    {
        parent::__construct(IterableHelper::toArray($value));
    }
}
