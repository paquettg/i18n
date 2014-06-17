<?php
namespace I18n;

class I18n {

	/**
	 * The collection of locale data.
	 *
	 * @var LocaleCollection
	 */
	protected $collection;

	/**
	 * Sets up the collection attribute
	 */
	public function __construct()
	{
		$this->collection = new LocaleCollection;
	}

	/**
	 * Gets a property of the currently loaded locale using magic.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->collection->$key;
	}

	/**
	 * Gets a property of the currently loaded locale.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		return $this->collection->get($key);
	}

	/**
	 * Load a given local to be ready to use.
	 *
	 * @param string $locale
	 * @chainable
	 */
	public function load($locale)
	{
		$this->collection->load($locale);
		return $this;
	}

	/**
	 * Set an array of strings for the gicen locale.
	 *
	 * @param string $locale
	 * @chainable
	 */
	public function set(array $strings, $locale)
	{
		$this->collection->setArray($strings, $locale);
		return $this;
	}
}
