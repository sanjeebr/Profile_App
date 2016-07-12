<?php
require_once('session_header.php');
require_once('libraries/ACL.php');
require_once('error_log.php');
require_once('libraries/Database.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('libraries/Employee.php');
require_once('page_header.php');


$db_obj = Database::get_instance();
$acl = new ACL($db_obj);
if( ! $acl->is_allowed('acl', 'view'))
{
    header('Location: logout.php');
    exit;
}

$employee = new Employee($db_obj);
$result = $employee->get_employee($_SESSION['emp_id']);

$row = mysqli_fetch_assoc($result);
extract($row, EXTR_SKIP);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,
            user-scalable=no">
        <title>HOME</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/output.css"/>
        <link rel="stylesheet" href="css/home.css"/>
    </head>
    <body>
        <div class="container-fluid text-center" id="container_body">
            <?php page_header('home');
            echo $acl->is_allowed('acl', 'delete') ? '<div class="well">Delete</div>' : '';
            echo $acl->is_allowed('acl', 'edit') ? '<div class="well">Edit</div>' : '';
            echo $acl->is_allowed('acl', 'view') ? '<div class="well">View</div>' : '';
            ?>
        </div>
        <script   src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/home.js?version=1.0"></script>
    </body>
</html>
