<?php
$subpages = array(
	'blank' => array(
		'file' => 'blank.php',
		'override' => false
	),
	'houses' => array(
		'file' => 'houses.php',
		'override' => false
	),
	'news' => array(
		'file' => 'index.php',
		'override' => false
	),
        'login' => array(
                'file' => "".$_GET['page'].".php",
                'override' => false
        ),
        'recover' => array(
                'file' => "".$_GET['page'].".php",
                'override' => false
        ),
        'charactersearch' => array(
                'file' => "".$_GET['page'].".php",
                'override' => false
        ),
        'highscore' => array(
                'file' => "".$_GET['page'].".php",
                'override' => false
        ),
        'loggedin' => array(
                'file' => "".$_GET['page'].".php",
                'override' => false
        ),
);
?>
