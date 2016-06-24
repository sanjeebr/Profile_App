<?php
session_start();

if (isset($_COOKIE['emp_id']) && isset($_COOKIE['is_completed']))
{
    $_SESSION['emp_id'] = $_COOKIE['emp_id'];
    $_SESSION['is_completed'] = $_COOKIE['is_completed'];
}

if (isset($_SESSION['emp_id']) && isset($_SESSION['is_completed']))
{
    if ( 0 == $_SESSION['is_completed'])
    {
        header('Location: form.php');
    }
    else if ( 1 == $_SESSION['is_completed'])
    {
        header('Location: home.php');
    }
}

$err = '';
$emp_id = TRUE;
$email = '';

require_once('classlib/db_class.php');
require_once('classlib/validation.php');
require_once('classlib/Employee.php');

$db_obj = Database::get_instance();

if (isset($_POST['login']))
{
    $valid = new validation($db_obj);
    $email = isset($_POST['email']) ? $valid->sanitize_input($_POST['email']) : '';
    $password = isset($_POST['password']) ? $valid->sanitize_input($_POST['password']) : '';

    if ( ! $valid->is_empty($email))
    {
        $err = '<strong>Error!</strong> Email field cannot be left blank';
    }
    else if ( 0 === $valid->is_valid_employee($email, hash('sha256', $password)))
    {
        $err = '<strong>Error!</strong> Incorrect Email or Password';
    }
    else if ( FALSE === $valid->is_valid_employee($email, hash('sha256', $password)))
    {
        header('Location: error.php');
    }
    else
    {
        $value = $valid->is_valid_employee($email, hash('sha256', $password));
        $_SESSION['emp_id'] = $value['id'];
        $_SESSION['is_completed'] = $value['is_completed'];
        if ('checkbox' === $_POST['checkbox'])
        {
            setcookie('emp_id', $value['id'], time() + (86400 * 14), "/");
            setcookie('is_completed', $value['is_completed'], time() + (86400 * 14), "/");
        }
        if (0 == $value['is_completed']) {
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
                <h1>Employee </h1>
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
                                            <input type="email" class="form-control"
                                                id="email" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" id="sizing-addon1">
                                                <span class="glyphicon glyphicon-lock"></span>
                                            </span>
                                            <input type="password" class="form-control"
                                                id="pwd" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="checkbox"
                                            value="checkbox"> Remember me</label>
                                    </div>
                                    <div class="alert-danger">
                                         <?php echo $err;?>
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
    </body>
</html>
