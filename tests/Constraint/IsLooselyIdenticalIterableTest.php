<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

class IsLooselyIdenticalIterableTest extends IterableConstraintTest
{
    protected function createConstraint($value, bool $canonicalizeKeys = false): Constraint
    {
        return new IsLooselyIdenticalIterable($value, $canonicalizeKeys);
    }

    function provideValues()
    {
        return [
            // value, otherValue, [expectedResult]
            [[1, 2, 3], new \ArrayObject([1, 2, 3])],
            [[1, 2, 3], new \ArrayObject([1, '2', 3]), false],
            [[new \stdClass(), (object) ['foo' => 123]], [new \stdClass(), (object) ['foo' => 123]]],
            [[new \stdClass(), (object) ['foo' => 123]], [new \stdClass(), (object) ['foo' => '123']], false],
        ];
    }

    function testShouldEvaluateConstraintWithKeyCanonicalization()
    {
        $this->assertTrue(
            $this->createConstraint(['foo' => 123, 'bar' => 456], true)
                ->evaluate(new \ArrayObject(['bar' => 456, 'foo' => 123]), '', true)
        );

        $this->assertFalse(
            $this->createConstraint(['foo' => 123, 'bar' => 456], true)
                ->evaluate(new \ArrayObject(['bar' => 789, 'foo' => 123]), '', true)
        );
    }
}
