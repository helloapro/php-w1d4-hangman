<?php
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Guess.php';
    require_once __DIR__.'/../src/Game.php';

    session_start();

    if (empty($_SESSION['game']) || $_SESSION['game']->getGameOver() == true) {
        $_SESSION['game'] = new Game();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get('/', function() use ($app) {
        return $app['twig']->render('home.html.twig', array('answerDisplay' => $_SESSION['game']->getAnswerDisplay()));
    });

    $app->post('/', function() use ($app) {
        $newGuess = new Guess($_POST['guess']);
        $newGuess = $newGuess->getLetter();
        if (in_array($newGuess, $_SESSION['game']->getGuesses()))
        {
            echo "You've already guessed that letter silly!";
        }
        elseif (in_array($newGuess, $_SESSION['game']->getAnswerArray()))
        {
            $i = 0;
            foreach ($_SESSION['game']->getAnswerArray() as $letter) {
                if ($letter == $newGuess) {
                    $oldArray = $_SESSION['game']->getAnswerDisplay();
                    $oldArray[$i] = $letter;
                    $_SESSION['game']->setAnswerDisplay($oldArray);
                }
                $i++;
            }
            $oldGuesses = $_SESSION['game']->getGuesses();
            array_push($oldGuesses, $newGuess);
            $_SESSION['game']->setGuesses($oldGuesses);
        }
        else
        {
            $oldGuesses = $_SESSION['game']->getGuesses();
            array_push($oldGuesses, $newGuess);
            $_SESSION['game']->setGuesses($oldGuesses);
            $_SESSION['game']->setWrongGuessCount($_SESSION['game']->getWrongGuessCount()-1);
            if ($_SESSION['game']->getWrongGuessCount() == 0)
            {
                echo "I'm so sorry! The word was " . $_SESSION['game']->getAnswer() . ". You're a loser, and now someone has paid with their life for it...<a href='/'>Play again?</a>";
                $_SESSION['game']->setGameOver(true);
            }
            else
            {
                echo "No letters match your guess! Try again.";
            }
        }

        if (in_array('_', $_SESSION['game']->getAnswerDisplay()) == false)
        {
            echo "You Win!! You guessed " . $_SESSION['game']->getAnswer() . "! <a href='/'>Play again?</a>";
            $_SESSION['game']->setGameOver(true);
        }

        return $app['twig']->render('home.html.twig', array('answerDisplay' => $_SESSION['game']->getAnswerDisplay()));
    });




    return $app;
?>
