<?php
//include a core config file to stripslash speacial characters
  class Reg{
    public function newUser($fullname, $imail, $pmail, $eno, $pass, $cpass, $db){
      $err[3] = [false,"",""];
      if(strlen($fullname) < 2 || strlen($pmail) < 3 || strlen($imail) < 3 ){
        $err = [true,"SHORT_VAL","Please fill in all fields"];
        return $err;
      }else if(strlen($fullname) > 55 || strlen($pmail) > 55 || strlen($imail) > 55 || strlen($pass) > 55){
        $err = [true,"LONG_VAL"," Please enter legit data lol"];
        return $err;
      }else{
        $name = explode(" ", $fullname);
        if(sizeof($name)>4){
          $err= [true,"FAKE_NAME", "Please enter your actual name"];
          return $err;
        }
        if(!filter_var($pmail, FILTER_VALIDATE_EMAIL)){
          $err = [true,"INVALID_PMAIL", "Please enter a valid personal mail"];
          return $err;
        }else if(strstr($imail,"@") != "@iitd.ac.in"){
          $err = [true,"INVALID_IMAIL", "Please enter valid institute mail"];
          return $err;
        }
        $qry = $db->prepare("SELECT * FROM users WHERE institutemail = :imail OR personalmail = :pmail LIMIT 1");
        $qry->execute([':imail'=>$imail, ':pmail'=>$pmail]);
        $res = $qry->fetch(PDO::FETCH_ASSOC);
        if(isset($res['uid'])){
          $err = [true, "USED_MAIL", "This email is already associated with an account, Please try logging in instead"];
          return $err;
        }


        $year = substr($eno, 0, 4);
        $bcode = substr($eno, 4, 2);
        $ucode = substr($eno, 6,5);
        if((!is_numeric($year)) || (!is_numeric($ucode) && is_string($ucode)) || (!ctype_alpha($bcode))){
          $err = [true,"INVALID_ENO","Please recheck your entry number"];
          return $err;
        }
        $eno = strtoupper($eno);
        if($pass != $cpass){
          $err = [true, "PASS_MATCH_ERROR", " Your Passwords do not match"];
          return $err;
        }
        if(strlen($pass) < 5){
          $err = [true, "PASS_SHORT", "Your Password is too short"];
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
        $qry = $db->prepare("INSERT INTO users (uid, firstname, lastname, institutemail, personalmail,entryno,password,status) VALUES (:uid, :fname, :lname, :imail, :pmail, :eno, :pass, 'active')");
        $qry->execute([
          ':uid'=> $uid,
          ':fname'=> $fname,
          ':lname'=> $lname,
          ':imail'=> $imail,
          ':pmail'=> $pmail,
          ':eno'=> $eno,
          ':pass' => $pass
        ]);
        $err = [false, "SUCCESS", "User registered successfully"];
        return $err;
      }
    }
  }


 ?>
