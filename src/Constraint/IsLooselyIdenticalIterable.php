<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use Kuria\Iterable\IterableHelper;

class IsLooselyIdenticalIterable extends IsLooselyIdentical
{
    use IterableConstraintTrait;

    function __construct(iterable $value, bool $canonicalizeKeys)
    {
        parent::__construct(IterableHelper::toArray($value), $canonicalizeKeys);
    }
}
