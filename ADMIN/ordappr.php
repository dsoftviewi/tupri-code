<?php
require_once('../Connections/divdb.php');
if ($_GET['typ'] == 1)
{
	$tplid=$_GET['tpid'];
	
	
	$appr_ord=$conn->prepare("update travel_master set status = 0 where plan_id =?");
	$appr_ord->execute(array($tplid));
}

if ($_GET['typ'] == 2)
{
	$tplid=$_GET['tpid'];
	
	
	$rej_ord=$conn->prepare("update travel_master set status = 1 where plan_id =?");
	$rej_ord->execute(array($tplid));
}

?>
