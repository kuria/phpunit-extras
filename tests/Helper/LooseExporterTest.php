<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Helper;

use PHPUnit\Framework\TestCase;

class LooseExporterTest extends TestCase
{
    function testShouldExportObjectsWithoutHashes()
    {
        $exporter = new LooseExporter();

        $object = (object) ['foo' => 'bar'];

        $this->assertSame(
            $exporter->export($object),
            $exporter->export(clone $object)
        );
    }
}
