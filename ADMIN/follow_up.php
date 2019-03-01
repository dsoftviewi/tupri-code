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

$empid=$_GET['eid'];
$me=$_GET['me'];



?>
<head>
<link href="../core/assets/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- MAIN CSS (REQUIRED ALL PAGE) height:100%; -->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
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
.alg{
	text-align:center;
		
}
td{
  padding: 8px;	
}
</style>

</head>
<body>
		<div class="row">
						<div class="col-sm-12">
                        <?php if($me=='AGENT'){
														
														$emp = $conn->prepare("SELECT * FROM agent_pro where agent_id=?");
														$emp->execute(array($empid));
														$row_emp= $emp->fetch(PDO::FETCH_ASSOC);
														$tot_emp= $emp->rowCount();
														
														$ename=$row_emp['agent_fname'].' '.$row_emp['agent_lname'];
														$eimg=$row_emp['agent_img'];
														$efolder='agent_img';
														
														

$mragn= $conn->prepare("SELECT * FROM travel_master where  status='5' and agent_id=?");
$mragn->execute(array($empid));
//$row_mragn= mysql_fetch_assoc($mragn);
$row_mragn_main=$mragn->fetchAll();
$tot_mragn= $mragn->rowCount();
							?>
							<div class="panel panel-primary" >
                          
							  <div class="panel-heading ">
								<h3 class="panel-title">&nbsp; <i class="fa fa-user"></i>&nbsp;<?php echo $ename.' - Follow Up'; ?>
									<span class="right-content">AGENT</span>
								</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
                                <div class="col-sm-12" style="border-bottom:1px solid #999">
                                <div class="col-sm-10">
                                <table width="100%">
                                <tr ><td width="20%">Name</td><td width="1%">:</td><td width="79%"><?php echo $ename;?></td></tr>
                                <tr><td>Mobile Number</td><td>:</td><td><?php if(trim($row_emp['mobile_no'])!='' || trim($row_emp['mobile_no'])!='-'){ echo $row_emp['mobile_no']; }else if(trim($row_emp['land_line'])!=''){ echo $row_emp['land_line']; }else{ echo '-';}?></td></tr>
                                <tr><td>Email ID</td><td>:</td><td><?php if(trim($row_emp['email_id'])!='' || trim($row_emp['email_id'])!='-'){ echo $row_emp['email_id']; }else{ echo '-'; }?></td></tr>
                                </table>
                                </div>
                                <div class="col-sm-2">
                                <img src="../ADMIN/img_upload/agent_img/<?php echo $eimg; ?>" class="absolute-left-content " style="width:85px; height:100px;" alt="<?php echo $ename; ?>"></div>
                                </div>
                                
                                <div class="col-sm-12">
                                <table width="100%">
                                <thead><tr style="background-color: #F5E6D1; height: 30px;color: #CA812E;" ><th width="5%" class="alg">S.No</th><th width="15%" class="alg">Itin. ID</th><th width="15%" class="alg">Date Of Reg.</th><th width="25%" class="alg">Transport Charge</th><th width="20%" class="alg">Staying Charge</th></tr></thead>
                                <tbody>
                                <?php
								 $s=1;
								
								 foreach($row_mragn_main as $row_mragn){ 
								  $str=explode('#',$row_mragn['plan_id']);
								 ?>
                                <tr><td align="center"><?php echo $s; ?></td>
                                <td align="center"><?php echo $row_mragn['plan_id']; ?></td>
                                <td align="center"><?php echo date('d-M-Y',strtotime($row_mragn['date_of_reg'])); ?></td>
                                <td align="center"><?php echo $row_mragn['tr_net_amt']; ?></td>
                                <td align="center"><?php  if($str[0]=='TH' && $row_mragn['stay_tot_amt']=='0.00'){ echo 'Pending'; }else if($str[0]=='T'){ echo '-';  }?></td>
                                <?php /*?><td align="center"><?php if($str[0]=='TH'){if($row_mragn['stay_tot_amt']=='0.00'){ echo ''; }else{ echo "Rs. ".$row_mragn['stay_tot_amt']."/-"; }}else{ echo "Still Not Completed"; } ?></td><?php */?></tr>
                                <?php  $s++;
								}//while end?>
                                </tbody>
                                </table>
                                
                                </div>
							  	</div>
							</div><!-- /.panel panel-default -->
						</div>
                        <?php }else if($me=='DISTR')
						{
														
														$emp = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
														$emp->execute(array($empid));
														$row_emp= $emp->fetch(PDO::FETCH_ASSOC);
														$tot_emp=$emp->rowCount();
														
														$ename=$row_emp['distr_fname'].' '.$row_emp['distr_lname'];
														$eimg=$row_emp['distr_img'];
														$efolder='distributor_img';
														
														

$mragn= $conn->prepare("SELECT * FROM travel_master where  status='5' and distr_id=? and agent_id='-'");
$mragn->execute(array($empid));
//$row_mragn= mysql_fetch_assoc($mragn);
$row_mragn_main=$mragn->fetchAll();
$tot_mragn= $mragn->rowCount();
							?>
							<div class="panel panel-primary" >
                          
							  <div class="panel-heading ">
								<h3 class="panel-title">&nbsp; <i class="fa fa-user"></i>&nbsp;<?php echo $ename.' - Follow Up'; ?>
									<span class="right-content">Distributor</span>
								</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
                                <div class="col-sm-12" style="border-bottom:1px solid #999">
                                <div class="col-sm-10">
                                <table width="100%">
                                <tr ><td width="20%">Name</td><td width="1%">:</td><td width="79%"><?php echo $ename;?></td></tr>
                                <tr><td>Mobile Number</td><td>:</td><td><?php if(trim($row_emp['mobile_no'])!='' || trim($row_emp['mobile_no'])!='-'){ echo $row_emp['mobile_no']; }else if(trim($row_emp['land_line'])!=''){ echo $row_emp['land_line']; }else{ echo '-';}?></td></tr>
                                <tr><td>Email ID</td><td>:</td><td><?php if(trim($row_emp['email_id'])!='' || trim($row_emp['email_id'])!='-'){ echo $row_emp['email_id']; }else{ echo '-'; }?></td></tr>
                                </table>
                                </div>
                                <div class="col-sm-2">
                                <img src="../ADMIN/img_upload/distributor_img/<?php echo $eimg; ?>" class="absolute-left-content " style="width:85px; height:100px;" alt="<?php echo $ename; ?>"></div>
                                </div>
                                
                                <div class="col-sm-12">
                                <table width="100%">
                                <thead><tr style="background-color: #F5E6D1; height: 30px;color: #CA812E;" ><th width="5%" class="alg">S.No</th><th width="15%" class="alg">Itin. ID</th><th width="15%" class="alg">Date Of Reg.</th><th width="35%" class="alg">Transport Charge</th><th width="30%" class="alg">Staying Charge</th></tr></thead>
                                <tbody>
                                <?php
								 $s=1;
								 
								 foreach($row_mragn_main as $row_mragn){ 
								 $str=explode('#',$row_mragn['plan_id']); ?>
                                <tr><td align="center"><?php echo $s; ?></td>
                                <td align="center"><?php echo $row_mragn['plan_id']; ?></td>
                                <td align="center"><?php echo date('d-M-Y',strtotime($row_mragn['date_of_reg'])); ?></td>
                                <td align="center"><?php echo $row_mragn['tr_net_amt']; ?></td>
                                <td align="center"><?php  if($str[0]=='TH' && $row_mragn['stay_tot_amt']=='0.00'){ echo 'Pending'; }else if($str[0]=='T'){ echo '-';  }?></td>
                               <?php /*?> <td align="center"><?php if($str[0]=='TH'){ if($row_mragn['stay_tot_amt']=='0.00'){ echo 'Pending';}else{ echo "Rs. ".$row_mragn['stay_tot_amt']."/-"; } }else{ echo "Still Not Save"; }?></td><?php */?></tr>
                                <?php  $s++;
								}//while end?>
                                </tbody>
                                </table>
                                
                                </div>
							  	</div>
							</div><!-- /.panel panel-default -->
						</div>
                        <?php }?>
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
      	<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
                 
<script>

</script>

</html>
                        