<?php
//include a core config file to stripslash speacial characters
  class Reg{
    public function newUser($fullname,$usrname, $contactno, $hostel, $email, $pass, $cpass, $db){
      $err[4] = [false,"","",""];
      if(strlen($fullname) < 2 || strlen($email) < 3 || strlen($contactno) < 3 || strlen($hostel) < 3 || strlen($usrname) < 3){
        $err = [true,"SHORT_VAL","Please fill in all fields",""];
        return $err;
      }else if(strlen($fullname) > 55 || strlen($email) > 55 || strlen($pass) > 55 || strlen($contactno) > 55 || strlen($hostel) > 55 || strlen($usrname) > 55){
        $err = [true,"LONG_VAL"," Please enter legit data lol",""];
        return $err;
      }else{
        $name = explode(" ", $fullname);
        if(sizeof($name)>4){
          $err= [true,"FAKE_NAME", "Please enter your actual name",""];
          return $err;
        }
        if(strstr($email,"@") != "@iitd.ac.in"){
          $err = [true,"INVALID_IMAIL", "Please enter valid institute mail",""];
          return $err;
        }
        $qry = $db->prepare("SELECT * FROM users WHERE email = :imail OR username = :usrname LIMIT 1");
        $qry->execute([':imail'=>$email, ':usrname'=>$usrname]);
        $res = $qry->fetch(PDO::FETCH_ASSOC);
        if(isset($res['uid'])){
          $err = [true, "USED_MAIL", "This email or username is already associated with an account, Please try logging in instead",""];
          return $err;
        }
        if($pass != $cpass){
          $err = [true, "PASS_MATCH_ERROR", " Your Passwords do not match",""];
          return $err;
        }
        if(strlen($pass) < 5){
          $err = [true, "PASS_SHORT", "Your Password is too short",""];
          return $err;
        }
        if($hostel == "Hostel"){
          $err = [true, "INV_HOSTEL", "Please select a hostel using the dropdown menu",""];
          return $err;
        }
        $fname = $name[0];
        $lname = "";
        $i = 1;
        while($i<sizeof($name)){
          $lname = $lname.$name[$i]." ";
          $i = $i+1;
        }
        $uid = uniqid('user',true);
        $uid = str_replace('.','u', $uid);
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $qry = $db->prepare("INSERT INTO users (uid, username, firstname, lastname, email, password, hostel, contactdet) VALUES (:uid, :usrname, :fname, :lname, :email, :pass, :hostel, :contactdet)");
        $qry->execute([
          ':uid'=> $uid,
          ':usrname'=>$usrname,
          ':fname'=> $fname,
          ':lname'=> $lname,
          ':email'=> $email,
          ':pass' => $pass,
          ':hostel'=>$hostel,
          ':contactdet'=>$contactno
        ]);
        $err = [false, "SUCCESS", "User registered successfully",$uid];
        return $err;
      }
    }
  }


 ?>
