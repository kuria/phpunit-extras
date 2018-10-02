<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Helper;

use PHPUnit\Framework\TestCase;

class LooseExporterTest extends TestCase
{
    function testShouldExportObjectsWithoutHashes()
    {
        $exporter = new LooseExporter(false);

        $object = (object) ['foo' => 'bar'];

        $this->assertSame(
            $exporter->export($object),
            $exporter->export(clone $object)
        );
    }

    /**
     * @dataProvider provideValuesForCanonicalizationTest
     */
    function testShouldCanonicalizeArrayKeys($value, bool $canonicalizeKeys, string $expectedOutputRegex)
    {
        $exporter = new LooseExporter($canonicalizeKeys);

        $this->assertRegExp($expectedOutputRegex, $exporter->export($value));
    }

    function provideValuesForCanonicalizationTest()
    {
        return [
            // value, canonicalizeKeys, expectedOutputRegex
            [
                ['z' => 'foo', 'y' => 'bar', 'x' => [2 => 'a', 1 => 'b', 0 => 'c']],
                false,
                "{'z'.*'y'.*'x'.*2.*1.*0}s",
            ],
            [
                ['z' => 'foo', 'y' => 'bar', 'x' => [2 => 'a', 1 => 'b', 0 => 'c']],
                true,
                "{'x'.*0.*1.*2.*'y'.*'z'}s",
            ],
        ];
    }
}
