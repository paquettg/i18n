<?php

class LocaleCollectionTest extends PHPUnit_Framework_TestCase {

	public function testSetArray()
	{
		$collection = new I18n\LocaleCollection;
		$chainable  = $collection->setArray([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA');

		$this->assertTrue($chainable instanceof I18n\LocaleCollection);
	}

	/**
	 * @expectedException \I18n\Exception\NoLocaleLoadedException
	 */
	public function testGetNoLocaleLoaded()
	{
		$collection = new I18n\LocaleCollection;
		$collection->setArray([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA');
		$collection->get('baz.rawr');
	}

	public function testLoadLocale()
	{
		$collection = new I18n\LocaleCollection;
		$collection->setArray([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA')->load('en_CA');

		$this->assertEquals('meow?', $collection->get('baz.rawr'));
	}

	/**
	 * @expectedException \I18n\Exception\LocaleNotFoundException
	 */
	public function testLoadLocaleNotFound()
	{
		$collection = new I18n\LocaleCollection;
		$collection->setArray([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA');
		$collection->load('en_US');
	}
}
