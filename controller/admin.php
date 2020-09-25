<?php
require_once __DIR__ . "/../component/autoLoad.php";
autoLoad(__FILE__);

$updPost = new Post();
$postData = [
	"name" => $_POST['name'],
	"text" => $_POST["text"]
];
if (strlen($postData['text']) <= 1000 && strlen($postData['text']) >= 1) {
	if (isset($_POST['st']) && $_POST['st'] != '0') $postData['st'] = 1;
	else $postData['st'] = 0;
	if ($updPost->updatePost($postData)) echo "<h1>Запись обнавлена<h1>";
	else echo "<h1>Запись не обнавлена<h1>";
}
else echo "<h1>Запись не обнавлена<h1>";
