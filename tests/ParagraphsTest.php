<?php

namespace Vendeka\Text\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Vendeka\Text\Paragraphs;

class ParagraphsTest extends Test
{
    public function testInstanceOfCollection(): void
    {
        $this->assertInstanceOf(Collection::class, new Paragraphs(''));
        $this->assertInstanceOf(Collection::class, new Paragraphs([]));
    }

    public function testToStringMethodReturnsString(): void
    {
        $paragraphs = new Paragraphs("First\n\nSecond");

        $this->assertEquals("First\n\nSecond", $paragraphs->toString());
        $this->assertEquals("First\n\nSecond", $paragraphs->__toString());
        $this->assertEquals("First\n\nSecond", (string) $paragraphs);
    }

    public function testOfMethodReturnsStringableInstance(): void
    {
        $this->assertInstanceOf(Stringable::class, (new Paragraphs('stringable'))->of());
    }

    public function testToArrayMethodReturnsArray(): void
    {
        $this->assertIsArray((new Paragraphs(''))->toArray());
        $this->assertIsArray((new Paragraphs([]))->toArray());
    }

    public function testToStringMethod(): void
    {
        $this->assertEquals("First\n\nSecond\nThird", (new Paragraphs("First\n\nSecond\nThird"))->toString());
        $this->assertEquals("First\n\nSecond\nThird", (new Paragraphs("First\r\n\r\nSecond\r\nThird"))->toString());
        $this->assertEquals("First\n\nSecond", (new Paragraphs("First\n\n\nSecond"))->toString());
        $this->assertEquals("First\n\nSecond", (new Paragraphs(['First', 'Second']))->toString());
    }

    public function testToHtmlMethodWithoutAttributes(): void
    {
        // Without attributes
        $this->assertEquals("<p>First</p>\n\n<p>Second<br>\nThird</p>", (new Paragraphs("First\n\nSecond\nThird"))->toHtml());
        $this->assertEquals("<p>First</p>\n\n<p>Second<br>\nThird</p>", (new Paragraphs("First\r\n\r\nSecond\r\nThird"))->toHtml());
        $this->assertEquals("<p>First</p>\n\n<p>Second</p>", (new Paragraphs("First\n\n\nSecond"))->toHtml());
        $this->assertEquals("<p>First</p>\n\n<p>Second</p>", (new Paragraphs(['First', 'Second']))->toHtml());
    }

    public function testToHtmlMethodWithEmptyAttributesString(): void
    {
        // With empty attributes string
        $this->assertEquals("<p>First</p>\n\n<p>Second<br>\nThird</p>", (new Paragraphs("First\n\nSecond\nThird"))->toHtml(''));
        $this->assertEquals("<p>First</p>\n\n<p>Second<br>\nThird</p>", (new Paragraphs("First\r\n\r\nSecond\r\nThird"))->toHtml(''));
        $this->assertEquals("<p>First</p>\n\n<p>Second</p>", (new Paragraphs("First\n\n\nSecond"))->toHtml(''));
        $this->assertEquals("<p>First</p>\n\n<p>Second</p>", (new Paragraphs(['First', 'Second']))->toHtml(''));
    }

    public function testToHtmlMethodWithEmptyAttributesArray(): void
    {
        // With empty attributes array
        $this->assertEquals("<p>First</p>\n\n<p>Second<br>\nThird</p>", (new Paragraphs("First\n\nSecond\nThird"))->toHtml([]));
        $this->assertEquals("<p>First</p>\n\n<p>Second<br>\nThird</p>", (new Paragraphs("First\r\n\r\nSecond\r\nThird"))->toHtml([]));
        $this->assertEquals("<p>First</p>\n\n<p>Second</p>", (new Paragraphs("First\n\n\nSecond"))->toHtml([]));
        $this->assertEquals("<p>First</p>\n\n<p>Second</p>", (new Paragraphs(['First', 'Second']))->toHtml([]));
    }

    public function testToHtmlMethodWithAttributesString(): void
    {
        // With attributes string
        $attrsStr = 'class="mt-4"';

        $this->assertEquals('<p class="mt-4">First</p>' . "\n\n" . '<p class="mt-4">Second<br>' . "\n" . 'Third</p>', (new Paragraphs("First\n\nSecond\nThird"))->toHtml($attrsStr));
        $this->assertEquals('<p class="mt-4">First</p>' . "\n\n" . '<p class="mt-4">Second<br>' . "\n" . 'Third</p>', (new Paragraphs("First\r\n\r\nSecond\r\nThird"))->toHtml(' ' . $attrsStr));
        $this->assertEquals('<p class="mt-4">First</p>' . "\n\n" . '<p class="mt-4">Second</p>', (new Paragraphs("First\n\n\nSecond"))->toHtml($attrsStr));
        $this->assertEquals('<p class="mt-4">First</p>' . "\n\n" . '<p class="mt-4">Second</p>', (new Paragraphs(['First', 'Second']))->toHtml(' ' . $attrsStr));
    }

    public function testToHtmlMethodWithAttributesArrayOrCollection(): void
    {
        // With array attributes/collection
        $attrsArr = ['class' => 'mt-4'];
        $attrsCollection = new Collection($attrsArr);

        $this->assertEquals('<p class="mt-4">First</p>' . "\n\n" . '<p class="mt-4">Second<br>' . "\n" . 'Third</p>', (new Paragraphs("First\n\nSecond\nThird"))->toHtml($attrsArr));
        $this->assertEquals('<p class="mt-4">First</p>' . "\n\n" . '<p class="mt-4">Second<br>' . "\n" . 'Third</p>', (new Paragraphs("First\r\n\r\nSecond\r\nThird"))->toHtml($attrsArr));
        $this->assertEquals('<p class="mt-4">First</p>' . "\n\n" . '<p class="mt-4">Second</p>', (new Paragraphs("First\n\n\nSecond"))->toHtml($attrsCollection));
        $this->assertEquals('<p class="mt-4">First</p>' . "\n\n" . '<p class="mt-4">Second</p>', (new Paragraphs(['First', 'Second']))->toHtml($attrsCollection));
    }

    public function testEolMethodToString(): void
    {
        $this->assertEquals("First\r\n\r\nSecond\r\n3rd", (new Paragraphs("First\n\nSecond\n3rd"))->eol("\r\n")->toString());
        $this->assertEquals("1st[EOL][EOL]2nd[EOL]3rd", (new Paragraphs("1st\n\n2nd\n3rd"))->eol('[EOL]')->toString());
    }

    public function testEolMethodToHtml(): void
    {
        $this->assertEquals("<p>First</p>\r\n\r\n<p>Second<br>\r\nThird</p>", (new Paragraphs("First\r\n\r\nSecond\r\nThird"))->eol("\r\n")->toHtml());
    }

    public function testBr(): void
    {
        $this->assertEquals("<p>First</p>\n\n<p>Second<br />\nThird</p>", (new Paragraphs("First\r\n\r\nSecond\r\nThird"))->br('<br />')->toHtml());
        $this->assertEquals("<p>First</p>\n\n<p>Second[BR]\nThird</p>", (new Paragraphs("First\r\n\r\nSecond\r\nThird"))->br('[BR]')->toHtml());
    }
}
