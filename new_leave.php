<?php
include 'dbcontroller.php';
$db_handle = new DBController();

if(isset($_POST['sewadar_name'])&&isset($_POST['from_date'])&&isset($_POST['to_date'])&&!empty($_POST['sewadar_name'])&&!empty($_POST['from_date'])&&!empty($_POST['to_date'])){

	$sewadar_name = $_POST['sewadar_name'];
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$month=date("m",strtotime($from_date));
	$year=date("Y",strtotime($from_date));
	$day = 01;
	$full_date = $year.'-'.$month.'-'.$day;
	
	$result = $db_handle->executeUpdate("INSERT INTO `leaves` (`id`, `sewadar_name`, `month`, `from_date`, `to_date`) VALUES ('', '".$sewadar_name."', '".$full_date."', '".$from_date."', '".$to_date."')");
	if ($result == 1) {
		header("Location: add_leave.php");
	} else {
		echo "Insertion Failed";
	}
}
else {
	echo "Empty Fields Inserted.";
}
?>