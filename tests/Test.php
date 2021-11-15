<?php

namespace Vendeka\Text\Tests;

use PHPUnit\Framework\TestCase;
use Vendeka\Text\Text;

abstract class Test extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        Text::boot();
    }
}
