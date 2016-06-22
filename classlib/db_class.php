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
     * Retrun connection
     *
     *@access public
     *@param  void
     *@return mix
     */
    public function get_last_insert_id() {
        return mysqli_insert_id($this->connection);
    }



}
?>
