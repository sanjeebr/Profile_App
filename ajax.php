<?php
session_start();

if ( ! isset($_SESSION['emp_id']) && ( ! isset($_SESSION['is_completed']) && '1' !== $_SESSION['is_completed']))
{
    echo 'logout';
}

require_once('error_log.php');
require_once('libraries/Database.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('libraries/Employee.php');
require_once('libraries/Validation.php');

$db_obj = Database::get_instance();

foreach ($_POST as $key => $value)
{
    $_POST[$key] = $db_obj->mysql_sanitize($value);
}

$signup = new Employee($db_obj);

$page = isset($_POST['page']) ? (int) ceil ($_POST['page']*2) : 0;
$name = isset($_POST['name']) ? preg_replace ( '/\s+/', '', $_POST['name']) : '';
$order = isset($_POST['order']) ? $_POST['order'] : 'DESC';

if ('DESC' !== $order && 'ASC' !== $order)
{
    $order = 'DESC';
}

if (0 > $page)
{
    $page = 0;
}

echo $signup->get_employee_json($page, $name, $order);
