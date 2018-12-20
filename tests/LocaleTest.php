<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class LocaleTest extends TestCase {

	public function testIsLocale()
	{
		$locale = new I18n\Locale;
		$locale->setLocale('en_US');

		$this->assertTrue($locale->isLocale('en_US'));
	}

	/**
	 * @expectedException \I18n\Exception\EmptyLocaleException
	 */
	public function testNullLocale()
	{
		$locale = new I18n\Locale;
		$locale->setLocale(null);
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

	public function testRaw()
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
		$raw = $locale->raw();

		$this->assertEquals('More Testing!', $raw['test.testing']);
	}

	public function testSetDelimiter()
	{
		$locale = new I18n\Locale;
		$locale->setDelimiter('-')
		       ->setStrings([
			'hi'      => 'Hello,',
			'rawr'    => 'Rawr, I am the king!',
			'foo'     => 'bar',
			'test'    => [
				'testing' => 'More Testing!',
				'ok'      => 'Testing is ok... I guess.',
			],
		]);
		$locale->flatten();
		$key = 'test-testing';

		$this->assertEquals('More Testing!', $locale->$key);
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
