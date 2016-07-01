<?php
require_once('session_header.php');
require_once('classlib/Database.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('classlib/Employee.php');

$db_obj = Database::get_instance();
$employee = new Employee($db_obj);
$result = $employee->get_employee($_SESSION['emp_id']);

$row = mysqli_fetch_assoc($result);

$prefix = $row['prefix'];
$first_name = $row['first_name'];
$middle_name = $row['middle_name'];
$last_name = $row['last_name'];
$gender = $row['gender'];
$date_of_birth = $row['date_of_birth'];
$marital = $row['marital'];
$r_street = $row['r_street'];
$r_city = $row['r_city'];
$r_state = $row['r_state'];
$r_pin = $row['r_pin'];
$r_phone = $row['r_phone'];
$r_fax = $row['r_fax'];
$o_street = $row['o_street'];
$o_city = $row['o_city'];
$o_state = $row['o_state'];
$o_pin = $row['o_pin'];
$o_phone = $row['o_phone'];
$o_fax = $row['o_fax'];
$employment = $row['employment'];
$employer = $row['employer'];
$note = $row['note'];
$communication = $row['communication'];
$photo = $row['photo'];

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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid" id="container_body">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Sanjeeb</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="home.php">Home</a></li>
                            <li ><a href="employee.php">Employee Details</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown"><a class="dropdown-toggle"
                                data-toggle="dropdown" href="#">Account Settings
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="form.php">Edit Account</a></li>
                                    <li><a href="delete.php"
                                        onclick="return confirm('Are you sure you want to delete your Account?')">
                                        Delete Account</a></li>
                                </ul>
                            </li>
                            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container-fluid bg-1 bg text-center">
                <img alt="PHOTO" class="img-circle" src="<?php $pic = ! empty($photo) ?
                    PROFILE_PIC . $photo : DEFAULT_PROFILE_PIC . $gender . '.jpg' ;
                    echo $pic; ?>" width="400" height="400">
                <h3><?php echo  $prefix
                            . ' ' . $first_name . ' ' . $middle_name
                            . ' ' . $last_name?></h3>
            </div>
            <div class="container-fluid bg-2 bg">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <h3>Personal Info</h3>
                        <ul >
                            <li class="right_char"><?php echo '<strong>Gender:</strong>'
                                . ( ! empty($gender) ? $gender : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>DOB:</strong>'
                                . ( ! empty($date_of_birth) ? $date_of_birth : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>Marital Status:</strong>'
                                . ( ! empty($marital) ? $marital : ' N/A');?></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <h3>Residence Address</h3>
                        <ul>
                            <li class="right_char"><?php echo '<strong>Street:</strong>'
                                . ( ! empty($r_street) ? $r_street : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>City:</strong>'
                                . ( ! empty($r_city) ? $r_city : ' N/A');?> </li>
                            <li class="right_char"><?php echo '<strong>State:</strong>'
                                . ( ! empty($r_state) ? $r_state : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>Pin no:</strong>'
                                . ( ! empty($r_pin) ? $r_pin : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>Phone no:</strong>'
                                . ( ! empty($r_phone) ? $r_phone : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>Fax no:</strong>'
                                . ( ! empty($r_fax) ? $r_fax : ' N/A');?></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <h3>Office Address</h3>
                        <ul>
                            <li class="right_char"><?php echo '<strong>Street:</strong>'
                                . ( ! empty($o_street) ? $o_street : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>City:</strong>'
                                . ( ! empty($o_city) ? $o_city : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>State:</strong>'
                                . ( ! empty($o_state) ? $o_state : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>Pin no:</strong>'
                                . ( ! empty($o_pin) ? $o_pin : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>Phone no:</strong>'
                                . ( ! empty($o_phone) ? $o_phone : ' N/A');?></li>
                            <li class="right_char"><?php echo '<strong>Fax no:</strong>'
                                . ( ! empty($o_fax) ? $o_fax : ' N/A');?></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <h3>Other Info</h3>
                        <ul>
                            <li class="left_char"><?php echo '<strong>Employment:</strong>'
                                . ( ! empty($employment) ? $employment : ' N/A');?></li>
                            <li class="left_char"><?php echo '<strong>Employer:</strong>'
                                . ( ! empty($employer) ? $employer : ' N/A');?></li>
                            <li class="left_char"><?php echo '<strong>Note:</strong>'
                                . ( ! empty($note) ? $note : ' N/A');?></li>
                            <li class="left_char"><?php echo '<strong>Communication:</strong>'
                                . ( ! empty($communication) ? $communication : ' N/A');?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.0.0.min.js"
            integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/home.js?version=1.0"></script>
    </body>
</html>
