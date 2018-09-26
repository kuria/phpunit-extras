PHPUnit extras
##############

Additional functionality for PHPUnit (such as assertions).

.. image:: https://travis-ci.com/kuria/phpunit-extras.svg?branch=master
    :target: https://travis-ci.com/kuria/phpunit-extras

.. contents::


Requirements
************

- PHP 7.1+


Usage
*****

``AssertionTrait``
==================

This trait exposes additional assertion methods to your test case.

.. code:: php

   <?php

   namespace Acme;

   use Kuria\PhpUnitExtras\Traits\AssertionTrait;
   use PHPUnit\Framework\TestCase;

   class ExampleTest extends TestCase
   {
       use AssertionTrait;

       function testFooBar()
       {
           $this->assertEqualIterable([1, 2, 3], new \ArrayObject([1, 2, 3]));
       }
   }


``assertLooselyIdentical($expected, $actual, $canonicalizeKeys = false)``
-------------------------------------------------------------------------

Assert that two values have the same type and value, but consider different
instances of the same class identical as long as they have identical properties.

If ``$canonicalizeKeys = TRUE``, then array key order is ignored.


``assertSameIterable(iterable $expected, $actual)``
---------------------------------------------------

Assert that two iterables contain the same values and types in the same order

Types are compared the same way as with the ``===`` operator.


``assertLooselyIdenticalIterable(iterable $expected, $actual, $canonicalizeKeys = false)``
------------------------------------------------------------------------------------------

Assert that two iterables contain the same values and types in the same order,
but consider different instances of the same class identical as long as they
have identical properties.

If ``$canonicalizeKeys = TRUE``, then array key order is ignored.


``assertEqualIterable(iterable $expected, $actual)``
----------------------------------------------------

Assert that two iterables contain equal values in any order

Types are compared the same way as with the ``==`` operator.


``looselyIdenticalTo($value, $canonicalizeKeys = false)``
---------------------------------------------------------

Create the ``IsLooselyIdentical`` constraint. See ``assertLooselyIdentical()``.


``identicalIterable(iterable $expected)``
-----------------------------------------

Create the ``IsIdenticalIterable`` constraint. See ``assertSameIterable()``.


``looselyIdenticalIterable(iterable $expected, $canonicalizeKeys = false)``
---------------------------------------------------------------------------

Create the ``IsLooselyIdenticalIterable`` constraint. See ``assertLooselyIdenticalIterable()``.


``equalIterable(iterable $expected)``
-------------------------------------

Create the ``IsEqualIterable`` constraint. See ``assertEqualIterable()``.


``ClockTrait``
==============

Mock current time in tests.

Only affects code that uses the `kuria/clock <https://github.com/kuria/clock>`_ component.

.. code:: php

   <?php

   namespace Acme;

   use Kuria\PhpUnitExtras\Traits\ClockTrait;
   use PHPUnit\Framework\TestCase;

   class ExampleTest extends TestCase
   {
       use ClockTrait;

       function testFooBar()
       {
           $this->atTime(1535904500, function () {
               // some code that uses Kuria/Clock/Clock
           });
       }
   }
