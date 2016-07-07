<?php
require_once('classlib/Database.php');

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
