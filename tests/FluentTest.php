<?php
use PHPUnit\Framework\TestCase;
use Vendeka\Text\Fluent;

class FluentTest extends TestCase
{
    public function testStringification (): void
    {
        $this->assertEquals('My string', (string) new Fluent('My string'));
    }

    public function testReturnsInstance (): void
    {
        $this->assertInstanceOf(Fluent::class, (new Fluent('My string'))->toLowerCase(null));
    }

    public function testReturnsBoolean (): void
    {
        $this->assertTrue(is_bool((new Fluent('MySQL'))->startsWith('My')));
    }
	
    public function testThrowsExceptionForMissingMethods (): void
    {
        $fluid = new Fluent('Fluent');

        $this->expectException(\BadMethodCallException::class);

        $fluid->thisMethodDoesNotExist();
    }
}