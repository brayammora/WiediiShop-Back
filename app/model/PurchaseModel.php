<?php

class PurchaseModel
{
  private $db;
  private $table = 'purchase';
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
      $query = $this->db->prepare("SELECT * FROM $this->table");
      $query->execute();

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "There is no purchase created in the system.";
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
      $query = $this->db->prepare("SELECT * FROM $this->table WHERE idPurchase = ?");
      $query->execute(array($id));

      if ($query->rowCount() > 0) {
        $this->response->setResponse(true);
        $this->response->result = $query->fetchAll(PDO::FETCH_OBJ);
      } else {
        $this->response->message = "Purchase not found.";
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
    $user = $data['user'];
    $products = $data['products'];

    try {
      $this->db = $this->db->start();
      $query = null;

      if (isset($data['idPurchase'])) {
        $sql = "UPDATE $this->table SET 
        idProduct         = ?, 
        idUser            = ?, 
        datePurchase      = ?,
        datePayment       = ?,
        state             = ?
        WHERE idPurchase  = ?";

        $query = $this->db->prepare($sql);
        $query->execute(
          array(
            $data['idProduct'],
            $data['idUser'],
            $data['datePurchase'],
            $data['datePayment'],
            $data['state']
          )
        );
        $this->response->setResponse(true, "Purchase successfully modified.");
      } else {

        foreach ($products as $product) {
          $sql = "INSERT INTO $this->table 
          (idProduct, idUser, datePurchase, datePayment, state) 
          VALUES (?, ?, ?, ?, ?)";

          $query = $this->db->prepare($sql);
          $query->execute(
            array(
              $product['idProduct'],
              $user,
              date('Y-m-d H:i:s'),
              null,
              'UNPAID'
            )
          );
          $this->response->setResponse(true, "Purchase successfully created. Check your mail.");
        }
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
        ->prepare("DELETE FROM $this->table WHERE idPurchase = ?");

      $query->execute(array($id));
      $this->response->setResponse(true);
      $this->response->message = "Purchase successfully removed.";
      //closing connections
      $query = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
    }
  }

  public function SendMail($data)
  {
    try {
      $this->db = $this->db->start();
      $query = $this->db
        ->prepare("SELECT * FROM $this->table WHERE idUser = ? and state = 'UNPAID' order by datePurchase desc");

      $query->execute(array($data['idUser']));
      $debts = $query->fetchAll(PDO::FETCH_OBJ);
      $mail = $this->sender->SendMail($data['mail'], $debts);

      $this->response->setResponse(true);
      $this->response->message = $mail;
      //closing connections
      $query = null;
      $this->db = null;

      return $this->response;
    } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
    }
  }
}
