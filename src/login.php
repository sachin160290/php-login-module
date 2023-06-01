<?php
// Include config file
require_once "../config/db.php";
//show_error();
// Processing form data when form is submitted
if(isset($_POST['submitBtn'])):
    
    $fields = [
        'password'      => 'string',
        'email'         => 'email',
    ];

    $data = sanitize($_POST, $fields);
    $email      = $data['email'];
    $password   = $data['password'];

    if(!empty($email) && !empty($password)):
        try {
            $table = 'users';
            $check = "SELECT id, email, password, status from $table WHERE email = ?";
            if($checkQuery = $db->prepare($check)):
                $checkQuery->bind_param("s", $email);
                $checkQuery->execute();
                $result = $checkQuery->get_result();
                $user = $result->fetch_assoc();
             
                if(!empty( $user )): 
                    if($user['status'] == 'active'){                  
                        if (password_verify($password, $user['password'])) {
                            $redirect = site_url().'/dashboard.php';
                            $_SESSION['user_login'] = 'yes';
                            $_SESSION['user_id']    = $user['id'];
                            $array_result = array( 'result' => 'success', 'message' => success_message('You are logged in successfully. Redirecting to Dashboard.'), 'redirect' => $redirect );
                        } else {
                            $array_result = array( 'result' => 'fail', 'message' => error_message('Invalid username or password entered.'));
                        }
                    } else {
                        $array_result = array( 'result' => 'fail', 'message' => error_message('Your account is inactive, due to that you can not login.'));
                    }
                else:
                    $array_result = array( 'result' => 'fail', 'message' => error_message('Invalid username or password entered.'));
                endif;
            endif;    
        } catch(Exception $e) {            
            $array_result = array( 'result' => 'fail', 'message' => error_message($e->getMessage()));
            exit('Error:'. $e->getMessage());
        } 
    else:        
        $array_result = array( 'result' => 'fail', 'message' => error_message('Please enter all required fields to register your account.'));
    endif;
    
    echo json_encode( $array_result );
    die();
endif;
?>