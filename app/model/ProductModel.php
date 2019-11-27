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
      $query = $this->db->prepare(
        " SELECT  idProduct, name, price, barcode 
            FROM  $this->table "
      );
      $query->execute();

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "No hay ningún producto agregado al sistema.";
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
        " SELECT  idProduct, name, price, barcode 
            FROM  $this->table 
           WHERE  idProduct = ? "
      );
      $query->execute(array($id));

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "Producto no encontrado.";
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
        $query = $this->db->prepare(
          " UPDATE  $this->table 
               SET  name = ?, 
                    price = ?, 
                    barcode = ?
             WHERE  idProduct = ? "
        );
        $query->execute(
          array(
            $data['name'],
            $data['price'],
            $data['barcode']
          )
        );
        $this->response->setResponse(true, "Producto modificado exitosamente.");
      } else {
        $query = $this->db->prepare(
          " INSERT  
              INTO  $this->table 
                    (name, price, barcode) 
            VALUES  (?, ?, ?) "
        );
        $query->execute(
          array(
            $data['name'],
            $data['price'],
            $data['barcode']
          )
        );
        $this->response->setResponse(true, "Nuevo producto agregado.");
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
           WHERE  idProduct = ? "
      );
      $query->execute(array($id));
      $this->response->setResponse(true);
      $this->response->message = "Producto eliminado exitosamente.";
      //closing connections
      $query = null;
      $this->db = null;
      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }

  public function GetByBarcode($id)
  {
    try {
      if (isset($id) && !empty($id)) {
        $this->db = $this->db->start();
        $query = $this->db->prepare(
          " SELECT  idProduct, name, price, barcode
              FROM  $this->table 
             WHERE  barcode = ? "
        );
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
