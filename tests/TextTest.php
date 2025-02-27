<?php

namespace Vendeka\Text\Tests;

use Vendeka\Text\Words;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Vendeka\Text\Paragraphs;

class TextTest extends Test
{
    public function testEncloseMethod(): void
    {
        $this->assertIsString(Str::enclose('Instance', '|'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->enclose('|'));

        // String
        $this->assertEquals('/path/', Str::enclose('path', '/'));
        $this->assertEquals('/path/', Str::enclose('path/', '/'));
        $this->assertEquals('/path/', Str::enclose('/path', '/'));
        $this->assertEquals('/path/', Str::enclose('/path/', '/'));
        $this->assertEquals('/x/path/y/', Str::enclose('path', '/x/', '/y/'));
        $this->assertEquals('/x/path/y/', Str::enclose('/x/path', '/x/', '/y/'));
        $this->assertEquals('/x/path/y/', Str::enclose('path/y/', '/x/', '/y/'));

        // Array
        $this->assertEquals('xXNo0bMaster69Xx', Str::enclose('No0bMaster69', ['X', 'x']));
        $this->assertEquals('xX420No0bMaster420Xx', Str::enclose('No0bMaster', ['420', 'X', 'x']));
    }

    public function testExclamationMethod()
    {
        $this->assertIsString(Str::exclamation('String'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->exclamation());

        $this->assertEquals('Clean your room!', Str::exclamation('clean your room'));
        $this->assertEquals('Clean your room!', Str::exclamation('Clean your room!'));
        
        $this->assertEquals('Clean your room!', Str::exclamation('clean your room'));
        $this->assertEquals('Clean your room!', Str::exclamation('Clean your room!'));
    }

    public function testGlueMethod(): void
    {
        $this->assertIsString(Str::glue('/', '/var', 'www'));

        $this->assertEquals('/var/www', Str::glue('/', '/var', 'www'));
        $this->assertEquals('/var/www', Str::glue('/', '/var', '/www'));
        $this->assertEquals('/var/www', Str::glue('/', '/var/', '/www'));
        $this->assertEquals('/var/www', Str::glue('/', '/var', '/www'));

        $this->assertEquals('/var/www', Str::glue('/', ['/var', 'www']));
        $this->assertEquals('/var/www', Str::glue('/', ['/var', '/www']));
        $this->assertEquals('/var/www', Str::glue('/', ['/var/', '/www']));
        $this->assertEquals('/var/www', Str::glue('/', ['/var', '/www']));
    }

    public function testNaturalMethod(): void
    {
        $this->assertIsString(Str::natural('String'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->natural());

        $this->assertEquals('My first blog post', Str::natural('my-first-blog-post'));
        $this->assertEquals('Property name', Str::natural('property_name'));
        $this->assertEquals('Color', Str::natural('color'));
    }

    public function testNullIfBlankMethod(): void
    {
        $this->assertNull(Str::nullIfBlank(''));
        $this->assertNull(Str::nullIfBlank(' '));
        $this->assertNull(Str::nullIfBlank(null));
        $this->assertEquals('Not blank', Str::nullIfBlank('Not blank'));
    }

    public function testNullIfEmptyMethod(): void
    {
        $this->assertNull(Str::nullIfEmpty(''));
        $this->assertEquals(' ', Str::nullIfEmpty(' '));
        $this->assertNull(Str::nullIfEmpty(null));
        $this->assertEquals('Not blank', Str::nullIfEmpty('Not blank'));
    }

    public function testQuestionMethod(): void
    {
        $this->assertIsString(Str::question('String'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->question());

        $this->assertEquals('Is it e-mail of email?', Str::question('Is it e-mail of email'));
        $this->assertEquals('Is HTML a fad?', Str::question('is HTML a fad'));
    }

    public function testSentenceMethod(): void
    {
        $this->assertIsString(Str::sentence('String'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->sentence());

        $this->assertEquals('Clean your room.', Str::sentence('clean your room'));
        $this->assertEquals('Clean your room.', Str::sentence('clean your room.'));
        $this->assertEquals('Clean your room.', Str::sentence('Clean your room.'));
        $this->assertEquals('Clean your room?', Str::sentence('clean your room?'));
        $this->assertEquals('Clean your room!', Str::sentence('clean your room!'));
    }

    public function testToWordsMethod(): void
    {
        $this->assertInstanceOf(Words::class, Str::toWords('Instance'));
        $this->assertInstanceOf(Words::class, Str::of('Instance')->toWords());
    }

    public function testToParagraphsMethod(): void
    {
        $this->assertInstanceOf(Paragraphs::class, Str::toParagraphs('A sentence.'));
        $this->assertInstanceOf(Paragraphs::class, Str::of('Paragraph?')->toParagraphs());
    }

    public function testUncloseMethod(): void
    {
        $this->assertIsString(Str::unclose('Instance', '/'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->unclose('/'));

        // String
        $this->assertEquals('path', Str::unclose('path', '/'));
        $this->assertEquals('path', Str::unclose('path/', '/'));
        $this->assertEquals('path', Str::unclose('/path', '/'));
        $this->assertEquals('path', Str::unclose('/path/', '/'));
        $this->assertEquals('path', Str::unclose('path', '/x/', '/y/'));
        $this->assertEquals('path', Str::unclose('/x/path', '/x/', '/y/'));
        $this->assertEquals('path', Str::unclose('path/y/', '/x/', '/y/'));
        $this->assertEquals('path', Str::unclose('/x/path/y/', '/x/', '/y/'));

        // Array
        $this->assertEquals('path', Str::unclose('/path/', ['/']));
        $this->assertEquals('path', Str::unclose('/path/', ['/', '\\']));
        $this->assertEquals('path', Str::unclose('x/path/x', ['/', 'x', '/']));
        $this->assertEquals('path', Str::unclose('x/path/x', ['x', '/', 'q', 'x']));
        $this->assertEquals('path', Str::unclose('/x/path/y/', ['/x/', '/a/'], ['/y/', '/z/']));
    }

    public function testUnprefixMethod(): void
    {
        $this->assertIsString(Str::unprefix('Instance', 'In'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->unprefix('In'));

        // String
        $this->assertEquals('path', Str::unprefix('path', '/'));
        $this->assertEquals('path', Str::unprefix('/path', '/'));

        // Array
        $this->assertEquals('path', Str::unprefix('/path', ['/']));
        $this->assertEquals('path', Str::unprefix('/my/path', ['/', 'my/']));
        $this->assertEquals('path', Str::unprefix('/my/path', ['/', 'your/', 'my/']));
    }

    public function testUnsufffixMethod(): void
    {
        $this->assertIsString(Str::unsuffix('Instance', 'x'));
        $this->assertInstanceOf(Stringable::class, Str::of('Instance')->unsuffix('x'));

        // String
        $this->assertEquals('path', Str::unsuffix('path', '/'));
        $this->assertEquals('path', Str::unsuffix('path/', '/'));

        // Array
        $this->assertEquals('path', Str::unsuffix('path/', ['/']));
        $this->assertEquals('path', Str::unsuffix('path/secret/', ['/', '/secret']));
        $this->assertEquals('path', Str::unsuffix('path/secret/', ['/', '/top-secret', '/secret']));
    }
}
