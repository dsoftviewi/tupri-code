   <?php require_once('Connections/divdb.php');
include("COMMN/smsfunc.php");

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
<?php
$seo = $conn->prepare("SELECT * FROM seo_settings_new where type='GAL'");
$seo->execute();
$row_seo = $seo->fetch(PDO::FETCH_ASSOC);
$totalRows_seo = $seo->rowCount();
?>
    <!-- Meta Tags -->
    <meta charset="utf-8">
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

<?php include_once("analyticstracking.php") ?>
      <?php 
include "header.php";

$htspots = $conn->prepare("SELECT * FROM hotspots_pro where status='0' GROUP BY spot_state ASC");
$htspots->execute();
//$row_htspots = mysql_fetch_assoc($htspots);
$row_htspots_main=$htspots->fetchAll();
$total_htspots = $htspots->rowCount();

?>

        <div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">Gallery</h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="index.php">HOME</a></li>
                    <li class="active">Gallery</li>
                </ul>
            </div>
        </div>

        <section id="content">
            <div class="container">
                <div id="main">
                    <div class="gallery-filter box">
                     <a href="#" class="button btn-medium active" data-filter="filter-all">All</a>
                    <?php
					$states_arr=array();
					$s=0;
					 foreach($row_htspots_main as $row_htspots) {
						
$sts = $conn->prepare("SELECT * FROM dvi_states where code =?");
$sts->execute(array($row_htspots['spot_state']));
$row_sts = $sts->fetch(PDO::FETCH_ASSOC);
$total_sts = $sts->rowCount();


					if($total_sts>0)	{?>
                     <a href="#" class="button btn-medium" data-filter="filter-<?php echo $row_htspots['spot_state']; ?>">
					 <?php echo $row_sts['name'];?></a>
                    <?php
					$states_arr[$s]=$row_htspots['spot_state'];
					$s++;
					}// if end
					}//while end 
					//print_r($states_arr); ?>
                  
                    </div>
                    <div class="items-container isotope image-box style9 row">
                    
                    
                    <?php
					
					foreach($states_arr as $stsa)
					{
						//for default limit-12 images initially
						//mysql_select_db($database_divdb, $divdb);
						if(isset($_GET['more']) && $_GET['more']=='more')
						{
 $hot = $conn->prepare("SELECT * FROM hotspots_pro where status='0' and spot_images != '' and spot_state=?");							
						}else{
 $hot = $conn->prepare("SELECT * FROM hotspots_pro where status='0' and spot_images != '' and spot_state=? LIMIT 12");
						}
$hot->execute(array($stsa));
//$row_hot = mysql_fetch_assoc($hot);
$row_hot_main=$hot->fetchAll();
$total_hot= $hot->rowCount();

$sts_name = $conn->prepare("SELECT * FROM dvi_states where code =?");
$sts_name->execute(array($stsa));
$row_sts_name = $sts_name->fetch(PDO::FETCH_ASSOC);
$total_sts_name = $sts_name->rowCount();

						foreach($row_hot_main as $row_hot)
						{ 
								$spot_arr=explode(',',$row_hot['spot_images']);
$cty = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$cty->execute(array($row_hot['spot_images']));
$row_cty = $cty->fetch(PDO::FETCH_ASSOC);
						?>
                        
						<div class="iso-item col-xs-12 col-sms-6 col-sm-6 col-md-3 filter-all filter-<?php echo $stsa; ?> filter-beach">
                            <article class="box">
                                <figure>
                                 
                                     <a <?php echo 'href="core/ajax/hotspot_slide.php?'. http_build_query(array('cluster' => $spot_arr)). '"'; ?> class="hover-effect popup-gallery">
                                     <img src="img_upload/hot_spots/<?php echo $spot_arr[array_rand($spot_arr)]; ?>" alt="tour packages for south india" title="travel agencies in trichy" style="height:130px;" /></a>
                                  
                                </figure>
                                <div class="details">
                                    <h4 class="box-title"><?php echo $row_hot['spot_name'];?><small><?php echo $row_cty['name']; ?>, <?php echo $row_sts_name['name']; ?></small></h4>
                                </div>
                            </article>
                        </div>	
							
						<?php }
					}
					
					?>
                   
                    </div>
                    <?php 
					if(!isset($_GET['more']))
						{
					?>
                     <a href="gallery.php?more=more" class="button uppercase full-width btn-large box">load more collection</a>
                     <?php }?>
                  
                </div>
            </div>
        </section>
<?php include"footer.php";?>
    <!-- Dh n Twitter Bootstrap -->
 <!-- <script type="text/javascript" src="core/js/jquery-1.11.1.min.js"></script>-->
   <script type="text/javascript" src="core/js/jquery.noconflict.js"></script>
    <script type="text/javascript" src="core/js/modernizr.2.7.1.min.js"></script>
    <script type="text/javascript" src="core/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="core/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="core/js/jquery-ui.1.10.4.min.js"></script>
    
    <!-- Twitter Bootstrap -->
    <script type="text/javascript" src="core/js/bootstrap.js"></script>
    
    <!-- parallax -->
    <script type="text/javascript" src="core/js/jquery.stellar.min.js"></script>
    
    <!-- waypoint -->
    <script type="text/javascript" src="core/js/waypoints.min.js"></script>

    <!-- Isotope -->
    <script type="text/javascript" src="core/js/isotope.pkgd.min.js"></script>

    <!-- load page Javascript -->
    <script type="text/javascript" src="core/js/theme-scripts.js"></script>
    <script type="text/javascript" src="core/js/scripts.js"></script>
 


<!-- Mirrored from www.soaptheme.net/html/travelo/pages-photogallery-4column.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 27 Mar 2015 10:40:42 GMT -->
</html>

