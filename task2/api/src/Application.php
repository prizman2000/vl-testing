<?php

namespace App;

use App\Controller\TodoController;
use App\Controller\UserController;

class Application
{
	private UserController $user_controller;
	private TodoController $todo_controller;

	public function __construct()
	{
		$this->user_controller = new UserController();
		$this->todo_controller = new TodoController();
	}

	public function run($request)
	{
		if ($request['request_params']['entity'] == 'post') {
			preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches);
			if ($this->user_controller->login_check($matches)['success']) {
				$this->todo_controller->set_user($this->user_controller->login_check($matches)['success']);
				if ($request['request_params']['action'] == 'get') {
					echo $this->todo_controller->get_all_todos();
				} elseif ($request['request_params']['action'] == 'add') {
					echo $this->todo_controller->add_todo($request['request_body']['description']);
				} elseif ($request['request_params']['action'] == 'complete') {
					echo $this->todo_controller->complete_todo($request['request_body']['id'], $request['request_body']['complete']);
				} elseif ($request['request_params']['action'] == 'delete') {
					echo $this->todo_controller->delete_todo($request['request_body']['id']);
				}
			} else {
				echo json_encode($this->user_controller->login_check($matches));
			}
		} elseif ($request['request_params']['entity'] == 'user') {
			if ($request['request_params']['action'] == 'register') {
				echo $this->user_controller->register_user($request['request_body']['login'], $request['request_body']['password']);
			} elseif ($request['request_params']['action'] == 'authenticate') {
				echo $this->user_controller->authenticate_user($request['request_body']['login'], $request['request_body']['password']);
			} elseif ($request['request_params']['action'] == 'logout') {
				echo $this->user_controller->logout_user();
			}
		}
	}
}
