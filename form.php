<?php
session_start();

if ( ! isset($_SESSION['emp_id']) && ! isset($_SESSION['is_completed']))
{
    header('Location: index.php');
}
require_once('classlib/Database.php');
require_once('config/initialization_config.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('classlib/Validation.php');
require_once('classlib/Employee.php');
require_once('classlib/Address.php');

$db_obj = Database::get_instance();
$conn = $db_obj->get_connection();
$valid = new validation($db_obj);
$employee = new Employee($db_obj);
$address = new Address($db_obj);

extract($employee_data, EXTR_SKIP);
extract($error_list, EXTR_SKIP);
$result = $employee->get_employee($_SESSION['emp_id']);

while ($row = mysqli_fetch_assoc($result))
{
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
}

if (isset($_POST['submit']) || isset($_POST['update']))
{
    $error = 0;

    $_POST['communication'] = (isset($_POST['communication']) && ! empty($_POST['communication']) )
        ? implode(',', $_POST['communication']) : '';

    foreach ($_POST as $value)
    {
        $value = $valid->sanitize_input($value);
    }

    $prefix = $_POST['prefix'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $marital = $_POST['marital'];
    $r_street = $_POST['r_street'];
    $r_city = $_POST['r_city'];
    $r_state = $_POST['r_state'];
    $r_pin = $_POST['r_pin'];
    $r_phone = $_POST['r_phone'];
    $r_fax = $_POST['r_fax'];
    $o_street = $_POST['o_street'];
    $o_city = $_POST['o_city'];
    $o_state = $_POST['o_state'];
    $o_pin = $_POST['o_pin'];
    $o_phone = $_POST['o_phone'];
    $o_fax = $_POST['o_fax'];
    $employment = $_POST['employment'];
    $employer = $_POST['employer'];
    $note = $_POST['note'];
    $communication = $_POST['communication'];

    // To check error in first name.
    if ( ! $valid->is_empty($_POST['first_name']))
    {
        $first_name_err = 'First Name is required.';
    }
    else
    {
        // Check if name only contains letters and whitespace
        if ( ! $valid->is_valid_name($_POST['first_name']))
        {
            $first_name_err = 'Only letters and white space allowed.';
        }
    }

    // To check error in middle name.
    if ( ! $valid->is_valid_name($_POST['middle_name']))
    {
        $middle_name_err = 'Only letters and white space allowed.';
    }

    // To check error in last name.
    if ( ! $valid->is_empty($_POST['last_name']))
    {
        $last_name_err = 'Last Name is required.';
    }
    else
    {

        // Check if name only contains letters and whitespace
        if ( ! $valid->is_valid_name($_POST['last_name']))
        {
          $last_name_err = 'Only letters and white space allowed.';
        }
    }

    // To check error in date of birth.
    if ( ! $valid->is_empty($_POST['date_of_birth']))
    {
        $dob_err = 'Date of Birth is required.';
    }
    else if (! $valid->is_valid_date($_POST['date_of_birth']) )
    {
         $dob_err = 'Date of Birth is invalid.';
    }

    // To check error in pin.
    if ( ! $valid->is_empty($_POST['r_pin']))
    {
       $r_pin_err = 'This field is required.';
    }
    else if ( ! $valid->is_valid_number($_POST['r_pin'],6))
    {
        $r_pin_err = 'Invalid Pin Code.';
    }

    if ( ! preg_match('/^[0-9]{6}$/', $_POST['o_pin']) && ! empty($_POST['o_pin']))
    {
        $o_pin_err = 'Invalid Pin Code.';
        $error++;
    }

    // To check error in mobile no.
    if (! $valid->is_empty($_POST['r_phone']))
    {
        $r_phone_err = 'This field is required.';
    }
    else if ( ! $valid->is_valid_number($_POST['r_phone'], 10))
    {
        $r_phone_err = 'Invalid Phone Number.';
    }

    if ( ! preg_match('/^[0-9]{10}$/', $_POST['o_phone']) && ! empty($_POST['o_phone']))
    {
        $o_phone_err = 'Invalid Phone Number.';
        $error++;
    }

    // To check error in fax number.
    if ( ! preg_match('/^[0-9]{11}$/', $_POST['r_fax']) && ! empty($_POST['r_fax']))
    {
        $r_fax_err = 'Invalid Fax Number.';
        $error++;
    }

    if ( ! preg_match('/^[0-9]{11}$/', $_POST['o_fax']) && ! empty($_POST['o_fax']))
    {
        $o_fax_err = 'Invalid Fax Number.';
        $error++;
    }

    // To check error in gender.
    if (! $valid->is_empty($_POST['gender']))
    {
        $gender_err = 'This field is required.';
    }

    // To check error in marital status.
    if (! $valid->is_empty($_POST['marital']))
    {
        $marital_err = 'This field is required.';
    }

    // To check residence street is empty or not.
    if (! $valid->is_empty($_POST['r_street']))
    {
        $r_street_err = 'This field is required.';
    }

    // To check residence city is empty or not.
    if (! $valid->is_empty($_POST['r_city']))
    {
        $r_city_err = 'This field is required.';
    }

    // To check residence state is empty or not.
    if (! $valid->is_empty($_POST['r_state']))
    {
        $r_state_err = 'This field is required.';
    }

    if (isset($_FILES['photo']))
    {
        $file_name = $_FILES['photo']['name'];
        $file_size = $_FILES['photo']['size'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_type = $_FILES['photo']['type'];

        // Check if image is selected or not.
        if (0 !== $file_size)
        {
            $ext = explode('.', $_FILES['photo']['name']);
            $file_ext = strtolower(end($ext));
            $extensions = array('jpeg', 'jpg', 'png');

            // Check if extension is valid or not then check the size must not greater then 2MB.
            if ( FALSE === in_array($file_ext,$extensions))
            {
                $photo_err = 'Please choose a JPEG or PNG file.';
                $error++;
            }
            else if ($file_size > 2097152)
            {
                $photo_err = 'File size must be excately 2 MB';
                $error++;
            }
            else if (0 === $error &&  (FALSE === $valid->is_error()))
            {
                unlink(PROFILE_PIC . $photo);
                $photo = 'Emp_' . $_SESSION['emp_id'] . '.' . $file_ext;
                move_uploaded_file($file_tmp, PROFILE_PIC . $photo);

            }
        }
    }

   // If there is any error or not.
   if ((0 === $error) &&  (FALSE === $valid->is_error()))
   {
        $times = '';

        if (isset($_POST['submit']))
        {
            $times = 'first';
        }

        if($employee->update_employee($_SESSION['emp_id'], $_POST,$times) &&
            $db_obj->update('employee', "photo = '$photo'", 'where id = ' . $_SESSION['emp_id']))
        {
            $_SESSION['is_completed'] = 1;
            header('Location: home.php');
        }
        else
        {
            header('Location: error.php');
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,
            user-scalable=no">
        <?php if (1 == $_SESSION['is_completed']): ?>
        <title>Update</title>
        <?php else: ?>
        <title>Registration</title>
        <?php endif ?>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/form.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid" id="container_body">
            <div class="container">
            <?php if (1 == $_SESSION['is_completed']): ?>
                <h1>Update Form</h1>
            <?php else: ?>
                <h1>Registration Form</h1>
            <?php endif ?>
            <br>
            <form role="form" id="empform" method="post" action=""
                enctype="multipart/form-data">
                <div class="well"><h3>Personal Info:</h3>
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="prefix">
                                    <span class="error">*</span>Prefix:
                                </label>
                                <select name="prefix" id="prefix" class="form-control">
                                    <option value="Mr">Mr</option>
                                    <option value="Ms" <?php if ('Ms' === $prefix)
                                        {
                                        echo "selected";
                                        } ?>>Ms</option>
                                    <option value="Mrs" <?php if ('Mrs' === $prefix)
                                        {
                                        echo "selected";
                                        } ?>>Mrs</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="fname">
                                    <span class="error">*</span>First Name:
                                </label>
                                <input type="text" class="form-control" id="fname"
                                    name="first_name" placeholder="First Name"
                                    <?php  echo "value='$first_name'"; ?>>
                                <br>
                                <span class="error"><?php echo $first_name_err; ?></span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="mname">Middle Name:</label>
                                <input type="text" class="form-control" id="mname"
                                    name="middle_name" placeholder="Middle Name"
                                    <?php  echo "value='$middle_name'"; ?>>
                                <br>
                                <span class="error"><?php echo $middle_name_err; ?></span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="lname">
                                    <span class="error">*</span>Last Name:
                                </label>
                                <input type="text" class="form-control" id="lname" name="last_name"
                                    placeholder="Last Name" <?php  echo "value='$last_name'"; ?>>
                                <br><span class="error"><?php echo $last_name_err; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                               <label for="gender"><span class="error">*</span>Gender:</label>
                               <div class="radio">
                                   <label class="radio-inline">
                                        <input type="radio" id="male" name="gender"
                                             value="Male" checked>Male
                                   </label>
                                   <label class="radio-inline">
                                        <input type="radio" id="female" name="gender"
                                            value="Female"
                                            <?php if ('Female' === $gender)
                                            {
                                                echo 'checked';
                                            } ?>>Female
                                   </label>
                               </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="date_of_birth">
                                    <span class="error">*</span>Date of Birth:
                                </label>
                                <div class="date">
                                    <input type="date" name="date_of_birth" class="form-control"
                                        id="dob" <?php  echo "value='$date_of_birth'"; ?>>
                                    <br><span class="error"><?php echo $dob_err; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="marital">
                                    <span class="error">*</span>Marital Status:
                                </label>
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input type="radio" id="single" name="marital" value="Single"
                                            checked>Single
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" id="married" name="marital"
                                            value="Married" <?php if ('Married' === $marital)
                                            {
                                                echo 'checked';
                                            } ?>>Married
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="photo">Upload Photo:
                                    <?php if (1 == $_SESSION['is_completed'])
                                    { ?>
                                    <a  data-toggle="modal" data-target="#profile_pic" >
                                    View Current Pic</a>
                                    <?php } ?></label>
                                <input type="file" class="form-control" id="photo"
                                    name="photo" >
                                <br><span class="error"><?php echo $photo_err; ?></span>

                                <!-- Modal for profile pic-->
                                <div id="profile_pic" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Profile Pic</h4>
                                            </div>
                                            <div class="modal-body">

                                            <?php if (1 == $_SESSION['is_completed']): ?>
                                                <img src="<?php echo !empty($photo)
                                                    ? PROFILE_PIC . $photo :
                                                    DEFAULT_PROFILE_PIC . $gender .'.jpg' ; ?>"
                                                    class="img-rounded" alt="profile_pic"
                                                    width="200" height="200">
                                            <?php endif ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <!-- TODO: Make address function and use it for
                            Residence Address and Office Address  -->
                            <div class="well"><h3>Residence Address:</h3>
                                <label for="r_street"><span class="error">*</span>Street Name:</label>
                                &nbsp;&nbsp;&nbsp;
                                <span class="error"><?php echo $r_street_err ?></span>
                                <input type="text" class="form-control" id="r_street"
                                    name="r_street" placeholder="Street name..."
                                    <?php echo "value='$r_street'"; ?>>
                                <label for="r_city"><span class="error">*</span>City:</label>
                                &nbsp;&nbsp;&nbsp;
                                <span class="error"><?php echo $r_city_err?></span>
                                <input type="text" class="form-control" id="r_city"
                                    name="r_city" placeholder="City..."
                                    <?php  echo "value='$r_city'"; ?>>
                                <label for="r_state"><span class="error">*</span>State:</label>
                                &nbsp;&nbsp;&nbsp;
                                <span class="error"><?php echo $r_state_err ?></span>
                                <select  id="r_state" class="form-control" name="r_state">
                                    <option value="">Select State</option>
                                    <?php
                                        // Fetch state list.
                                        echo $address->state_list($r_state);
                                    ?>
                                </select>
                                <label for="r_pin"><span class="error">*</span>Pin no:</label>
                                &nbsp;&nbsp;&nbsp;
                                <span class="error"><?php echo $r_pin_err ?></span>
                                <input type="text" class="form-control" id="r_pin"
                                    placeholder="Pin No" name="r_pin"
                                    <?php  echo "value='$r_pin'"; ?>>
                                <label for="r_phone"><span class="error">*</span>Mobile No:</label>
                                &nbsp;&nbsp;&nbsp;
                                <span class="error"><?php echo $r_phone_err ?></span>
                                <input type="text" class="form-control" id="r_phone"
                                    placeholder="eg:9990001234" name="r_phone"
                                    <?php  echo "value='$r_phone'"; ?>>
                                <label for="r_fax">Fax:</label>
                                &nbsp;&nbsp;&nbsp;
                                <span class="error"><?php echo $r_fax_err ?></span>
                                <input type="text" class="form-control" id="r_fax"
                                    placeholder="eg:00001234567" name="r_fax"
                                    <?php  echo "value='$r_fax'"; ?>>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="well"><h3>Office Address:</h3>
                                <label for="o_street">Street Name:</label>
                                <input type="text" class="form-control" id="o_street"
                                    name="o_street" placeholder="Street name..."
                                    <?php  echo "value='$o_street'"; ?>>
                                <label for="o_city">City:</label>
                                <input type="text" class="form-control" id="o_city"
                                    name="o_city" placeholder="City.."
                                    <?php  echo "value='$o_city'"; ?>>
                                <label for="o_state">State:</label>
                                <select  id="o_state" class="form-control" name="o_state">
                                    <option value="">Select State</option>
                                    <?php
                                        // Fetch state list.
                                        echo $address->state_list($o_state);
                                    ?>
                                </select>
                                <label for="o_pin">Pin no:</label>
                                &nbsp;&nbsp;&nbsp;
                                <span class="error"><?php echo $o_pin_err ?></span>
                                <input type="text" class="form-control" id="o_pin"
                                    name="o_pin" placeholder="Pin No"
                                    <?php  echo "value='$o_pin'"; ?>>
                                <label for="o_phone">Mobile No:</label>
                                &nbsp;&nbsp;&nbsp;
                                <span class="error"><?php echo $o_phone_err ?></span>
                                <input type="text" class="form-control" id="o_phone"
                                    name="o_phone" placeholder="eg:9990001234"
                                    <?php  echo "value='$o_phone'"; ?> >
                                <label for="o_fax">Fax:</label>
                                &nbsp;&nbsp;&nbsp;
                                <span class="error"><?php echo $o_fax_err ?></span>
                                <input type="text" class="form-control" id="o_fax"
                                    name="o_fax" placeholder="eg:00001234567"
                                    <?php  echo "value='$o_fax'"; ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well"><h3>Other Info:</h3>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="employment">Employment:</label>
                                <input type="text" class="form-control" id="employment"
                                    name="employment" placeholder="Employment"
                                    <?php echo "value='$employment'"; ?>>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="employer">Employer:</label>
                                <input type="text" class="form-control" id="employer"
                                    name="employer" placeholder="Employer"
                                    <?php  echo "value='$employer'"; ?>>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="extra">Extra Note:</label>
                                <textarea class="form-control" id="extra" name="note"
                                    placeholder="Extra Note.."><?php  echo "$note"; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4">
                                <label>Preferred communication medium:</label>
                            </div>
                            <!-- TODO: fetch this from database -->
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <div class="checkbox-inline" id="Mail">
                                    <label>
                                        <input type="checkbox" name="communication[]"
                                            value="Mail"
                                            <?php if (strpos($communication, 'Mail') !== FALSE)
                                            {
                                                echo 'checked';
                                            } ?>>Mail
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <div class="checkbox-inline" id="Message">
                                    <label>
                                        <input type="checkbox" name="communication[]"
                                            value="Message"
                                            <?php if (strpos($communication, 'Message') !== FALSE)
                                            {
                                                echo 'checked';
                                            } ?>>Message
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <div class="checkbox-inline" id="phone">
                                    <label>
                                        <input type="checkbox" name="communication[]"
                                            value="Phone Call"
                                            <?php if (strpos($communication, 'Phone Call') !== FALSE)
                                            {
                                                echo 'checked';
                                            } ?>>Phone Call
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <div class="checkbox-inline" id="any">
                                    <label>
                                        <input type="checkbox" name="communication[]"
                                            value="Any"
                                            <?php if (strpos($communication, 'Any') !== FALSE)
                                            {
                                                echo "checked";
                                            } ?>>Any
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group text-center">
                    <?php if(1 == $_SESSION['is_completed']): ?>
                    <a class="btn btn-danger btn-lg" href="home.php" >Cancel</a>
                    &nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-warning btn-lg" name="update">Update</button>
                    <?php else: ?>
                    <a class="btn btn-info btn-lg" href="logout.php" >Cancel</a>
                    &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-danger btn-lg" type="reset" >Reset</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-warning btn-lg" name="submit">Submit</button>
                    <?php endif ?>
                </div>
            </form>
            </div>
        </div>
    </body>
</html>
