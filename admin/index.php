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
  }else if(!isset($_SESSION['admin'])){
    header('location: ../home/index.php');
    session_write_close();
  }
  $_SESSION['loc'] = "Admin";
  $user = new User;
  $userdet = $user->getDetails($_SESSION['user'], $db);

  $qry = $db->prepare("SELECT * FROM listings WHERE status = :status ORDER BY publishdate DESC");
  $qry->execute([':status'=>"active"]);
  $qry2 = $db->prepare("SELECT * FROM listings WHERE status = :status ORDER BY publishdate DESC");
  $qry2->execute([':status'=>"blocked"]);
  $qry3 = $db->prepare("SELECT * FROM listings WHERE status = :status ORDER BY publishdate DESC");
  $qry3->execute([':status'=>"purchased"]);
  // echo(count($res));

  if(isset($_POST['actbtn'])){
    $lid = $_POST['lid'];
    $sqry = $db->prepare("SELECT * FROM listings WHERE lid = :lid LIMIT 1");
    $sqry->execute([':lid'=>$lid]);
    $sres = $sqry->fetch(PDO::FETCH_ASSOC);
    $newstatus = "";
    if($sres['status'] == "blocked"){
      $newstatus = "active";
    }else{
      $newstatus = "blocked";
    }
    $uqry = $db->prepare("UPDATE listings SET status = :status WHERE lid = :lid");
    $uqry->execute([':status'=>$newstatus, ':lid'=>$lid]);
    header("location: ../home");
  }

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
    <script type="text/javascript">
      $(document).ready(function(){
        // alert("scroll down to see blocked listings")
      })
    </script>
    <!-- <script src="../js/admin.js" charset="utf-8"></script> -->
  </head>
  <body>
    <div class="listingcont1">
      <div class="listingconttitle">
        Active listings
      </div>
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
    <div class="listingcont2">
      <div class="listingconttitle">
        Blocked listings
      </div>
      <?php
      while($res = $qry2->fetch(PDO::FETCH_ASSOC)){
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
            <form class="" action="#" method="post">
              <input type="text" class="listingid" name="lid" value="" style="display:none">
              <button type="submit" class="btn" id="blockbtn" name="actbtn">
                Block/Unblock Listing
              </button>
            </form>
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
