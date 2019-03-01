<?php
require_once('../Connections/divdb.php');
if ($_GET['typ'] == 1)
{
	$did=$_GET['did'];
	$sup_val=$_GET['sup_val'];
	
	
	$update_disid=$conn->prepare("update distributor_pro SET is_super =? where distr_id=?");
	$update_disid->execute(array($sup_val,$did));
}

?>
