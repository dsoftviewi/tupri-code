<?php
require_once('Connections/divdb.php');


if (isset($_SESSION['uid']))
{

	if (isset($_GET['mm']) && isset($_GET['sm']))
	{
		$_SESSION['setmmsm'] = $_SERVER["PHP_SELF"]."?mm=".$_GET['mm']."&sm=".$_GET['sm'];
	}
	elseif(isset($_GET['mm']) && !isset($_GET['sm']))
	{
		$_SESSION['setmmsm'] = $_SERVER["PHP_SELF"]."?mm=".$_GET['mm'];
	}
	elseif(!isset($_GET['mm']) && !isset($_GET['sm']))
	{
		$_SESSION['setmmsm'] = $_SERVER["PHP_SELF"];
	}


	/*$query_travelcomp = "SELECT * FROM travel_master where comp_status='1'";
	$travelcomp = mysql_query($query_travelcomp, $divdb) or die(mysql_error());
	//$row_travelcomp = mysql_fetch_assoc($travelcomp);
	$tot_travelcomp=mysql_num_rows($travelcomp);
	if($tot_travelcomp>0)
	{
		while($row_travelcomp = mysql_fetch_assoc($travelcomp))
		{
			echo $update_compstatus="update travel_master set status='3',comp_status='2' where plan_id='".$row_travelcomp['plan_id']."' and comp_status='1'";
			mysql_select_db($database_divdb, $divdb);
			mysql_query($update_compstatus, $divdb);
		}
	}*/

if($_SESSION['grp'] == 'AGENT')
{ 
	$logo = $conn->prepare("SELECT * FROM agent_pro where agent_id =? and status = 0");
	$logo->execute(array($_SESSION['uid']));
	$row_logo = $logo->fetch(PDO::FETCH_ASSOC);
}else if($_SESSION['grp'] == 'DISTRB')
{
	$logo = $conn->prepare("SELECT * FROM  distributor_pro where distr_id =? and status = 0");
	$logo->execute(array($_SESSION['uid']));
	$row_logo = $logo->fetch(PDO::FETCH_ASSOC);
	
}

?>
<style>

</style>
<div class="top-navbar info-color">
				<div class="top-navbar-inner " >
                
                <div class="modal fade" id="followup_modal" tabindex="-1" role="dialog" aria-hidden="true"  data-keyboard="false"  >
										  <div class="modal-dialog modal-lg">
											<div class="modal-content modal-no-shadow modal-no-border bg-default">
											  <div class="modal-header" style="color:#9A4C0B">
											<!--	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
												<h4 class="modal-title" style="text-align:center">Need Follow-Up</h4>
											  </div>
                                            <div class="modal-body"  style="padding-top: 5px; padding-left: 5px;padding-right: 20px; padding-bottom: 5px" align="center"><img src="images/stop.jpg" alt="Stop" style="width:100px; height:100px; opacity:0.5;" /><br>
                                            <strong style="color:#933;">Sorry! Some seasons are locked. <br> [ Some hotels are unavailable to make your itinerary... ]</strong>
                                    </div>
											  <div class="modal-footer" style="padding-top:10px; padding-bottom:10px" id="plan_det_info_btns" >
                                              <center>
                                              <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
                                                </center>
											  </div>
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .success .full -->
										  </div><!-- /.modal-dialog -->
										</div>
                
					<div class="logo-brand info-color">
                    <?php
					if ($_SESSION['grp'] == 'AGENT')
					{
					?>
						<a href="dashboard.php"><img style="margin-left:-25px" src="img_upload/agent_img/logo/<?php if(trim($row_logo['comp_logo'])!=''){  echo $row_logo['comp_logo']; }else { echo "logo.png"; }?>" height="60" alt="logo"></a>
                        <?php
					}
					else
					{
					?>
                        <a href="dashboard.php"><img style="margin-left:-25px" src="core/assets/img/logo.png" height="60" alt="logo"></a>
                        <?php
					}
						?>
					</div><!-- /.logo-brand -->
					<!-- End Logo brand -->
					<div class="top-nav-content">
						<!-- Begin button sidebar left toggle -->
						<div class="btn-collapse-sidebar-left">
							<i class="fa fa-bars"></i>
						</div><!-- /.btn-collapse-sidebar-left -->
						<!-- End button sidebar left toggle -->
						<!-- Begin button nav toggle -->
						<div class="btn-collapse-nav" data-toggle="collapse" data-target="#main-fixed-nav">
							<i class="fa fa-plus icon-plus"></i>
						</div><!-- /.btn-collapse-sidebar-right -->
						<!-- End button nav toggle -->
						<!-- Begin user session nav -->
						<ul class="nav-user navbar-right">
                        
							<li class="dropdown">
							  <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown">
                              <?php if ($_SESSION['grp'] == 'AGENT'){?>
                              <img src="ADMIN/img_upload/agent_img/<?php echo $row_logo['agent_img']; ?>" class="avatar img-circle" alt="<?php echo $row_logo['agent_fname']; ?>">Hi, <strong><?php echo $row_logo['agent_fname']." ".$row_logo['agent_lname']; ?></strong>
                              <?php }else if($_SESSION['grp'] == 'DISTRB')
							  {?>
								   <img src="ADMIN/img_upload/distributor_img/<?php echo $row_logo['distr_img']; ?>" class="avatar img-circle" alt="<?php echo $row_logo['distr_fname']; ?>">Hi, <strong><?php echo $row_logo['distr_fname']." ".$row_logo['distr_lname']; ?></strong>
							  <?php }else{?>
								<img src="core/assets/img/avatar/avatar.jpg" class="avatar img-circle" alt="ADMIN">
                                Hi, <strong><?php echo $_SESSION['name']; ?></strong>
                                <?php }?>
								
							  </a>
							  <ul class="dropdown-menu square info margin-list-rounded with-triangle">
                              <?php if ($_SESSION['grp'] != 'ADMIN'){ ?>
								<li><a class="profile_edit" href="<?php echo $_SESSION['grp'];?>/profile.php?uid=<?php echo $_SESSION['uid'];?>&group=<?php echo $_SESSION['grp'];?>">View Profile</a></li>
                                <?php } ?>
								<li><a class="change_pass" href="<?php echo $_SESSION['grp'];?>/profile.php?uid=<?php echo $_SESSION['uid'];?>&group=<?php echo "password";?>">Change Password</a></li>
								<li class="divider"></li>
								<li><a href="logout.php">Log out</a></li>
							  </ul>
							</li>
						</ul>
		
						<!-- Begin Collapse menu nav -->
						<div class="collapse navbar-collapse" id="main-fixed-nav">	
							<!-- Begin nav search form -->
							<form class="navbar-form navbar-left" role="search">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Search">
								</div>
							</form>
							<!-- End nav search form -->
<?php 
//notification to administator
if(isset($_SESSION['grp']) && $_SESSION['grp']=="ADMIN")
{

$anew = $conn->prepare("SELECT * FROM  agent_pro where status='1'");
$anew->execute();
//$row_anew= mysql_fetch_assoc($anew);
$row_anew_main=$anew->fetchAll();
$tot_anew= $anew->rowCount();

$dnew = $conn->prepare("SELECT * FROM distributor_pro where status='1'");
$dnew->execute();
//$row_dnew= mysql_fetch_assoc($dnew);
$row_dnew_main=$dnew->fetchAll();
$tot_dnew= $dnew->rowCount();
?>
							<ul class="nav navbar-nav navbar-left" >
							
                                
                                 <?php if($tot_anew>0 || $tot_dnew>0){?>
                                <li class="dropdown" id="notification">
									<a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"  title='Employee approval'>
										<span class="badge badge-info icon-count" id="span_tt">
										<?php echo $tot_dnew+$tot_anew;?></span>
										<i class="fa fa-users"></i>
									</a>
                                    <input type="hidden" value="<?php echo $tot_dnew+$tot_anew;?>" id="tot_cnn" />
									<ul class="dropdown-menu square margin-list-rounded with-triangle">
										<li>
											<div class="nav-dropdown-heading">
										 Waiting for approval
								 			</div>
											<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 350px;"><div class="nav-dropdown-content static-list scroll-nav-dropdown" style="overflow-y: scroll; width: auto; height: 350px;">
												<ul>
                                                 <?php foreach($row_dnew_main as $row_dnew) {?>
													<li id="<?php echo $row_dnew['distr_id'];?>">
														<img src="ADMIN/img_upload/distributor_img/<?php echo $row_dnew['distr_img'];?>" class="absolute-left-content img-circle" alt="Avatar">
														<div class="row">
															<div class="col-xs-6 ">
															<strong ><a class="profile_edit" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px;" href="<?php echo $_SESSION['grp'];?>/person_prof_details.php?uid=<?php echo $row_dnew['distr_id'];?>&person=<?php echo "DISTR";?>"><?php echo $row_dnew['distr_fname'];?><br /><span class="small-caps">As Distributor</span></a></strong>
																
															</div>
															<div class="col-xs-6 text-right btn-action">
																<button class="btn btn-success btn-xs" onclick="accept_or_reg_distr('<?php echo $row_dnew['distr_id'];?>','0')">Accept</button>
                                                                <button class="btn btn-danger btn-xs"  onclick="accept_or_reg_distr('<?php echo $row_dnew['distr_id'];?>','2')">Reject</button>
															</div><!-- /.col-xs-5 text-right btn-cation -->
														</div><!-- /.row -->
													</li>
                                                    <?php }?>
                                                
                                                
                                                  <?php foreach($row_anew_main as $row_anew) {?>
													<li id="<?php echo $row_anew['agent_id'];?>">
														<img src="ADMIN/img_upload/agent_img/<?php echo $row_anew['agent_img'];?>" class="absolute-left-content img-circle" alt="Avatar">
														<div class="row">
															<div class="col-xs-6">
																<strong>
																<a class="profile_edit" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px;" href="<?php echo $_SESSION['grp'];?>/person_prof_details.php?uid=<?php echo $row_anew['agent_id'];?>&person=<?php echo "AGENT";?>"><?php echo $row_anew['agent_fname'];?><br /><span class="small-caps">As Agent</span></a></strong>
																
															</div>
															<div class="col-xs-6 text-right btn-action">
																<button class="btn btn-success btn-xs" onclick="accept_or_reg_agent('<?php echo $row_anew['agent_id'];?>','0')">Accept</button>
                                                                <button class="btn btn-danger btn-xs"  onclick="accept_or_reg_agent('<?php echo $row_anew['agent_id'];?>','2')">Reject</button>
															</div><!-- /.col-xs-5 text-right btn-cation -->
														</div><!-- /.row -->
													</li>
                                                    <?php }?>
												
												</ul>
											</div><div class="slimScrollBar" style="width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 340.277777777778px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.3; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div><!-- /.nav-dropdown-content scroll-nav-dropdown --><hr style="margin-bottom: 5px;margin-top: 6px;" />
											<!--<button class="btn btn-primary btn-square btn-block">See all request</button>-->
                                           <center> <button class="btn btn-success btn-xs" onclick="accept_all()">Accept All</button> &nbsp;&nbsp;&nbsp;&nbsp; <button class="btn btn-danger btn-xs"  onclick="reject_all()">Reject All</button></center>
                                           <hr style="margin-bottom: 5px;margin-top: 6px;" />
										</li>
									</ul>
								</li>
                                <?php } else{ ?>
                               <li class="dropdown" id="notification">
									<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >
										<span class="badge badge-info icon-count" id="span_tt">
										<?php echo $tot_anew;?></span>
										<i class="fa fa-users"></i>
									</a>
                                    </li>
                                <?php }

$tmast = $conn->prepare("SELECT * FROM travel_master where status='2'");
$tmast->execute();
//$row_tmast= mysql_fetch_assoc($tmast);
$row_tmast_main=$tmast->fetchAll();
$tot_tmast= $tmast->rowCount();

								 if($tot_tmast>0){?>
                                <li class="dropdown" id="notification1">
									<a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"  title='Waiting for plan approval'>
										<span class="badge badge-info icon-count" id="span_tt1">
										<?php echo $tot_tmast;?></span>
										<i class="fa fa-envelope"></i>
									</a>
                                    <input type="hidden" value="<?php echo $tot_tmast;?>" id="tot_tmast" />
									<ul class="dropdown-menu square margin-list-rounded with-triangle">
										<li>
											<div class="nav-dropdown-heading">
										 Waiting for plan approval
								 			</div><!-- /.nav-dropdown-heading -->
											<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 350px;" id="note1_latest">
                                            <div class="nav-dropdown-content static-list scroll-nav-dropdown" style="overflow-y: scroll; width: auto; height: 350px;">
												<ul>
                                                 <?php foreach($row_tmast_main as $row_tmast) {?>
													<li id="sno<?php echo $row_tmast['sno'];?>">
															<img src="images/agent_accept.jpg" class="absolute-left-content img-circle" alt="Avatar">
														<div class="row">
															<div class="col-xs-6 ">
															<strong >
                                                            <?php 
														//	echo substr($row_tmast['plan_id'],0,2);
															
															if(substr($row_tmast['plan_id'],0,2)=="TH"){?>
                                                            <a class="show_pdf" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px;" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?topbar=<?php echo "topbar";?>&planid=<?php echo urlencode($row_tmast['plan_id']); ?>"><?php echo $row_tmast['plan_id'];?><br /><span class="small-caps">Waiting</span></a>
                                                            <?php }else if(substr($row_tmast['plan_id'],0,2)=="T#"){?>
                                                            <a class="show_pdf" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px;" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?topbar=<?php echo "topbar";?>&planid=<?php echo urlencode($row_tmast['plan_id']); ?>"><?php echo $row_tmast['plan_id'];?><br /><span class="small-caps">Waiting</span></a>
                                                            <?php }else if(substr($row_tmast['plan_id'],0,2)=="H#"){?>
                                                            <a class="show_pdf" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px;" href="<?php echo $_SESSION['grp'];?>/itiner_hotel.php?topbar=<?php echo "topbar";?>&planid=<?php echo urlencode($row_tmast['plan_id']); ?>"><?php echo $row_tmast['plan_id'];?><br /><span class="small-caps">Waiting</span></a>
                                                            <?php }?>
                                                            </strong>
																
															</div>
															<div class="col-xs-6 text-right btn-action">
																<button class="btn btn-success btn-xs" onclick="cal_wait_approvel('<?php echo $row_tmast['sno']; ?>','0')">Accept</button>
                                                                <button class="btn btn-danger btn-xs"  onclick="cal_wait_approvel('<?php echo $row_tmast['sno']; ?>','1')">Reject</button>
															</div><!-- /.col-xs-5 text-right btn-cation -->
														</div><!-- /.row -->
													</li>
                                                    <?php }?>
												</ul>
											</div><div class="slimScrollBar" style="width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 340.277777777778px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.3; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div><hr style="margin-bottom: 5px;margin-top: 6px;" />
										</li>
									</ul>
								</li>
                                <?php }else{ ?>
                               <li class="dropdown" id="notification1">
									<a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"  title='Waiting for plan approval'>
										<span class="badge badge-info icon-count" id="span_tt1">
										<?php echo $tot_tmast;?></span>
										<i class="fa fa-envelope"></i>
									</a>
                                    <input type="hidden" value="<?php echo $tot_tmast;?>" id="tot_tmast" />
									<ul class="dropdown-menu square margin-list-rounded with-triangle">
										<li>
											<div class="nav-dropdown-heading">
										Waiting for plan approval
								 			</div><!-- /.nav-dropdown-heading -->
											<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 300px; height: 350px;" id="note1_latest">
                                            <div class="slimScrollBar" style="width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 340.277777777778px; background: rgb(0, 0, 0);"></div>
                                           <br /><br /><center> Unavailable </center>
                                            
                                            <div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.3; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div><hr style="margin-bottom: 5px;margin-top: 6px;" />
										</li>
									</ul>
								</li>
                                
                                <?php }?>
								<!-- End nav task -->
                                <!-- Saved itinerary start -->
                                
                                <?php
$tmast_res = $conn->prepare("SELECT * FROM travel_master where  status='5' and agent_id!='-' GROUP BY agent_id");
$tmast_res->execute();
//$row_tmast_res= mysql_fetch_assoc($tmast_res);
$row_tmast_res_main=$tmast_res->fetchAll();
$tot_tmast_res= $tmast_res->rowCount();

$tmast_res1 = $conn->prepare("SELECT * FROM travel_master where status='5' and agent_id='-' GROUP BY distr_id");
$tmast_res1->execute();
//$row_tmast_res1= mysql_fetch_assoc($tmast_res1);
$row_tmast_res1_main=$tmast_res1->fetchAll();
$tot_tmast_res1= $tmast_res1->rowCount();

$tot_res=$tot_tmast_res1+$tot_tmast_res;
if($tot_res>0){
								?>
                                
                                <li class="dropdown" id="resume">
									<a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown" title='Uncompleted Plan'>
										<span class="badge badge-info icon-count" id="resume_bag">
										<?php echo $tot_res;?></span>
										<i class="fa fa-fast-forward"></i>
									</a>
                                    <input type="hidden" value="<?php echo $tot_res;?>" id="tot_tmast_res" />
									<ul class="dropdown-menu square margin-list-rounded with-triangle">
										<li>
											<div class="nav-dropdown-heading">
										 Uncompleted plans - Members
								 			</div><!-- /.nav-dropdown-heading -->
											<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 350px;" id="note1_latest1">
                                            <div class="nav-dropdown-content static-list scroll-nav-dropdown" style="overflow-y: scroll; width: auto; height: 350px;">
												<ul>
                                                 <?php 
												 if($tot_tmast_res>0)
												 {
												 foreach($row_tmast_res_main as $row_tmast_res) {?>
													<li id="sno<?php echo $row_tmast_res['sno'];?>">
                                                    <?php 
																									
														$emp = $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
														$emp->execute(array($row_tmast_res['agent_id']));
														$row_emp= $emp->fetch(PDO::FETCH_ASSOC);
														$tot_emp= $emp->rowCount();
														
														$ename=$row_emp['agent_fname'].' '.$row_emp['agent_lname'];
														$eimg=$row_emp['agent_img'];
														$efolder='agent_img';
												
													?>
															<img src="ADMIN/img_upload/<?php echo $efolder.'/'.$eimg; ?>" class="absolute-left-content img-circle" alt="<?php echo $ename; ?>">
														<div class="row">
															<div class="col-xs-8">
                                                           <strong>
                                                            <?php echo $ename;?>
                                                            </strong><br /><small>Agent</small>
															</div>
                                                            <div class="col-xs-4">
                                                       <!-- <button type="button" class="btn btn-default" onclick="follow_agent('<?php echo $row_tmast_res['agent_id']; ?>')">show</button>-->
                                                        <a class="follow_up btn btn-default" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px; height:27px;" href="<?php echo $_SESSION['grp'];?>/follow_up.php?eid=<?php echo $row_tmast_res['agent_id']; ?>&me=AGENT">Follow</a>
                                                            </div>
															<!-- /.col-xs-5 text-right btn-cation -->
														</div><!-- /.row -->
													</li>
                                                    <?php }//while end agent
												 }//if end agent
												 
												 if($tot_tmast_res1>0){//to distributor
													
												 foreach($row_tmast_res1_main as $row_tmast_res1) {?>
													<li id="sno<?php echo $row_tmast_res1['sno'];?>">
                                                    <?php 
														$emp = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
														$emp->execute(array($row_tmast_res1['distr_id']));
														$row_emp= $emp->fetch(PDO::FETCH_ASSOC);
														$tot_emp= $emp->rowCount();
														$ename=$row_emp['distr_fname'].' '.$row_emp['distr_lname'];
														$eimg=$row_emp['distr_img'];
														$efolder='distributor_img';
													?>
															<img src="ADMIN/img_upload/<?php echo $efolder.'/'.$eimg; ?>" class="absolute-left-content img-circle" alt="<?php echo $ename; ?>">
														<div class="row">
															<div class="col-xs-8">
															<strong > <?php echo $ename;?></strong>
															<small>Distributor</small>	
															</div>
                                                            <div class="col-xs-4">
                                                            <a class="follow_up btn" style="padding-left: 0px;padding-right: 0px; padding-top: 0px;padding-bottom: 0px; height:27px;" href="<?php echo $_SESSION['grp'];?>/follow_up.php?eid=<?php echo $row_tmast_res1['distr_id']; ?>&me=DISTR">Follow</a>
                                                            </div>
															<!-- /.col-xs-5 text-right btn-cation -->
														</div><!-- /.row -->
													</li>
                                                    <?php }//while end agent
												  
												 }
													?>
												</ul>
											</div><div class="slimScrollBar" style="width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 340.277777777778px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.3; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div><hr style="margin-bottom: 5px;margin-top: 6px;" />
										</li>
									</ul>
								</li>
                                <?php }else {?>
                                fd
                                <?php }?>
                                <!-- Saved itinerary end -->
                                
                                
							</ul>
<?php }// notification admin if end ?>                            
                            
						</div><!-- /.navbar-collapse -->
						<!-- End Collapse menu nav -->
					</div><!-- /.top-nav-content -->
				</div><!-- /.top-navbar-inner -->
			</div>
            <script>    
    if(typeof window.history.pushState == 'function') {
		<?php if(isset($_GET['mm']) && isset($_GET['sm']))
		{ ?>
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'].'?mm='.$_GET['mm'].'&sm='.$_GET['sm'].'';?>');
		<?php }else {?>
		window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF']; ?>');
		<?php }?>
		
    }
</script>
<script>
<?php if($_SESSION['grp']=='ADMIN') {?>
$(document).ready(function(e) {
	setInterval(function()
	{var ty=9;
		$.get('<?php echo $_SESSION['grp']; ?>/ajax_others.php?type='+ty,function(result)
		{
			
			var latest=result.trim();
			//alert(latest);
			$('#tot_tmast').val(latest);
			$('#span_tt1').empty().prepend($('#tot_tmast').val());
		});
	},60000);
	
	setInterval(function()
	{var ty=10;
		$.get('<?php echo $_SESSION['grp']; ?>/ajax_others.php?type='+ty,function(result)
		{
			//alert(result);
			$('#note1_latest').empty().html(result);
		});
	},60000);
	
});
<?php } ?>


function accept_or_reg_agent(id,sts)
{
    var ty=1;
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_others.php?type='+ty+'&id='+id+'&sts='+sts,function(result)
	{
		//alert(result);
		$('#'+id).hide();
		$('#tot_cnn').val($('#tot_cnn').val()-1);
		$('#span_tt').empty().prepend($('#tot_cnn').val());
		
		if($('#tot_cnn').val()!= '0')
		{
		$('#notification').addClass('open');
		}else
		{
			parent.location.reload();
		}
		
	});
}

function accept_or_reg_distr(id,sts)
{
  var ty=2;
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_others.php?type='+ty+'&id='+id+'&sts='+sts,function(result)
	{
		//alert(result);
		$('#'+id).hide();
		$('#tot_cnn').val($('#tot_cnn').val()-1);
		$('#span_tt').empty().prepend($('#tot_cnn').val());
		if($('#tot_cnn').val()!= '0')
		{
		$('#notification').addClass('open');
		}else
		{
			parent.location.reload();
		}
	});
}

function accept_all()
{
	 var ty=3;
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_others.php?type='+ty,function(result)
	{
		//alert(result);
		$('#notification').hide();
	});
}

function reject_all()
{	
	 var ty=4;
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_others.php?type='+ty,function(result)
	{
	//	alert(result);
		$('#notification').hide();
	});
}


function cal_wait_approvel(id,sts)
{
	//alert(id);
	 var ty=7;
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_others.php?type='+ty+'&id='+id+'&sts='+sts,function(result)
	{
		//alert(result);
		$('#sno'+id).hide();
		$('#tot_tmast').val($('#tot_tmast').val()-1);
		$('#span_tt1').empty().prepend($('#tot_tmast').val());
		if($('#tot_tmast').val()!= '0')
		{
		$('#notification1').addClass('open');
		}else
		{
			parent.location.reload();
		}
	});
	
}

</script>

 <script type="text/javascript">
    $(document).ready(function() {
		
	
      		var w,h,pval;
        w = screen.height;
        h =screen.width;
		
		 $('.profile_edit').fancybox({
	  width: w/0.8,
		height: h/2.35,
		autoSize	:  false,
		openEffect	: 'fade',
		closeEffect	: 'none',
		scrolling : 'no',
		type : 'iframe',
		//scrolling : 'yes',
		 topRatio     : 0,
		 padding  :[10,10,0,10],
		 
		  
		 helpers   : { 
      overlay : {closeClick: false} 
                   },
				   
		
        afterClose : function() {
  //  parent.location.reload();
	
  },
 
		}); 
		
		 $('.change_pass').fancybox({
	  width: w/1.5,
		height: h/4,
		autoSize	:  false,
		openEffect	: 'fade',
		closeEffect	: 'none',
		scrolling : 'no',
		type : 'iframe',
		 topRatio     : 0,
		 padding  :[10,10,0,10],
		 
		  
		 helpers   : { 
      overlay : {closeClick: false} 
                   },
				   
		
        afterClose : function() {
  //  parent.location.reload();
	
  },
 
		});
		
		 $('.show_pdf').fancybox({
			width: w/0.8,
			height: h/0.8,
			autoSize	:  false,
			openEffect	: 'fade',
			closeEffect	: 'none',
			scrolling : 'no',
			type : 'iframe',
			 topRatio     : 0,
			 padding  :[10,10,0,10],
			 
			  
			 helpers   : { 
		  overlay : {closeClick: false} 
					   },
			
			afterClose : function() {
			//parent.location.reload();
			},
		});
		
		 $('.follow_up').fancybox({
	  width: w/0.8,
		height: h/2.35,
		autoSize	:  false,
		openEffect	: 'fade',
		closeEffect	: 'none',
		scrolling : 'no',
		type : 'iframe',
		//scrolling : 'yes',
		 topRatio     : 0,
		 padding  :[10,10,0,10],
		 
		  
		 helpers   : { 
      overlay : {closeClick: false} 
                   },
				   
        afterClose : function() {
  //  parent.location.reload();
  },
 
		}); 
		

	
/*	$(".prof_fancy").fancybox({
    //type: "date",
    onStart: function (el, index) {
        var thisElement = $(el[index]);
        $.extend(this, {
           href: thisElement.data("href")
        });
		
    }
});*/	
	$('.nav-dropdown-content').find('ul').find('li').remove('a');

    });

function follow_agent(aid)
{
	alert(aid);
	$('#followup_modal').modal('show');
}

function follow_distr(did)
{
	alert(did);	
}

	</script>


<?php
}
else
{
	header("Location: index.php ");
}
?>

