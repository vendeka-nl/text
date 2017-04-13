# Text helpers

This package provides a couple useful string helper methods.

The package is developed by [Vendeka](https://www.vendeka.nl/), a company from the Netherlands.

# Installation

Install using composer:

```
composer require vendeka-nl/text
```

# Usage

```php
// Fully qualified name
Vendeka\Text\Text::toWords($x);

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

## Usage with Laravel

Register an alias for `Text` in config/app.php:
```php
'Text' => Vendeka\Text\Text::class,
```

## Methods

### `endsWith(string $haystack, string|array $needles): boolean`

Determine if a given string ends with a given substring.

### `finish(string $value, string $cap): string`

Cap a string with a single instance of a given value.

### `start(string $value, string $lead): string`

Lead a string with a single instance of a given value.

### `startsWith(string $haystack, string|array $needles): boolean`

Determine if a given string starts with a given substring.

### `toWords(string $input, mixed $uppercase = Text::UPPERCASE_FIRST): string`

Convert a snake_case, kebab-case, camelCase or StudlyCase to string of words. For example 'aSnake' becomes 'A snake'.

Possible values for the second parameter:
* `Text::UPPERCASE_FIRST` capitalizes the first character of the string.
* `Text::UPPERCASE_WORDS` capitalizes the first character of each word.
* `true`  converts the whole string to uppercase.
* `false` converts the whole string to lowercase.
* `null` is used to leave the capitalization as-is.

```php
Text::toWords('a dog'); //=> 'A dog'
Text::toWords('a cat', Text::UPPERCASE_FIRST); //=> 'A cat'
Text::toWords('a_snake', Text::UPPERCASE_WORDS); //=> 'A Snake'
Text::toWords('a-lamb', true); //=> 'A LAMB'
Text::toWords('aCamel', false); //=> 'a camel'
Text::toWords('aCow', null); //=> 'a Cow'
```

# Testing

```
composer run test
```