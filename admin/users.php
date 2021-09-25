<?php
session_start();

	if (isset($_SESSION['adminName'])) {
		$pageTitle='Users Manage';
		include 'init.php';


	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		//start Manage Page
		if($do == 'Manage'){  // Manage page 

	


		// Select All Users Except the Admins or With admin debending on User_Group 
			
			if($_SESSION['adminGroup'] == 0){
				$members = superGet("*", "users");
			}else{
				$members = superGet("*", "users",'User_Group != 0 AND User_Group !=1');
			}
			
			


		?>

				<h1 class="title">Manage The Members </h1>
				  <div>
				 		<table class="member-table">
				 			<tr>
				 				<td>#ID</td>
	                            <td>Image</td>
				 				<td>User Name</td>
				 				<td>Email</td>
				 				<td>Full Name</td>
				 				<td>Web Site</td>
				 				<td>User Group</td>
				 				
				 				<td>Regist Time</td>
				 				<td>Controls</td>

				 			</tr>

				 			<?php

				 			foreach ($members as $member) { 
				 				echo '<tr>';
				 					echo '<td>' .$member["User_ID"]. '</td>' ;
				 					echo '<td>' .$member["User_Image"]. '</td>' ;
				 					echo '<td>' .$member["User_Name"]. '</td>' ;
				 					echo '<td>' .$member["Email"]. '</td>' ;
				 					echo '<td>' .$member["Full_Name"]. '</td>' ;
				 					echo '<td>' .$member["User_Web"]. '</td>' ;
				 					echo '<td>' .$member["User_Group"]. '</td>' ;
				 					//echo '<td>' .$member["Location_ID"]. '</td>' ;
				 					echo '<td>' .$member["Regis_Time"]. '</td>' ;
				 					echo '<td>';
				 					       if ($member["User_Status"] == 0){
				 					       	echo '<a class="btn btn-blue"  href=users.php?do=Activate&userid='.$member["User_ID"].'>Active</a>';
				 					       }
				 					       echo '<a class="btn btn-red" href=users.php?do=Delete&userid='.$member["User_ID"].'>Delete</a>';
				 					echo '</td>';
				 				echo '</tr>';
				 			}
				 			echo '</table>';
				 		echo '</div>';
	                         

	    
	   	}elseif($do == 'Activate'){

		echo "<h1>Activate Member</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; //short if 


		$check = superGet('*','users','User_ID = "$userid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("UPDATE users SET User_Status = 1 WHERE User_ID = ?");

					$stmt->execute(array($userid));

			// Echo the Message
			echo '<div>';
			$theMsg = "<div> ". $stmt->rowCount() ." Record Activated</div>" ;
			redirectHome($theMsg,'',3);
			echo '</div>';
			

		}else{
			echo '<div>';
			$theMsg = "<div>Sorry you dont select the User.</div>";
			redirectHome($theMsg);
			echo '</div>';
		}
		echo '</div>' ;

	}elseif ($do == 'Delete') {
		echo "<h1>Delete Member</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; //short if 


		$check = superGet('User_ID', 'users','User_ID = "$userid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("DELETE FROM users WHERE User_ID = :zuser");

					$stmt->bindParam(":zuser", $userid);

					$stmt->execute();

			// Echo the Message
			echo '<div">';
			$theMsg = "<div> ". $stmt->rowCount() ." The Record Deleted</div>" ;
			redirectHome($theMsg,'',3);
			echo '</div>';



			

		}else{
			echo '<div>';
			$theMsg = "<div >Sorry you dont chose the User.</div>";
			redirectHome($theMsg);
			echo '</div>';
		}
		echo '</div>' ;

	}
	   
	    


	    // if ther are no Session forword to the login page
}else{
		header('Location:index.php'); // Forowrd to the next Page If the session;
	}
include  $tpl ."footer.php";
?>