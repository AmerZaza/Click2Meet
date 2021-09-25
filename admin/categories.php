<?php
session_start();

	if (isset($_SESSION['adminName'])) {
		$pageTitle='Categories Manage';
		include 'init.php';


	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		//start Manage Page
		if($do == 'Manage'){  // Manage page 
	


		// Select Categories

		

			echo  '<h1 class="title">Manage The Categories </h1>';
			////////////////////////////////////////////////////
			function getCatTreeAdmin($where = NULL){
		global $con;
		global $mLang;

	if ($where !== NULL){$WHERE = 'WHERE';}else{$WHERE = NULL ;}

	if (isset($_SESSION['ulang'])){
        $LangID = $_SESSION['ulang'];
        // Check if is record in same session Language
        $catLangs = superGet('*','categories_ml',"Lang_ID = $LangID");
        if(!empty($catLangs)){
            $LANG = "AND Lang_ID = $LangID";
        }else{
            // Check if is record in Englich(2 Choise)
           $catLangs = superGet('*','categories_ml',"Lang_ID = $mLang");
           if(!empty($catLangs)){
            $LANG = "AND Lang_ID = $mLang";
           }else{$LANG = NULL;}
        }
        // Get Last record (Withaut condition)
    }else{// Check if is record in Englich(2 Choise)
           $catLangs = superGet('*','categories_ml',"Lang_ID = $mLang");
           if(!empty($catLangs)){
            $LANG = "AND Lang_ID = $mLang";
           }else{$LANG = NULL;}
    }

	


	$stmt = $con->prepare("SELECT
								categories.*, categories_ml.*, languages.*
								FROM categories
								INNER JOIN categories_ml
								ON categories.Category_ID = categories_ml.Category_ID
									$LANG
								INNER JOIN languages
								ON categories_ml.Lang_ID = languages.Lang_ID
								$WHERE $where

								GROUP BY categories_ml.Category_ID

									
				                        ");
		$stmt->execute();
		$categories = $stmt->fetchAll();

	//return $categories;
		echo '<ul class="cat-tree-ul">';
		foreach ($categories as $catiegory) {
			echo '<li>';
			echo '<h4>'.$catiegory['Category_Name'].'</h4>';
			//echo '<p>'.$catiegory['Category_Description'].'</p>';
			if ($catiegory["Category_Display"] == 0){
				echo '<a class="btn btn-green"  href=categories.php?do=Allow_dis&catid='.$catiegory["Category_ID"].'>Allow Display</a>';
				 					       }
			if ($catiegory["Allow_Items"] == 0){
				echo '<a class="btn btn-green"  href=categories.php?do=Allow_items&catid='.$catiegory["Category_ID"].'>Allow Items</a>';
				 					       }
			echo '<a class="btn btn-blue" href=categories.php?do=Edit&catid='.$catiegory["Category_ID"].'>Edit</a>';
			//echo '<a class="btn btn-red" href=categories.php?do=Delete&catid='.$catiegory["Category_ID"].'>Delete</a>';
			echo '<a  class="btn btn-orange" href="categories.php?do=Add&parentid='.$catiegory['Category_ID'].'">New Sub Category</a>';
			
			echo '</li>';
			$parentid = $catiegory['Category_ID'];

			 getCatTreeAdmin("Parent_ID = $parentid");
			 

		} // End for each 


	echo '</ul>'; // end main ul 

	} // end Function

	
										
			// Add New Gategory
			echo '<div class="container">';
				echo '<div class="row">';
					echo '<div class="col col-md-8">';


			getCatTreeAdmin("Parent_ID = 0");

			?>
				</div>
				<div class="col col-md-4">
					<div>
						Categories Details
					</div>
					
				</div>
			</div>
			<div>
				<a href="categories.php?do=Add" class="btn btn-orange" "> Add New Category</a>
			</div>
		</div>

			<?php	              
		// Start Add Category Page

	    }elseif($do == 'Add'){

	    	?>
	    	<h1> Add New Category </h1>

	    	<div class="main_box">

	    		<form action="?do=Insert" method="POST" enctype="multipart/form-data">


	    			<!-- Category Parent-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Parent</label>
		    			</div>
		    			<div>
			    			<select class="main_box" name="cat-parent">
			    				<?php
			    				// Get Parent Id from POST Category ID
			    				$parentid = isset($_GET['parentid']) && is_numeric($_GET['parentid']) ? intval($_GET['parentid']) : 0;
			    				$cats = getInnerCat("categories.Category_ID = $parentid");
			    				/// Select as default parent Category
			    				foreach ($cats as $cat) {
			    					echo '<option value="'.$cat["Category_ID"].'">'.$cat["Category_Name"].'</option>';
			    				}
			    				//// Get another Categories to the select
			    				echo '<option value="0">Main Group</option>';
			    				$cats = getInnerCat();
			    				foreach ($cats as $cat) {
			    					echo '<option value="'.$cat["Category_ID"].'">'.$cat["Category_Name"].'</option>';
			    				}


			    				?>
			    				
			    			</select>
		    			</div>
	    			</div>



	    			<!-- Category Ordering-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Ordering</label>
		    			</div>
		    			<div>
		    				<input type="number" name="ordering"  required="required" placeholder="Insert display Ordering"/>
		    			</div>
	    			</div>


	    			<!-- Category Include Code-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Code</label>
		    			</div>
		    			<div>
		    				<input type="textarea" name="cat-code"  placeholder="Insert the Code"/>
		    			</div>
	    			</div>

	    			<!-- Category Image-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Image</label>
		    			</div>
		    			<div>
		    				<input type="file" name="image"  placeholder="Select the Image"/>
		    			</div>
	    			</div>


	    			<!-- Category Display Allow-->
	    			<div class="main_box">
	    			   <div>
		    				<label>Visible</label>
		    		   </div>
		    		   <div>
						    <input id="vis-yes" type="radio" name="visibility" value="1" checked />
						    <label for="vis-yes">Yes</label>
				        </div>
		    		    <div>
						    <input id="vis-no" type="radio" name="visibility" value="0"  />
						    <label for="vis-no">No</label>
				   	   </div>
		    			
	    			</div>

	    			<!-- Category Add Items Allow-->
	    			<div class="main_box">
	    			   <div>
		    				<label>Add Items</label>
		    		   </div>
		    		   <div>
						    <input id="vis-yes" type="radio" name="add-item" value="1" checked="" />
					   		 <label for="vis-yes">Yes</label>
				        </div>
		    		    <div>
						    <input id="vis-no" type="radio" name="add-item" value="0" />
					   		 <label for="vis-no">No</label>
				   	   </div>
		    			
	    			</div>


	    			<!-- Category Commits Allow-->
	    			<div class="main_box">
	    			   <div>
		    				<label>Commints</label>
		    		   </div>
		    		   <div>
						    <input id="vis-yes" type="radio" name="commints" value="1" checked />
						    <label for="vis-yes">Yes</label>
				        </div>
		    		    <div>
						    <input id="vis-no" type="radio" name="commints" value="0"  />
						    <label for="vis-no">No</label>
				   	   </div>
		    			
	    			</div>



	    		<!-- ** Select The Multilanguage values***************************  -->

	    			<!-- Select The Language-->
	    			<div class="main_box">
	    				<div>
		    				<label>Select The Language</label>
		    			</div>
		    			<div>
		    				<select name="lang">
		    					<?php
		    					$languages = superGet('*','languages');
		    					foreach($languages as $lang){
		    						
		    						echo '<option value="'.$lang['Lang_ID'].'">'.$lang['Lang_Name'].'</option>';
		    					  }
		    					?>
		    				</select>
		    				
		    			</div>
	    			</div>


	    			<!-- Category Name-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Name</label>
		    			</div>
		    			<div>
		    				<input type="text" name="cat-name"  required="required" placeholder="Insert the Category Name"/>
		    			</div>
	    			</div>




	    			<!-- Category Discrebtion-->
	    			<dir class="main_box">
	    				<div>
		    				<label>Discrebtion</label>
		    			</div>
		    			<div>
		    				<input type="textarea"  autocomplete="off" name="describtion"  placeholder="Insert the Describtion" />
		    			</div>
	    			</dir>


	    			<!-- Category Include Code-->
	    			<div class=" btn btn-blue">
		    			<input type="submit" name=""  value="Insert Category" />
	    			</div>


	    		</form>
	    	</div>


	    	<?php

	    }elseif($do == 'Insert'){

	    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    		echo '<h1> Insert the new Category</h1>';
	    		// pring the data from insert form

	    		$catparent    =  $_POST['cat-parent'];
	    		$order        =  $_POST['ordering'];
	    		$code         =  $_POST['cat-code'];
	    		$visi         =  $_POST['visibility'];
	    		$comm         =  $_POST['commints'];
	    		$lang         =  $_POST['lang'];
	    		$name         =  $_POST['cat-name'];
	    		$desc         =  $_POST['describtion'];
	    		$addItem      =  $_POST['add-item'];

	    		// Add Photo Function

	    		addFile('images/categories/','image');

	    		// Check If Category Exist in Database

				$check = checkItem("Category_Name", "categories_ml", $name);

				if ($check == 1) {

					$theMsg = '<div class="alert alert-info">Sorry, This Category Is allready Exist</div>';

					redirectHome($theMsg);

				}else{
					// insert the new category details

					$stmt = $con->prepare("INSERT INTO categories(Category_Image, Parent_ID, Category_Display, 	Category_Ordering, Allow_Comments, Allow_Items, Include_Code) VALUES(:zimg, :zparent, :zdisplay, :zorder, :zcomm, :zitem, :zcode)");

					$stmt->execute(array(
						'zimg'   	=> $file,
						'zparent' 	=> $catparent,
						'zdisplay' 	=> $visi,
						'zorder' 	=> $order, 
						'zcomm' 	=> $comm,
						'zitem' 	=> $addItem,
						'zcode'		=> $code
                         ));

					$stmt = $con->prepare("INSERT INTO categories_ml(Category_ID, Lang_ID, Category_Name, Category_Description) VALUES(LAST_INSERT_ID(), :zlang_id, :zname, :zdesc)");

					$stmt->execute(array(
						'zlang_id' 		=> $lang,
						'zname'         => $name,
						'zdesc' 		=> $desc
                         ));	

					// Echo Success Message
					echo '<div class="container">';
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted succesfuly</div>';
  					redirectHome($theMsg);
					echo '</div>';
				}
	    		


	    	}else{
	    		echo '<div>';
				$theMsg = "<div class='alert alert-danger'>Sorry, You dont have permesion to access this page.</div>";
				redirectHome($theMsg);
				echo '</div>';
	    	}


	    }elseif($do == 'Allow_items'){ // Allow the Category *************************************
	    	echo "<h1>Allow Item</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; //short if 


		$check = superGet('*','categories','Category_ID = "$catid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("UPDATE categories SET Allow_Items = 1 WHERE Category_ID = ?");

					$stmt->execute(array($catid));

			// Echo the Message
			echo "<div class='mssg'>";
			$theMsg = "<div class='alert alert-success'> ". $stmt->rowCount() ." Record Updated</div>" ;
			redirectHome($theMsg);
			echo '</div>';
			

		}else{
			echo '<div>';
			$theMsg = "<div class='alert alert-success'>Sorry you dont chose the User.</div>";
			redirectHome($theMsg);
			echo '</div>';
		}
		echo '</div>' ;

	   	}elseif($do == 'Allow_dis'){ // Allow the Category **************************************

		echo "<h1>Allow Item</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; //short if 


		$check = superGet('*','categories','Category_ID = "$catid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("UPDATE categories SET Category_Display = 1 WHERE Category_ID = ?");

					$stmt->execute(array($catid));

			// Echo the Message
			echo "<div class='mssg'>";
			$theMsg = "<div> ". $stmt->rowCount() ." Record Updated</div>" ;
			redirectHome($theMsg,'backX',3);
			echo '</div>';
			

		}else{
			echo '<div>';
			$theMsg = "<div class='alert alert-success'>Sorry you dont chose the User.</div>";
			redirectHome($theMsg);
			echo '</div>';
		}
		echo '</div>' ;

	}elseif ($do == 'Edit'){ // Start Edit Section **************************************************

		 //chek if the  Category Id is Excist and is nummer
		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; //short if 

       // Select All Data Depend on this Id

		$categories = getInnerCat("categories.Category_ID = $catid");

		foreach ($categories as $cat) {
			
		}
		

		?>
	    	<h1> Edit [ <?php echo $cat['Category_Name']; ?> ] Category </h1>

	    	<div class="main_box">

	    		<form action="?do=Update" method="POST" enctype="multipart/form-data">

	    			<!-- Hiden input to use it in Update statement -->
	    			<input type="hidden" name="catid" value="<?php echo $cat['Category_ID']; ?>"/> 	


	    			<!-- Category Parent-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Parent</label>
		    			</div>
		    			<div>
			    			<select class="main_box" name="cat-parent">
			    				<option value="0">Main Category</option>
			    				<?php 
			    				echo '<option value="'.$cat['Category_ID'].'">'.$cat['Category_Name'].'</option>';
			    				$allcats = getInnerCat();
			    				foreach ($allcats as $allcat) {
			    					echo '<option value="'.$allcat["Category_ID"].'">'.$allcat["Category_Name"].'</option>';
			    				}

			    				?>
			    				
			    			</select>
		    			</div>
	    			</div>



	    			<!-- Category Ordering-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Ordering</label>
		    			</div>
		    			<div>
		    				<input type="number" name="ordering" 
		    				value="<?php echo $cat['Category_Ordering']; ?>" 
		    				 required="required" placeholder="Insert display Ordering"/>
		    			</div>
	    			</div>


	    			<!-- Category Include Code-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Code</label>
		    			</div>
		    			<div>
		    				<input type="textarea" name="cat-code" 
		    				value="<?php echo $cat['Include_Code']; ?>" 
		    				 placeholder="Insert the Code"/>
		    			</div>
	    			</div>

	    			<!-- Category Image-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Image</label>
		    			</div>
		    			<div>
		    				<input type="file" name="image" value="<?php echo $cat['Category_Image']; ?>" 
		    				 />
		    				 <!-- placeholder="Select the Image" -->
		    			</div>
		    			<?php echo $cat['Category_Image']; ?>
	    			</div>


	    			<!-- Category Display Allow-->
	    			<div class="main_box">
	    			   <div>
		    				<label>Visible</label>
		    		   </div>
		    		   <div>
						    <input id="vis-yes" type="radio" name="visibility" value="1" <?php if($cat['Category_Display'] == 1){echo 'checked';} ?> />
					   		 <label for="vis-yes">Yes</label>
				        </div>
		    		    <div>
						    <input id="vis-no" type="radio" name="visibility" value="0" <?php if($cat['Category_Display'] == 0){echo 'checked';} ?> />
					   		 <label for="vis-no">No</label>
				   	   </div>
		    			
	    			</div>


	    			<!-- Category Add Items Allow-->
	    			<div class="main_box">
	    			   <div>
		    				<label>Add Items</label>
		    		   </div>
		    		   <div>
						    <input id="vis-yes" type="radio" name="add-item" value="1" <?php if($cat['Allow_Items'] == 1){echo 'checked';} ?> />
					   		 <label for="vis-yes">Yes</label>
				        </div>
		    		    <div>
						    <input id="vis-no" type="radio" name="add-item" value="0" <?php if($cat['Allow_Items'] == 0){echo 'checked';} ?> />
					   		 <label for="vis-no">No</label>
				   	   </div>
		    			
	    			</div>


	    			<!-- Category Commits Allow-->
	    			<div class="main_box">
	    			   <div>
		    				<label>Commints</label>
		    		   </div>
		    		   <div>
						    <input id="vis-yes" type="radio" name="commints" value="1" <?php if($cat['Category_Display'] == 1){echo 'checked';} ?> />
					   		 <label for="vis-yes">Yes</label>
				        </div>
		    		    <div>
						    <input id="vis-no" type="radio" name="commints" value="0" <?php if($cat['Category_Display'] == 0){echo 'checked';} ?> />
					   		 <label for="vis-no">No</label>
				   	   </div>
		    			
	    			</div>



	    		<!-- ** Select The Multilanguage values***************************  -->

	    			<!-- Select The Language-->
	    			<div class="main_box">
	    				<div>
		    				<label>Select The Language</label>
		    			</div>
		    			<div>
		    				<select name="lang">
		    					<?php
		    					echo '<option  value"='.$cat['Lang_ID'].'"selected>'.$cat['Lang_Name'].'</option>';
		    					$languages = superGet('*','languages');
		    					foreach($languages as $lang){
		    						
		    						echo '<option value="'.$lang['Lang_ID'].'">'.$lang['Lang_Name'].'</option>';
		    					  }
		    					?>
		    				</select>
		    				
		    			</div>
	    			</div>


	    			<!-- Category Name-->
	    			<div class="main_box">
	    				<div>
		    				<label>Category Name</label>
		    			</div>
		    			<div>
		    				<input type="text" name="cat-name"  
		    				value="<?php echo $cat['Category_Name']; ?>" 
		    				required="required" placeholder="Insert the Category Name"/>
		    			</div>
	    			</div>




	    			<!-- Category Discrebtion-->
	    			<dir class="main_box">
	    				<div>
		    				<label>Discrebtion</label>
		    			</div>
		    			<div>
		    				<input type="textarea"  
		    				value="<?php echo $cat['Category_Description'];?>" 
		    				autocomplete="off" name="describtion"  placeholder="Insert the Describtion" />
		    			</div>
	    			</dir>


	    			<!-- Category Include Code-->
	    			<div >
		    			<input class=" btn btn-success" type="submit" name=""  value="Edit Category" />
	    			</div>


	    		</form>
	    	</div>


	    	<?php

		
	}elseif ($do == 'Update'){ // Update The Category *******************************************

		echo '<h1 class="text-center">Update Category informations</h1>' ;

		echo '<div>';              // To control the form designe

		if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 

		// Get the Variable from the Form
				$catid        =  $_POST['catid'];
				$catparent    =  $_POST['cat-parent'];
	    		$order        =  $_POST['ordering'];
	    		$code         =  $_POST['cat-code'];
	    		$visi         =  $_POST['visibility'];
	    		$comm         =  $_POST['commints'];
	    		$lang         =  $_POST['lang'];
	    		$name         =  $_POST['cat-name'];
	    		$desc         =  $_POST['describtion'];
	    		$addItem      =  $_POST['add-item'];


	    		// Update the Photo IF is set in the form
	    		
	    		if(strlen($_FILES['image']['name']) !== 0){ // check if ther is Post photo
	    			
	    				addFile('images/categories/','image'); // use addPhoto Function ($file = autput variable)
	    			
	    		}
	    		else{ // if ther is no new photo
		                $catimgs = superGet('*','categories',"Category_ID = '$catid'");// pring photo name from DB
		                foreach ( $catimgs as $catimg) {

		                }
		              
		                	$file = $catimg['Category_Image']; // Set $file = old photo Name
	    	}
	    			
	    			
		


			//Update Categories table in The DB With This informations
			$stmt = $con->prepare("UPDATE categories SET   	Category_Image = ?, Parent_ID = ?, Category_Display = ?, Category_Ordering = ?, Allow_Comments = ?,Allow_Items =?, Include_Code = ?   WHERE Category_ID = ?");
			$stmt->execute(array($file, $catparent, $visi, $order, $comm,$addItem, $code , $catid)) ;

			//Update Categories_ML table in The DB With This informations
			$stmt = $con->prepare("UPDATE categories_ml SET  Category_Name = ?, Category_Description = ?   WHERE Category_ID = ?");
			$stmt->execute(array($name, $desc, $catid)) ;


			// echo Success message
			echo '<div>';
			$theMsg = '<div > One Record Updated </div>';
			redirectHome($theMsg);
			echo '</div>';
		 

		}else{
			echo '<div class="container">';
			$theMsg ='<div class="alert alert-danger">Sorry can not go directly to this Page</div>';
			redirectHome($theMsg) ;
			echo '</div>';
		  }

		

		echo '</div>'; 


	}elseif ($do == 'Delete'){
		echo "<h1>Delete Category</h1>";
		echo "<div>";
		

		       //chek if the Id is Excist and is nummer
		$cat = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; //short if 


		$check = superGet('Category_ID', 'categories','Category_ID = "$catid"') ;


				if($check > 0){ 

					$stmt = $con->prepare("DELETE FROM Categories WHERE Category_ID = :zcat");

					$stmt->bindParam(":zcat", $cat);

					$stmt->execute();

			// Echo the Message
			echo '<div>';
			$theMsg = "<div class='alert alert-danger'>  The Record Deleted</div>" ;
			redirectHome($theMsg);
			echo '</div>';



			

		}else{
			echo '<div>';
			$theMsg = "<div class='alert alert-info'>Sorry you dont chose the User.</div>";
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