<?php
require_once('session_header.php');
require_once('display_error.php');
require_once('config/constants.php');
require_once('page_header.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport">
        <title>Employee Details</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/output.css"  />
    </head>
    <body>
        <div class="container-fluid" id="container_1">
            <?php page_header('details'); ?>
            <form role="form" class="form-inline text-center" method="post">
                <div class="form-group well well-lg">
                    <div class="input-group">
                        <input type="text" class="form-control" id="name" placeholder="NAME">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            Search</button>
                        </span>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default sorting" id="sorting" name="DESC">
                                <span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
            <div  class="display">
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-2">
                    <input type="hidden" name="field_name" value="0" id="page-no">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <button type="button" class="btn btn-primary btn-block pagination disabled" id="previous">« Previous</button>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <button type="button" class="btn btn-primary btn-block pagination" id="next">Next »</button>
                </div>
            </div>
        <script   src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/employee.js?version=1.0"></script>
    </body>
</html>
