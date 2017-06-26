<?php
use PHPUnit\Framework\TestCase;
use Vendeka\Text\Text;

class TextTest extends TestCase
{
	public function testToWordsMethodUppercasesFirstCharacter ()
	{
		$this->assertEquals(Text::toWords('a dog'), 'A dog');
		$this->assertEquals(Text::toWords('a_snake'), 'A snake');
		$this->assertEquals(Text::toWords('a-lamb'), 'A lamb');
		$this->assertEquals(Text::toWords('aCamel'), 'A Camel');
		
		$this->assertEquals(Text::toWords('a dog', Text::UPPERCASE_FIRST), 'A dog');
		$this->assertEquals(Text::toWords('a_snake', Text::UPPERCASE_FIRST), 'A snake');
		$this->assertEquals(Text::toWords('a-lamb', Text::UPPERCASE_FIRST), 'A lamb');
		$this->assertEquals(Text::toWords('aCamel', Text::UPPERCASE_FIRST), 'A Camel');
	}

	public function testToWordsMethodUppercasesWords ()
	{	
		$this->assertEquals(Text::toWords('a dog', Text::UPPERCASE_WORDS), 'A Dog');
		$this->assertEquals(Text::toWords('a_snake', Text::UPPERCASE_WORDS), 'A Snake');
		$this->assertEquals(Text::toWords('a-lamb', Text::UPPERCASE_WORDS), 'A Lamb');
		$this->assertEquals(Text::toWords('aCamel', Text::UPPERCASE_WORDS), 'A Camel');
	}

	public function testToWordsMethodUppercasesAllCharacters ()
	{	
		$this->assertEquals(Text::toWords('a dog', true), 'A DOG');
		$this->assertEquals(Text::toWords('a_snake', true), 'A SNAKE');
		$this->assertEquals(Text::toWords('a-lamb', true), 'A LAMB');
		$this->assertEquals(Text::toWords('aCamel', true), 'A CAMEL');
	}

	public function testToWordsMethodLowercasesAllCharacters ()
	{	
		$this->assertEquals(Text::toWords('a dog', false), 'a dog');
		$this->assertEquals(Text::toWords('a_snake', false), 'a snake');
		$this->assertEquals(Text::toWords('a-lamb', false), 'a lamb');
		$this->assertEquals(Text::toWords('aCamel', false), 'a camel');
	}

	public function testToWordsMethoLeaveCaseUntouched ()
	{	
		$this->assertEquals(Text::toWords('a dog', null), 'a dog');
		$this->assertEquals(Text::toWords('a_snake', null), 'a snake');
		$this->assertEquals(Text::toWords('a-lamb', null), 'a lamb');
		$this->assertEquals(Text::toWords('aCamel', null), 'a Camel');
	}

	public function testStartsWithMethod ()
	{
		$this->assertTrue(Text::startsWith('abc', 'a'));
		$this->assertTrue(Text::startsWith('abc', array('a')));
		$this->assertTrue(Text::startsWith('abc', array('b', 'a')));
		
		$this->assertFalse(Text::startsWith('abc', 'b'));
		$this->assertFalse(Text::startsWith('abc', array('b')));
		$this->assertFalse(Text::startsWith('abc', array('b', 'c')));
	}

	public function testEndsWithMethod ()
	{
		$this->assertTrue(Text::endsWith('abc', 'c'));
		$this->assertTrue(Text::endsWith('abc', array('c')));
		$this->assertTrue(Text::endsWith('abc', array('b', 'c')));
		
		$this->assertFalse(Text::endsWith('abc', 'b'));
		$this->assertFalse(Text::endsWith('abc', array('b')));
		$this->assertFalse(Text::endsWith('abc', array('b', 'a')));
	}

	public function testStartMethod ()
	{
		$this->assertEquals(Text::start('path', '/'), '/path');
		$this->assertEquals(Text::start('/path', '/'), '/path');
	}

	public function testFinishMethod ()
	{
		$this->assertEquals(Text::finish('path', '/'), 'path/');
		$this->assertEquals(Text::finish('path/', '/'), 'path/');
	}
	
	public function testWrapMethod ()
	{
		$this->assertEquals(Text::wrap('path', '/'), '/path/');
		$this->assertEquals(Text::wrap('path/', '/'), '/path/');
		$this->assertEquals(Text::wrap('/path', '/'), '/path/');
		$this->assertEquals(Text::wrap('/path/', '/'), '/path/');
		$this->assertEquals(Text::wrap('path', '/x/', '/y/'), '/x/path/y/');
		$this->assertEquals(Text::wrap('/x/path', '/x/', '/y/'), '/x/path/y/');
		$this->assertEquals(Text::wrap('path/y/', '/x/', '/y/'), '/x/path/y/');		
	}
}