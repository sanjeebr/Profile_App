<?php
require_once('session_header.php');
require_once('classlib/Database.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('classlib/Employee.php');

if ( ! isset($_POST['name'])) {
    header('Location: index.php');
}

$db_obj = Database::get_instance();
$conn = $db_obj->get_connection();
$signup = new Employee($db_obj);
$result = $signup->get_employee(0, "WHERE CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE '%{$_POST['name']}%' ORDER BY first_name");

// Serial no for employee table.
$serial_no = 0;

// To check if employee table is empty or not.
if (0 !== $result):
?>
<div  class="table-responsive">
    <h2>Employee Details</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th><h4><strong>Serial No</strong></h4></th>
                <th><h4><strong>Photo</strong></h4></th>
                <th><h4><strong>Personal Info</strong></h4></th>
                <th><h4><strong>Residence Address</strong></h4></th>
                <th><h4><strong>Office Address</strong></h4></th>
                <th><h4><strong>Other Info</strong></h4></th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = mysqli_fetch_assoc($result))
            {
        ?>
            <tr>
                <td>
                    <?php echo ++$serial_no; ?>
                </td>
                <td>
                    <img src="<?php $pic = ! empty($row['photo']) ?
                        PROFILE_PIC . $row['photo'] : DEFAULT_PROFILE_PIC . $row['gender'] . '.jpg' ;
                        echo $pic; ?>"
                        class="img-rounded" alt="profile_pic" width="160"
                        height="160">
                </td>
                <td>
                    <?php echo '<strong>Name:</strong>' . $row['prefix']
                        . ' ' . $row['first_name'] . ' ' . $row['middle_name']
                        . ' ' . $row['last_name']
                        . '<br><strong>Gender:</strong>' . $row['gender']
                        . '<br><strong>DOB:</strong>' .
                        date('d-M-Y',strtotime($row['date_of_birth'])) .
                        '<br><strong>Marital Status:</strong>'
                        . $row['marital'];
                    ?>
                </td>
                <td>
                    <?php echo '<strong>Street:</strong>'
                        . $row['r_street']
                        . '<br><strong>City:</strong>'
                        . $row['r_city']
                        . '<br><strong>State:</strong>'
                        . $row['r_state']
                        . '<br><strong>Pin no:</strong>'
                        . $row['r_pin']
                        . '<br><strong>Phone no:</strong>'
                        . $row['r_phone']
                        . '<br><strong>Fax no:</strong>'
                        . ( ! empty($row['r_fax'])
                            ? $row['r_fax'] : ' N/A')
                    ?>
                </td>
                <td>
                    <?php echo '<strong>Street:</strong>'
                        . ( ! empty($row['o_street'])
                            ? $row['o_street'] : ' N/A')
                        . '<br><strong>City:</strong>'
                        . ( ! empty($row['o_city'])
                            ? $row['o_city'] : ' N/A')
                        . '<br><strong>State:</strong>'
                        . ( ! empty($row['o_state'])
                            ? $row['o_state'] : ' N/A')
                        . '<br><strong>Pin no:</strong>'
                        . ( ! empty($row['o_pin'])
                            ? $row['o_pin'] : ' N/A')
                        . '<br><strong>Phone no:</strong>'
                        . ( ! empty($row['o_phone'])
                            ? $row['o_phone'] : ' N/A')
                        . '<br><strong>Fax no:</strong>'
                        . ( ! empty($row['o_fax'])
                            ? $row['o_fax'] : ' N/A');
                    ?>
                </td>
                <td>
                    <?php echo '<strong>Employment:</strong>'
                        . ( ! empty($row['employment'])
                            ? $row['employment'] : ' N/A')
                        . '<br><strong>Employer:</strong>'
                        . ( ! empty($row['employer'])
                            ? $row['employer'] : ' N/A')
                        . '<br><strong>Note:</strong>'
                        . ( ! empty($row['note'])
                            ? $row['note'] : ' N/A')
                        . '<br><strong>Communication:</strong>'
                        . ( ! empty($row['communication'])
                            ? $row['communication'] : ' N/A')
                    ?>
                </td>
            </tr>
            <?php   } ?>
        </tbody>
    </table>
</div>
<?php  else : ?>
    <div class="container">
        <div class="alert alert-danger">
            <h2>No employee records.</h2>
        </div>
    </div>
<?php endif; ?>