<?php
session_start(); // Start the Session
session_unset(); // Unset The Data 
session_destroy();// Destroy the Session
header('Location: index.php'); // Go to main Page
exit();