<?php
require_once "../component/autoLoad.php";
autoLoad(__FILE__);

class User
{
	private $dataBase;

	public function __construct()
	{
		try {
			$this->dataBase = new PDO(
				'mysql:host=jirldlijre.zzz.com.ua;dbname=esersdx',
				'esersdx',
				'DSHU@#BHBLdhfu32',
				[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
			);
		} catch (PDOException $e) {
			echo 'ошибка' . $e->getmessage();
		}
	}
	public function chechUser($login, $password)
	{
		$prepare = $this->dataBase->prepare("SELECT `id` FROM `user` WHERE `login` = :login AND `password` = :pass");
		$prepare->bindParam(':login', $login, PDO::PARAM_STR);
		$prepare->bindParam(':pass', $password, PDO::PARAM_STR);
		$prepare->execute();
		$result = $prepare->fetch(PDO::FETCH_ASSOC);
		if (count($result) == 1) return true;
		else return false;
	}
}
