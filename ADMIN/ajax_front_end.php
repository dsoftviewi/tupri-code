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
echo "fdf".$_POST['quest'];
echo "fddfsf".$_POST['answ'];

	 
	echo $faq = $conn->prepare("update dvi_front_faq set faq_quest=?, faq_ans=? where sno=?");
		$faq->execute(array($_POST['quest'],$_POST['answ'],$_POST['sno']));


}?>
<?php
//inserting faq questions and answers
if(isset($_GET['type']) && $_GET['type']==2)
{ 
 $field=$_POST['str1'];
 $tarea=$_POST['tarea'];


	echo $faq = $conn->prepare("update dvi_front_settings set ".$field."=? where sno='1'");
		 $faq->execute(array($tarea));


}?>

<?php
//inserting faq questions and answers
if(isset($_GET['type']) && $_GET['type']==3)
{ 
 $field1=$_POST['field1'];
 $field2=$_POST['field2'];
 $tarea1=$_POST['tarea1'];
 $tarea2=$_POST['tarea2'];


	$contact = $conn->prepare("update dvi_front_settings set ".$field1."=?,".$field2."=? where sno='1'");
	$contact->execute(array($tarea1,$tarea2));


}?>

<?php
//inserting faq questions and answers
if(isset($_GET['type']) && $_GET['type']==4)
{ 

$fdbk_view = $conn->prepare("SELECT * FROM dvi_front_feedback where status='0' ORDER BY sno ASC");
$fdbk_view->execute();
$row_fdbk_view = $fdbk_view->fetch(PDO::FETCH_ASSOC);
$total_fdbk_view = $fdbk_view->rowCount();
	
	if($total_fdbk_view>=10)
	{
		
		$fdbk_del = $conn->prepare("DELETE FROM dvi_front_feedback where sno=?");
		$fdbk_del->execute(array($row_fdbk_view['sno']));
	}
	
	$fdbk = $conn->prepare("insert into dvi_front_feedback(cname,feedback,status) values(?,?,0)");
	$fdbk->execute(array($_POST['cname'],$_POST['cfeed']));

}?>

<?php
//inserting faq questions and answers
if(isset($_GET['type']) && $_GET['type']==5)
{ 


$fdbks = $conn->prepare("SELECT * FROM dvi_front_feedback where status='0' ORDER BY sno DESC");
$fdbks->execute();
//$row_fdbks = mysql_fetch_assoc($fdbks);
$row_fdbks_main=$fdbks->fetchAll();
$total_fdbks = $fdbks->rowCount();

$ff=1;
			foreach($row_fdbks_main as $row_fdbks)
			{
?>
<div class="col-sm-12" id="fdbk_main<?php echo $ff;?>" style="margin-top:10px; border: #999 1px solid; background-color:#FFF9EF; ">
				<div class="row show_hide_all " id="show_hide_fdbk<?php echo $ff; ?>"  style="height:auto" onclick="comm_div_fdbk(<?php echo $ff; ?>)">
                    <div class="col-sm-10">
                    
                  <p id="dis_quest_fdbk<?php echo $ff; ?>" style="height:27px;"><?php if(trim($row_fdbks['cname']) != '') { echo "Client Name : ".$row_fdbks['cname']; }else{ echo "Tourist"; }?></p>
                    <p id="edit_quest_fdbk<?php echo $ff; ?>" style="display:none;" ><label>Client Name </label><input type="text" class="form-control"  id="upd_quest_fdbk<?php echo $ff; ?>"  name="upd_quest_fdbk<?php echo $ff; ?>"  value="<?php echo $row_fdbks['cname']; ?>" /></p>
                    </div>
                    <div class="col-sm-2" id="edit_btn_fdbk<?php echo $ff; ?>">
                    <table><tr><td>&nbsp;</td><td><a class="btn btn-default" style="margin-left:" onclick="show_editable_fdbk(<?php echo $ff; ?>)"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger"  style="background-color:#E79486" onclick="delete_fdbk(<?php echo $ff; ?>,<?php echo $row_fdbks['sno']; ?>)"><i class="fa fa-times"></i></a></td></tr></table></div>
                    <div class="col-sm-2" id="update_btn_fdbk<?php echo $ff; ?>" style="display:none;">
                 <table style="margin-top:10px;"><tr><td><a class="btn btn-default" style="margin-left:" onclick="update_me_fdbk(<?php echo $ff; ?>,<?php echo $row_fdbks['sno']; ?>)"><i class="fa fa-upload"></i></a>&nbsp;</td><td>
                     <a class="btn btn-default" style="margin-left:" onclick="make_default_fdbk(<?php echo $ff; ?>)"><i class="fa fa-times"></i></a></td></tr></table></div>
                    </div>

                    <div class=" col-sm-12 row slidingDiv_all" id="slidingDiv_fdbk<?php echo $ff; ?>" style="display: none; margin-top:15px">
                  	<p id="dis_answ_fdbk<?php echo $ff; ?>" style="margin-left:50px;"><?php echo "Feedback : ".$row_fdbks['feedback']; ?></p>
                    <p id="edit_answ_fdbk<?php echo $ff; ?>" style="display:none;" ><label> Feedback </label><textarea class="form-control" rows="5" style="width:100%; resize:vertical" id="upd_answ_fdbk<?php echo $ff; ?>"  name="upd_answ_fdbk<?php echo $ff; ?>"><?php echo $row_fdbks['feedback']; ?></textarea></p>
                    </div>
                    </div>
                    <?php $ff++; } //while end?>
            
<?php
}?>

<?php
//inserting faq questions and answers
if(isset($_GET['type']) && $_GET['type']==6)
{ 
echo "fdf".$_POST['cname'];
echo "fddfsf".$_POST['cfeed'];

	 
	echo $feed = $conn->prepare("update dvi_front_feedback set cname=?, feedback=? where sno=?");
		$feed->execute(array($_POST['cname'],$_POST['cfeed'],$_POST['sno']));


}?>

<?php
//inserting faq questions and answers
if(isset($_GET['type']) && $_GET['type']==7)
{ 

	 	
		$fdbk_del = $conn->prepare("DELETE FROM dvi_front_feedback where sno=?");
		$fdbk_del->execute(array($_POST['sno']));

}?>

<?php
//inserting home welcome and features
if(isset($_GET['type']) && $_GET['type']==8)
{ 
 $field1=$_POST['field1'];
 $field2=$_POST['field2'];
 $tarea1=$_POST['tarea1'];
 $tarea2=$_POST['tarea2'];


	$home = $conn->prepare("update dvi_front_home set ".$field1."=?,".$field2."=? where sno='1'");
	$home->execute(array($tarea1,$tarea2));


}?>