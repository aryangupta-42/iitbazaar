<?php
  require '../core/dbconnect.php';
  require '../core/config.php';
  require '../core/reg.php';

  $reg = new Reg;
  $err = [false,"","",""];
  if(isset($_POST['regbtn'])){
    $usrname = $_POST['username'];
    $fname = $_POST['fullname'];
    $email = $_POST['imail'];
    $pass = $_POST['pass'];
    $conpass = $_POST['conpass'];
    $hostel = $_POST['hostel'];
    $contactno = $_POST['contact'];
    $usrname = cln($usrname);
    $fname = cln($fname);
    $email = cln($email);
    $pass = cln($pass);
    $conpass = cln($conpass);
    $contactno = cln($contactno);

    $err = $reg->newUser($fname, $usrname, $contactno, $hostel, $email, $pass, $conpass, $db);

    if($err[0] == false && $err[3] != ""){
      session_start();
      $_SESSION['user'] = $err[3];
      session_write_close();
      header("location: ../home/index.php");
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <?php require '../ui/includes.php' ?>
    <link rel="stylesheet" href="../css/reg.css">
    <script src="../js/reg.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="logo"></div>
    <div class="title">
      Register
    </div>
    <div class="subtitle">
      <span>Welcome to IIT Bazaar</span>, please ensure that you fill out all the details properly so that both the buyer of your product and the seller can contact you efficiently.
    </div>
    <div class="formcont">
      <form class="" action="#" method="post">
        <input required placeholder="Username" type="text" name="username" value="<?php echo($usrname) ?>">
        <input required placeholder="Fullname" type="text" name="fullname" value="<?php echo($fname) ?>"><br>
        <input required id="mail" placeholder="Institute Email" type="email" name="imail" value="<?php echo($email) ?>"><br>
        <input required placeholder="Password" type="password" name="pass" value="<?php echo($pass) ?>">
        <input required placeholder="Confirm Password" type="password" name="conpass" value="<?php echo($conpass) ?>">
        <div class="dropdown">
          <input type="text" name="hostel" value="Hostel" class="dtitle" readonly id="hostel">
        </div>
        <div class="dropdown-opt">
          <div class="di">Hostel 1</div>
          <div class="di">Hostel 2</div>
          <div class="di">Hostel 3</div>
          <div class="di">Hostel 4</div>
          <div class="di">Hostel 5</div>
        </div>
        <input required id="contact" placeholder="Contact Number" type="tel" name="contact" value="<?php echo($contactno) ?>">
        <br>
        <button type="submit" name="regbtn" class="btn">Let's Go</button>
      </form>
    </div>
    <?php
      if($err[0] == true){
        echo(
          "<div class='error'>".
          $err[2]
          ."</div>");
      }
    ?>
    <?php require '../ui/footer.php' ?>
  </body>
</html>
