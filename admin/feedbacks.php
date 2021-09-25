<?php
session_start();

	if (isset($_SESSION['adminName'])) {
		$pageTitle='Items Manage';
		include 'init.php';




		// Select All Users Except the Admin 

		$feeds = superGet('*','feedback');

		?>

				<h1 class="title">Manage The Items </h1>
				  <div>
				 		<table class="member-table">
				 			<tr>
				 				<td>#ID</td>
				 				<td>Insert Time</td>
				 				<td>user ID</td>
	                            <td>Name</td>
				 				<td>Email</td>
				 				<td>Phone</td>
				 				<td>Subject</td>
				 				<td>Text</td>
				 				<td>Status</td>
				 				<td>Controls</td>

				 			</tr>

				 			<?php

				 			foreach ($feeds as $feed) { 
				 				echo '<tr>';
				 					echo '<td>'.$feed["Feedback_ID"]. '</td>';	
				 					echo '<td>'.$feed["Fb_Time"]. '</td>';
				 					echo '<td>'.$feed["User_ID"]. '</td>';
				 					echo '<td>'.$feed["Name"]. '</td>';
				 					echo '<td>'.$feed["Email"]. '</td>';
				 					echo '<td>'.$feed["Phone"]. '</td>';
				 					echo '<td>'.$feed["Subject"]. '</td>';
				 					echo '<td>'.$feed["Fb_Text"]. '</td>';
				 					echo '<td>'.$feed["Status"]. '</td>';
				 				
				 					echo '<td>';
				 					/*
				 					       if ($item["Item_Display"] == 0){
				 					       	echo '<a class="btn btn-blue"  href=items.php?do=Allow&itemid='.$item["Item_ID"].'>Allow</a>';
				 					       }
				 					       echo '<a class="btn btn-red" href=items.php?do=Delete&itemid='.$item["Item_ID"].'>Delete</a>';
				 					       */
				 					echo '</td>';
				 				echo '</tr>';
				 			}
				 			echo '</table>';
				 		echo '</div>';
	                         

	


	    // if ther are no Session forword to the login page
}else{
		header('Location:index.php'); // Forowrd to the next Page If the session;
	}
include  $tpl ."footer.php";
?>