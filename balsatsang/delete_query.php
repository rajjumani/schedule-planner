<?php
include 'dbcontroller.php';
$table = explode("/", $_GET['id']);
$table_name = $table[0];
$id = $table[1];
$db_handle = new DBController();
if ($table_name == 'master') {
	if ($result = $db_handle->executeUpdate("DROP TABLE `".$id."`")) {
		echo "Deleted Successfully";
	} else {
		echo "Failed to Delete";
	}
} else {
	if ($result = $db_handle->executeUpdate("DELETE FROM `".$table_name."` WHERE  id=".$id)) {
		if (strcmp($table_name, "bsk") == 0) {
			header("Location: edit_bsk.php");
		} 
		else if (strcmp($table_name, "bsp") == 0) {
			header("Location: edit_bsp.php");
		}
		else if (strcmp($table_name, "bsc") == 0) {
			header("Location: edit_bsc.php");
		}
	} else {
		echo "Failed to Delete";
	}
}
?>