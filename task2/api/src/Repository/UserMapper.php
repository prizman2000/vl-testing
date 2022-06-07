<?php

namespace App\Repository;

use App\Entity\User;
use PDO;

class UserMapper
{
	private $connection;
	private string $table = 'user';

	public function __construct($db)
	{
		$this->connection = $db;
	}

	public function authenticate(User $user)
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE login=:login';
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam('login', $user->getLogin(), PDO::PARAM_STR);
		$stmt->execute();
		return $stmt;
	}

	public function register(User $user)
	{
		$query = 'INSERT INTO ' . $this->table . ' (login, password) VALUES (:login, :password)';
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam('login', $user->getLogin(), PDO::PARAM_STR);
		$stmt->bindParam('password', $user->getPassword(), PDO::PARAM_STR);
		$stmt->execute();
	}
}
