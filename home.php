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
if( ! $acl->is_allowed('home', 'view'))
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
        <div class="container-fluid" id="container_body">
            <?php page_header('home'); ?>
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
        <script   src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/home.js?version=1.0"></script>
    </body>
</html>
