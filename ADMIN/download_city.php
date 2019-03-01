<?php
require_once('../Connections/divdb.php');

//Enter the headings of the excel columns
$contents="";

//Mysql query to get records from datanbase

$stat =$conn->prepare("SELECT * FROM dvi_states where status = 0 ORDER BY name ASC");
$stat->execute();
$row_stat_main = $stat->fetchAll();					
//While loop to fetch the records
foreach($row_stat_main as $row_stat)
{
	//$contents.="--------------------"."\n";
	$contents.="--".trim($row_stat['name'])." - ".$row_stat['code']."--"."\n";
	//$contents.=trim($row_stat['code'])."\n";
	//$contents.="--------------------"."\n";
	
	
	$city =$conn->prepare("SELECT * FROM dvi_cities where region =?");
	$city->execute(array($row_stat['code']));
	$row_city_main = $city->fetchAll();
	$totalRows_city = $city->rowCount();
	
	$i=1;
	if($totalRows_city > 0)
	{
	foreach($row_city_main as $row_city)
	{
		$contents.=trim($row_city['name']).",";
		$contents.=trim($row_city['id'])."\n";
		if($totalRows_city == $i)
		{
			$contents.="\n";
		}
		$i++;
	}
	
	}
	else
	{
		$contents.="NO CITIES"."\n\n";
	}
	
	
}


// remove html and php tags etc.
$contents = strip_tags($contents); 
//header to make force download the file
header("Content-Disposition: attachment; filename=city_states.csv");
print $contents;

?>