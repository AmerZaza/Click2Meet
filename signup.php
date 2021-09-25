<?php 
ob_start();
	session_start();
	$pageTitle = 'Sign Up | A to Z for All';
	if (isset($_SESSION['user'])) {
	header('Location:index.php'); // Forowrd to the next Page If the session is allready exist 	before
        exit();
	}
include 'init.php';

// Check if the User is comming From HTTP POST Connect
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        $formErrors = array();
        
        $username   = $_POST['username'];
        $password1  = $_POST['password1'];
        $password2  = $_POST['password2'];
        $email      = $_POST['email'];
        $fullname   = $_POST['fullname'];
        $lang       = $_POST['lang'];

        $pwKey = rand(1000,9999);//Password Secret Key
        
        // Check Boxes 
        if (isset($_POST['accebt']) && $_POST['accebt'] = 'YES'){
            $accept     = 1;
        }else {$accept  = 0;
        }

        if (isset($_POST['news']) && $_POST['accebt'] = 'YES'){
            $news     = 1;
        }else {$news  = 0;
        }
        

        if (isset($username)){
            $filterdUser = tSec($username);  // filter_var($username,FILTER_SANITIZE_STRING)
            if (strlen($filterdUser) < 4){
                $formErrors[] =  getT('The Username must be longer than 3 letters');
            }else{
                $_GET['userName'] = $filterdUser;
            }
        }

        if (isset($password1) && isset($password2)){
            if (strlen($password1) < 6){
                $formErrors[] = getT('The Password must be more than 5 Charecter');
            }
          
            
            if (sha1($password1) !== sha1($password2)){
                $formErrors[] = getT('The Passwords must be same') ;
            } 
        }
        if(isset($email)){
            $filterdEmail = eSec($email) ;  //   filter_var($email, FILTER_SANITIZE_EMAIL)
            if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true){
                $formErrors[] = getT('This is not Email Form');
            }else{
                $_GET['email'] =  $filterdEmail;
            }
        }
        if (isset($fullname)){
            $filterdFull = tSec($fullname);  // filter_var($username,FILTER_SANITIZE_STRING)
            if (strlen($filterdFull) < 4){
                $formErrors[] = getT('The Full Name must include more than 3 letters');
            }else{
                $_GET['fullName'] = $filterdFull;
            }
            
        }
        if (!isset($_POST['accebt'])){ //////////////Check
                $formErrors[] = getT('You must to Accept the using agriment');
        }

        // Check if User Exist in DB (using CheckItem Function)
        $check = checkItem("Email","users",$email);

        if($check == 1){
                         
                $formErrors[] = getT('Sorry this Email is Exist, Please insert new Email') ; 
        }


        if(empty($formErrors)){ // If All Fields in form is OK 

					// Check if User Exist in DB (using CheckItem Function)
					$check = checkItem("User_Name","users",$username);

					 if($check == 1){
                         
                         $formErrors[] = 'Sorry this user is Exist, Pleas chose another User Name' ;
                         

					 }else{
                            // Just to get Location ID 
                      //  $stmt = $con->prepare("INSERT INTO locations_text() VALUES()");
                     //   $stmt->execute(array());  LAST_INSERT_ID(),  U_Location_ID,


 

					//Insert User in DB
						$stmt = $con->prepare("INSERT INTO users(User_Name, Password, Change_PW_K, Email,Full_Name, Select_Lang ,User_Status, Accept , News ,  Regis_Time) VALUES(:zuser, :zpass, :zpasskey, :zemail ,:zfullname, :zlang,1 ,:zaccebt, :znews, now())");
						$stmt->execute(array('zuser' => $username,'zpass' => sha1($password1),'zpasskey' => $pwKey, 'zemail' => $email, 'zfullname'=>$fullname, 'zlang'=>$lang, 'zaccebt'=>$accept, 'znews'=>$news));

                        
                            /*
                        // Add to Subscribe List IF Accept
                        if (isset($_POST['news']) && $_POST['accebt'] = 'YES'){

                            $stmt = $con->prepare("INSERT INTO subscribe(Subscribe_Name, Subscribe_Email, Lang_ID) VALUES(:zfullname, :zemail , :zlang)");
                        $stmt->execute(array('zfullname' => $fullname,'zemail' => $email, 'zlang'=>$lang));
                                
                            } */
					

					// echo Success message
					$successMs = '<div class="alert alert-success">'.getT('Your data will studied from the management').'</div>';
                   redirectHome($successMs,"login.php" ,4);

					}
        }
    }


 // Get Value from inputs   
    if(isset($_GET['userName'])){$userName = $_GET['userName'];}else{$userName = NULL;}
    if(isset($_GET['email'])){$email = $_GET['email'];}else{$email = NULL;}
    if(isset($_GET['fullName'])){$fullN = $_GET['fullName'];}else{$fullN = NULL;}


?>

    

    <h2 class="text-center"> <?php getTE('Register as new user');?></h2>
    <!-- Start SignUp Form-->
    <div class="container">
        <div class="row">
            
        
    <div class=" col-md-offset-4 col-md-4  mine-box ">
        
    
    <form class="signup" data-class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <div class="col col-md-12">
            <div class="input-container">
            <input class="form-control" type="text" name="username" autocomplete="off" placeholder="<?php getTE('User Name');?>" required="required" patternX="[A-Za-z]{4}" title="The User Name is not Validate" value="<?php echo $userName; ?>">
            </div>
        </div>
        <div class="col col-md-12">
            <div class="input-container">
                <input class="form-control" type="text" name="fullname" autocomplete="off" placeholder="<?php getTE('Full Name');?>" required="required" patternX="[A-Za-z]{4}" title="The Full Name " value="<?php echo $fullN; ?>" >
            </div>
        </div>

        <div class="col col-md-12">
            <div class="input-container">
                <input class="form-control" type="password" name="password1" autocomplete="new-password" placeholder="<?php getTE('Password');?>" required="required" minlenghtX="6" maxlengthX="12">
            </div>
        </div>

        <div class="col col-md-12">
            <div class="input-container">
                <input class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="<?php getTE('Re-Password');?>" required="required" minlenghtX="6" maxlengthX="12">
            </div>
        </div>

        <div class="col col-md-12">
            <div class="input-container">
                <input class="form-control" type="text" name="email"  placeholder="<?php getTE('Email');?>" required="required" value="<?php echo $email; ?>" >
            </div>
        </div>

        <div class="col col-md-12">
            <div class="input-container">
                <select class="form-control" name="lang" >
                    <option value="11"> <?php getTE('Select The Language');?></option>
                    <?php 
                    $langs = superGet('*','languages',"Lang_ID != 1 AND Lang_Used = 1");
                    foreach ($langs as $lang) {
                        echo '<option value="'.$lang['Lang_ID'].'">'.$lang['Lang_Name'].'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="form-group form-group-lg">
                <div class="row">
                        <input class="col col-md-1" type="checkbox" name="accebt"  value="YES">
                        <label class="col col-md-9" ><?php echo getT('I accept').' <a href="Terms_of_use.php">'.getT('the using agreement').','.getT('Data Protection').'</a>';?></label>
                    </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group form-group-lg">

                <div class="row">
                        <input class="col col-md-1" type="checkbox" name="news"   value="YES">
                        <label class="col col-md-9" ><?php getTE('Send me news latter');?></label>
                    </div>
            </div>
        </div>

        
    <div class="col col-md-12">
        <input class="btn btn-success btn-block " type="submit" name="signup" value="<?php getTE('SignUp');?>">
    </div>
    </form>

    
</div>
</div>
    </div>
    <!-- End SignUp Form-->


    <!-- Start Message Box -->
<div class="container text-center">
    
    <?php 
    
    if (!empty ($formErrors )){
        echo '<div class="alert alert-danger">';
        foreach ($formErrors as $error){
        echo '§ ' . $error .'<br>';
        }
        echo '</div>'; 
    }
        /*
          
        if (isset($successMs)){
            echo '<div class="alert alert-success">';
            echo $successMs ;
            echo '</div>' ;
            } */
        ?>
    
</div>
    <!-- Start Message Box -->

<?php  
include $tpl .'footer.php' ;  
    ?>