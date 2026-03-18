<?php

namespace Vendeka\Text\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Vendeka\Text\Text;

abstract class TestCase extends PHPUnitTestCase
{
    public static function setUpBeforeClass(): void
    {
        Text::boot();
    }
}
