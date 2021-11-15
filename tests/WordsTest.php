<?php

namespace Vendeka\Text\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Vendeka\Text\Words;

class WordsTest extends Test
{
    public function testInstanceOfCollection(): void
    {
        $this->assertInstanceOf(Collection::class, new Words(''));
        $this->assertInstanceOf(Collection::class, new Words([]));
    }

	public function testToStringMethodReturnsString(): void
	{
        // Default (space)
        $words = new Words('Same');

        $this->assertEquals('Same', $words->toString());
        $this->assertEquals('Same', $words->__toString());
        $this->assertEquals('Same', (string) $words);

        // Custom glue
        $multi = new Words('multiple-words');
        $this->assertEquals('multiple/words', $multi->toString('/'));
	}

    public function testToStringMethodHandlesAcronymsCorrectly(): void
    {
        $acronyms = new Words('HTML for dummies');
        $this->assertEquals('HTML for dummies', $acronyms->toString());
        $this->assertEquals('HTML/for/dummies', $acronyms->toString('/'));
        $this->assertEquals('html-for-dummies', $acronyms->of()->slug());
    }

    public function testToStringMethodHandlesDottedAcronymsCorrectly(): void
    {
        $acronyms = new Words('H.T.M.L. for noobs');
        $this->assertEquals('H.T.M.L. for noobs', $acronyms->toString());
        $this->assertEquals('html-for-noobs', $acronyms->of()->slug());
    }

	public function testOfMethodReturnsStringableInstance(): void
	{
        $this->assertInstanceOf(Stringable::class, (new Words('Stringable'))->of());
    }
    
	public function testToArrayMethodReturnsArray(): void
	{
        $this->assertIsArray((new Words(''))->toArray());
        $this->assertIsArray((new Words([]))->toArray());
	}
}