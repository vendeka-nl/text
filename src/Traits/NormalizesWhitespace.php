<?php

namespace Vendeka\Text\Traits;

/**
 * @deprecated 3.3.1 This trait was only to be used internally and will be dropped in v4.
 * @internal Used internally to trim and replace repeating whitespace characters with a single space.
 * @codeCoverageIgnore
 */
trait NormalizesWhitespace
{
    private static function purgeWhitespace(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/\s+/', ' ', $text);

        return $text;
    }
}
