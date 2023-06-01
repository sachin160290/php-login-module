<?php
require_once "config/db.php";
if(!is_user_logged_in() ){
    header("location: index.php");
}
$user = get_logged_in_user_details();

?>