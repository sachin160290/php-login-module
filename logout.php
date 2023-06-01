<?php
require_once "config/db.php";

ob_start();
session_start();
if (isset($_SESSION['user_login']) && isset($_SESSION['user_id'])) {
    unset($_SESSION['user_login']);
    unset($_SESSION['user_id']);
    session_destroy();
    header("Location: index.php");
}
else {
	header("location: index.php");
}

?>