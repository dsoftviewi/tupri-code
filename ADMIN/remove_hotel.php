<?php
require_once('../Connections/divdb.php');

$tab_name=$_POST['tname'];
$wfield=$_POST['field'];
$sno=$_POST['sno'];

	$insertSQLupd=$conn->prepare("delete from $tab_name where $wfield=?");
	$insertSQLupd->execute(array($sno));

    $insertSQLsea=$conn->prepare("delete from hotel_season where $wfield=?");
	$insertSQLsea->execute(array($sno));
	
	$insertSQLfood=$conn->prepare("delete from hotel_food where $wfield=?");
	$insertSQLfood->execute(array($sno)));
$path='../uploadexcel/hotel/';
 $file='';
 
 if(isset($_POST['fls']) && $_POST['fls']!='')
 {
	 $file=$path.$_POST['fls'];
	 unlink($file);
 }
?>