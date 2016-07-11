<?php
/**
 * Employee Class
 *.
 * @package
 * @subpackage
 * @category
 * @author Sanjeeb Rao
 */
class Employee {

    private $signup_fields = array(
        'email' => '',
        'password' => '',
        'is_completed' => '',
    );

    private $form_fields = array(
        'is_completed' => '1',
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

    private $table_name = 'employee';
    private $db_obj = NULL;

    /**
     * Initialization of Database object.
     *
     * @access public constructor of Employee
     * @param  object db_object
     */
    public function __construct($db_object)
    {
        $this->db_obj = $db_object;
    }

    /**
     * Create account of user.
     *
     * @access public create_account
     * @param  string email
     * @param  string password
     * @return mixed
     */
    public function create_account($email, $password)
    {
        $this->signup_fields['email'] = $email;
        $this->signup_fields['password'] = $password;
        $this->signup_fields['is_completed'] = '0';

        if ($this->db_obj->insert($this->table_name, $this->signup_fields) === TRUE)
        {
            return $this->db_obj->get_last_insert_id();
        }

        return FALSE;
    }

    /**
     * Get employee data from database.
     *
     * @access public  get_employee
     * @param  integer employee_id
     * @return mixed
     */
    public function get_employee($employee_id = 0, $input_condition = '')
    {
        $value = 'SQL_CALC_FOUND_ROWS employee.is_completed AS is_completed, employee.id AS emp_id,
            employee.first_name AS first_name, employee.middle_name AS middle_name,
            employee.last_name AS last_name, employee.date_of_birth AS date_of_birth,
            employee.prefix AS prefix, employee.photo AS photo, employee.note AS note,
            employee.gender AS gender, employee.marital AS marital,employee.communication AS communication,
            employee.employment AS employment,employee.employer AS employer,
            residence.street AS r_street,residence.city AS r_city,
            residence.state AS r_state,residence.pin AS r_pin,residence.phone AS r_phone,
            residence.fax AS r_fax,office.street AS o_street,office.city AS o_city,
            office.state AS o_state,office.pin AS o_pin,office.phone AS o_phone,
            office.fax AS o_fax , FOUND_ROWS() AS ROWS';
        $condition = "LEFT JOIN address AS residence ON employee.id = residence.employee_id AND
            residence.type = 'residence'
            LEFT JOIN address AS office ON employee.id = office.employee_id AND
            office.type = 'office'";

        if ( 0 !== $employee_id)
        {
            $condition .= " HAVING emp_id = '$employee_id'";
        }
        else if ( '' !== $input_condition)
        {
            $condition .= $input_condition;
        }
        else
        {
            $condition .= " HAVING is_completed = '1'";
        }

        $result = $this->db_obj->select($this->table_name, $value, $condition);

        if (FALSE === $result)
        {
            return FALSE;
        }

        $num_rows = mysqli_num_rows($result);

        if (0 === $num_rows)
        {
            return 0;
        }

        return $result;
    }

    /**
     * Get total number of employee.
     *
     * @access public  total_employee
     * @param  string condition
     * @return mixed
     */
    public function total_employee($condition = '')
    {
        $value = 'COUNT(id) AS total';

        $result = $this->db_obj->select($this->table_name, $value, $condition);

        if (FALSE === $result)
        {
            return FALSE;
        }

        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    /**
     * Update employee data.
     *
     * @access public  update_employee
     * @param  integer emp_id
     * @param  array   employee_data
     * @param  string  time
     * @return mixed
     */
    public function update_employee($emp_id, $employee_data, $time='')
    {
        $address = new Address($this->db_obj);

        foreach ($employee_data as $key => $value)
        {
            if(isset($this->form_fields[$key]))
            {
                $this->form_fields[$key] = $value;
            }
        }

        $this->db_obj->transaction();

        if($this->db_obj->update($this->table_name, $this->form_fields, "WHERE id = $emp_id")
            && $address->update_address($emp_id, $employee_data, 'residence', $time)
            && $address->update_address($emp_id, $employee_data, 'office', $time))
        {
            $this->db_obj->commit();
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Get JSON data of employee if the input is valid.
     *
     * @access public  total_employee
     * @param  string page
     * @param  string search_name
     * @param  string order
     * @return string
     */
    public function get_employee_json($page, $search_name = '', $order = 'DESC')
    {
        $condition = "WHERE CONCAT(employee.first_name, employee.middle_name, employee.last_name)
            LIKE '%$search_name%'
            ORDER BY employee.first_name " . "$order" . " LIMIT 2 OFFSET " . "$page";

        $result = $this->get_employee(0, $condition);

        // To check if employee table is empty or not.
        if (0 !== $result)
        {
            $json_data = array();

            while ($row = mysqli_fetch_assoc($result))
            {
                $row['photo'] = ! empty($row['photo']) ?
                    PROFILE_PIC . $row['photo'] : DEFAULT_PROFILE_PIC . $row['gender'] . '.jpg';

                foreach ($row as $key => $value)
                {
                    if ('middle_name' !== $key)
                    {
                        $row[$key] = ! empty($row[$key]) ? $row[$key] : ' N/A';
                    }
                }

                $json_data[] = $row;
            }
            return json_encode($json_data);
        }
        else if (0 === $result && 0 === $page )
        {
            return 'no data';
        }
        else
        {
            $condition = "WHERE CONCAT(employee.first_name, ' ', employee.middle_name,
                ' ', employee.last_name) LIKE '%{$_POST['name']}%'";
            $last_page = ceil (($this->total_employee($condition) / 2) - 1);
            if(0 > $last_page)
            {
               return 'no data';
            }
            return 'total' . $last_page;
        }
    }

}
