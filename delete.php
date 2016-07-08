<?php
require_once('error_log.php');
require_once('session_header.php');
require_once('libraries/Database.php');
require_once('config/constants.php');

$db_obj = Database::get_instance();
$conn = $db_obj->get_connection();

$table = 'employee';
$condition = 'WHERE id =' . $_SESSION['emp_id'];
$result = $db_obj->select($table, 'photo',$condition);
$row = mysqli_fetch_assoc($result);
$photo = PROFILE_PIC . $row['photo'];

if (FALSE === $db_obj->delete($table, $condition))
{
    header('Location: error.php');
}

// Delete profile pic
unlink($photo);
header('Location: logout.php');
