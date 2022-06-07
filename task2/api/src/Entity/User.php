<?php

namespace App\Entity;

class User
{
	private $id;
	private ?string $login;
	private ?string $password;

	public function __construct(string $login, string $password)
	{
		$this->login = $login;
		$this->password = $password;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getLogin(): ?string
	{
		return $this->login;
	}

	public function setLogin(string $login): self
	{
		$this->login = $login;

		return $this;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}
}
