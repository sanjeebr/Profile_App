<?php
function on_error($error_no, $error_msg, $error_file, $error_line)
{
    date_default_timezone_set('UTC');
    $time = date("H:i:s");
    $error_msg = "[Time: $time] | [Error: $error_no] | [Error Message: $error_msg] [Filename: $error_file on Line no: $error_line]\n";
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