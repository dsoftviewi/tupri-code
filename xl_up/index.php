<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Demo - Import Excel file data in mysql database using PHP, Upload Excel file data in database</title>
<meta name="description" content="This tutorial will learn how to import excel sheet data in mysql database using php. Here, first upload an excel sheet into your server and then click to import it into database. All column of excel sheet will store into your corrosponding database table."/>
<meta name="keywords" content="import excel file data in mysql, upload ecxel file in mysql, upload data, code to import excel data in mysql database, php, Mysql, Ajax, Jquery, Javascript, download, upload, upload excel file,mysql"/>
</head>
<body>

<?php
/************************ YOUR DATABASE CONNECTION START HERE   ****************************/

define ("DB_HOST", "Localhost"); // set database host
define ("DB_USER", "root"); // set database user
define ("DB_PASS",""); // set database password
define ("DB_NAME","excel_up"); // set database name

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysqli_select_db($link,DB_NAME ) or die("Couldn't select database");

$databasetable = "excel_table";

/************************ YOUR DATABASE CONNECTION END HERE  ****************************/


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'IOFactory.php';

// This is the file path to be uploaded.
$inputFileName = 'new.xlsx'; 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
$race=array();
$race_nme=array();
$race1='';
$col_arry=array('G','H','I','J','K','L','M','N');


echo trim($allDataInSheet[5]["G"]).'1';
echo trim($allDataInSheet[4]["C"]).'2';

for($i=7;$i<=$arrayCount;$i++){
if(trim($allDataInSheet[$i]["A"])!='')
{	
$skateName = trim($allDataInSheet[$i]["B"]);
$dist = trim($allDataInSheet[$i]["C"]);
$DOB = trim($allDataInSheet[$i]["D"]);
$age_grp = trim($allDataInSheet[$i]["E"]);
$gen = trim($allDataInSheet[$i]["F"]);
foreach($col_arry as $col_arry1)
{
	if(trim($allDataInSheet[$i][$col_arry1])!='-')
	{
		array_push($race,trim($allDataInSheet[$i][$col_arry1]));
		array_push($race_nme,trim($allDataInSheet[6][$col_arry1]));
	}
	
}

//$race = trim($allDataInSheet[$i]["H"]);	
$race1=implode(',',$race);
$race2=implode('~',$race_nme);

//mysqli_select_db($skaters,$database_skaters);
/*$query = "SELECT name FROM $databasetable WHERE name = '".$userName."' and email = '".$userMobile."'";
$sql = mysqli_query($link,$query);
$recResult = mysqli_fetch_array($sql);
$existName = $recResult["name"];*/
/*if($existName=="") {*/
$insertTable= mysqli_query($link,"insert into $databasetable(Skater_name,Dist,dob,age_grp,gender,race_eve) values('".$skateName."', '".$dist."','".$DOB."','".$age_grp."','".$gen."','".$race2."');");

$race = array();
$race_nme = array();
//$race = array();
$race1='';
$race2='';
$msg = 'Record has been added. <div style="Padding:20px 0 0 0;"><a href="">Go Back to tutorial</a></div>';
/*} else {
$msg = 'Record already exist. <div style="Padding:20px 0 0 0;"><a href="">Go Back to tutorial</a></div>';
}*/
}
}
echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";
 

?>
<body>
</html>