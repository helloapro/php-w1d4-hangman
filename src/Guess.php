<?php
    class Guess
    {
        private $letter;

//Constructor
        function __construct($letter)
        {
            $this->letter = $letter;
        }
//Getters and Setters
        function setLetter ($new_letter)
        {
            $this->letter = (string) $new_letter;
        }
        function getLetter ()
        {
            return $this->letter;
        }
    }

?>
