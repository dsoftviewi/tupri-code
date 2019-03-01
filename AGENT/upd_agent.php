<?php
session_start();
require_once('../Connections/divdb.php');
if ($_GET['typ'] == 1)
{
	$agentid=$_SESSION['uid'];
	$prof_per=$_GET['perc'];
	
	
	$update_perc=$conn->prepare("update agent_pro set my_percentage =? where agent_id =?");
	$update_perc->execute(array($prof_per,$agentid));
}


?>
