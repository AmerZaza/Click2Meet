<?php 

session_start();

$pageTitle = 'My Profile | A to Z for All';
	
include 'init.php';

if (isset($_SESSION['user'])){
    $userid = $_SESSION['uid'];
    
  $users = superGet('*','users',"users.User_ID = $userid");
  if(!empty($users)){
    foreach ($users as $user){}

    ?>

 
    <div class="container">
        <div class="row">
            <div class="col col-md-12">
                <div class="container">
                    <div class="profile-head">
                        <img class="profile-back-img" src="images/profiles/<?php echo $user['User_back_image'];?>">
                    </div>
                    <div class="profile-head-info">
                            
                        <div class="profile-title"> <?php echo $user['Full_Name']?></div>
                             <img class="head-user-img" src="images/profiles/<?php echo $user['User_Image'] ?>">
                        </div>
                </div>

                    <div class="container user-details">
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    <li><label><?php getTE('User Name');?> : </label><span><?php echo $user['User_Name'];?></span></li>
                                     <li><label><?php getTE('Full Name');?> :</label><span><?php echo $user['Full_Name'];?></span></li>
                                    <li><label><?php getTE('Email');?> :</label><span><?php echo $user['Email'];?></span></li>
                                     <li><label><?php getTE('Website');?> :</label><span><?php echo $user['User_Web'];?></span></li>
                                     <?php 
                                     $langID = $user['Select_Lang'];
                                     $langs = superGet('*','languages',"Lang_ID = $langID");
                                     foreach ($langs as $lang) {} 
                                     
                                     ?>
                                     <li><label><?php getTE('Language');?> : </label><span><?php echo $lang['Lang_Name'];?></span></li>
                                  
                                      <li><label><?php getTE('Regist Date');?> :</label><span><?php echo $user['Regis_Time'];?></span></li>
                                 </ul>
         
                             </div>
  <!--
                             <div class="col-md-6">
                                   <?php 
                                    $userLoc = $user['U_Location_ID'];
                                    if(isset($userLoc)){
                                    $areas = superGet('*','locations_text', "Location_ID = $userLoc");
                                    foreach ($areas as $area) {}
                                    ?>
                                     <ul>
                                        <li><label><?php getTE('Country');?> :</label><span><?php if(isset($area['Country'])){ echo $area['Country'];}?></span></li>
                                        <li><label><?php getTE('Region');?> :</label><span><?php if(isset($area['Region'])){echo $area['Region'];} ?></span></li>
                                        <li><label><?php getTE('City');?> :</label><span><?php if(isset($area['City'])){ echo $area['City'];}?></span></li>
                                        <li><label><?php getTE('Street');?> :</label><span><?php if(isset($area['Street'])){ echo $area['Street'];}?></span></li>
                                        <li><label><?php getTE('Haus Nummer');?> :</label><span><?php if(isset($area['Haus_N'])){ echo $area['Haus_N'];}?></span></li>
                                        <li><label><?php getTE('Address');?> :</label><span><?php if(isset($area['Loc_Note'])){ echo $area['Loc_Note'];}?></span></li>
                                     </ul>
 
                                    <?php } // END IS Set?>
                                    
                                </div>
                -->
                            </div>
                        </div>
                   


                    
                </div>
           
        </div>
    </div>


    <?php


    } // end if proveider not EMPTY 

}else { // end if Session es Set 
    header('Location:login.php');
    exit();
}
include  $tpl . "footer.php";