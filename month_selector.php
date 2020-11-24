<?php
include 'dbcontroller.php';
$db_handle = new DBController();
session_start();
if(isset($_POST['NoIconDemo'])&&!empty($_POST['NoIconDemo'])){

	$month = $_POST['NoIconDemo'];
	$_SESSION['selected_month'] = $month;
}
else {
	echo "Empty Fields Inserted.";
}
?>