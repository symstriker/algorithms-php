<?php

namespace Symstriker\Algorithms\StringAlgorithms\Words;

use InvalidArgumentException;

/**
 * Class Words
 */
class Words implements WordsInterface
{
	/**
	 * @var string $text
	 */
	private $text;
	/**
	 * @var int $textLength
	 */
	private $textLength;


	/**
	 * @param string $text
	 * @throws InvalidArgumentException
	 */
	public function __construct($text) {
		if (!is_string($text)) {
			throw new InvalidArgumentException('Parameter $text must be a string');
		}
		$this->text = $text;
		$this->textLength = strlen($text);
	}

	/**
	 * @return WordsIterator
	 */
	public function getIterator() {
		return new WordsIterator($this);
	}

	/**
	 * @param WordsIterator $iterator
	 * @return string
	 */
	public function getNextWord(WordsIterator $iterator) {
		$word = '';
		while ($iterator->valid()) {
			if (!preg_match("/^{$this->getBasePattern()}$/", $this->text[$iterator->current()])) {
				if ($this->matchWord($word)) {
					break;
				}
				$word = '';
				$iterator->next();
				continue;
			}
			$word .= $this->text[$iterator->current()];
			$iterator->next();
		}
		return $word;
	}

	/**
	 * @param string $word
	 * @param bool $fromTheRight
	 * @throws InvalidArgumentException
	 * @return int
	 */
	public function getWordPosition($word, $fromTheRight = false) {
		if (!is_string($word)) {
			throw new InvalidArgumentException('Parameter $word must be a string');
		}

		if (!is_bool($fromTheRight)) {
			throw new InvalidArgumentException('Parameter $fromTheRight must be a boolean');
		}

		if ($fromTheRight) {
			return strrpos($this->text, $word);
		}
		return strpos($this->text, $word);
	}


	/**
	 * @param WordsIterator $iterator
	 * @param int $length
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function getLongestDistanceMatchingWord(WordsIterator $iterator, $length) {
		if (!is_int($length)) {
			throw new InvalidArgumentException('Parameter $length must be an integer');
		}

		$textLength = $this->textLength;

		$word = '';
		while (--$textLength && $iterator->valid()) {
			if (!preg_match("/^{$this->getBasePattern()}$/", $this->text[$textLength])) {
				if ($this->matchWord($word) && strlen($word) == $length) {
					$word = strrev($word);
					break;
				}
				$word = '';
				continue;
			}
			$word .= $this->text[$textLength];

		}

		return $word;
	}

    /**
     * @param WordsIterator $iterator
     * @return array|MatchedWords
     */
	public function findLongestDistanceMatchedWords(WordsIterator $iterator) {
		$currentWordPairsDiff = 0;
		$currentWord = '';
		$currentWordPair = '';
		while ($nextWord = $this->getNextWord($iterator)) {
			if ($this->textLength - $iterator->current() < $currentWordPairsDiff) {
				break;
			}
			$matchedPair = $this->getLongestDistanceMatchingWord($iterator, strlen($nextWord));
			$pairDiff = $this->getWordPosition($matchedPair, true) - $this->getWordPosition($nextWord, false) + strlen($nextWord);

			if ($pairDiff > $currentWordPairsDiff
				&& $this->getWordPosition($matchedPair, true) != $this->getWordPosition($nextWord, true)
			) {
				$currentWordPairsDiff = $pairDiff;
				$currentWord = $nextWord;
				$currentWordPair = $matchedPair;
			}
		}
		if (!$currentWordPairsDiff) {
			return null;
		}

        return new MatchedWords($currentWord, $currentWordPair);
	}


	/**
	 * @param string $word
	 * @throws InvalidArgumentException
	 * @return int
	 */
	public function matchWord($word) {
		if (!is_string($word)) {
			throw new InvalidArgumentException('Parameter $word must be a string');
		}
		return preg_match("/^{$this->getBasePattern()}{2,}$/", $word);
	}

	/**
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @return int
	 */
	public function getTextLength() {
		return $this->textLength;
	}


    public function getBasePattern() {
        return '[A-Za-zА-Я-а-я`-]';
    }
}
