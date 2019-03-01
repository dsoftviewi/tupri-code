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
$seo = $conn->prepare("SELECT * FROM seo_settings_new where type='ABOUT'");
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
?>
<div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">About Us</h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="index.php">HOME</a></li>
                    <li class="active">About Us</li>
                </ul>
            </div>
        </div>
        <section id="content">
            <div class="container">
            <?php
			 
 //hotspots
$spots= $conn->prepare("select COUNT(*) as cnt from  hotspots_pro where status='0'");
$spots->execute();
$row_spots_main = $spots->fetch(PDO::FETCH_ASSOC);
$row_spots = $row_spots_main['cnt'];
 
 //hotels
$hotel=$conn->prepare("select COUNT(*) as cnt from hotel_pro where status='0'");
$hotel->execute();
$row_hotel_main = $hotel->fetch(PDO::FETCH_ASSOC);
$row_hotel = $row_hotel_main['cnt'];

//city
$city=$conn->prepare("select COUNT(*) as cnt from dvi_cities where status='0'");
$city->execute();
$row_city_main = $city->fetch(PDO::FETCH_ASSOC);
$row_city = $row_city_main['cnt'];

//vehicle
$vehicle=$conn->prepare("select COUNT(*) as cnt from vehicle_pro where status='0'");
$vehicle->execute();
$row_vehicle_main = $vehicle->fetch(PDO::FETCH_ASSOC);
$row_vehicle = $row_vehicle_main['cnt'];
			?>
            
            <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="icon-box style3 counters-box">
                                    <div class="numbers">
                                        <i class="soap-icon-places yellow-color"></i><br><br>
                                        <span class="display-counter" data-value="<?php echo $row_spots; ?>"><?php echo $row_spots; ?></span>
                                    </div>
                                    <div class="description">Amazing Places To Visit</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="icon-box style3 counters-box">
                                    <div class="numbers">
                                        <i class="soap-icon-hotel blue-color"></i><br><br>
                                        <span class="display-counter" data-value="<?php echo $row_hotel; ?>"><?php echo $row_hotel; ?></span>
                                    </div>
                                    <div class="description">Star Hotels To Stay</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="icon-box style3 counters-box">
                                    <div class="numbers">
                                        <i class="soap-icon-beach green-color"></i><br><br>
                                        <span class="display-counter" data-value="<?php  echo $row_city; ?>"><?php  echo $row_city; ?></span>
                                    </div>
                                    <div class="description">Cities To Travel </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="icon-box style3 counters-box">
                                    <div class="numbers">
                                        <i class="soap-icon-car red-color"></i><br><br>
                                        <span class="display-counter" data-value="<?php echo $row_vehicle; ?>"><?php echo $row_vehicle; ?></span>
                                    </div>
                                    <div class="description">VIP Transport Options</div>
                                </div>
                            </div>
                        </div>
            
            
                <div class="row">
                    <div id="main" class="col-sm-8 col-md-9">
                        <div class="image-style style1 box" >
                        <?php 
$aboutus =$conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$aboutus->execute();
$row_aboutus = $aboutus->fetch(PDO::FETCH_ASSOC);
$total_aboutus = $aboutus->rowCount();
if($total_aboutus>0)
{
						?>
                        
                            <!--<ul class="image-block column-3 pull-left clearfix">
                                <li><img class="middle-item" src="images/author3.jpg" alt="" width="136" height="98" /></li>
                            </ul>-->

							<center><img src="images/about-us.jpg" alt="tourist vehicle Operator in trichy" title="travel agencies in trichy" style="height:140px; width:800px;"></center>
                            <br>
                          <!--  <h1>About Us!</h1>-->
                            
                            <p style="margin-left:25px; text-align:justify;"><?php echo $row_aboutus['aboutus'];?></p>
                            <!--<div class="clearfix"></div>-->
                        </div>
                        
                        <div class="row">
                         <div id="main" class="col-sm-12 col-md-12">
                                <div class="tab-container box">
                                    <ul class="tabs">
                                        <li ><a href="#satisfied-customers" data-toggle="tab">Our Vision</a></li>
                                        <li class="active"><a href="#tours-suggestions" data-toggle="tab">Our Mission</a></li>
                                        <li><a href="#careers" data-toggle="tab">Our Services</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade" id="satisfied-customers">
                                            <h4>DVI Vision</h4>
                                            <p style="text-align:justify;"><?php echo $row_aboutus['vision'];?></p>
                                        </div>
                                        <div class="tab-pane fade in active" id="tours-suggestions">
                                            <h4>DVI Mission</h4>
                                            <p style="text-align:justify;"><?php echo $row_aboutus['mission'];?></p>
                                        </div>
                                        <div class="tab-pane fade" id="careers">
                                            <h4>DVI Services</h4>
                                            <p style="text-align:justify;"><?php echo $row_aboutus['services'];?></p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                
                            </div>
                        
 <?php }else{?>
 <div class="row">
 <center><img src="images/logo.png" alt="tourist vehicle Operator in trichy" title="travel agencies in trichy" width="100px" height="100px;"></center>
 <br><br><center><strong style="color:#CCC; font-size:24px;"> Under Processing...</strong></center>
 </div>
 <?php }

 
 ?>
                        
                        
                    </div>
                    
                    <?php include"sidebar.php";?>
                </div>
            </div>
        </section>
<?php include"footer.php";?>
    
    

