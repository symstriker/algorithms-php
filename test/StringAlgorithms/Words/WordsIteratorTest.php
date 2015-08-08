<?php

namespace StringAlgorithms\Words;


use PHPUnit_Framework_Error;
use PHPUnit_Framework_TestCase;
use Symstriker\Algorithms\StringAlgorithms\Words\Words;
use Symstriker\Algorithms\StringAlgorithms\Words\WordsIterator;

class WordsIteratorTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testConstruct() {
		$iterator = new WordsIterator('sdfgsdf');
	}

	public function testConstructSuccess() {
		$iterator = new WordsIterator(new Words('text text'));
		$this->assertInstanceOf('Symstriker\Algorithms\StringAlgorithms\Words\WordsIterator', $iterator);
	}

	public function testCurrent() {
		$iterator = new WordsIterator(new Words('text text'));
		$this->assertEquals(0, $iterator->current());
		$iterator->next();
		$this->assertEquals(1, $iterator->current());
	}

	public function testNext() {
		$iterator = new WordsIterator(new Words('text text'));
		$iterator->next();
		$this->assertEquals(1, $iterator->current());
		$iterator->next();
		$this->assertEquals(2, $iterator->current());
	}

	public function testKey() {
		$iterator = new WordsIterator(new Words('text text'));
		$this->assertEquals(0, $iterator->key());
		$iterator->next();
		$this->assertEquals(1, $iterator->key());
	}

	public function testValid() {
		$iterator = new WordsIterator(new Words('text text'));
		$iterator->next();
		$iterator->next();
		$iterator->next();
		$iterator->next();
		$iterator->next();
		$iterator->next();
		$this->assertTrue($iterator->valid());
		$iterator->next();
		$iterator->next();
		$iterator->next();
		$this->assertFalse($iterator->valid());
	}

	public function testRewind() {
		$iterator = new WordsIterator(new Words('text text'));
		$iterator->next();
		$iterator->next();
		$iterator->next();
		$iterator->next();
		$iterator->next();
		$iterator->next();
		$this->assertTrue($iterator->valid());
		$iterator->rewind();
		$this->assertEquals(0, $iterator->current());

	}
} 