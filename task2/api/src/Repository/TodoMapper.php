<?php

namespace App\Repository;

use PDO;

class TodoMapper
{
	private $connection;
	private string $todoTable = 'todo';
	private string $userTable = 'user';

	public function __construct($db)
	{
		$this->connection = $db;
	}

	public function getAll($user)
	{
		$query = 'SELECT todo.id, description, is_complete FROM ' . $this->todoTable . ' INNER JOIN ' . $this->userTable . ' ON user = login WHERE login = :user';
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam('user', $user, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt;
	}

	public function add($user, string $description)
	{
		$query = 'INSERT INTO '. $this->todoTable . ' (description, user) VALUES (:description, :user)';
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam('description', $description, PDO::PARAM_STR);
		$stmt->bindParam('user', $user, PDO::PARAM_STR);
		$stmt->execute();
	}

	public function complete(int $id, bool $complete)
	{
		$query = 'UPDATE ' . $this->todoTable . ' SET is_complete=:complete WHERE id=:id';
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam('id', $id, PDO::PARAM_INT);
		$stmt->bindParam('complete', $complete, PDO::PARAM_BOOL);
		$stmt->execute();
	}

	public function delete(int $id)
	{
		$query = 'DELETE FROM ' . $this->todoTable . ' WHERE id=:id';
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam('id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}
}

