<?php

/**
 * Delete employee data file.
 */

require_once('classlib/db_class.php');
require_once('config/constants.php');

$db_obj = Database::get_instance();
$conn = $db_obj->get_connection();

if (isset($_GET['emp_id']) && preg_match('/^[0-9]*$/', $_GET['emp_id'])) {
    $emp_id = $conn->real_escape_string($_GET['emp_id']);

    $sql_query = "SELECT employee.photo AS photo
        FROM employee
        WHERE employee.id = $emp_id";

    $result = mysqli_query($conn, $sql_query);
    $row = mysqli_fetch_assoc($result);
    $photo = PROFILE_PIC . $row['photo'];

    // Delete data from address table
    $sql = "DELETE FROM address WHERE employee_id = $emp_id";
    $result = mysqli_query($conn, $sql);

    if (FALSE === $result) {
        header('Location: error.php');
    }

    // Delete data from employee table.
    $sql = "DELETE FROM employee WHERE id = $emp_id";
	$result = mysqli_query($conn, $sql);

    if (FALSE === $result) {
        header('Location: error.php');
    }

    // Delete profile pic
    unlink($photo);
}

header('Location: employee.php');
