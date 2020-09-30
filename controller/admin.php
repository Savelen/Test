<?php
require_once __DIR__ . "/../component/autoLoad.php";
autoLoad(__FILE__);

session_start();

if ($_SESSION['adminMod'] == 1) {
	$updPost = new Post(DB_INFO);
	$postData = [
		"name" => $_POST['name'],
		"text" => $_POST["text"]
	];
	if (strlen($postData['text']) <= 1000 && strlen($postData['text']) >= 1) {
		if (isset($_POST['status']) && $_POST['status'] != '0') $postData['status'] = 1;
		else $postData['status'] = 0;
		if ($updPost->updatePost($postData)) echo "<h1>Запись обнавлена<h1>";
		else echo "<h1>Запись не обнавлена<h1>";
	} else echo "<h1>Запись не обнавлена<h1>";
} else echo "<h1>Запись не обнавлена<h1>";
