<?php
session_start();
setcookie('emp_id', '', time() - 1, "/");
setcookie('is_completed', '', time() - 1, "/");
// unset($_SESSION['emp_id']);
// unset($_SESSION['is_completed']);
    session_unset();
    session_destroy();


 header('Location: index.php');?>