<?php
session_start();

if (isset($_SESSION['emp_id']) && (isset($_SESSION['is_completed']) && 1 == $_SESSION['is_completed']))
{

    require_once('classlib/db_class.php');
    require_once('config/constants.php');
    require_once('classlib/employee_class.php');
    require_once('classlib/address_class.php');

    $db_obj = Database::get_instance();
    $conn = $db_obj->get_connection();
    $table = 'employee';
    $condition = 'WHERE id =' . $_SESSION['emp_id'];
    $result = $db_obj->select($table, 'photo',$condition);
    $row = mysqli_fetch_assoc($result);
    $photo = PROFILE_PIC . $row['photo'];

    if (FALSE === $db_obj->delete($table, $condition)) {
        header('Location: error.php');
    }

    // Delete profile pic
    unlink($photo);
    unset($_SESSION['emp_id']);
    unset($_SESSION['is_completed']);
    setcookie('emp_id', '', time() - 3600);
    setcookie('is_completed', '', time() - 3600);

    if (session_destroy())
    {
    header('Location: index.php');
    }

} else {
header('Location: index.php');
}
