<?php
  require '../core/dbconnect.php';
  require '../core/userdet.php';
  session_start();
  if(isset($_POST['logoutbtn'])){
    session_unset();
    session_destroy();
    header("Location: ../index.php");
  }
  if(!isset($_SESSION['user'])){
    header('Location: ../index.php');
    session_write_close();
  }
  $_SESSION['loc'] = "purchases";
  $user = new User;
  $userdet = $user->getDetails($_SESSION['user'], $db);

  $qry = $db->prepare("SELECT * FROM listings WHERE status = :status AND bid = :bid ORDER BY publishdate DESC");
  $qry->execute([':status'=>"purchased", ':bid'=>$_SESSION['user']]);
  // echo(count($res));


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <?php require '../ui/includes.php'; ?>
    <script src="../js/purchase.js" charset="utf-8"></script>
    <link rel="stylesheet" href="../css/purchase.css">
  </head>
  <body>
    <div class="listingcont">
      <?php
      while($res = $qry->fetch(PDO::FETCH_ASSOC)){
        if(count($res)== 0){
          echo("no posts");
        }else{
          $qry2 = $db->prepare("SELECT * FROM users WHERE uid = :uid LIMIT 1");
          $qry2->execute([':uid'=>$res['sid']]);
          $sellerdet = $qry2->fetch(PDO::FETCH_ASSOC);
          echo("
          <div class='listingcard' style='background-image:url(../img/listings/".$res['lid'].".jpg)'>
            <div class='listingdet'>
              <div class='listingtextcont'>
              <div class='sellername' style='display:none'>"
                .$sellerdet['firstname']." ".$sellerdet['lastname'].
              "</div>
              <div class='sellercon' style='display:none'>"
                .$sellerdet['contactdet'].
              "</div>
                <div class='itemname'>"
                  .$res['name'].
                "</div>
                <div class='lid' style='display:none'>"
                  .$res['lid'].
                "</div>
                <div class='itemdesc'>"
                  .substr($res['description'],0,150).
                "</div>
                <div class='itemdescfull' style='display:none'>"
                  .$res['description'].
                "</div>
                <div class='itemprice'><b>INR:</b> <span>"
                  .$res['price'].
                "</span></div>
                <div class='seller'><b>Seller:</b> <span>"
                  .$res['seller'].
                "</span>
                </div>
                <div class='pickuplocation' style='display:none'>"
                  .$res['pickup'].
                "</div>
              </div>
            </div>
          </div>");
          // echo($res['name']);
        }
      }
       ?>

    </div>
  <!-- listing overlay full details -->
    <div class="listingdetdispoverlay">
      <div class="listingdetcard">
        <div class="closebtn">

        </div>
        <div class="listingdetcardcont">
          <div class="listingdetcardimg">

          </div>
          <div class="listingdetcarddet">
            <div class="listingdetcardname">
            </div>
            <div class="listingdetcarddesc">
            </div>
            <div class="listingdetcardprice">
              <b>INR:</b> <span></span>
            </div>
            <div class="listingdetcardpickup">
              <b>Item Pickup Location:</b> <span></span>
            </div>
            <div class="listingdetcardsellerinfo">
              <div class="listingdetcardseller">
                <b>Seller:</b> <span></span>
              </div>
              <div class="listingdetcardsellername">
                <b>Seller Name:</b> <span></span>
              </div>
              <div class="listingdetcardsellercontact">
                <b>Seller Contact Number: </b><span></span>
              </div>
            </div>
            <div class="error">
              The seller should be getting in touch with you shortly. However if that does not happen, feel free to use the above contact details to reach out to the seller.
            </div>
          </div>
        </div>
      </div>
    </div>





    <?php require '../ui/header.php'; require '../ui/sideoverlay.php'; ?>
  </body>
</html>
