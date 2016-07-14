<?php
require_once('error_log.php');

session_start();
setcookie('emp_id', '', time() - 1, '/');
setcookie('is_completed', '', time() - 1, '/');
session_unset();

header('Location: index.php');?>
