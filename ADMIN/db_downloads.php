<?php 

function backup_db(){
include('Connections/divdb.php');
date_default_timezone_set("Asia/Kolkata");
$date = date('d-M-Y-H-i-s', time()); 
/* Store All Table name in an Array */
$return='';
$allTables = array();

$result = $conn->prepare('SHOW TABLES');
$row_result_main=$result->fetchAll();

foreach($row_result_main as $row_result)
{
     $allTables[] = $row_result[0];
}
//print_r($allTables);

for($bd=0;$bd<count($allTables);$bd++)//taking whole table from database
{
	$table_nm=$allTables[$bd];
/*Used For Get Product Sale Details*/
$column_value='';

$row1=$conn->prepare("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='dvidb' and `TABLE_NAME`=?");
$row1->execute(array($table_nm));
$row_row1_main=$row1->fetchAll();
foreach($row_row1_main as $row_row1)
{
$column_value.="`".$row_row1['COLUMN_NAME']."`,";
}
$final_clum_val=substr($column_value,0,-1);


//$resquery=;
$result =$conn->prepare('SELECT * from '.$table_nm);
$result->execute();
$num_fields = $result->columnCount();
$total_row = $result->rowCount();

for ($i = 0; $i < $num_fields; $i++) {
foreach($row_result_main as $row_result)
{
   $return.= 'INSERT INTO '.$table_nm.' ('.$final_clum_val.'
  ) VALUES(';
     for($j=0; $j<$num_fields; $j++){
       $row[$j] = addslashes($row[$j]);
       $row[$j] = str_replace("\n","\\n",$row[$j]);
       if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } 
       else { $return.= '""'; }
       if ($j<($num_fields-1)) { $return.= ','; }
     }
   $return.= ");\n";
}
$return.="\n\n";
}
/*End Of  Ger Product Sale Details*/




// Create Backup Folder
$folder = 'DB_Backup/DB_Backup_'.$date.'/';
if (!is_dir($folder))
mkdir($folder, 0777, true);
chmod($folder, 0777);


$filename = $folder."db_".$table_nm."-".$date; 
$extfilename = "db-backdwn";
$handle = fopen($filename.'.sql','w+');
fwrite($handle,$return);
//echo "Generating table backup to ".$table_nm." - Done<br>";
$return='';
}//table main for end
}
backup_db();
?>