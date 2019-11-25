<?php

class ReturnModel
{
  private $db;
  private $table = "returns";
  private $response;
  private $sender;

  public function __CONSTRUCT()
  {
    $this->db = new db();
    $this->response = new Response();
    $this->sender = new mail();
  }

  public function GetAll()
  {
    try {
      $this->db = $this->db->start();
      $query = $this->db->prepare(
        " SELECT  idReturns, idPurchase, dateReturns, reason
            FROM  $this->table "
      );
      $query->execute();

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "No hay ninguna devolución creada en el sistema.";
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
        " SELECT  idReturns, idPurchase, dateReturns, reason
            FROM  $this->table 
           WHERE  idReturn = ? "
      );
      $query->execute(array($id));

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "Devolución no encontrada.";
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
    $idPurchase = $data['idPurchase'];
    $reason = $data['reason'];
    try {
      $this->db = $this->db->start();
      $query = null;
      if (isset($data['idReturn'])) {
        $query = $this->db->prepare(
          " UPDATE  $this->table 
               SET  idPurchase = ?, 
                    dateReturns = ?, 
                    reason = ?
             WHERE  idReturns = ? "
        );
        $query->execute(
          array(
            $data['idPurchase'],
            $data['dateReturns'],
            $data['reason'],
            $data['idReturns'],
          )
        );
        $this->response->setResponse(true, "Purchase successfully modified.");
      } else {
        $query = $this->db->prepare(
          " INSERT INTO $this->table (idPurchase, dateReturns, reason) VALUES (?, ?, ?)"
        );
        $query->execute(
          array(
            $idPurchase,
            date('Y-m-d H:i:s'),
            $reason
          )
        );

        $this->response->setResponse(true, "¡Devolución realizada exitosamente! Revisa tu correo.");
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
           WHERE  idReturn = ? "
      );
      $query->execute(array($id));
      $this->response->setResponse(true);
      $this->response->message = "Devolución eliminada exitosamente.";
      //closing connections
      $query = null;
      $this->db = null;
      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
    }
  }
}
