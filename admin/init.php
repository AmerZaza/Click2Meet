<?php
include 'connect.php';
include '../configuration.php';
// Routes
$tpl = 'includes/templates/'; //Template Directory
$css = 'layout/css/'; // CSS Directory
$js = 'layout/js/';  // JS Directory
$func = '../includes/functions/' ; // Functions Directory

//include The Importants Files 

include $func ."functions.php";
include  $tpl ."header.php";


//Chek if we need the Navbar in the pages or not like(login.php)
if (!isset($noNavbar)){
	include 'navbar.php';}


