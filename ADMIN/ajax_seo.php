<?php
require_once('../Connections/divdb.php');
session_start();

 if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date("Y-m-d");
?>

<?php
//inserting faq questions and answers
if(isset($_GET['type']) && $_GET['type']==1)
{ 
$field_name=$_POST['field'];
$upd_vals=$_POST['vals'];

	
	$seo = $conn-prepare(("update seo_settings set ".$field_name."=?");
	$seo->execute(array($upd_vals));
  
}
if(isset($_GET['type']) && $_GET['type']==2)
{ 
$field_name=$_POST['field'];
$upd_vals=$_POST['vals'];
$typee=$_POST['typ'];


$seo = $conn->prepare("SELECT * FROM seo_settings_new where type=?");
$seo->execute(array($typee));
$row_seo = $seo->fetch(PDO::FETCH_ASSOC);
$totalRows_seo = $seo->rowCount();

if($totalRows_seo>0){

  
  $seo = $conn->prepare(("update seo_settings_new set ".$field_name."=? where type=? ");
  $seo->execute(array($upd_vals,$typee));
  }else {
     

echo $seo=$conn->prepare("INSERT INTO seo_settings_new(".$field_name.",type)  VALUES(?,?)");
     $seo->execute(array($upd_vals,$typee));
  }
}
?>