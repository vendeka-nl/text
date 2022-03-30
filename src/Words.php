<?php

namespace Vendeka\Text;

use Illuminate\Support\Collection;
use Vendeka\Text\Traits\IsStringable;
use Vendeka\Text\Traits\NormalizesWhitespace;

class Words extends Collection
{
    use IsStringable;
    use NormalizesWhitespace;

    /**
     * @param mixed $text 
     */
    public function __construct(mixed $text)
    {
        if (is_string($text))
        {
            $text = preg_replace('/((?:[A-Z]\.?)+)/', ' $1', $text);
            $text = str_replace(['_', '-'], ' ', $text);
            $text = self::purgeWhitespace($text);
            $text = explode(' ', $text);
        }

        parent::__construct($text);
    }

    /**
     * Returns the words as a string glued together with a single space (or custom string) between words.
     * 
     * @param string $glue
     * @return string
     */
    public function toString(string $glue = ' '): string
    {
        return $this->join($glue);
    }

    /**
     * Return the string representation of the collection of words.
     * 
     * @return string
     * 
     * @see Vendeka\Text\Words::toString() To use a custom glue string.
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
