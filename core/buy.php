<?php
  require 'dbconnect.php';
  require 'userdet.php';
  $lid = $_POST['lid'];
  $bid = $_POST['buyer'];
  $b = new User;
  $buyerdet = $b->getDetails($bid, $db);
  $qry = $db->prepare("SELECT * FROM listings WHERE lid = :lid");
  $qry->execute([':lid'=>$lid]);
  $res = $qry->fetch(PDO::FETCH_ASSOC);
  if(strcmp(substr($res['sid'],0,27),substr($bid,0,27)) == 0){
    echo("same");
  }else{
    $qry = $db->prepare("UPDATE listings SET buyer = :buyer, status = :stat, bid = :bid WHERE lid = :lid");
    $qry->execute([
      ':buyer'=>$buyerdet[0],
      ':stat'=>"purchased",
      ':bid'=>$bid,
      ':lid'=>$lid
    ]);
    $qry2 = $db->prepare("SELECT * FROM listings WHERE lid = :lid");
    $qry2->execute([':lid'=>$lid]);
    $res2 = $qry2->fetch(PDO::FETCH_ASSOC);
    $sid = $res2['sid'] ;
    $qry2 = $db->prepare("SELECT * FROM users WHERE uid = :uid LIMIT 1");
    $qry2->execute([':uid'=>$sid]);
    $res2 = $qry2->fetch(PDO::FETCH_ASSOC);
    $soldnoup = 1+$res2['soldno'];
    $qry2 = $db->prepare("UPDATE users SET soldno = :soldno WHERE uid = :uid");
    $qry2->execute([
      ':soldno'=>$soldnoup,
      ':uid'=>$sid
    ]);
    echo("done");
  }
 ?>
