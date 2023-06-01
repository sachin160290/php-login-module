<?php
require_once "config/db.php";
if(is_user_logged_in() ){
    header("location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row m-5">
            <h1 class="d-flex justify-content-center">Login Page</h1>
            <div class="col-lg-12 d-flex justify-content-center">                
                <form class="pt-4" action="" method="post" id="loginForm">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" />
                    </div>

                   
                    <!-- Submit button -->
                    <button type="submit" name="submitBtn" value="submitBtn" class="btn btn-primary btn-block mb-4">Login</button>
                    
                    <!-- Register buttons -->
                    <div class="text-center">
                        <p>Not a member? <a href="register.php">Register</a></p>
                    </div>

                    <div id="ajax-message"></div>
                </form>
    
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script src="assets/js/validator.min.js"></script>
    <script src="assets/js/login-module.js"></script>
 </body>

</html>