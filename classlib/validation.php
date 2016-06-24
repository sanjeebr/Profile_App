<?php


/**
 * Validation
 *@package Database
 *@subpackage
 *@category
 *@author Sanjeeb Rao
 */

class Validation {
    private $error = FALSE;
    private $db_obj = NULL;


    public function __construct($db_object)
    {
        $this->db_obj = $db_object;

    }

    public function is_valid_employee($email, $password = '')
    {
        $condition = "WHERE email = '$email' ";

        if ('' !== $password)
        {
            $condition .= "AND password = '$password'";
        }

        $result = $this->db_obj->select('employee', ' id,is_completed ', $condition);

        if (FALSE === $result)
        {
            $this->error = TRUE;
            return FALSE;
        }

        $num_rows = mysqli_num_rows($result);
        if (0 === $num_rows)
        {
            return 0;
        }
        $id = mysqli_fetch_assoc($result);
        $this->error = TRUE;
        return $id;
    }

    /**
     * Sanitize data
     *
     * @param  string $input
     * @return string
     */
    function sanitize_input($input) {
        return htmlspecialchars( stripslashes( trim($input)));
    }

    public function is_error() {
        return $this->error;
    }

    public function is_equal($first, $second) {
        if ($first !== $second) {
            $this->error = TRUE;
            return FALSE;
        }
        return TRUE;
    }

    public function is_valid_email($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
            $this->error = TRUE;
            return FALSE;
        }
        return TRUE;
    }

    public function is_valid_pass($password) {
        if ( strlen($password) < 8 || strlen($password) > 16) {
            $this->error = TRUE;
            return FALSE;
        }
        return TRUE;
    }

    public function is_valid_number($number, $length = 10) {
        if ( ! preg_match('/^[0-9]{' . $length . '}$/', $number)) {
            $this->error = TRUE;
            return FALSE;
        }
        return TRUE;

    }

    public function is_valid_name($name) {
        if ( ! preg_match('/^[a-zA-Z ]*$/', $name)) {
            $this->error = TRUE;
            return FALSE;
        }
        return TRUE;
    }

    public function is_valid_date($date) {
        $date_arr = explode('-', $date);

        if ( 3 !== count($date_arr) || ! checkdate($date_arr[1], $date_arr[2], $date_arr[0])) {
            $this->error = TRUE;
            return FALSE;
        }
        return TRUE;
    }

    public function is_empty($data) {
        if (empty($data)) {
            $this->error = TRUE;
            return FALSE;
        }
        return TRUE;
    }

}