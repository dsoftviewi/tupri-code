<?php
require_once('../Connections/divdb.php');
if(isset($_GET['type']) && $_GET['type']==1)
{
	echo $_POST['dates'];
}

?>