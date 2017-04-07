<?php
namespace Vendeka\Text;

class Text
{
	const UPPERCASE_FIRST = 'first';
	const UPPERCASE_WORDS = 'words';
	const LOWERCASE = false;

	/**
	 * Convert a snake_case, camelCase or StudlyCase to string of words. For example 'aSnake' becomes 'A snake'.
	 * 
	 * @param string $input 
	 * @param string|boolean $uppercase Which uppercasing method should be used? If set to false output is lowercase.
	 * @return string String with words
	 */
	public static function toWords ($input, $uppercase = self::UPPERCASE_FIRST)
	{
		$output = preg_replace('/([A-Z])/', ' $1', $input);
		$output = str_replace(['_', '-'], ' ', $output);
		$output = preg_replace('/\s+/', ' ', $output);

		if ($uppercase === self::UPPERCASE_FIRST)
		{
			$output = ucfirst($output);
		}
		elseif ($uppercase === self::UPPERCASE_WORDS)
		{
			$output = ucwords($output);			
		}
		elseif ($uppercase === self::LOWERCASE)
		{
			$output = strtolower($output);
		}

		return $output;
	}
}