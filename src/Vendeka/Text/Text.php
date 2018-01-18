<?php
namespace Vendeka\Text;

class Text
{
	const UPPERCASE_FIRST = 'first';
	const UPPERCASE_WORDS = 'words';

	/**
	 * Convert a snake_case, kebab-case, camelCase or StudlyCase to string of words. For example 'aSnake' becomes 'A snake'.
	 * 
	 * @param string $input 
	 * @param string|boolean $uppercase Which uppercasing method should be used? If set to false output is lowercase.
	 * @return string String with words
	 */
	public static function toWords ($input, $uppercase = self::UPPERCASE_FIRST)
	{
		$output = preg_replace('/([A-Z])/', ' $1', $input);
		$output = str_replace(array('_', '-'), ' ', $output);
		$output = preg_replace('/\s+/', ' ', $output);
		$output = ltrim($output);

		if ($uppercase === self::UPPERCASE_FIRST)
		{
			$output = ucfirst($output);
		}
		elseif ($uppercase === self::UPPERCASE_WORDS)
		{
			$output = ucwords($output);			
		}
		elseif ($uppercase === true)
		{
			$output = strtoupper($output);
		}
		elseif ($uppercase === false)
		{
			$output = strtolower($output);
		}

		return $output;
	}

    /**
     * Lead a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $lead
     * @return string
     */
    public static function start($value, $lead)
	{
		if (!self::startsWith($value, $lead)) 
		{
			return $lead . $value;
		}
		
		return $value;
	}

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $cap
     * @return string
     */
    public static function finish($value, $cap)
	{
		if (!self::endsWith($value, $cap)) 
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
	public static function wrap($text, $before, $after = null)
	{
		return self::finish(self::start($text, $before), empty($after) ? $before : $after);
	}

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle)
		{
            if (substr($haystack, -strlen($needle)) === (string) $needle)
			{
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) 
		{
            if ($needle != '' && substr($haystack, 0, strlen($needle)) === (string) $needle)
			{
                return true;
            }
        }

        return false;
    }
}