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
  $_SESSION['loc'] = "Admin";
  $user = new User;
  $userdet = $user->getDetails($_SESSION['user'], $db);

  $qry = $db->prepare("SELECT * FROM listings WHERE status = :status ORDER BY publishdate DESC");
  $qry->execute([':status'=>"active"]);
  // echo(count($res));


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <?php require '../ui/includes.php'; ?>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/home.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="listingcont1">
      <?php
      while($res = $qry->fetch(PDO::FETCH_ASSOC)){
        if(count($res)== 0){
          echo("no posts");
        }else{
          echo("
          <div class='listingcard' style='background-image:url(../img/listings/".$res['lid'].".jpg)'>
            <div class='listingdet'>
              <div class='listingtextcont'>
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
            <div class="listingdetcardseller">
              <b>Seller:</b> <span></span>
            </div>
            <button class="btn" id="buynowbtn">
              Buy Now
            </button>
            <div class="error">
              <!-- You Cannot purchase your own item. -->
            </div>
          </div>
        </div>
      </div>
    </div>





    <?php require '../ui/header.php'; require '../ui/sideoverlay.php'; ?>
  </body>
</html>
