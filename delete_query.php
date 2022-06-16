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
		if (strcmp($table_name, "centres") == 0) {
			header("Location: edit_centre.php");
		} else if (strcmp($table_name, "sewadars") == 0) {
			header("Location: edit_sewadar.php");
		} else if (strcmp($table_name, "leaves") == 0) {
			header("Location: leave_month_selector.php");
		} else if (strcmp($table_name, "baani") == 0) {
			header("Location: edit_baani.php");
		}
	} else {
		echo "Failed to Delete";
	}
}
?>