<?php

namespace StringAlgorithms\Words;


use InvalidArgumentException;
use PHPUnit_Framework_Error;
use PHPUnit_Framework_TestCase;
use Symstriker\Algorithms\StringAlgorithms\Words\Words;

/**
 * Class WordsTest
 * @package StringAlgorithms\Words
 */
class WordsTest extends PHPUnit_Framework_TestCase {

	/**
	* @expectedException InvalidArgumentException
	*/
	public function testConstructWithException() {
		$words = new Words($this);
	}

	public function testBasic() {
		$words = new Words($this->text());
		$this->assertInstanceOf('Symstriker\Algorithms\StringAlgorithms\Words\Words', $words);
	}

	public function testGetIterator() {
		$words = new Words($this->text());
		$this->assertInstanceOf('Symstriker\Algorithms\StringAlgorithms\Words\WordsIterator', $words->getIterator());
	}

	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testGetNextWordNegative() {
		$words = new Words($this->text());
		$words->getNextWord(1);
	}

	public function testGetNextWordWithNewIterator() {
		$words = new Words($this->text());
		$word1 = $words->getNextWord($words->getIterator());
		$word2 = $words->getNextWord($words->getIterator());
		$this->assertEquals('For', $word1);
		$this->assertEquals('For', $word2);
	}

	public function testGetNextWordWithSameIteratorInstance() {
		$words = new Words($this->text());
		$iterator = $words->getIterator();
		$word1 = $words->getNextWord($iterator);
		$word2 = $words->getNextWord($iterator);
		$this->assertEquals('For', $word1);
		$this->assertEquals('testing', $word2);
	}

	public function testGetNextWordReturns() {
		$words = new Words($this->text());
		$iterator = $words->getIterator();
		$allWords = [];
		while ($next = $words->getNextWord($iterator)) {
			$allWords[] = $next;
		}
		$this->assertEquals(16, count($allWords));
	}

	public function testGetWordPosition(){
		$words = new Words($this->text());
		$iterator = $words->getIterator();
		$next1 = $words->getNextWord($iterator);
		$next2 = $words->getNextWord($iterator);
		$this->assertEquals(0, $words->getWordPosition($next1));
		$this->assertEquals(4, $words->getWordPosition($next2));
		$this->assertEquals(4, $words->getWordPosition($next2, true));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testGetWordPositionWithBadWordParameter() {
		$words = new Words($this->text());
		$iterator = $words->getIterator();
		$next1 = $words->getNextWord($iterator);
		$this->assertEquals(0, $words->getWordPosition(1));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testGetWordPositionWithBadFromTheRightParameter() {
		$words = new Words($this->text());
		$iterator = $words->getIterator();
		$next1 = $words->getNextWord($iterator);
		$this->assertEquals(0, $words->getWordPosition($next1, 1));
	}


	public function testGetLongestDistanceMatchingWord() {
		$words = new Words($this->text());
		$iterator = $words->getIterator();
		$next1 = $words->getNextWord($iterator);
		$longDistance1 = $words->getLongestDistanceMatchingWord($iterator, strlen($next1));
		$next2 = $words->getNextWord($iterator);
		$longDistance2 = $words->getLongestDistanceMatchingWord($iterator, strlen($next2));
		$this->assertEquals('our', $longDistance1);
		$this->assertEquals('phpunit', $longDistance2);
	}

	public function testGetText() {
		$words = new Words($this->text());
		$this->assertEquals($this->text(), $words->getText());
	}

	public function testGetTextLength() {
		$words = new Words($this->text());
		$words->getNextWord($words->getIterator());
		$this->assertEquals(strlen($this->text()), strlen($words->getText()));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testMatchWordWithException() {
		$words = new Words($this->text());
		$words->matchWord(2);
	}

	public function testMatchWord(){
		$words = new Words($this->text());
		$this->assertEquals(1, $words->matchWord('about'));
	}

	public function testFindLongestDistanceMatchedWords(){
		$words = new Words($this->text());
		$matchedWords = $words->findLongestDistanceMatchedWords($words->getIterator());
		$this->assertEquals('For', array_shift($matchedWords));
		$this->assertEquals('our', array_shift($matchedWords));

		$words = new Words('this is easily way');
		$matchedWords = $words->findLongestDistanceMatchedWords($words->getIterator());
		$this->assertEmpty($matchedWords);

	}


	public function text() {
		return "For testing lets use phpunit. After test would be done we need to subscribe our work.";
	}

} 