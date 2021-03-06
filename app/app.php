<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Scrabble.php';

    session_start();

    if (empty($_SESSION['list_of_words'])) {
       $_SESSION['list_of_words'] = array();
    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get('/', function() use($app) {

        return $app['twig']->render('input_form.html.twig');
    });

    $app->post('/calc-score', function() use ($app) {
        $new_scrabble = new Scrabble($_POST['word']);
        $total_score = $new_scrabble->calculateWord($_POST['word']);

        return $app['twig']->render('view_score.html.twig', array('word' => $new_scrabble->getWord($_POST['word']), 'total_score' => $total_score));
    });

    return $app;
?>
