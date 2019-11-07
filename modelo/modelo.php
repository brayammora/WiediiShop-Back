<?php
class modelo {
	
	private $host = "localhost";
	private $user = "root";
	private $pw = "1234";
	private $db = "WiediiTienda";
	private $conexion;

	public function __construct(){
	}
	
	public function conectar(){
		$this->conexion = mysqli_connect($this->host, $this->user , $this->pw, $this->db) or die("Problemas al conectar al servidor.");
	}
	
	public function desconectar(){
		mysqli_close($this->conexion);
	}
	
	public function consultar($query){
		return mysqli_query( $this->conexion, $query );
	}
}