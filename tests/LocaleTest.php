<?php

class LocaleTest extends PHPUnit_Framework_TestCase {

	public function testIsLocale()
	{
		$locale = new I18n\Locale;
		$locale->setLocale('en_US');

		$this->assertTrue($locale->isLocale('en_US'));
	}

	public function testSetStrings()
	{
		$locale = new I18n\Locale;
		$locale->setStrings([
			'hi'   => 'Hello,',
			'rawr' => 'Rawr, I am the king!',
			'foo'  => 'bar',
		]);

		$this->assertEquals('Hello,', $locale->hi);
	}

	public function testGetNoStringFound()
	{
		$locale = new I18n\Locale;
		$this->assertNull($locale->get('foo'));
	}

	public function testFlatten()
	{
		$locale = new I18n\Locale;
		$locale->setStrings([
			'hi'      => 'Hello,',
			'rawr'    => 'Rawr, I am the king!',
			'foo'     => 'bar',
			'test'    => [
				'testing' => 'More Testing!',
				'ok'      => 'Testing is ok... I guess.',
			],
		]);
		$locale->flatten();

		$this->assertEquals('More Testing!', $locale->get('test.testing'));
	}

	/**
	 * @expectedException \I18n\Exception\DuplicateKeyException
	 */
	public function testFlattenThrowDuplicateKeyException()
	{
		$locale = new I18n\Locale;
		$locale->setStrings([
			'hi'      => 'Hello,',
			'rawr'    => 'Rawr, I am the king!',
			'foo'     => 'bar',
			'test.ok' => 'yes, that is ok',
			'test'    => [
				'testing' => 'More Testing!',
				'ok'      => 'Testing is ok... I guess.',
			],
		]);
		$locale->flatten();
	}
}
