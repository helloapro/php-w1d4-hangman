<?php
    class Game
    {
        private $answer;
        private $answerArray;
        private $answerDisplay;
        private $guesses;
        private $wrongGuessCount;
        private $gameOver;

//Constructor
        function __construct($answer = '', $answerArray = array(), $answerDisplay = array(), $guesses = array(), $wrongGuessCount = 6, $gameOver = false)
        {
            $this->answer = $answer;
            $this->answerArray = $answerArray;
            $this->answerDisplay = $answerDisplay;
            $this->guesses = $guesses;
            $this->wrongGuessCount = $wrongGuessCount;
            $this->gameOver = $gameOver;
            $this->start();
        }
//Getters and Setters
        function setAnswer($new_answer)
        {
            $this->answer = (string) $new_answer;
        }
        function setAnswerArray($new_answerArray)
        {
            $this->answerArray = (array) $new_answerArray;
        }
        function setAnswerDisplay($new_answerDisplay)
        {
            $this->answerDisplay = (array) $new_answerDisplay;
        }
        function setGuesses($new_guesses)
        {
            $this->guesses = (array) $new_guesses;
        }
        function setWrongGuessCount($new_wrongGuessCount)
        {
            $this->wrongGuessCount = (int) $new_wrongGuessCount;
        }
        function setGameOver($new_gameOver)
        {
            $this->gameOver = (bool) $new_gameOver;
        }
        function getAnswer()
        {
            return $this->answer;
        }
        function getAnswerArray()
        {
            return $this->answerArray;
        }
        function getAnswerDisplay()
        {
            return $this->answerDisplay;
        }
        function getGuesses()
        {
            return $this->guesses;
        }
        function getWrongGuessCount()
        {
            return $this->wrongGuessCount;
        }
        function getGameOver()
        {
            return $this->gameOver;
        }
//Methods
        function save()
        {
            array_push($_SESSION['guesses'], $this);
        }
        function start()
        {
            $allAnswers = array('penny', 'monkey', 'banana', 'artichoke', 'pizza', 'building', 'architecture');
            $this->answer = $allAnswers[rand(0,6)];
            $length = strlen($this->answer);
            $this->answerArray = array();
            $this->answerDisplay = array();
            for ($i = 0; $i < $length; $i++) {
                array_push($this->answerArray, $this->answer[$i]);
                array_push($this->answerDisplay, '_');
            }
            $this->guesses = array();
            $this->wrongGuessCount = 6;
        }
    }

?>
