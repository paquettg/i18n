<?php
namespace I18n;

use I18n\Exception\UnableToSetException;

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
	 * Set a source for the gicen locale.
	 *
	 * @param mixed $strings
	 * @param mixed $locale
	 * @chainable
	 */
	public function set($strings, $locale = null)
	{
		if (is_array($strings))
		{
			return $this->setArray($strings, $locale);
		}
		if (is_dir($strings))
		{
			return $this->setDirectory($strings);
		}

		throw new UnableToSetException("We could not figure out how to set '$strings' ");
	}

	/**
	 * Sets an array as the given locale.
	 *
	 * @param array $strings
	 * @param string $locale
	 * @chainable
	 */
	public function setArray(array $strings, $locale)
	{
		$this->collection->setArray($strings, $locale);
		return $this;
	}

	/**
	 * Loads a bunch of files from a given directory as locales into the collection.
	 *
	 * @param string $directory
	 * @chainable
	 */
	public function setDirectory($directory)
	{
		// trim trailling slash
		$directory = rtrim($directory,"/");
		$dir       = opendir($directory);
		if ($dir === false)
		{
			throw new UnableToSetException("Could not set '$directory'. It is not a directory!");
		}


		while (($file = readdir($dir)) !== false)
		{
			$path      = $directory.'/'.$file;
			$pathInfo  = pathinfo($path);
			$extension = strtolower($pathInfo['extension']);
			$filename  = $pathInfo['filename'];
			if ($extension == 'php')
			{
				$strings = include $path;
				if (is_array($strings))
				{
					$this->collection->setArray($strings, $filename);
				}
			}
		}
		return $this;
	}
}
