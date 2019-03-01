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
$seo = $conn->prepare("SELECT * FROM seo_settings_new where type='CON'");
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
require_once('COMMN/smsfunc.php');
require_once('Connections/divdb.php');
$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
if(isset($_POST['contact_mails']) && $_POST['contact_mails']=='contact_mails_val')
{

	$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Registration status</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';><tr><td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'><span style='margin-top:20px; padding-top:30px'>Your request is accepted</span></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td></tr><tr align='center'><td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: green;'>Director</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p><span style='color:blue'>Name : ".$_POST['name']." </span><br> Subject :".$_POST['subject']." <br> Email ID :".$_POST['email']." <br> Website :".$_POST['website']." <br> Message :".$_POST['message']." <br> This mail came from our website ( dvi.co.in ).</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'><tr><td width='244'>[DVI Administrator]</td></tr><tr><td>DoView Holidays India Pvt. Ltd.</td></tr></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px; font-weight: bold; color: #CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in'>support@dvi.co.in</a>.</p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><br /><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px; font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DoView Holidays Private Limited. All rights reserved.</span></td></tr></table></body></html>";
	
	
$contact= $conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$contact->execute();
$row_contact = $contact->fetch(PDO::FETCH_ASSOC);
$total_contact= $contact->rowCount();
	
	$to=$row_contact['email'];
	//$to ='vsr@v-i.in';
	//$to ='pco@elysiumservices.info';<br />
    //$to='dinaece@gmail.com';
	//$to='info@elysiumservices.info';
	$from = $_POST['email']; 
	$subject=$_POST['subject'];
	$str=send_mail($to,$from,$subject,$stringData);
	
	echo "<script>alert('Your Request Successfully Sent To Our Director.')</script>";
	
}

?>


<div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">Contact Us</h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="index.php">HOME</a></li>
                    <li class="active">Contact Us</li>
                </ul>
            </div>
        </div>
       <div class=" full-box travelo-google-map"></div>
        <section id="content" class="white-bg">
            <div class="container">
                <div id="main" style="border:2px solid rgb(97, 166, 210); margin-bottom:20px;" >
                    <div class="col-md-9 no-float no-padding center-block"  style="margin-bottom:30px" >
                        <div class="intro text-center block">
                            <h2 style="color:rgb(9, 84, 149)">Send us a Message</h2>
                            <p style="color:rgb(10, 77, 152); font-weight:600">
Please contact us for any queries on your itinerary and we will reach you back with best possible quote as soon as possible.</p>
                        </div>
                         <form class="contact-form" method="post">
                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <label style="color:rgb(251, 47, 97); font-weight:600;">Your Name</label>
                                    <input type="text" name="name" class="input-text full-width">
                                </div>
                                <div class="col-xs-6">
                                    <label style="color:rgb(251, 47, 97); font-weight:600;">Your Email</label>
                                    <input type="text" name="email" class="input-text full-width">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <label style="color:rgb(251, 47, 97); font-weight:600;">Subject</label>
                                    <input type="text" name="subject" class="input-text full-width">
                                </div>
                                <div class="col-xs-6">
                                    <label style="color:rgb(251, 47, 97); font-weight:600;">Website</label>
                                    <input type="text" name="website" class="input-text full-width">
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color:rgb(251, 47, 97); font-weight:600;">Your Message</label>
                                <textarea name="message" rows="6" class="input-text full-width" placeholder="write message here"></textarea>
                            </div>
                            <button type="submit" name="contact_mails" value="contact_mails_val" class="btn-large full-width">SEND MESSAGE</button>
                           
                        </form>
                    </div>
                </div>
            </div>
            
 <?php 
$contact= $conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$contact->execute();
$row_contact = $contact->fetch(PDO::FETCH_ASSOC);
$total_contact= $contact->rowCount();
if($total_contact>0)

?>
            <div class=" section contact-details parallax" data-stellar-background-ratio="0.5"  style="background-color:rgb(45, 72, 90)">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-box style10 phone">
                                <i class="soap-icon-phone"></i>
                                <small>We are on 24/7</small>
                                <h4 class="box-title"><?php echo "<br>".$row_contact['phone'];?></h4>
                                <p class="description"><?php echo $row_contact['phone_desc'];?></p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="icon-box style10 email">
                                <i class="soap-icon-message"></i>
                                <small>Send us email on</small>
                                <h4 class="box-title"><?php echo "<br>".$row_contact['email'];?></h4>
                                <p class="description"><?php echo $row_contact['email_desc'];?></p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="icon-box style10 address">
                                <i class="soap-icon-address"></i>
                                <small>Meet us now</small>
                                <h4 class="box-title"><?php echo $row_contact['location'];?></h4>
                                <p class="description"><?php echo $row_contact['location_desc'];?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
<?php include"footer.php";?>
     <script type="text/javascript">
 var infowindow = new google.maps.InfoWindow();
        tjq(".travelo-google-map").gmap3({
			
            map: {
                options: {
                    center: [10.797696, 78.658312],
                    zoom: 12
                }
            },
            marker:{
                values: [
                    {latLng:[10.797696, 78.658312],
					}
                ],
            }
        }
		
		);
		
    </script>
    
