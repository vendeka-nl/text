<?php
namespace Vendeka\Text;

use Vendeka\Text\Words;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Vendeka\Text\Traits\NormalizesWhitespace;

class Text
{
    use NormalizesWhitespace;

    /** @var bool */
    private static $isBooted = false;

    public static function boot(): void
    {
        if (!self::$isBooted) {
            self::bootStrMacros();
            self::bootStringableMacros();

            self::$isBooted = true;
        }
    }

    /**
     * Convert a string in snake_case, kebab-case, camelCase or StudlyCase format to words.
     *
     * @return Words
     */
    public static function toWords(string $text): Words
    {
        return new Words($text);
    }

    /**
     * Wrap a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.
     *
     * @param string $before
     * @param string $after
     * @return string
     */
    public static function wrap(string $text, string $before, string $after = null): string
    {
        return Str::finish(Str::start($text, $before), $after ?? $before);
    }

    /**
     * Unwrap a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.
     *
     * @param string $before
     * @param string $after
     * @return string
     */
    public static function unwrap(string $text, string $before, string $after = null): string
    {
        return self::unsuffix(self::unprefix($text, $before), $after ?? $before);
    }

    /**
     * Remove a prefix if it is present.
     *
     * @param string $lead
     * @return string
     */
    public static function unprefix(string $text, string $lead): string
    {
        if (Str::startsWith($text, $lead)) {
            $text = mb_substr($text, mb_strlen($lead));
        }

        return $text;
    }

    /**
     * Remove a suffix if it is present.
     *
     * @param string $cap
     * @return string
     */
    public static function unsuffix(string $text, string $cap): string
    {
        if (Str::endsWith($text, $cap)) {
            $text = mb_substr($text, 0, -mb_strlen($cap));
        }

        return $text;
    }

    /**
     * Removes duplicate whitespace characters and trim.
     * 
     * @return string
     */
    public static function normalizeWhitespace(string $text): string
    {
        return self::purgeWhitespace($text);
    }

    private static function bootStrMacros(): void
    {
        Str::macro('normalizeWhitespace', fn (string $text): string =>  Text::normalizeWhitespace($text));
        Str::macro('toWords', fn (string $text): Words => Text::toWords($text));
        Str::macro('unprefix', fn (string $text, string $lead): string => Text::unprefix($text, $lead));
        Str::macro('unsuffix', fn (string $text, string $cap): string => Text::unsuffix($text, $cap));
        Str::macro('unwrap', fn (string $text, string $before, string $after = null): string => Text::unwrap($text, $before, $after));
        Str::macro('wrap', fn (string $text, string $before, string $after = null): string => Text::wrap($text, $before, $after));
    }

    private static function bootStringableMacros(): void
    {
        Stringable::macro('normalizeWhitespace', function (): Stringable {
            return new Stringable(Text::normalizeWhitespace($this->value));
        });

        Stringable::macro('toWords', function (): Words {
            return Text::toWords($this->value);
        });

        Stringable::macro('unprefix', function (string $lead): Stringable {
            return new Stringable(Text::unprefix($this->value, $lead));
        });

        Stringable::macro('unsuffix', function (string $cap): Stringable {
            return new Stringable(Text::unsuffix($this->value, $cap));
        });

        Stringable::macro('unwrap', function (string $before, string $after = null): Stringable {
            return new Stringable(Text::unwrap($this->value, $before, $after));
        });

        Stringable::macro('wrap', function (string $before, string $after = null): Stringable {
            return new Stringable(Text::wrap($this->value, $before, $after));
        });
    }
}
