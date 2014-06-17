<?php

class I18nTest extends PHPUnit_Framework_TestCase {

	public function testSetArray()
	{
		$i18n = new I18n\I18n;
		$chainable  = $i18n->set([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA');

		$this->assertTrue($chainable instanceof I18n\I18n);
	}

	/**
	 * @expectedException \I18n\Exception\NoLocaleLoadedException
	 */
	public function testGetNoLocaleLoaded()
	{
		$i18n = new I18n\I18n;
		$i18n->set([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA');
		$i18n->get('baz.rawr');
	}

	public function testLoadLocale()
	{
		$i18n = new I18n\I18n;
		$i18n->set([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA')->load('en_CA');

		$this->assertEquals('meow?', $i18n->get('baz.rawr'));
	}

	/**
	 * @expectedException \I18n\Exception\LocaleNotFoundException
	 */
	public function testLoadLocaleNotFound()
	{
		$i18n = new I18n\I18n;
		$i18n->set([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA');
		$i18n->load('en_US');
	}

	public function testLoadDirectory()
	{
		$i18n = new I18n\I18n;
		$i18n->set(__DIR__.'/dir/');
		$i18n->load('en_CA');
		$this->assertEquals('More Testing!', $i18n->get('test.testing'));
	}
}
