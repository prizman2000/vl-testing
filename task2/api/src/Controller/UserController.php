<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;

class UserController
{
	private ?PDO $db;
	private UserRepository $mapper;

	public function __construct(?PDO $connection)
	{
		$this->db = $connection;
		$this->mapper = new UserRepository($this->db);
	}

	public function authenticate_user(string $login, string $password): bool|string
    {
		try {
			if ($login and $password) {
				$user = new User($login, $password);
				$res = $this->mapper->authenticate($user);
				if ($res->rowCount() && password_verify($password, $res->fetch()['password'])) {
					$secretKey = '02385gv2qw=]3e0c12-4=bn03n4=05ti0123i4dseq23';
					$issuedAt   = new DateTimeImmutable();
					$tokenData = [
						'iat'  => $issuedAt,
						'iss'  => 'vl-testing',
						'nbf'  => $issuedAt,
						'exp'  => $issuedAt->modify('+6 minutes')->getTimestamp(),
						'userName' => $user->getLogin(),
					];
					$jwt = JWT::encode($tokenData, $secretKey, 'HS512');
					return json_encode(
						array('token' => $jwt)
					);
				} else {
					return json_encode(
						array('error' => 'Invalid credentials')
					);
				}
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

	public function register_user(string $login, string $password): bool|string
    {
		try {
			if ($login and $password) {
				$user = new User($login, password_hash($password, PASSWORD_DEFAULT));
				$this->mapper->register($user);

				return json_encode(
					array('message' => 'Success registration')
				);
			} else {
				return json_encode(
					array('error' => 'Unprocessable entity')
				);
			}
		} catch (Exception $e) {
			return json_encode(
				array('error' => 'User with this login already exist')
			);
		}
	}

	public function logout_user(): bool|string
    {
		try {
			return json_encode(
				array('error' => 'Logged out successfully')
			);
		} catch (Exception $e) {
			return json_encode(
				array('error' => $e->getMessage())
			);
		}
	}

	public function login_check($matches): array
	{
		if (!$matches) {
			return
				array('error' => 'Token not found in request');
		} else {
			$jwt = $matches[1];
			if (!$jwt) {
				return
					array('error' => 'Token not found in request');
			} else {
				try {
					$secretKey  = '02385gv2qw=]3e0c12-4=bn03n4=05ti0123i4dseq23';
					$token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
					$now = new DateTimeImmutable();
					$serverName = 'vl-testing';
					if ($token->iss !== $serverName || $token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp()) {
						return array('error' => 'Unauthorized');
					}
					return array('success' => $token->userName);
				} catch (Exception $e) {
					return array('error' => $e->getMessage());
				}
			}
		}
	}
}
