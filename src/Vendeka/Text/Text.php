<?php
namespace Vendeka\Text;

class Text
{
	const UPPERCASE_FIRST = 'first';
	const UPPERCASE_WORDS = 'words';

	/**
	 * Convert a snake_case, kebab-case, camelCase or StudlyCase to string of words. For example 'aSnake' becomes 'A snake'.
	 *
	 * @param string $text
	 * @param string|bool $uppercase See the `changeCase()` method for an explanation of this parameter. Use `null` for the is used to leave the capitalization as-is.\
	 * @param bool $lowercase_rest Change the case of the remaining characters to lowercase?
	 * @return string String with words
	 */
	public static function toWords (string $text, $uppercase = self::UPPERCASE_FIRST, bool $lowercase_rest = true): string
	{
		$output = preg_replace('/([A-Z])/', ' $1', $text);
		$output = str_replace(array('_', '-'), ' ', $output);
		$output = preg_replace('/\s+/', ' ', $output);
		$output = ltrim($output);

		return self::changeCase($output, $uppercase, $lowercase_rest);
	}

    /**
     * Start a string with a single instance of a given value.
     *
     * @param string $text
     * @param string $lead
     * @return string
     */
    public static function start(string $text, string $lead): string
	{
		if (!self::startsWith($text, $lead))
		{
			return $lead . $text;
		}

		return $text;
	}

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param string $text
     * @param string $cap
     * @return string
     */
    public static function finish(string $text, string $cap): string
	{
		if (!self::endsWith($text, $cap))
		{
			$value .= $cap;
		}

		return $value;
	}

	/**
	 * Wrap a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.
	 *
	 * @param string $text
	 * @param string $before
	 * @param string $after
	 * @return string
	 */
	public static function wrap(string $text, string $before, string $after = null): string
	{
		return self::finish(self::start($text, $before), empty($after) ? $before : $after);
	}

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string $text
     * @param string|array $needles
     * @return bool
     */
    public static function endsWith(string $text, $needles): bool
    {
        foreach ((array) $needles as $needle)
		{
            if (substr($text, -strlen($needle)) === (string) $needle)
			{
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string $text
     * @param string|array $needles
     * @return bool
     */
    public static function startsWith(string $text, $needles): bool
    {
        foreach ((array) $needles as $needle)
		{
            if ($needle != '' && substr($text, 0, strlen($needle)) === (string) $needle)
			{
                return true;
            }
        }

        return false;
	}

	/**
	 * Unwrap a text with a prefix and a (different) suffix. If the suffix is empty the prefix is also used as the suffix.
	 *
	 * @param string $text
	 * @param string $before
	 * @param string $after
	 * @return string
	 */
	public static function unwrap(string $text, string $before, string $after = null): string
	{
		return self::unsuffix(self::unprefix($text, $before), empty($after) ? $before : $after);
	}

	/**
	 * Remove a prefix if it is present.
	 *
     * @param string $text
     * @param string $lead
     * @return string
     */
	public static function unprefix (string $text, string $lead): string
	{
		if (self::startsWith($text, $lead))
		{
			return substr($text, strlen($lead));
		}

		return $text;
	}

	/**
	 * Remove a suffix if it is present.
	 *
     * @param string $text
     * @param string $cap
     * @return string
     */
	public static function unsuffix (string $text, string $cap): string
	{
		if (self::endsWith($text, $cap))
		{
			return substr($text, 0, -strlen($cap));
		}

		return $text;
	}

	/**
	 * Make a string lowercase.
	 *
     * @param string $text
     * @return string
	 */
	public static function toLowerCase (string $text): string
	{
		return strtolower($text);
	}

	/**
	 * Make a string uppercase.
	 *
     * @param string $text
     * @return string
	 */
	public static function toUpperCase (string $text): string
	{
		return strtoupper($text);
	}

	/**
	 * Make a string's first character uppercase.
	 *
     * @param string $text
	 * @param bool $lowercase_rest Change the case of the remaining characters to lowercase?
     * @return string
	 */
	public static function firstToUpperCase (string $text, bool $lowercase_rest = true): string
	{
		return ucfirst($lowercase_rest ? strtolower($text) : $text);
	}

	/**
	 * Uppercase the first character of each word in a string.
	 *
     * @param string $text
	 * @param bool $lowercase_rest Change the case of the remaining characters to lowercase?
     * @return string
	 */
	public static function toTitleCase (string $text, bool $lowercase_rest = true): string
	{
		return ucwords($lowercase_rest ? strtolower($text) : $text);
	}

	/**
	 * Change a string's case to lower case, upper case, title case or just the first character to uppercase.
	 *
	 * @param string $text
	 * @param string|bool $case Use either on the constants of this class or a boolean (`true` for upper case and `false` for lowercase)
	 * @param bool $lowercase_rest Change the case of the remaining characters to lowercase?
	 * @return string String with words
	 */
	public static function changeCase (string $text, $case, bool $lowercase_rest = true): string
	{
		if ($case === self::UPPERCASE_FIRST)
		{
			return self::firstToUpperCase($text, $lowercase_rest);
		}
		elseif ($case === self::UPPERCASE_WORDS)
		{
			return self::toTitleCase($text, $lowercase_rest);
		}
		elseif ($case === true)
		{
			return self::toUpperCase($text);
		}
		elseif ($case === false)
		{
			return self::toLowerCase($text);
		}

		return $text;
	}
}