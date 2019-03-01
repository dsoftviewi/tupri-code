

<style>
  #slider {
    margin:0px auto;
    padding:0px;
  height:20px;
  overflow:hidden;
  }
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<?php 
include("core/session.php");
if (!isset($_SESSION['uid']))
{
include ("header.php"); 
include ("slider.php");
?>
 

        <section id="content" >
        <div class="search-box-wrapper" style="background-color:#FFF">
                <div class="search-box container">
                    <ul class="search-tabs clearfix">
                        <li class="active"><a href="#welcome" data-toggle="tab">Welcome</a></li>
                        <li><a href="#features" data-toggle="tab">Features</a></li>
                    </ul>
                    <div class="visible-mobile">
                       <ul class="tabs no-padding">

                        <li class="active"><a data-toggle="tab" href="#welcome"><i class="soap-icon-passenger"></i> About Us</a></li>   
                        <li><a data-toggle="tab" href="#features"><i class="soap-icon-wifi"></i> Features</a></li>
                    </ul>
                    </div> 
<?php 

$home= $conn->prepare("SELECT * FROM dvi_front_home where status='0'");
$home->execute();
$row_home = $home->fetch(PDO::FETCH_ASSOC);
$total_home = $home->rowCount();
?>                   
                    <div class="search-tab-content" style="background-color:#FFF; padding:10px" >
                        <div id="welcome" class="tab-pane fade in active">
                            <div class="sm-section clearfix">
                                <i class="soap-icon-passenger circle white-color skin-bg no-border pull-left" style="font-size: 54px; margin-right: 15px;"></i>
                                <div class="table-wrapper hidden-table-sm">
                                    <div class="table-cell" style="padding: 0 15px;">
                                        <h1><?php echo $row_home['welcome_heading'];?></h1>
                                        <p id="wel_desc_short"><?php echo substr($row_home['welcome_desc'],0,300)."...";?> </p>
                                        <p id="wel_desc_detailed" style="display:none;"><?php echo $row_home['welcome_desc'];?> </p>
                                    </div>
                                    <div class="table-cell content-middle" >
                             <a href="javascript:void(0);" class="button btn-large green pull-right" id="show_welcome" onclick="show_welcome()">Read More...</a>
                             <a href="javascript:void(0);" style="display:none;" class="button btn-large green pull-right" id="hide_welcome" onclick="hide_welcome()">Hide Details...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="features" class="tab-pane fade in">
                            <div class="sm-section clearfix">
                                <i class="soap-icon-passenger circle white-color skin-bg no-border pull-left" style="font-size: 54px; margin-right: 15px;"></i>
                                <div class="table-wrapper hidden-table-sm">
                                    <div class="table-cell" style="padding: 0 15px;">
                                        <h1><?php echo $row_home['feature_heading'];?></h1>
                                        <p id="feat_desc_short"><?php echo substr($row_home['feature_desc'],0,300)."...";?> </p>
                                        <p id="feat_desc_detailed" style="display:none;"><?php echo $row_home['feature_desc'];?> </p>
                                    </div>
                                    <div class="table-cell content-middle" >
                             <a href="javascript:void(0);" class="button btn-large green pull-right" id="show_feature" onclick="show_feature()">Read More...</a>
                             <a href="javascript:void(0);" style="display:none;" class="button btn-large green pull-right" id="hide_feature" onclick="hide_feature()">Hide Details...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php 
			
			$spots = $conn->prepare("SELECT * FROM hotspots_pro where trim(spot_images)!='' and status = 0 GROUP BY `spot_city` ORDER BY RAND() LIMIT 10");
			$spots->execute();
			$row_spots_main = $spots->fetchAll();
			$totalRows_spots = $spots->rowCount();
			?>
        <div class="" style="background-color:#FFF; margin-top:-80px">
    <div class="section" style="padding-bottom:0px;"> 
                <div class="container">
                    <h2>Recommended Tourist Place</h2>
                    <div class="block image-carousel style2 flexslider" data-animation="slide" data-item-width="270" data-item-margin="30" style="margin-bottom: 0px;">
                        <ul class="slides image-box listing-style2">
                        <?php
						foreach($row_spots_main as $row_spots)
						{
							$imgexp = explode(',',$row_spots['spot_images']);
							
							
							$city = $conn->prepare("SELECT * FROM dvi_cities where id=? and status = 0");
							$city->execute(array($row_spots[spot_city]));
							$row_city = $city->fetch(PDO::FETCH_ASSOC);
							$totalRows_city =$city->rowCount();
							
							if ($totalRows_city > 0)
							{
						?>
                            <li>
                                <article class="box">
                                    <figure>
                                        <a <?php echo 'href="core/ajax/hotspot_slide.php?'. http_build_query(array('cluster' => $imgexp)). '"'; ?> class="hover-effect popup-gallery"><img  src="img_upload/hot_spots/<?php echo $imgexp[array_rand($imgexp)]; ?>" alt="<?php echo $row_spots['spot_name']; ?>" style="height:200px; width:270px" /></a>
                                    </figure>
                                    <div class="details">
                                        <a href="hotspots_galary.php?cid=<?php echo $row_spots['spot_city'];?>&sid=<?php echo $row_spots['spot_state'];?>" title="View all" class="pull-right button uppercase">Read More...</a>
                                        <h4 class="box-title"><?php echo $row_city['name']; ?></h4>
                                        <label class="price-wrapper">
                                            <span class="price-per-unit">(<?php if (strlen($row_spots['spot_name']) <= 14) { echo $row_spots['spot_name']; } else { echo substr($row_spots['spot_name'],0,13).'..'; } ?>)</span>
                                        </label>
                                    </div>
                                </article>
                            </li>
                            <?php
							}
						}
							
							?>
                        </ul>
                    </div>
                   
<?php /*?>  <?php
  
   $query_itenarary= "SELECT * FROM travel_master where status='0' ORDER BY sno DESC LIMIT 5";
$itenarary= mysql_query($query_itenarary, $divdb) or die(mysql_error());
//$row_itenarary = mysql_fetch_assoc($itenarary);
$total_itenarary= mysql_num_rows($itenarary);
  
  ?>                  
                    
                    <div class="block row" style="margin-bottom: 2px;">
                        <div class="col-md-6">
                            <h2>Latest Activities</h2>
                            <div class="tab-container style1 box">
                                <ul class="tabs">
                                    <li class="active"><a href="#hot-hotel-popular" data-toggle="tab">Itinerary</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="hot-hotel-popular" style="height:200px;overflow:hidden">
                                    
                                    <marquee onmouseover="this.stop()"  onmouseout="this.start();" scrollamount="6" direction="up"  loop="true"  >
                                    <?php while($row_itenarary = mysql_fetch_assoc($itenarary)){
										$plan=substr($row_itenarary['plan_id'],0,2);
										?>
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <a href="javascript:void(0);" class="badge-container">
                                                <img class="full-width" src="images/flight_img.png" alt="flight" style="height:100px; width:100px;" /></a>
                                            </div>
                                            <div class="col-xs-8">
                                            <br />
                                            <?php
$arr1=array();
$r=0;

$query_tsched="select * from dvi_cities where name IN (SELECT tr_from_cityid FROM `travel_sched` WHERE travel_id='".$row_itenarary['plan_id']."' GROUP BY tr_from_cityid) GROUP BY region";
$tsched= mysql_query($query_tsched, $divdb) or die(mysql_error());
while($row_tsched = mysql_fetch_assoc($tsched))
{
	$query_stss="select name from dvi_states where code='".$row_tsched['region']."'";
$stss= mysql_query($query_stss, $divdb) or die(mysql_error());
$row_stss = mysql_fetch_assoc($stss);
$arr1[$r]=$row_stss['name'];
	$r++;
}
	$packages=implode('-',$arr1);											?>
                                                <h5 class="box-title"><?php echo $packages." Tour Package"; ?><small><?php 
												
												if($plan=='TH')
												{
													echo "Travel With Stay Itineray";
												}else if($plan=='T#')
												{
													echo "Travel Itineray";
												}
												?></small></h5>
                                                <p class="no-margin"><?php echo $row_itenarary['tr_days']." Days and ".$row_itenarary['tr_nights']." Nights"."<br>Booked on ".substr($row_itenarary['date_of_reg'],0,10); ?></p>
                                            </div>
                                            <div class="col-xs-2">
                                            <br />
<?php
	
$query_spots= "select COUNT(*) from hotspots_pro where spot_city IN (select id from dvi_cities where name IN (SELECT tr_from_cityid FROM `travel_sched` WHERE travel_id='".$row_itenarary['plan_id']."' GROUP BY tr_from_cityid))";
$spots= mysql_query($query_spots, $divdb) or die(mysql_error());
$row_spots = mysql_result($spots,0,0);

?>                                            
                                                <span class="price" style="text-align:center">Spots<br /><?php echo $row_spots." +"; ?></span>
                                                <br />
                                                <?php $aff=explode('#',$row_itenarary['plan_id']);?>
      <a class="btn btn-info btn-sm pull-right" href="tour_details.php?tid1=<?php echo $aff[0]; ?>&tid2=<?php echo $aff[1]; ?>">Details</a>
                                            </div>
                                        </div>
                                        <?php }?>
                                        
                                        </marquee>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        
<?php 

$query_fdbks = "SELECT * FROM dvi_front_feedback where status='0' ORDER BY sno DESC";
$fdbks = mysql_query($query_fdbks, $divdb) or die(mysql_error());
//$row_fdbks = mysql_fetch_assoc($fdbks);
$total_fdbks = mysql_num_rows($fdbks);
?>                        
                        <div class="col-md-6">
                            <h2>What Travelers Say?</h2>
                            <div class="testimonial style1 box">
                                <ul class="slides ">
                                <?php while($row_fdbks = mysql_fetch_assoc($fdbks)){?>
                                    <li>
                                        <p class="description"><?php echo $row_fdbks['feedback'];?></p>
                                        <div class="author clearfix">
                                            <a href="#"><img src="images/guest.jpg" alt="" width="74" height="74" /></a>
                                            <h5 class="name"><?php echo $row_fdbks['cname'];?> <small> guest</small></h5>
                                        </div>
                                    </li>
                                    <?php }?>
                                </ul>
                            </div>
                        </div>
                    </div><?php */?>
                </div>
            </div>
            
            </div>
        </section>
        <div class="col-sm-12" style="padding-bottom:15px">
        <img src="images/boat.jpg" alt="" width="100%" height="50%" />
        </div>
        <!--<div class="global-map-area promo-box no-margin parallax" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="content-section description pull-right col-sm-9">
                        <div class="table-wrapper hidden-table-sm">
                            <div class="table-cell">
                                <h2 class="m-title">
                                    Experienced DVI travel!<br /><em>Share Your Amazing DVI Experience With Your Friends..</em>
                                </h2>  
                            </div>
                            <div class="action-section table-cell">
                                
                            </div>
                        </div>
                    </div>
                    <div class="image-container col-sm-4">
                        <img src="images/promo-image3.png" alt="" width="376" height="255" />
                    </div>
                </div>
            </div>-->
            
          
       <?php include"footer.php";?>
     
<?php
}
else
{
	header("Location: ".$_SESSION['setmmsm']);
}
?>
<script>

function show_welcome()
{
	document.getElementById('show_welcome').style.display='none';
		document.getElementById('hide_welcome').style.display='block';
			document.getElementById('wel_desc_short').style.display='none';
				document.getElementById('wel_desc_detailed').style.display='block';
}

function hide_welcome()
{
	document.getElementById('show_welcome').style.display='block';
		document.getElementById('hide_welcome').style.display='none';
			document.getElementById('wel_desc_short').style.display='block';
				document.getElementById('wel_desc_detailed').style.display='none';
}

function show_feature()
{
	document.getElementById('show_feature').style.display='none';
		document.getElementById('hide_feature').style.display='block';
			document.getElementById('feat_desc_short').style.display='none';
				document.getElementById('feat_desc_detailed').style.display='block';
}

function hide_feature()
{
	document.getElementById('show_feature').style.display='block';
		document.getElementById('hide_feature').style.display='none';
			document.getElementById('feat_desc_short').style.display='block';
				document.getElementById('feat_desc_detailed').style.display='none';
}
</script>