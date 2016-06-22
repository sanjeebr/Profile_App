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
        if ( empty($data)) {
            $this->error = TRUE;
            return FALSE;
        }
        return TRUE;
    }

}