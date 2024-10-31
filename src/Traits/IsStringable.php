<?php

namespace Vendeka\Text\Traits;

use Illuminate\Support\Stringable;

/**
 * @internal Provides method to convert to instance `Illuminate\Support\Stringable`.
 * @codeCoverageIgnore
 */
trait IsStringable
{
    /**
     * Return a new instance of `Illuminate\Support\Stringable` to continue the method chain.
     * 
     * @return Stringable
     */
    public function of(): Stringable
    {
        return new Stringable($this);
    }
}
