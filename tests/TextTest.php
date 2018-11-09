<?php
use PHPUnit\Framework\TestCase;
use Vendeka\Text\Text;

class TextTest extends TestCase
{
	public function testToWordsMethodUppercasesFirstCharacter (): void
	{
		$this->assertEquals('A dog', Text::toWords('a dog'));
		$this->assertEquals('A snake', Text::toWords('a_snake'));
		$this->assertEquals('A lamb', Text::toWords('a-lamb'));
		$this->assertEquals('A camel', Text::toWords('aCamel'));
		$this->assertEquals('A dog', Text::toWords('a dog', Text::UPPERCASE_FIRST));
		$this->assertEquals('A snake', Text::toWords('a_snake', Text::UPPERCASE_FIRST));
		$this->assertEquals('A lamb', Text::toWords('a-lamb', Text::UPPERCASE_FIRST));
		$this->assertEquals('A camel', Text::toWords('aCamel', Text::UPPERCASE_FIRST));
		$this->assertEquals('A Dog', Text::toWords('a Dog', Text::UPPERCASE_FIRST, false));
		$this->assertEquals('A Snake', Text::toWords('a_Snake', Text::UPPERCASE_FIRST, false));
		$this->assertEquals('A Lamb', Text::toWords('a-Lamb', Text::UPPERCASE_FIRST, false));
		$this->assertEquals('A Camel', Text::toWords('aCamel', Text::UPPERCASE_FIRST, false));
	}

	public function testToWordsMethodUppercasesWords (): void
	{
		$this->assertEquals('A Dog', Text::toWords('a dog', Text::UPPERCASE_WORDS));
		$this->assertEquals('A Snake', Text::toWords('a_snake', Text::UPPERCASE_WORDS));
		$this->assertEquals('A Lamb', Text::toWords('a-lamb', Text::UPPERCASE_WORDS));
		$this->assertEquals('A Camel', Text::toWords('aCamel', Text::UPPERCASE_WORDS));
		$this->assertEquals('A Dog', Text::toWords('a Dog', Text::UPPERCASE_WORDS, false));
		$this->assertEquals('A Snake', Text::toWords('a_Snake', Text::UPPERCASE_WORDS, false));
		$this->assertEquals('A Lamb', Text::toWords('a-Lamb', Text::UPPERCASE_WORDS, false));
		$this->assertEquals('A Camel', Text::toWords('aCamel', Text::UPPERCASE_WORDS, false));
	}

	public function testToWordsMethodUppercasesAllCharacters (): void
	{
		$this->assertEquals('A DOG', Text::toWords('a dog', true));
		$this->assertEquals('A SNAKE', Text::toWords('a_snake', true));
		$this->assertEquals('A LAMB', Text::toWords('a-lamb', true));
		$this->assertEquals('A CAMEL', Text::toWords('aCamel', true));
	}

	public function testToWordsMethodLowercasesAllCharacters (): void
	{
		$this->assertEquals('a dog', Text::toWords('a dog', false));
		$this->assertEquals('a snake', Text::toWords('a_snake', false));
		$this->assertEquals('a lamb', Text::toWords('a-lamb', false));
		$this->assertEquals('a camel', Text::toWords('aCamel', false));
	}

	public function testToWordsMethodLeaveCaseUntouched (): void
	{
		$this->assertEquals('a dog', Text::toWords('a dog', null));
		$this->assertEquals('a snake', Text::toWords('a_snake', null));
		$this->assertEquals('a lamb', Text::toWords('a-lamb', null));
		$this->assertEquals('a Camel', Text::toWords('aCamel', null));
	}

	public function testStartsWithMethod (): void
	{
		$this->assertTrue(Text::startsWith('abc', 'a'));
		$this->assertTrue(Text::startsWith('abc', ['a']));
		$this->assertTrue(Text::startsWith('abc', ['b', 'a']));
		$this->assertFalse(Text::startsWith('abc', 'b'));
		$this->assertFalse(Text::startsWith('abc', ['b']));
		$this->assertFalse(Text::startsWith('abc', ['b', 'c']));
	}

	public function testEndsWithMethod (): void
	{
		$this->assertTrue(Text::endsWith('abc', 'c'));
		$this->assertTrue(Text::endsWith('abc', ['c']));
		$this->assertTrue(Text::endsWith('abc', ['b', 'c']));
		$this->assertFalse(Text::endsWith('abc', 'b'));
		$this->assertFalse(Text::endsWith('abc', ['b']));
		$this->assertFalse(Text::endsWith('abc', ['b', 'a']));
	}

	public function testStartMethod (): void
	{
		$this->assertEquals('/path', Text::start('path', '/'));
		$this->assertEquals('/path', Text::start('/path', '/'));
	}

	public function testFinishMethod (): void
	{
		$this->assertEquals('path/', Text::finish('path', '/'));
		$this->assertEquals('path/', Text::finish('path/', '/'));
	}

	public function testWrapMethod (): void
	{
		$this->assertEquals('/path/', Text::wrap('path', '/'));
		$this->assertEquals('/path/', Text::wrap('path/', '/'));
		$this->assertEquals('/path/', Text::wrap('/path', '/'));
		$this->assertEquals('/path/', Text::wrap('/path/', '/'));
		$this->assertEquals('/x/path/y/', Text::wrap('path', '/x/', '/y/'));
		$this->assertEquals('/x/path/y/', Text::wrap('/x/path', '/x/', '/y/'));
		$this->assertEquals('/x/path/y/', Text::wrap('path/y/', '/x/', '/y/'));
	}

	public function testUnprefixMethod (): void
	{
		$this->assertEquals('path', Text::unprefix('path', '/'));
		$this->assertEquals('path', Text::unprefix('/path', '/'));
	}

	public function testUnsufffixMethod (): void
	{
		$this->assertEquals('path', Text::unsuffix('path', '/'));
		$this->assertEquals('path', Text::unsuffix('path/', '/'));
	}

	public function testUnwrapMethod(): void
	{
		$this->assertEquals('path', Text::unwrap('path', '/'));
		$this->assertEquals('path', Text::unwrap('path/', '/'));
		$this->assertEquals('path', Text::unwrap('/path', '/'));
		$this->assertEquals('path', Text::unwrap('/path/', '/'));
		$this->assertEquals('path', Text::unwrap('path', '/x/', '/y/'));
		$this->assertEquals('path', Text::unwrap('/x/path', '/x/', '/y/'));
		$this->assertEquals('path', Text::unwrap('path/y/', '/x/', '/y/'));
		$this->assertEquals('path', Text::unwrap('/x/path/y/', '/x/', '/y/'));
	}

	public function testToTitleCaseMethod (): void
	{
		$this->assertEquals('A Dog', Text::toTitleCase('a Dog', Text::UPPERCASE_WORDS));
		$this->assertEquals('A Snake', Text::toTitleCase('a snake', Text::UPPERCASE_WORDS));
	}

	public function testToUpperCaseMethod (): void
	{
		$this->assertEquals('A DOG', Text::toUpperCase('a Dog', true));
		$this->assertEquals('A SNAKE', Text::toUpperCase('A SNAKE', true));
	}

	public function testToLowerCaseMethod (): void
	{
		$this->assertEquals('a dog', Text::toLowerCase('A dog'));
		$this->assertEquals('a snake', Text::toLowerCase('A SNAKE'));
	}

	public function testFirstToUpperCaseMethod (): void
	{
		$this->assertEquals('A dog', Text::firstToUpperCase('a Dog'));
		$this->assertEquals('A Snake', Text::firstToUpperCase('A Snake', false));
		$this->assertEquals('Pet anaconda', Text::firstToUpperCase('pet Anaconda', 'Unrecognized value'));
	}

	public function testChangeCaseMethodUppercasesFirstCharacter (): void
	{
		$this->assertEquals('A dog', Text::changeCase('a dog', Text::UPPERCASE_FIRST));
		$this->assertEquals('A snake', Text::changeCase('a Snake', Text::UPPERCASE_FIRST));
		$this->assertEquals('A cat', Text::changeCase('a cat', Text::UPPERCASE_FIRST, false));
		$this->assertEquals('A Duck', Text::changeCase('a Duck', Text::UPPERCASE_FIRST, false));
	}

	public function testChangeCaseMethodUppercasesWords (): void
	{
		$this->assertEquals('A Dog', Text::changeCase('a Dog', Text::UPPERCASE_WORDS));
		$this->assertEquals('A Snake', Text::changeCase('a snake', Text::UPPERCASE_WORDS));
		$this->assertEquals('A DOG', Text::changeCase('a DOG', Text::UPPERCASE_WORDS, false));
		$this->assertEquals('A SnAKe', Text::changeCase('a snAKe', Text::UPPERCASE_WORDS, false));
	}

	public function testChangeCaseMethodUppercasesAllCharacters (): void
	{
		$this->assertEquals('A DOG', Text::changeCase('a Dog', true));
		$this->assertEquals('A SNAKE', Text::changeCase('A SNAKE', true));
	}

	public function testChangeCaseMethodLowercasesAllCharacters (): void
	{
		$this->assertEquals('a dog', Text::changeCase('A dog', false));
		$this->assertEquals('a snake', Text::changeCase('A SNAKE', false));
	}

	public function testChangeCaseMethodLeaveCaseUntouched (): void
	{
		$this->assertEquals('a dog', Text::changeCase('a dog', null));
		$this->assertEquals('A Snake', Text::changeCase('A Snake', null));
		$this->assertEquals('pet anaconda', Text::changeCase('pet anaconda', 'Unrecognized value'));
	}
}