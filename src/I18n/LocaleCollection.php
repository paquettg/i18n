<?php
namespace I18n;

use I18n\Exception\LocaleNotFoundException;
use I18n\Exception\NoLocaleLoadedException;

class LocaleCollection {

	/**
	 * The current active locale, if any.
	 *
	 * @var string
	 */
	protected $activeLocale = null;

	/**
	 * The current locales array.
	 *
	 * @var array
	 */
	protected $locales = [];

	/**
	 * The directory set to be scanned.
	 *
	 * @var string
	 */
	protected $directory;

	/**
	 * Gets the value set at $key in the current locale using magic.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * Gets the value set at the $key in the current locale.
	 *
	 * @param string $key
	 * @return mixed
	 * @throws NoLocaleLoadedException;
	 */
	public function get($key)
	{
		if (is_null($this->activeLocale))
		{
			throw new NoLocaleLoadedException('No locale was loaded for this collection.');
		}

		$locale = $this->activeLocale;
		return $this->locales[$locale]->get($key);
	}

	/**
	 * Loads a gicen local to be ready to use.
	 *
	 * @param string $locale
	 * @chainable
	 */
	public function load($locale)
	{
		if ( ! isset($this->locales[$locale]))
		{
			throw new LocaleNotFoundException("The locale '$locale' was not found in this collection.");
		}

		$this->locales[$locale]->flatten();
		$this->activeLocale = $locale;
		return $this;
	}

	public function setDirectory($dir)
	{
	}

	/**
	 * Sets an array directly into the collection as a given locale.
	 *
	 * @param array $strings
	 * @param string $locale
	 * @chainable
	 */
	public function setArray(array $strings, $locale)
	{
		$localeObject = new Locale;
		$localeObject->setLocale($locale)
		             ->setStrings($strings);
		$this->locales[$locale] = $localeObject;
		return $this;
	}
}
