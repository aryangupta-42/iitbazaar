<?php
  require '../core/dbconnect.php';
  require '../core/userdet.php';
  require '../core/imageprocessing.php';
  session_start();
  if(!isset($_SESSION['user'])){
    header('Location: ../index.php');
    session_write_close();
  }
  if(isset($_POST['logoutbtn'])){
    session_unset();
    session_destroy();
    header("Location: ../index.php");
  }
  $user = new User;
  $userdet = $user->getDetails($_SESSION['user'], $db);
  $flag = 0;
  $error = "";
  if(isset($_POST['uploadbtn'])){
    if($flag){
      $error = "You've already uploaded this item";
      return;
    }else{
      $flag = 1;
    }
    $img = new \claviska\SimpleImage();
    move_uploaded_file($_FILES['itemimage']['tmp_name'],'../img/temp.jpg');
    $lid = uniqid('list',true);
    $lid = str_replace('.','l',$lid);
    // $info = pathinfo($_FILES['itemimage']['name']);
    // try{
      $upimg = $img->fromFile('../img/temp.jpg');
      $imgheight = $upimg->getHeight();
      $imgwidth = $upimg->getWidth();
      $imglength = 0;
      if($imgheight > $imgwidth){
        $imglength = $imgwidth;
      }else{
        $imglength = $imgheight;
      }
      $x1 = ($imgwidth - $imglength)/2;
      $y1 = ($imgheight - $imglength)/2;
      $x2 = $imgwidth - $x1;
      $y2 = $imgheight - $y1;
      $edittedimg = $upimg->crop($x1,$y1,$x2,$y2);

    // }catch(Exception $err){
      // echo $err->getMessage();
    // }
    $name = $_POST['itemname'];
    $description = $_POST['itemdesc'];
    $price = $_POST['itemprice'];
    $pickup = $_POST['itempickup'];
    $qry = $db->prepare('SELECT * FROM listings WHERE description = :description LIMIT 1');
    $qry->execute([':description'=>$description]);
    $res = $qry->fetch(PDO::FETCH_ASSOC);
    $f = 0;
    if(!isset($res['lid'])){
      $qry = $db->prepare('INSERT INTO listings (lid, name, description, price, pickup, status, seller, sid) VALUES (:lid, :name, :description, :price, :pickup, :status, :seller, :sid)');
      $qry->execute([
        ':lid'=>$lid,
        ':name'=>$name,
        ':description'=>$description,
        ':price'=>$price,
        ':pickup'=>$pickup,
        ':status'=>"active",
        ':seller'=>$userdet[0],
        ':sid'=>$_SESSION['user']
      ]);
      $edittedimg->toFile('../img/listings/'.$lid.'.jpg');
      $error = "Listing uploaded successfully";
    }else{
      $error = "You've already uploaded this listing";
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <?php require '../ui/includes.php'; ?>
    <link rel="stylesheet" href="../css/newlisting.css">
    <script src="../js/newlisting.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="newlistingcont">
      <div class="output">
        <?php echo($error); ?>
      </div>
      <div class="title">
        Create Your Listing
      </div>
      <form class="" action="#" method="post" enctype="multipart/form-data">
        <div class="maincard">
          <img src="#" alt="" id="itemimagepre">
          <label for="itemimage" id="itemimagelabel">Select image</label>
          <input id="itemimage" type="file" name="itemimage" value="" onchange="readURL(this);" required>
          <br>
          <input required class="iteminp"type="text" name="itemname" value="" placeholder="Item Name">
          <textarea required name="itemdesc" placeholder="Item Description"></textarea>
          <input required class="iteminp" type="number" name="itemprice" value="" placeholder="Product Price in INR ">
          <input required class="iteminp" type="text" name="itempickup" placeholder="Item Pickup Location " value="">
          <button type="submit" name="uploadbtn" class="btn" id="uploadbtn">Upload</button>
        </div>
      </form>
    </div>
    <?php require '../ui/header.php'; require '../ui/sideoverlay.php'; ?>
  </body>
</html>
