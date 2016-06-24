<?php
/**
 * Employee Class
 *.
 *@package Database
 *@subpackage
 *@category
 *@author Sanjeeb Rao
 */
class Employee {

    private $signup_fields = array(
        'email' => '',
        'password' => '',
        'flag' => 'signup',
    );
    private $table_name = 'employee';
    private $db_obj = NULL;

    public function __construct($db_object) {
        $this->db_obj = $db_object;

    }


    public function create_account($email,$password) {
        $this->fields['email'] = $email;
        $this->fields['password'] = $password;
        if ($this->db_obj->insert($this->table_name, $this->signup_fields) === TRUE) {
            return $this->db_obj->get_last_insert_id();
        }
        return FALSE;
    }
}