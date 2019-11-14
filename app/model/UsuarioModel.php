<?php

class UsuarioModel {
  private $db;
  private $table = 'usuario';
  private $response;

  public function __CONSTRUCT() {
    $this->db = new db();
    $this->response = new respuesta();
  }

  public function GetAll() {
    try {
      $this->db = $this->db->conectar();
      $consulta = $this->db->prepare("SELECT * FROM $this->table");
      $consulta->execute();

      if ($consulta->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $consulta->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "No existe ningún usuario.";
      }

      //cierro conexiones
      $consulta = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }

  public function Get($id) {
    try {
      $this->db = $this->db->conectar();
      $consulta = $this->db->prepare("SELECT * FROM $this->table WHERE idUsuario = ?");
      $consulta->execute(array($id));

      if ($consulta->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $consulta->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "No existe el usuario.";
      }

      //cierro conexiones
      $consulta = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }

  public function InsertOrUpdate($data) {
    try {
      $this->db = $this->db->conectar();

      if (isset($data['idUsuario'])) {
        $sql = "UPDATE $this->table SET 
        nombre          = ?, 
        cedula          = ?, 
        correo          = ?, 
        huellaDactilar  = ?,
        rol             = ?,
        contrasena      = ?
        WHERE idUsuario = ?";

        $consulta = $this->db->prepare($sql);
        $consulta ->execute(
          array(
            $data['nombre'],
            $data['cedula'],
            $data['correo'],
            $data['huellaDactilar'],
            $data['rol'],
            $data['contrasena'],
            $data['idUsuario']
          )
          );
        $this->response->setResponse(true, "Usuario modificado.");
      } else {
        $sql = "INSERT INTO $this->table 
        (nombre, cedula, correo, huellaDactilar, rol, contrasena) 
        VALUES (?, ?, ?, ?, ?, ?)";

        $this->db->prepare($sql)
          ->execute(
            array(
              $data['nombre'],
              $data['cedula'],
              $data['correo'],
              $data['huellaDactilar'],
              $data['rol'],
              $data['contrasena']
            )
          );
        $this->response->setResponse(true, "Nuevo usuario guardado.");
      }

      //cierro conexiones
      $consulta = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
    }
  }

  public function Delete($id) {
    try {
      $this->db = $this->db->conectar();
      $consulta = $this->db
        ->prepare("DELETE FROM $this->table WHERE idUsuario = ?");

      $consulta->execute(array($id));
      $this->response->setResponse(true);
      $this->response->message = "Usuario eliminado.";
      //cierro conexiones
      $consulta = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
    }
  }

  public function Login($data) {
    try {
      $huella = $data['huella'];
      if (!empty($huella)) {
        $this->db = $this->db->conectar();
        $consulta = $this->db->prepare("SELECT idUsuario, nombre, cedula FROM usuario where huellaDactilar = ?");
        $consulta->execute(array($huella));

        if ($consulta->rowCount() > 0) {
          $this->response->setResponse(true);
          $this->response->result = $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
          $this->response->message = "Huella no identificada.";
        }

        //cierro conexiones
        $consulta = null;
        $this->db = null;
      } else {
        $this->response->setResponse(false, "¡Campo vacio! Intente de nuevo.");
      }

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }
}
