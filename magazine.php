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
$seo = $conn->prepare("SELECT * FROM seo_settings_new where type='FAQ'");
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
<?php //include_once("analyticstracking.php") ?>
<?php 
include "header.php";
?>
<div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">Magazine</h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="index.php">HOME</a></li>
                    <li class="active">Magazine</li>
                </ul>
            </div>
        </div>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-12">
                            <div class="travelo-box question-list">
                                <div class="toggle-container">
                                    <!--<div class="panel style1">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tgg1" class="collapsed">How do I edit my listing?</a>
                                        </h4>
                                        <div id="tgg1" class="panel-collapse collapse">
                                            <div class="panel-content">
                                                
                                            </div>
                                        </div>
                                    </div>-->
                                    <style>.embed-container { position: relative; padding-bottom:70%; height:0; overflow: hidden; max-width: 100%; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%;}</style><div class='embed-container' data-page-width='449' data-page-height='640' id='ypembedcontainer' ><iframe   src="https://www.yumpu.com/xx/embed/view/kMSAd6CTqraowenX" frameborder="0" allowfullscreen="true"  allowtransparency="true"></iframe></div><script src='https://players.yumpu.com/modules/embed/yp_r_iframe.js' ></script>
					
                                   
                                    
                                   <!-- <div class="panel style1">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tgg3" class="collapsed">How can I manage Instant Book settings? </a>
                                        </h4>
                                        <div id="tgg3" class="panel-collapse collapse">
                                            <div class="panel-content">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel style1">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tgg4" class="collapsed">How do I list multiple rooms? </a>
                                        </h4>
                                        <div id="tgg4" class="panel-collapse collapse">
                                            <div class="panel-content">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel style1">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tgg5" class="collapsed">How do I use my calendar? </a>
                                        </h4>
                                        <div id="tgg5" class="panel-collapse collapse">
                                            <div class="panel-content">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel style1">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tgg6" class="collapsed">How do I edit my calendar? </a>
                                        </h4>
                                        <div id="tgg6" class="panel-collapse collapse">
                                            <div class="panel-content">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel style1">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tgg7" class="collapsed">Why was my listing deactivated? </a>
                                        </h4>
                                        <div id="tgg7" class="panel-collapse collapse">
                                            <div class="panel-content">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel style1">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#tgg8" class="collapsed">How do I turn off or delete my listing? </a>
                                        </h4>
                                        <div id="tgg8" class="panel-collapse collapse">
                                            <div class="panel-content">
                                                
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>

                        </div>
                    
                    <?php //include"sidebar.php";?>
                </div>
            </div>
        </section>
<?php include"footer.php";?>
    
    

