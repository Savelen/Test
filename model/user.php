<?php
require_once "../component/autoLoad.php";
autoLoad(__FILE__);

class User
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
	public function chechUser($login, $password)
	{
		try {
			// достаём из бд (если есть) инфу о пользователе
			$pre = $this->dataBase->prepare('SELECT `password` FROM user WHERE `login` = :login');
			$pre->execute([":login" => $login]);
			$response = $pre->fetch(PDO::FETCH_ASSOC);
			if (password_verify($password, $response['password'])) {
				session_start();
				$_SESSION['login'] = $login;
				$_SESSION['adminMod'] = true;
				return true;
			} else return false;
		} catch (Exception $e) {
			return false;
		}
	}
}
