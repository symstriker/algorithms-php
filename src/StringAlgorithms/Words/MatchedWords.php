<?php

namespace Symstriker\Algorithms\StringAlgorithms\Words;

/**
 * Class MatchedWords
 * @package Symstriker\Algorithms\StringAlgorithms\Words
 */
class MatchedWords
{

    /**
     * @var string
     */
    public $firstWord;

    /**
     * @var string
     */
    public $secondWord;

    /**
     * @param string $firstWord
     * @param string $secondWord
     */
    public function __construct($firstWord, $secondWord)
    {
        if (!is_string($firstWord)) {
            throw new \InvalidArgumentException('Parameter $firstWord must be a string');
        }

        if (!is_string($secondWord)) {
            throw new \InvalidArgumentException('Parameter $secondWord must be a string');
        }

        $this->firstWord = $firstWord;
        $this->secondWord = $secondWord;
    }
} 