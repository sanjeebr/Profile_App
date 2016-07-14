<?php
require_once('session_header.php');
require_once('libraries/ACL.php');
require_once('error_log.php');
require_once('libraries/Database.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('page_header.php');

$db_obj = Database::get_instance();
$acl = new ACL($db_obj);

if( ! $acl->is_allowed('admin', 'view'))
{
    header('Location: home.php');
    exit;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport">
        <title>Admin Page</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/output.css"/>
        <link rel="stylesheet" href="css/home.css"/>
    </head>
    <body>
        <div class="container-fluid" id="container_body">
            <?php page_header('admin_home'); ?>
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                    <ul class="nav nav-pills nav-stacked well">
                        <li class="active" id="link-dashboard"><a   class="side-menu"
                            id="dashboard">Dashboard</a></li>
                        <li id="link-privilege"><a class="side-menu"
                            id="privilege">Add/Delete Privilege</a></li>
                        <li id="link-role"><a class="side-menu" id="role">
                            Create New Role</a></li>
                        <li id="link-assign-role"><a class="side-menu"
                            id="assign-role">Assign Role</a></li>
                    </ul>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                    <div class="container">
                        <div class="row display">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script   src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/admin_home.js?version=1.0"></script>
    </body>
</html>
