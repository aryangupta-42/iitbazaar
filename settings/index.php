<?php
  require '../core/dbconnect.php';
  require '../core/userdet.php';
  require '../core/imageprocessing.php';

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
  $_SESSION['loc'] = "settings";
  $user = new User;
  $userdet = $user->getDetails($_SESSION['user'], $db);
  if(isset($_POST['changenamebtn'])){
    $namemsg = "An error occured, Please try again later";
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $qry = $db->prepare('UPDATE users SET firstname = :fname, lastname = :lname WHERE uid = :uid');
    $qry->execute([
      ":fname"=>$fname,
      ":lname"=>$lname,
      ":uid"=>$_SESSION['user']
    ]);
    $namemsg = "Changes Successful";
    header("location: ../settings");
  }
  if(isset($_POST['changehostelbtn'])){
    $hostelmsg = "An error occured, Please try again later";
    $hostel = $_POST['hostel'];
    $qry = $db->prepare('UPDATE users SET hostel = :hostel WHERE uid = :uid');
    $qry->execute([
      ":hostel"=>$hostel,
      ":uid"=>$_SESSION['user']
    ]);
    $hostelmsg = "Changes Successful";
    header("location: ../settings");
  }
  if(isset($_POST['changeimagebtn'])){
    $img = new \claviska\SimpleImage();
    move_uploaded_file($_FILES['userimage']['tmp_name'],'../img/tempuser.jpg');
    $upimg = $img->fromFile('../img/tempuser.jpg');
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
    $edittedimg->toFile('../img/users/'.$_SESSION['user'].'.jpg');
    $qry = $db->prepare('UPDATE users SET img = :img WHERE uid = :uid');
    $qry->execute([
      ":img"=>$_SESSION['user'].'.jpg',
      ":uid"=>$_SESSION['user']
    ]);
    header("location: ../settings");
    
  }

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <?php require '../ui/includes.php'; ?>
    <link rel="stylesheet" href="../css/settings.css">
    <script src="../js/settings.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="settingscont">
      <div class="settingsection">
        <div class="sectiontitle">
          Update Your Name
        </div>
        <div class="sectioninp">
          <form class="" action="#" method="post">
            <input required class="userinp" type="text" name="firstname" value="<?php echo($userdet[1]) ?>">
            <input required class="userinp" type="text" name="lastname" value="<?php echo($userdet[2]) ?>">
            <br>
            <button type="submit" name="changenamebtn" class="btn">Confirm</button>
            <div class="msg">
              <?php echo($namemsg) ?>
            </div>
          </form>
        </div>
      </div>
      <div class="settingsection">
        <div class="sectiontitle">
          Update your hostel
        </div>
        <form class="" action="#" method="post">
          <div class="dropdown">
            <input type="text" name="hostel" value="<?php echo($userdet[4]) ?>" class="dtitle" readonly id="hostel" required>
          </div>
          <div class="dropdown-opt">
            <div class="di">Hostel 1</div>
            <div class="di">Hostel 2</div>
            <div class="di">Hostel 3</div>
            <div class="di">Hostel 4</div>
            <div class="di">Hostel 5</div>
          </div>
          <button type="submit" name="changehostelbtn" class="btn">Confirm</button>
          <div class="msg">

          </div>
        </form>
      </div>
      <div class="settingsection" id="lastsec">
        <div class="sectiontitle">
          Update your user image
        </div>
        <form class="" action="#" method="post" enctype="multipart/form-data">
          <img src="#" alt="" id="itemimagepre">
          <label for="itemimage" id="itemimagelabel">Select image</label>
          <input id="itemimage" type="file" name="userimage" value="" onchange="readURL(this);" required>
          <button type="submit" name="changeimagebtn" class="btn">Confirm</button>
          <div class="msg">

          </div>
        </form>
      </div>
    </div>
    <?php require '../ui/header.php'; require '../ui/sideoverlay.php'; ?>
  </body>
</html>
