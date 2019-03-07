<div class="sideoverlay">
  <div class="userinfo">
    <div class="userimg">
    </div>
    <div class="userdet">
      <div class="username">@<?php echo($userdet[0]) ?></div>
      <div class="userfullname"><?php echo($userdet[1]." ".$userdet[2]) ?></div>
      <div class="useremail"><?php echo($userdet[3]) ?></div>
      <div class="userhostel"><?php echo($userdet[4]) ?></div>
      <div class="userrating">Rating: <?php echo($userdet[6]) ?></div>
      <div class="usersoldno">Products Sold: <?php echo($userdet[7]) ?></div>
      <div class="userid" style="display:none"><?php echo($_SESSION['user']) ?></div>
    </div>
  </div>
  <div class="navmenu">
    <div class="navbtn" id="purchases"><i class="fas fa-shopping-cart fa-1x"></i><span>Purchases</span></div>
    <div class="navbtn" id="activelistings"><i class="fas fa-list-ul fa-1x"></i><span>Active Listings</span></div>
    <div class="navbtn" id="oldlistings"><i class="fas fa-history fa-1x"></i><span>Old Listings</span></div>
    <div class="navbtn" id="newlisting"><i class="fas fa-plus-square fa-1x"></i><span>New Listing</span></div>
    <div class="navbtn" id="settings"><i class="fas fa-cog fa-1x"></i><span>Settings</span></div>
  </div>
  <form class="" action="#" method="post">
    <button type="submit" name="logoutbtn" class="btn" id="logoutbtn"><i class="fas fa-power-off fa-1x"></i>Logout</button>
  </form>
</div>
