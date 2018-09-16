<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Traits;

use Kuria\Clock\Clock;
use PHPUnit\Framework\TestCase;

class ClockTraitTest extends TestCase
{
    use ClockTrait;

    function testShouldOverrideTimeForCallback()
    {
        $expectedTime = 1532004939;

        $this->assertSame(
            'value',
            $this->atTime($expectedTime, function () use ($expectedTime) {
                $this->assertTrue(Clock::isOverridden());
                $this->assertSame($expectedTime, Clock::time());

                return 'value';
            })
        );

        $this->assertFalse(Clock::isOverridden());
    }

    function testShouldOverrideTimeForNestedCallbacks()
    {
        $times = [1531573186, 1531486791, 1531227607];

        // time 0
        $this->assertNull(
            $this->atTime($times[0], function () use ($times) {
                $this->assertTrue(Clock::isOverridden());
                $this->assertSame($times[0], Clock::time());

                // time 1
                $this->assertSame(
                    456,
                    $this->atTime($times[1], function () use ($times) {
                        $this->assertTrue(Clock::isOverridden());
                        $this->assertSame($times[1], Clock::time());

                        // time2
                        $this->assertSame(
                            123,
                            $this->atTime($times[2], function () use ($times) {
                                $this->assertTrue(Clock::isOverridden());
                                $this->assertSame($times[2], Clock::time());

                                return 123;
                            })
                        );

                        $this->assertTrue(Clock::isOverridden());
                        $this->assertSame($times[1], Clock::time());

                        return 456;
                    })
                );

                $this->assertTrue(Clock::isOverridden());
                $this->assertSame($times[0], Clock::time());
            })
        );

        $this->assertFalse(Clock::isOverridden());
    }

    function testShouldRestorePreviousTimeOrResumeEvenIfExceptionIsThrown()
    {
        $times = [1531573186, 1531486791];

        $e = null;
        try {
            // time 0
            $this->atTime($times[0], function () use ($times) {
                $this->assertTrue(Clock::isOverridden());
                $this->assertSame($times[0], Clock::time());

                // time 1
                $e = null;
                try {
                    $this->atTime($times[1], function () use ($times) {
                        $this->assertTrue(Clock::isOverridden());
                        $this->assertSame($times[1], Clock::time());

                        throw new \Exception('Time 1 exception');
                    });
                } catch (\Exception $e) {
                    $this->assertSame('Time 1 exception', $e->getMessage());
                }
                $this->assertNotNull($e);

                $this->assertTrue(Clock::isOverridden());
                $this->assertSame($times[0], Clock::time());

                throw new \Exception('Time 0 exception');
            });
        } catch (\Exception $e) {
            $this->assertSame('Time 0 exception', $e->getMessage());
        }
        $this->assertNotNull($e);

        $this->assertFalse(Clock::isOverridden());
    }
}
