<?php
namespace Shaun\LightflowsSuchcloudSdk;

use PDO;

final class Db
{
	public PDO $dbInstance;

	public function __construct($dbFilePath = ':memory:') {
		if (empty($this->dbInstance)) {
			$this->dbInstance = new PDO("sqlite:$dbFilePath");
			$this->createTables();
		}
	}

	private function createTables(): void
	{
		$this->dbInstance->exec("CREATE TABLE IF NOT EXISTS documents (
             id INTEGER PRIMARY KEY AUTOINCREMENT,
    		api_key VARCHAR(255) NOT NULL,
    		uuid CHAR(36) NOT NULL,
    		title VARCHAR(255) NOT NULL,
    		slug VARCHAR(255) NOT NULL,
    		contents BLOB,
    		UNIQUE(api_key, slug)
        )");
	}

	public function getInstance(): PDO
	{
		return $this->dbInstance;
	}
}
