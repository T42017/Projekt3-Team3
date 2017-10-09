<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	</head>
	<body>
    
<?php

	require __DIR__ . '/vendor/autoload.php';
	$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
	$twig = new Twig_Environment($loader, array('cache' => __DIR__ . '/cache', 'debug' => true));
	$pdo = new PDO('mysql:host=localhost;dbname=trälleborg;charset=utf8mb4', 'root', '');
	$stmt = $pdo->query('SELECT * FROM books');

 while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {   
    $book[] = array(
        'title'=> $row["title"],
        'ISBN'=> $row["ISBN"],
        'author'=> $row["author"],
        'category'=> $row["category"],
        'release_date'=> $row["release_date"],
    	'publisher'=> $row["publisher"],
    	'language' => $row["language"]
    );
	}
	
	echo $twig->render('site.twig', array('books' => $book));
?>