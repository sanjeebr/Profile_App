<?php
require_once('db_class.php');
require_once('employee_class.php');
require_once('validation.php');

$db_obj = Database::get_instance();
$conn = $db_obj->get_connection();
$array = array('employee_id'=>'21' , 'state' =>'3');
print_r($array);
$db_obj->delete_table('address','WHERE employee_id = 21');
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>hello';