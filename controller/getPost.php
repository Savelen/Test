<?php
require_once __DIR__ . "/../component/autoLoad.php";
autoLoad(__FILE__);

function getInfo($page, $sortName, $sortType)
{
	if (!is_int($page)) $page = 1;
	$managePost = new Post();
	$result["page"] = ceil($managePost->countPost() / 3);
	$result["post"] = $managePost->getPost($page, $sortName, $sortType);
	return $result;
}
