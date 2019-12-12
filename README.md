# Text helpers

This package provides a couple useful string helper methods. It is especially useful for handling prefixes in paths and converting between different string naming conventions.

The package is developed and maintained by [Vendeka](https://www.vendeka.nl/), a company from the Netherlands.

# Installation

Install using composer:

```
composer require vendeka-nl/text
```

# Usage

```php
// Fully qualified name
Vendeka\Text\Text::toWords($x);
```

```php
// Using alias (use)
namespace YourNamespace;

use Vendeka\Text\Text;

class YourClass
{
  public function yourMethod ($x)
  {
    return Text::toWords($x);
  }
}
```

## Fluent API
The package also provides a class for chainable calls.

```php
$fluid = new Fluid('My text.');
$fluid->unprefix('My')->firstToUpperCase();
echo $fluid; // => 'Text.'
```

## Usage with Laravel

Register an alias for `Text` in `config/app.php`:
```php
'Text' => Vendeka\Text\Text::class,
```

## Methods

### `changeCase (string $text, string|bool $case): string`

Change a string's case to lower case, upper case, title case or just the first character to uppercase.

Possible values for the second parameter:
* `Text::UPPERCASE_FIRST` capitalizes the first character of the string.
* `Text::UPPERCASE_WORDS` capitalizes the first character of each word.
* `Text::TITLE_CASE` capitalizes the first character of each word and convert all other characters to lowercase.
* `true`  converts the whole string to uppercase.
* `false` converts the whole string to lowercase.
* `null` is used to leave the capitalization as-is.

```php
Text::changeCase('a dog'); //=> 'A dog'
Text::changeCase('a cat', Text::UPPERCASE_FIRST); //=> 'A cat'
Text::changeCase('a sNaKe', Text::UPPERCASE_WORDS); //=> 'A SNaKe'
Text::changeCase('ThE wOLf', Text::TITLE_CASE); //=> 'The Wolf'
Text::changeCase('a lamb', true); //=> 'A LAMB'
Text::changeCase('A Camel', false); //=> 'a camel'
Text::changeCase('a Cow', null); //=> 'a Cow'
```

### `endsWith (string $text, string|array $needles): bool`

Determine if a given string ends with a given substring.

```php
Text::endsWith('alpha', 'a') //=> true
```

### `finish (string $text, string $cap): string`

Cap a string with a single instance of a given value.

```php
Text::finish('path', '/') //=> 'path/'
Text::finish('path/', '/') //=> 'path/'
```

### `firstToUpperCase (string $text): string`

Make a string's first character uppercase.

```php
Text::firstToUpperCase ('john') //=> 'John'
```

### `start (string $text, string $lead): string`

Lead a string with a single instance of a given value.

```php
Text::start('path', '/') //=> '/path'
Text::start('/path', '/') //=> '/path'
```

### `startsWith (string $text, string|array $needles): bool`

Determine if a given string starts with a given substring.

```php
Text::startsWith('alpha', 'a') //=> true
```

### `toLowerCase (string $text): string`

Make a string lowercase.

```php
Text::toLowerCase('Quiet') //=> 'quiet'
```

### `toTitleCase (string $text, bool $lowercase_rest = true): string`

Uppercase the first character of each word in a string.

```php
Text::toTitleCase('My BOOK') //=> 'My Book'
Text::toTitleCase('My BOOK', false) //=> 'My BOOK'
```

### `toUpperCase (string $text): string`
Make a string uppercase.

```php
Text::toUpperCase('yelling!') //=> 'YELLING!'
```

### `toWords (string $text, string|bool $uppercase = Text::UPPERCASE_FIRST, bool $lowercase_rest = true): string`

Convert a snake_case, kebab-case, camelCase or StudlyCase to string of words. For example 'aSnake' becomes 'A snake'. 

See the `changeCase()` method for an explanation of the second parameter. Use `null` for the is used to leave the capitalization as-is. 

```php
Text::toWords('a-dog'); //=> 'A dog'
```

### `unprefix (string $text, string $lead): string`

Remove a prefix if it is present.

```php
Text::unprefix('#yolo', '#') //=> 'yolo'
```

### `unsuffix (string $text, string $cap): string`

Remove a suffix if it is present.

```php
Text::unsuffix('/var/www/', '/') //=> '/var/www'
```

### `unwrap (string $text, string $before, string $after = null): string`

Unwrap a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.

```php
Text::unwrap('<p>Gift</p>', '<p>', '</p>'); //=> 'Gift'
Text::unwrap('/present/', '/') //=> 'present'
```

### `wrap (string $text, string $before, string $after = null): string`

Wrap a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.

```php
Text::wrap('directory', '/'); //=> '/directory/'
Text::wrap('directory/', '/'); //=> '/directory/'
Text::wrap('Paragraph', '<p>', '</p>'); //=> '<p>Paragraph</p>'
Text::wrap('<p>Paragraph</p>', '<p>', '</p>'); //=> '<p>Paragraph</p>'
```

# Testing

```
composer run test
```