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
  $user = new User;
  $userdet = $user->getDetails($_SESSION['user'], $db);
  $qry = $db->prepare("SELECT * FROM listings WHERE status = :status AND sid = :sid ORDER BY publishdate DESC");
  $qry->execute([':status'=>"active", ':sid'=>$_SESSION['user']]);
  if(isset($_POST['updatebtn'])){
    $name = $_POST['itemname'];
    $description = $_POST['itemdesc'];
    $price = $_POST['itemprice'];
    $pickup = $_POST['itempickup'];
    $lid = $_POST['lid'];
    $qryup = $db->prepare("UPDATE listings SET name = :name, description = :description, price = :price, pickup = :pickup WHERE lid = :lid");
    $qryup->execute([
      ':name'=>$name,
      ':description'=>$description,
      ':price'=>$price,
      ':pickup'=>$pickup,
      ':lid'=>$lid
    ]);
  }
  if(isset($_POST['deletebtn'])){
    $lid = $_POST['lid'];
    $qrydel = $db->prepare("DELETE FROM listings WHERE lid = :lid");
    $qrydel->execute([
      ':lid'=>$lid
    ]);
    unlink("../img/listings".$lid."jpg");

  }
  // echo(count($res));

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="../css/master.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/sideoverlay.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../js/activelisting.js" charset="utf-8"></script>
    <link rel="stylesheet" href="../css/activelistings.css">
  </head>
  <body>
    <div class="listingcont">
      <?php
      while($res = $qry->fetch(PDO::FETCH_ASSOC)){
        if(count($res)== 0){
          echo("no posts");
        }else{
          $qry2 = $db->prepare("SELECT * FROM users WHERE uid = :uid LIMIT 1");
          $qry2->execute([':uid'=>$res['bid']]);
          $buyerdet = $qry2->fetch(PDO::FETCH_ASSOC);
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
                <div class='pickuplocation' style='display:none'>"
                  .$res['pickup'].
                "</div>
                <div class='editmessage'>
                  Click to edit the listing
                </div>
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
            <form class="" action="#" method="post">
              <div class="listingdetcardname">
                <input id="listingdetcardname" class="iteminp" type="text" name="itemname" value="">
              </div>
              <div class="listingdetcarddesc">
                <textarea id="listingdetcarddesc" name="itemdesc"></textarea>
              </div>
              <div class="listingdetcardprice">
                <input id="listingdetcardprice" class="iteminp" type="number" name="itemprice" value="">
              </div>
              <div class="listingdetcardpickup">
                <input id="listingdetcardpickup" class="iteminp" type="text" name="itempickup" value="">
              </div>
              <input type="text" name="lid" value="" style="display:none" id="listingdetcardlid">
              <button type="submit" name="updatebtn" class="btn" id="updatebtn">Update</button>
              <button type="submit" name="deletebtn" class="btn" id="delbtn">Delete Listing</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php require '../ui/header.php'; require '../ui/sideoverlay.php'; ?>
  </body>
</html>
