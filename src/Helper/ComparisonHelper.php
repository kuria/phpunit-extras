<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Helper;

abstract class ComparisonHelper
{
    /**
     * Check whether two values are loosely identical
     *
     * Types are compared the same way as with the "===" operator, but two different
     * instances of the same class are considered identical if they have identical properties.
     */
    static function isLooselyIdentical($a, $b, array &$visited = []): bool
    {
        // don't compare twice to allow for cyclic dependencies
        if (in_array([$a, $b], $visited, true) || in_array([$b, $a], $visited, true)) {
            return true;
        }

        $aType = gettype($a);
        $bType = gettype($b);

        // compare different instances of the same class as arrays
        if ($aType === 'object' && $bType === 'object' && get_class($a) === get_class($b) && $a !== $b) {
            return static::isLooselyIdentical((array) $a, (array) $b);
        }

        // compare arrays recursively
        if ($aType === 'array' && $bType === 'array') {
            $visited[] = [$a, $b];

            $keys = array_keys($a);

            if ($keys !== array_keys($b)) {
                return false;
            }

            foreach ($keys as $key) {
                if (!static::isLooselyIdentical($a[$key], $b[$key], $visited)) {
                    return false;
                }
            }

            return true;
        }

        // compare other values directly
        return $a === $b;
    }
}
