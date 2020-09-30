<?php
require_once __DIR__ . "/../component/autoLoad.php";
autoLoad(__FILE__);

function getInfo($page, $sortName, $sortType)
{
	session_start();
	if (!is_int($page)) $page = 1;
	$managePost = new Post(DB_INFO);
	$result["page"] = ceil($managePost->countPost() / 3);
	$result["post"] = $managePost->getPost($page, $sortName, $sortType);
	$result['adminMod'] = !isset($_SESSION['adminMod']) ? 0 : ($_SESSION['adminMod'] ? 1 : 0);
	return $result;
}
