<?php
session_start();

if (isset($_SESSION['adminName'])) {
	$pageTitle='Translate the Insertings';
	include 'init.php';
// function to return ID & ml- insertin 
function tInserting($table,$field,$parentTable){
    $Xs = superGet('*',$table,"Lang_ID = 1");
      foreach ($Xs as $x) {
         echo '<li><a href="'.$_SERVER['PHP_SELF'].'?sRid='.$x['ID'].'&sTable='.$table.'&sField='.$field.'&sText='.$x[$field].'&sParentTable='.$parentTable.'&sParentID='.$x[$parentTable].'">'.$x[$field].'</a></li>';
       } 
    }

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start Manage Page
if($do == 'Manage'){  // Manage page 


	?>
<div class="container home-stats text-center">
    	<h1 class="title">Translate the Insertings</h1>
    	<div class="row">

        <div class="col col-md-6">
          <div class="main-text">
            <ul>
                    <?php
                    // Get Main Text to translate  re_items_ml
                    $mTexts = tInserting("categories_ml","Category_Name","Category_ID");
                    //$mTexts = tInserting("items_ml","Item_Name","Item_ID");
                    $mTexts = tInserting("currencies_ml","Currency_Name","Currency_ID");
                   // $mTexts = tInserting("re_items_ml","RE_Description","RE_Item_ID");
                    $mTexts = tInserting("praxis_ml","Praxis_Name","Praxis_ID");
                    $mTexts = tInserting("am_body_types_ml","AM_Body_Type_Name","AM_Body_Type_ID");
                    $mTexts = tInserting("am_colors_ml","AM_Color_Name","AM_Color_ID");
                    $mTexts = tInserting("am_emission_stickers_ml","AM_Emission_Sticker_Name","AM_Emission_Sticker_ID");
                    $mTexts = tInserting("am_fuel_ml","AM_Fuel_Name","AM_Fuel_ID");
                    $mTexts = tInserting("am_gearboxes_ml","AM_Gearbox_Name","AM_Gearbox_ID");
                    $mTexts = tInserting("am_sales_methods_ml","AM_Sales_Method_Name","AM_Sales_Method_ID");
                    $mTexts = tInserting("am_usings_ml","AM_Using_Name","AM_Using_ID");
                    $mTexts = tInserting("re_heating_ml","RE_Heating_Name","RE_Heating_ID");
                    $mTexts = tInserting("re_types_ml","Type_Name","RE_Type_ID");
                    $mTexts = tInserting("ws_services_ml","WS_Service_Name","WS_Service_ID");
                    $mTexts = tInserting("sp_groups_ml","SP_Group_Name","SP_Group_ID");
                    $mTexts = tInserting("sp_main_items_ml","SP_Main_Item_Name","SP_Main_Item_ID");

                 ?>
               </ul>
          </div>
          
        </div>

         <div class="col col-md-6">

          <div class="">
            <?php 

            $rRid = isset($_GET['sRid']) && is_numeric($_GET['sRid']) ? intval($_GET['sRid']) : 0; //short if 

            if (isset($_GET['sTable'])){
              $rTable = $_GET['sTable'] ;  }

            if (isset($_GET['sField'])){
              $rField = $_GET['sField'] ;  }

            if (isset($_GET['sText'])){
              $rText = $_GET['sText'] ;  }

            if (isset($_GET['sParentTable'])){
              $rParentT = $_GET['sParentTable'] ;  }  

            if (isset($_GET['sParentID'])){
              $rParentID = $_GET['sParentID'] ;  }
     

            if (isset($rRid) && isset($rTable) && isset($rParentT)){

              $Texts = superGet('*',$rTable,"ID = $rRid");
              foreach ($Texts as $Text) { }
                              ?>

            <form action="<?php echo $_SERVER['PHP_SELF'].'?do=insert-update';?>" method="POST">

              <input type="hidden" name="recordID" value="<?php echo $rRid; ?>" > 
              <input type="hidden" name="tableN" value="<?php echo $rTable; ?>" > 
              <input type="hidden" name="parentID" value="<?php echo $rParentID; ?>">
              <input type="hidden" name="fildN" value="<?php echo $rField; ?>"> 
              <input type="hidden" name="parentN" value="<?php echo $rParentT; ?>"> 


              <div class="col col-md-12">

                 <label class="form-control"><?php echo $rText; ?></label>
              </div>

              <div class="col col-md-12">
                 <select name="langID" class="form-control">
                  <option> Select Language</option>
                  <?php 
                  $langs = superGet('*','languages',"Lang_ID != 1");
                  foreach ($langs as $lang) {
                    echo '<option value="'.$lang['Lang_ID'].'">'.$lang['Lang_Name'].'</option>';
                  }
                   ?>
                 </select>
              </div>

              <div class="col col-md-12">
                 <input type="textarea" name="nText" class="form-control " placeholder="Insert Text Hier">
              </div>

              <div class="col col-md-12">
                <input class="btn btn-info" type="submit" value="Save">
              </div>

            </form>
          </div>


          <div class="text-table">
              <table class="table table-striped">
              <tr>
                <td>Main Text</td>
                <td>Language</td>
                <td>Controls</td>
              </tr>

                <?php               
                
                if (!empty($rRid)){

                $rows = superGet('*',$rTable,"$rParentID = $rParentT");
               

                foreach ($rows as $row) {
                  //Get Language Name
                  $languID = $row['Lang_ID'];
                  $langNames = superGet('*','languages',"Lang_ID = $languID");
                  foreach ($langNames as $langName) {}

                  echo '<tr>';
                  echo '<td>'.$row[$rField].'</td>';
                  echo '<td>'.$langName['Lang_Name'].'</td>';
                    if ($langName['Lang_ID'] ==1){ echo '<td> Main </td>'; 
                    }else{
                  echo '<td>
                        <a class="btn btn-danger" href = "'.$_SERVER['PHP_SELF'].'?do=delete&tID='.$row['ID'].'&table='.$rTable.'">Delete</a>
                  </td>';}
                  echo ' </tr>';
                  }// end for each 
                }
                
                ?>
          </div>
          
        </div>

      </div>
	<?php
  }// end if $rText id isset

}elseif ( $do == 'insert-update'){


  $rNtext = $_POST['nText'];

  if(empty($rNtext)){//if the is no insert in input from visitor
    $msg = '<div class="alert alert-danger">Pleas insert the new Value</div>';
      redirectHome($msg,'t_insrtings.php?do=Manage',1);
 
  }else{
    $rLang     = $_POST['langID']; 
    $rTextID   = $_POST['recordID']; 
    $rTableN   = $_POST['tableN']; 
    $rParent_ID = $_POST['parentID']; //XXXXXXX
    $rParentTn = $_POST['parentN']; 
    $rFildN    = $_POST['fildN']; 
    

    //Check if the DB include record in same (LANGUAGE&MainText)
    $records = superGet('*',$rTableN,"$rParentTn = $rParent_ID AND  Lang_ID = $rLang");
    foreach ($records as $record) { }
      if (empty($records)){

        $stmt = $con->prepare("INSERT INTO $rTableN ($rParentTn, $rFildN, Lang_ID) VALUES(:zparentid, :ztext, :zlang)");

                $stmt->execute(array(
                  'zparentid' => $rParent_ID,
                  'ztext'     => $rNtext,
                  'zlang'     => $rLang
                      ));

          $msg = '<div class="alert alert-success">The Translate Inserted succssesfuly</div>';

          redirectHome($msg,'t_insertings.php',1);

      }else{// End if the is no record in same TextID & LangID

        $intMLid = $record['ID'];
        
        $stmt = $con->prepare("UPDATE $rTableN SET $rFildN = ? WHERE ID = ?");

        $stmt->execute(array($rNtext , $intMLid));


        $msg = '<div class="alert alert-success">The Translate Updated succssesfuly</div>';
          redirectHome($msg,'t_insertings.php?do=Manage',1);


      }// end if the is allready record in same TextID & LangID 
  }//end elseif the is input value 


  }elseif ( $do == 'delete'){

    $rTid = isset($_GET['tID']) && is_numeric($_GET['tID']) ? intval($_GET['tID']) : 0; //short if 
  
    if (isset($_GET['table'])){
       $rTableN = $_GET['table']; }

    $check = superGet('ID', $rTableN , "ID = $rTid") ;

        if($check > 0){ 

          $stmt = $con->prepare("DELETE FROM $rTableN WHERE ID = :zid");

          $stmt->bindParam(":zid", $rTid);

          $stmt->execute();

    $msg = '<div class="alert alert-success">The Translate Deleted</div>';
  redirectHome($msg,'t_insertings.php?do=Manage',1);
    }
  } // END else if


}else{
		header('Location:index.php'); // Forowrd to the next Page If the session;
	}
include  $tpl ."footer.php";
?>