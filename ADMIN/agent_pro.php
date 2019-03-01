

 <?php
include("COMMN/smsfunc.php");
$agentpro = $conn->prepare("SELECT * FROM agent_pro where status='0' ORDER BY sno DESC");
$agentpro->execute();
$row_agentpro_main = $agentpro->fetchAll();
$totalRows_agentpro = $agentpro->rowCount();

$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$mon=$date->format('F');
$dd=$date->format('m/d/Y');

//agent settings
if(isset($_POST['agent_sett']) && $_POST['agent_sett']=='agent_sett_val')
{
	$sett = $conn->prepare("SELECT * FROM employee_setting where employee='Agent'");
	$sett->execute();
	$row_sett = $sett->fetch(PDO::FETCH_ASSOC);
	$tot_sett=$sett->rowCount();
	
	if($tot_sett>0)
	{
		
		$deletesett=$conn->prepare("delete from employee_setting where employee = 'Agent'");
		$deletesett->execute();
		
		$deletesett1=$conn->prepare("delete from employee_setting where employee = 'Admin_Markup_To_AGT'");
		$deletesett1->execute();
		
		$insertsett=$conn->prepare("insert into employee_setting(employee,percentage)values('Agent',?)");
		$insertsett->execute(array(trim($_POST['agt_def_perc'])));
		
		$insertsett1=$conn->prepare("insert into employee_setting(employee,percentage)values('Admin_Markup_To_AGT',?)");
		$insertsett1->execute(array(trim($_POST['adm_markup_perc'])));
		
		$updatesett=$conn->prepare("update agent_pro set brokerage_perc=?");
		$updatesett->execute(array(trim($_POST['adm_markup_perc'])));
		
		//distr my edit start
		$updatesettdst=$conn->prepare("update distributor_pro set my_percentage=?");
		$updatesettdst->execute(array(trim($_POST['adm_markup_perc'])));
		//distr my edit end
	}else{
		
		$insertsett=$conn->prepare("insert into employee_setting(employee,percentage)values('Agent',?)");
		$insertsett->execute(array(trim($_POST['agt_def_perc'])));
		
		$insertsett1=$conn->prepare("insert into employee_setting(employee,percentage)values('Admin_Markup_To_AGT',?)");
		$insertsett1->execute(array(trim($_POST['adm_markup_perc'])));
		
		$updatesett=$conn->prepare("update agent_pro set brokerage_perc=?");
		$updatesett->execute(array(trim($_POST['adm_markup_perc'])));
		
		$updatesettdst=$conn->prepare("update distributor_pro set my_percentage=?");
		$updatesettdst->execute(array(trim($_POST['adm_markup_perc'])));
		//distr my edit end
	}
}



if(isset($_POST['submit_modal']) && $_POST['submit_modal']=='submit_modal_val')
{
	$vehid = $conn->prepare("SELECT * FROM setting_ids  where sno =9");
	$vehid->execute();
	$row_vehid = $vehid->fetch(PDO::FETCH_ASSOC);
	$id=$row_vehid['id_name'].$row_vehid['id_number'];
	$idin=$row_vehid['id_number']+1;

	if(trim($_FILES["agn_image"]["name"]) != '')
	{
		$file=$_FILES["agn_image"]["name"];
		$FileType = pathinfo($file,PATHINFO_EXTENSION);
		$profile=$id.'.'.$FileType;
		$target_file=$_SESSION['grp'].'/img_upload/agent_img/'.$profile;
		move_uploaded_file($_FILES["agn_image"]["tmp_name"], $target_file);
	}
	else
	{
		$profile='default.jpg';
	}

	$insertSQLupd= $conn->prepare('insert into agent_pro (agent_id, distr_id, agent_fname, agent_lname, agent_addr, comp_name, busi_volume, state, city, land_line, mobile_no, email_id, fax_no, iata_no, bank_addr, bank_acc_no, bank_ifsc_code, agent_img, added_by, status) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,"0")');
	$insertSQLupd->execute(array($id,$_POST['distributor'],$_POST['agn_fname'],$_POST['agn_lname'],$_POST['addr'],$_POST['agn_cname'],$_POST['agn_bvolume'],$_POST['agn_state'],$_POST['hotel_city'],$_POST['agn_landline'],$_POST['agn_mobile'],$_POST['agn_email'],$_POST['agn_fax'],$_POST['agn_iatano'],$_POST['agn_bk_addr'],$_POST['agn_bk_acc'],$_POST['agn_bk_ifsc'],$profile,$_SESSION['uid']));
	
	function generate_password( $length = 6 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789*";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	$password1 = generate_password();
	
	$insertSQL_log=$conn->prepare('insert into login_secure (uid, uname, passwd, nname, gcode, status) values(?,?,?,"-","AGENT", 0 )');
	$insertSQL_log->execute(array($id,$id,md5($password1)));
				
	//Update setting ids
	$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=9');
	$insertSQLupd->execute(array($idin));

	//mail config - start
	
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>New Agent Login Details!</span><img src='../img_upload/agent_img/".$profile."' alt='' width='240' height='64' style='float:right; margin-top:-10px;'/></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$_POST['agn_fname'].' '.$_POST['agn_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br> Your Login id:".$id." <br> Your password is ".$password1." <br> Please login and update your personal details.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/><img src='../images/logo2.png'/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	$to = $_POST['agn_email'];
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
				
	//mail config -end
	$cn=$_POST['agn_fname'].' '.$_POST['agn_lname'];
		
	echo "<script>parent.document.location.href='admin_manaagent.php?mm=".$_GET['mm']."&sm=".$_GET['sm']."&rec1=".md5(3)."&name=".$cn."';</script>"; 

}

?>





<style>
.ss
{
	background-color:transparent !important ;
}
.nav-dropdown-contents{

	height: auto;

	min-width: 248px;

	max-width: 240px;
	overflow-y:auto;
	
}

.nav-dropdown-contents ul{

	padding: 0;

	margin: 0;

	list-style: none;

}

.nav-dropdown-contents ul li{

	display: block;

	border-bottom: 1px solid #F5F7FA;

}

.nav-dropdown-contents.static-list ul li,

.nav-dropdown-contents ul li a{

	padding: 20px 10px 10px 20px;

	display: block;

	position: relative;

	height: 60px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

	text-decoration: none;

	color: #656D78;

	background: #fff;

}

.nav-dropdown-contents ul li a:hover{

	color: #434A54;

}
.scroll-nav-dropdowns
{
	height:auto;
	width:240px;
}

</style>


<!-- /#InfoModalColor2 -->

	<div class="container-fluid">
    
		
				<!-- Begin page heading -->
				<h1 class="page-heading">Agent Pro <small>Manage Agents</small></h1>
				
					<div class="row">
                        <div class="col-lg-12">
                        <div class="modal fade" id="agent_settings" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" >
                    <form  name="form_agent_sett"  id="form_agent_sett"  method="post" onsubmit=" return check_numbers()" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-cogs"></i>&nbsp;Agent Settings</h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
							<div class="col-sm-12">
                                
                                   <div  >
                                   <center><strong style="color:#CCC"> Agent Default Percentage</strong></center>
                                   <br />
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<label >Agent Profit Default Percentage (%)</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                    <?php
	$sett = $conn->prepare("SELECT * FROM employee_setting where employee='Agent'");
	$sett->execute();
	$row_sett = $sett->fetch(PDO::FETCH_ASSOC);
	$tot_sett= $sett->rowCount();
									?>
                                     <input type="text" data-placeholder="percentage" value="<?php if($tot_sett>0){ echo $row_sett['percentage']; }?>" name="agt_def_perc" id="agt_def_perc" />
										</div>
									      </div>
                                        </div>
                                    </div>
                                    <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<label >Admin Markup Percentage (%)</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                    <?php
	$sett1 = $conn->prepare("SELECT * FROM employee_setting where employee='Admin_Markup_To_AGT'");
	$sett1->execute();
	$row_sett1 = $sett1->fetch(PDO::FETCH_ASSOC);
	$tot_sett1= $sett1->rowCount();
									?>
                                     <input type="text" data-placeholder="percentage" value="<?php if($tot_sett1>0){ echo $row_sett1['percentage']; } ?>" name="adm_markup_perc" id="adm_markup_perc" />
										</div>
									      </div>
                                        </div>
                                    </div>
                                   
                                </div><!-- first_div_id -->
                                
                                
                                </div>
							  </div>
                                                
											  </div>
											  <div class="modal-footer">
                                              <strong class="pull-left" style="font-size:12px; color:#F00;">Note : Please enter numeric or float values only. <br /> [ Without space, special characters, letters ] </strong>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="agent_sett" name="agent_sett" value="agent_sett_val" class="btn btn-success" >Submit</button>
											  </div>
											</div>                                </form>
										  </div>
										</div>
                        
                        
                        
                        
                        
                        <div class="modal fade" id="InfoModalColor2" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" style="width:60%">
                    <form  name="form_agent"  id="form_agent"  method="post" enctype="multipart/form-data" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;">New Agent Form</h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
							<div class="col-sm-12">
                                
                                   <div id="first_div_id" >
                                   <center><strong style="color:#CCC"> Personal Infomations</strong></center>
                                   <br />
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Agent First Name" ><i class="fa fa-tag fa-fw"  ></i></span>
										  <input type="text" name="agn_fname"  class="form-control" placeholder="First Name">
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Agent Last Name" ><i class="fa fa-tag fa-fw"  ></i></span>
										  <input type="text" name="agn_lname"  class="form-control" placeholder="Last Name">
										</div>
									      </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:10px">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Company Name" ><i class="fa fa-building-o fa-fw"  ></i></span>
										  <input type="text" name="agn_cname"  class="form-control" placeholder="Company Number">
										</div>
									   </div>
                                    
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Business Volume" ><i class="fa  fa-building fa-fw"  ></i></span>
										  <input type="text" name="agn_bvolume"  class="form-control" placeholder="Business Volume">
										</div>
									   </div>
                                        </div>
                                </div>
                                
                                    <div class="row" style="margin-top:10px">
                                    <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Land-Line Number"><i class="fa  fa-phone fa-fw"></i></span>
										 <input type="text" placeholder="Land-Line Number" class="form-control" name="agn_landline">
										</div>
                                        </div>
                                </div>
                                    
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Mobile Number" ><i class="fa  fa-mobile fa-fw"  ></i></span>
										  <input type="text" name="agn_mobile"  class="form-control" placeholder="Mobile Number">
										</div>
									   </div>
                                        </div>
                                </div>
                                
                                <div class="row" style="margin-top:10px">
                                    <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Email ID"><i class="fa fa-envelope  fa-fw"></i></span>
										 <input type="text" placeholder="Email ID" class="form-control" name="agn_email">
										</div>
                                        </div>
                                </div>
                                    <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Fax Number"><i class="fa fa-fax fa-fw"></i></span>
										 <input type="text" placeholder="Fax Number" class="form-control" name="agn_fax">
										</div>
                                        </div>
                                </div>
                                
                                </div>
                                    
                                    <div class="row" style="margin-top:10px">
                                    <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="IATA Number"><i class="fa fa-plane fa-fw"></i></span>
										 <input type="text" placeholder="IATA Number" class="form-control" name="agn_iatano">
										</div>
                                        </div>
                                </div>
                  				<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                    <?php
									$distr = $conn->prepare("SELECT * FROM distributor_pro");
									$distr->execute();
									$row_distr_main=$distr->fetchAll();
									?>
                                    
										<span class="input-group-addon tooltips" data-original-title="Distributor Name" ><i class="fa  fa-users fa-fw"  ></i></span>
										  <select data-placeholder="Choose Distributor" name="distributor" class="form-control chosen-select col-lg-12 " tabindex="2"  >									
                                         <option >Choose Distributor</option>	
										 <?php foreach($row_distr_main as $row_distr) {?>
										<option value="<?php echo $row_distr['distr_id'];?>"><?php echo $row_distr['distr_fname']."&nbsp;".$row_distr['distr_lname'];?></option>
                                        <?php } ?>
									</select>
										</div>
									   </div>
                                        </div>
                                </div>
                                
                                <div class="row" style="margin-top:10px">
                                    
                  				<div class="col-sm-12">
                                <div class="form-group">
										 <div class="input-group">
										<div class="col-sm-4">
										 <label  style="color:#CCC;">Upload Image :</label> 
                                         </div>
                                         <div class="col-sm-8">
                                         <input  type="file" placeholder="Profile Picture"  name="agn_image">
                                         </div>
										</div>
                                         
                                        </div>
                                      
                                </div>
                                
                                </div>
                                
                               
                                </div><!-- first_div_id -->
                                
                                <div id="second_div_id" style="display:none;">
                                <center><strong style="color:#CCC;">Banking Information</strong></center>
                                
                                <div class="row" style="margin-top:15px; ">
                                    <div class="col-sm-12">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Bank Information"><i class="fa fa-university fa-fw"></i></span>
										 <textarea placeholder="Bank Information or Address" class="form-control" name="agn_bk_addr" style="resize:none;"></textarea>
										</div>
                                        </div>
                                </div>
                                </div>
                                
                                <div class="row" style="margin-top:3px;">
                                    
                                <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Account Number"><i class="fa fa-tags fa-fw"></i></span>
										 <input type="text" placeholder="Account Number" class="form-control" name="agn_bk_acc">
										</div>
                                        </div>
                                </div>
                                
                                <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Bank - IFSC Code"><i class="fa fa-rocket fa-fw"></i></span>
										 <input type="text" placeholder="IFSC Code" class="form-control" name="agn_bk_ifsc">
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
									$row_hotelstate_main= $hotelstate->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="Agent State Location"><i class="fa fa-globe fa-fw"></i></span>
										 <select data-placeholder="Choose a State" name="agn_state" class="form-control chosen-select col-lg-12 " tabindex="2" onChange="find_city(this.value)"  >									
                                         <option >Choose state</option>	
										 <?php foreach($row_hotelstate_main as $row_hotelstate) {?>
										<option value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option>
                                        <?php } ?>
									</select>
										</div>
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group " id="default_city_id">
									<span class="input-group-addon tooltips" data-original-title="Agent city location"><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose A City" class="form-control chosen-select  input-lg" tabindex="2">						<option value="" disabled>Choose state - initially</option>	
										
									</select >
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
										  <textarea class="form-control no-resize" name="addr"></textarea>
										</div>
                                       
                                        </div>
                                </div>
                                
                                
                                </div>
                                </div>
                                </div>
							  </div>
                                                
											  </div>
											  <div class="modal-footer">
                                              <div class="pull-left" id="note_id">
                                               <b style="color:#930; font-size:13px">Note :</b><strong style="color:#999; font-size:12px"> Image size should be less than 40KB</strong>
                                              </div>
                                              <button type="button" id="prev_btn" class="btn btn-info pull-left" onclick="show_first_div()" style="display:none;">Previous</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="button" id="continue_btn" class="btn btn-info" onclick="hide_first_div()">Continue</button>
                                                <button type="submit" id="submit_id" name="submit_modal" value="submit_modal_val" class="btn btn-success" style="display:none;">Submit</button>
											  </div><!-- /.modal-footer -->
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->                                </form>
										  </div><!-- /.modal-dialog -->
										</div>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
            <button class="btn btn-info tooltips " id="ddd" data-direction="right" data-toggle="modal"  <?php if(isset($row_sett['percentage']) && $row_sett['percentage'] != ''){ ?>data-original-title="<?php echo "Default percentage - ".$row_sett['percentage']."&nbsp;%"; ?>" <?php  }else {?>data-original-title="Still not assign"<?php }?> data-target="#agent_settings"><i class="fa fa-cogs"></i >&nbsp; Settings </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <!--  <button class="btn btn-info tooltips " data-toggle="modal" data-original-title="For new agent" onclick="model_div_hide()" data-target="#InfoModalColor2"><i class="fa fa-plus"></i>&nbsp; Add Agent </button>-->

								</div>
                                <h3 class="panel-title"><i class="glyphicon glyphicon-user"></i>&nbsp;Agent Pro</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                <?php if($totalRows_agentpro>0){?>
                                    
                                    <div class="table-responsive" id="tabonly">
                                   <?php ?>
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th width="5%">S.No&nbsp;</th>
									<th colspan="2" width="30%"><i class="fa fa-user"></i>&nbsp;&nbsp; Agent Information</th>
                                    <th width="25%"><i class="fa fa fa-envelope fa-fw" ></i>&nbsp; Email ID </th>
                                    <th width="25%"><center><i class="fa fa-user"></i>&nbsp; Distributor</center></th>
                                    <th width="15%"><i class="fa fa-exclamation-triangle"></i>&nbsp; Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
					foreach($row_agentpro_main as $row_agentpro)
					{
						$distr = $conn->prepare("SELECT * FROM distributor_pro where distr_id =?");
						$distr->execute(array($row_agentpro['distr_id']));
						$row_distr = $distr->fetch(PDO::FETCH_ASSOC);
						$totalRows_distr = $distr->rowCount();
?>
								<tr class="even gradeA" id='tr_id<?php echo $i;?>'>
									<td >&nbsp;&nbsp;<?php echo $i;?></td>
									<td >
                                   <a class="profile_edit" href="<?php echo $_SESSION['grp']; ?>/agent_profile.php?uid=<?php echo $row_agentpro['agent_id'];?>&group=AGENT" style="background-color: #E6EDF9; color: #3D5B83; text-decoration:none"><?php echo "&nbsp;".$row_agentpro['agent_fname']." ".$row_agentpro['agent_lname']."&nbsp;";?></a>
								
                                    </td>
                                    <td>		
									 <div class="btn-group">
						 <a class="dropdown-toggle btn btn-xs btn-default tooltips"  data-original-title="Contact Number" data-toggle="dropdown"><i class="fa fa-phone" style="font-size:14px"></i> </a>
								  <ul class="dropdown-menu pull-left info with-triangle" role="menu" style="text-align:left;width: 200px;">
                                  <li><center> Contact Number</center></li>
									<li class="divider" style="border:1px solid #434A54"></li>
                                    <li>
                                    <center>
                                    <strong>
                                    <?php if(trim($row_agentpro['mobile_no'])!=''){?>
                        <i class="fa fa-mobile "></i>&nbsp;&nbsp;<?php echo $row_agentpro['mobile_no']."<br>"; 
									}
									if(trim($row_agentpro['land_line'])!=''){
						?>
                        <i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $row_agentpro['land_line']."<br>";
						}
						 ?>
                                    </strong>
                                    </center>
                                    </li>
								  </ul>
                                    </div>
                                     </td>
                                    <td style="word-wrap:break-word">
                                   <?php
								   if(trim($row_agentpro['email_id']) != '')
								   { 
								   	echo "&nbsp;&nbsp;".$row_agentpro['email_id'];
                                   }else{
                                    echo "No Email ID";
                                   }?> </td>
									
                                    <td >
                                     <?php if(trim($row_distr['distr_id']) != ''){?>
                                   <div class="btn-group">
						 <a class="dropdown-toggle btn btn-xs btn-default tooltips"  data-original-title="<?php echo $row_distr['distr_fname']."&nbsp;-&nbsp;Details"; ?>" data-toggle="dropdown"><strong style="font-size:14px"> <?php echo $row_distr['distr_fname']; ?> </strong></a>
								  <ul class="dropdown-menu pull-right info with-triangle" role="menu" style="text-align:left;width: 300px;">
                                  <li><center> Distributor Infomation</center></li>
									<li class="divider" style="border:1px solid #434A54"></li>
                                    <li>
                                    <div style="width:100%">
                                    <div class="pull-left" style="width:30%">
                                    <?php if($row_distr['distr_img'] != 'default.php') {?>
                                    <img src="<?php echo $_SESSION['grp']; ?>/img_upload/distributor_img/<?php echo $row_distr['distr_img']; ?>" width="70px" height="70px" alt="<?php echo $row_distr['distr_fname']."&nbsp;Image";?>" />
                                    <?php }else{?>
                                    <img src="<?php echo $_SESSION['grp']; ?>/img_upload/distributor_img/default.jpg" width="70px" height="70px"  />
                                    <?php }?>
                                    </div>
                                     <div class="pull-left" style="width:70%">
                                      <i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo $row_distr['distr_fname']."<br>"; ?>
                                    <i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $row_distr['mobile_no']."<br>"; ?>
                                     <i class="fa fa-envelope "></i>&nbsp;&nbsp;<?php echo $row_distr['email_id']; ?>
                                    </div>
                                    </div>
                                    </li>
								  </ul>
                                    </div>
                                    <?php }else{ ?>
                                   <a class="btn btn-xs btn-default" data-toggle="dropdown"> No Distributor </a>
                                    <?php } ?>
                                    </td>
                                    <td >
                                  <div class="btn-group">
								  <button class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class=" pull-right dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
								<li>
                                    <a class="add_agent" title="View Order list of - <?php echo $row_agentpro['agent_fname'];?> " href="<?php echo $_SESSION['grp']; ?>/view_orders.php?aid=<?php echo $row_agentpro['agent_id'];?>"><i class="fa fa-file-text-o"></i>&nbsp; View Orders </a></li>
                                    <li class="divider" ></li>	
                                    <li><a class="change_pass1" href="<?php echo $_SESSION['grp']; ?>/agent_profile.php?uid=<?php echo $row_agentpro['agent_id'];?>&group=password"><i class="fa fa-edit"></i>&nbsp; Change Password</a></li>
                                    <li>
                                    <a class="add_agent" title="Update - <?php echo $row_agentpro['agent_fname'];?> " href="ADMIN/add_agent.php?aid=<?php echo $row_agentpro['agent_id'];?>&ty=<?php echo md5(2);?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-wrench"></i>&nbsp; Update </a></li>
                                  <li><a href="javascript:void(0);" onclick="remove_me('<?php echo $i; ?>','<?php echo $row_agentpro['agent_id']; ?>','<?php echo $row_agentpro['agent_img']; ?>','<?php echo $row_agentpro['agent_fname']; ?>')"><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
								  </ul>
                                  
                                    </div>
                                    </td>
								</tr>
					<?php $i++; } ?>
                                </tbody>
                                </table>
                                </div>
                                <div class="" id="tabon2">
                                </div>
								<?php }else{?>  
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable">
                                   <center><p style="color:#CCC; font-weight:600; font-size:16px"> Agent Entries are Unavailable</p></center>
                                  
                                    </div>
                                    <?php }?>
                                </div>
                                </div>
                            </div>
                        </div><!-- /.col-sm-8 -->
					</div><!-- /.row -->
				</div>
              
<script>

$(document).ready(function(e) {
   	$('.tooltips').tooltip({});
	$('.chosen-select').chosen({width : '100%'});
	
});


function remove_me(no,sno,img,name)
{
	//alert('f');
	var type=12;
 $.get("<?php echo $_SESSION['grp'];?>/ajax_hotel.php?sno="+sno+"&pic="+img+"&type="+type,function(result)
 {
	 //alert(result);
	 $('#tr_id'+no).hide();
	 
      toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          }
      toastr.error(name+' removed successfully..!');
           
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
 $('#first_div_id').hide();
 $('#note_id').hide();
 $('#second_div_id').show();
 $('#prev_btn').show();	
 $('#submit_id').show();
 $('#continue_btn').hide();	
}

function show_first_div()
{
	$('#second_div_id').hide();
	$('#submit_id').hide();
	$('#prev_btn').hide();	
	$('#first_div_id').show();
 	$('#continue_btn').show();		
}

function find_city(state_id)
{
	var type=1;
	$.get("<?php echo $_SESSION['grp']; ?>/ajax_hotel.php?sid="+state_id+"&type="+type,function(result)
	{
		$('#default_city_id').empty().html(result);
							$('.chosen-select').chosen({'width':'100%'});
							$('.tooltips').tooltip({});
		
	});
}

function check_numbers()
{
	var numbers =  /^-?\d*(\.\d+)?$/; 
	var adp=$('#agt_def_perc').val().trim();
	var amp=$('#adm_markup_perc').val().trim();
	//alert(adp+' '+amp);
	if(adp!='' && amp!='')
	{
		if(numbers.test(adp) && numbers.test(amp))
		{
			return true;
		}else{
			alert('Please give some value [numbers only - without characters]');	
			return false;
		}
	}else{
		alert('Please give some value [numbers only]');	
		return false;
	}
	
	
	
	
}
</script>