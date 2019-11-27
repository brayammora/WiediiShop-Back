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
      if (isset($data['idReturns'])) {
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
           WHERE  idReturns = ? "
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

  public function SendMail($data)
  {
    try {
      $this->db = $this->db->start();
      $query = $this->db->prepare(
        " SELECT  prod.name as producto, purc.datePurchase as fechaCompra, retu.dateReturns as fechaDevolucion,
                  prod.price as precio, user.name as usuario, user.debt as total, retu.reason as reason
            FROM  returns retu
      INNER JOIN  purchase purc on (retu.idPurchase = purc.idPurchase)
      INNER JOIN  user on (purc.idUser = user.idUser)
      INNER JOIN  product prod on (purc.idProduct = prod.idProduct) 
           WHERE  purc.idUser = ? 
             AND  purc.state = 'DEVUELTO' 
        ORDER BY  purc.datePurchase desc, prod.name asc "
      );
      $query->execute(array($data['idUser']));
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      $debts = "";
      foreach ($result as $row) {
        $producto = $row["producto"];
        $fechaCompra = $row["fechaCompra"];
        $fechaDevolucion = $row["fechaDevolucion"];
        $precio = $row["precio"];
        $nombre = $row["usuario"];
        $motivo = $row['reason'];
        $total = $row['total'];

        $debts .= "<tr align='center'> 
                    <td width='20%'> $fechaCompra </td>
                    <td width='20%'> $fechaDevolucion </td>
                    <td width='20%'> $producto </td>  
                    <td width='20%' align='center'> $$precio </td> 
                    <td width='20%' align='left'> &nbsp;$motivo </td>
                  </tr>";
      }

      $subject = 'Reporte de devoluciones.';

      $mail = $this->sender->SendMail($data['mail'], $nombre, $debts, $subject, $total, "returns");
      $this->response->setResponse(true);
      $this->response->message = $mail;
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
