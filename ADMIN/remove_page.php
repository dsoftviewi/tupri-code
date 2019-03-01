<?php
require_once('../Connections/divdb.php');

$tab_name=$_POST['tname'];
$wfield=$_POST['field'];



$sno=$_POST['sno'];

if($tab_name == "hotspots_pro")
{
	$spotsel=$conn->prepare("select * from hotspots_pro where $wfield=?");
	$spotsel->execute(array($sno));
	$row_spot_main=$spotsel->fetchAll();
	foreach($row_spot_main as $row_spotsel)
	{
		if(trim($row_spot['spot_images']) != '')
		{
			$imgs=explode(',',$row_spot['spot_images']);
			foreach($imgs as $img)
			{
				unlink("../img_upload/uploads/files/".$img);	
    			unlink("../img_upload/uploads/files/thumbnail/".$img);	
			}
		}
	}
	
	$insertSQLupd=$conn->prepare("delete from $tab_name where $wfield=?");
	$insertSQLupd->execute(array($sno));
}else
{
	if($wfield=="datetime")
	{
	$insertSQLupd=$conn->prepare("delete from $tab_name where $wfield=?");
	$insertSQLupd->execute(array($sno));
	
	$insertSQLupd1=$conn->prepare("delete from vehicle_rent where $wfield=?");
	$insertSQLupd1->execute(array($sno));
	}else
	{
		$insertSQLupd=$conn->prepare("delete from $tab_name where $wfield=?");
		$insertSQLupd->execute(array($sno));
	
	$insertSQLupd1=$conn->prepare("delete from vehicle_rent where vehicle_id=?");
	$insertSQLupd1->execute(array($sno));
	}
	
}

if($tab_name == "hotspots_pro")
{
	$path='../uploadexcel/hotspot/';
 $file='';
	
}else{
$path='../uploadexcel/vehicle/';
 $file='';
}
 if(isset($_POST['fls']) && $_POST['fls']!='')
 {
	  $file=$path.$_POST['fls'];
	 unlink($file);
 }
?>