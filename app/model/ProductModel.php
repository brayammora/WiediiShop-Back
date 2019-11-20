<?php

class ProductModel
{
  private $db;
  private $table = 'product';
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
      $query = $this->db->prepare("SELECT * FROM $this->table");
      $query->execute();

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "There is no product created in the system.";
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
      $query = $this->db->prepare("SELECT * FROM $this->table WHERE idProduct = ?");
      $query->execute(array($id));

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "Product not found.";
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

      if (isset($data['idProduct'])) {
        $sql = "UPDATE $this->table SET 
        name            = ?, 
        price           = ?, 
        barcode         = ?
        WHERE idProduct = ?";

        $query = $this->db->prepare($sql);
        $query->execute(
          array(
            $data['name'],
            $data['price'],
            $data['barcode']
          )
        );
        $this->response->setResponse(true, "Product successfully modified.");
      } else {
        $sql = "INSERT INTO $this->table 
        (name, price, barcode) 
        VALUES (?, ?, ?)";

        $this->db->prepare($sql)
          ->execute(
            array(
              $data['name'],
              $data['price'],
              $data['barcode']
            )
          );
        $this->response->setResponse(true, "New product created.");
      }

      //closing connections
      $query = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
    }
  }

  public function Delete($id)
  {
    try {
      $this->db = $this->db->start();
      $query = $this->db
        ->prepare("DELETE FROM $this->table WHERE idProduct = ?");

      $query->execute(array($id));
      $this->response->setResponse(true);
      $this->response->message = "Product successfully removed.";
      //closing connections
      $query = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
    }
  }

  public function GetByBarcode($id)
  {
    try {
      if (isset($id) && !empty($id)) {
        $this->db = $this->db->start();

        $query = $this->db->prepare("SELECT * FROM $this->table WHERE barcode = ?");
        $query->execute(array(trim($id)));

        if ($query->rowCount() > 0) {
          $this->response->setResponse(true);
          $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
          $this->response->message = "Producto no encontrado.";
        }

        //closing connections
        $query = null;
        $this->db = null;
      } else {
        $this->response->setResponse(false, "Codigo de barras incorrecto.");
      }

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }
}
