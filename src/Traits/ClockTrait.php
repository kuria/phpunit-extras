<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Traits;

use Kuria\Clock\Clock;

/**
 * Mock current time in tests
 *
 * Only affects code that uses the Kuria Clock component.
 *
 * @see Clock
 */
trait ClockTrait
{
    /**
     * Override current time for the duration of the callback
     *
     * @param \DateTimeInterface|int|float $now
     * @param callable $callback callback to invoke
     * @return mixed return value of the callback
     */
    static function atTime($now, callable $callback)
    {
        // store time if already overridden
        if (Clock::isOverridden()) {
            $previousOverride = Clock::microtime();
        } else {
            $previousOverride = null;
        }

        try {
            // override time
            Clock::override($now);

            // invoke callback
            return $callback();
        } finally {
            // restore previous state
            if ($previousOverride === null) {
                // no previous override - resume
                Clock::resume();
            } else {
                // restore previous override
                Clock::override($previousOverride);
            }
        }
    }
}
