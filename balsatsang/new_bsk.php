<?php
include 'dbcontroller.php';
$db_handle = new DBController();

if(isset($_POST['sewadar_name'])&&isset($_POST['mob'])&&!empty($_POST['sewadar_name'])&&!empty($_POST['mob'])){

	$sewadar_name = $_POST['sewadar_name'];
	$mob = $_POST['mob'];

	if($sewadar_name !='' || $mob !=''){
		$row_count = $db_handle->numRows("SELECT * FROM `bsk` WHERE `name`='".$sewadar_name."'");

		if ($row_count == 0) {
			$result = $db_handle->executeUpdate("INSERT INTO `bsk` (`id`, `name`, `mob`) VALUES ('', '".$sewadar_name."', ".$mob.")");
			if ($result == 1) {
				header("Location: add_bsk.php");
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