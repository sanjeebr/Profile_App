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
    private $fields = array(
        'prefix' => '',
        'first_name' => '',
        'middle_name' => '' ,
        'last_name' => '',
        'gender' => '',
        'date_of_birth' => '',
        'marital' => '',
        'employment' => '',
        'employer' => '',
        'note' => '',
        'communication' => '',
        'photo' => ''
    );

    private $residence_address = NULL;
    private $office_address = NULL;


    /**
     * Get an instance of the Database
     *
     *@access public
     *@param  void
     *@return Instance
     */
    public function __construct($employee_data) {
        foreach ($employee_data as $key => $value) {
            if(isset($this->fields[$key]))
            {
                $this->fields[$key] = $value;
            }

        }
        $this->residence_address = new Address('residence', $employee_data);
        $this->office_address = new Address('office', $employee_data);
    }

    /**
     * Get an instance of the Database
     *
     *@access public
     *@param  void
     *@return Instance
     */
    public function add_emp($db_obj) {
        $sql_query = "INSERT INTO employee
            (first_name, middle_name, last_name, date_of_birth, prefix,
            note, gender, marital_status, communication, employment, employer)
            VALUES ('{$this->fields['first_name']}', '{$this->fields['middle_name']}',
            '{$this->fields['last_name']}', '{$this->fields['date_of_birth']}',
            '{$this->fields['prefix']}', '{$this->fields['note']}', '{$this->fields['gender']}',
            '{$this->fields['marital']}', '{$this->fields['communication']}',
            '{$this->fields['employment']}', '{$this->fields['employer']}')";


        $result = $db_obj->execute_sql_query($sql_query);
        $employee_id = $db_obj->get_last_insert_id();

        if (FALSE === $result || FALSE === $this->residence_address->add_address($db_obj,$employee_id)
            || FALSE === $this->office_address->add_address($db_obj,$employee_id)) {
                return FALSE;
            }

        return TRUE;
    }

    /**
     * Get an instance of the Database
     *
     * @access public
     *@param  void
     *@return Instance
     */
    public function edit_emp($db_conn, $emp_id)
    {

    }

    /**
     * Get an instance of the Database
     *
     *@access public
     *@param  void
     *@return Instance
     */
    public function delete_emp($db_obj, $emp_id)
    {
        $is_address_delete = $residence_address->delete_address($db_obj, $emp_id);
        $sql = "DELETE FROM employee WHERE id = $emp_id";
        $result = $db_obj->execute_sql_query($sql_query);

        if (FALSE === $result || FALSE === $is_address_delete) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Get an instance of the Database
     *
     *@access public
     *@param  void
     *@return Instance
     */
    public function get_emp($db_conn, $emp_id)
    {
        $sql_query = "SELECT  employee.id AS emp_id,employee.first_name AS first_name,
        employee.middle_name AS middle_name, employee.last_name AS last_name,
        employee.date_of_birth AS date_of_birth, employee.prefix AS prefix,
        employee.photo AS photo, employee.note AS note,employee.gender AS gender,
        employee.marital_status AS marital,employee.communication AS communication,
        employee.employment AS employment,employee.employer AS employer,
        residence.street AS r_street,residence.city AS r_city,
        residence.state AS r_state,residence.pin_no AS r_pin,residence.phone AS r_phone,
        residence.fax AS r_fax,office.street AS o_street,office.city AS o_city,
        office.state AS o_state,office.pin_no AS o_pin,office.phone AS o_phone,
        office.fax AS o_fax
        FROM employee
        LEFT JOIN address AS residence ON employee.id = residence.employee_id AND
        residence.type = 'residence'
        LEFT JOIN address AS office ON employee.id = office.employee_id AND
        office.type = 'office'";

        if ('ALL' !== $emp_id) {
            $sql_query .= " HAVING emp_id = $emp_id ";
        }

        $result = $db_conn->execute_sql_query($sql_query);

        if (FALSE === $result) {
            return FALSE;
        }
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
}