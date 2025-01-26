<?php

namespace ClassyPhp\Classy\Classes;

use PDO;
use PDOException;
use ClassyPhp\Classy\Classes\Config;

class Model {
	private $pdo;
	private $table;
	private $columns;

	public function __construct(string $table) {
		try {
			$this->table = $table;

			if (Config::get('db_driver') === 'sqlite') {
				$dsn = "sqlite:" . Config::get('db_path');
				$this->pdo = new PDO($dsn);
			} else {
				$host = Config::get('db_host');
				$dbname = Config::get('db_dbname');
				$username = Config::get('db_username');
				$password = Config::get('db_password');
				$dsn = "mysql:host=$host;dbname=$dbname";
				$this->pdo = new PDO($dsn, $username, $password);
			}

			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die("Database connection failed: " . $e->getMessage());
		}
	}

	public function setTable($table) {
		$this->table = $table;
	}

	public function setColumns($columns) {
		$this->columns = $columns;
	}

	public function create() {
		$columns = implode(", ", array_keys($this->columns));
		$placeholders = implode(", ", array_fill(0, count($this->columns), "?"));
		$sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(array_values($this->columns));
	}

	public function read(string $conditions = "", string $fields = "*") {
		$sql = "SELECT $fields FROM $this->table $conditions";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function query(string $sql, array $params = []) {
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function update(string $conditions) {
		$set = "";
		foreach ($this->columns as $column => $value) {
			$set .= "$column = ?, ";
		}
		$set = rtrim($set, ", ");
		$sql = "UPDATE $this->table SET $set $conditions";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(array_values($this->columns));
	}

	public function delete(string $conditions) {
		$sql = "DELETE FROM $this->table $conditions";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute();
	}
}
