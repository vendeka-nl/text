<?php

namespace Vendeka\Text;

use Illuminate\Support\Stringable;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;
use Vendeka\Text\Traits\IsStringable;

class Paragraphs extends Collection implements Htmlable
{
    use IsStringable;

    private string $eol = "\n";
    private string $br = '<br>';

    /**
     * @param mixed $text 
     */
    public function __construct(mixed $text)
    {
        if (is_string($text))
        {
            $text = preg_split('/\n\n+/', Str::replace("\r", '', trim($text)));
        }

        parent::__construct($text);
    }

    /**
     * Set the end of line character(s), used in both `toHtml()` and `toString()`. Defaults to `"\n"` if not set.
     * 
     * @param string $eol EOL character(s)
     * @return self
     */
    public function eol(string $eol): self
    {
        $this->eol = $eol;

        return $this;
    }

    /**
     * Set the `<br>` HTML tag used in `toHtml()`. Defaults to `<br>` if not set.
     * 
     * @param string $eol HTML break tag
     * @return self
     */
    public function br(string $br): self
    {
        $this->br = $br;

        return $this;
    }

    /**
     * Returns the paragraphs as a HTML string wrapped in <p> tags.
     * Single new lines are replaced with the break character(s) set with `<br>`.
     * 
     * @params string|iterable Attributes to add to every paragraph element
     * @return string
     */
    public function toHtml(string|iterable $attributes = ''): string
    {
        $attrs = $this->buildAttributesString($attributes);

        return $this->transform(function (string $p) use ($attrs): string
        {
            return (string) Str::of($p)
                ->wrap('<p' . $attrs . '>', '</p>')
                ->replace("\n", $this->br . $this->eol);
        })->join(str_repeat($this->eol, 2));
    }

    /**
     * Returns the words as a string glued together with a single space (or custom string) between words.
     * 
     * @return string
     */
    public function toString(): string
    {
        return $this->transform(fn (string $p): string => Str::replace("\n", $this->eol, $p))
            ->join(Str::repeat($this->eol, 2));
    }

    /**
     * Cast the paragraphs to a string.
     * 
     * @return string
     * 
     * @see Vendeka\Text\Paragraphs::toString()
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Build a HTML attribute string
     * 
     * @params string|iterable $attributes Attributes
     * @return string
     * 
     * @codeCoverageIgnore
     */
    private function buildAttributesString(string|iterable $attributes): string
    {
        if (empty($attributes))
        {
            return '';
        }

        if (is_string($attributes))
        {
            return Str::start($attributes, ' ');
        }

        $attrs = '';

        foreach ($attributes as $key => $value)
        {
            if ($value === false || is_null($value))
            {
                continue;
            }

            if ($value === true)
            {
                $value = $key;
            }

            $attrs .= ' ' . $key . '="' . Str::of($value)->replace('"', '\\"')->trim() . '"';
        }

        return $attrs;
    }
}
