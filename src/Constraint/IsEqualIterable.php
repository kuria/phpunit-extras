<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use Kuria\Iterable\IterableHelper;
use PHPUnit\Framework\Constraint\IsEqual;

class IsEqualIterable extends IsEqual
{
    use IterableConstraintTrait;

    function __construct(iterable $value)
    {
        parent::__construct(IterableHelper::toArray($value), 0.0, 10, true);
    }
}
