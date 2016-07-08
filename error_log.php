<?php


function on_error($errno, $errstr)
{
    date_default_timezone_set('UTC');
    $time = date("H:i:s");
    $error_msg = "[Time: $time] | [Error: $errno] | [Error Message: $errstr] [Filename: {$_SERVER['PHP_SELF']}]\n";
    $filename = 'error_helper/' . date("m.d.y") . '.txt';

    if ( ! file_exists($filename))
    {
        $myfile = fopen($filename, "w");
        fclose($myfile);
    }

    error_log($error_msg, 3, $filename);
    header('Location: error.php');
}

//set error handler
set_error_handler('on_error');