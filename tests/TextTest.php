<?php

namespace Vendeka\Text\Tests;

use Vendeka\Text\Words;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class TextTest extends Test
{
    public function testNormalizeWhitespaceMethod(): void
    {
        $this->assertIsString(Str::normalizeWhitespace('Instance'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->normalizeWhitespace());

        $this->assertEquals('White space', Str::normalizeWhitespace(" White\r\n space  "));
        $this->assertEquals('White space', Str::of("White  space\t")->normalizeWhitespace());
    }

    public function testToWordsMethod(): void
    {
        $this->assertInstanceOf(Words::class, Str::toWords('Instance'));
        $this->assertInstanceOf(Words::class, Str::of('Instance')->toWords());

        $this->assertEquals('a dog', (string) Str::toWords('a dog'));
        $this->assertEquals('a snake', Str::toWords('a_snake')->__toString());
        $this->assertEquals('a lamb', Str::toWords('a-lamb')->toString());
        $this->assertEquals('a Camel', (string) Str::toWords('aCamel'));
    }

    public function testUnprefixMethod(): void
    {
        $this->assertIsString(Str::unprefix('Instance', 'In'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->unprefix('In'));

        $this->assertEquals('path', Str::unprefix('path', '/'));
        $this->assertEquals('path', Str::unprefix('/path', '/'));
    }

    public function testUnsufffixMethod(): void
    {
        $this->assertIsString(Str::unsuffix('Instance', 'x'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->unsuffix('x'));

        $this->assertEquals('path', Str::unsuffix('path', '/'));
        $this->assertEquals('path', Str::unsuffix('path/', '/'));
    }

    public function testUnwrapMethod(): void
    {
        $this->assertIsString(Str::unwrap('Instance', '/'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->unwrap('/'));

        $this->assertEquals('path', Str::unwrap('path', '/'));
        $this->assertEquals('path', Str::unwrap('path/', '/'));
        $this->assertEquals('path', Str::unwrap('/path', '/'));
        $this->assertEquals('path', Str::unwrap('/path/', '/'));
        $this->assertEquals('path', Str::unwrap('path', '/x/', '/y/'));
        $this->assertEquals('path', Str::unwrap('/x/path', '/x/', '/y/'));
        $this->assertEquals('path', Str::unwrap('path/y/', '/x/', '/y/'));
        $this->assertEquals('path', Str::unwrap('/x/path/y/', '/x/', '/y/'));
    }

    public function testWrapMethod(): void
    {
        $this->assertIsString(Str::wrap('Instance', '|'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->wrap('|'));

        $this->assertEquals('/path/', Str::wrap('path', '/'));
        $this->assertEquals('/path/', Str::wrap('path/', '/'));
        $this->assertEquals('/path/', Str::wrap('/path', '/'));
        $this->assertEquals('/path/', Str::wrap('/path/', '/'));
        $this->assertEquals('/x/path/y/', Str::wrap('path', '/x/', '/y/'));
        $this->assertEquals('/x/path/y/', Str::wrap('/x/path', '/x/', '/y/'));
        $this->assertEquals('/x/path/y/', Str::wrap('path/y/', '/x/', '/y/'));
    }
}
