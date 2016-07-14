<?php
/**
* Page Header
*
* @param  string
* @return void
*/
function page_header($page)
{
    $db_obj = Database::get_instance();
    $acl = new ACL($db_obj);
?>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">Employee.com</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <?php if($acl->is_allowed('admin', 'view')):?>
                <li <?php if ('admin_home' === $page):?> class="active" <?php endif ?>>
                    <a href="admin_home.php">Admin</a>
                </li>
                <?php endif ?>
                <?php if($acl->is_allowed('home', 'view')):?>
                <li <?php if ('home' === $page):?> class="active" <?php endif ?>>
                    <a href="home.php">Home</a>
                </li>
                <?php endif ?>
                <?php if($acl->is_allowed('employee_details', 'view')):?>
                <li <?php if ('details' === $page):?> class="active" <?php endif ?>>
                    <a href="employee.php" class="active">
                    Employee Details</a>
                </li>
                <?php endif ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if($acl->is_allowed('employee_details', 'edit') ||
                    $acl->is_allowed('employee_details', 'delete')):?>
                <li class="dropdown"><a class="dropdown-toggle"
                    data-toggle="dropdown" href="#">Account Settings
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if($acl->is_allowed('employee_details', 'edit')):?>
                        <li><a href="form.php">Edit Account</a></li>
                        <?php endif ?>
                        <?php if($acl->is_allowed('employee_details', 'delete')):?>
                        <li><a onclick="return
                            confirm('Are you sure you want to delete your Account?')"
                            href="delete.php">Delete Account</a></li>
                        <?php endif ?>
                    </ul>
                </li>
                <?php endif ?>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out">
                    </span> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php
}
?>