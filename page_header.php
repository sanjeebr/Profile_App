<?php
/**
* Page Header
*
* @param  string
* @return void
*/
function page_header($page)
{
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
            <a class="navbar-brand">Sanjeeb</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li <?php if ('home' === $page):?> class="active" <?php endif ?>>
                    <a href="home.php">Home</a>
                </li>
                <li <?php if ('details' === $page):?> class="active" <?php endif ?>>
                    <a href="employee.php" class="active">
                    Employee Details</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a class="dropdown-toggle"
                    data-toggle="dropdown" href="#">Account Settings
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="form.php">Edit Account</a></li>
                        <li><a onclick="return
                            confirm('Are you sure you want to delete your Account?')"
                            href="delete.php">Delete Account</a></li>
                    </ul>
                </li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out">
                    </span> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php
}
?>