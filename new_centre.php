<?php
include 'dbcontroller.php';
$db_handle = new DBController();

if(isset($_POST['centre_name'])&&!empty($_POST['centre_name'])&&isset($_POST['days'])&&!empty($_POST['days'])){

	$centre_name = $_POST['centre_name'];

	$days=implode(",",$_POST['days']);

	if($centre_name !=''||$days !=''){
		$row_count = $db_handle->numRows("SELECT * FROM `centres` WHERE `name`='".$centre_name."'");

		if ($row_count == 0) {
			$result = $db_handle->executeUpdate("INSERT INTO `centres` (`id`, `name`, `days`) VALUES ('', '".$centre_name."', '".$days."')");
			if ($result == 1) {
				header("Location: add_centre.php");
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