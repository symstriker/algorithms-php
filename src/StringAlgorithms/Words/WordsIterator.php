<?php

namespace Symstriker\Algorithms\StringAlgorithms\Words;

/**
 * Class WordsIterator
 */
class WordsIterator implements \Iterator
{


	private $words;
	private $caretPosition = 0;

	public function __construct(WordsInterface $words) {
		$this->words = $words;
	}


	/**
	 *
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return int
	 */
	public function current() {
		return $this->caretPosition;
	}

	/**
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next() {
		++$this->caretPosition;
	}

	/**
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return int.
	 */
	public function key() {
		return $this->current();
	}

	/**
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid() {
		return ($this->caretPosition < $this->words->getTextLength() - 1 && isset($this->words->getText()[$this->caretPosition]));
	}

	/**
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind() {
		$this->caretPosition = 0;
	}
}