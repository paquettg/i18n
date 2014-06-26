i18n
====

I18n is a php framework agnostic package to handle I18n functionality (such an original name). The goal is to have the ability to implement multiple languages into a website with out needing to depend on a framework.

Install
-------

This package can be found on [packagist](https://packagist.org/packages/paquettg/i18n) and is best loaded using [composer](http://getcomposer.org/). We support php 5.4, 5.5, and hhvm.

Simple Example
--------------

You can find many examples of how to use the package and any of its parts (which you will most likely never touch) in the tests directory. The tests are done using PHPUnit and are very small, a few lines each, and are a great place to start. Given that, I'll still be showing examples of how the package is intended to work. The following example is a very simplistic usage of the package, good place to start.

```php
use I18n\I18n;

$i18n = new I18n;
$i18n->set([
	'foo' => 'bar',
	'baz' => [
		'rawr' => 'meow?',
	],
], 'en_CA');
$i18n->load('en_CA');

echo $i18n->get('baz.rawr'); // will output 'meow?'
```

You may also set a directory to look at to load the given locales.

```php
use I18n\I18n;

$i18n = new I18n;
$i18n->load($pathToLocaleDirectory);
$i18n->load($locale);
```

Using static facade
-------------------

We also support a static facade so you don't need to carry around the I18n object to every part of your application.

```php
use I18n\Facade\StaticI18n;

StaticI18n::mount();
I18n::set([
	'foo' => 'bar',
	'baz' => [
		'rawr' => 'meow?',
	],
], 'en_CA');
I18n::load('en_CA');
echo I18n::get('baz.rawr');
```
