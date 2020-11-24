<?php
include 'dbcontroller.php';
$db_handle = new DBController();

if(isset($_POST['sewadar_name'])&&isset($_POST['short_name'])&&isset($_POST['type'])&&!empty($_POST['sewadar_name'])&&!empty($_POST['short_name'])&&!empty($_POST['type'])){

	$sewadar_name = $_POST['sewadar_name'];
	$short_name = $_POST['short_name'];
	$type = $_POST['type'];

	if($sewadar_name !='' || $short_name !='' || $type !=''){
		$row_count = $db_handle->numRows("SELECT * FROM `sewadars` WHERE `sewadar_name`='".$sewadar_name."'");

		if ($row_count == 0) {
			$result = $db_handle->executeUpdate("INSERT INTO `sewadars` (`id`, `sewadar_name`, `short_name`, `type`) VALUES ('', '".$sewadar_name."', '".$short_name."', '".$type."')");
			if ($result == 1) {
				header("Location: add_sewadar.php");
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