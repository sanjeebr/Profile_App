<?php

/**
 * Address class
 *.
 * @package
 * @subpackage
 * @category
 * @author Sanjeeb Rao
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

    /**
     * Initialization of Database object.
     *
     * @access private constructor of Address
     * @param  object  db_object
     */
    public function __construct($db_object)
    {
        $this->db_obj = $db_object;
    }

    /**
     * Update/create address.
     *
     * @access public  update_address
     * @param  integer emp_id
     * @param  array   address
     * @param  string  type
     * @param  string  time
     * @return mixed
     */
    public function update_address($emp_id, $address, $type, $time = '')
    {
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

        if ('first' === $time)
        {
            return $this->db_obj->insert($this->table_name, $this->fields);
        }

        return $this->db_obj->update($this->table_name, $this->fields,
            "WHERE employee_id = '$emp_id' and type = '$type'");
    }

    /**
     * Creates a list states.
     *
     * @param  string state
     * @return string
     */
    public function state_list($state)
    {
        $result = $this->db_obj->select(' states ', ' name ');
        $state_list = '';

      while ($row = mysqli_fetch_assoc($result))
        {
            $is_selected = '';

            if ($row['name'] === $state)
            {
                $is_selected = 'selected';
            }

            $state_list .= "<option value='{$row['name']}' $is_selected>{$row['name']}"
                . "</option>";
        }

        return $state_list;
    }
}
