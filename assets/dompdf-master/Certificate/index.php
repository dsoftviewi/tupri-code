      <?php 
	require_once("../Connections/exam.php");
		mysql_select_db($database_exam, $exam);
			$query_student= "SELECT * FROM exam_result where payid='".$_GET['id']."' ";
			$student = mysql_query($query_student, $exam) or die(mysql_error());
			$row_student = mysql_fetch_assoc($student);
			$totalRows_student= mysql_num_rows($student);
			
			$std_name='';
			$std_perc='';
			$std_emid='';
			
			if($totalRows_student==0)
			{
			
			mysql_select_db($database_exam, $exam);
			$query_inst_student= "SELECT * FROM exam_insti_result where payid='".$_GET['id']."' ";
			$inst_student = mysql_query($query_inst_student, $exam) or die(mysql_error());
			$row_inst_student = mysql_fetch_assoc($inst_student);
			$totalRows_inst_student= mysql_num_rows($inst_student);
			
			$std_name=$row_inst_student['stuname'];
			$std_perc=$row_inst_student['percent'];
			$std_emid=$row_inst_student['examid'];
			
			}
			else{
			
			
			$std_perc=$row_student['percent'];
			$std_emid=$row_student['examid'];
			
			mysql_select_db($database_exam, $exam);
			$query_stuinfo= "SELECT * FROM user_student where uid='".$row_student['stuid']."'  ";
			$stuinfo = mysql_query($query_stuinfo, $exam) or die(mysql_error());
			$row_stuinfo = mysql_fetch_assoc($stuinfo);
			$totalRows_stuinfo= mysql_num_rows($stuinfo);
			
			$std_name=$row_stuinfo['name'];
			}
			
			
			mysql_select_db($database_exam, $exam);
			$query_examinfo= "SELECT * FROM author_exam where examid='$std_emid' ";
			$examinfo = mysql_query($query_examinfo, $exam) or die(mysql_error());
			$row_examinfo = mysql_fetch_assoc($examinfo);
			$totalRows_examinfo= mysql_num_rows($examinfo);
			
			mysql_select_db($database_exam, $exam);
			$query_certifyinfo= "SELECT * FROM setting_certificate where status!='1' ";
			$certifyinfo = mysql_query($query_certifyinfo, $exam) or die(mysql_error());
			$row_certifyinfo = mysql_fetch_assoc($certifyinfo);
			$totalRows_certifyinfo= mysql_num_rows($certifyinfo);
			
			mysql_select_db($database_exam, $exam);
			$query_gradeinfo= "SELECT * FROM setting_grade where  '$std_perc'<=end_percent AND '$std_perc'>=start_percent ";
			$gradeinfo = mysql_query($query_gradeinfo, $exam) or die(mysql_error());
			$row_gradeinfo = mysql_fetch_assoc($gradeinfo);
			$totalRows_gradeinfo= mysql_num_rows($gradeinfo);	
	        
		
        ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Certificate</title>
</head>
<style>


@font-face {
    font-family: 'sonoma_scriptregular';
 src: url('font/sonomascript-webfont.eot');
    src: url('font/sonomascript-webfont.eot?#iefix') format('embedded-opentype'),
         url('font/sonomascript-webfont.woff2') format('woff2'),
         url('font/sonomascript-webfont.woff') format('woff'),
         url('font/sonomascript-webfont.ttf') format('truetype'),
         url('font/sonomascript-webfont.svg#sonoma_scriptregular') format('svg');
    font-weight: normal;
    font-style: normal;

}


@font-face {
    font-family: 'robotoregular';
    src: url('font/roboto-regular-webfont.eot');
    src: url('font/roboto-regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('font/roboto-regular-webfont.woff2') format('woff2'),
         url('font/roboto-regular-webfont.woff') format('woff'),
         url('font/roboto-regular-webfont.ttf') format('truetype'),
         url('font/roboto-regular-webfont.svg#robotoregular') format('svg');
    font-weight: normal;
    font-style: normal;

}



@font-face {
    font-family: 'ScriptMTBoldRegular';
    src: url('font/scriptbl.eot');
    src: url('font/scriptbl.eot') format('embedded-opentype'),
         url('font/scriptbl.woff2') format('woff2'),
         url('font/scriptbl.woff') format('woff'),
         url('font/scriptbl.ttf') format('truetype'),
         url('font/scriptbl.svg#ScriptMTBoldRegular') format('svg');
}


</style>

<body>


<div style="width:950px; height:550px; background-image:url(images/bg.png); margin:auto; 
 border-style:inset; border-width:20px; border-bottom-color:#000; border-left-color:#000;">

<div style="border-style:solid; margin:10px 10px 10px 10px;height:520px;">

<div style="font-family:'robotoregular';
 font-size:24px; text-align:center; padding-top:5px;">
<?php echo $row_certifyinfo['title'];?>
</div>

<div style="background-image:url(images/STAR.png); background-position:center; background-repeat:no-repeat; height:25px;">

</div>

<div style="font-family:'Lucida Console', Monaco, monospace; font-size:48px; text-align:center;">
CERTIFICATE

</div>

<div style="background-image:url(images/of.png); background-position:center; background-repeat:no-repeat; height:25px; padding-bottom:15px;" >

</div>

<div style="background-image:url(images/red.png); background-position:center; background-repeat:no-repeat; height:50px;
font-family:Arial, Helvetica, sans-serif; font-size:44px; color:#FFF; text-align:center; padding-top:5px;"> 

<?php echo $row_certifyinfo['sub_title'];?>

</div>

<!--/* <div style="font-family:'sonoma_scriptregular'; font-size:22px; text-align:center; padding-top:5px;">
Present to
</div>*/-->

<div style="font-family:'ScriptMTBoldRegular'; font-size:24px; width:550px; text-align:center; margin-right:200px;
 margin-left:185px; padding-top:5px;">

This is to certify that
</div>

<div style="font-family:'robotoregular'; font-size:55px; text-align:center; padding-top:-5px; padding-bottom:5px;" >
<?php echo $std_name;?>
</div>





<div style="font-family:'ScriptMTBoldRegular'; font-size:22px; width:550px; text-align:center; margin-right:200px;
padding-bottom:5px; margin-left:200px;">
has Successfully Completed Online Certification Course on


<div style="font-family:Segoe UI Symbol; font-size:24px; text-align:center;">  
<?php echo $row_examinfo['examname']?> - GRADE '<?php echo $row_gradeinfo['grade_name']; ?>'
</div> 

Conducted by Elysium Technologies Oct 2014.
</div>


<div style="font-family:'robotoregular'; font-size:18px; text-align:left; margin-left:20px; margin-top:30px; float:left;">
Exam Code&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $row_examinfo['examcode'];?><br />
Certificate ID : 654321
</div>


<div style="float:left; margin-left:150px; padding-top:20px;">
<img src="<?php echo $row_certifyinfo['certify_logo'];?>" />

</div>



<div style="font-family:'robotoregular'; font-size:18px; text-align:right; margin-right:20px; margin-top:10px;">

<div  style="margin-right:50px;">

<img src="<?php echo $row_certifyinfo['signature'];?>" width="134" height="38" / >
</div>
<div style="margin-right:25px; font-size:14px;">
<div ><!--style="padding-right:15px;"-->
<?php echo $row_certifyinfo['auth_desg'];?> 

</div>

<?php echo $row_certifyinfo['title'];?>
</div>
</div>






</div>



</div>


</body>
</html>
