<?php
require_once __DIR__ . "/../component/autoLoad.php";
autoLoad(__FILE__);

class Post
{
	private $dataBase;

	public function __construct($dbInfo)
	{
		try {
			$this->dataBase = new PDO(
				'mysql:host=' . $dbInfo['host'] . ';dbname=' . $dbInfo['dbname'],
				$dbInfo['username'],
				$dbInfo['password'],
				[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
			);
		} catch (PDOException $e) {
			echo 'ошибка' . $e->getmessage();
		}
	}
	public function putPost($postData)
	{
		$postData['email'] = $this->escape_character($postData['email']);
		$postData['text'] = $this->escape_character($postData['text']);
		$postData['name'] = $this->escape_character($postData['name']);
		$prepare = $this->dataBase->prepare("INSERT INTO `post`(`name`, `email`, `text`) VALUES (:name,:email,:text)");
		if ($prepare->execute(["name" => $postData['name'], "email" => $postData['email'], "text" => $postData['text']])) return true;
		else return false;
	}
	public function countPost()
	{
		$prepare = $this->dataBase->prepare("SELECT id, COUNT(*) FROM post");
		$prepare->execute();
		return $prepare->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
	}
	public function getPost($page, $sortName, $sortType)
	{
		$sql = "";
		if ($sortName == 'name' || $sortName == "email" || $sortName == "status") {
			$sql = "SELECT `name`, `email`, `text`,`status`,`edit` FROM `post` ORDER BY `" . $sortName . "`";
		}
		if ($sortType == 0) $sql .= " ASC LIMIT :start,3";
		else $sql .= " DESC LIMIT :start,3";
		$page = ($page - 1) * 3;
		$prepare = $this->dataBase->prepare($sql);
		$prepare->bindParam(':start', $page, PDO::PARAM_INT);
		$prepare->execute();
		return $prepare->fetchAll(PDO::FETCH_ASSOC);
	}
	public function updatePost($postData)
	{
		$postData['text'] = $this->escape_character($postData['text']);
		$postData['name'] = $this->escape_character($postData['name']);
		//Проверяем был ли изменён текст
		$prepare = $this->dataBase->prepare('SELECT `text` FROM post WHERE `name` = :name');
		$prepare->execute(['name' => $postData['name']]);
		$text = $prepare->fetch(PDO::FETCH_ASSOC)['text'];

		$sql = "UPDATE `post` SET `text`= :text,`status`= :status";
		if ($text != $postData['text']) {
			$sql .= ", `edit` = 1";
		}

		$prepare = $this->dataBase->prepare($sql . " WHERE `name` = :name");
		$prepare->bindParam(':text', $postData['text'], PDO::PARAM_STR);
		$prepare->bindParam(':status', $postData['status'], PDO::PARAM_INT);
		$prepare->bindParam(':name', $postData['name'], PDO::PARAM_STR);
		if ($prepare->execute()) return true;
		else return false;
	}
	private function escape_character($str)
	{
		$str = preg_replace("~(\\\\)?<(\\\\)?~", "\<\\\\", $str);
		$str = preg_replace("~(\\\\)?>~", "\>", $str);
		return $str;
	}
}
