<?php
ob_start();
session_start();


session_unset();
session_destroy();
//setcookie ("grp", '',time()-3600);
unset($_SESSION['uid']);
unset($_SESSION['grp']);
unset($_SESSION['name']);
unset($_SESSION['uname']);

header("location: login.php");
exit();
?>