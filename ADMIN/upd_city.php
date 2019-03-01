<?php
require_once('../Connections/divdb.php');
if ($_POST['typ'] == 1)
{
	$sno=$_POST['id'];
	$hist=$_POST['hist'];
	$citnam1 = $_POST['citnam1'];
	$getss = $_POST['ssdis'];
	$getad = $_POST['ad'];
	
	
	$cityhis = $conn->prepare("SELECT * FROM dvi_cities_history where cid=?");
	$cityhis->execute(array($sno));
	$row_cityhis = $cityhis->fetch(PDO::FETCH_ASSOC);	
	$totalRows_cityhis = $cityhis->rowCount();

	if($totalRows_cityhis > 0)
	{
		
		$update_city=$conn->prepare("UPDATE dvi_cities_history SET `cdesc`  =? WHERE cid =?"); 
		$update_city->execute(array($hist,$sno));
	}
	elseif($totalRows_cityhis == 0)
	{
		$insertSQL1=$conn->prepare("INSERT INTO dvi_cities_history (cid, `cdesc`) VALUES (?, ?)");
		$insertSQL1->execute(array($sno,$hist));
	}
	
	
	$update_city1=$conn->prepare("UPDATE dvi_cities SET name = ?, ss_dist = ?, type = ? WHERE id =?");
	$update_city1->execute(array($citnam1,$getss,$getad,$sno));
	
	
}

if ($_POST['typ'] == 2)
{
	$sno=$_POST['id'];

	
	$update_city=$conn->prepare("UPDATE dvi_cities SET status  = 1 WHERE id =?");
	$update_city->execute(array($sno));
}

if ($_POST['typ'] == 3)
{
	$sno=$_POST['id'];
$sid=$_POST['sid'];
	
	$update_city=$conn->prepare("UPDATE dvi_cities SET status  = 0 WHERE id =?");
	$update_city->execute(array($sno));
	
	
	$update_stat=$conn->prepare("update dvi_states set status = '0' where code=?");
	$update_stat->execute(array($sid));
}

?>