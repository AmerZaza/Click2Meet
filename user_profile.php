<?php 

session_start();

$pageTitle = 'My Profile | A to Z for All';
	
include 'init.php';

$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
    
  $users = superGet('*','users',"users.User_ID = $userid");
  if(!empty($users)){
    foreach ($users as $user){}

    ?>

    <h1 class="text-center"><?php echo $user['Full_Name'].getT('profile page'); ?></h1>

    <div class="information block">
        <div class="container">
            <div class="title"> <?php getTE('profile page'); ?></div>
            <div class="row">
            <div class="col col-md-8">
                
                <ul>
                    <li><span><?php getTE('User Name');?> : </span><span><?php echo $user['User_Name'];?></span></li>
                    <li><span><?php getTE('Full Name');?> :</span><span><?php echo $user['Full_Name'];?></span></li>
                    <li><span><?php getTE('Email');?> :</span><span><?php echo $user['Email'];?></span></li>
                    <li><span><?php getTE('Website');?> :</span><span><?php echo $user['User_Web'];?></span></li>
                    <li><span><?php getTE('Language');?> : </span><span><?php echo $user['Select_Lang'];?></span></li>
                
                    <li><span><?php getTE('Regist Date');?> :</span><span><?php echo $user['Regis_Time'];?></span></li>
                    <?php 
                    $userLoc = $user['U_Location_ID'];
                    if(isset($userLoc) & $userLoc != 0 ){
                    $areas = superGet('*','locations_text', "Location_ID = $userLoc");
                    foreach ($areas as $area) {}
                    ?>
                    <li><label><?php getTE('Country');?> : </label><span><?php echo $area['Country'];?></span></li>
                    <li><label><?php getTE('Region');?> : </label><span><?php echo $area['Region'];?></span></li>
                    <li><label><?php getTE('City');?> : </label><span><?php echo $area['City'];?></span></li>
                    <li><label><?php getTE('Street');?> : </label><span><?php echo $area['Street'];?></span></li>
                    <li><label><?php getTE('Haus Nummer');?> : </label><span><?php echo $area['Haus_N'];?></span></li>
                    <li><label><?php getTE('Address');?> : </label><?php echo $area['Loc_Note'];?></span></li>

                    <?php } // END IS Set?>

                </ul>
  
                </div>
                
             
                
                 <!-- Add Profile Photo -->
                <div class='col col-md-2'>
                <img class="user-img" src="images/profiles/<?php echo $user['User_Image'] ?>">
            </div>
        </div>
    </div>
</div>


    <?php


    } // end if proveider not EMPTY 


include  $tpl . "footer.php";