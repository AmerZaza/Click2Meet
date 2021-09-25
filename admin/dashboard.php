<?php
session_start();

if (isset($_SESSION['adminName'])) {
	$pageTitle='Dashboard';
	include 'init.php';


	?>
<div class="container home-stats text-center">
    	<h1 class="title">Dashboard</h1>
    	<div class="main_box">
    		
    		   <div class="main_box">
                   <i class="fa fa-users"></i>
                   <div >
                         Total Members
                        <span><a href="users.php"><?php  echo countItems('User_ID','users'); ?></a></span>
                   </div>
                   </div>
    	
    	
    		   <div class="main_box">
                   <i class="fa fa-user-plus"></i>
                   <div class="">
                        Pending Members
                        <span><a href="users.php?do=Manage&page=Pending"><?php echo checkItem ('User_Status','users',0)?></a></span>
                 </div>
    		   </div>
    		
    		   <div class="main_box">
                   <i class="fa fa-tags"></i>
                   <div class="">
                        Total Items
                        <span><a href="items.php"><?php  echo countItems('Item_ID','items'); ?></a></span>
                  </div>
    		   </div>
    
    		   <div class="main_box">
                   <i class="fa fa-comments"></i>
                   <div class="info">
                        Total Comments
                       <span><a href="itemsevaluations.php"><?php  echo countItems('Evaluation_ID','items_evaluations'); ?></a></span>
                   </div>
    		   </div>
   
    </div>


	<?php



}else{
		header('Location:index.php'); // Forowrd to the next Page If the session;
	}

include  $tpl ."footer.php";
?>