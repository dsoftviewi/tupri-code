<html>
<?php
require_once('../Connections/divdb.php');
require_once('../COMMN/smsfunc.php');

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone);
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");


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

/*function generate_password( $length = 8 ) {
$chars = "abcdefghijklmnopqrstuvwxyz0123456789*";
$password = substr( str_shuffle( $chars ), 0, $length );
return $password;
}
$password1 = generate_password();*/
	 
	$distr= $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
	$distr->execute(array($_GET['did']));
	$row_distr = $distr->fetch(PDO::FETCH_ASSOC);
	
	
if(isset($_POST['submit_modal']) && $_POST['submit_modal']=='submit_modal_val')
{
$file=$_FILES["agn_image"]["name"];
 if(trim($_FILES["agn_image"]["name"]) != '')
 {
	// echo "dd".$row_agent['agent_img'];
	 unlink('img_upload/distributor_img/'.$row_distr['distr_img']);
	  $FileType = pathinfo($file,PATHINFO_EXTENSION);
  $profile=$_GET['did'].'.'.$FileType;
$target_file='img_upload/distributor_img/'.$profile;
move_uploaded_file($_FILES["agn_image"]["tmp_name"], $target_file);
 }else
 {
	 $profile=$row_distr['distr_img'];
 }
 $updates=$conn->prepare("UPDATE distributor_pro set my_percentage=?,distr_fname=?, distr_lname=?, distr_addr=?, comp_name=?, busi_volume=?,state=?,city=?, land_line=?, mobile_no=?,fax_no=?, iata_no=?, bank_addr=? ,bank_acc_no=?, bank_ifsc_code=?,distr_img=?,work_state=? where distr_id=?");
 $updates->execute(array($_POST['distr_def_perc'],$_POST['agn_fname'],$_POST['agn_lname'],$_POST['addr'],$_POST['agn_cname'],$_POST['agn_bvolume'],$_POST['agn_state'],$_POST['hotel_city'],$_POST['agn_landline'],$_POST['agn_mobile'],$_POST['agn_fax'],$_POST['agn_iatano'],$_POST['agn_bk_addr'],$_POST['agn_bk_acc'],$_POST['agn_bk_ifsc'],$profile,$_POST['dis_work_state'],$_GET['did']));
	
				/*//mail config - start
				 $stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>New User Login Details!</span><img src='../img_upload/agent_img/".$profile."' alt='' width='240' height='64' style='float:right; margin-top:-10px;'/></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td>  </tr>  <tr align='center'>    <td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: #FF0000;'>".$_POST['agn_name']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p>Your Login id:".$id." <br> Your password is ".$password1." <br> Please login and update your personal credentials.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/><img src='assets/img/logo2-login.png' width='168' height='48' alt=''/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>ETPL-Helpdesk Service</td></tr><tr><td>DVI Group of Companies</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px;	font-weight: bold;	color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@elysiumtechnologies.com'>support@elysiumtechnologies.com</a> and call us at toll free 1800 - 103 - 2221. Needing any guidance we assist you at <a href='http://support.elysiumtechnologies.com' title='DVI Support' target='_blank'>DVI Support Center.</a></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://support.elysiumtechnologies.com' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>Elysium Support Center</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px;	font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." Elysium Technologies Private Limited. All rights reserved.</span></td>  </tr></table></body></html>";
	
	$to = $_POST['email_id'];
	$from = "ETPL Services <info@elysiumtechnologies.com>"; 
	$subject="Welcome Message from DVI_Holidays.com"; 
	$str=send_mail($to,$from,$subject,$stringData);*/
			
				//mail config -end

		$cn=$_POST['agn_fname'].' '.$_POST['agn_lname'];
		
echo "<script>parent.document.location.href='../admin_manadistrb.php?mm=".$_GET['mm']."&sm=".$_GET['sm']."&rec2=".md5(4)."&name=".$cn."';</script>"; 
}

?>
<head>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- PLUGINS CSS -->
		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
<!--		<link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">-->
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
        
<style>
body {

    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>

</head>
<body>
					  <div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class=" glyphicon glyphicon-user"></i> Update - <?php echo $row_distr['distr_fname']; ?>
                                <span class="right-content">
			<?php echo "[ IP :".$row_distr['ip_addr']." - when registered - ".date("d-M-Y",strtotime(substr($row_distr['datetime'],0,10)))." ]"?>
                                        </span>
                                </h3>
							  </div>
							  <div class="panel-body">
                               <form  name="form_agent"   method="post" enctype="multipart/form-data" onSubmit="return check_page2()" >
								<div class="row">
							<div class="col-sm-12">
                                
                                   <div id="first_div_id" >
                                   <center><strong style="color:#CCC"> Personal Infomations</strong></center>
                                   <br />
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="First Name" ><i class="fa fa-tag fa-fw"  ></i></span>
										  <input type="text" name="agn_fname" id='agn_fname' class="form-control" placeholder="First Name" value="<?php echo $row_distr['distr_fname'];?>">
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Last Name" ><i class="fa fa-tag fa-fw"  ></i></span>
										  <input type="text" name="agn_lname" id="agn_lname"  class="form-control" placeholder="Last Name" value="<?php echo $row_distr['distr_lname'];?>">
										</div>
									      </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" >
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Company Name" ><i class="fa fa-building-o fa-fw"  ></i></span>
										  <input type="text" name="agn_cname"  id="agn_cname"  class="form-control" placeholder="Company Number" value="<?php echo $row_distr['comp_name'];?>">
										</div>
									   </div>
                                    
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Business Volume" ><i class="fa  fa-building fa-fw"  ></i></span>
										  <input type="text" name="agn_bvolume"  id="agn_bvolume" class="form-control" placeholder="Business Volume" value="<?php echo $row_distr['busi_volume'];?>">
										</div>
									   </div>
                                        </div>
                                </div>
                                
                                    <div class="row">
                                    <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Land-Line Number"><i class="fa  fa-phone fa-fw"></i></span>
										 <input type="text" placeholder="Land-Line Number" class="form-control" name="agn_landline" id="agn_landline" value="<?php echo $row_distr['land_line'];?>">
										</div>
                                        </div>
                                </div>
                                    
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Mobile Number" ><i class="fa  fa-mobile fa-fw"  ></i></span>
										  <input type="text" name="agn_mobile" id="agn_mobile" class="form-control" placeholder="Mobile Number" value="<?php echo $row_distr['mobile_no'];?>">
										</div>
									   </div>
                                        </div>
                                </div>
                                
                                <div class="row" >
                                    <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Email ID"><i class="fa fa-envelope  fa-fw"></i></span>
										 <input type="text" placeholder="Email ID" class="form-control" name="agn_email" id="agn_email" value="<?php echo $row_distr['email_id'];?>" readonly>
										</div>
                                        </div>
                                </div>
                                    <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Fax Number"><i class="fa fa-fax fa-fw"></i></span>
										 <input type="text" placeholder="Fax Number" class="form-control" name="agn_fax" id="agn_fax" value="<?php echo $row_distr['fax_no'];?>">
										</div>
                                        </div>
                                </div>
                                
                                </div>
                                    
                                    <div class="row" >
                                    <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="IATA Number"><i class="fa fa-plane fa-fw"></i></span>
										 <input type="text" placeholder="IATA Number" class="form-control" name="agn_iatano" id="agn_iatano" value="<?php echo $row_distr['iata_no'];?>">
										</div>
                                        </div>
                                </div>
                                <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Distributor Percentage"><i class="fa fa-play fa-fw"></i></span>
										  <input type="text" class="form-control" data-placeholder="percentage" value="<?php echo $row_distr['my_percentage']; ?>" name="distr_def_perc" id="distr_def_perc" />
										
										</div>
                                        </div>
                                </div>
                  			
                                </div>
                                
                                <div class="row">
                                    
                  				<div class="col-sm-12">
                                <div class="form-group">
										 <div class="input-group">
										<div class="col-sm-4">
                                        <label id="lbl_id2" style="color:#CCC; display:none;">Upload Image :</label>
                                        <label id="lbl_id1"  style="color:#CCC; ">Current Image :</label>
                                         </div>
                                         <div class="col-sm-4">
                                         <img id="imm" class="pull-left" src="img_upload/distributor_img/<?php echo $row_distr['distr_img']; ?>" style="width:70px; height:70px" >
                                          <input id="upld_id" style="display:none"  type="file" placeholder="Profile Picture" name="agn_image"> <button type="button" class="pull-left" id="chan_btn" onClick="call_my_image()"> Change </button>
                                        
                                         </div>
                                         <div class="col-sm-4">
                                         <button type="button" id="cans_id" onClick="cancel_my_image()" style="display:none"> Cancel </button>
                                         </div>
										</div>
                                         
                                        </div>
                                      
                                </div>
                                
                                </div>
                                
                               
                                </div><!-- first_div_id -->
                                
                                <div id="second_div_id" style="display:none;">
                                <div class="row" style="margin-top:3px;">
                                    
                                <div class="col-sm-6" align="center">
                                <div class="form-group">
										 <div class="input-group" >
										<label style="text-align:right"> Working State</label>
										</div>
                                        </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group ">
                                    <?php 
									$hotelstate = $conn->prepare("SELECT * FROM dvi_states");
									$hotelstate->execute();
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelstate_main=$hotelstate->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="Working State "><i class="fa fa-globe fa-fw"></i></span>
										 <select id="dis_work_state" name="dis_work_state" class="form-control chosen-select col-lg-12 " tabindex="2"   data-placeholder="Choose Work State" >									
                                         <option ></option>	
										 <?php foreach($row_hotelstate_main as $row_hotelstate) {
											 if($row_distr['state']==$row_hotelstate['code'])
											 {
											 ?>
										<option selected value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option> <?php }else{?>
                                        <option value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option>
                                        <?php } 
										} ?>
									</select>
										</div>
                                        </div>
                                        </div>
                                </div>
                              <hr style=" margin-top: 10px; margin-bottom: 10px; ">
                                <center><strong style="color:#CCC;">Banking Information</strong></center>
                                
                                <div class="row" style="margin-top:15px; ">
                                    <div class="col-sm-12">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Bank Information"><i class="fa fa-university fa-fw"></i></span>
										 <textarea placeholder="Bank Information or Address" class="form-control" name="agn_bk_addr" id="agn_bk_addr" style="resize:none;"><?php echo $row_distr['bank_addr'];?></textarea>
										</div>
                                        </div>
                                </div>
                                </div>
                                
                                <div class="row" style="margin-top:3px;">
                                    
                                <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Account Number"><i class="fa fa-tags fa-fw"></i></span>
										 <input type="text" placeholder="Account Number" class="form-control" name="agn_bk_acc" id="agn_bk_acc" value="<?php echo $row_distr['bank_acc_no'];?>">
										</div>
                                        </div>
                                </div>
                                
                                <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Bank - IFSC Code"><i class="fa fa-rocket fa-fw"></i></span>
										 <input type="text" placeholder="IFSC Code" class="form-control" name="agn_bk_ifsc" id="agn_bk_ifsc"  value="<?php echo $row_distr['bank_ifsc_code'];?>">
										</div>
                                        </div>
                                </div>
                                </div>
                                    
                                      <hr style=" margin-top: 10px; margin-bottom: 10px; ">
                                       <center><strong style="color:#CCC;">Residential Address</strong></center>
                                       <br />
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group ">
                                    <?php 
									$hotelstate = $conn->prepare("SELECT * FROM dvi_states");
									$hotelstate->execute();
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelstate_main=$hotelstate->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="Agent State Location"><i class="fa fa-globe fa-fw"></i></span>
										 <select data-placeholder="Choose a State" name="agn_state" id="agn_state" class="form-control chosen-select col-lg-12 " tabindex="2" onChange="find_city(this.value)"  >									
                                         <option ></option>	
										 <?php foreach($row_hotelstate_main as $row_hotelstate) {
											 if($row_distr['state']==$row_hotelstate['code'])
											 {
											 ?>
										<option selected value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option> <?php }else{?>
                                        <option value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option>
                                        <?php } 
										} ?>
									</select>
										</div>
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group " id="default_city_id">
									<span class="input-group-addon tooltips" data-original-title="Agent city location"><i class="fa fa-map-marker fa-fw"></i></span>
                                    <?php
									$hotelcity = $conn->prepare("SELECT * FROM reg_cities where region=?");
									$hotelcity->execute(array($row_distr['state']));
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelcity_main=$hotelcity->fetchAll();
									?>
										 <select data-placeholder="Choose city" name="hotel_city" id="hotel_city" class="form-control chosen-select " tabindex="2">									<option></option>	
										 <?php 
										 foreach($row_hotelcity_main as $row_hotelcity) {
											   if($row_distr['city']==$row_hotelcity['id'])
											 {
											 ?>
										<option selected value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>  <?php }else{ ?>
                                 <option value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>       
                                        
                                        <?php  }
										} //while end?>
									</select>
										</div>
                                        </div>
                                        </div>
                                         <!-- /.col-sm-6 -->
                                </div>
                                
                                
                                <div class="row">
                                <div class="col-sm-12">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Residential Address"><i class="fa fa-home fa-fw"></i></span>
										  <textarea class="form-control no-resize" id="addr" name="addr"><?php echo $row_distr['distr_addr'];?></textarea>
										</div>
                                        </div>
                                </div>
                                </div>
                                </div>
                                </div>
							  </div>
                              <div class="modal-footer" style="margin-top:-10px; margin-bottom:-30px;">
                                              <div class="pull-left" id="note_id">
                                               <b style="color:#930; font-size:13px">Note :</b><strong style="color:#999; font-size:12px"> Image size should be less than 40KB</strong>
                                              </div>
                                              <button type="button" id="prev_btn" class="btn btn-info pull-left" onClick="show_first_div()" style="display:none;">Previous</button>
												<button type="button" class="btn btn-default" onClick="close_fancy()">Close</button>
												<button type="button" id="continue_btn" class="btn btn-info" onClick="hide_first_div()">Continue</button>
                                                <button type="submit" id="submit_id" name="submit_modal" value="submit_modal_val" class="btn btn-success" style="display:none;" >Submit</button>
											  </div>
                                              </form>
                              
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
        
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
		<script src="../core/assets/plugins/skycons/skycons.js"></script>
		<script src="../core/assets/plugins/prettify/prettify.js"></script>
		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
<!--		<script src="../core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="../core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="../core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="../core/assets/plugins/markdown/markdown.js"></script>
		<script src="../core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="../core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>-->
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
        
                 
<script>

$('.tooltips').tooltip({});
$('.chosen-select').chosen({width : '100%'});

function find_city(state_id)
{
	
		var type=16;
	$.get("ajax_hotel.php?sid="+state_id+"&type="+type,function(result)
	{
		//alert(result);
		$('#default_city_id').empty().html(result);
							$('.chosen-select').chosen({'width':'100%'});
							$('.tooltips').tooltip({});
		
	});
	
}


function model_div_hide()
{
	$('#second_div_id').hide();
	$('#submit_id').hide();
	$('#prev_btn').hide();	
	$('#first_div_id').show();
 	$('#continue_btn').show();	
}

function hide_first_div()
{
	if($('#agn_fname').val().trim()=='')
	{
		alert('Please Enter Valid First Name');
		$('#agn_fname').focus();	
	}else if($('#agn_lname').val().trim()=='')
	{
		alert('Please Enter Valid Last Name');
		$('#agn_lname').focus();
	}else if($('#agn_cname').val().trim()=='')
	{
		alert('Please Enter Company Name');
		$('#agn_cname').focus();
	}else if($('#agn_bvolume').val().trim()=='')
	{
		alert('Please Enter Your Business Volume');
		$('#agn_bvolume').focus();
	}else if($('#agn_mobile').val().trim()=='')
	{
		alert('Please Enter Your Mobile Number');
		$('#agn_mobile').focus();
	}
	else if($('#distr_def_perc').val().trim()=='')
	{
		alert('Please Enter Distributor Percentage( Min : 0)');
		$('#distr_def_perc').focus();
	}else{
	
 $('#first_div_id').hide();
 $('#note_id').hide();
 $('#second_div_id').show();
 $('#prev_btn').show();	
 $('#submit_id').show();
 $('#continue_btn').hide();	
	}
}

function check_page2()
{
	if($('#dis_work_state').val().trim()=='')
	{
		alert('Please Select Work State');
		$('#dis_work_state').focus();
		return false;	
	}else if($('#agn_state').val().trim()=='')
	{
		alert('Please Select State');
		$('#agn_state').focus();
		return false;	
	}else if($('#hotel_city').val().trim()=='')
	{
		alert('Please Select City');
		$('#hotel_city').focus();
		return false;	
	}else{
		return true;
	}
}

function show_first_div()
{
	$('#second_div_id').hide();
	$('#submit_id').hide();
	$('#prev_btn').hide();	
	$('#first_div_id').show();
 	$('#continue_btn').show();		
}

function call_my_image()
{
	$('#lbl_id1').hide();
	$('#lbl_id2').show();
 	$('#upld_id').show();
 	$('#cans_id').show();
	$('#chan_btn').hide();
	$('#imm').hide();
 	
}
function cancel_my_image()
{
	$('#lbl_id1').show();
	$('#lbl_id2').hide();
	$('#cans_id').hide();
	$('#upld_id').hide();
	$('#chan_btn').show();
	$('#imm').show();
}

function close_fancy()
{
 parent.jQuery.fancybox.close();
}

</script>                        

</html>
                        