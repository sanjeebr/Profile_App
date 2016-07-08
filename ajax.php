<?php
require_once('error_log.php');
require_once('session_header.php');
require_once('libraries/Database.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('libraries/Employee.php');

$db_obj = Database::get_instance();

foreach ($_POST as $key => $value)
{
    $_POST[$key] = $db_obj->mysql_sanitize($value);
}

$signup = new Employee($db_obj);

$page = isset($_POST['page']) ? ceil ($_POST['page']*2) : 0;
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

$condition = "WHERE CONCAT(employee.first_name, employee.middle_name, employee.last_name) LIKE '%$name%'
    ORDER BY employee.first_name " . "$order" . " LIMIT 2 OFFSET " . "$page";
$result = $signup->get_employee(0, $condition);

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
else if (0 === $result && 0 === $page )
{
    echo 'no data';
}
else
{
    $condition = "WHERE CONCAT(employee.first_name, ' ', employee.middle_name, ' ', employee.last_name) LIKE '%{$_POST['name']}%'";
    $last_page = ceil (($signup->total_employee($condition) / 2) - 1);
    echo 'total' . $last_page;
}

