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
$today_dat=$date->format('d-M-Y h:i:s a');
?>

<?php
//for approval from admin to agent
if(isset($_GET['type']) && $_GET['type']==1)
{ 	
	$pid=$_GET['pid1']."#".$_GET['pid2'];
	
 //breakup start 

$breakup = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$breakup->execute(array($pid));
$row_breakup = $breakup->fetch(PDO::FETCH_ASSOC);
$totalRows_breakup = $breakup->rowCount();

$break_arr=array();
//echo "Breakup =".$row_breakup['sub_paln_id'];
if(trim($row_breakup['sub_paln_id'])!='')//not empty
{
	$row_breakup['sub_paln_id'];
	$break_arr=explode('-',$row_breakup['sub_paln_id']);
}
//print_r($break_arr);
//breakup end 

	?>
	
	<div class="modal-dialog">
											<div class="modal-content modal-no-shadow modal-no-border">
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> 
                                <i class="fa fa-cogs"></i>&nbsp;Download Vouchers  [ <?php echo $pid ." - ".$_GET['trname']; ?> ]</h5>
											  </div>
											  <div class="modal-body" >
                                                <div class="row" style="margin-top:10px;">
                                                	<div class="col-sm-12" >
                                                    	<div class="col-sm-4"  style="color:#FB2323; font-weight:600;">
                                                        Hotel Name
                                                        </div>
                                                    	<div class="col-sm-5" style="color:#FB2323; font-weight:600;" align="center">
                                                        Date Of Stay 
                                                        </div>
                                                        <div class="col-sm-3" style="color:#FB2323; font-weight:600;">
                                                        Download
                                                        </div>
                                                    </div>
                                                   <?php
//main break stay for
$break_chk=0;
//print_r($break_arr);
foreach($break_arr as $breakup)
{
    
	$sspro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
	$sspro1->execute(array($breakup));
	//$row_sspro1 = mysql_fetch_assoc($sspro1);
	//$row_sspro1_main = $sspro1->fetchAll();
	$totalRows_sspro1 = $sspro1->rowCount();                                           
		if($totalRows_sspro1>0)
		{
			if($break_chk==0)
				{
					$main_plan_id=$breakup;
					$custom=$row_breakup['tr_name'];
					$break_chk++;
				}
			$first_day=0;
			$last_day=1;
				while($row_sspro1 = $sspro1->fetch(PDO::FETCH_ASSOC))
				{
					   $old_date= date('d-M-Y',strtotime($row_sspro1['sty_date']));
			   		   $old_date11=$row_sspro1['sty_date'];
			  					 //my edit
								$flg=true;
								$nxt_chout=1;
								$ssno=($row_sspro1['sno']+1);
						while($flg)
						{
							
							$sy_ntx1= $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=? and sno=?");
							//print "$pid,".$row_sspro1['hotel_id'].",$ssno";
							$sy_ntx1->execute(array($pid,$row_sspro1['hotel_id'],$ssno));
							$row_sy_ntx1 = $sy_ntx1->fetch(PDO::FETCH_ASSOC);
							$totalRows_sy_ntx1 = $sy_ntx1->rowCount();
							if($totalRows_sy_ntx1>0)
							{
									$nxt_chout++;	
									$ssno++;
							}else{
								$flg=false;
							}
						}

						$date=date_create($row_sspro1['sty_date']);
						$nxt_chout=$nxt_chout;
						date_add($date,date_interval_create_from_date_string($nxt_chout." days"));
						$next_datt=date_format($date,"d-M-Y");	
					    $next_datt11=date_format($date,"Y-m-d");	   
												   ?>
                                                   <div class="col-sm-12" style="margin-top:10px; border-bottom:1px solid #E2E2E2" >
                                                    	<div class="col-sm-4">
                                                        <?php
														  
$hotell = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotell->execute(array($row_sspro1['hotel_id']));
$row_hotell = $hotell->fetch(PDO::FETCH_ASSOC);
$totalRows_hotell = $hotell->rowCount();
														 echo $row_hotell['hotel_name']; ?>
                                                        </div>
                                                    	<div class="col-sm-5" align="center">
                                                        <?php echo $old_date .' <i class="fa fa-arrows-h"></i> '.$next_datt; ?>
                                                        </div>
                                                        <div class="col-sm-3">
           <a target="_blank" class="btn btn-sm btn-info" href="ADMIN/voucher_download.php?planid=<?php echo urlencode($breakup); ?>&fdate=<?php echo $old_date11; ?>&tdate=<?php echo $next_datt11; ?>&customers=<?php echo $custom; ?>"><i class="fa  fa-hand-o-right"></i>&nbsp;Download</a>
                                                        
                                                        </div>
                                                    </div>
                                                   
                                                   <?php
												  $nxt_chout=$nxt_chout+1;
												   //print $nxt_chout;
												   for($rt=1;$rt<$nxt_chout;$rt++)
														{
														$row_sspro1 = $sspro1->fetch(PDO::FETCH_ASSOC);
														}
														$nxt_chout=1;
				}//while end
		}
	}//main for loop
												   ?> 
                                                   
                                                   <div class="col-sm-12" align="center" style="margin-top:20px;">
       <a target="_blank" class="btn btn-sm btn-info" href="ADMIN/voucher_download.php?planid=<?php echo urlencode($main_plan_id); ?>&customers=<?php echo $custom; ?>"><i class="fa  fa-hand-o-right"></i>&nbsp;Download All Vouchers</a>
       <a target="_blank" class="btn btn-sm btn-info tooltips " href="<?php echo $_SESSION['grp']; ?>/feed_back_download.php?planid=<?php echo urlencode($main_plan_id); ?>&customers=<?php echo $custom; ?>" data-toggle="tooltip" data-original-title="Click to download feedback form"><i class="fa fa-comment"></i></a>
<a target="_blank" class="btn btn-sm btn-info" href="<?php echo $_SESSION['grp']; ?>/itin_wel_board_pdf.php?planid=<?php echo urlencode($main_plan_id); ?>&customers=<?php echo $custom; ?>"><i class="fa  fa-hand-o-right"></i></a>
                                                
                               <button type="button" class="btn btn-danger  pull-right" data-dismiss="modal" >Close</button>
                                                </div>
                                                   
                                                </div>
											  </div>
											</div>                               
	</div>
	<?php
}

 //updating additional cost form additional_cost.php
if(isset($_GET['type']) && $_GET['type']==2)
{ 	
	$sno=$_GET['sno'];
	
	$updaddi = $conn->prepare("SELECT * FROM additional_cost where sno =? ORDER BY sno ASC ");
	$updaddi->execute(array($sno));
	$row_updaddi = $updaddi->fetch(PDO::FETCH_ASSOC);
	$totalRows_updaddi = $updaddi->rowCount();
	?>
    <div class="modal-dialog ">
                    <form name="form_addi_cost_sett" id="form_addi_cost_sett_updt" method="post" onsubmit="return vali_additional_updt()">
											<div class="modal-content modal-no-shadow modal-no-border">
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-cogs"></i>&nbsp;Update : <?php echo $row_updaddi['short_desc']; ?></h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
                                                <div class="col-sm-12">
                                                 <div class="col-sm-6"> Choose City </div>
                                                	<div class=" " > 
                                                <?php 
													
													$city= $conn->prepare("SELECT * FROM dvi_cities where status = '0' ORDER BY name ASC");
													$city->execute();
													//$row_city = mysql_fetch_assoc($city);
													$totalRows_city = $city->rowCount();
												?>
                                                	<select class="chosen-select col-sm-6" name="ac_sel_upd" id="ac_sel_upd" onchange="upd_place(this.value)">
                                                	<?php while($row_city = $city->fetch(PDO::FETCH_ASSOC))
													{
														if($row_updaddi['city_id']==$row_city['id']){?>
							<option selected="selected" value="<?php echo $row_city['id']; ?>"> <?php echo $row_city['name']; ?> </option>		
														<?php }else{?>
                                                	<option value="<?php echo $row_city['id']; ?>"> <?php echo $row_city['name']; ?> </option>
                                                    <?php }
													}//while ene ?>
                                                </select>
                                                </div>
                                                </div>
                                             <div class="col-sm-12" style="margin-top:10px;">
                                                 <div class="col-sm-6"> Choose Place </div>
                                                	<div id="up_place" > 
                                                <?php 
													
													$city1= $conn->prepare("SELECT * FROM hotspots_pro where status = '0' and spot_city=? ORDER BY spot_prior ASC");
													$city1->execute(array($row_updaddi['city_id']));
													//$row_city = mysql_fetch_assoc($city);
													$totalRows_city1 = $city1->rowCount();
												?>
                                                	<select class="chosen-select col-sm-6" name="ac_pla_upd" id="ac_pla_upd">
                                                	<?php while($row_city1 = $city1->fetch(PDO::FETCH_ASSOC))
													{ ?>
												
														
                                                	<option <?php if($row_updaddi['place']==$row_city1['hotspot_id']){?> selected="selected" <?php } ?> value="<?php echo $row_city1['hotspot_id']; ?>"> <?php echo $row_city1['spot_name']; ?> </option>
                                                    <?php 
													}//while ene ?>
                                                </select>
                                                </div>
                                                </div>   
                                                <div class="col-sm-12" style="margin-top:10px;">
                                                  <div class="col-sm-6 "> Short Name </div>
                                                  <div class="col-sm-6 reduce_padd">
                                                	<input type="text" class="form-control" name="ac_name_upd" id="ac_name_upd" value="<?php echo $row_updaddi['short_desc']; ?>" >
                                                </div>
                                                </div>
                                                
                                                <div class="col-sm-12" style="margin-top:10px;">
                                                <div class="col-sm-6 "> From Date </div>
                                                <div class="col-sm-6 reduce_padd" >
                                                	<input type="text" class="form-control datepicker_ac datepicker" name="ac_fdate_upd" id="ac_fdate_upd" data-date-format='yyyy-mm-dd' value="<?php echo $row_updaddi['fdate']; ?>" readonly="readonly" >
                                                </div>
                                                </div>
                                                
                                                <div class="col-sm-12" style="margin-top:10px;">
                                                <div class="col-sm-6 "> To Date </div>
                                                <div class="col-sm-6 reduce_padd" >
                                                	<input type="text" class="form-control datepicker_ac datepicker" name="ac_tdate_upd" id="ac_tdate_upd" data-date-format='yyyy-mm-dd' value="<?php echo $row_updaddi['tdate']; ?>" readonly="readonly" >
                                                </div>
                                                </div>
                                                
                                                <div class="col-sm-12" style="margin-top:10px;">
                                                <div class="col-sm-6 "> Amount (Rs.)</div>
                                                <div class="col-sm-6 reduce_padd" >
                                                	<input type="text" class="form-control" name="ac_amount_upd" id="ac_amount_upd" onkeypress="decemal_or_number_update()" value="<?php echo $row_updaddi['amount']; ?>"  >
                                                </div>
                                                </div>
							  					</div>
											  </div>
											  <div class="modal-footer">
                                              <strong class="pull-left" style="font-size:12px; color:#F00;" id="msg_addi_upd">Note : Please Enter All Required Fields..</strong>
                                              <input type="hidden" value="<?php echo $row_updaddi['sno']; ?>" name="addi_updt_id" id="addi_updt_id">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="addtion_submit" name="addtion_submit_updt" value="addtion_submit_updt_val" class="btn btn-success">Submit</button>
											  </div>
											</div>                                </form>
										  </div>
 <?php   
    }
	
//for locking additional cost
if(isset($_GET['type']) && $_GET['type']==3)
{
	
	$update=$conn->prepare("update additional_cost set status=? where sno=?");
	$update->execute(array($_GET['sts'],$_GET['sno']));
 
 	
	$addi = $conn->prepare("SELECT * FROM additional_cost where status != '2' ORDER BY sno ASC");
	$addi->execute();
	//$row_addi = mysql_fetch_assoc($addi);
	$totalRows_addi = $addi->rowCount();
	
    if($totalRows_addi>0){
								   ?>
						<table class="table table-striped table-hover datatable-example" >
							<thead class="the-box dark full">
								<tr>
								<th width="5%"><center> #</center> </th>
								<th width="25%" ><i class="fa fa-tag "></i>&nbsp; Short Name</th>
                                <th width="18%"><i class="fa  fa-map-marker"></i>&nbsp; City Name</th>
                                <th width="20%" ><center><i class="fa fa-calendar "></i>&nbsp; Date Limit</center></th>
                                <th width="12%" ><i class="fa fa-rupee (alias)"></i>&nbsp; Cost</th>
                                <th width="15%" ><center><i class="fa fa-flag "></i>&nbsp; Action </center></th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
							while($row_addi = $addi->fetch(PDO::FETCH_ASSOC))
							{?>
								<tr>
                                <td><?php echo $i; ?></td>
                                <td><?php 
									 $len=strlen($row_addi['short_desc']); 
									 if($len>31)
									 {?>
									 <span data-toggle='tooltip' data-original-title='<?php echo $row_addi['short_desc']; ?>'><?php echo substr($row_addi['short_desc'],0,30).'..'; ?></span>
									 <?php }else{
										 echo $row_addi['short_desc'];
									 }
									 
									 if($row_addi['status']==0)
									 {?>
										 <i class="fa fa-unlock-alt pull-right" data-toggle='tooltip' data-original-title='Active'></i>
									 <?php }else if($row_addi['status']==1){ ?>
										 <i class="fa fa-lock pull-right"  data-toggle='tooltip' data-original-title='Deactive'></i>
									 <?php } ?>
                                </td>
                                <td><?php
													
													$city_name= $conn->prepare("SELECT * FROM dvi_cities where id=?");
													$city_name->execute(array($row_addi['city_id']));
													$row_city_name = $city_name->fetch(PDO::FETCH_ASSOC);
								
								 echo $row_city_name['name']; 
									 ?></td>
                                <td align="center"><?php echo date('d-M-Y',strtotime($row_addi['fdate'])).' <i class="fa fa-arrows-h"></i> '.date('d-M-Y',strtotime($row_addi['tdate'])); ?></td>
                                <td> <i class="fa fa-rupee (alias)"></i>&nbsp; <?php echo $row_addi['amount']; ?></td>
                                <td align="center">
                                <div class="btn-group" align="left">
								  <button class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class=" pull-right dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
									<li><a href="javascript:void(0);" onclick="update_addi_cost('<?php echo $row_addi['sno']; ?>')"><i class="fa fa-edit"></i>&nbsp; Update</a></li>
                                    <?php  if($row_addi['status']==0){?>
                                    <li><a href="javascript:void(0);" onclick="lock_addi_cost('<?php echo $row_addi['sno']; ?>','1')" ><i class="fa fa-lock"></i>&nbsp; Lock</a></li><?php }else if($row_addi['status']==1){?>
                                    <li><a href="javascript:void(0);" onclick="lock_addi_cost('<?php echo $row_addi['sno']; ?>','0')" ><i class="fa  fa-unlock-alt"></i>&nbsp; UnLock</a></li>
                                    <?php }?>
                                    <li class="divider"></li>
                                  	<li><a href="javascript:void(0);" onclick="remove_addi_cost('<?php echo $row_addi['sno']; ?>','2')" ><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
								  </ul>
                                    </div></td>
                                </tr>
							<?php
							$i++;
							 }?>
                                </tbody>
                                </table>
                                <?php } else{?>
                              	<div class="alert alert-danger alert-bold-border square fade in alert-dismissable">
								  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								  <center><strong style="font-weight:600; color:#930;">No Entry Found !</strong></center>
								</div>
                                <?php } 
}

if(isset($_GET['type']) && $_GET['type']==4)
{
	$mail_to=$_GET['mailto']; 
	if(trim($mail_to)!='')
	{
		
		$mail = $conn->prepare("insert into settings_mail(mail_to,date_time)values(?,?)");
		$mail->execute(array($mail_to,$today_dat));
	}else{
		
			
			$fs = $conn->prepare("SELECT * FROM dvi_front_settings where sno=1");
			$fs->execute();
			$row_fs = $fs->fetch(PDO::FETCH_ASSOC);
			$totalRows_fs = $fs->rowCount();
			
			if($totalRows_fs >0)
			{
				$mailtoo=trim($row_fs['email']);
			}else{
				$mailtoo="srini@v-i.in";
			}
			
			$mail = $conn->prepare("insert into settings_mail(mail_to,date_time)values(?,?)");
			$mail->execute(array($mailtoo,$today_dat));
		
	}
	
}
?>