<?php
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Guess.php';

    session_start();
    if ($_SESSION['answer'] == array()) {
        $_SESSION['answer'] = 'penny';
        $_SESSION['answerArray'] = array('p','e','n','n','y');
        $_SESSION['answerDisplay'] = array('_','_','_','_','_');
        $_SESSION['guesses'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get('/', function() use ($app) {
        // $length = strlen($_SESSION['answer']);
        // $answerDisplay = '';
        // for ($i = 0; $i < $length; $i++) {
        //     $answerDisplay .= '_ ';
        // }

        return $app['twig']->render('home.html.twig', array('answerDisplay' => $_SESSION['answerDisplay']));
    });

    $app->post('/', function() use ($app) {
        $newGuess = new Guess($_POST['guess']);
        $newGuess = $newGuess->getLetter();
        if (in_array($newGuess, $_SESSION['guesses']))
        {
            echo "You've already guessed that letter silly!";
        }
        elseif (in_array($newGuess, $_SESSION['answerArray']))
        {
            $i = 0;
            foreach ($_SESSION['answerArray'] as $letter) {
                if ($letter == $newGuess) {
                    $_SESSION['answerDisplay'][$i] = $letter;
                }
                $i++;
            }
            array_push($_SESSION['guesses'], $newGuess);
        }
        else
        {
            echo "No letters match your guess! Try again.";
            array_push($_SESSION['guesses'], $newGuess);
        }

        return $app['twig']->render('home.html.twig', array('answerDisplay' => $_SESSION['answerDisplay']));
    });




    return $app;
?>
