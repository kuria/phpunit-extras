<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use PHPUnit\Framework\Constraint\IsIdentical;

class IsIdenticalIterable extends IsIdentical
{
    use IterableConstraintTrait;
}
