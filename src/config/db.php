<?php

class db{
    
    private $dbHost = 'localhost';
    private $dbName = 'WiediiTienda';
	private $dbUser = 'root';
	private $dbPassword = 'root';

    public function conectar(){
        $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
        $dbConnection = new PDO($mysqlConnect, $this->dbUser, $this->dbPassword);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
	}
}