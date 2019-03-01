<?php
require_once('Connections/divdb.php');

mysql_select_db($database_divdb, $divdb);
				$query_foryou = "SELECT * FROM agent_pro where agent_id='".$_SESSION['uid']."'";
				$foryou = mysql_query($query_foryou, $divdb) or die(mysql_error());
				$row_foryou = mysql_fetch_assoc($foryou);
				$totalRows_foryou = mysql_num_rows($foryou);

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
                
				
			
            

					<!-- BEGIN CAROUSEL ITEM -->
                     <?php
						mysql_select_db($database_divdb, $divdb);
						$query_spots = "SELECT * FROM hotspots_pro where spot_images!='' and status = 0 ORDER BY RAND() LIMIT 20";
						$spots = mysql_query($query_spots, $divdb) or die(mysql_error());
						$row_spots = mysql_fetch_assoc($spots);
						$totalRows_spots = mysql_num_rows($spots);
					?>
					<div class="the-box no-border">
					<h4 class="small-heading more-margin-bottom text-center">Travel Hot spots</h4>
						<div id="store-item-carousel-3" class="owl-carousel shop-carousel">
                        <?php
						do
						{
							$imgexp = explode(',',$row_spots['spot_images']);
							
							mysql_select_db($database_divdb, $divdb);
							$query_city = "SELECT * FROM dvi_cities where id='$row_spots[spot_city]' and status = 0 ORDER BY RAND() LIMIT 25";
							$city = mysql_query($query_city, $divdb) or die(mysql_error());
							$row_city = mysql_fetch_assoc($city);
							$totalRows_city = mysql_num_rows($city);
							
							if ($totalRows_city > 0)
							{
						?>
							<div class="item">
								<div class="media">
									<a class="pull-left show_hotss" href="<?php echo $_SESSION['grp'];?>/hotspot_images.php?sid=<?php echo $row_spots['hotspot_id']; ?>">
								 <img class="media-object sm" src="img_upload/hot_spots/<?php echo $imgexp[0]; ?>" width="80" height="80" alt="Image">
									</a>
									<div class="media-body">
									  <h4 class="media-heading"><a class="show_hotss" href="<?php echo $_SESSION['grp'];?>/hotspot_images.php?sid=<?php echo $row_spots['hotspot_id']; ?>"><?php echo $row_spots['spot_name']; ?> </a></h4>
									  <p class="brand"><?php echo $row_city['name']; ?></p>
									</div>
								</div>
							</div>
                            <?php
							}
						} while($row_spots = mysql_fetch_assoc($spots));
						?>
						</div><!-- /#store-item-carousel-1 -->
					</div><!-- /.the-box .no-border -->
				</div><!-- /.container-fluid -->
             </div>

<script>

$(document).ready(function(e) {
    $('.chosen-select').chosen({width:'100%'});
});

function travel_fun(p0id,p1id)
{
	var ty=1;
	var datt=$('#cdate').val();
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_log.php?type='+ty+'&pid1='+p0id+'&pid2='+p1id+'&datt='+datt,function(result){
		$('.loader_ax').fadeOut(500);
		$('#model_travel_ajax').empty().html(result);
		});
	$('.travel_mod').attr('id','travel_info'+p0id+'_'+p1id);
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

/*    $('#example1').datepicker({
        format: "yyyy-mm-dd"
    });

    $('.dp').on('changeDate', function () {
        $('.datepicker').hide();
		
		var datt=$('.dp').val();
		$('#cdate').val(datt);
		$('#tdate').empty().prepend(datt);
		$.get('<?php //echo $_SESSION['grp']; ?>/ajax_log.php?type=2&datt='+datt,function(result){
			//alert(result);
		$('#log_table').empty().html(result);
		$('#example1').datepicker({format: "yyyy-mm-dd"});
		});
    });*/

</script>              