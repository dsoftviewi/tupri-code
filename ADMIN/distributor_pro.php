<?php
include("COMMN/smsfunc.php");

$distrpro = $conn->prepare("SELECT * FROM distributor_pro where status='0'  ORDER BY sno DESC");
$distrpro->execute();
$row_distripro_main = $distrpro->fetchAll();
$totalRows_distrpro =$distrpro->rowCount();

$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$mon=$date->format('F');
$dd=$date->format('m/d/Y');

//agent settings
if(isset($_POST['distr_sett']) && $_POST['distr_sett']=='distr_sett_val')
{
	
	$sett = $conn->prepare("SELECT * FROM employee_setting where employee='Distr'");
	$sett->execute();
	$row_sett = $sett->fetch(PDO::FETCH_ASSOC);
	$tot_sett=$sett->rowCount();
	
	if($tot_sett>0)
	{
		
		$deletesett=$conn->prepare("delete from employee_setting where employee = 'Distr'");
		$deletesett->execute();
		
		$insertsett=$conn->prepare("insert into employee_setting(employee,percentage)values('Distr',?)");
		$insertsett->execute(array($_POST['distr_def_perc']));
		
		$updatesett=$conn->prepare("update distributor_pro set my_percentage=?");
		$updatesett->execute(array($_POST['distr_def_perc']));
	}else{
		
		
		$insertsett=$conn->prepare("insert into employee_setting(employee,percentage)values('Distr',?)");
		$insertsett->execute(array($_POST['distr_def_perc']));
		
		$updatesett=$conn->prepare("update distributor_pro set my_percentage=?");
		$updatesett->execute(array($_POST['distr_def_perc']));
	}
}




if(isset($_POST['submit_modal']) && $_POST['submit_modal']=='submit_modal_val')
{
	
	$vehid = $conn->prepare("SELECT * FROM setting_ids  where sno =10");
	$vehid->execute();
	$row_vehid = $vehid->fetch(PDO::FETCH_ASSOC);
	$id=$row_vehid['id_name'].$row_vehid['id_number'];
	$idin=$row_vehid['id_number']+1;
		
	if(trim($_FILES["agn_image"]["name"]) != '')
	{
		$file=$_FILES["agn_image"]["name"];
		$FileType = pathinfo($file,PATHINFO_EXTENSION);
		$profile=$id.'.'.$FileType;
		$target_file=$_SESSION['grp'].'/img_upload/distributor_img/'.$profile;
		move_uploaded_file($_FILES["agn_image"]["tmp_name"], $target_file);
	}
	else
	{
		$profile='default.jpg';
	}

	$insertSQLupd=$conn->prepare('insert into distributor_pro (distr_id, distr_fname, distr_lname, distr_addr, comp_name, busi_volume, state, city, land_line, mobile_no, email_id, fax_no, iata_no, bank_addr, bank_acc_no, bank_ifsc_code, distr_img, added_by, status) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, "0" )');
	$insertSQLupd ->execute(array($id,$_POST['agn_fname'],$_POST['agn_lname'],$_POST['addr'],$_POST['agn_cname'],$_POST['agn_bvolume'],$_POST['agn_state'],$_POST['hotel_city'],$_POST['agn_landline'],$_POST['agn_mobile'],$_POST['agn_email'],$_POST['agn_fax'],$_POST['agn_iatano'],$_POST['agn_bk_addr'],$_POST['agn_bk_acc'],$_POST['agn_bk_ifsc'],$profile,$_SESSION['uid']));
	
	function generate_password( $length = 6 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789*";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	$password1 = generate_password();
	
	$insertSQL_log=$conn->prepare('insert into login_secure (uid, uname, passwd, nname, gcode, status) values(?,?,?, "-", "DISTRB", 0 )');
	$insertSQL_log->execute(array($id,$id,$md5($password1)));
		
				 //Update setting ids
	$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=10');
	$insertSQLupd->execute(array($idin));
				
	//mail config - start
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>New Distributor Login Details!</span><img src='../img_upload/agent_img/".$profile."' alt='' width='240' height='64' style='float:right; margin-top:-10px;'/></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$_POST['agn_fname'].' '.$_POST['agn_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br> Your Login id:".$id." <br> Your password is ".$password1." <br> Please login and update your personal details.</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/><img src='../images/logo2.png'/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	$to = $_POST['agn_email'];
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
				
				
	//mail config -end
	$cn=$_POST['agn_fname'].' '.$_POST['agn_lname'];
		
	echo "<script>parent.document.location.href='admin_manadistrb.php?mm=".$_GET['mm']."&sm=".$_GET['sm']."&rec1=".md5(3)."&name=".$cn."';</script>"; 

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
	<div class="container-fluid">
				
				<!-- Begin page heading -->
				<h1 class="page-heading">Distributor Pro <small>Manage Distributor</small></h1>
				
					<div class="row">
                        <div class="col-lg-12">
                        
                        <div class="modal fade" id="distr_settings" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" >
                    <form  name="form_distr_sett"  id="form_distr_sett"  method="post" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-cogs"></i>&nbsp;Distributor Settings</h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
							<div class="col-sm-12">
                                
                                   <div  >
                                   <center><strong style="color:#CCC"> Distributor - Default Percentage</strong></center>
                                   <br />
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<label >Distributor - Default Percentage</label>
										  
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                    <?php
									
	$sett = $conn->prepare("SELECT * FROM employee_setting where employee='Distr'");
	$sett->execute();
	$row_sett = $sett->fetch(PDO::FETCH_ASSOC);
	$tot_sett=$sett->rowCount();
									?>
                                    <input type="text" value="<?php echo $row_sett['percentage']; ?>" name="distr_def_perc" id="distr_def_perc" />
										<!--  <select name="distr_def_perc" class="form-control chosen-select">
                                          <?php//for($r=1;$r<=100;$r++){if($row_sett['percentage']== $r){?>
											  <option selected="selected" value="<?php// echo $r; ?>"><?php// echo $r; ?>&nbsp;%</option>
										  <?php// }else{?>
											   <option  value="<?php// echo $r; ?>"><?php// echo $r; ?>&nbsp;%</option>
										  <?php// }}
										  ?>
                                          </select>-->
										</div>
									      </div>
                                        </div>
                                    </div>
                                   
                                </div><!-- first_div_id -->
                                
                                
                                </div>
							  </div>
                                                
											  </div>
											  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="distr_sett" name="distr_sett" value="distr_sett_val" class="btn btn-success" >Submit</button>
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
												<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;">New Distributor - Form</h5>
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
										<span class="input-group-addon tooltips" data-original-title="Distributor First Name" ><i class="fa fa-tag fa-fw"  ></i></span>
										  <input type="text" name="agn_fname"  class="form-control" placeholder="First Name">
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Distributor Last Name" ><i class="fa fa-tag fa-fw"  ></i></span>
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
									$row_hotelstate_main=$hotelstate->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="Distributor State "><i class="fa fa-globe fa-fw"></i></span>
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
									<span class="input-group-addon tooltips" data-original-title="Distributor City "><i class="fa fa-map-marker fa-fw"></i></span>
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
                                
                                  <?php /*?><button class="btn btn-info tooltips " <?php if(isset($row_sett['percentage']) && $row_sett['percentage'] != ''){ ?>data-original-title="<?php echo "Default percentage - ".$row_sett['percentage']."&nbsp;%"; ?>" <?php  }else {?>data-original-title="Still not assign"<?php }?> data-toggle="modal" data-target="#distr_settings"><i class="fa fa-cogs"></i >&nbsp; Settings </button><?php */?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<button class="btn btn-info tooltips" data-toggle="modal" onclick="model_div_hide()" data-original-title="For new distributor" data-target="#InfoModalColor2"><i class="fa fa-plus"></i>&nbsp; Add Distributor </button>-->
								</div>
                                <h3 class="panel-title"><i class=" glyphicon glyphicon-user"></i>&nbsp;Distributor Pro</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                <?php if($totalRows_distrpro>0){?>
                                    
                                    <div class="table-responsive" id="tabonly">
                                  <table class="table table-striped table-hover datatable-example" width="100%">
							<thead class="the-box dark full">
								<tr>
									<th width="5%">S.No&nbsp;</th>
									<th width="25%" colspan="2" ><i class="fa fa-user"></i>&nbsp;&nbsp; Distributor </th>
									<!--<th><i class="fa fa-user"></i>&nbsp; Name </th>
                                    <th width="15%"><i class="fa fa fa-envelope fa-fw" ></i>&nbsp;  </th>--> 
                                    <th width="20%"><center><i  class="fa fa-briefcase "></i>&nbsp; Email ID</center> </th>
                                    <th width="15%"><center><i class="fa fa-user"></i>&nbsp; Agent(s)</center></th>
                                    <th width="13%"><center><i class="fa fa-star"></i>&nbsp; Spr.Distr</center></th>
                                    <th width="12%"><i class="fa fa-exclamation-triangle"></i>&nbsp; Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
					foreach($row_distripro_main as $row_distripro)
					{
?>								<tr class="even gradeA" id='tr_id<?php echo $i;?>'>
									<td>&nbsp;&nbsp;<?php echo $i;?></td>
									<td>
                                    <a class="profile_edit" href="<?php echo $_SESSION['grp']; ?>/distrib_profile.php?uid=<?php echo $row_distripro['distr_id'];?>&amp;group=DISTRB" style="background-color: #E6EDF9; color: #3D5B83; text-decoration:none;"><?php echo "&nbsp;".$row_distripro['distr_fname']." ".$row_distripro['distr_lname']."&nbsp;";?></a>
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
                                    	 <?php if(trim($row_distripro['mobile_no'])!=''){?>
                        <i class="fa fa-mobile "></i>&nbsp;&nbsp;<?php echo $row_distripro['mobile_no']."<br>"; 
									}
									if(trim($row_distripro['land_line'])!=''){
						?>
                        <i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $row_distripro['land_line']."<br>";
						}
						 ?>
                                    </strong>
                                    </center>
                                    </li>
								  </ul>
                                    </div>
									
                                     </td>
                                    <td style="word-wrap:break-word" width="15%">
                                    <?php 
									if(trim($row_distripro['email_id']) != '')
									{
									echo "&nbsp;&nbsp;".$row_distripro['email_id'];
									}else{
										echo "No Email ID";
									}?>
                                    
                                     </td>
                                     
							
                                    <td>
                                    <center>
                                     <?php 
										
	$agnte = $conn->prepare("SELECT * FROM agent_pro where  distr_id=?");
	$agnte->execute(array($row_distripro['distr_id']));
	$row_agnte = $agnte->fetch(PDO::FETCH_ASSOC);
	$tot_agnte=$agnte->rowCount();
	if($tot_agnte>0){
									?>
                                    <a class=" show_agent btn btn-sm btn-default" href="ADMIN/show_under_agents.php?did=<?php echo $row_distripro['distr_id']; ?>"><?php echo $tot_agnte; ?>&nbsp;Agent(s)</a>
                                    <?php }else{ ?>
                                    <a class="btn btn-sm btn-default" href="javascript:void(0);">No Agent</a>
                                    <?php }?>
                                    </center>
                                    </td>
                                    <td>
                                    <center>
                                    <span title="Double click to update distributor type" id="is_sup<?php echo $i; ?>" class=" <?php if($row_distripro['is_super'] == 0) { ?> label label-warning tooltips <?php } else { ?> label label-primary tooltips<?php } ?>" ondblclick="upd_super(<?php echo $i; ?>);"><?php if($row_distripro['is_super'] == 0) { echo 'NO'; } else { echo 'YES'; } ?></span>
                                    <div class="form-group" id="upd_sup<?php echo $i; ?>" style="display:none">
									<select class="form-control" tabindex="2" onchange="upd_dist(<?php echo $i; ?>, '<?php echo $row_distripro['distr_id'];  ?>', this.value)">
                                        <option value="1">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
									</select> <br /><br />
                                    <button class="btn btn-danger btn-xs" onclick="can_upd(<?php echo $i; ?>);">Cancel</button>
								</div>
									</center>
                                    </td>
                                   <td width="10%">
                                  <div class="btn-group">
								  <button class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class=" pull-right dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
									<li><a class="change_pass1" href="<?php echo $_SESSION['grp']; ?>/distrib_profile.php?uid=<?php echo $row_distripro['distr_id'];?>&group=password"><i class="fa fa-edit"></i>&nbsp; Change Password</a></li>
                                    <li>
                                    <a class="add_agent" title="Update - <?php echo $row_distripro['distr_fname'];?> " href="<?php echo $_SESSION['grp']; ?>/add_distributor.php?did=<?php echo $row_distripro['distr_id'];?>&ty=<?php echo md5(2);?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-wrench"></i>&nbsp; Update </a></li>
                                  <li><a href="javascript:void(0);" onclick="remove_me('<?php echo $i; ?>','<?php echo $row_distripro['distr_id']; ?>','<?php echo $row_distripro['distr_img']; ?>','<?php echo $row_distripro['distr_fname']; ?>')"><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
								  </ul>
                                  
                                    </div>
                                    </td>
								</tr>
                               <?php $i++;
							}?>
                                </tbody>
                                </table>
                                </div>
                                <div class="" id="tabon2">
                                </div>
                                  <?php }else{?>  
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable">
                                   <center><p style="color:#CCC; font-weight:600; font-size:16px"> Distributor Entries are Unavailable</p></center>
                                  
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
	var type=13;
 $.get("ADMIN/ajax_hotel.php?sno="+sno+"&pic="+img+"&type="+type,function(result)
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

function upd_super(cnt)
{
	$('#upd_sup'+cnt).show();
	$('#is_sup'+cnt).hide();
}

function can_upd(cnt)
{
	$('#upd_sup'+cnt).hide();
	$('#is_sup'+cnt).show();
}

function upd_dist(cnt, did, dval)
{
	$.get('<?php echo $_SESSION['grp'].'/upd_ajax.php' ?>', { did : did, sup_val : dval, typ : 1 }, function(data) 
	{
		parent.location.reload();
	});
}
</script>