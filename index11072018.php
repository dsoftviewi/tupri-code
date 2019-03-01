<?php 

 require_once('Connections/divdb.php');
//include("COMMN/smsfunc.php");
$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$mon=$date->format('F');
$dd=$date->format('m/d/Y');
?>
<!DOCTYPE html>
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->
<head>
<meta name="google-site-verification" content="0vbHDVicRqeDtkXXOs4jaMvyNtMV5h8z0iAUz8aDCys" />

    <!-- Page Title -->
<title>DVI Holidays : Travel Agency : Tourism</title>
 <META NAME="Title" CONTENT="DVI Holidays : Travel Agency : Tourism">
<META NAME="Keywords" CONTENT="travel agencies in trichy, tour operators in trichy, tour packages for south india, tourist vehicle Operator in trichy, trichy travel agents, travel company in trichy,">
<META NAME="Description" CONTENT="DVI is a leading tours and trvels in trichy,tour operators in trichy,tour packages for south india,tourist vehicle Operator in trichy, ">
<META NAME="Subject" CONTENT="travel agencies in trichy">
<META NAME="Language" CONTENT="English">
<META NAME="Robots" CONTENT="INDEX,NOFOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Theme Styles -->
    <link rel="stylesheet" href="core/css/bootstrap.min.css">
    <link rel="stylesheet" href="core/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="core/css/animate.min.css">
    <!-- Current Page Styles -->
    <link rel="stylesheet" type="text/css" href="core/components/revolution_slider/css/settings.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="core/components/revolution_slider/css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="core/components/jquery.bxslider/jquery.bxslider.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="core/components/flexslider/flexslider.css" media="screen" />
    <!-- Main Style -->
    <link id="main-style" rel="stylesheet" href="core/css/style.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="core/css/custom.css">
    <!-- Updated Styles -->
    <link rel="stylesheet" href="core/css/updates.css">
    <link rel="shortcut icon" href="images/logo2.png" type="image/x-icon">
    <!-- Responsive Styles -->
    <link rel="stylesheet" href="core/css/responsive.css">
     <script type="text/javascript" src="core/js/jquery-1.11.1.min.js"></script>
     <script src="core/assets/js/jquery.min.js"></script>
       <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-82115299-1', 'auto');
  ga('send', 'pageview');

</script> 
</head>
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
 <?php //include_once("analyticstracking.php") ?>

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
$home=$conn->prepare("SELECT * FROM dvi_front_home where status='0'");
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
			//$row_spots = $spots->fetch(PDO::FETCH_ASSOC);
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
							$city->execute(array($row_spots['spot_city']));
							$row_city = $city->fetch(PDO::FETCH_ASSOC);
							$totalRows_city = $city->rowCount();
							
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
                   

                </div>
            </div>
            
            </div>
        </section>
        <div class="col-sm-12" style="padding-bottom:15px">
        <img src="images/boat.jpg" alt="tour operators in trichy" title="travel agencies in trichy" width="100%" height="50%" />
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
<div class="modal fade in" id="modalAds1" tabindex="-1" role="dialog" aria-hidden="true" style="display:block">
<div class="modal-dialog" style="width:51%">
<div class="modal-header bg-info no-border" style="background-color:rgb(237, 238, 239);padding:20px;border-radius:10px">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clscls()">&times;</button>

<!-- <div id="myElement">Loading the player...</div> -->
<script type="text/javascript">
/*var playerInstance = jwplayer("myElement");
playerInstance.setup({
file: "https://www.youtube.com/watch?v=j2sSojSFBxY?autoplay=1",
width: 640,
height: 360,
autostart: true,
});*/
</script>
<iframe width="640" height="360" src="https://www.youtube.com/embed/j2sSojSFBxY?autoplay=1&rel=0&showinfo=0">
</iframe>
<!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/j2sSojSFBxY?autoplay=1" frameborder="0"  allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe> -->
<!-- <video  controls="controls" poster="" width="100%" height="100%" autoplay>
    <source src="Alumini Video.mp4" type="video/mp4" />
    <object type="application/x-shockwave-flash" data="ADMIN/videos/flowplayer-3.2.1.swf" width="640" height="360">
        <param name="movie" value="ADMIN/videos/flowplayer-3.2.1.swf" />
        <param name="allowFullScreen" value="true" />
        <param name="wmode" value="transparent" />        
    
    </object>
</video> -->
</div>
</div><!-- /.modal-dialog -->
</div>
<?php
}
else
{
	header("Location: ".$_SESSION['setmmsm']);
}
?>
<script>
    // this script required for subscribe modal
   function clscls(){
       
      $('#modalAds1').hide();
      $("body").removeClass("modal-open");
  $("#veopn").show();

   }
</script>
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
