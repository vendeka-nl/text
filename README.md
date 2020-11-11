# Text helpers

![Packagist Version](https://img.shields.io/packagist/v/vendeka-nl/text)

This package adds a few useful string helper methods to [`Illuminate\Support\Str`](https://laravel.com/docs/master/helpers#strings).

The package is developed and maintained by [Vendeka](https://www.vendeka.nl/), a company from the Netherlands.

# Installation

Install using composer:

```shell
composer require vendeka-nl/text
```

If you are using Laravel this package automatically adds its macros to `Illuminate\Support\Str`.


## Without Laravel

If you are not using Laravel, you need to boot the package manually. This is only required to be excuted once, so put it somewhere at the start of your app.

```php
use Vendeka\Text\Text;

Text::boot();
```


## Upgrading from v1.x

Version 2.x requires PHP 7.4 or higher.

Next, update the package version of `vendeka-nl/text` to "^2" in your composer.json and run `composer update vendeka-nl/text` to update the package.

After updating the package, change your calls using the table below. 
Replace all other references to `Vendeka\Text\Text` with `Illuminate\Support\Str`.

| v1 | v2 |
|----|----|
| `Vendeka\Text\Fluid` | `Illuminate\Support\Str::of()`
| `Vendeka\Text\Text::changeCase()` | `Illuminate\Support\Str::lower()`<br>`Illuminate\Support\Str::upper()`<br>`Illuminate\Support\Str::ucfirst()` <br>`Illuminate\Support\Str::title()` |
| `Vendeka\Text\Text::firstToUpperCase()` | `Illuminate\Support\Str::ucfirst()` |
| `Vendeka\Text\Text::startsWith()` | `Illuminate\Support\Str::startsWith()` |
| `Vendeka\Text\Text::toLowerCase()` | `Illuminate\Support\Str::lower()` |
| `Vendeka\Text\Text::toTitleCase()` | `Illuminate\Support\Str::title()` |
| `Vendeka\Text\Text::toUpperCase()` | `Illuminate\Support\Str::upper()` |


# Usage

This package adds the following methods to `Illuminate\Support\Str`:

- [`normalizeWhitespace`](#normalizeWhitespace)
- [`toWords`](#toWords)
- [`unprefix`](#unprefix)
- [`unsuffix`](#unsuffix)
- [`unwrap`](#unwrap)
- [`wrap`](#wrap)

All methods are chainable using `Illuminate\Support\Str::of()`.

Check the [Laravel documentation](https://laravel.com/docs/helpers#method-str-after) to see the available methods on `Illuminate\Support\Str`.

```php
use Illuminate\Support\Str;

Str::of('taco')->wrap('[', ']')->upper();   //=> '[TACO]'
Str::unwrap('/gift/', '/');                 //=> 'gift'
```

Most methods return an instance of the class. To convert to a string, either typecast to a `string` (`echo` will do this automatically) or call the `toString()` method.


## Available methods

### normalizeWhitespace

Removes duplicate whitespace characters and trims.

```php
Str::normalizeWhitespace(" White\r\n  space "); //=> 'White space'
```


### toWords

Convert a snake_case, kebab-case, camelCase or StudlyCase to a string of words. For example 'aSnake' becomes 'A snake'.

Please note that this method does not return a string, but an instance of `Vendeka\Text\Words`. The `Words` class extends `Illuminate\Support\Collection` and adds the following useful methods:

* `of()` returns a new instance of `Illuminate\Support\Stringable` to continue the method chain
* `toArray()` returns the words as a array of strings
* `toString()` returns the words as a string glued together with a single space between words (casting to a string is also supported)


```php
use Illuminate\Support\Str;

(string) Str::toWords('a-dog'); //=> 'a dog'
Str::of('aSnake')->toWords()->of()->lower(); //=> 'a snake'
(string) (new Words(['From', 'an', 'array'])); //=> 'From an array'
```


### unprefix

Remove a prefix if it is present.

```php
use Illuminate\Support\Str;

Str::unprefix('#yolo', '#') //=> 'yolo'
```


### unsuffix

Remove a suffix if it is present.

```php
Str::unsuffix('/var/www/', '/') //=> '/var/www'
```


### unwrap

Unwrap a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.

```php
Str::unwrap('<p>Gift</p>', '<p>', '</p>'); //=> 'Gift'
Str::unwrap('/present/', '/') //=> 'present'
```


### wrap

Wrap a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.

```php
Str::wrap('directory', '/'); //=> '/directory/'
Str::wrap('directory/', '/'); //=> '/directory/'
Str::wrap('Paragraph', '<p>', '</p>'); //=> '<p>Paragraph</p>'
Str::wrap('<p>Paragraph</p>', '<p>', '</p>'); //=> '<p>Paragraph</p>'
```

# Testing

```
composer run test
```
