<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Helper;

use PHPUnit\Framework\TestCase;

class ComparisonHelperTest extends TestCase
{
    /**
     * @dataProvider provideValuesToLooselyCompare
     */
    function testShouldLooselyCompare($a, $b, bool $expectedResult)
    {
        $this->assertSame($expectedResult, ComparisonHelper::isLooselyIdentical($a, $b));
    }

    function provideValuesToLooselyCompare(): array
    {
        $object = (object) ['foo' => 123];
        $childClassObject = new class extends \stdClass {};
        $childClassObject->foo = 123;

        $selfReferencingArray = [];
        $selfReferencingArray['foo']['bar']['baz'] = &$selfReferencingArray;

        $selfReferencingObject = new \stdClass();
        $selfReferencingObject->foo = new \stdClass();
        $selfReferencingObject->foo->bar = new \stdClass();
        $selfReferencingObject->foo->bar->baz = $selfReferencingObject;

        return [
            // a, b, expectedResult
            [true, true, true],
            [false, false, true],
            [true, false, false],
            [true, 1, false],
            [false, 0, false],
            [null, null, true],
            [null, 0, false],
            [null, false, false],
            [null, '', false],
            [123, 123, true],
            [123, 456, false],
            [123, '123', false],
            [123, 123.0, false],
            [3.14, 3.14, true],
            [3.14, 5.12, false],
            [3.14, '3.14', false],
            ['foo', 'foo', true],
            ['foo', 'bar', false],
            [[1, 2, 3], [1, 2, 3], true],
            [[], [], true],
            [['foo'], [], false],
            [[1, 2, 3], [1, 2, '3'], false],
            [['a' => 1, 'b' => 2], [1, 2], false],
            [$object, clone $object, true],
            [$object, (object) ['foo' => '123'], false],
            [$object, $childClassObject, false],
            [$selfReferencingObject, $selfReferencingObject, true],
            [$selfReferencingArray, $selfReferencingArray, true],
            [$selfReferencingObject, $selfReferencingArray, false],
        ];
    }
}
