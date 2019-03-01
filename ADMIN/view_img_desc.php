<?php //echo $_GET['sid'];
require_once('../Connections/divdb.php');

$spot=$conn->prepare("select * from hotspots_pro where spot_city=?");
$spot->execute(array($_GET['cid']));
//$row_spot = mysql_fetch_assoc($spot);
$row_spot_main=$spot->fetchAll();
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
        
        <script src="../core/assets/plugins/fancybox/lib/jquery-1.8.2.min.js"></script>
         <link href="../core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
    	<script src="../core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="../core/assets/plugins/fancybox/source//helpers/jquery.fancybox-thumbs.js?v=1.0.7">
    </script>
     <script type="text/javascript" src="../core/assets/plugins/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>

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
<?php 
$i=0;
foreach($row_spot_main as $row_spot) {?>
<div class="col-sm-12" id="divv_<?php echo $i; ?>" <?php if($i!=0) {?>style="display:none;"<?php } ?>>
<div>
<div class="col-sm-6">
											<?php $images=explode(',',$row_spot['spot_images']);
											$len=count($images);
											
											if($len>0 && trim($images[0]) != ''){
											?>
											<div  class="imagesync11 owl-carousel">
                                            
                                            <?php 
											//echo $row_spot['spot_images'];
											//$images=explode(',',$row_spot['spot_images']);
											foreach($images as $img){ ?>
											  <div style="width:100%; height:65%" class="item full">
                                              <br>
                                              <img src="../img_upload/uploads/files/<?php echo $img; ?>" alt="Image"></div>
                                              <?php } ?>
									
											</div>
                                            <br>
											<div  class=" imagesync21 owl-carousel" style="background-color:#F4F5FA">
                                            
                                           <?php foreach($images as $img1){ ?>
											  <div class="item" style="height:15%; width:70%"><img src="../img_upload/uploads/files/<?php echo $img1; ?>"  alt="Image"   ></div>
                                              <?php } ?>
 
											</div>
                                            <?php }else{?>
                                            <br><br><br><br><br><br><br><br><center><strong style="color:#CCC; font-weight:600; font-size:18px;">Unavailable Pictorial Representation</strong>
                                            <img src="../img_upload/uploads/unavail_img.jpg"  alt="Unavailable Image"   >
                                            </center>
                                            <?php }?>
										    </div>
    <div class="col-sm-6" style="background-color:#F4F5FA; height:450px; overflow-y:scroll">
    <center><strong style="color:#28508E; font-weight:600;"> Description about - <?php echo $row_spot['spot_name'];?></strong></center><br><?php 
	if(trim($row_spot['spot_desc']) != '')
	{
    $hdesc=str_replace(">>>","'",$row_spot['spot_desc']);
							 echo $hdesc."<hr>";
							 echo "Timing : <strong style='color:#B24926'>".$row_spot['spot_timings']."</strong>";
	}else
	{?>
		<br><br><br><br><br><br><center><strong style="color:#CCC; font-weight:600; font-size:18px;">Unavailable Discription</strong><br><br>
         <img src="../img_upload/uploads/unavail_desc.png"  alt="Unavailable Image"  width="150px;" height="150px;"  >
	<?php }
							 ?>
    </div>
    </div>
  
    </div>
    
  <div class="col-sm-12" id="arrow_<?php echo $i; ?>" <?php if($i!=0) {?>style="display:none;"<?php } ?>>
  <br>
    <center><button class="btn btn-sm btn-default" id="left_btn_<?php echo $i; ?>"   onClick="move_left(<?php echo $i-1;?>)" ><i class="fa fa-arrow-left"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="right_btn_<?php echo $i; ?>" class="btn btn-sm btn-default" href="javascript:void(0)" onClick="move_right(<?php echo $i+1;?>)"><i class=" fa fa-arrow-right"></i></a></center> 
    
    </div>
    
    <?php $i++; } ?>
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
//alert("L"+no);
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


var imagesync1 = $(".imagesync11");

	var imagesync2 = $(".imagesync21");

	 

	  $(".imagesync11").owlCarousel({

		singleItem : true,

		slideSpeed : 1000,

		navigation: false,

		pagination:false,

		afterAction : syncPosition,

		lazyLoad : true,

		responsiveRefreshRate : 200

	  });

	 

	 $(".imagesync21").owlCarousel({

		items : 5,

		itemsDesktop      : [1199,5],

		itemsDesktopSmall : [979,4],

		itemsTablet       : [768,3],

		itemsMobile       : [479,2],

		pagination:false,

		responsiveRefreshRate : 100,

		afterInit : function(el){

		  el.find(".owl-item").eq(0).addClass("synced");

		}

	  });

	 

	  function syncPosition(el){

		var current = this.currentItem;

		$(".imagesync21")

		  .find(".owl-item")

		  .removeClass("synced")

		  .eq(current)

		  .addClass("synced")

		if($(".imagesync21").data("owlCarousel") !== undefined){

		  center(current)

		}

	  }

	 if ($(".imagesync21").length > 0){

	  $(".imagesync21").on("click", ".owl-item", function(e){

		e.preventDefault();

		var number = $(this).data("owlItem");

		imagesync1.trigger("owl.goTo",number);

	  });

	 }

	  function center(number){

		var imagesync2visible = imagesync2.data("owlCarousel").owl.visibleItems;

		var num = number;

		var found = false;

		for(var i in imagesync2visible){

		  if(num === imagesync2visible[i]){

			var found = true;

		  }

		}

	 

		if(found===false){

		  if(num>imagesync2visible[imagesync2visible.length-1]){

			imagesync2.trigger("owl.goTo", num - imagesync2visible.length+2)

		  }else{

			if(num - 1 === -1){

			  num = 0;

			}

			imagesync2.trigger("owl.goTo", num);

		  }

		} else if(num === imagesync2visible[imagesync2visible.length-1]){

		  imagesync2.trigger("owl.goTo", imagesync2visible[1])

		} else if(num === imagesync2visible[0]){

		  imagesync2.trigger("owl.goTo", num-1)

		}

		

	  }

</script>