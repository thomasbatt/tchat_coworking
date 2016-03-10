<?php
class UserManager
{
	// Déclarer les propriétés
	private $db;

	// Constructeur
	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

	public function getByLogin($login)
	{
		var_dump($login);
		$login = $this->db->quote($login);
		var_dump($login);
		$query = "SELECT * FROM user WHERE login_user=".$login;
		var_dump($query);
		$res = $this->db->query($query);
		var_dump($res);
		if ($res)
		{
			$user = $res->fetchObject("User");
			if ($user)
				return $user;
			else
				throw new Exception("Login incorrect");
		}
		else
			throw new Exception("Erreur interne");
	}

	public function getById($id)
	{
		$id = intval($id);
		$query = "SELECT * FROM user WHERE id_user=".$id;
		$res = $this->db->query($query);
		if ($res)
		{
			$user = $res->fetchObject("User");
			if ($user)
				return $user;
			else
				throw new Exception("id incorrect");
		}
		else
			throw new Exception("Erreur interne");
	}

	public function create($login, $pass1, $pass2)
	{
		$user = new User();
		$user->setLogin($login);
		$user->initPassword($pass1, $pass2);
		$login = $this->db->quote($user->getLogin());
		$hash = $this->db->quote($user->getHash());
		$query = "INSERT INTO user (login_user, hash_user) VALUES(".$login.",".$hash.")";
		try
		{
			$res = $this->db->exec($query);
		}
		catch (Exception $e)
		{
			throw new Exception("Erreur interne");
		}
		return $this->getByLogin($user->getLogin());
	}

 	public function getAll()
 	{
 		$query = "SELECT * FROM user ORDER BY update_user DESC, login_user ASC";
 		$res = $this->db->query($query);
 		try
		{
 			while ( $user = $res->fetchObject("User") )
				$users [] = $user;
			return $users;
		}
		catch (Exception $e)
		{
			throw new Exception("Erreur interne");
		}
 	}

 	public function isConnected($id)
 	{
 		$idVerif = intval($id);
 		$query = "SELECT login_user FROM user WHERE update_user > CURRENT_TIMESTAMP - 10 AND id_user = '".$idVerif."'";
 		$res = $this->db->query($query);
 		$count = $res->rowCount();
 		if ($count == 0) 
 			return FALSE;
 		else
 			return TRUE;
 	}

 	public function editDateConnected($id)
 	{
 		$time = time();
 		$query = "UPDATE user SET update_user=CURRENT_TIMESTAMP WHERE id_user = '".$id."'";
 		$res = $this->db->exec($query);
 	}

}
?>