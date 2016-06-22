<?php

/**
 * Address class
 *.
 *@package Database
 *@subpackage
 *@category
 *@author Sanjeeb Rao
 */
class Address {
    private $fields = array(
        'street' => '',
        'city' => '',
        'state' => '',
        'pin' => '',
        'phone' => '',
        'fax' => '',
    );
    private $type = '';

    public function __construct($type, $address) {
        $this->type = $type;
        foreach ($address as $key => $value) {
            if(('office' === $type && 'o' === $key[0] ) || ('residence' === $type && 'r' === $key[0]))
            $key = substr($key, 2);
            if(isset($this->fields[$key]))
            {
                $this->fields[$key] = $value;
                echo $value.'<br>';
            }
        }
    }

    public function add_address($db_obj,$emp_id) {
        $sql_query = "INSERT INTO `address`
                (`employee_id`, `type`, `phone`, `fax`, `street`, `pin_no`, `city`, `state`)
                VALUES ($emp_id, '$this->type', '{$this->fields['phone']}', '{$this->fields['fax']}',
                '{$this->fields['street']}', '{$this->fields['pin']}',
                '{$this->fields['city']}', '{$this->fields['state']}')";


        $result = $db_obj->execute_sql_query($sql_query);

        if (FALSE === $result) {
                return FALSE;
            }

        return $sql_query;
    }

    public function delete_address($db_obj,$emp_id) {
        $sql_query = "DELETE FROM address WHERE employee_id = $emp_id";


        $result = $db_obj->execute_sql_query($sql_query);

        if (FALSE === $result) {
                return FALSE;
            }

        return $sql_query;
    }
}