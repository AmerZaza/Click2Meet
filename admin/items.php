<?php
session_start();

	if (isset($_SESSION['adminName'])) {
		$pageTitle='Items Manage';
		include 'init.php';


	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		//start Manage Page
		if($do == 'Manage'){  // Manage page 


		// Select All Users Except the Admin 

		$items = getInnerItem("items.Item_ID != 0","items.Item_ID","DESC");

		?>

				<h1 class="title">Manage The Items </h1>
				  <div>
				 		<table class="member-table">
				 			<tr>
				 				<td>#ID</td>
				 				<td>Item Name</td>
				 				<td>Item Catigory</td>
	                            <td>Item Price</td>
				 				<td>Item Category</td>
				 				<td>Tags</td>
				 				<td>Insert Time</td>
				 				<td>Item Link 1</td>
				 				<td>Item Link 2</td>
				 				<td>Controls</td>

				 			</tr>

				 			<?php

				 			foreach ($items as $item) { 
				 				echo '<tr>';
				 					echo '<td>'.$item["Item_ID"]. '</td>';	
				 					echo '<td>'.$item["Item_Name"]. '</td>';
				 					echo '<td>'.$item["Category_Name"]. '</td>';
				 					echo '<td>'.$item["Main_Price"]. '</td>';
				 					echo '<td>'.$item["Category_ID"]. '</td>';
				 					echo '<td>'.$item["Item_Tags"]. '</td>';
				 					echo '<td>'.$item["Inser_Time"]. '</td>';
				 					echo '<td>'.$item["Item_Link1"]. '</td>';
				 					echo '<td>'.$item["Item_Link2"]. '</td>';
				 				
				 					echo '<td>';
				 					       if ($item["Item_Display"] == 0){
				 					       	echo '<a class="btn btn-blue"  href=items.php?do=Allow&itemid='.$item["Item_ID"].'>Allow</a>';
				 					       }elseif($item["Item_Display"] == 1){
				 					       	echo '<a class="btn btn-orange"  href=items.php?do=Deactivate&itemid='.$item["Item_ID"].'>Deactivate</a>';
				 					       }

				 					       echo '<a class="btn btn-blue" href="../manage_'.$item["Include_Code"].'?itemid='.$item["Item_ID"].' " target="_blank">Edit Item</a>';

				 					       echo '<a class="btn btn-red" href=items.php?do=Delete&itemid='.$item["Item_ID"].'>Delete</a>';
				 					echo '</td>';
				 				echo '</tr>';
				 			}
				 			echo '</table>';
				 		echo '</div>';
	                         

	    
	}elseif($do == 'Allow'){

		echo "<h1>Allow Item</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; //short if 


		$check = superGet('*','items','Item_ID = "$itemid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("UPDATE items SET Item_Display = 1 WHERE Item_ID = ?");

					$stmt->execute(array($itemid));

			// Echo the Message
			echo '<div>';
			$theMsg = "<div> ". $stmt->rowCount() ." Record Updated</div>" ;
			redirectHome($theMsg,'index.php',2);
			echo '</div>';
			

		}else{
			echo '<div>';
			$theMsg = "<div>Sorry you dont chose the User.</div>";
			redirectHome($theMsg,'items.php',2);
			echo '</div>';
		}
		echo '</div>' ;

	}elseif($do == 'Deactivate'){

		echo "<h1>Allow Item</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; //short if 


		$check = superGet('*','items','Item_ID = "$itemid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("UPDATE items SET Item_Display = 0 WHERE Item_ID = ?");

					$stmt->execute(array($itemid));

			// Echo the Message
			echo '<div>';
			$theMsg = "<div> ". $stmt->rowCount() ." Record Updated</div>" ;
			redirectHome($theMsg,'items.php',2);
			echo '</div>';
			

		}else{
			echo '<div>';
			$theMsg = "<div>Sorry you dont chose the User.</div>";
			redirectHome($theMsg,'index.php',2);
			echo '</div>';
		}
		echo '</div>' ;

	}elseif ($do == 'Delete') {
		echo "<h1>Delete Member</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; //short if 


		$check = superGet('Item_ID', 'items','Item_ID = "$itemid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zitem");

					$stmt->bindParam(":zitem", $itemid);

					$stmt->execute();

			// Echo the Message
			echo '<div">';
			$theMsg = "<div> ". $stmt->rowCount() ." The Record Deleted</div>" ;
			redirectHome($theMsg,'index.php',2);
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