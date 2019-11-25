<?php

class UserModel
{
  private $db;
  private $table = 'user';
  private $response;

  public function __CONSTRUCT()
  {
    $this->db = new db();
    $this->response = new Response();
  }

  public function GetAll()
  {
    try {
      $this->db = $this->db->start();
      $query = $this->db->prepare(
        " SELECT  idUser, name, document, mail, fingerprint, rol, password 
           FROM   $this->table "
      );
      $query->execute();

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "No hay ningún usuario agregado al sistema.";
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

  public function Get($id)
  {
    try {
      $this->db = $this->db->start();
      $query = $this->db->prepare(
        " SELECT  idUser, name, document, mail, fingerprint, rol, password 
            FROM  $this->table 
           WHERE  idUser = ? "
      );
      $query->execute(array($id));

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "Usuario no encontrado.";
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

  public function InsertOrUpdate($data)
  {
    try {
      $this->db = $this->db->start();

      if (isset($data['idUser'])) {
        $query = $this->db->prepare(
          " UPDATE  $this->table 
               SET  name = ?, 
                    document = ?, 
                    mail = ?, 
                    fingerprint = ?,
                    rol = ?,
                    password = ?
             WHERE  idUser = ? "
        );
        $query->execute(
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
        $this->response->setResponse(true, "Usuario modificado exitosamente.");
      } else {
        $query = $this->db->prepare(
          " INSERT 
              INTO  $this->table 
                    (name, document, mail, fingerprint, rol, password) 
            VALUES  (?, ?, ?, ?, ?, ?) "
        );
        $query->execute(
            array(
              $data['name'],
              $data['document'],
              $data['mail'],
              $data['fingerprint'],
              $data['rol'],
              $data['password']
            )
          );
        $this->response->setResponse(true, "Nuevo usuario creado.");
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

  public function Delete($id)
  {
    try {
      $this->db = $this->db->start();
      $query = $this->db->prepare(
        " DELETE 
            FROM  $this->table 
           WHERE  idUser = ? "
      );
      $query->execute(array($id));
      $this->response->setResponse(true);
      $this->response->message = "Usuario eliminado exitosamente.";
      //closing connections
      $query = null;
      $this->db = null;
      return $this->response;

    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }

  public function Login($data)
  {
    try {
      $finger = $data['finger'];
      if (!empty($finger)) {
        $this->db = $this->db->start();
        $query = $this->db->prepare(
          " SELECT  idUser, name, document, mail 
              FROM  user 
             WHERE  fingerprint = ? "
        );
        $query->execute(array($finger));

        if ($query->rowCount() > 0) {
          $this->response->setResponse(true);
          $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
          $this->response->setResponse(false, "Huella no identificada en el sistema.");
        }
        //closing connections
        $query = null;
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

  public function Logout()
  {
    try {
      $this->response->setResponse(true, "Sesión finalizada.");
      return $this->response;
      
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }
}
