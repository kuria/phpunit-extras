<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use Kuria\Iterable\IterableHelper;

class IsLooselyIdenticalIterable extends IsLooselyIdentical
{
    public function __construct($value, bool $canonicalizeKeys)
    {
        parent::__construct(IterableHelper::toArray($value), $canonicalizeKeys);
    }

    function evaluate($other, string $description = '', bool $returnResult = false)
    {
        if (!is_iterable($other)) {
            if ($returnResult) {
                return false;
            }

            $this->fail($other, $description);
        }

        return parent::evaluate(IterableHelper::toArray($other), $description, $returnResult);
    }
}
