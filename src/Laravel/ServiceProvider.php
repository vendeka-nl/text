<?php

namespace Vendeka\Text\Laravel;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Vendeka\Text\Text;

/**
 * @codeCoverageIgnore
 */
class ServiceProvider extends LaravelServiceProvider
{
    public function boot(): void
    {
        Text::boot();
    }
}
