<?php
require_once('db_class.php');
require_once('employee_class.php');
require_once('address_class.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$db_obj = Database::get_instance();
$conn = $db_obj->get_connection();
$arry = array('o_state' =>  'odissa','r_state' =>  'delhi');
$emp = new Address('office',$arry);
$emp1 = new Address('residence',$arry);

var_dump($conn);
echo '<br>';
echo $emp->add_address($db_obj,1);
echo '<br>';
echo $emp1->delete_address($db_obj,1);
echo '<br>hello';