<?php
/**
 * Database class - create single instance
 *@package Database
 *@subpackage
 *@category
 *@author Sanjeeb Rao
 */
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'mindfire';
    private $database = 'registration';
    private $connection = NULL;

    // The single instance
    private static $instance = NULL;

    /**
     * Create connection
     *
     *@access private
     *@param  void
     *@return void
     */
    private function __construct() {
        $this->connection = new mysqli($this->host, $this->username,
            $this->password, $this->database);

        // Error handling
        if(mysqli_connect_error()) {

        }
    }

    /**
     * Get an instance of the Database
     *
     *@access public
     *@param  void
     *@return Instance
     */
    public static function get_instance() {
        if(self::$instance === NULL) {

            // If no instance then make one
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retrun connection
     *
     *@access public
     *@param  void
     *@return Instance
     */
    public function get_connection() {
        return $this->connection;
    }


    /**
     * Retrun connection
     *
     *@access public
     *@param  string
     *@return mix
     */
    public function execute_sql_query($sql_query) {
        return mysqli_query($this->connection, $sql_query);
    }

    /**
     * Retrun last id
     *
     *@access public
     *@param  void
     *@return mix
     */
    public function get_last_insert_id() {
        return mysqli_insert_id($this->connection);
    }

    /**
     * Insert
     *
     *@access public
     *@param  void
     *@return mix
     */
    public function insert($table_name, $data) {
        $sql_query = "INSERT INTO $table_name ";
        $col_name = ' ( ';
        $col_value = ' VALUES ( ';
        foreach ($data as $key => $value) {
            $col_name .= "$key, ";
            $col_value .= "'$value', ";
        }
        $col_name = trim($col_name, ", ") . ' )';
        $col_value = ' '.trim($col_value, ", ") .' )';
        $sql_query .= $col_name . $col_value;

        if(FALSE === $this->execute_sql_query($sql_query)) {
            return FALSE;
        }

        return TRUE;

    }


    public function update($table_name, $data, $condition = '') {
        $sql_query = "UPDATE $table_name ";
        $set = ' SET ';
        if (is_array ($data)) {
            foreach ($data as $key => $value) {
                $set .= "$key = '$value', ";
            }
            $set = trim($set, ", ");
        } else {
            $set .= " $data ";
        }
        $sql_query .= $set . ' ' . $condition;
        if(FALSE === $this->execute_sql_query($sql_query)) {
            return FALSE;
        }

        return TRUE;
    }

    public function select($table_name, $data, $condition = '') {
        $sql_query = "SELECT ";
        if (is_array ($data)) {
            foreach ($data as $value) {
                $sql_query .= " $value, ";
            }
        } else {
            $sql_query .= " $data";
        }

        $sql_query .= ' FROM ' . $table_name . ' ' . $condition;
        echo $sql_query;
        $result = $this->execute_sql_query($sql_query);
        if(FALSE === $result) {
            return FALSE;
        }

        return mysqli_fetch_assoc($result);
    }

    public function delete($table_name, $condition = '') {
        $sql_query = "DELETE FROM $table_name $condition";
        echo $sql_query;
        $result = $this->execute_sql_query($sql_query);
        if(FALSE === $result) {
            return FALSE;
        }

        return TRUE;
    }
}
?>
