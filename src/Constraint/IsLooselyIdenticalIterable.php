<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

class IsLooselyIdenticalIterable extends IsLooselyIdentical
{
    use IterableConstraintTrait;
}
