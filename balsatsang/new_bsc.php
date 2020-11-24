<?php
include 'dbcontroller.php';
$db_handle = new DBController();

if(isset($_POST['sewadar_name'])&&!empty($_POST['sewadar_name'])){

	$sewadar_name = $_POST['sewadar_name'];

	if($sewadar_name !=''){
		$row_count = $db_handle->numRows("SELECT * FROM `bsc` WHERE `name`='".$sewadar_name."'");

		if ($row_count == 0) {
			$result = $db_handle->executeUpdate("INSERT INTO `bsc` (`id`, `name`) VALUES ('', '".$sewadar_name."')");
			if ($result == 1) {
				header("Location: add_bsc.php");
			} else {
				echo "Insertion Failed";
			}
		}
		else {
			echo "Already Exist";
		}
	}
}
else {
	echo "Empty Fields Inserted.";
}
?>