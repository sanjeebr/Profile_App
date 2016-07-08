<?php
require_once('libraries/Database.php');
require_once('error_log.php');
/**
 * Close the connection when the page is shutdown
 *
 * @param  void
 * @return void
 */
function shutdown()
{
    $db_obj = Database::get_instance();
    $db_obj->close();
}

register_shutdown_function('shutdown');
