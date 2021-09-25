<?php
session_start();

if (isset($_SESSION['adminName'])) {
	$pageTitle='Translate the Intefaces';
	include 'init.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start Manage Page
if($do == 'Manage'){  // Manage page 


	?>
<div class="container home-stats text-center">
    	<h1 class="title">Translate the Intefaces</h1>
    	<div class="row">

        <div class="col col-md-6">
          <div class="main-text">
            <ul>
                    <?php
                    // Get Main Text to translate
                    $mTexts = superGet('*','interface',"Text_ID != 0","Base_T");
                    foreach ($mTexts as $mText) {
                   
                      echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?tID='.$mText['Text_ID'].'">'.$mText['Base_T'].'</a></li>';
                    }
                 ?>
               </ul>
          </div>
          
        </div>

         <div class="col col-md-6">

          <div class="">
            <?php 
            $rText = isset($_GET['tID']) && is_numeric($_GET['tID']) ? intval($_GET['tID']) : 0; //short if 

              if (isset($rText)){

              $Texts = superGet('*','interface_ml',"Interface_ID = $rText");
              $mTexts = superGet('*','interface',"Text_ID = $rText");

              foreach ($Texts as $Text){}
              foreach ($mTexts as $mText) {}
                ?>

            <form action="<?php echo $_SERVER['PHP_SELF'].'?do=insert-update';?>" method="POST">

              <input type="hidden" name="intefaceid" value="<?php echo $rText; ?>" class="form-control ">

              <div class="col col-md-12">

                 <label class="form-control"><?php echo $mText['Base_T']; ?></label>
              </div>

              <div class="col col-md-12">
                 <select name="langText" class="form-control ">
                  <?php 
                  $langs = superGet('*','languages',"Lang_ID != 1");
                  foreach ($langs as $lang) {
                    echo '<option value="'.$lang['Lang_ID'].'">'.$lang['Lang_Name'].'</option>';
                  }
                   ?>
                 </select>
              </div>

              <div class="col col-md-12">
                 <input type="textarea" name="nText" class="form-control " >
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
                
                if (!empty($rText)){

                
                foreach ($Texts as $Text) {
                  //Get Language Name
                  $languID = $Text['Lang_ID'];
                  $langNames = superGet('*','languages',"Lang_ID = $languID");
                  foreach ($langNames as $langName) {}
                  echo '<tr>';
                  echo '<td>'.$Text['View_Text'].'</td>';
                  echo '<td>'.$langName['Lang_Name'].'</td>';
                  echo '<td>
                        <a class="btn btn-danger" href = "'.$_SERVER['PHP_SELF'].'?do=delete&tID='.$Text['ID'].'">Delete</a>
                  </td>';
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

  if(empty($rNtext)){//if thir is no insert in input from visitor
    $msg = '<div class="alert alert-danger">Pleas insert the new Value</div>';
      redirectHome($msg,'t_interfaces.php?do=Manage',4);

  }else{

    $rLang = $_POST['langText'];
    $rTextID = $_POST['intefaceid'];

    //Check if the DB include record in same (LANGUAGE&MainText)
    $records = superGet('*','interface_ml',"Interface_ID = $rTextID AND  Lang_ID = $rLang");
    foreach ($records as $record) { }
      if (empty($records)){

        $stmt = $con->prepare("INSERT INTO interface_ml(Interface_ID, Lang_ID , View_Text) VALUES(:zinterfaceid, :zlang, :zinterface)");

                $stmt->execute(array(
                  'zinterface'   => $rNtext,
                  'zinterfaceid' => $rTextID,
                  'zlang'        => $rLang
                      ));

          $msg = '<div class="alert alert-success">The Translate Inserted succssesfuly</div>';
          redirectHome($msg,'t_interfaces.php?do=Manage',1);

      }else{// End if the is no record in same TextID & LangID

        $intMLid = $record['ID'];
        
        $stmt = $con->prepare("UPDATE interface_ml SET View_Text = ? WHERE ID = ?");

        $stmt->execute(array($rNtext , $intMLid));

        $msg = '<div class="alert alert-success">The Translate Updated succssesfuly</div>';
          redirectHome($msg,'t_interfaces.php?do=Manage',2);


      }// end if the is allready record in same TextID & LangID
  }//end elseif the is input value 

  }elseif ( $do == 'delete'){

    $rTid = isset($_GET['tID']) && is_numeric($_GET['tID']) ? intval($_GET['tID']) : 0; //short if 


    $check = superGet('ID', 'interface_ml','ID = "$rTid"') ;

        if($check > 0){ 

          $stmt = $con->prepare("DELETE FROM interface_ml WHERE ID = :zid");

          $stmt->bindParam(":zid", $rTid);

          $stmt->execute();

    $msg = '<div class="alert alert-success">The Translate Deleted</div>';
  redirectHome($msg,'t_interfaces.php?do=Manage',3);
    }
  } // END else if


}else{
		header('Location:index.php'); // Forowrd to the next Page If the session;
	}

  include  $tpl ."footer.php";
?>