<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class FacadeStaticI18nTest extends TestCase {

	public function setUp()
	{
		I18n\Facade\StaticI18n::mount();
	}

	public function tearDown()
	{
		I18n::fresh();
	}

	public function testSetArray()
	{
		$chainable  = I18n::set([
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
		I18n::set([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA');
		I18n::get('baz.rawr');
	}

	public function testLoadLocale()
	{
		I18n::set([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA')->load('en_CA');

		$this->assertEquals('meow?', I18n::get('baz.rawr'));
	}

	/**
	 * @expectedException \I18n\Exception\LocaleNotFoundException
	 */
	public function testLoadLocaleNotFound()
	{
		I18n::set([
			'foo' => 'bar',
			'baz' => [
				'rawr' => 'meow?',
			],
		], 'en_CA');
		I18n::load('en_US');
	}

	public function testLoadDirectory()
	{
		I18n::set(__DIR__.'/../dir/');
		I18n::load('en_CA');
		$this->assertEquals('More Testing!', I18n::get('test.testing'));
	}
}
