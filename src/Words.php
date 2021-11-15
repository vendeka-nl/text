<?php

namespace Vendeka\Text;

use Illuminate\Support\Stringable;
use Illuminate\Support\Collection;
use Vendeka\Text\Traits\NormalizesWhitespace;

class Words extends Collection
{
    use NormalizesWhitespace;

    public function __construct($text)
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

    public function of(): Stringable
    {
        return new Stringable($this->toString());
    }

    public function toString(string $glue = ' '): string
    {
        return $this->join($glue);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}