<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport">
        <title>Employee Details</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/form.css"  />
        <link rel="stylesheet" href="css/output.css"  />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid" id="container_1">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Sanjeeb</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li><a href="form.php">Registration</a></li>
                            <li><a href="employee.php">Employee Details</a></li>
                            <li class="active"><a href="#">Error</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="alert alert-danger">
                    <h2>Internal Error! Please try again after sometime.</h2>
                </div>
            </div>
        </div>
    </body>
</html>
