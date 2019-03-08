<?php
  class User{
    public function getDetails($user, $db){
      $qry = $db->prepare("SELECT * FROM users WHERE uid = :uid LIMIT 1");
      $qry->execute([':uid'=>$user]);
      $res = $qry->fetch(PDO::FETCH_ASSOC);
      return [$res['username'], $res['firstname'], $res['lastname'],$res['email'], $res['hostel'], $res['contactdet'], $res['rating'], $res['soldno'], $res['img']];
    }

  }
 ?>
