<?php
require_once('error_log.php');

session_start();

if (isset($_COOKIE['emp_id']) && isset($_COOKIE['is_completed']))
{
    $_SESSION['emp_id'] = $_COOKIE['emp_id'];
    $_SESSION['is_completed'] = $_COOKIE['is_completed'];
}

if (isset($_SESSION['emp_id']) && isset($_SESSION['is_completed']))
{
    switch ($_SESSION['is_completed'])
    {
        case '0':
            header('Location: form.php');
            break;
        case '1':
            header('Location: home.php');
            break;
        default :
            header('Location: error.php');
    }
}

$pwd_err = '';
$email = '';

require_once('libraries/Database.php');
require_once('libraries/Validation.php');
require_once('libraries/Employee.php');

$db_obj = Database::get_instance();

if (isset($_POST['login']))
{
    $valid = new validation($db_obj);
    $email = isset($_POST['email']) ? $valid->sanitize_input($_POST['email']) : '';
    $password = isset($_POST['password']) ? $valid->sanitize_input($_POST['password']) : '';
    $checkbox = isset($_POST['checkbox']) ? $valid->sanitize_input($_POST['checkbox']) : '';
    $password = hash('sha256', $password);

    if ( ! $valid->is_empty($email))
    {
        $email_err = '<strong>Error!</strong> Email field cannot be left blank';
    }
    else if ( 0 === $valid->is_valid_employee($email, $password))
    {
        $pwd_err = '<strong>Error!</strong> Incorrect Email or Password';
    }
    else if ( FALSE === $valid->is_valid_employee($email, $password))
    {
        header('Location: error.php');
    }
    else
    {
        $value = $valid->is_valid_employee($email, $password);
        $_SESSION['emp_id'] = $value['id'];
        $_SESSION['is_completed'] = $value['is_completed'];

        if ('checkbox' === $checkbox)
        {
            setcookie('emp_id', $value['id'], time() + (86400 * 14), '/');
            setcookie('is_completed', $value['is_completed'], time() + (86400 * 14), '/');
        }

        if ('0' === $value['is_completed'])
        {
             header('Location: form.php');
        }

        header('Location: home.php');
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport">
        <title>Login</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/index.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body class="container_body">
        <div class="container-fluid">
            <div class="jumbotron transbox">
                <h1>Employee</h1>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                        <div class="well well-lg page-header">
                            <div class="btn-group btn-group-justified page-header">
                                <a class="btn btn-lg btn-primary active">Login</a>
                                <a href="register.php" class="btn btn-lg btn-primary">Register</a>
                            </div>
                            <div>
                                <form role="form" id="login" method="post" action="">
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" id="sizing-addon1">
                                                <span class="glyphicon glyphicon-user"
                                                    aria-hidden="true"></span>
                                            </span>
                                            <input type="email" class="form-control empty"
                                                id="email" name="email" placeholder="Email">
                                        </div>
                                        <div class="alert-danger" id="email_err">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" id="sizing-addon1">
                                                <span class="glyphicon glyphicon-lock"></span>
                                            </span>
                                            <input type="password" class="form-control empty"
                                                id="pwd" name="password" placeholder="Password">
                                        </div>
                                        <div class="alert-danger" id="pwd_err">
                                        <?php echo $pwd_err;?>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="checkbox"
                                            value="checkbox"> Remember me</label>
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-success btn-block" name="login">
                                        Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <script   src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/validation.js?version=1.0"></script>
    </body>
</html>
