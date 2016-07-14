<?php
session_start();

if ( ! isset($_SESSION['emp_id']) || ( ! isset($_SESSION['is_completed'])
    || '1' !== $_SESSION['is_completed']))
{
    echo 'logout';
}

require_once('libraries/Database.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('libraries/Employee.php');
require_once('libraries/Validation.php');

$db_obj = Database::get_instance();
$valid = new Validation($db_obj);
foreach ($_POST as $key => $value)
{
    $_POST[$key] = $db_obj->mysql_sanitize($value);
}

$type = isset($_POST['type']) ? $_POST['type'] : '';
$name = isset($_POST['name']) ? preg_replace ( '/\s+/', '', $_POST['name']) : '';
$resource = isset($_POST['resource']) ? $_POST['resource'] : '-1';
$role = isset($_POST['role']) ? $_POST['role'] : '-1';
$privilege = isset($_POST['privilege']) ? $_POST['privilege'] : '-1';
$e_id = isset($_POST['e_id']) ? $_POST['e_id'] : '-1';


if ('add_role' === $type)
{
    $data = array('name' => $name );
    $success = $db_obj->insert('role',$data);
}

if ('resource' === $type)
{
    $json_data = array();
    $result = $db_obj->select('resources', 'id, name');

    while ($row = mysqli_fetch_assoc($result))
    {
        $json_data[] = $row;
    }

    echo json_encode($json_data);
}

if ('role' === $type)
{
    $json_data = array();
    $result = $db_obj->select('role', 'id, name');

    while ($row = mysqli_fetch_assoc($result))
    {
        if ('admin' !== $row['name'])
        {
            $json_data[] = $row;
        }
    }

    echo json_encode($json_data);
}

if ('privilege' === $type)
{
    $json_data = array();
    $result = $db_obj->select('privilege', 'privilege.id AS id, privilege.name AS name,
        role_privilege.id AS p_id', "LEFT JOIN role_privilege ON privilege.id =
        role_privilege.privilege_id  AND role_privilege.role_id = '$role'
        and role_privilege.resource_id =  '$resource'");

    while ($row = mysqli_fetch_assoc($result))
    {
        $json_data[] = $row;
    }

    echo json_encode($json_data);
}

if ('add_privilege' === $type)
{
    $data = array('role_id' => $role,
       'resource_id' => $resource,
       'privilege_id' => $privilege
       );

    $success = $db_obj->insert('role_privilege',$data);
    if (FALSE === $success)
    {
        echo 'error';
    }
}

if ('delete_privilege' === $type)
{
    $success = $db_obj->delete('role_privilege',
        "WHERE role_id = $role AND resource_id = $resource AND privilege_id = $privilege");
}

if ('email' === $type)
{
    $json_data = array();
    $result = $db_obj->select('employee', 'employee.id AS id,employee.email AS email,
        role.name AS role' ,'JOIN role on employee.role_id = role.id');

    while ($row = mysqli_fetch_assoc($result))
    {
        if('admin' !== $row['role'])
        {
        $json_data[] = $row;
        }
    }

    echo json_encode($json_data);
}

if ('role-assign' === $type)
{
    $json_data = array();
    $result = $db_obj->select('role', 'role.id AS id, role.name AS name,
        employee.id AS e_id', "LEFT JOIN employee ON role.id = employee.role_id
        AND employee.id= $e_id");

    while ($row = mysqli_fetch_assoc($result))
    {
        if ('admin' !== $row['name'])
        {
            $json_data[] = $row;
        }
    }

    echo json_encode($json_data);
}

if ('update_role' === $type)
{
    $success = $db_obj->update('employee', "role_id = $role", "WHERE id = $e_id");
}