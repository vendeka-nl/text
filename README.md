# Text helpers

[![Packagist Version](https://img.shields.io/packagist/v/vendeka-nl/text)](https://packagist.org/packages/vendeka-nl/text)

This package adds a handful of useful string helper methods to [`Illuminate\Support\Str`](https://laravel.com/docs/master/helpers#strings).

The package is developed and maintained by [Vendeka](https://www.vendeka.nl/), a company from the Netherlands.


# Installation

Install using composer:

```shell
composer require vendeka-nl/text
```

## With Laravel

If you are using Laravel this package automatically adds its macros to `Illuminate\Support\Str`.


## Without Laravel

If you are not using Laravel, you need to boot the package manually. This is only required to be executed once, so put it somewhere at the start of your app.

```php
use Vendeka\Text\Text;

Text::boot();
```


# Usage

This package adds a number of helpful methods to `Illuminate\Support\Str`. Check the [Laravel documentation](https://laravel.com/docs/11.x/helpers#strings-method-list) to see the available methods on `Illuminate\Support\Str`.

```php
use Illuminate\Support\Str;

Str::of('taco')->enclose('[', ']')->upper(); //=> '[TACO]'
Str::unclose('/gift/', '/'); //=> 'gift'
```


## Available methods

Most methods are chainable using the `Illuminate\Support\Stringable` class, either by using [`Illuminate\Support\Str::of()`](https://laravel.com/docs/11.x/helpers#fluent-strings) or Laravel's [`str()`](https://laravel.com/docs/11.x/helpers#method-str) helper function. To convert to a string, either typecast to a `string` (`echo` will do this automatically) or call the `toString()` method. Methods marked with an asterisk (*) are not chainable

- [`enclose`](#enclose)
- [`exclamation`](#exclamation)
- [`glue`](#glue)*
- [`natural`](#natural)
- ~~[`normalizeWhitespace`](#normalizeWhitespace)~~
- [`nullIfBlank`](#nullIfBlank)*
- [`nullIfEmpty`](#nullIfEmpty)*
- [`question`](#question)
- [`sentence`](#sentence)
- [`toParagraphs`](#toParagraphs)
- [`toWords`](#toWords)
- [`unclose`](#unclose)
- [`unprefix`](#unprefix)
- [`unsuffix`](#unsuffix)
- ~~[`unwrap`](#unwrap)~~
- ~~[`wrap`](#wrap)~~


### enclose

*Since v3.0.2*

Enclose a text with a prefix and a (different) suffix. If the suffix is `null` the prefix is also used as the suffix.

```php
Str::enclose('directory', '/'); //=> '/directory/'
Str::enclose('directory/', '/'); //=> '/directory/'
Str::enclose('Paragraph', '<p>', '</p>'); //=> '<p>Paragraph</p>'
Str::enclose('<p>Paragraph</p>', '<p>', '</p>'); //=> '<p>Paragraph</p>'
```

### exclamation

*Since v3.0.0*

Create an exclamation from a string.
This method automatically uppercases the first letter and adds a question mark if none if there is no period or exclamation mark at the end of it.

```php
Str::exclamation('yelling'); //=> 'Yelling!'
Str::exclamation('Why are you yelling?'); //=> 'Why are you yelling?!'
``` 

### glue

*Since v3.0.0*

Glue together multiple strings, without duplicate glue between items.

```php
Str::glue('/', 'https://example.com/', '/dashboard'); //=> 'https://example.com/dashboard'
Str::glue('/', '/var', '/www/', []); //=> '/var/www/'
```


### natural

*Since v3.0.0*

Create a natural language version of a snake_case of kebab-case string.

```php
Str::natural('my-first-blog'); //=> 'My first blog'
Str::natural('i_love_kebab'); // => 'I love kebab'
```


### ~~normalizeWhitespace~~

*Since v2.0.0*
\
**Deprecated since v3.3.1**:  No longer to be used in Laravel v10.42 or above, because `Illuminate\Support\Str::unwrap()` overrides this method. Use the `Str::squish()` method instead.

Removes duplicate whitespace characters and trims.

```php
Str::normalizeWhitespace(" White\r\n  space "); //=> 'White space'
```


### nullIfBlank

*Since v3.0.0*

Convert a blank string to null.

```php
Str::nullIfBlank(' '); //=> null
```


### nullIfEmpty

*Since v3.0.0*

Convert an empty string to null.

```php
Str::nullIfEmpty(''); //=> null
```


### question

*Since v3.0.0*

Create a question from a string. This method automatically uppercases the first letter and adds a question mark if none if there is no period, exclamation mark or question mark at the end of it.

```php
Str::question('Questions'); //=> 'Questions?'
```

### sentence

*Since v3.0.0*

Create a question from a string. This method automatically uppercases the first letter and adds a question mark if none if there is no period, exclamation mark or question mark at the end of it.

```php
Str::sentence('this is a sentence'); //=> 'This is a sentence.'
```

### toParagraphs

*Since v3.0.0*

Split a text into paragraphs.

Please note that this method does not return a string, but an instance of [`Vendeka\Text\Paragraphs`](#paragraphs).

```php
Str::toParagraphs("Paragraph 1\n\nParagraph 2"); // => instance of Vendeka\Text\Paragraphs
```


### toWords

*Since v1.0.0*

Convert a snake_case, kebab-case, camelCase or StudlyCase to a string of words. For example 'aSnake' becomes 'A snake'.

Please note that this method does not return a string, but an instance of [`Vendeka\Text\Words`](#words).

```php
use Vendeka\Text\Words;

(string) Str::toWords('a-dog'); //=> 'a dog'
Str::of('aSnake')->toWords()->of()->lower(); //=> 'a snake'
(string) (new Words(['From', 'an', 'array'])); //=> 'From an array'
```


## unclose

*Since v3.1.1*

Unclose (unwrap) a text with a prefix and a (different) suffix. If the suffix is `null` the prefix is also used as the suffix.

```php
Str::unclose('<p>Gift</p>', '<p>', '</p>'); //=> 'Gift'
Str::unclose('/present/', '/') //=> 'present'
```


### unprefix

*Since v1.0.0*

Remove a prefix if it is present.

```php
Str::unprefix('#yolo', '#') //=> 'yolo'
```


### unsuffix

*Since v1.0.0*

Remove a suffix if it is present.

```php
Str::unsuffix('/var/www/', '/') //=> '/var/www'
```


### ~~unwrap~~

*Since v1.0.0*
\
**Deprecated since v3.1.1**:  No longer to be used in Laravel v10.42 or above, because `Illuminate\Support\Str::unwrap()` overrides this method. Use the `unclose()` method instead.


### ~~wrap~~

*Since v1.0.0*
\
**Deprecated since v3.0.2**: No longer to be used in Laravel v9.31 or above, because `Illuminate\Support\Str::wrap()` overrides this method. Use the `enclose()` method instead.


## Available classes

### Paragraphs

*Since v3.0.0*

The class `Vendeka\Text\Paragraphs` extends `Illuminate\Support\Collection`. The class can be initialized via its constructor or the `Illuminate\Support\Str::toParagraphs()` method.

```php
$paragraphs = new Paragraphs("First paragraph\n\nSecond paragraph...");
$paragraphs = new Paragraphs(['First paragraph', 'Second paragraph...']);
$paragraphs = Str::toParagraphs("First paragraph\n\nSecond paragraph...");
```

It adds the following useful methods:

#### br

`br(string $br)` sets the `<br>` HTML tag used in `toHtml()`. The default is set to `<br>`.

#### eol

`eol(string $char)` sets the EOL character(s), used in both `toHtml()` and `toString()`.

#### of

`of()` returns a new instance of `Illuminate\Support\Stringable` to continue the method chain.

#### toString

`toString()` returns the paragraphs as a string

#### toHtml

`toHtml()` returns the paragraphs as a HTML string wrapped in `<p>` tags. Single new lines are replaced with `<br>`.


### Words 

*Since v2.0.0*

The class `Vendeka\Text\Words` extends `Illuminate\Support\Collection`. The class can be initialized via its constructor or the `Illuminate\Support\Str::toWords()` method.


```php
$words = new Words("First Second");
$words = new Words(['First', 'Second']);
$words = Str::toWords("First Second");
```

It adds the following useful methods:


#### of

`of()` returns a new instance of `Illuminate\Support\Stringable` to continue the method chain.


#### toString

`toString()` returns the words as a string glued together with a single space (or custom string) between words (casting to a string is also supported).

```php
Str::toWords('my-slug')->toString(); // => 'my slug'
Str::toWords('my-folder')->toString('/'); // => 'my/slug'
(string) Str::toWords("It's a kind of magic!"); // => "It's a kind of magic!"
```


# Upgrading

## Upgrading from v1

Version 2.0.x requires PHP 7.4 or higher. Version 3.0.x requires PHP 8.0 or higher. Version 3.3 requires PHP 8.2 or higher.

Next, update the package version of `vendeka-nl/text` to `"^3"` in your composer.json and run `composer update vendeka-nl/text` to update the package.

After updating the package, change your calls using the table below. 
Replace all other references to `Vendeka\Text\Text` with `Illuminate\Support\Str`.

| v1 | v2+ |
|----|----|
| `Vendeka\Text\Fluid` | `Illuminate\Support\Str::of()`
| `Vendeka\Text\Text::changeCase()` | `Illuminate\Support\Str::lower()`<br>`Illuminate\Support\Str::upper()`<br>`Illuminate\Support\Str::ucfirst()` <br>`Illuminate\Support\Str::title()` |
| `Vendeka\Text\Text::firstToUpperCase()` | `Illuminate\Support\Str::ucfirst()` |
| `Vendeka\Text\Text::startsWith()` | `Illuminate\Support\Str::startsWith()` |
| `Vendeka\Text\Text::toLowerCase()` | `Illuminate\Support\Str::lower()` |
| `Vendeka\Text\Text::toTitleCase()` | `Illuminate\Support\Str::title()` |
| `Vendeka\Text\Text::toUpperCase()` | `Illuminate\Support\Str::upper()` |

## Upgrading from v3.0

### Deprecated `wrap` method

Version 3.0.2 deprecated the `wrap` method because a method with the same name was added in `illuminate/support` v9.31 and overrides this packages' version.

| v3.0 | v3.1+ |
|----|----|
|`Illuminate\Support\Str::wrap()`|`Illuminate\Support\Str::enclose()`|


### Deprecated `unwrap` method

Version 3.1.1 deprecated the `unwrap` method because a method with the same name was added in `illuminate/support` v10.43 and overrides this packages' version.

| v3.0 | v3.1.1+ |
|----|----|
|`Illuminate\Support\Str::unwrap()`|`Illuminate\Support\Str::unclose()`|


## Upgrading from v3.2

### Deprecated `normalizeWhitespace` method

Version 3.1.1 deprecated the `normalizeWhitespace` method, in favor of `squish` method that comes with `illuminate/support`.

| v3.2 | v3.3.1+ |
|----|----|
|`Illuminate\Support\Str::normalizeWhitespace()`|`Illuminate\Support\Str::squish()`|


# Testing

```
composer run test
```
