<?php //echo $_GET['sid'];
require_once('../Connections/divdb.php');

$spot=$conn->prepare("select * from hotspots_pro where hotspot_id=?");
$spot->execute(array($_GET['sid']));
$row_spot = $spot->fetch(PDO::FETCH_ASSOC);

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

<div class="row ">
<div class="col-sm-12">
<div class="col-sm-6">
<div  id="property-photos">
											<div id="imagesync1" class="owl-carousel">
                                            
                                            <?php 
											$images=explode(',',$row_spot['spot_images']);
											foreach($images as $img){ ?>
											  <div style="width:100%; height:65%" class="item full">
                                              <br>
                                              <img src="../img_upload/hot_spots/<?php echo $img; ?>" alt="Image" style="width:441px;height:350px"></div>
                                              <?php } ?>
									
											</div>
											<div id="imagesync2" class="owl-carousel">
                                           <?php foreach($images as $img1){ ?>
											  <div class="item" style="height:15%; width:70%"><img src="../img_upload/hot_spots/<?php echo $img1; ?>"  alt="Image"  style="height:70px; width:78px;"></div>
                                              <?php } ?>
 
											</div>
										</div>
    </div>
    <div class="col-sm-6" style="background-color:#F4F5FA; height:450px; overflow-y:scroll">
    <center><strong style="color:#28508E; font-weight:600;"> Description about - <?php echo $row_spot['spot_name'];?></strong></center><br><?php 
    $hdesc=str_replace(">>>","'",$row_spot['spot_desc']);
							 echo $hdesc."<hr>";
							 echo "Timing : <strong style='color:#B24926'>".$row_spot['spot_timings']."</strong>";
							 ?>
    </div>
    </div>
</div>
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
