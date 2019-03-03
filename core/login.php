<?php
class Log{
  public function login($imail, $pass, $db){
    $err = [false,"",""];
    $qry = $db->prepare("SELECT * FROM users WHERE institutemail = :imail LIMIT 1");
    $qry->execute([
      'imail'=>$imail
    ]);
    $res = $qry->fetch(PDO::FETCH_ASSOC);
    if(isset($res['institutemail'])){
      $dt = new DateTime();
      //(strtotime($dt->format('Y-m-d H:i:s')) - strtotime($res['lastseen']))/60
      if((strtotime($dt->format('Y-m-d H:i:s')) - strtotime($res['lastseen'])) / 60 < 15){
        if($res['loginattempts']>8){
          $err = [true,"TEMP_BLOCK","Sorry, You've made too many login attempts, please try again after 15 minutes"];
          return $err;
        }
      }else{
        $qry = $db->prepare("UPDATE users SET loginattempts = :lattempts WHERE uid = :uid");
        $lattempts = 0;
        $qry->execute([
          ':lattempts'=>$lattempts,
          ':uid' => $res[uid]
        ]);
        $res['loginattempts'] = 0;
      }
      if(password_verify($pass,$res['password'])){
        if($res['status'] == 'blocked'){
          $err = [true,"ACC_BLOCK","Sorry, your account has been blocked due to suspicious activity. Please contact system admin"];
          return $err;
        }else if($res['status'] == 'inactive'){
          $err = [true, "ACC_INACT","Whoops, looks like you've deactivated your account."];
          return $err;
        }
        $qry = $db->prepare("UPDATE users SET loginattempts = :lattempts WHERE uid = :uid");
        $lattempts = 0;
        $qry->execute([
          ':lattempts'=>$lattempts,
          ':uid' => $res[uid]
          ]);
        updateLastseen($res['uid'],$db);
        $err = [false,"LOG_SUCC","User verified successfully "];
        return $err;
      }else{
        $qry = $db->prepare("UPDATE users SET loginattempts = :lattempts WHERE uid = :uid");
        $lattempts = $res['loginattempts'] + 1;
        $qry->execute([
          ':lattempts'=>$lattempts,
          ':uid' => $res[uid]
          ]);
        updateLastseen($res['uid'],$db);
        $err = [true,"INV_PASS","Sorry, incorrect password, Please try again"];
        return $err;
      }
    }else{
      $err = [true,"INV_MAIL","Sorry no such email found. You can register using the register page"];
      return $err;
    }


  }

}
 ?>
