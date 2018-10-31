<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Helper;

use SebastianBergmann\Exporter\Exporter;

/**
 * @internal
 */
class LooseExporter extends Exporter
{
    /** @var bool */
    private $canonicalizeKeys;

    function __construct(bool $canonicalizeKeys)
    {
        $this->canonicalizeKeys = $canonicalizeKeys;
    }

    function toArray($value)
    {
        $array = parent::toArray($value);

        if ($this->canonicalizeKeys && is_object($value)) {
            // if keys are being canonicalized, sort array keys to produce more readable diffs
            ksort($array);
        }

        return $array;
    }

    protected function recursiveExport(&$value, $indentation, $processed = null)
    {
        if ($this->canonicalizeKeys && is_array($value)) {
            // if keys are being canonicalized, sort array keys to produce more readable diffs
            ksort($value);
        }

        if (is_object($value)) {
            // strip hashes from object exports so that they don't show up in the diffs
            return preg_replace(
                '{([^ ]+) Object &[^ ]*}A',
                '$1 Object',
                parent::recursiveExport($value, $indentation, $processed)
            );
        }

        return parent::recursiveExport($value, $indentation, $processed);
    }
}
