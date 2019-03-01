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

	
	$agent= $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
	$agent->execute(array($_GET['uid']));
	$row_agent= $agent->fetch(PDO::FETCH_ASSOC);
	$tot_agent=$agent->rowCount();


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


$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request is accepted</span><img src='../img_upload/agent_img/".$row_agent['agent_img']."' alt='' width='240' height='64' style='float:right; margin-top:-10px;'/></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$row_agent['agent_fname'].' '.$row_agent['agent_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Greetings from DVI Holidays! Your password has been changed changed, Please check and try logging in again.. </span><br> Your Login id:".$row_agent['email_id']." <br> Your password is ".$_POST['re_pass']." <br> Please login and update your personal details.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/><img src='../images/logo2.png'/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	$to = $row_agent['email_id'];
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);


		echo "<script>parent.location.reload();parent.fancybox.close();</script>";
	}else{
	echo "Mismatch Password";	
	}
}


if(isset($_POST['update_pro']) && $_POST['update_pro']=="update_pro_val")
{
$file=$_FILES["pro_pic"]["name"];
 if(trim($_FILES["pro_pic"]["name"]) != '')
 {
	// echo "dd".$row_agent['agent_img'];
	 unlink('../ADMIN/img_upload/agent_img/'.$row_agent['agent_img']);
	 $FileType = pathinfo($file,PATHINFO_EXTENSION);
  $profile=$_GET['uid'].'.'.$FileType;
$target_file='../ADMIN/img_upload/agent_img/'.$profile;
move_uploaded_file($_FILES["pro_pic"]["tmp_name"], $target_file);
 }else
 {
	$profile=$row_agent['agent_img'];
 }
 

$update_pro=$conn->prepare("update agent_pro set agent_fname=?,agent_lname=?,agent_addr=?,comp_name=?,busi_volume=?,state=?,city=?,land_line=?,mobile_no=?,email_id=?,fax_no=?,iata_no=?,bank_addr=?,bank_acc_no=?,bank_ifsc_code=?,agent_img=?,work_state=? where agent_id=?");
$update_pro->execute(array($_POST['fname'],$_POST['lname'],$_POST['agentaddr'],$_POST['compname'],$_POST['busivolume'],$_POST['add_state'],$_POST['add_city'],$_POST['landline'],$_POST['mobile'],$_POST['email'],$_POST['faxno'],$_POST['iatano'],$_POST['bankaddr'],$_POST['bankaccnoc'],$_POST['bankifsccode'],$profile,$_POST['workstate'],$_GET['uid']));	

/*
$update_chang="update login_secure set email_id='".$_POST['email']."' where uid='".$_GET['uid']."'";
$update_cp = mysql_query($update_chang, $divdb) or die(mysql_error());*/

echo "<script>parent.location.reload();parent.fancybox.close();</script>";
}
		   


?>
<head>
<link href="../core/assets/css/bootstrap.min.css" rel="stylesheet">
		
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
                    <?php if($_GET['group']=="AGENT"){ ?>
						<div class="col-sm-12">
							<div class="panel panel-primary" >
                          
							  <div class="panel-heading ">
								<h3 class="panel-title">&nbsp; <i class="fa fa-user"></i>&nbsp;
<?php if($_GET['group']=="AGENT"){ echo $row_agent['agent_fname']." ".$row_agent['agent_lname']." Profile View"; }?>

										<span class="right-content">
										<button id="edit_btn"  type="button" class="btn btn-primary  btn-rounded-lg " onClick="edit_fun()">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        </span>
</h3>
							  </div>
                              
                                <form name="update_pro" method="post" enctype="multipart/form-data">
							  <div class="panel-body">
								<div class="row">
                                <?php  if($_GET['group']=="AGENT"){?>
                                <div class="col-sm-12" align="center">
                                <img src="../ADMIN/img_upload/agent_img/<?php echo $row_agent['agent_img']; ?>" alt="<?php echo $row_agent['agent_fname']; ?>" height="190px" width="200px">
<input type="file" name="pro_pic"  class="inp form-control" style="display:none;  width: 300px;" >
                                
                                </div>
                                
								<div class="col-sm-12" style="margin-top:15px; border-top: #CCC solid 1px">
                                <p style="font-size:14px; font-weight:600; color:#CCC; text-align:center">Personal Information</p>
<div class="col-sm-6" >
<table>
<tr><td>First Name</td><td>:</td><td><label class="lab"><?php echo $row_agent['agent_fname']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['agent_fname']; ?>" name="fname" style="display:none;color: rgb(129, 197, 134);" readonly></td></tr>
<tr><td>Last Name</td><td>:</td><td><label class="lab"><?php echo $row_agent['agent_lname']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['agent_lname']; ?>" name="lname" style="display:none;color: rgb(129, 197, 134);" readonly></td></tr>
<tr><td>Email ID</td><td>:</td><td><label class="lab"><?php echo $row_agent['email_id']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['email_id']; ?>" name="email" style="display:none;color: rgb(129, 197, 134);" readonly></td></tr>
<tr><td>Contact Number</td><td>:</td><td><label class="lab"><?php echo $row_agent['mobile_no']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['mobile_no']; ?>" name="mobile" style="display:none" ></td></tr>
<tr><td>Land-Line Number</td><td>:</td><td><label class="lab"><?php echo $row_agent['land_line']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['land_line']; ?>" name="landline" style="display:none" ></td></tr>
</table>
</div>
<div class="col-sm-6">
<table>
<tr><td>Company Name</td><td>:</td><td><label class="lab"><?php echo $row_agent['comp_name']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['comp_name']; ?>" name="compname" style="display:none" ></td></tr>
<tr><td>Business Volume</td><td>:</td><td><label class="lab"><?php echo $row_agent['busi_volume']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['busi_volume']; ?>" name="busivolume" style="display:none" ></td></tr>
<tr><td>Fax Number</td><td>:</td><td><label class="lab"><?php echo $row_agent['fax_no']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['fax_no']; ?>" name="faxno" style="display:none" ></td></tr>
<tr><td>IATA Number</td><td>:</td><td><label class="lab"><?php echo $row_agent['iata_no']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['iata_no']; ?>" name="iatano" style="display:none" ></td></tr>
<tr><td>Working State</td><td>:</td><td>
                           <?php 

$dvistate = $conn->prepare("SELECT * FROM dvi_states ");
$dvistate->execute();
//$row_dvistate= mysql_fetch_assoc($dvistate);
$row_dvistate_main=$dvistate->fetchAll();
?>
<select id="workstate" name="workstate" class="inp form-control " style="display:none" >
<?php foreach($row_dvistate_main as $row_dvistate){
	if($row_dvistate['code']==$row_agent['work_state']){
		$wname=$row_dvistate['name'];
	?>
    <option selected value="<?php echo $row_dvistate['code']; ?>"><?php echo $row_dvistate['name']; ?></option>
<?php }else{?>
	<option value="<?php echo $row_dvistate['code']; ?>"><?php echo $row_dvistate['name']; ?></option>
<?php } 
}?>
</select>
<label class="lab"><?php echo $wname; ?></label>
                                
 </td></tr>
</table>

</div>
                  			 	</div>
                                
                                <div class="col-sm-12" style="margin-top:10px; border-top:#CCC solid 1px;">
                                <p style="font-size:14px; font-weight:600; color:#CCC; text-align:center">Banking & Residential Information</p>
                                <div class="col-sm-6">
                                <table>
<tr><td>Account Number</td><td>:</td><td><label class="lab"><?php echo $row_agent['bank_acc_no']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['bank_acc_no']; ?>" name="bankaccnoc" style="display:none" ></td></tr>
<tr><td>IFSC Code</td><td>:</td><td><label class="lab"><?php echo $row_agent['bank_ifsc_code']; ?></label> <input class="inp form-control" type="text" value="<?php echo $row_agent['bank_ifsc_code']; ?>" name="bankifsccode" style="display:none" ></td></tr>
<tr><td>Address</td><td>:</td><td><label class="lab"><?php echo $row_agent['bank_addr']; ?></label> 
<textarea class="inp form-control" name="bankaddr" style="display:none; resize:none; height:90px; width:173px;"><?php echo $row_agent['bank_addr']; ?></textarea>
</td></tr>
</table>
                                </div>
                                 <div class="col-sm-6">
                                 <table>
                                 <tr><td>Home State</td><td>:</td><td> 
                                  <?php 

$dvistate = $conn->prepare("SELECT * FROM dvi_states ");
$dvistate->execute();
//$row_dvistate= mysql_fetch_assoc($dvistate);
$row_dvistate_main=$dvistate->fetchAll();
?>
<select id="add_state" name="add_state" class="inp form-control " style="display:none" onChange="find_my_city(this.value)">
<?php foreach($row_dvistate_main as $row_dvistate){
	if($row_dvistate['code']==$row_agent['state']){
		$sname=$row_dvistate['name'];
	?>
    <option selected value="<?php echo $row_dvistate['code']; ?>"><?php echo $row_dvistate['name']; ?></option>
<?php }else{?>
	<option value="<?php echo $row_dvistate['code']; ?>"><?php echo $row_dvistate['name']; ?></option>
<?php } 
}?>
</select>
<label class="lab"><?php echo $sname; ?></label>
                                 </td></tr>
                                 <tr><td>Home City</td><td>:</td><td id="home_city"> 
                                  <?php   

$dvicity = $conn->prepare("SELECT * FROM reg_cities where region=?");
$dvicity->execute(array($row_agent['state']));
//$row_dvicity= mysql_fetch_assoc($dvicity);
$row_dvicity_main=$dvicity->fetchAll();
$cname='Not chosen';
?>
<select id="add_city" name="add_city" class="inp form-control " style="display:none">
<?php foreach($row_dvicity_main as $row_dvicity){
	
	if($row_dvicity['id']==$row_agent['city']){
		$cname=$row_dvicity['name'];
	?>
    <option selected value="<?php echo $row_dvicity['id']; ?>"><?php echo $row_dvicity['name']; ?></option>
<?php }else{?>
	<option value="<?php echo $row_dvicity['id']; ?>"><?php echo $row_dvicity['name']; ?></option>
<?php } 
}?>
</select>
<label class="lab"><?php echo $cname; ?></label>
                                 </td></tr>
                                 
<tr><td>Home Address</td><td>:</td><td><label class="lab"><?php echo $row_agent['agent_addr']; ?></label> 
<textarea class="inp form-control" name="agentaddr" style="display:none; resize:none;height:90px; width:201px;"><?php echo $row_agent['agent_addr']; ?></textarea>
</td></tr>

</table>
                                 </div>
                                </div>
                                <div class="col-sm-12" id="hid_id" align="center" style="background-color:rgb(234, 250, 238); height:60px; display:none"><br>
                                <button id="update_pro" type="submit"  class="btn btn-primary  btn-rounded-lg " name="update_pro" value="update_pro_val">
										<i class="fa fa-edit"></i>&nbsp;Update
										</button>
                                        <button id="cancel_btn"  class="btn btn-primary  btn-rounded-lg " >
										<i class="fa fa-times"></i>&nbsp;Cancel
										</button><br>
                                        </div>
 <?php }?>
							  </div>
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        <?php }//if end of profile edit
						else if($_GET['group']=="password"){?>
                        
                        <div class="col-sm-12">
							<div class="panel panel-primary" >
                          
							  <div class="panel-heading ">
								<h3 class="panel-title">&nbsp; <i class="fa fa-cogs"></i>&nbsp;
<?php if($_GET['group']=="password"){ echo $row_agent['agent_fname']." ".$row_agent['agent_lname']; }?>
<span class="right-content">Password Settings</span>
</h3>
							  </div>
                              
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
						</div>
                        </div>
                        
                        
                        
                        <?php }//password change?>
                        
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
      	<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
                 
<script>
$(document).ready(function(e) {
    $('.chosen-select').chosen({'width': '100%'});
});

function find_my_city(sid,cname)
{	
var typ=19;
$.get('ajax_agent.php',{'sid':sid,'type':typ},function(result){
	$('#home_city').empty().html(result);
	});
}

function cancel_fun()
{
	$('.inp').hide();
	$('.lab').show();
	//$('#update_pro').hide();
	//$('#cancel_btn').hide();
	$('#edit_btn').show();
}


function edit_fun()
{
	$('#hid_id').show();
	$('#add_state').addClass('chosen-select');
	//$('.chosen').chosen({'width': '100%'});
	
	$('.lab').hide();
	$('.inp').show();
	$('#edit_btn').hide();
	//$('#update_pro').show();
	//$('#cancel_btn').show();
	
}

function check_pass()
{
	var new_pass=$('#new_pass').val();
	var re_pass=$('#re_pass').val();
	var cur_pass=$('#cur_pass').val();
	var cpa;
	if(new_pass==re_pass)
	{
		var typ=20;
$.get('ajax_agent.php',{'cpass':cur_pass,'type':typ},function(result){
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
                        