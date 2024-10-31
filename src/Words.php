<?php

namespace Vendeka\Text;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Stringable;
use Vendeka\Text\Traits\IsStringable;

class Words extends Collection
{
    use IsStringable;

    /**
     * @param mixed $text 
     */
    public function __construct(mixed $text)
    {
        if ($this->getStringable($text))
        {
            $text = preg_replace('/((?:[A-Z]\.?)+)/', ' $1', $text);
            $text = str_replace(['_', '-'], ' ', $text);
            $text = Str::squish($text);
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

    /**
     * Convert a stringable to a string and check if it is a stringable.
     * A stringable is a string, an instance of `\Stringable` or an object that implements a `toString()` method.
     * 
     * @param mixed $subject
     * 
     * @return bool
     */
    private function getStringable(mixed &$subject): bool
    {
        if (is_string($subject) || $subject instanceof Stringable)
        {
            return true;
        }

        if (is_object($subject) && method_exists($subject, 'toString'))
        {
            $subject = $subject->toString();

            return true;
        }

        return false;
    }
}
