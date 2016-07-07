<?php
require_once('session_header.php');
require_once('classlib/Database.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('classlib/Employee.php');

if ( ! isset($_POST['name']))
{
    header('Location: index.php');
}

$db_obj = Database::get_instance();
$conn = $db_obj->get_connection();

foreach ($_POST as $key => $value)
{
    $_POST[$key] = $db_obj->mysql_sanitize($value);
}

$signup = new Employee($db_obj);

$page = $_POST['page']*2;

if(0 > $page)
{
    $page = 0;
}

$condition = "HAVING CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE '%{$_POST['name']}%'
    ORDER BY first_name " . "{$_POST['order']}" . " LIMIT 2 OFFSET " . "$page";
$result = $signup->get_employee(0,$condition);

// To check if employee table is empty or not.
if (0 !== $result)
{
    $json_data = array();

    while ($row = mysqli_fetch_assoc($result))
    {
        $row['photo'] = ! empty($row['photo']) ?
            PROFILE_PIC . $row['photo'] : DEFAULT_PROFILE_PIC . $row['gender'] . '.jpg';

        foreach ($row as $key => $value)
        {
            if ('middle_name' !== $key)
            {
                $row[$key] = ! empty($row[$key]) ? $row[$key] : ' N/A';
            }
        }

        $json_data[] = $row;
    }

    echo json_encode($json_data);
}
else
{
    echo 'no data';
}

