<?php

class db {
    
  private $dbHost = 'localhost';
  private $dbName = 'WiediiShop';
	private $dbUser = 'root';
	private $dbPassword = 'root';

    public function start() {
        $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
        $dbConnection = new PDO($mysqlConnect, $this->dbUser, $this->dbPassword);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
	}
}
?>