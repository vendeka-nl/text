<?php

namespace Vendeka\Text\Traits;

/**
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
