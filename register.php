<?php 
require_once "config/db.php";
if(is_user_logged_in() ){
    header("location: dashboard.php");
}
if(isset($_POST['submitBtn'])):
    $fields = [
        'first_name'    => 'string',
        'last_name'     => 'string',
        'password'      => 'string',
        'email'         => 'email',
    ];

    $data = sanitize($_POST,$fields);
    
    $first_name = $data['first_name'];
    $last_name  = $data['last_name'];
    $email      = $data['email'];
    $password   = $data['password'];
    $status     = 'active';
    if(!empty($email) && !empty($first_name) && !empty($last_name) && !empty($password)):
        $password_hash =  password_hash($password, PASSWORD_DEFAULT);
        try {
            $table = 'users';
            $check = "SELECT email from $table WHERE email = ?";
            if($checkQuery = $db->prepare($check)):
                $checkQuery->bind_param("s", $email);
                $checkQuery->execute();
                $result = $checkQuery->get_result();
                $user = $result->fetch_assoc();
                if(empty($user )):                    
                    // Prepare an insert statement
                    $sql = "INSERT INTO $table (first_name, last_name, email, password, status) VALUES (?, ?, ?, ?, ?)";
                    if($query = $db->prepare($sql)):
                        // Bind variables to the prepared statement as parameters
                        $query->bind_param("sssss", $first_name, $last_name, $email, $password_hash, $status);
                        $query->execute();
                        if($query->affected_rows === 1):
                            $array_result = array( 'result' => 'success', 'message' => success_message('Your account has been registered successfully') );
                        else:
                            $array_result = array( 'result' => 'fail', 'message' => error_message('Oops! Something went wrong. Your registration is not completed yet. Please try again after some time.') );
                        endif;
                        
                        mysqli_stmt_close($query);
                        mysqli_close($db);
                    else:
                        $array_result = array( 'result' => 'fail', 'message' => error_message('Oops! Something went wrong. Your registration is not completed yet. Please try again after some time.'));
                    endif;
                  
                else:
                    $array_result = array( 'result' => 'fail', 'message' => error_message('A user is already registered with this email address.'));
                endif;
            endif;    
        } catch(Exception $e) {            
            $array_result = array( 'result' => 'fail', 'message' => error_message($e->getMessage()));
            exit('Error:'. $e->getMessage());
        } 
    else:        
        $array_result = array( 'result' => 'fail', 'message' => error_message('Please enter all required fields to register your account.'));
    endif;
endif;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row m-5">
            <h1 class="d-flex justify-content-center">Register Page</h1>
            <div class="col-lg-12 d-flex justify-content-center">                
                <form class="pt-4" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="registerForm">
                    <!-- First Name input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" />
                    </div>
                    
                    <!-- Email input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" />
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="c_password">Repeat Password</label>
                        <input type="password" id="c_password" name="c_password" class="form-control" />
                    </div>

                   <!-- Submit button -->
                    <button type="submit" name="submitBtn" value="submitBtn" class="btn btn-primary btn-block mb-4">Register</button>
                    
                    <!-- Register buttons -->
                    <div class="text-center">
                        <p>Already have an account? <a href="index.php">Login Now</a></p>
                    </div>

                    <div id="ajax-message">
                        <?php 
                            if(isset( $array_result )):
                                echo $array_result['message'];
                            endif;
                        ?>
                    </div>
                </form>
    
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script src="assets/js/validator.min.js"></script>
    <script src="assets/js/login-module.js"></script>
 </body> 
</html>