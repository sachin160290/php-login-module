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
    <?php 
        require_once "config/db.php";
        require_once "src/auth.php";
        $data = array();
        if( isset( $_REQUEST['id'] ) ):
            $id = $_REQUEST['id'];
            if(!empty($id)):
                try {
                    $table = 'users';            
                    // Prepare an insert statement
                    $check = "SELECT * from $table WHERE id = ?";
                    if($checkQuery = $db->prepare($check)):
                        $checkQuery->bind_param("s", $id);
                        $checkQuery->execute();
                        $result = $checkQuery->get_result();
                        $data = $result->fetch_assoc();
                    endif;                 
                } catch(Exception $e) {            
                    $array_result = array('message' => error_message($e->getMessage()));
                    exit('Error:'. $e->getMessage());
                } 

            endif;
        endif;    


        if(!empty($data)):

            if(isset($_POST['submitBtn'])):
                $fields = [
                    'first_name'    => 'string',
                    'last_name'     => 'string',
                    'status'        => 'string',
                    'email'         => 'email',
                ];
            
                $userData = sanitize($_POST,$fields);
                
                $first_name = $userData['first_name'];
                $last_name  = $userData['last_name'];
                $email      = $userData['email'];
                $status     = $userData['status'];
                if(!empty($email) && !empty($first_name) && !empty($last_name) && !empty($status)):
                    
                    try {
                        $table = 'users';
                        $check = "SELECT email from $table WHERE email = ?";
                        if($checkQuery = $db->prepare($check)):
                            $checkQuery->bind_param("s", $email);
                            $checkQuery->execute();
                            $result = $checkQuery->get_result();
                            $user = $result->fetch_assoc();
                            if(!empty( $user )):                    
                                // Prepare an insert statement
                                $sql = "UPDATE $table SET first_name=?, last_name=?, email=?, status=? WHERE id=?";
                                if($query = $db->prepare($sql)):
                                    // Bind variables to the prepared statement as parameters
                                    $query->bind_param("sssss", $first_name, $last_name, $email, $status, $id);
                                    $query->execute();
                                    if($query->affected_rows === 1):
                                        $array_result = array('message' => success_message('User details has been updated successfully') );
                                    else:
                                        $array_result = array( 'message' => error_message('Oops! Something went wrong. Please try again after some time.') );
                                    endif;
                                    
                                    mysqli_stmt_close($query);
                                    mysqli_close($db);
                                else:
                                    $array_result = array( 'message' => error_message('Oops! Something went wrong. Please try again after some time.'));
                                endif;
                            
                            else:
                                $array_result = array( 'message' => error_message('User not found in database.'));
                            endif;
                        endif;    
                    } catch(Exception $e) {            
                        $array_result = array( 'message' => error_message($e->getMessage()));
                        exit('Error:'. $e->getMessage());
                    } 
                else:        
                    $array_result = array( 'message' => error_message('Please enter all required fields.'));
                endif;

                // $encodedData = urlencode( json_encode( $array_result));
                // header("Location: ".$redirect."?response=".$encodedData."");
                // exit;

            endif;
        ?>  

        <div  class="container">
            <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                LoginModule
            </a>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="dashboard.php" class="nav-link px-2 link-dark">Dashboard</a></li>
                <li><a href="users.php" class="nav-link px-2 active link-secondary">Users</a></li>
            </ul>

            <div class="col-md-3 text-end">
                <a href="logout.php" class="btn btn-outline-primary me-2">Logout</a>
            </div>
            </header>
        </div>

            <div class="container">
                <div class="row m-5">
                    <h1 class="d-flex justify-content-center">Edit User Page</h1>
                    <div class="col-lg-12 d-flex justify-content-center">                
                        <form class="pt-4" action="" method="post" id="registerForm">
                            <!-- First Name input -->
                            <div class="form-outline mb-2">
                                <label class="form-label" for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $data['first_name']; ?>" />
                            </div>
                            
                            <!-- Email input -->
                            <div class="form-outline mb-2">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $data['last_name']; ?>"  />
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-2">
                                <label class="form-label" for="email">Email address</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo $data['email']; ?>" />
                            </div>

                            <!-- Staus input -->
                            <?php 
                                $status = $data['status']; 
                                $active =  ($status == 'active')?  'checked' : '';
                                $inactive =  ($status == 'inactive')?  'checked' : '';
                            ?>
                            <div class="form-outline mb-2">
                                <label class="form-label" for="status">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="active" value="active" <?php echo $active; ?>>
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive" <?php echo $inactive; ?>>
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                            </div>

                        <!-- Submit button -->
                            <button type="submit" name="submitBtn" value="submitBtn" class="btn btn-primary btn-block mb-4">Update User</button>
                

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
            
        <?php

        else:
            echo '<div class="container"><div class="row"><div clas="col-lg-12"><h2 class=" d-flex justify-content-center m-5">You are not autorized to do this action<h2></div></div></div>';
        endif;
        ?>
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script src="assets/js/validator.min.js"></script>
    <script src="assets/js/login-module.js"></script>
</body> 
</html>