<?php
require_once('../Connections/divdb.php');
if ($_GET['typ'] == 1)
{
	$sno=$_GET['sno'];
	$state_nm=$_GET['stname'];
	
	
	$update_stat=$conn->prepare("update dvi_states set name =? where code=?");
	$update_stat->execute(array($state_nm,$sno));
}

if ($_GET['typ'] == 2)
{
	$sno=$_GET['sno'];
	$status=$_GET['sts'];
	
	$update_stat=$conn->prepare("update dvi_states set status =? where code=?");
	$update_stat->execute(array($status,$sno));
	
	
	$update_stat=$conn->prepare("update dvi_cities set status =? where region=?");
	$update_stat->execute(array($status,$sno));
}

if ($_GET['typ'] == 3)
{
	$sno=$_GET['sno'];
	$perm_val=$_GET['perm_val'];
	
	
	$update_stat=$conn->prepare("update dvi_states set permit_amt =? where code=?");
	$update_stat->execute(array($perm_val,$sno));
}

?>
