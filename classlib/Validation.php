<?php

/**
 * Validation Class
 *
 * @package
 * @subpackage
 * @category
 * @author Sanjeeb Rao
 */

class Validation {
    private $error = FALSE;
    private $db_obj = NULL;

    /**
     * Initialization of Database object.
     *
     * @access public Constructor of Validation
     * @param  object db_object
     */
    public function __construct($db_object)
    {
        $this->db_obj = $db_object;
    }


    /**
     * To check user is valid or not.
     *
     * @access public  is_valid_employee
     * @param  string email
     * @param  string password
     * @return mixed
     */
    public function is_valid_employee($email, $password = '')
    {
        $condition = "WHERE email = '$email' ";

        if ('' !== $password)
        {
            $condition .= "AND password = '$password'";
        }

        $result = $this->db_obj->select('employee', ' id, is_completed ', $condition);

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
     * To sanitize value.
     *
     * @access public  sanitize_input
     * @param  string input
     * @return string
     */
    function sanitize_input($input)
    {
        return htmlspecialchars(stripslashes(trim($input)));
    }


    /**
     * To check is present or not.
     *
     * @access public  is_error
     * @param  void
     * @return bollean
     */
    public function is_error()
    {
        return $this->error;
    }


    /**
     * To check first string is equal to second.
     *
     * @access public  is_equal
     * @param  string  first
     * @param  string  second
     * @return bollean
     */
    public function is_equal($first, $second)
    {
        if ($first !== $second)
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }


    /**
     * To check valid email.
     *
     * @access public  is_valid_email
     * @param  string  email
     * @return bollean
     */
    public function is_valid_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }


    /**
     * To check valid password.
     *
     * @access public  is_valid_pass
     * @param  string  password
     * @return bollean
     */
    public function is_valid_pass($password)
    {
        if (8 > strlen($password) || 16 < strlen($password))
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }


    /**
     * To check valid number or not.
     *
     * @access public  is_valid_number
     * @param  string  number
     * @param  integer lenght
     * @return bollean
     */
    public function is_valid_number($number, $length = 10)
    {
        if ( ! preg_match('/^[0-9]{' . $length . '}$/', $number))
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }


    /**
     * To check valid name or not.
     *
     * @access public  is_valid_name
     * @param  string  name
     * @return bollean
     */
    public function is_valid_name($name)
    {
        if ( ! preg_match('/^[a-zA-Z ]*$/', $name))
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * To check valid Street or not.
     *
     * @access public  is_valid_street
     * @param  string  street
     * @return bollean
     */
    public function is_valid_street($street)
    {
        if ( ! preg_match('/^[a-zA-Z\s\d-,]*$/', $street))
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * To check valid length or not.
     *
     * @access public  valid_max_length
     * @param  string  data
     * @param  integer maxlength
     * @return bollean
     */
    public function valid_max_length($data, $maxlength='200')
    {
        if (strlen ($data) > $maxlength)
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * To check valid Gender or not.
     *
     * @access public  is_valid_gender
     * @param  string  gender
     * @return bollean
     */
    public function is_valid_gender($gender)
    {
        if ( 'Male' !== $gender && 'Female' !== $gender)
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * To check valid Marital Status or not.
     *
     * @access public  is_valid_marital
     * @param  string  marital
     * @return bollean
     */
    public function is_valid_marital($marital)
    {
        if ('Single' !== $marital && 'Married' !== $marital)
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * To check valid state or not.
     *
     * @access public  is_valid_state
     * @param  string  state
     * @return bollean
     */
    public function is_valid_state($state)
    {
        $result = $this->db_obj->select(' states ', ' name ');

        while ($row = mysqli_fetch_assoc($result))
        {
            if ($state === $row['name'])
            {
                return TRUE;
            }
        }

        if ( ! empty($state) )
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * To check valid prefix or not.
     *
     * @access public  is_valid_prefix
     * @param  string  perfix
     * @return bollean
     */
    public function is_valid_prefix($prefix)
    {
        if ('Mr' !== $prefix && 'Mrs' !== $prefix && 'Ms' !== $prefix)
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * To Check valid date or not.
     *
     * @access public  is_valid_date
     * @param  string  date
     * @return bollean
     */
    public function is_valid_date($date)
    {
        $date_arr = explode('-', $date);

        if ( 3 !== count($date_arr) || ! checkdate($date_arr[1], $date_arr[2], $date_arr[0]))
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }


    /**
     * To check data is empty or not.
     *
     * @access public  is_empty
     * @param  string  data
     * @return bollean
     */
    public function is_empty($data)
    {
        if (empty($data))
        {
            $this->error = TRUE;
            return FALSE;
        }

        return TRUE;
    }
}
