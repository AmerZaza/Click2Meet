<?php
/*

	ob_start();
	session_start();
	$noNavbar = ''; //to remover the navbar from this page
	$pageTitle = 'login';
	if (isset($_SESSION['adminName'])) {
	header('Location:dashboard.php'); // Forowrd to the next Page If the session is allready exist 	before
	}

	include 'init.php';

	// Check if the User is comming From HTTP POST Connect
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['user'];
	$password = $_POST['pass'];
	$hashedPass = sha1($password);

	// Chek if the user is EXIST in DB *Excute Statement*
	
	$admins = superGet("*", "users","User_Name = '$username' AND Password = '$hashedPass' AND User_Group = 0"); // when user is not normal visitor
	foreach ($admins as $admin) {}
		
	
	if (!empty($admin) ) {
		$_SESSION['adminName']=$username;  // Regist the Session Name
		$_SESSION['adminID']= $admin["User_ID"]; // Regist Session ID
		$_SESSION['adminGroup']= $admin["User_Group"]; // Regist User Group
		$_SESSION['selectLang'] = $admin['Select_Lang'];// Regist Session Language

		header('Location:dashboard.php'); // Forowrd to the next Page 
		exit();          				 
	}
} 
?>


<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	<h4> Login</h4>
	<input  type="text" name="user" placeholder="Username" autocomplete="off" />
	<input type="password" name="pass" placeholder="password" autocomplete="new-password" />
	<input  class="btn" type="submit" name="Login" />
	
</form>

<?php
*/
//include $tpl .'footer.php';
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

<h1>My First Heading</h1>
<p>My first paragraph.</p>

</body>
</html>