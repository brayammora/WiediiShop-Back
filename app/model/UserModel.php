<?php

class UserModel {
  private $db;
  private $table = 'user';
  private $response;

  public function __CONSTRUCT() {
    $this->db = new db();
    $this->response = new response();
  }

  public function GetAll() {
    try {
      $this->db = $this->db->start();
      $query = $this->db->prepare("SELECT * FROM $this->table");
      $query->execute();

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "There is no user created in the system.";
      }

      //closing connections
      $query = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }

  public function Get($id) {
    try {
      $this->db = $this->db->start();
      $query = $this->db->prepare("SELECT * FROM $this->table WHERE idUser = ?");
      $query->execute(array($id));

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "User not found.";
      }

      //closing connections
      $query = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }

  public function InsertOrUpdate($data) {
    try {
      $this->db = $this->db->start();

      if (isset($data['idUser'])) {
        $sql = "UPDATE $this->table SET 
        name          = ?, 
        document          = ?, 
        mail          = ?, 
        fingerprint  = ?,
        rol             = ?,
        password      = ?
        WHERE idUser = ?";

        $query = $this->db->prepare($sql);
        $query ->execute(
          array(
            $data['name'],
            $data['document'],
            $data['mail'],
            $data['fingerprint'],
            $data['rol'],
            $data['password'],
            $data['idUser']
          )
          );
        $this->response->setResponse(true, "User successfully modified.");
      } else {
        $sql = "INSERT INTO $this->table 
        (name, document, mail, fingerprint, rol, password) 
        VALUES (?, ?, ?, ?, ?, ?)";

        $this->db->prepare($sql)
          ->execute(
            array(
              $data['name'],
              $data['document'],
              $data['mail'],
              $data['fingerprint'],
              $data['rol'],
              $data['password']
            )
          );
        $this->response->setResponse(true, "New user created.");
      }

      //closing connections
      $query = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
    }
  }

  public function Delete($id) {
    try {
      $this->db = $this->db->start();
      $query = $this->db
        ->prepare("DELETE FROM $this->table WHERE idUser = ?");

      $query->execute(array($id));
      $this->response->setResponse(true);
      $this->response->message = "User successfully removed.";
      //closing connections
      $query = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
    }
  }

  public function Login($data) {
    try {
      $fingerprint = $data['fingerprint'];
      if (!empty($fingerprint)) {
        $this->db = $this->db->start();
        $query = $this->db->prepare("SELECT idUser, name, document FROM user where fingerprint = ?");
        $query->execute(array($fingerprint));

        if ($query->rowCount() > 0) {
          $this->response->setResponse(true);
          $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
          $this->response->message = "Fingerprint not identified in the system.";
        }

        //closing connections
        $query = null;
        $this->db = null;
      } else {
        $this->response->setResponse(false, "Empty field! Try again.");
      }

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }

  public function Logout() {
    try {    
      $this->response->setResponse(true, "Session finished.");
      return $this->response;

    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }
}
