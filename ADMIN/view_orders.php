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

	$aid=$_GET['aid'];
$grd_tot=0;
$pro_tot=0;
$pay_dvi=0;
$orders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and status='0' ");
$orders->execute(array($aid));
//$row_orders = mysql_fetch_assoc($orders);
$row_orders_main=$orders->fetchAll();
$totalRows_orders = $orders->rowCount();

$agentt = $conn->prepare("SELECT * FROM agent_pro where agent_id=? and status='0' ");
$agentt->execute(array($aid));
$row_agentt = $agentt->fetch(PDO::FETCH_ASSOC);
$totalRows_agentt = $agentt->rowCount();


foreach($row_orders_main as $row_orders)
		{
			$grd_tot=$grd_tot+ceil($row_orders['agnt_grand_tot']);
			
			
			$admin_perc=$row_orders['grand_tot']*($row_orders['agnt_adm_perc']/100);
    		$pro_tot=$pro_tot+ceil($admin_perc);
			
			//$pro_tot=$pro_tot+ceil((($row_orders['grand_tot']+$admin_perc)*($row_orders['agent_perc']/100)));
			
		}
?>



<head>
<link href="../core/assets/css/bootstrap.min.css" rel="stylesheet">

		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
        <link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
      <script src="../core/assets/js/jquery.min.js"></script>

   
        
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
							<div class="panel panel-primary" >
                          
							  <div class="panel-heading ">
								<h3 class="panel-title">&nbsp; <i class="fa fa-user"></i>&nbsp;
<?php echo $row_agentt['agent_fname']." ".$row_agentt['agent_lname']." - Orders"; ?>
</h3>
							  </div>
                              
							  <div class="panel-body">
								<div class="row">
                               <div  class="col-sm-12" align="center">
                                <table width="100%"  style="margin-top:10px;">
                                     
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Total Number Of Plan</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo $totalRows_orders."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Total Itinerary Collection</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo ceil($grd_tot)."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr>
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Profit to DVI</strong></td ><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo ceil($pro_tot)."&nbsp;&nbsp; Rupee(s)"; ?>
                                     </strong></td></tr>
                                     <?php /*?><tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Your Profit Amount</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo ceil($pro_tot)."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr><?php */?>
                                     </table>
                                    </div>
                                    
                                    <div class=" col-sm-12 table-responsive" style="margin-top:20px;" >
                                     <table width="100%"  class="table table-th-block ttb1"><thead>
                                     <tr style="background-color:#FCDABE; color:#83501F;">
                                     <td class="padclass" width="10%"><center><strong >Plan ID</strong></center></td>
                                     <td class="padclass" width="25%"><center><strong >Collection </strong>(Rs)</center></td>
                                     <td class="padclass" width="25%"><center><strong >Profit to DVI </strong>(Rs)</center></td>
                                     <td class="padclass" width="30%"><center><strong >Distr. Name</strong></center></td>
                                     <td class="padclass" width="10%"><center><strong >More Details</strong></center></td></tr>
                                     </thead>
                                     <tbody>
                                     <?php 
									 $pro_tot1=0;
									 $pay_dvi1=0;
									 
$orders1 = $conn->prepare("SELECT * FROM travel_master where agent_id=? and status='0' ");
$orders1->execute(array($aid));
//$row_orders1 = mysql_fetch_assoc($orders1);
$row_orders1_main=$orders1->fetchAll();
$totalRows_orders1 = $orders1->rowCount();
foreach($row_orders1_main as $row_orders1)
		{
			$admin_perc1=$row_orders1['grand_tot']*($row_orders1['agnt_adm_perc']/100);
    		$pay_dvi1=$row_orders1['grand_tot']+$admin_perc1;
			
			$pro_tot1=$admin_perc1;
			//$pro_tot1=$pay_dvi1*($row_orders1['agent_perc']/100);
			?>
			<tr><td><center><strong style="color:#3F4E89"><?php echo $row_orders1['plan_id'];?></strong></center></td>
            <td><center><strong style="color:#3F4E89"><?php echo ceil($row_orders1['agnt_grand_tot']);?></strong></center></td>
            <td><center><strong style="color:#3F4E89"><?php echo ceil($pro_tot1);?></strong></center></td>
           <td width="30%"><center><strong style="color:#3F4E89"><?php
		 
$distrb = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
$distrb->execute(array($row_orders1['distr_id']));
$row_distrb = $distrb->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $distrb->rowCount();

$str_name=$row_distrb['distr_fname'].' '.$row_distrb['distr_lname'];
		    echo $str_name;?></strong></center></td>
            <td><center><strong style="color:#3F4E89">
			   <?php 
			   $id_mas=substr($row_orders1['plan_id'],0,2);
															if($id_mas =='TH')
															{?>
																<a class="show_pdf btn btn-default" title="Plan details" href="../<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?planid=<?php echo urlencode($row_orders1['plan_id']); ?>"><i class="fa fa-ticket"></i></a>
															<?php }else if($id_mas =='H#')
															{?>
																<a class="show_pdf btn btn-default "  title="Plan details" href="../<?php echo $_SESSION['grp'];?>/itiner_hotel.php?planid=<?php echo urlencode($row_orders1['plan_id']); ?>"><i class="fa fa-ticket"></i></i></a>
															<?php }else if($id_mas =='T#')
															{?>
																<a class="show_pdf btn btn-default "  title="Plan details" href="../<?php echo $_SESSION['grp'];?>/itiner_trav.php?planid=<?php echo urlencode($row_orders1['plan_id']); ?>"><i class="fa fa-ticket"></i></a>
																
															<?php }
															?></strong></center></td></tr>
		<?php }
									 ?>
                                     </tbody>
                                     </table>
                                     </div>
							  </div>
							</div><!-- /.panel panel-default -->
                         
						</div>
                        </div>
                        </div>
                        </body>
                        
                        
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>

       
<script>
$(document).ready(function() {
	$('.ttb1').dataTable();
});

</script> 
                 


</html>
                        