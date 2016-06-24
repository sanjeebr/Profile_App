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
        'employee_id' => '',
        'street' => '',
        'city' => '',
        'state' => '',
        'pin' => '',
        'phone' => '',
        'fax' => '',
        'type' => ''
    );
    private $db_obj = NULL;
    private $table_name = 'address';

    public function __construct($db_object) {
        $this->db_obj = $db_object;

    }

    public function update_address($emp_id, $address, $type, $time = '') {
       $this->fields['type'] = $type;
       $this->fields['employee_id'] = $emp_id;
        foreach ($address as $key => $value)
        {
            if(('office' === $type && 'o' === $key[0] ) || ('residence' === $type && 'r' === $key[0]))
            {
            $key = substr($key, 2);
                if(isset($this->fields[$key]))
                {
                    $this->fields[$key] = $value;
                }
            }
        }
        if ('first' === $time) {
            return $this->db_obj->insert($this->table_name, $this->fields);
        }
        return $this->db_obj->update($this->table_name, $this->fields, "WHERE employee_id = '$emp_id' and type = '$type'");
    }
}