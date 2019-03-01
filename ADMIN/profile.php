<html>
<?php
require_once('../Connections/divdb.php');
include("../COMMN/smsfunc.php");
session_start();


$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$mon=$date->format('F');
$dd=$date->format('m/d/Y');
	
	if(isset($_POST['change_passw']) && $_POST['change_passw']=="change_passw_val")
{
	
	$pass=$conn->prepare("select * from login_secure where uid=?");
	$pass->execute(array($_GET['uid']));
	$row_pass=$pass->fetch(PDO::FETCH_ASSOC);
	$tot_pass=$pass->rowCount();
	
	if($row_pass['passwd']==md5($_POST['cur_pass']))
	{
		
$update_chang=$conn->prepare("update login_secure set passwd=? where uid=?");
$update_chang->execute(array(md5($_POST['re_pass']),$_GET['uid']));


$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration status</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request is accepted</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>ADMIN</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! Your password changed, Please check and hide form others </span><br> Your Login id:".$row_pass['email_id']." <br> Your password is ".$_POST['re_pass']." <br> Please login and update your personal details.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/><img src='../images/logo2.png'/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DoView Holidays Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	$to = $row_pass['email_id'];
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);


		echo "<script>parent.location.reload();</script>";
	}else{
	echo "Mismatch Password";	
	}
}
	
	   


?>
<head>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)       height:100%;
-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
        <link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
        <link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
         <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
         <link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
         <link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
         
        
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}

td{
  padding: 6px;	
}
</style>

</head>
<body>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title">&nbsp; <i class="fa fa-user"></i>&nbsp;
                                <?php if($_GET['group']=="password"){?>ADMIN<?php }?></h3>
							  </div>
                              
							  <div class="panel-body">
								<div class="row">
								<div class="col-sm-12">
<?php  if($_GET['group']=="password"){?>
<form name="change_pass" method="post" onSubmit="return check_pass()">
							  <div class="panel-body">
								<div class="row">
                                
                    <div class="col-sm-12">
                  <table width="100%">
                  <tr><td>Enter Current Password</td><td> : </td><td><input type="password" id="cur_pass" name="cur_pass" class="form-control"><p id="cur_pass_wd" style="color:#930; font-size:12px; font-weight:600; text-align:center; display:none">Mismatch Password</p></td></tr>
                  <tr><td>Enter New Password</td><td> : </td><td><input type="password" id="new_pass" name="new_pass" class="form-control"></td></tr>
                  <tr><td>Re-Enter New Password</td><td> : </td><td><input type="password"  id="re_pass" name="re_pass" class="form-control">
                  <p id="re_pass_wd" style="color:#930; font-size:12px; font-weight:600; text-align:center; display:none">Re-enter password</p></td></tr>
                  <tr><td colspan="3" height="20px;" style=" background-color:#EAF5F3"><center><button class="btn btn-success" type="submit" value="change_passw_val" name="change_passw">Submit</button></center></td></tr>
                  </table>
                    </div>
							  </div>
							</div><!-- /.panel panel-default -->
                            </form>

<?php }?>


                  			 	</div>
							  </div>
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>
                      
                        </body>
                        
                        <script src="../core/assets/js/jquery.min.js"></script>
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        <script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
        <script src="../core/assets/plugins/icheck/icheck.min.js"></script>

        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
        <script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>
        <script src="../core/assets/plugins/toastr/toastr.js"></script>
        
        <!-- VALIDATOR EXAMPLE -->
      <!--  <script src="../core/assets/plugins/validator/example.js"></script>-->
     
     
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
                 
<script>
$('.chosen-select').chosen({
	'width': '100%',
});

function check_pass()
{
	var new_pass=$('#new_pass').val();
	var re_pass=$('#re_pass').val();
	var cur_pass=$('#cur_pass').val();
	var cpa;
	if(new_pass==re_pass)
	{
		var typ=8;
$.get('ajax_others.php',{'cpass':cur_pass,'type':typ},function(result){
	var res=$.trim(result);
	
	if(res=="yes")
	{
		cpa="true";
	}else if(res=="no")
	{
		$('#cur_pass_wd').val('').focus();
		cpa="false";
	}
	
		});
		return cpa;
	}else
	{
		$('#re_pass_wd').show();
		$('#re_pass').val('').focus();
		return false;
	}
	

}

</script>

</html>
                        