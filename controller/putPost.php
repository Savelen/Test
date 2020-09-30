<?php
require_once "../component/autoLoad.php";
autoLoad(__FILE__);

$postData = [
	"name" => $_POST['name'],
	"email" => $_POST["email"],
	"text" => $_POST["text"]
];

if (strlen($postData['name']) <= 30 && strlen($postData['name']) >= 3 && strlen($postData['email']) <= 100 && strlen($postData['text']) <= 1000 && strlen($postData['text']) >= 1 && preg_match("~.*?@.*?\..*?~", $postData['email'])) {
	$newPost = new Post(DB_INFO);

	try {
		if ($newPost->putPost($postData)) echo "<h1>Запись добавленна<h1>";
		else echo "<h1>Запись не добавленна<h1>";
	} catch (Exception $e) {
		echo "<h1>Запись не добавленна<h1>";
	}
} else echo "<h1>Запись не добавленна<h1>";
