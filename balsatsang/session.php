<?php
require 'dbcontroller.php';

$db_handle = new DBController();

session_start();
$user_check=$_SESSION['username'];
 
$login_user= $db_handle->runQuery("SELECT username FROM users WHERE username='$user_check'");
 
if(!isset($user_check))
{
header("Location: login.php");
}
?>