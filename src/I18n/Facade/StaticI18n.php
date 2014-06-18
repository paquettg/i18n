<?php
namespace I18n\Facade;

use I18n\I18n;

final class StaticI18n extends AbstractFacade {

	/**
	 * The I18n class to be used for the facade.
	 *
	 * @var I18n\I18n
	 */
	protected static $i18n = null;

	public static function __callStatic($method, $arguments)
	{
		if (self::$i18n instanceof I18n)
		{
			return call_user_func_array([self::$i18n, $method], $arguments);
		}
		else
		{
			self::$i18n = new I18n;
			return call_user_func_array([self::$i18n, $method], $arguments);
		}
	}

	/**
	 * Set the I18n object to null.
	 *
	 * @return void
	 */
	public static function fresh()
	{
		self::$i18n = null;
	}
}
