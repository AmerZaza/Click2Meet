<?php
session_start();

	if (isset($_SESSION['adminName'])) {
		$pageTitle='Item Evaluation Manage';
		include 'init.php';


	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		//start Manage Page
		if($do == 'Manage'){  // Manage page 




		// Select All Users Except the Admin 

		$evalus = getInnerItemEv("items_evaluations.Evaluation_ID != 0","items_evaluations.Evaluation_Time","DESC");

		?>

				<h1 class="title">Manage The Evaluations </h1>
				  <div>
				 		<table class="member-table">
				 			<tr>
				 				<td>#ID</td>
				 				<td>Item Name</td>
				 				<td>User Name</td>
				 				<td>Stars</td>
				 				<td>Comment</td>
				 				<td>Time</td>
				 				<td>Controls</td>

	      
				 			</tr>

				 			<?php

				 			foreach ($evalus as $evalu) { 
				 				echo '<tr>';
				 					echo '<td>'.$evalu["Evaluation_ID"]. '</td>';
				 					echo '<td>'.$evalu["Item_Name"]. '</td>';
				 					echo '<td>'.$evalu["User_ID"]. '</td>';
				 					echo '<td>'.$evalu["Item_Star"]. '</td>';
				 					echo '<td>'.$evalu["Item_Comment"]. '</td>';
				 					echo '<td>'.$evalu["Evaluation_Time"]. '</td>';
				 					
				 					echo '<td>';
				 					       if ($evalu["Evaluation_Display"] == 0){
				 					       	echo '<a class="btn btn-blue"  href=itemsevaluations.php?do=Allow&evalaluid='.$evalu["Evaluation_ID"].'>Allow</a>';
				 					       }
				 					       echo '<a class="btn btn-red" href=itemsevaluations.php?do=Delete&evalaluid='.$evalu["Evaluation_ID"].'>Delete</a>';
				 					echo '</td>';
				 				echo '</tr>';
				 			}
				 			echo '</table>';
				 		echo '</div>';
	                         

	    
	   	}elseif($do == 'Allow'){

		echo "<h1>Allow Evaluation</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$evaluid = isset($_GET['evalaluid']) && is_numeric($_GET['evalaluid']) ? intval($_GET['evalaluid']) : 0; //short if 



		$check = superGet('*','items_evaluations',"Evaluation_ID = $evaluid") ;


				if($check > 0){ 

					$stmt = $con->prepare("UPDATE items_evaluations SET Evaluation_Display = 1 WHERE Evaluation_ID = ?");

					$stmt->execute(array($evaluid));

			// Echo the Message
			echo '<div>';
			$theMsg = "<div> ". $stmt->rowCount() ." Record Updated</div>" ;
			redirectHome($theMsg,'backX',3);
			echo '</div>';
			

		}else{
			echo '<div>';
			$theMsg = "<div>Sorry you dont chose the User.</div>";
			redirectHome($theMsg);
			echo '</div>';
		}
		echo '</div>' ;

	}elseif ($do == 'Delete') {
		echo "<h1>Delete Evaluation</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$evaluid = isset($_GET['evalaluid']) && is_numeric($_GET['evalaluid']) ? intval($_GET['evalaluid']) : 0; //short if


		$check = superGet('*','items_evaluations','Evaluation_ID = "$evaluid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("DELETE FROM items_evaluations WHERE Evaluation_ID = :zeval");

					$stmt->bindParam(":zeval", $evaluid);

					$stmt->execute();

			// Echo the Message
			echo '<div">';
			$theMsg = "<div> ". $stmt->rowCount() ." The Record Deleted</div>" ;
			redirectHome($theMsg,'backX',3);
			echo '</div>';



			

		}else{
			echo '<div>';
			$theMsg = "<div >Sorry you dont chose the User.</div>";
			redirectHome($theMsg,'itemsevaluations.php');
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