<?php 

/*$ip_loctioan='';

$ip = $_SERVER['REMOTE_ADDR']; 
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if($query && $query['status'] == 'success') {
$ip_loctioan=$_SERVER['REMOTE_ADDR'].' - '.$query['query'].', '.$query['isp'].', '.$query['org'].', '.$query ['country'].', '.$query['regionName'].', '.$query['city'].'!';
} else {
$ip_loctioan='Unable to get location';
}

if(isset($_POST['submit_modal']) && $_POST['submit_modal']=='submit_modal_val')
{
		mysql_select_db($database_divdb, $divdb);
	$query_perc_sett = "SELECT * FROM employee_setting ";
	$perc_sett = mysql_query($query_perc_sett, $divdb) or die(mysql_error());
	//$row_perc_sett = mysql_fetch_assoc($perc_sett);
	$tot_perc_sett= mysql_num_rows($perc_sett);
	
	if($tot_perc_sett==3) // if employee_setting is empty
	{
	if($_POST['person'] == '0')//for agent registration 
	{
		mysql_select_db($database_divdb, $divdb);
		$query_vehid = "SELECT * FROM setting_ids  where sno =9";
		$vehid = mysql_query($query_vehid, $divdb) or die(mysql_error());
		$row_vehid = mysql_fetch_assoc($vehid);
		$id=$row_vehid['id_name'].$row_vehid['id_number'];
		$idin=$row_vehid['id_number']+1;
	if($_POST['agn_state']=='nil')
	{
		$_POST['agn_state']='';
	}
	while($row_perc_sett = mysql_fetch_assoc($perc_sett))
	{
		if($row_perc_sett['employee']=='Agent')
		{
			$agent_def_perc=$row_perc_sett['percentage'];
		}else if($row_perc_sett['employee']=='Admin_Markup_To_AGT')
		{
			$admin_prof_perc=$row_perc_sett['percentage'];
		}
	}
	$profile='default.jpg';
		 $insertSQLupd='insert into agent_pro (agent_id, distr_id, agent_fname, agent_lname, agent_addr, comp_name, state, city, land_line, mobile_no, email_id, agent_img, my_percentage, brokerage_perc, ip_addr, status) values("'.$id.'","'.$_POST['distributor'].'","'.$_POST['agn_fname'].'", "'.$_POST['agn_lname'].'","'.$_POST['addr'].'", "'.$_POST['agn_cname'].'", "'.$_POST['agn_state'].'","'.$_POST['hotel_city'].'", "'.$_POST['agn_landline'].'", "'.$_POST['agn_mobile'].'", "'.$_POST['agn_email'].'", "'.$profile.'", "'.$agent_def_perc.'","'.$admin_prof_perc.'","'.$ip_loctioan.'","1" )';
		mysql_select_db($database_divdb, $divdb);
		$Resultupd = mysql_query($insertSQLupd, $divdb) or die(mysql_error());
			//Update setting ids
		$insertSQLupd='update setting_ids set id_number="'.$idin.'" where sno=9';
		mysql_select_db($database_divdb, $divdb);
		$Resultupd = mysql_query($insertSQLupd, $divdb) or die(mysql_error());
		$vip="AGENT";
		$vvip="Agent";
		$v_img="agent_img";
	}else
	{
		mysql_select_db($database_divdb, $divdb);
		$query_vehid = "SELECT * FROM setting_ids  where sno =10";
		$vehid = mysql_query($query_vehid, $divdb) or die(mysql_error());
		$row_vehid = mysql_fetch_assoc($vehid);
		$id=$row_vehid['id_name'].$row_vehid['id_number'];
		$idin=$row_vehid['id_number']+1;
	if($_POST['agn_state']=='nil')
	{
		$_POST['agn_state']='';
	}
	while($row_perc_sett = mysql_fetch_assoc($perc_sett))
	{
		if($row_perc_sett['employee']=='Distr')
		{
			$dist_def_perc=$row_perc_sett['percentage'];
		}
	}
	$profile='default.jpg';
	$insertSQLupd='insert into distributor_pro (distr_id, distr_fname, distr_lname, distr_addr, comp_name, state, city, land_line, mobile_no, email_id, distr_img,  my_percentage, ip_addr, status) values("'.$id.'", "'.$_POST['agn_fname'].'", "'.$_POST['agn_lname'].'","'.$_POST['addr'].'", "'.$_POST['agn_cname'].'", "'.$_POST['agn_state'].'","'.$_POST['hotel_city'].'", "'.$_POST['agn_landline'].'", "'.$_POST['agn_mobile'].'","'.$_POST['agn_email'].'", "'.$profile.'", "'.$dist_def_perc.'","'.$ip_loctioan.'", "1" )';
		mysql_select_db($database_divdb, $divdb);
		$Resultupd = mysql_query($insertSQLupd, $divdb) or die(mysql_error());
		 //Update setting ids
		$insertSQLupd='update setting_ids set id_number="'.$idin.'" where sno=10';
		mysql_select_db($database_divdb, $divdb);
		$Resultupd = mysql_query($insertSQLupd, $divdb) or die(mysql_error());
		$vip="DISTRB";
		$vvip="Distributor";
		$v_img="distributor_img";
	}
	//mail config - start
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>New ".$vvip." Request is pending!</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$_POST['agn_fname'].' '.$_POST['agn_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br>  Please hold on until your registration gets approved.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	$to = $_POST['agn_email'];
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
	//mail config -end
	$cn=$_POST['agn_fname'].' '.$_POST['agn_lname'];
	echo "<script>alert('Thankyou For Your Registration, Check your mail...');</script>";
	}else{ // if setting_employee table is empty means
		$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Please set your employee default percentage..</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'></span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br>  Please hold on until your registration gets approved.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	$to = "vsr@v-i.in";
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in> Website ( dvi.co.in)"; 
	$subject="Manage settings from dvi.co.in";
	$str=send_mail($to,$from,$subject,$stringData);
		echo "<script>alert('Please Try Again Later..');</script>";
	}

}*/

?>
<style type="text/css">
.navbar-brand{padding: 0px!important;}
#modalAds .close {margin-top: -18px;}
 #modalAds .modal-dialog{margin: 122px auto;}
 #modalAds1 .close {margin-top: -18px;}
 #modalAds1 .modal-dialog{margin: 122px auto;}
</style>
<!--<body onLoad="javascript$(#travelo-login).modal('show')">-->
<script src="//content.jwplatform.com/libraries/bFyELn2w.js"></script>
<script src="//s3.amazonaws.com/support-static.jwplayer.com/staging/modernizr.js"></script>
<?php  $lik=explode("/", $_SERVER['REQUEST_URI']);?>
<body <?php if($lik[1]=="index.php" || $lik[1]==""){?> class="modal-open" <?php } ?>>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-WCQ8KN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WCQ8KN');</script>
<!-- End Google Tag Manager -->
<div class="modal fade" id="InfoModalColor212" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="width:60%">
	  <form  name="hotel_add"  id="hotel_add"  method="post" enctype="multipart/form-data"  onSubmit="return validate_final()">
<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border" style="background-color:rgb(237, 238, 239);padding-bottom: 5px;padding-top: 5px;">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												 <img src="images/logo.png" alt="DVI Logo" />
                                               
											  </div>
 <div class="modal-body" style=" padding-bottom: 5px;">
                                                <div class="row">
              <div class="col-sm-12">
                                
                                   <div id="first_div_id" >
                               
                                   <center><strong style="color:#F00" id="reg_head"> Registration Form</strong></center>
                                   <br />
                                                <div class="row">
                  <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="First Name" ><i class="fa fa-tag fa-fw"  ></i></span>
                      <input type="text" name="agn_fname" id="agn_fname"  class="form-control" placeholder="First Name">
                    </div>
                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Last Name" ><i class="fa fa-tag fa-fw"  ></i></span>
                      <input type="text" name="agn_lname" id="agn_lname"  class="form-control" placeholder="Last Name">
                    </div>
                        </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:5px">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Company Name" ><i class="fa fa-building-o fa-fw"  ></i></span>
                      <input type="text" name="agn_cname" id="agn_cname"  class="form-control" placeholder="Company Name">
                    </div>
                     </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Email ID"><i class="fa fa-envelope  fa-fw"></i></span>
                     <input type="text" placeholder="Email ID" class="form-control" id="agn_email" name="agn_email">
                    </div>
                     </div>
                                        </div>
                                </div>
                                
                                    <div class="row" style="margin-top:5px">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Mobile Number" ><i class="fa  fa-mobile fa-fw"  ></i></span>
                      <input type="text" name="agn_mobile" id="agn_mobile" class="form-control" placeholder="Mobile Number">
                    </div>
                     </div>
                                        </div>
                                    
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group ">
                                    <?php 
                  $hotelcountry = $conn->prepare("SELECT * FROM dvi_country");
                  $hotelcountry->execute();
                  //$row_hotelstate= mysql_fetch_assoc($hotelstate);
				  $row_hotelcountry_main=$hotelcountry->fetchAll();
                  ?>
                  <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Living State"><i class="fa fa-globe fa-fw"></i></span>
                     <select data-placeholder="Choose a Country" name="agn_count" id="agn_count" class="form-control chosen-select col-lg-12 " tabindex="2" onChange="find_state(this.value)"   >                  
                                         <option value='nil'>Choose a Country</option>  
                     <?php foreach($row_hotelcountry_main as $row_hotelcountry) {?>
                    <option value="<?php echo $row_hotelcountry['ciso'];?>"><?php echo $row_hotelcountry['cname'];?></option>
                                        <?php } ?>
                  </select>
                    </div>
                                        </div>
                                        </div>
                                </div>
                                
                                <!-- <div class="row" style="margin-top:5px">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group " id="default_state_id">
                    
                  <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Living State"><i class="fa fa-globe fa-fw"></i></span>
                     <select data-placeholder="Choose country initially" name="agn_state" id="agn_state" class="form-control chosen-select col-lg-12 " tabindex="2"    >                  
                                         <option value='nil'>Choose country initially</option>  
                                       
                        </select>
                    </div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group " id="default_city_id">
                  <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="City Name"><i class="fa fa-map-marker fa-fw"></i></span>
                     <select data-placeholder="Choose A City" class="form-control chosen-select col-lg-12 " tabindex="2">           <option value="" disabled>Choose state - initially</option> 
                    
                  </select >
                    </div>
                                        </div>
                                        </div>
                                </div> -->
                                    
                                    <div class="row" style="margin-top:5px">
                                <div class="col-sm-12">
                                <div class="form-group">
                     <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Residential Address"><i class="fa fa-home fa-fw"></i></span>
                      <textarea class="form-control no-resize" name="addr" id="addr" style="resize:none" placeholder="Residential Address"></textarea>
                    </div>
                                       
                                        </div>
                                </div>
                                </div>
                                <hr style=" margin-top: 5px;margin-bottom: 5px;border-color: #f5f5f5;">
                                
                                <div class="row" style="margin-top:5px;display:none">
                                    <div class="col-sm-6">
                                <div class="form-group">
                     <div class="input-group">
              <h6 style="font-size:16px;margin-left: 42px;"><i style="color:#F00">*</i> &nbsp;Which post do you want to apply ? </h6>
                    </div>
                                        </div>
                                </div>
                                    
                                <div class="col-sm-6">
                                    <table width="100%"><tr>
                                    <td  width="45%"><label class="btn btn-sm" style="background-color: rgb(252, 252, 252);" ><input type="radio" class="" id="distrr" name="person" value="1"  onClick="hide_distr()" >&nbsp;&nbsp;Distributor</label></td>
                                    <td  width="5%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td  width="45%"><label class="btn btn-sm" style="background-color: rgb(252, 252, 252);"><input type="radio" class="" id="agentt" name="person" value="0"  checked='checked' onClick="show_distr()">&nbsp;&nbsp;Agent</label></td></tr></table>
                                    
                                    <div id="disr_sel" class="form-group" style="display:none;">
                                    <div class="input-group">
                                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Choose Your Distributor"><i class="fa fa-home fa-fw"></i></span>
                                     <?php
                 
                  $distr = $conn->prepare("SELECT * FROM distributor_pro");
                  $distr->execute();
				   $row_distr_main = $distr->fetchAll();
                  ?>
                    <select id="distr_sel" data-placeholder="Choose Distributor" name="distributor" class="form-control chosen-select col-lg-12 " tabindex="2"  >                 
                                         <option value="nil">Choose Distributor</option>  
                     <?php foreach($row_distr_main as $row_distr) {?>
                    <option <?php if($row_distr['distr_id']=='DSR128'){ echo "selected";} ?> value="<?php echo $row_distr['distr_id'];?>"><?php echo $row_distr['distr_fname']."&nbsp;".$row_distr['distr_lname'];?></option>
                                        <?php } ?>
                  </select>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                </div><!-- first_div_id -->
                                </div>
                </div>
                        </div>
											   <div class="modal-footer" style="margin-top:0px">
												<button type="button" id="modal_sub_cancel" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="submit_id" name="submit_modal" value="submit_modal_val" class="btn btn-success pull-right"  ><i class="fa fa-thumbs-o-up"></i>&nbsp;Submit</button>
											  </div><!-- /.modal-footer -->
											</div>
	  </form>							  
	</div></div>
<div class="modal fade" id="modalAds" tabindex="-1" role="dialog" aria-hidden="true" >
<div class="modal-dialog" style="width:51%">
<div class="modal-header bg-info no-border" style="background-color:rgb(237, 238, 239);padding:20px;border-radius:10px">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clscls1()">&times;</button>
<div id="myElement1">Loading the player...</div>
<script type="text/javascript">
var playerInstance = jwplayer("myElement1");
playerInstance.setup({
file: "https://www.youtube.com/watch?v=j2sSojSFBxY?autoplay=1",
width: 640,
height: 360,
autostart: true,
});
</script>
<!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/j2sSojSFBxY?autoplay=1" frameborder="0"  allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe> -->
<!-- <video  controls="controls" poster="" width="100%" height="100%" autoplay>
    <source src="Alumini Video.mp4" type="video/mp4" />
    <object type="application/x-shockwave-flash" data="ADMIN/videos/flowplayer-3.2.1.swf" width="640" height="360">
        <param name="movie" value="ADMIN/videos/flowplayer-3.2.1.swf" />
        <param name="allowFullScreen" value="true" />
        <param name="wmode" value="transparent" />        
    
    </object>
</video> -->
</div>
</div><!-- /.modal-dialog -->
</div>


<?php

$aboutus1 = $conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$aboutus1->execute();
$row_aboutus1 = $aboutus1->fetch(PDO::FETCH_ASSOC);
$total_aboutus1 = $aboutus1->rowCount();
?>
    <div id="page-wrapper" >
        <header id="header" class="navbar-static-top">
            <div class="topnav hidden-xs">
                <div class="container">
                    <ul class="quick-menu pull-left">
                        <li><a href="contact.php"><i class="soap-icon-message"></i>&nbsp;  <?php echo $row_aboutus1['email']; ?></a></li>
                        <li><a href="javascript:void(0);"><i class="soap-icon-phone"></i>&nbsp;  <?php echo $row_aboutus1['phone']; ?></a></li>
                    </ul>
                    <ul class="quick-menu pull-right">
                        <li><a data-target="#travelo-login" style="cursor:pointer" class="soap-popupbox"><i class="soap-icon-user"></i> LOGIN</a></li>
                       <!-- <li><a data-target="#travelo-signup" style="cursor:pointer" class="soap-popupbox"  onClick="model_div_hide()"><i class="soap-icon-list"></i> SIGNUP</a></li>-->
                      <li><a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor212"><i class="soap-icon-list"></i>&nbsp;SIGNUP</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="main-header">
                
                <a href="#mobile-menu-01" data-toggle="collapse" class="mobile-menu-toggle">
                    Mobile Menu Toggle
                </a>

                <div class="container">
                    <h1 class="navbar-brand">
                        <a href="index.php" title="Home Page">
                            <img src="images/logo2.png"  alt="DVI Logo"/>
                        </a>
                    </h1>
      <?php 

$hotspots = $conn->prepare("SELECT * FROM hotspots_pro where status='0' GROUP BY spot_state ASC");
$hotspots->execute();
$row_hotspots_main= $hotspots->fetchAll();
$total_hotspots = $hotspots->rowCount();

       ?>                
                    <nav id="main-menu" role="navigation">
                        <ul class="menu">

                            <li class="menu-item-has-children"><a class="active" href="index.php">Home</a></li>
                            <li class="menu-item-has-children"><a href="about.php">About Us</a></li>
                            <li class="menu-item-has-children megamenu-columns-2"> <a href="javascript:void()">Incredible India !</a>
                            <ul class="sub-menu">
                            <?php 
							foreach($row_hotspots_main as $row_hotspots) {
								

$states = $conn->prepare("SELECT * FROM dvi_states where code =?");
$states->execute(array($row_hotspots['spot_state']));
$row_states_main = $states->fetchAll();
$total_states = $states->rowCount();
								?>
                                <li>
                                <a href="hotspot.php?id=<?php echo $row_states_main[0]['code'];?>"><?php echo $row_states_main[0]['name'];?></a>
                                </li>
                                <?php }?>
                            </ul>
                            </li>
                            <li class="menu-item-has-children"><a href="javascript:void(0)">Packages</a>
                            	<ul class="sub-menu">
                 <li class="menu-item-has-children"><a href="domestic_itin.php">Domestic itineraries</a></li>
                 <li class="menu-item-has-children"><a href="internation_itin.php">International itineraries</a></li>
                            	</ul>
                            </li>
                            <li class="menu-item-has-children"><a href="gallery.php">Gallery</a></li>
                            <li class="menu-item-has-children"><a href="faq.php">FAQ</a></li>
                            <li class="menu-item-has-children"><a href="contact.php">Contact Us </a></li>
                            <li class="menu-item-has-children" id="veopn" <?php if($lik[1]=="index.php" || $lik[1]==""){?> style="display:none"<?php } ?>><a onclick="viewvideo()" href="javascript:void(0);"  >Video</a></li> 
                        </ul>
                    </nav>
                </div>
   
                <nav id="mobile-menu-01" class="mobile-menu collapse">
                    <ul id="mobile-primary-menu" class="menu">
                           <li class="menu-item-has-children"><a href="index.php">Home</a></li>
                            <li class="menu-item-has-children"><a href="about.php">About Us</a></li>
                            <li class="menu-item-has-children"> <a href="">Incredible India !</a>
                            <ul>
                            <?php foreach($row_states_main as $row_states) {?>
                                <li><a href="hotspot.php"><?php echo $row_states['name'];?></a></li>
                                <?php } ?>
                                <li><a href="hotspot.php">kerela</a></li>
                            </ul>
                            </li>
                            <li class="menu-item-has-children"><a href="gallery.php">Gallery</a></li>
                            <li class="menu-item-has-children"><a href="faq.php">FAQ</a></li>
                            <li class="menu-item-has-children"><a href="contact.php">Contact Us</a></li>
                        
                        
                        
                    </ul>
                    
                    <ul class="mobile-topnav container">
                        <li><a href="#"><i class="soap-icon-message"></i> vsr@dvi.co.in</a></li>
                        <li><a href="#"><i class="soap-icon-phone"></i> 9843288844</a></li>
                        <li><a data-target="#travelo-login" style="cursor:pointer" class="soap-popupbox">LOGIN</a></li>
                        <!--<li><a data-target="#travelo-signup" style="cursor:pointer" class="soap-popupbox" >SIGNUP</a></li>-->
                       <li><a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor212"><i class="soap-icon-list"></i>&nbsp;SIGNUP</a></li>
                    </ul>
                    
                </nav>
            </div>
            
            
         
            
            <div id="travelo-login" class="travelo-login-box travelo-box">
                <div class="login-social">
                    <img src="images/logo.png" alt="DVI Logo" />
                </div>
                <div class="seperator"><label></label></div>
                <form action="" name="login" method="POST" id="login_my">
                    <div class="form-group">
                    	<div id="errlogin"></div>
                        <input name="uname" id="uname" type="text" class="input-text full-width" placeholder="Username" value="<?php echo (isset($_COOKIE['rem_user'])&& !empty($_COOKIE['rem_user'])) ? $_COOKIE['rem_user'] : ''; ?>" onkeydown="">
                    </div>
                    <div class="form-group">
                        <input name="passwd" id="passwd" type="password" class="input-text full-width" placeholder="Password" value="<?php echo (isset($_COOKIE['rem_pwd'])&& !empty($_COOKIE['rem_pwd'])) ? $_COOKIE['rem_pwd'] : ''; ?>" onkeydown="if (event.keyCode ==13) document.getElementById('loguser').click()">
                    </div>
                    <div class="form-group">
                      <a data-target="#travelo-forgot" href="javascript:void(0)" class="forgot-password pull-right" onClick="forgot_pass()"> Forgot password?</a>
                        <div class="checkbox checkbox-inline">
                            <label>
                                <input type="checkbox" name="remember" id="remember" value="1" <?php echo ((isset($_COOKIE['rem_user']) && isset($_COOKIE['rem_pwd'])) ? 'checked' : '');?> onkeydown="if (event.keyCode ==13) document.getElementById('loguser').click()"> Remember me
                            </label>
                        </div>
                    </div>
                     <button name="loguser" id="loguser" onClick="check_login()" type="button" class="full-width btn-medium">Login</button>
                </form>
                
                <div id='forgot_pass' style="display:none;">
                <div class="form-group" style="text-align:center; color:#F00; font-weight:600" id="notice_fb"> Please Enter Your Registered Email ID</div>
                <div class="form-group">
                        <input name="reg_emailid" id="reg_emailid" type="text" class="input-text full-width" placeholder="Registered Email ID" value="" onkeydown="">
                    </div>
                    <button name="forgotuser" id="forgotuser" onClick="check_forgot_pass()" type="button" class="full-width btn-medium">Send Password</button>
                  <div class="form-group" style="text-align:center; color:#F00; font-weight:600" > Or </div>
                    <button style="background-color:rgb(61, 176, 213)" name="backtologin" id="backtologin" onClick="bacttologin()" type="button" class="full-width btn-medium">Back To Login</button>
                </div>
                
                <div class="seperator"></div>
                <!--<p>Don't have an account? <!--<a href="#travelo-signup" class="goto-signup soap-popupbox" onClick="model_div_hide()" >Sign up</a>--<a href="#InfoModalColor212" class=" soap-popupbox" data-toggle="modal" onclick="model_div_hide()" >&nbsp;SIGNUP</a></p>-->
                <strong style="color:#900; font-size:10px">* This application is best operable with Chrome & Firefox</strong>
            </div>
        </header>

<script>
var check='';
function check_login()
{
	var uname=document.getElementById('uname').value;
	var passwd=document.getElementById('passwd').value;
	var remember=0;
	
	if (document.getElementById('remember').checked) 
	{
		remember = '1';
	}
	var uid="-";
	var type=1;
	var swt=0;
	
	var strURL="login_check.php?uname="+uname+"&passwd="+passwd+"&ty="+type+"&remember="+remember+"&swt="+swt+"&uid="+uid;
	
	function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	var ses;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() 
		{
			if (req.readyState == 4 && req.status == 200) 
			{
				 check=req.responseText.trim();
				 //alert(check);
				 if (check == 'not')
				 {
					document.getElementById('errlogin').innerHTML = "<p style='color:red'><i style='color:red' class='fa fa-bell'></i> &nbsp;Login Credentials Invalid!</p>";
				 }
				 else
				 {
         // window.location.href='dashboard_maintain.php';
         // return false;
					if(check == 'AGENT')
					{
						window.location.href='agent_manaorder.php?mm=23311f54cbcb20fd815e2574e8b07b39&sm=f0e2efabf331f439ad99596cea1accf3';	
					}else{
						window.location.href='dashboard.php';	
					}
				 }
			}  
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}
	</script>        
<script>

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	
function show_distr()
{
	document.getElementById("disr_sel").style.display='block';
	//document.getElementById("distr_sel").removeAttribute('disabled');
}

function hide_distr()
{ 
	document.getElementById("disr_sel").style.display='none';
    //document.getElementById('distr_sel').disabled="false";
}


function model_div_hide()
{
	$('#reg_head').empty().prepend('Registration Form');
	/*	document.getElementById('second_div_id').style.display='none';
			document.getElementById('third_div_id').style.display='none';
				document.getElementById('submit_id').style.display='none';
					document.getElementById('prev_btn').style.display='none';
						document.getElementById('prev_btn2').style.display='none';
							document.getElementById('first_div_id').style.display='block';
								document.getElementById('continue_btn').style.display='block';
									document.getElementById('continue_btn2').style.display='none';*/
}

var check='';
function validate_final()
{
  var type=2;
  var email_check='';
  var ag_nme=document.getElementById('agn_fname').value;
  var agn_email=document.getElementById('agn_email').value;
  var agmobile=document.getElementById('agn_mobile').value.trim();
  var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,10}|[0-9]{1,3})(\]?)$/;
  var numbers =  /^\d+$/; 
  var strin = /^[a-zA-Z ]{4,30}$/;
  var lstrin = /^[a-zA-Z ]{1,30}$/;

  //alert(document.getElementById('agentt').checked);
  if(document.getElementById('agn_fname').value.trim()=='')
  {
    alert('Please Enter valid first name');
    document.getElementById('agn_fname').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_fname').value.trim().length<4  )
  {
    alert('First name should be minimum 4 charactors');
    document.getElementById('agn_fname').focus();
    check=0;
    //return false;
  }else if(!strin.test(ag_nme))
  {
    alert('Characters only acceptable on first-name');
    document.getElementById('agn_fname').focus();
    check=0;
    //return false;
  }
  else if(document.getElementById('agn_lname').value.trim()=='')
  {
    alert('Please Enter valid last name');
    document.getElementById('agn_lname').focus();
    check=0;
    //return false;
  }else if(!lstrin.test(document.getElementById('agn_lname').value.trim()))
  {
    alert('Characters only acceptable on last-name');
    document.getElementById('agn_lname').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_cname').value.trim()=='')
  {
    alert('Please Enter valid company name');
    document.getElementById('agn_cname').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_cname').value.trim().length<4)
  {
    alert('company name should be minimum 4 charactors');
    document.getElementById('agn_cname').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_mobile').value.trim()=='')
  {
    alert('Please Enter Mobile number');
    document.getElementById('agn_mobile').focus();
    check=0;
    //return false;
  }else if(!numbers.test(agmobile))
  {
    alert('Please Enter Valid Mobile Number');
    document.getElementById('agn_mobile').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_mobile').value.trim().length<10 || document.getElementById('agn_mobile').value.trim().length>13)
  {
    alert('Invalid Mobile Number');
    document.getElementById('agn_mobile').focus();
    check=0;
    //return false;
  }
  else if(document.getElementById('agn_email').value.trim()=='')
  {
    alert('Please Enter valid email id');
    document.getElementById('agn_email').focus();
    check=0;
    //return false;
  }else if(!expr.test(agn_email))
  {
    alert('Invalid email id, Please Enter Valid email id');
    document.getElementById('agn_email').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_count').value.trim()=='nil')
  {
    alert('Please choose your country');
    document.getElementById('agn_count').focus();
    check=0;
    //return false;
}
  // }else if(document.getElementById('agn_state').value.trim()=='nil')
  // {
  //   alert('Please choose your state');
  //   document.getElementById('agn_state').focus();
  //   check=0;
  //   //return false;
  // }
  // else if(document.getElementById('hotel_city').value.trim()=='')
  // {
  //   alert('Please choose your city');
  //   document.getElementById('hotel_city').focus();
  //   check=0;
  //   //return false;
  // }
  else if(document.getElementById('addr').value.trim()=='')
  {
    alert('Please Enter Your Address');
    document.getElementById('addr').focus();
    check=0;
    //return false;
  }else if(document.getElementById('addr').value.trim().length<5)
  {
    alert('Please Enter Your Valid Address');
    document.getElementById('addr').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agentt').checked && document.getElementById('distr_sel').value=='nil')
  {
      alert('Please Choose Your Distributor');
      document.getElementById('distr_sel').focus();
      check=0;
    //return false;
  }else{
      var strURL="login_check.php?email="+agn_email+"&ty="+type;
      var req = getXMLHTTP();
      if (req) {
        req.onreadystatechange = function() 
        {
          if (req.readyState == 4 && req.status == 200) 
          {
                   email_check=req.responseText.trim();
                  // alert(email_check);
            if(email_check == 'yes')
            {
              check=1;
              //alert('submit'+check);
                  //return true;      
            }else{
              check=0;
              alert("This Email ID already exists, Please give alternate mailid ..");
              document.getElementById('agn_email').focus();
              //return false;
            }
          }  
        }     
        req.open("GET", strURL, false);
        req.send(null);
      }
    }
    
      if(check==0)
      {
        return false;
      }else{
        fun_noitartsiger();
        return false;
        //return true;  
      }
}

function find_city(state_id)
{
	var type=15;
	var strURL="ADMIN/ajax_hotel.php?sid="+state_id+"&type="+type;
	
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() 
		{
			if (req.readyState == 4 && req.status == 200) 
			{
				document.getElementById('default_city_id').innerHTML = req.responseText;
				}  
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}

function fun_noitartsiger()
{
	$('#reg_head').empty().prepend('Registration Form [ Processing .. ]');
	var datastring = $("#hotel_add").serialize();
        $.ajax({
            type: "POST",
            url: "login_check.php?ty=3",
            data: datastring,
            success: function(res) {
				$('#reg_head').empty().prepend('Registration Form [ Completed ]')
                alert("Wow! That's great you are in. Your registration may take 2 to 8 working hrs, check your e-mail for password");
				$('#modal_sub_cancel').trigger('click');
            }
        });
}

function forgot_pass()
{
	$('#notice_fb').empty().prepend('Please Enter Your Registered Email ID').css('color','rgb(230, 45, 1)');
	$('#login_my').hide();
	$('#forgot_pass').show();
}

function bacttologin()
{
	$('#login_my').show();
	$('#forgot_pass').hide();
}

function check_forgot_pass()
{
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	var reg_mid=$('#reg_emailid').val().trim();
	var res;
	
	if(reg_mid=='')
	{
		$('#notice_fb').empty().prepend('Please Enter Your Registered Email ID..').css('color','rgb(230, 45, 1)');
	}else if(!expr.test(reg_mid))
	{
		$('#notice_fb').empty().prepend('Invalid Mail ID, Please Enter Valid Email ID').css('color','rgb(230, 45, 1)');
		document.getElementById('reg_emailid').focus();
	}else{
		$('#notice_fb').empty().prepend('Please Wait..').css('color','#C93');
		$.get('login_check.php?ty=4&fb='+reg_mid,function(result)
		{
			res=result.trim();
			if(res=='yes')
			{
				$('#notice_fb').empty().prepend('Password sent to given mail id').css('color','rgb(36, 95, 17)');
			}else{
				$('#notice_fb').empty().prepend('Kindly varify your mail id').css('color','rgb(230, 45, 1)');
			}
		});
	}
}
function viewvideo(){
	<?php  $_SESSION['v_id']=0; 
	$_SESSION['vv_id']=0;?>
	$('#modalAds').show();
	$("#modalAds").addClass("modal fade in");
      $("body").addClass("modal-open ");
}
function clscls1(){
<?php  $_SESSION['v_id']=1; $_SESSION['vv_id']=1; ?>
      $('#modalAds').hide();
      $("body").removeClass("modal-open");
  
   }
   function find_state(state_id)
{
  var type=16;
  var strURL="ajax_page.php?sid="+state_id+"&type="+type;
  
  var req = getXMLHTTP();
  if (req) {
    req.onreadystatechange = function() 
    {
      if (req.readyState == 4 && req.status == 200) 
      {
        document.getElementById('default_state_id').innerHTML = req.responseText;
        }  
    }     
    req.open("GET", strURL, true);
    req.send(null);
  }
}
function find_city(state_id)
{
  var type=15;
  var strURL="ajax_page.php?sid="+state_id+"&type="+type;
  
  var req = getXMLHTTP();
  if (req) {
    req.onreadystatechange = function() 
    {
      if (req.readyState == 4 && req.status == 200) 
      {
        document.getElementById('default_city_id').innerHTML = req.responseText;
        }  
    }     
    req.open("GET", strURL, true);
    req.send(null);
  }
}
</script>
