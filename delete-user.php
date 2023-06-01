<?php
// Include config file
require_once "config/db.php";
require_once "src/auth.php";
/** Delete Action */
if( isset( $_REQUEST['id'] ) ):
    $id = $_REQUEST['id'];
    $redirect = site_url().'/users.php';
    $array_result   = [];
    if(!empty($id)):
        try {
            $table = 'users';            
            // Prepare an insert statement
            $check = "SELECT id from $table WHERE id = ?";
            if($checkQuery = $db->prepare($check)):
                $checkQuery->bind_param("s", $id);
                $checkQuery->execute();
                $result = $checkQuery->get_result();
                $data = $result->fetch_assoc();
                
                if(!empty($data )):
                    // Prepare an insert statement
                    $sql = "DELETE FROM $table WHERE id = ?";
                    if($query = $db->prepare($sql)):
                        // Bind variables to the prepared statement as parameters
                        $query->bind_param("s", $id);
                        $query->execute();
                        if($query->affected_rows === 1):                            
                            $array_result = array('message' => success_message('User record has been deleted successfully'), 'redirect' => $redirect  );
                        else:
                            $array_result = array('message' => error_message('Oops! Something went wrong. Please try again after some time.') );
                        endif;
                        
                        mysqli_stmt_close($query);
                        mysqli_close($db);
                    else:
                        $array_result = array('message' => error_message('Oops! Something went wrong. Please try again after some time.'));
                    endif;
                  
                else:
                    $array_result = array('message' => error_message('User ID not found in database.'));
                endif;
            endif;   
                  
                
        } catch(Exception $e) {            
            $array_result = array('message' => error_message($e->getMessage()));
            exit('Error:'. $e->getMessage());
        } 
    else:
        $array_result = array('message' => error_message('All fields are required.'));
    endif;
    $encodedData = urlencode( json_encode( $array_result));
    header("Location: ".$redirect."?response=".$encodedData."");
    exit;
endif;
?>