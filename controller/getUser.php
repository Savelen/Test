<?php
require_once __DIR__ . "/../component/autoLoad.php";
autoLoad(__FILE__);

$check = new User();
if ($check->chechUser($_GET['login'],$_GET["password"])){
	header("location: ../index.php?page=1&sort_name=name&sort_type=asc&admin=1");
}
else {
	header("location: ../index.php?page=1&sort_name=name&sort_type=asc&admin=0");
}
