<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Traits;

use Kuria\PhpUnitExtras\Constraint\IsEqualIterable;
use Kuria\PhpUnitExtras\Constraint\IsIdenticalIterable;
use Kuria\PhpUnitExtras\Constraint\IsLooselyIdentical;
use Kuria\PhpUnitExtras\Constraint\IsLooselyIdenticalIterable;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class AssertionTraitTest extends TestCase
{
    use AssertionTrait;

    function testShouldAssertLooselyIdentical()
    {
        $object = new \stdClass();

        $this->assertLooselyIdentical($object, clone $object);

        $this->expectException(ExpectationFailedException::class);
        $this->assertLooselyIdentical((object) ['foo' => 123], (object) ['foo' => '123']);
    }

    function testShouldAssertLooselyIdenticalWithKeyCanonicalization()
    {
        $this->assertLooselyIdentical(['foo' => 123, 'bar' => 456], ['bar' => 456, 'foo' => 123], true);

        $this->expectException(ExpectationFailedException::class);
        $this->assertLooselyIdentical(['foo' => 123, 'bar' => 456], ['bar' => 789, 'foo' => 123], true);
    }

    function testShouldAssertSameIterable()
    {
        $this->assertSameIterable([1, 2, 3], new \ArrayObject([1, 2, 3]));

        $this->expectException(ExpectationFailedException::class);
        $this->assertSameIterable([1, 2, 3], new \ArrayObject([1, 2, '3']));
    }

    function testShouldAssertLooselyIdenticalIterable()
    {
        $object = new \stdClass();

        $this->assertLooselyIdenticalIterable([$object], new \ArrayObject([clone $object]));

        $this->expectException(ExpectationFailedException::class);
        $this->assertLooselyIdenticalIterable(
            [(object) ['foo' => 123]],
            [(object) ['foo' => '123']]
        );
    }

    function testShouldAssertLooselyIdenticalIterableWithKeyCanonicalization()
    {
        $this->assertLooselyIdenticalIterable(
            ['foo' => 123, 'bar' => 456],
            new \ArrayObject(['bar' => 456, 'foo' => 123]),
            true
        );

        $this->expectException(ExpectationFailedException::class);
        $this->assertLooselyIdenticalIterable(
            ['foo' => 123, 'bar' => 456],
            new \ArrayObject(['bar' => 789, 'foo' => 123]),
            true
        );
    }

    function testShouldAssertEqualIterable()
    {
        $this->assertEqualIterable([1, 2, 3], new \ArrayObject(['1', '2', '3']));

        $this->expectException(ExpectationFailedException::class);
        $this->assertEqualIterable([1, 2, 3], new \ArrayObject(['1', '2', 'x']));
    }

    function testShouldCreateLooselyIdenticalConstraint()
    {
        $this->assertInstanceOf(IsLooselyIdentical::class, $this->looselyIdenticalTo('value'));
    }

    function testShouldCreateIdenticalIterableConstraint()
    {
        $this->assertInstanceOf(IsIdenticalIterable::class, $this->identicalIterable([1, 2, 3]));
    }

    function testShouldCreateLooselyIdenticalIterableConstraint()
    {
        $this->assertInstanceOf(IsLooselyIdenticalIterable::class, $this->looselyIdenticalIterable([1, 2, 3]));
    }

    function testShouldCreateEqualIterableConstraint()
    {
        $this->assertInstanceOf(IsEqualIterable::class, $this->equalIterable([1, 2, 3]));
    }
}
