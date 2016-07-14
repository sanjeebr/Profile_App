<?php

/**
 * Database class - create single instance
 *
 * @package Database
 * @subpackage
 * @category
 * @author Sanjeeb Rao
 */

class Database {
    private $db = array(
        'master' => array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'mindfire',
            'db_name' => 'registration'
        ),
        'slave' => array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'mindfire',
            'db_name' => 'registration'
        )
    );

    private $connection = NULL;

    // The single instance
    private static $instance = NULL;

    /**
     * Creating connection.
     *
     * @access private constructor of Database
     * @param  void
     */
    private function __construct()
    {
        $this->connection = new mysqli(
            $this->db['master']['host'],
            $this->db['master']['username'],
            $this->db['master']['password'],
            $this->db['master']['db_name']);

        // Error handling
        if (mysqli_connect_error())
        {
            header('Location: error.php');
        }
    }

    /**
     * Creating connection.
     *
     * @access private
     * @param  void
     */
    private function __clone()
    {
    }

    /**
     * Get an instance of the Database.
     *
     * @access public get_instance
     * @param  void
     * @return Instance
     */
    public static function get_instance()
    {
        if (self::$instance === NULL)
        {

            // If no instance then make one
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Retrun connection.
     *
     * @access public  get_connection
     * @param  void
     * @return Instance
     */
    public function get_connection()
    {
        return $this->connection;
    }


    /**
     * Execute Sql Query.
     *
     * @access public execute_sql_query
     * @param  string
     * @return mixed
     */
    public function execute_sql_query($sql_query)
    {
        return mysqli_query($this->connection, $sql_query);
    }

    /**
     * Retrun last id.
     *
     * @access public get_last_insert_id
     * @param  void
     * @return mixed
     */
    public function get_last_insert_id()
    {
        return mysqli_insert_id($this->connection);
    }

    /**
     * Insert data into database.
     *
     * @access public insert
     * @param  string table_name
     * @param  array  data
     * @return bollean
     */
    public function insert($table_name, $data)
    {
        $sql_query = "INSERT INTO $table_name ";
        $col_name = ' ( ';
        $col_value = ' VALUES ( ';

        foreach ($data as $key => $value)
        {
            $col_name .= "$key, ";
            $col_value .= "'$value', ";
        }

        $col_name = trim($col_name, ", ") . ' )';
        $col_value = ' ' . trim($col_value, ", ") . ' )';
        $sql_query .= $col_name . $col_value;

        if (FALSE === $this->execute_sql_query($sql_query))
        {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Update data into database
     *
     * @access public update
     * @param  string table_name
     * @param  mix    data
     * @param  string condition
     * @return mixed
     */
    public function update($table_name, $data, $condition = '')
    {
        $sql_query = "UPDATE $table_name ";
        $set = ' SET ';

        if (is_array ($data))
        {
            foreach ($data as $key => $value)
            {
                $set .= "$key = '$value', ";
            }

            $set = trim($set, ", ");
        }
        else
        {
            $set .= " $data ";
        }

        $sql_query .= $set . ' ' . $condition;

        if (FALSE === $this->execute_sql_query($sql_query))
        {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Get Data from database.
     *
     * @access public select
     * @param  string table_name
     * @param  mix    data
     * @param  string condition
     * @return mixed
     */
    public function select($table_name, $data, $condition = '')
    {
        $sql_query = "SELECT ";

        if (is_array ($data))
        {
            foreach ($data as $value)
            {
                $sql_query .= " $value, ";
            }
        }
        else
        {
            $sql_query .= " $data";
        }

        $sql_query .= ' FROM ' . $table_name . ' ' . $condition;
        $result = $this->execute_sql_query($sql_query);

        if (FALSE === $result)
        {
            return FALSE;
        }

        return $result;
    }

    /**
     * Delete data from database.
     *
     * @access public delete
     * @param  string $table_name
     * @param  string $condition
     * @return boolean
     */
    public function delete($table_name, $condition = '')
    {
        $sql_query = "DELETE FROM $table_name $condition";
        $result = $this->execute_sql_query($sql_query);

        if(FALSE === $result)
        {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Begin Transaction
     *
     * @access public transaction
     * @param  void
     * @return void
     */
    public function transaction()
    {
        mysqli_begin_transaction($this->connection, MYSQLI_TRANS_START_READ_WRITE);
    }

    /**
     * Commit sql query
     *
     * @access public commit
     * @param  void
     * @return void
     */
    public function commit()
    {
        $this->connection->commit();
    }

    /**
     * Close the connection
     *
     * @access public close
     * @param  void
     * @return void
     */
    public function close()
    {
        mysql_close($this->connection);
        self::$instance = NULL;
    }

    /**
     * Close the connection
     *
     * @access public close
     * @param  void
     * @return void
     */
    public function mysql_sanitize($data)
    {
        return $this->connection->real_escape_string($data);
    }
}
