<?php
session_start();
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
        <link href="../core/assets/plugins/summernote/summernote.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/markdown/bootstrap-markdown.min.css" rel="stylesheet">
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
</head>        

<body>
<?php 
require_once('../Connections/divdb.php');
$sid=$_GET['sid'];



$state = $conn->prepare("SELECT * FROM dvi_states where code=?");
$state->execute(array($sid));
$row_state =$state->fetch(PDO::FETCH_ASSOC);


$city = $conn->prepare("SELECT * FROM dvi_cities where region=?");
$city->execute(array($sid));
$row_city_main = $city->fetchAll();

							
?>

<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_state['name']; ?>-&nbsp; City List&nbsp;(&nbsp;<strong style="color:#FFF;"><?php echo $row_state['cities']; ?></strong>&nbsp;)
									<span class="right-content">
									
                                        <!--<form name="remove_room" method="post">
                                         <button id="remove_id"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_room" value="remove_room_val" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>-->								
                                        </span>
								
								</h3>
							  </div> 
                           <table id class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th><center><i class="fa  fa-tag"></i>&nbsp; id</center></th>
									<th><center><i class="fa  fa-map-marker"></i>&nbsp; Name of the City</center></th>
                                    <th><center><i class="fa  fa-fa-cogs"></i>&nbsp; Arrival/Departure</center></th>
                                    <th><center><i class="fa fa-refresh"></i>&nbsp; Sight-seeing distance</center></th>
                                    <th><center><i class="fa  fa-edit"></i>&nbsp; Update</center></th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
							foreach($row_city_main as $row_city){
								
								$histr = $conn->prepare("SELECT * FROM dvi_cities_history where cid=?");
								$histr->execute(array($row_city['id']));
								$row_histr = $histr->fetch(PDO::FETCH_ASSOC);	
							?>
								<tr class="even gradeA" id='tr_id<?php echo $i;?>'>
									<td width="3%"><center><?php echo $row_city['id'];?></center></td>
									<td  width="10%" >
									<center><span id="citnam<?php echo $i; ?>"><?php echo $row_city['name'];?></span>
                                    <input type="text" name="ecitnam<?php echo $i; ?>" id="ecitnam<?php echo $i; ?>" value="<?php echo $row_city['name'];?>" style="display:none">
									</center>
									</td>
                                    <td  width="10%" >
									<center><span id="ad<?php echo $i; ?>"><?php echo $row_city['type'];?></span>
                                    <input type="text" name="ead<?php echo $i; ?>" id="ead<?php echo $i; ?>" value="<?php echo $row_city['type'];?>" style="display:none">
									</center>
									</td>
                                    <td  width="10%" >
									<center><span id="ss<?php echo $i; ?>"><?php echo $row_city['ss_dist'];?></span>
                                    <input type="text" name="ess<?php echo $i; ?>" id="ess<?php echo $i; ?>" value="<?php echo $row_city['ss_dist'];?>" style="display:none">
									</center>
									</td>
                                    <td width="10%"><center>
                                    <a class="btn btn-default tooltips <?php if($row_city['status'] == 1) {	echo "disabled"; } ?>" id="ebtn<?php echo $i; ?>" title="Update history of city <?php echo $row_city['name']; ?>" onClick="show_edit(<?php echo $i; ?>)"><i class="fa fa-edit"></i></a>
                                    <?php
									if($row_city['status'] == 0)
									{
									?>
                                      <a class="btn btn-default tooltips" id="lock<?php echo $i; ?>" title="Lock city <?php echo $row_city['name']; ?>" onClick="lock_fun(<?php echo $i; ?>,<?php echo $row_city['id'];?>)" ><i class="fa fa-lock"></i></a>
                                      <?php
									}
									elseif($row_city['status'] == 1)
									{
										?>
                                        <a class="btn btn-default" id="unlock<?php echo $i; ?>" onClick="unlock_fun(<?php echo $i; ?>,<?php echo $row_city['id'];?>,<?php echo $sid; ?>)" ><i class="fa fa-key"></i></a>
                                        <?php
									}
									?>
                                      </center>
                                    </td>
								</tr>
                                <tr id="tr_edit_id<?php echo $i; ?>" style="display:none;">
                                <td colspan="5">
                                <textarea name="cdesc<?php echo $i; ?>" id="cdesc<?php echo $i; ?>" data-provide='markdown' rows="10" style="width:100%" ><?php echo $row_histr['cdesc'] ?>
                                </textarea>
                                <button type="button" name="updcit<?php echo $i; ?>" id="updcit<?php echo $i; ?>" class="btn btn-info btn-rounded-xs" style="display:none" onClick="editsub(<?php echo $i; ?>,<?php echo $row_city['id'];?>)">Update</button>
                                <button type="button" name="cancit<?php echo $i; ?>" id="cancit<?php echo $i; ?>" class="btn btn-danger btn-rounded-xs" style="display:none" onClick="cancel_fun(<?php echo $i; ?>)" >cancel</button>
                                <input type="hidden" name="hidid<?php echo $i; ?>" value="<?php echo $row_city['id'];?>" />
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
         
<script>


$('.tooltips').tooltip({});

function show_edit(no)
{
	$('#tr_edit_id'+no).show();
	$('#citnam'+no).hide();
	$('#ss'+no).hide();
	$('#ad'+no).hide();
	$('#ecitnam'+no).show();
	$('#ess'+no).show();
	$('#ead'+no).show();
	$('#updcit'+no).show();
	$('#cancit'+no).show();
}

function cancel_fun(no)
{
	$('#tr_edit_id'+no).hide();
	$('#updcit'+no).hide();
	$('#cancit'+no).hide();
	$('#citnam'+no).show();
	$('#ss'+no).show();
	$('#ad'+no).show();
	$('#ecitnam'+no).hide();
	$('#ess'+no).hide();
	$('#ead'+no).hide();
}

function editsub(cnt,sno)
{
	var hist = document.getElementById('cdesc'+cnt).value;
	var citnam1 = document.getElementById('ecitnam'+cnt).value;
	var ssdist = document.getElementById('ess'+cnt).value;
	var ctype = document.getElementById('ead'+cnt).value;
	
	if (hist.trim().length == 0)
	{
		hist = '-';
	}
	
	if (citnam1 == '')
	{
		alert ('enter cityname');
	}
	else
	{
		$.post('upd_city.php', { id:sno, hist: hist, citnam1: citnam1, ssdis: ssdist, ad: ctype, typ: 1 }, function(data) {
			$('#tr_edit_id'+cnt).hide();
			window.location.reload();
		});
	}
}

function lock_fun(cnt,sno)
{
	$.post('upd_city.php', { id:sno, typ: 2 }, function(data) {
		window.location.reload();
	});
}

function unlock_fun(cnt,sno,sid)
{
	$.post('upd_city.php', { id:sno, typ: 3, sid: sid }, function(data) {
		window.location.reload();
	});
}


</script>