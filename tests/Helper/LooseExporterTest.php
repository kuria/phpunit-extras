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

    function testShouldExportArraysWithoutIds()
    {
        $exporter = new LooseExporter(false);

        $array = [1, 2, 3];

        $this->assertNotContains('&', $exporter->export([&$array, &$array]));
    }

    /**
     * @dataProvider provideValuesForCanonicalizationTest
     */
    function testShouldCanonicalize($value, bool $canonicalizeKeys, string $expectedOutputRegex)
    {
        $exporter = new LooseExporter($canonicalizeKeys);

        $this->assertRegExp($expectedOutputRegex, $exporter->export($value));
    }

    function provideValuesForCanonicalizationTest()
    {
        return [
            // value, canonicalizeKeys, expectedOutputRegex
            'array without canonicalization' => [
                ['z' => 'foo', 'y' => 'bar', 'x' => [2 => 'a', 1 => 'b', 0 => 'c']],
                false,
                "{'z'.*'y'.*'x'.*2.*1.*0}s",
            ],

            'array with canonicalization' =>[
                ['z' => 'foo', 'y' => 'bar', 'x' => [2 => 'a', 1 => 'b', 0 => 'c']],
                true,
                "{'x'.*0.*1.*2.*'y'.*'z'}s",
            ],

            'object without canonicalization' => [
                (object) ['z' => 'foo', 'y' => 'bar', 'x' => (object) [2 => 'a', 1 => 'b', 0 => 'c']],
                false,
                "{'z'.*'y'.*'x'.*2.*1.*0}s",
            ],

            'object with canonicalization' => [
                (object) ['z' => 'foo', 'y' => 'bar', 'x' => (object) [2 => 'a', 1 => 'b', 0 => 'c']],
                true,
                "{'x'.*0.*1.*2.*'y'.*'z'}s",
            ],
        ];
    }
}
