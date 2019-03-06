<?php
  require '../core/dbconnect.php';
  require '../core/userdet.php';
  session_start();
  if(isset($_POST['Logoutbtn'])){
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
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <?php require '../ui/includes.php'; ?>
  </head>
  <body>


    <?php require '../ui/header.php'; require '../ui/sideoverlay.php'; ?>
  </body>
</html>
