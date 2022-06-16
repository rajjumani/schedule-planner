<?php
include 'dbcontroller.php';
$db_handle = new DBController();

if(isset($_POST['baani_name'])&&isset($_POST['sewadar_name'])&&!empty($_POST['baani_name'])&&!empty($_POST['sewadar_name'])){

	$baani_name = $_POST['baani_name'];
	$sewadar_name = $_POST['sewadar_name'];

	if($baani_name !='' || $sewadar_name !=''){
		$row_count = $db_handle->numRows("SELECT * FROM `baani` WHERE `baani_name`='".$baani_name."' AND `sewadar_name`='".$sewadar_name."'");
		if ($row_count == 0) {
			$result = $db_handle->executeUpdate("INSERT INTO `baani` (`id`, `baani_name`, `sewadar_name`) VALUES ('', '".$baani_name."', '".$sewadar_name."')");
			if ($result == 1) {
				header("Location: add_baani.php");
			} else {
				echo "Insertion Failed";
			}
		} else {
			echo "Already Exist";
		}
	}
}
else {
	echo "Empty Fields Inserted.";
}
?>