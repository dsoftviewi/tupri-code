<?php
session_start();

require_once('../Connections/divdb.php');

$vid = $_GET['vid'];

$vehnm = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id=? and status=0");
$vehnm->execute(array($vid));
$row_vehnm = $vehnm->fetch(PDO::FETCH_ASSOC);

$states = $conn->prepare("SELECT * FROM dvi_states where is_permit = 0 and status=0");
$states->execute();
$row_states_main = $states->fetchAll();
$totalRows_states = $states->rowCount();

if (isset($_POST['formsub']) && $_POST['formsub'] == '1')
{
	for ($j=1;$j<=$totalRows_states;$j++)
	{
		$ifexist = $conn->prepare("SELECT * FROM vehicle_permit where vehicle_id =? and state_id =? and status=0");
		$ifexist->execute(array($_GET['vid'],$_POST['stat'.$j]));
		$row_ifexist = $ifexist->fetch(PDO::FETCH_ASSOC);
		$totalRows_ifexist = $ifexist->rowCount();
		
		if($totalRows_ifexist > 0)
		{
			$upd_perm=$conn->prepare("UPDATE vehicle_permit set vehicle_id=?, state_id =?, permit_amt =? where vehicle_id =? and state_id =?");
			$upd_perm->execute(array($vid,$_POST['stst'.$j],$_POST['peramt'.$j],$_GET['vid'],$_POST['stat'.$j]));
		}
		else
		{
			$permitins = $conn->prepare("INSERT INTO vehicle_permit (vehicle_id, state_id, permit_amt, status) VALUES (?,?,?, '0')");
			$permitins->execute(array($vid,$_POST['stat'.$j],$_POST['peramt'.$j]));
		}
	}
	echo "<script>parent.jQuery.fancybox.close();</script>";
}

?>
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
        <link href="../coreassets/plugins/weather-icon/css/weather-icons.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/owl-carousel/owl.theme.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/owl-carousel/owl.transitions.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../coreassets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/summernote/summernote.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/markdown/bootstrap-markdown.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/morris-chart/morris.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/c3-chart/c3.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../coreassets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../coreassets/plugins/toastr/toastr.css" rel="stylesheet">
		<link href="../coreassets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet">
		<link href="../coreassets/plugins/fullcalendar/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print">

		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
</head>        

<body>
					<div class="row">
						<div class="col-sm-12">
							<div class="the-box" style="background-color:#E8E9EE">
								<h4 class="bolded">Permit rates for <?php echo $row_vehnm['vehicle_type']; ?></h4>
                                <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #CCC;">
								<form id="ExampleBootstrapValidationForm" method="post" class="" action="">
                                
                                	
                                    <div class="form-group">
                                        <div class="row">
                                        <label style="color:#900" class="control-label col-sm-4">States</label>
                                        
                                        <label style="color:#900" class="control-label col-sm-4">Permit amount</label>
                                         </div>
	                       			</div>
                                
                                <?php 
								$i=1;
								foreach($row_states_main as $row_states)
								{
									$vehper = $conn->prepare("SELECT * FROM vehicle_permit where vehicle_id =? and state_id =? and status=0");
									$vehper->execute(array($_GET['vid'],$row_states['code']));
									$row_vehper = $vehper->fetch(PDO::FETCH_ASSOC);
									$totalRows_vehper = $vehper->rowCount();

								?>
                                    <div class="form-group">
                                        <div class="row">
                                        <label class="control-label col-sm-4"><?php echo $row_states['name']; ?></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="peramt<?php echo $i; ?>" placeholder="Enter permit charge" value="<?php if($totalRows_vehper > 0) { echo $row_vehper['permit_amt']; } else { echo 0; } ?>" style=" background-color:#F5F5F5" />
                                                <input type="hidden" name="stat<?php echo $i; ?>" value="<?php echo $row_states['code']; ?>">
                                            </div>
                                         </div>
	                       			</div>
                                    <?php
								$i++;
								}
								
								?>
                                
                                <div class="the-box"  style="background-color:#EFF2F5;" >
                                <center>
                                <button type="submit" class="btn btn-info" name="sub_rate">Submit</button>
                                <button type="button" onClick="parent.jQuery.fancybox.close();" class="btn btn-warning">Cancel</button>
                                <input type="hidden" name="formsub" value="1">
                                </center>
                                </div>
								</form>
							</div><!-- /.the-box -->
						</div><!-- /.col-sm-8 -->

                        </div>
					</body>    
				</html>    
 
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
                        <script src="../core/assets/js/jquery.min.js"></script>
						<script src="../core/assets/js/bootstrap.min.js"></script>
                        <script src="../core/assets/plugins/retina/retina.min.js"></script>
                        <script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
                        <script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
                        <script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
                 
                        <!-- PLUGINS -->
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
                        
                        <!-- FULL CALENDAR JS -->
                        <script src="../core/assets/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
                        <script src="../core/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
                        <script src="../core/assets/js/full-calendar.js"></script>
                        
                        <!-- EASY PIE CHART JS -->
                        <script src="../core/assets/plugins/easypie-chart/easypiechart.min.js"></script>
                        <script src="../core/assets/plugins/easypie-chart/jquery.easypiechart.min.js"></script>
                        
                        <!-- KNOB JS -->
                        <!--[if IE]>
                        <script type="text/javascript" src="assets/plugins/jquery-knob/excanvas.js"></script>
                        <![endif]-->
                        <script src="../core/assets/plugins/jquery-knob/jquery.knob.js"></script>
                        <script src="../core/assets/plugins/jquery-knob/knob.js"></script>
                
                        <!-- FLOT CHART JS -->
                        <script src="../core/assets/plugins/flot-chart/jquery.flot.js"></script>
                        <script src="../core/assets/plugins/flot-chart/jquery.flot.tooltip.js"></script>
                        <script src="../core/assets/plugins/flot-chart/jquery.flot.resize.js"></script>
                        <script src="../core/assets/plugins/flot-chart/jquery.flot.selection.js"></script>
                        <script src="../core/assets/plugins/flot-chart/jquery.flot.stack.js"></script>
                        <script src="../core/assets/plugins/flot-chart/jquery.flot.time.js"></script>
                
                        <!-- MORRIS JS -->
                        <script src="../core/assets/plugins/morris-chart/raphael.min.js"></script>
                        <script src="../core/assets/plugins/morris-chart/morris.min.js"></script>
                        
                        <!-- C3 JS -->
                        <script src="../core/assets/plugins/c3-chart/d3.v3.min.js" charset="utf-8"></script>
                        <script src="../core/assets/plugins/c3-chart/c3.min.js"></script>
                        
                        <!-- VALIDATOR EXAMPLE -->
                        <script src="../core/assets/plugins/validator/example.js"></script>
                        
                        <!-- MAIN APPS JS -->
                        <script src="../core/assets/js/apps.js"></script>
                        <script src="../core/assets/js/demo-panel.js"></script>
						<script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
         
