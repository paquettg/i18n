<?php
namespace I18n;

use I18n\Exception\DuplicateKeyException;
use I18n\Exception\EmptyLocaleException;

class Locale {

	/**
	 * The locale string.
	 *
	 * @var string
	 */
 	protected $locale = '';

	/**
	 * The strings array.
	 *
	 * @var array
	 */
	protected $strings = [];

	/**
	 * The delimiter character (or string) to use when flattening
	 * the array.
	 *
	 * @var string
	 */
	protected $delimiter = '.';

	/**
	 * Gets a value from the strings array by magic method.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * Gets a value from the strings array by key.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		if ( ! isset($this->strings[$key]))
		{
			return null;
		}

		return $this->strings[$key];
	}

	/**
	 * Sets the locale for this object.
	 *
	 * @param string $locale
	 * @chainable
	 */
	public function setLocale($locale)
	{
		$locale = (string) $locale;
		if ($locale == '')
		{
			throw new EmptyLocaleException('The locale must be a string and not empty.');
		}
		$this->locale = $locale;
		return $this;
	}

	/**
	 * Sets the strings array.
	 *
	 * @param array $strings
	 * @chainable
	 */
	public function setStrings(array $strings)
	{
		$this->strings = $strings;
		return $this;
	}

	/**
	 * Sets the delimiter string to be used when flattening
	 * the array.
	 *
	 * @param string $delimiter
	 * @chainable
	 */
	public function setDelimiter($delimiter)
	{
		$this->delimiter = (string) $delimiter;
		return $this;
	}

	/**
	 * Checks if the given locale matches the locale in this object.
	 *
	 * @param string $locale
	 * @return bool
	 */
	public function isLocale($locale)
	{
		return $this->locale == $locale;
	}

	/**
	 * Flattens the $strings array.
	 *
	 * @uses $this->flattenString
	 * @return void
	 */
	public function flatten()
	{
		$flatten = [];
		$this->flattenString('', $this->strings, $flatten);
		$this->strings = $flatten;
	}

	/**
	 * Return the $strings array.
	 *
	 * @return array
	 */
	public function raw()
	{
		return $this->strings;
	}

	/**
	 * Flattens the given string array with the given pre String.
	 *
	 * @recursive
	 * @param string $preString
	 * @param array $strings
	 * @param array $flatten
	 * @throws DuplicateKeyException 
	 */
	protected function flattenString($preString, array $strings, array &$flatten)
	{
		foreach ($strings as $key => $string)
		{
			if (strlen($preString) > 0)
			{
				$key = $preString.$this->delimiter.$key;
			}
			if ( ! is_array($string))
			{
				if (isset($flatten[$key]))
				{
					// we have a problem, 2 strings with the same key.
					throw new DuplicateKeyException("The key '$key' was found twice in the ".$this->locale." locale");
				}
				$flatten[$key] = $string;
				continue;
			}

			// recursive call
			$this->flattenString($key, $string, $flatten);
		}
	}
}
