<?php
session_start();

unset($_SESSION['emp_id']);
unset($_SESSION['is_completed']);

if (session_destroy())
{
    header('Location: index.php');
}