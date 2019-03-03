<?php
$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date("d-M-Y");
  $ctoday=date("Y-m-d");
?>

<style>
.loader_ax{
position: fixed;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
z-index: 9999;
background: url('images/ajax_loader.gif') center no-repeat ;
background-size:120px;
background-color:rgba(0, 0, 0, 0.5);
}
</style>
<div class="page-content">
				<div class="container-fluid">
                
       
<div class="modal fade travel_mod"  tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" style="width:65%">
<div class="modal-content modal-no-shadow modal-no-border" id="model_travel_ajax">
   
<!-- update - model -->
</div> 
</div> 
</div>
				<!-- Begin page heading -->
				<h1 class="page-heading">DASHBOARD</h1>
				<!-- End page heading -->
				
					<!-- BEGIN EXAMPLE ALERT -->
					<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
					  
					  <p><strong>Welcome! </strong></p>
					  <p class="text-muted">We are upgrading our system to your expectations we will be back soon, inconvenience caused regretted </p>
					</div>
					<!-- END EXAMPLE ALERT -->
					
			
				
             </div>
          </div>
       </div>
<script>

function travel_fun(p0id,p1id)
{
	var ty=1;
	var datt=$('#cdate').val();
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_log.php?type='+ty+'&pid1='+p0id+'&pid2='+p1id+'&datt='+datt,function(result){
		$('.loader_ax').hide();
		$('#model_travel_ajax').empty().html(result);
		$('.tooltips').tooltip();
		});
		$('.travel_mod').attr('id','travel_info'+p0id+'_'+p1id);
		$('.datatable-example').dataTable();
}
  
function fn_city()
{
	var cid=$('#city_selt').val().trim();
	if(cid!='-')
	{
		$('#hotspot_city').addClass('add_host4');
		$('#hotspot_city').attr('href','AGENT/view_img_desc.php?cid='+cid);
	}else{
		alert('Please select any city ..');
		$('#hotspot_city').removeClass('add_host4');
		$('#hotspot_city').removeAttr('href');
	}
}
  
   
/* $(document).ready(function () {
    $('#example1').datepicker({
        format: "yyyy-mm-dd"
    });

    $('.dp').on('changeDate', function () {
        $('.datepicker').hide();
		
		var datt=$('.dp').val();
		$('#cdate').val(datt);
		$('#tdate').empty().prepend(datt);
		$.get('<?php // echo $_SESSION['grp']; ?>/ajax_log.php?type=2&datt='+datt,function(result){
			//alert(result);
		$('#log_table').empty().html(result);
		$('#example1').datepicker({format: "yyyy-mm-dd"});
		});
    });

});*/


	  

</script>