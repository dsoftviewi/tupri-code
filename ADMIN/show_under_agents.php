<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>

<html>
<head>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- PLUGINS CSS -->
		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
</head>        
      <body>

<?php 
require_once('../Connections/divdb.php');
$did=$_GET['did'];



	$dist = $conn->prepare("SELECT * FROM distributor_pro where distr_id=?");
	$dist->execute(array($did));
	$row_dist = $dist->fetch(PDO::FETCH_ASSOC);
	$tot_dist= $dist->rowCount();


	$agent = $conn->prepare("SELECT * FROM  agent_pro where distr_id=?");
	$agent->execute(array($did));
	$row_agent_main = $agent->fetchAll();
	$tot_agent= $agent->rowCount();

							
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_dist['distr_fname']."&nbsp;".$row_dist['distr_lname']; ?>&nbsp;-&nbsp; Agent List&nbsp;(&nbsp;<strong style="color:#FFF;"><?php echo $tot_agent; ?></strong>&nbsp;)
									<span class="right-content">
									
                                        <!--<form name="remove_room" method="post">
                                         <button id="remove_id"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_room" value="remove_room_val" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>-->								
                                        </span>
								
								</h3>
							  </div> 
                           <table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th  width="4%"><center>#</center></th>
									<th><center><i class="fa  fa-picture-o"></i>&nbsp; Image</center></th>
                                    <th><center><i class="fa  fa-tag"></i>&nbsp; Contact</center></th>
                                    <th><center><i class="fa  fa-home"></i>&nbsp; Address</center></th>
                                    <th><center><i class="fa  fa-home"></i>&nbsp; Order(s)</center></th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
					foreach($row_agent_main as $row_agent){?>
								<tr class="even gradeA" >
									<td width="5%"><center><?php echo $i;?></center></td>
									<td  width="10%" >
									<center><img src="img_upload/agent_img/<?php echo $row_agent['agent_img'];?>" style="width:70px; height:70px;" alt="<?php echo $row_agent['agent_fname']; ?>" >
									</center>
									</td>
                                    <td width="25%" style="word-wrap:break-word">
                                     <?php
									  echo "<i class='fa fa-tag' style='color:#CCC;'></i>&nbsp; <b style='color:#C73B0B;'>".$row_agent['agent_fname']."&nbsp;".$row_agent['agent_lname']."</b><br>";
									 echo "<i class='fa fa-phone' style='color:#CCC'></i>&nbsp; <b style='color:#698368; font-size:13px;'>".$row_agent['mobile_no']."</b><br>";
									  echo "<i class='fa fa-envelope' style='color:#CCC'></i>&nbsp; <b style='color:#698368; font-size:13px;'>".$row_agent['email_id']."</b><br>";
									 ?></td>
                                    
                                    
                                    <td width="40%" style="word-wrap:break-word">
                                     <?php
									
									 $addr= str_replace('\\',',',$row_agent['agent_addr']);
									 echo $addr."<br>";
	
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_agent['city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);								 
									  echo $row_hotelcity['name']."<br>";
									  
	
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_agent['state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									  echo $row_hotelstate['name'];
									  
									 ?></td>
                                     <td width="20%">
                                    <center> <button type="button"  class="btn btn-sm" disabled>No Order(s)</button> </center>
                                     </td>
									
								</tr>
                               <?php $i++;
							}?>
                                </tbody>
                                </table>
						</div>
                        </div>
                        </div>
                        
 </body>    
 </html>    
 
 <script>
 
 </script>
                               
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
		<script src="../core/assets/plugins/icheck/icheck.min.js"></script>
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
		<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>