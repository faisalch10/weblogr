<?php include_once("./includes/connection.php"); ?>
<?php include_once("./includes/session.php"); ?>
<?php include_once("./includes/helpers.php"); ?>


<?php
$_SESSION['user_type'] = null;
$_SESSION['name'] = null;
session_destroy();
redirect_to(0, 'login.php');

?>