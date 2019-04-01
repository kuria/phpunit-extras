Changelog
#########

3.0.0
*****

- PHPUnit 8 support


2.0.3
*****

- remove array IDs in ``LooseExporter``


2.0.2
*****

- sort object properties in ``LooseExporter`` if key canonicalization is enabled


2.0.1
*****

- sort array keys in ``LooseExporter`` if key canonicalization is enabled


2.0.0
*****

- added ``$canonicalizeKeys`` parameter to:

  - ``ComparisonHelper::isLooselyIdentical()``
  - ``AssertionTrait::assertLooselyIdentical()``
  - ``AssertionTrait::assertLooselyIdenticalIterable()``
  - ``AssertionTrait::looselyIdenticalTo()``
  - ``AssertionTrait::looselyIdenticalIterable()``


1.0.0
*****

Initial release
