<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Helper;

use SebastianBergmann\Exporter\Exporter;

class LooseExporter extends Exporter
{
    protected function recursiveExport(&$value, $indentation, $processed = null)
    {
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
