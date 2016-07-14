<?php
session_start();

if ( ! isset($_SESSION['emp_id']) || ( ! isset($_SESSION['is_completed'])) || '1' !== $_SESSION['is_completed'])
{
    header('Location: index.php');
    exit;
}