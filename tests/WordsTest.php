<?php
namespace Vendeka\Text\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use PHPUnit\Framework\TestCase;
use Vendeka\Text\Words;

class WordsTest extends TestCase
{
    public function testInstanceOfCollection(): void
    {
        $this->assertInstanceOf(Collection::class, new Words(''));
        $this->assertInstanceOf(Collection::class, new Words([]));
    }

	public function testToStringMethodReturnsString(): void
	{
        $words = new Words('Same');

        $this->assertEquals('Same', $words->toString());
        $this->assertEquals('Same', $words->__toString());
        $this->assertEquals('Same', (string) $words);
	}

	public function testOfMethodReturnsStringableInstance(): void
	{
        $this->assertInstanceOf(Stringable::class, (new Words('Stringable'))->of());
    }
    
	public function testToArrayMethodReturnsArray(): void
	{
        $this->assertIsArray((new Words(''))->toArray());
	}
}