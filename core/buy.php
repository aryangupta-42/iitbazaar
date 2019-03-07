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
    echo("done");
  }
 ?>
