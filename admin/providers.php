<?php
session_start();

	if (isset($_SESSION['adminName'])) {
		$pageTitle='Users Manage';
		include 'init.php';


	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		//start Manage Page
		if($do == 'Manage'){  // Manage page 

	


		// Select All Users Except the Admins or With admin debending on User_Group 
			
			$providers = getInnerProvider();
		


		?>

				<h1 class="title">Manage The Members </h1>
				  <div>
				 		<table class="member-table">
				 			<tr>
				 				<td>#ID</td>
				 				<td>Provider Image</td>
				 				<td>Provider Name</td>
	                            <td>Contact Person</td>
				 				<td>User Name</td>
				 				<td>Email</td>
				 				<td>Full Name</td>
				 				<td>Web Site</td>
				 				<td>User Group</td>
				 				<td>Location</td>
				 				<td>Regist Time</td>
				 				<td>Controls</td>

				 			</tr>

				 			<?php

				 			foreach ($providers as $provider) { 
				 				echo '<tr>';
				 					echo '<td>' .$provider["Provider_ID"]. '</td>' ;
				 					echo '<td>' .$provider["Provider_Image"]. '</td>' ;
				 					echo '<td>' .$provider["Provider_Name"]. '</td>' ;
				 					echo '<td>' .$provider["Contact_Person"]. '</td>' ;
				 					echo '<td>' .$provider["User_Name"]. '</td>' ;
				 					echo '<td>' .$provider["Email"]. '</td>' ;
				 					echo '<td>' .$provider["Full_Name"]. '</td>' ;
				 					echo '<td>' .$provider["User_Web"]. '</td>' ;
				 					echo '<td>' .$provider["User_Group"]. '</td>' ;
				 					echo '<td>' .$provider["Location_ID"]. '</td>' ;
				 					echo '<td>' .$provider["P_Regist_Time"]. '</td>' ;
				 					echo '<td>';
				 					       if ($provider["Provider_Status"] == 0){
				 					       	echo '<a class="btn btn-blue"  href=providers.php?do=Activate&provid='.$provider["Provider_ID"].'>Active</a>';
				 					       }
				 					       echo '<a class="btn btn-red" href=providers.php?do=Delete&provid='.$provider["Provider_ID"].'>Delete</a>';
				 					echo '</td>';
				 				echo '</tr>';
				 			}
				 			echo '</table>';
				 		echo '</div>';
	                         

	    
	   	}elseif($do == 'Activate'){

		echo "<h1>Activate Provider</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$provid = isset($_GET['provid']) && is_numeric($_GET['provid']) ? intval($_GET['provid']) : 0; //short if 


		$check = superGet('*','providers','Provider_ID = "$provid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("UPDATE providers SET Provider_Status = 1 WHERE Provider_ID = ?");

					$stmt->execute(array($provid));

			// Echo the Message
			echo '<div>';
			$theMsg = "<div> ". $stmt->rowCount() ." Record Activated</div>" ;
			redirectHome($theMsg,'',2);
			echo '</div>';
			

		}else{
			echo '<div>';
			$theMsg = "<div>Sorry you dont chose the User.</div>";
			redirectHome($theMsg,'',3);
			echo '</div>';
		}
		echo '</div>' ;

	}elseif ($do == 'Delete') {
		echo "<h1>Delete Provider</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$provid = isset($_GET['provid']) && is_numeric($_GET['provid']) ? intval($_GET['provid']) : 0; //short if 


		$check = superGet('*','providers','Provider_ID = "$provid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("DELETE FROM providers WHERE Provider_ID = :zprov");

					$stmt->bindParam(":zprov", $provid);

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