<?php
  require 'core/dbconnect.php';
  require 'core/config.php';
  require 'core/login.php';

  $err = [false, "", "",""];
  $login = new Log;
  if(isset($_POST['loginbtn'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $email = cln($email);
    $pass = cln($pass);
    $err = $login->login($email, $pass, $db);
  }
  if($err[0] == false && $err[3] != ""){
    session_start();
    $_SESSION['user'] = $err[3];
    if($_POST['email'] == "admin@iitd.ac.in"){
      $_SESSION['admin'] = "admin";
      session_write_close();
      header("location: admin/index.php");
    }else{
      session_write_close();
      header("location: home/index.php");
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>IIT Bazaar</title>
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/footer.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/master.js" charset="utf-8"></script>
    <script src="js/login.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="logo"></div>
    <div class="title">
      IIT <span>Bazaar</span>
    </div>
    <div class="subtitle">
      An interactive buying and selling portal for IIT Students within campus
    </div>
    <div class="loginspace">
      <form class="loginform" action="#" method="post">
        <input id="logmail" type="email" name="email" value="<?php echo($email) ?>" placeholder="Enter your institute email id" required><br>
        <input id="logpass" type="password" name="pass" value="<?php echo($pass) ?>" placeholder="password" required><br>
        <button type="submit" name="loginbtn" class="btn" id="loginbtn">Login</button>
        <div class="or">
          OR
        </div>
        <button type="button" class="btn" id="regbtn">Register</button>
      </form>
      <?php
        if($err[0] == true){
          echo("<div class = 'error'>".$err[2]."</div>");
        }
       ?>
    </div>
    <?php require 'ui/footer.php' ?>
  </body>
</html>
