<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Traits;

use Kuria\PhpUnitExtras\Constraint;

/**
 * Expose additonal assertions to a TestCase
 */
trait AssertionTrait
{
    abstract static function assertThat(
        $value,
        \PHPUnit\Framework\Constraint\Constraint $constraint,
        string $message = ''
    ): void;

    /**
     * Assert that two values have the same type and value, but consider different instances
     * of the same class identical as long as they have identical properties
     *
     * If $canonicalizeKeys = TRUE, then array key order is ignored.
     */
    static function assertLooselyIdentical($expected, $actual, bool $canonicalizeKeys = false, string $message = ''): void
    {
        static::assertThat($actual, static::looselyIdenticalTo($expected, $canonicalizeKeys), $message);
    }

    /**
     * Assert that two iterables contain the same values and types in the same order
     *
     * Types are compared the same way as with the "===" operator.
     */
    static function assertSameIterable(iterable $expected, $actual, string $message = ''): void
    {
        static::assertThat($actual, static::identicalIterable($expected), $message);
    }

    /**
     * Assert that two iterables contain the same values and types in the same order, but consider
     * different instances of the same class identical as long as they have identical properties
     *
     * If $canonicalizeKeys = TRUE, then array key order is ignored.
     */
    static function assertLooselyIdenticalIterable(iterable $expected, $actual, bool $canonicalizeKeys = false, string $message = '')
    {
        static::assertThat($actual, static::looselyIdenticalIterable($expected, $canonicalizeKeys), $message);
    }

    /**
     * Assert that two iterables contain equal values in any order
     *
     * Types are compared the same way as with the "==" operator.
     */
    static function assertEqualIterable(iterable $expected, $actual, string $message = ''): void
    {
        static::assertThat($actual, static::equalIterable($expected), $message);
    }

    static function looselyIdenticalTo($value, bool $canonicalizeKeys = false): Constraint\IsLooselyIdentical
    {
        return new Constraint\IsLooselyIdentical($value, $canonicalizeKeys);
    }

    static function identicalIterable(iterable $expected): Constraint\IsIdenticalIterable
    {
        return new Constraint\IsIdenticalIterable($expected);
    }

    static function looselyIdenticalIterable(iterable $expected, bool $canonicalizeKeys = false): Constraint\IsLooselyIdenticalIterable
    {
        return new Constraint\IsLooselyIdenticalIterable($expected, $canonicalizeKeys);
    }

    static function equalIterable(iterable $expected): Constraint\IsEqualIterable
    {
        return new Constraint\IsEqualIterable($expected);
    }
}
