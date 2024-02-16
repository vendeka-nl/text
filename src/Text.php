<?php

namespace Vendeka\Text;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Vendeka\Text\Words;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Vendeka\Text\Traits\NormalizesWhitespace;

class Text
{
    use NormalizesWhitespace;

    private static bool $isBooted = false;

    /**
     * Boot the Text class to register the macros to `Illuminate\Support\Str`.
     * 
     * If you are not using Laravel you must call this method yourself.
     * This is only required to be executed once, so put it somewhere at the start of your app.
     *
     * @return void
     * 
     * @codeCoverageIgnore
     */
    public static function boot(): void
    {
        if (!self::$isBooted)
        {
            self::bootStrMacros();
            self::bootStringableMacros();

            self::$isBooted = true;
        }
    }

    /**
     * Enclose a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.
     * 
     * @param string $text
     * @param string|iterable $before
     * @param string|iterable $after
     * @return string
     */
    public static function enclose(string $text, string|iterable $before, string|iterable $after = null): string
    {
        $after = (array) ($after ?? $before);

        foreach ((array) $before as $i => $lead)
        {
            $text = Str::finish(Str::start($text, $lead), $after[$i]);
        }

        return $text;
    }

    /**
     * Create an exclamation from a string.
     * This method automatically uppercases the first letter and adds a question mark if none if there is no period or exclamation mark at the end of it.
     * 
     * @param string $text 
     * @return string
     */
    public static function exclamation(string $text): string
    {
        if (Str::endsWith($text, ['.', '!']))
        {
            return self::natural($text);
        }

        return Str::finish(self::natural($text), '!');
    }

    /**
     * Glue together multiple strings, without duplicate glue between items.
     * 
     * @param string $glue
     * @param mixed $strings
     * 
     * @return string
     */
    public static function glue(string $glue, ...$strings)
    {
        if (is_array($strings) && count($strings) === 1 && is_array(reset($strings)))
        {
            $strings = reset($strings);
        }

        $lastIndex = count($strings) - 1;
        $index = 0;

        return (new Collection($strings))->map(function (string $str) use ($glue, &$index, $lastIndex): string
        {
            if ($index > 0)
            {
                $str = Str::unprefix($str, $glue);
            }

            if ($index < $lastIndex)
            {
                $str = Str::unsuffix($str, $glue);
            }

            $index++;

            return $str;
        })->join($glue);
    }

    /**
     * Create a natural language version of a snake_case of kebab-case string.
     * 
     * @param string $text 
     * @return string
     */
    public static function natural(string $text): string
    {
        if (Str::contains($text, ' '))
        {
            $text = explode(' ', $text);
        }

        return Str::toWords($text)->of()->ucfirst();
    }

    /**
     * Removes duplicate whitespace characters and trim.
     * 
     * @param string $text 
     * @return string
     */
    public static function normalizeWhitespace(string $text): string
    {
        return self::purgeWhitespace($text);
    }

    /**
     * Convert a blank string to null.
     * 
     * @param string|null $text 
     * @return string|null
     */
    public static function nullIfBlank(?string $text): string|null
    {
        return blank($text) ? null : $text;
    }

    /**
     * Convert an empty string to null.
     * 
     * @param string $text 
     * @return string|null
     */
    public static function nullIfEmpty(?string $text): string|null
    {
        return $text == '' ? null : $text;
    }

    /**
     * Create a question from a string.
     * This method automatically uppercases the first letter and adds a question mark if none if there is no period, exclamation mark or question mark at the end of it.
     * 
     * @param string $text 
     * @param string $cap
     * @return string
     */
    public static function question(string $text): string
    {
        return self::sentence($text, '?');
    }

    /**
     * Create a sentence from a string.
     * This method automatically uppercases the first letter and adds a period if none if there is no end mark (period, exclamation mark or question mark).
     * 
     * @param string $text 
     * @param string $cap
     * @return string
     */
    public static function sentence(string $text, string $cap = '.'): string
    {
        $endMarks = ['.', '!', '?'];

        if (!Arr::has($endMarks, $cap))
        {
            $endMarks = [$cap, ...$endMarks];
        }

        if (Str::endsWith($text, $endMarks))
        {
            return self::natural($text);
        }

        return Str::finish(self::natural($text), $cap);
    }

    /**
     * Convert a string to paragraphs.
     *
     * @param string $text 
     * @return Paragraphs
     */
    public static function toParagraphs(string $text): Paragraphs
    {
        return new Paragraphs($text);
    }

    /**
     * Convert a string in snake_case, kebab-case, camelCase or StudlyCase format to words.
     *
     * @param mixed $text
     * @return Words
     */
    public static function toWords(mixed $text): Words
    {
        return new Words($text);
    }

    /**
     * Unclose (unwrap) a text with a prefix and a (different) suffix. If the suffix is `null` the prefix is also used as the suffix.
     * 
     * @param string $text 
     * @param string|iterable $before
     * @param string|iterable $after
     * @return string
     */
    public static function unclose(string $text, string|iterable $before, string|iterable $after = null): string
    {
        return self::unsuffix(self::unprefix($text, $before), $after ?? $before);
    }

    /**
     * Remove a prefix if it is present.
     *
     * @param string $text
     * @param string|iterable $lead
     * @return string|array
     */
    public static function unprefix(string $text, string|iterable $lead): string
    {
        foreach ((array) $lead as $l)
        {
            if (Str::startsWith($text, $l))
            {
                $text = Str::substr($text, Str::length($l));
            }
        }

        return $text;
    }

    /**
     * Remove a suffix if it is present.
     *
     * @param string $text
     * @param string|iterable $cap
     * @return string|array
     */
    public static function unsuffix(string $text, string|iterable $cap): string
    {
        foreach ((array) $cap as $c)
        {
            if (Str::endsWith($text, $c))
            {
                $text = Str::substr($text, 0, -Str::length($c));
            }
        }

        return $text;
    }

    /**
     * Unwrap a text with a prefix and a (different) suffix. If the suffix is `null` the prefix is also used as the suffix.
     *
     * @deprecated 3.1.1 No longer to be used in Laravel v10.42 or above, because `Illuminate\Support\Str::unwrap()` overrides this method. Use the `unclose()` method instead.
     * @see Vendeka\Text\Text::unclose()
     * 
     * @param string $text 
     * @param string|iterable $before
     * @param string|iterable $after
     * @return string
     * 
     * @codeCoverageIgnore
     */
    public static function unwrap(string $text, string|iterable $before, string|iterable $after = null): string
    {
        return self::unclose($text, $before, $after);
    }

    /**
     * Wrap a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.
     *
     * @deprecated 3.0.2 No longer to be used in Laravel v9.31 or above, because `Illuminate\Support\Str::wrap()` overrides this method. Use the `enclose()` method instead.
     * @see Vendeka\Text\Text::enclose()
     * 
     * @param string|iterable $before
     * @param string|iterable $after
     * @return string
     * 
     * @codeCoverageIgnore
     */
    public static function wrap(string $text, string|iterable $before, string|iterable $after = null): string
    {
        return self::enclose($text, $before, $after);
    }

    /**
     * Register the macros on `Illuminate\Support\Str`.
     * 
     * @return void
     * 
     * @codeCoverageIgnore
     */
    private static function bootStrMacros(): void
    {
        Str::macro('enclose', fn (string $text, $before, $after = null): string => Text::enclose($text, $before, $after));
        Str::macro('exclamation', fn (string $text): string => Text::exclamation($text));
        Str::macro('glue', fn (string $glue, ...$strings): string => Text::glue($glue, ...$strings));
        Str::macro('natural', fn (string $text): string => Text::natural($text));
        Str::macro('normalizeWhitespace', fn (string $text): string => Text::normalizeWhitespace($text));
        Str::macro('nullIfBlank', fn (?string $text): ?string => Text::nullIfBlank($text));
        Str::macro('nullIfEmpty', fn (?string $text): ?string => Text::nullIfEmpty($text));
        Str::macro('question', fn (string $text): string => Text::question($text));
        Str::macro('sentence', fn (string $text, string $cap = '.'): string => Text::sentence($text, $cap));
        Str::macro('toParagraphs', fn (string $text): Paragraphs => Text::toParagraphs($text));
        Str::macro('toWords', fn (mixed $text): Words => Text::toWords($text));
        Str::macro('unclose', fn (string $text, $before, $after = null): string => Text::unclose($text, $before, $after));
        Str::macro('unprefix', fn (string $text, $lead): string => Text::unprefix($text, $lead));
        Str::macro('unsuffix', fn (string $text, $cap): string => Text::unsuffix($text, $cap));
        Str::macro('unwrap', fn (string $text, $before, $after = null): string => Text::unwrap($text, $before, $after));
        Str::macro('wrap', fn (string $text, $before, $after = null): string => Text::wrap($text, $before, $after));
    }

    /**
     * Register the macros on `Illuminate\Support\Stringable`.
     * 
     * @return void
     * 
     * @codeCoverageIgnore
     */
    private static function bootStringableMacros(): void
    {
        Stringable::macro('enclose', fn ($before, $after = null): Stringable => new Stringable(Text::enclose($this->value, $before, $after)));
        Stringable::macro('exclamation', fn (): Stringable => new Stringable(Text::exclamation($this->value)));
        Stringable::macro('natural', fn (): Stringable => new Stringable(Text::natural($this->value)));
        Stringable::macro('normalizeWhitespace', fn (): Stringable => new Stringable(Text::normalizeWhitespace($this->value)));
        Stringable::macro('question', fn (): Stringable => new Stringable(Text::question($this->value)));
        Stringable::macro('sentence', fn (string $cap = '.'): Stringable => new Stringable(Text::sentence($this->value, $cap)));
        Stringable::macro('toParagraphs', fn (): Paragraphs => Text::toParagraphs($this->value));
        Stringable::macro('toWords', fn (): Words => Text::toWords($this->value));
        Stringable::macro('unclose', fn ($before, $after = null): Stringable => new Stringable(Text::unclose($this->value, $before, $after)));
        Stringable::macro('unprefix', fn ($lead): Stringable => new Stringable(Text::unprefix($this->value, $lead)));
        Stringable::macro('unsuffix', fn ($cap): Stringable => new Stringable(Text::unsuffix($this->value, $cap)));
        Stringable::macro('unwrap', fn ($before, $after = null): Stringable => new Stringable(Text::unwrap($this->value, $before, $after)));
        Stringable::macro('wrap', fn ($before, $after = null): Stringable => new Stringable(Text::wrap($this->value, $before, $after)));
    }
}
