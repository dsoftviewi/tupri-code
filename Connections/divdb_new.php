<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_divdb = "localhost";
//$database_divdb = "dvidbtrv";
$database_divdb = "dvidb1";
$username_divdb = "dvi";
$password_divdb = "%(WDyS#*UFN7";
$conn = new PDO("mysql:host=$hostname_divdb;dbname=$database_divdb", $username_divdb, $password_divdb);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$divdb = mysql_pconnect($hostname_divdb, $username_divdb, $password_divdb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>