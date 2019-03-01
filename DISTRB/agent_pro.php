<?php
include("COMMN/smsfunc.php");

$agentpro = $conn->prepare("SELECT * FROM agent_pro where distr_id =? and status='0' ORDER BY sno DESC");
$agentpro->execute(array($_SESSION['uid']));
$row_agentpro_main = $agentpro->fetchAll();
$totalRows_agentpro = $agentpro->rowCount();

$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$mon=$date->format('F');
$dd=$date->format('m/d/Y');

if(isset($_POST['submit_modal']) && $_POST['submit_modal']=='submit_modal_val')
{
	
	$ref= $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
	$ref->execute(array($_SESSION['uid']));
	$row_ref = $ref->fetch(PDO::FETCH_ASSOC);
	
	
	$perc_sett = $conn->prepare("SELECT * FROM employee_setting ");
	$perc_sett->execute();
	//$row_perc_sett = mysql_fetch_assoc($perc_sett);
	$row_perc_sett_main=$perc_sett->fetchAll();
	$tot_perc_sett= $perc_sett->rowCount();
	
	foreach($row_perc_sett_main as $row_perc_sett)
	{
		if($row_perc_sett['employee']=='Agent')
		{
			$agent_def_perc=$row_perc_sett['percentage'];
		}else if($row_perc_sett['employee']=='Admin_Markup_To_AGT')
		{
			$admin_prof_perc=$row_perc_sett['percentage'];
		}
	}
	
	
	$vehid = $conn->prepare("SELECT * FROM setting_ids  where sno =9");
	$vehid->execute();
	$row_vehid = $vehid->fetch(PDO::FETCH_ASSOC);
	$id=$row_vehid['id_name'].$row_vehid['id_number'];
	$idin=$row_vehid['id_number']+1;

		$profile='default.jpg';
	
	$ref_name=$row_ref['distr_fname'].' '.$row_ref['distr_lname'];
	 $insertSQLupd=$conn->prepare('insert into agent_pro (agent_id, distr_id, agent_fname, agent_lname, agent_addr, comp_name, state, city, land_line, mobile_no, email_id, agent_img, refered_id, refered_name, my_percentage, brokerage_perc, ip_addr, status) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,"1" )');
	 $insertSQLupd->execute(array($id,$_SESSION['uid'],$_POST['agn_fname'],$_POST['agn_lname'],$_POST['addr'],$_POST['agn_cname'],$_POST['agn_state'],$_POST['hotel_city'],$_POST['agn_landline'],$_POST['agn_mobile'],$_POST['agn_email'],$profile,$row_ref['distr_id'],$ref_name,$agent_def_perc,$admin_prof_perc,$_SERVER['REMOTE_ADDR']));
	
	//Update setting ids
	$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=9');
	$insertSQLupd->execute(array($idin));

	//mail config - start
	
	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration Details</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>New Agent Login Details!</span><img src='../img_upload/agent_img/".$profile."' alt='' width='240' height='64' style='float:right; margin-top:-10px;'/></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>".$_POST['agn_fname'].' '.$_POST['agn_lname']."</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> Do View Holidays welcomes you to our family! You are now registered with us and can login to our system with below credentials... </span><br> Your Login id and password will send to your registered mail id </p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/><img src='images/logo2.png'/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	$to = $_POST['agn_email'];
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD. <vsr@v-i.in>"; 
	$subject="Welcome Message from DVI_Holidays.com";
	$str=send_mail($to,$from,$subject,$stringData);
				
				
				//to admin
		$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>New Agent Registration Details</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>    <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>New Agent Registered with us ! </span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear Administrator,<span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'></span></span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'> New Agent - referred by your distributor ( ".$ref_name." ) <br> New Agent Name : ".$_POST['agn_fname'].' '.$_POST['agn_lname']." <br>New Agent Email ID : ".$_POST['agn_email']." </span><br> </p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/><img src='images/logo2.png'/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: '#CC6600;'>For more details, please login from administrator-end..</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;	color: #000000;'>Questions? Go to the Help Centre at: </span><a href='http://dvi.co.in' style='font-family: Arial, Helvetica, sans-serif;	font-size: 11px;	font-weight: normal;  color: #000000;'>DoView Holidays</a><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; ".$yy." DoView Holidays (India) Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	$to = 'vsr@v-i.in';
	$from = "DO VIEW HOLIDAYS INDIA PVT. LTD."; 
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
                        <div class="modal fade" id="InfoModalColor2" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" style="width:60%">
                    <form  name="form_agent"  id="form_agent"  method="post" enctype="multipart/form-data" onSubmit="return validate_final()" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;">New Agent Form</h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
							<div class="col-sm-12">
                                
                                   <div id="first_div_id" >
                                   <center><strong style="color:#CCC"> Registration Form</strong></center>
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
										<span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Land-Line Number"><i class="fa  fa-phone fa-fw"></i></span>
										 <input type="text" placeholder="Land-Line Number" class="form-control" name="agn_landline" id="agn_landline">
										</div>
                                        </div>
                                </div>
                                    
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Mobile Number" ><i class="fa  fa-mobile fa-fw"  ></i></span>
										  <input type="text" name="agn_mobile" id="agn_mobile" class="form-control" placeholder="Mobile Number">
										</div>
									   </div>
                                        </div>
                                </div>
                                
                                <div class="row" style="margin-top:5px">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group ">
                                    <?php 
									
									$hotelstate = $conn->prepare("SELECT * FROM dvi_states");
									$hotelstate->execute();
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelstate_main=$hotelstate->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Living State"><i class="fa fa-globe fa-fw"></i></span>
										 <select data-placeholder="Choose a State" name="agn_state" id="agn_state" class="form-control chosen-select col-lg-12 " tabindex="2" onChange="find_city(this.value)"   >									
                                         <option value='nil'>Choose a State</option>	
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
									<span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="City Name"><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose A City" class="form-control chosen-select col-lg-12 " tabindex="2">						<option value="" disabled>Choose state - initially</option>	
										
									</select >
										</div>
                                        </div>
                                        </div>
                                </div>
                                    
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
                                </div><!-- first_div_id -->
                                
                                </div>
							  </div>
                                                
											  </div>
											  <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="submit_id" name="submit_modal" value="submit_modal_val" class="btn btn-success pull-right" ><i class="fa fa-thumbs-o-up"></i>&nbsp;Submit</button>
											  </div><!-- /.modal-footer -->
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->                                </form>
										  </div><!-- /.modal-dialog -->
										</div>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
            
                                <button class="btn btn-info btn-block" data-toggle="modal" data-target="#InfoModalColor2"><i class="fa fa-plus"></i>&nbsp; Add Agent </button>

                                
                                  <!--  <a class="add_agent btn btn-info btn-sm " href="<?php //echo $_SESSION['grp'];?>/add_agent.php?mm=<?php //echo $_GET['mm'];?>&ty=<?php //echo md5(1);?>&sm=<?php //echo $_GET['sm'];?>"><i class="fa fa-plus"></i>&nbsp; Add Agent </a>-->
								</div>
                                <h3 class="panel-title"><i class="glyphicon glyphicon-user"></i>&nbsp;Agent Pro</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                <?php if($totalRows_agentpro>0){?>
                                    
                                    <div class="table-responsive" id="tabonly">
                                  
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th width="5%">S.No&nbsp;</th>
									<th colspan="2" width="30%"><i class="fa fa-user"></i>&nbsp;&nbsp; Agent Information</th>
                                    <th width="25%"><i class="fa fa fa-envelope fa-fw" ></i>&nbsp; Email ID </th>
                                    <th width="25%"><center><i class="fa fa-user"></i>&nbsp; Orders</center></th>
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
                                   <a class="profile_edit" href="<?php echo $_SESSION['grp']; ?>/agent_profile.php?uid=<?php echo $row_agentpro['agent_id'];?>&group=AGENT" style="background-color: #E6EDF9; color: #3D5B83; text-decoration:none"><strong><?php echo "&nbsp;".$row_agentpro['agent_fname']." ".$row_agentpro['agent_lname']."&nbsp;";?></strong></a>
								
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
                                    <strong>
                                   <?php
								   if(trim($row_agentpro['email_id']) != '')
								   { 
								   	echo "&nbsp;&nbsp;".$row_agentpro['email_id'];
                                   }else{
                                    echo "No Email ID";
                                   }?></strong> </td>
									
                                    <td>
                                   <center> <a class="btn btn-sm btn-info add_agent" title="View Order list of - <?php echo $row_agentpro['agent_fname'];?> " href="<?php echo $_SESSION['grp']; ?>/view_orders.php?aid=<?php echo $row_agentpro['agent_id'];?>"><i class="fa fa-file-text-o"></i>&nbsp; View Orders </a></center>
                                    </td>
                                    <td >
                                  <div class="btn-group">
								  <button class="dropdown-toggle btn btn-sm btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class=" pull-right dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
                                    <li>
                                    <a class="add_agent" title="Update - <?php echo $row_agentpro['agent_fname'];?> " href="ADMIN/add_agent.php?aid=<?php echo $row_agentpro['agent_id'];?>&ty=<?php echo md5(2);?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-wrench"></i>&nbsp; Update </a></li>
                                    <li class="divider" ></li>
                                  <li><a href="javascript:void(0);" onclick="remove_me('<?php echo $i; ?>','<?php echo $row_agentpro['sno']; ?>','<?php echo $row_agentpro['agent_img']; ?>','<?php echo $row_agentpro['agent_fname']; ?>')"><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
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
	var txt;
    var r = confirm("Confirm ?");
    if (r == true) {
        var type=4;
		 $.get("<?php echo $_SESSION['grp']; ?>/ajax_log.php?sno="+sno+"&pic="+img+"&type="+type,function(result)
		 {
			 alert(result);
			 $('#tr_id'+no).hide();
			  toastr.options={   
				  "closeButton":true,
				  "positionClass":"toast-top-right",
				  "showMethod": "fadeIn",
				   "hideMethod": "fadeOut"
				  }
			  toastr.error(name+' removed successfully..!');
				   
		 });
    } else {
        txt = "You pressed Cancel!";
    }
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
	var type=15;
	$.get("ADMIN/ajax_hotel.php?sid="+state_id+"&type="+type,function(result)
	{
		$('#default_city_id').empty().html(result);
							$('.chosen-select').chosen({'width':'100%'});
							$('.tooltips').tooltip({});
		
	});
}


var check='';
function validate_final()
{
	var ty=3;
	var email_check='';
	var ag_nme=document.getElementById('agn_fname').value;
	var agn_email=document.getElementById('agn_email').value;
	var agmobile=document.getElementById('agn_mobile').value.trim();
	var agnlandline=document.getElementById('agn_landline').value.trim();
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,10}|[0-9]{1,3})(\]?)$/;
 	var numbers =  /^\d+$/; 
	var strin = /^[a-zA-Z ]{4,30}$/;
	var lstrin = /^[a-zA-Z. ]{1,30}$/;

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
	}else if(document.getElementById('agn_landline').value.trim()=='' && document.getElementById('agn_mobile').value.trim()=='')
	{
		alert('Please Enter Your Contact Number');
		document.getElementById('agn_landline').focus();
		check=0;
		//return false;
	}else if(document.getElementById('agn_landline').value.trim()!='' && (!numbers.test(agnlandline) || agnlandline.length<10) )
	{
		alert('Please Enter Valid Landline Number (* avoid space and characters) ');
		document.getElementById('agn_landline').focus();
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
	}else if(document.getElementById('agn_state').value.trim()=='nil')
	{
		alert('Please choose your state');
		document.getElementById('agn_state').focus();
		check=0;
		//return false;
	}
	else if(document.getElementById('hotel_city').value.trim()=='')
	{
		alert('Please choose your city');
		document.getElementById('hotel_city').focus();
		check=0;
		//return false;
	}
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
	}else{
		
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
			var strURL="<?php echo $_SESSION['grp']; ?>/ajax_log.php?email="+agn_email+"&type="+ty;
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
				return true;	
			}
	
}
</script>