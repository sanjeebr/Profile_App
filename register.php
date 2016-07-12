<?php
require_once('error_log.php');

session_start();

if (isset($_SESSION['emp_id']) && isset($_SESSION['is_completed']))
{
    switch ($_SESSION['is_completed'])
    {
        case '0':
            header('Location: form.php');
            exit;
            break;
        case '1':
            header('Location: home.php');
            exit;
            break;
        default:
            header('Location: error.php');
            exit;
    }
}

$email_err = '';
$pwd_err = '';
$cpwd_err = '';
$emp_id = TRUE;
$email = '';

require_once('libraries/Database.php');
require_once('libraries/Validation.php');
require_once('libraries/Employee.php');

$db_obj = Database::get_instance();

if (isset($_POST['signup']))
{
    $valid = new validation($db_obj);
    $email = isset($_POST['email']) ? $valid->sanitize_input($_POST['email']) : '';
    $password = isset($_POST['password']) ? $valid->sanitize_input($_POST['password']) : '';
    $cpassword = isset($_POST['cpassword']) ? $valid->sanitize_input($_POST['cpassword']) : '';

    // To check valid Email or not.
    if ( ! $valid->is_empty($email))
    {
        $email_err = 'Email field cannot be left blank';
    }
    else if ( ! $valid->is_valid_email($email))
    {
        $email_err = 'Invalid Email';
    }
    else if ( 0 !== $valid->is_valid_employee($email))
    {
        $email_err = 'Email already present';
    }

    // To check valid Password or not.
    if ( ! $valid->is_empty($password))
    {
        $pwd_err = 'Password cannot be left blank';
    }
    else if ( ! $valid->is_valid_pass($password))
    {
        $pwd_err = 'Password length must be between 8-16';
    }

    // To check valid Comfirm Password or not.
    if (! $valid->is_empty($cpassword))
    {
        $cpwd_err = 'Password cannot be left blank';
    }
    else if ( ! $valid->is_equal($password, $cpassword))
    {
        $cpwd_err = 'Password field does not match Confirm Password field';
    }

    if ( ! $valid->is_error())
    {
        $password = hash('sha256', $password);
        $signup = new Employee($db_obj);
        $emp_id = $signup->create_account($email, $password);

        if (FALSE === $emp_id)
        {
            header('Location: error.php');
            exit;
        }
        else
        {
            $_SESSION['emp_id'] = $emp_id;
            $_SESSION['is_completed'] = '0';
            $_SESSION['role_id'] = '2';
            header('Location: form.php');
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport">
        <title>Register</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/index.css"/>
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
                                <a href="index.php" class="btn btn-lg btn-primary">Login</a>
                                <a class="btn btn-lg btn-primary active">Register</a>
                            </div>
                            <div>
                                <form role="form" id="signup" method="post" action="">
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon"
                                                id="sizing-addon1">
                                                <span class="glyphicon glyphicon-user"
                                                    aria-hidden="true"></span>
                                            </span>
                                            <input type="email"
                                                class="form-control empty"
                                                id="email" name="email"
                                                placeholder="Email"
                                                value="<?php echo $email;?>">
                                        </div>
                                        <div class="alert-danger " id="email_err">
                                            <?php echo $email_err;?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon"
                                                id="sizing-addon1">
                                                <span class="glyphicon glyphicon-lock"></span>
                                            </span>
                                            <input type="password"
                                                class="form-control empty"
                                                id="pwd" name="password"
                                                placeholder="Password">
                                        </div>
                                        <div class="alert-danger pwd_err"
                                            id="pwd_err">
                                            <?php echo $pwd_err;?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon"
                                                id="sizing-addon1">
                                                <span class="glyphicon glyphicon-lock"></span>
                                            </span>
                                            <input type="password"
                                                class="form-control empty"
                                                id="cpwd" name="cpassword"
                                                placeholder="Confirm Password">
                                        </div>
                                        <div class="alert-danger cpwd_err" id="cpwd_err">
                                            <?php echo $cpwd_err;?>
                                        </div>
                                    </div>
                                    <button type="submit" name="signup"
                                        class="btn btn-lg btn-success btn-block" >
                                        Sign up</button>
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