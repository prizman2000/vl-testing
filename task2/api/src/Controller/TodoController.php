<?php

namespace App\Controller;

use App\Entity\Database;
use App\Repository\TodoMapper;
use Exception;
use PDO;

class TodoController
{
	private ?PDO $db;
	private TodoMapper $mapper;
	private string $user;

	public function __construct()
	{
		$database = new Database();
		$this->db = $database->connect();
		$this->mapper = new TodoMapper($this->db);
	}

	public function set_user(string $username)
	{
		$this->user = $username;
	}

	public function get_all_todos()
	{
		try {
			$res = $this->mapper->getAll($this->user);

			if ($res->rowCount() > 0) {
				$todo_arr = array();
				$todo_arr['data'] = array();

				while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
					$todo_item = array(
						'id' => $row['id'],
						'description' => $row['description'],
						'is_complete' => $row['is_complete']
					);
					array_push($todo_arr['data'], $todo_item);
				}

				return json_encode($todo_arr);

			} else {
				return json_encode(
					array('message' => 'No todos found')
				);
			}
		} catch (Exception $e) {
			return json_encode(
				array('error' => $e->getMessage())
			);
		}
	}

	public function add_todo(string $description)
	{
		try {
			if ($description) {
				$this->mapper->add($this->user, $description);

				return json_encode(
					array('message' => 'Todo added successfully')
				);
			} else {
				return json_encode(
					array('error' => 'Unprocessable entity')
				);
			}
		} catch (Exception $e) {
			return json_encode(
				array('error' => $e->getMessage())
			);
		}
	}

	public function complete_todo(int $id, bool $complete)
	{
		try {
			if ($id) {
				$this->mapper->complete($id, $complete);

				return json_encode(
					array('message' => 'Todo marked as completed successfully')
				);
			} else {
				return json_encode(
					array('error' => 'Unprocessable entity')
				);
			}
		} catch (Exception $e) {
			return json_encode(
				array('error' => $e->getMessage())
			);
		}
	}

	public function delete_todo(int $id)
	{
		try {
			if ($id) {
				$this->mapper->delete($id);

				return json_encode(
					array('message' => 'Todo deleted successfully')
				);
			} else {
				return json_encode(
					array('error' => 'Unprocessable entity')
				);
			}
		} catch (Exception $e) {
			return json_encode(
				array('error' => $e->getMessage())
			);
		}
	}
}
