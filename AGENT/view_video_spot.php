<?php //echo $_GET['sid'];
require_once('../Connections/divdb.php');

$spot=$conn->prepare("select * from hotspots_pro where spot_city=?");
$spot->execute(array($_GET['cid']));
//$row_spot = mysql_fetch_assoc($spot);
$row_spot_main =$spot->fetchAll();
$tot_row=$spot->rowCount();

?>


<link href="../core/assets/css/bootstrap.min.css" rel="stylesheet">
	
		<link href="../core/assets/plugins/weather-icon/css/weather-icons.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.theme.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.transitions.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
	
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">

<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>
<body>

<?php if($tot_row>0){ ?>
<div class="row ">
<div class="col-sm-12">
<?php 

$i=0;
foreach($row_spot_main as $row_spot) {?>
<div id="divv_<?php echo $i; ?>" <?php if($i!=0){?> style="display:none;" <?php } ?>>
<center><strong><?php echo $row_spot['spot_name']; ?></strong></center>
<br>
<iframe width="640" height="390" src="<?php echo $row_spot['video_link']; ?>" frameborder="0" allowfullscreen></iframe>
    </div>
    
    <div id="arrow_<?php echo $i; ?>" <?php if($i!=0){?> style="display:none;" <?php } ?>>
    <br>
   <center> <button class="btn btn-sm btn-default" id="left_btn_<?php echo $i; ?>" onClick="move_left(<?php echo $i-1; ?>)"><i class="fa fa-arrow-left"></i> </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button class="btn btn-sm btn-default" id="right_btn_<?php echo $i; ?>" onClick="move_right(<?php echo $i+1; ?>)"><i class="fa fa-arrow-right"></i></button></center>
    </div>
    <?php $i++; } ?>


</div>
</div>
<?php }else{?>
<div class="row ">
<div class="col-sm-12">
<br><br><br><center><strong style="color:#CCC; font-weight:600; font-size:18px;">Unavailable Pictorial Representation</strong></center>
</div>
</div>
<?php } ?>
</body>
<script src="../core/assets/js/jquery.min.js"></script>
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
 
		<script src="../core/assets/plugins/skycons/skycons.js"></script>
		<script src="../core/assets/plugins/prettify/prettify.js"></script>
		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
	
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel.js"></script>


<script>
function move_left(no)
{
	
var org1=no+1;
		if ( $('#divv_'+no).length )
		{
		$('#divv_'+org1).hide();
		$('#arrow_'+org1).hide();
		$('#divv_'+no).show();
		$('#arrow_'+no).show();
		}else
		{
			$('#left_btn_'+org1).attr('disabled',true);
		}
}

function move_right(no)
{
var org2=no-1;
		if ( $('#divv_'+no).length ) {
				$('#divv_'+org2).hide();
				$('#arrow_'+org2).hide();
				$('#divv_'+no).show();
				$('#arrow_'+no).show();
		}else
		{
		$('#right_btn_'+org2).attr('disabled',true);	
		}	
}
</script>