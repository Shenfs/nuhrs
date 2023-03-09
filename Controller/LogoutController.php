<?php 
include_once('../db-connection.php');//include file
session_start();//starting session
session_destroy();//ending session
include_once('../Utilities/insertToActivityLogs.php');

$db = new DatabaseConnection();
insertToActivityLogs($db->conn,$_POST['user_id'],"Logout","Date and Time: ".date('Y-m-d H:i A'));

header("Location: ../login.php");//redirect user in login page after logout button is clicked
?>