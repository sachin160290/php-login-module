<?php 
/** Define Debug Function to Do Die */
function debug($arg){
    echo '<pre>';
    print_r($arg);
    echo '</pre>';
    die();
}

/** Debug log on  to print error */
function show_error(){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/** Success Message HTML */
function success_message($message){
    $html = '';
    $html .= '<div class="btn btn-success btn-icon-split">
                    <span class="text">'.$message.'</span>
                </div>';
    return $html;
}

/** Error Message HTML */
function error_message($message){
    $html = '';
    $html .= '<div class="btn btn-danger btn-icon-split">
                    <span class="text">'.$message.'</span>
                </div>';
    return $html;
}

/** Warning Message HTML */
function warning_message($message){
    $html = '';
    $html .= '<div class="btn btn-warning btn-icon-split">
                    <span class="text">'.$message.'</span>
                </div>';
    return $html;
}


/** Validation for is user login */
function is_user_logged_in(){
    if (isset($_SESSION['user_login']) && isset($_SESSION['user_id']) && $_SESSION['user_login'] == 'yes'):
        return true;
    else:
        return false;
    endif;
}


/** Return User Name */
function get_logged_in_user_details(){
    global $db;
    if( is_user_logged_in() ):
        $table = 'users';
        $check = "SELECT id, first_name, last_name, email from $table WHERE id = ?";
        
        if($checkQuery = $db->prepare($check)):
            $user_id = $_SESSION['user_id']; 
            $checkQuery->bind_param("s", $user_id);
            $checkQuery->execute();
            $result = $checkQuery->get_result();
            $user = $result->fetch_assoc();
            if(!empty($user )):
                return $user;
            endif;
        endif;
    endif;
}

/** Return Site URL */
function site_url(){
    return 'http://local.php.com/php-login-module';
}
?>