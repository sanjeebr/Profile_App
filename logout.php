<?php
setcookie('emp_id', '', time() - 1, '/');
setcookie('is_completed', '', time() - 1, '/');

session_unset();
session_destroy();

header('Location: index.php');?>
