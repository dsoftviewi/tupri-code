<?php
error_reporting(0);
$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');

?>
<style type="text/css">
	
      .title-head {
            
        font-size:20px;
        font-weight:bold;
        text-align:center;
        /*background-color:rgba(43, 54, 60, 0.6);
*/		color:#687477;
	  	margin: 0 0 15px;
    	font-weight: normal;
    	color: #2d3e52;
        padding:5px;
       
      }
      .feeds-links {
        text-align:left;
        padding:5px;
       /* border:1px solid #dedede;*/
      }
       
	   hr {
    margin-top: 10px;
    margin-bottom: 10px;
    border-color: #f5f5f5;
}
       
    </style>
      <div class="col-sm-12" style="background-color:rgba(212, 212, 212, 0.98); color:#383735; font-family:Verdana, Geneva, sans-serif; font-weight:600; border-top:#B9B8B7 2px solid ">
<footer id="footer">
            <div class="footer-wrapper" style="padding:15px;">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-3" >
                            <h2 style=" color:#0950AB">&nbsp;&nbsp;Quick Links</h2>
                            <ul class="discover triangle hover row">
                                <li class="col-xs-6"><a href="index.php">Home</a></li>
                                <li class="col-xs-6"><a href="about.php">About</a></li>
                                <li class="col-xs-6"><a href="gallery.php">Gallery</a></li>
                                <li class="col-xs-6"><a href="faq.php">FAQ</a></li>
                                <li class="active col-xs-6"><a href="contact.php">Contact Us</a></li>
                            </ul>
                                               <!--  <br />       <img src="images/front/links.png" style="width:200px; height:75px;" />-->
                            <br />
                           <ul class="social-icons clearfix" style="margin-left:40px;">
                                <li class="googleplus "><a title="googleplus" href="https://plus.google.com/105116048533698225174/about?hl=en" data-toggle="tooltip" target="_blank" style="background:#F00"><i class="soap-icon-googleplus"></i></a></li>
                                <li class="facebook"><a title="facebook" href="https://www.facebook.com/pages/Dvi-Holidays/498114133655654" data-toggle="tooltip" target="_blank" style="background:#09F"><i class="soap-icon-facebook"></i></a></li>
                                <li class="linkedin"><a title="linkedin" href="https://in.linkedin.com/pub/dvi-holidays/28/582/261" data-toggle="tooltip" target="_blank" style="background:#093"><i class="soap-icon-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <!--<h2>Travel News</h2>-->
                            <ul class="travel-news">
                                <li>
                                <div>
                                 <?php
								 //http://feeds.feedburner.com/travelnews/dvi?format=xml
  include('rssclass.php');
  $feedlist = new rss('http://feeds.feedburner.com/travelnews/dvi');
  echo $feedlist->display(5,"Travel Feeds ");
  
  
  ?> 
                                  </div>
                                </li>
                              
                            </ul>
                        </div>
                       
                        <?php
$contact= $conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$contact->execute();
$row_contact = $contact->fetch(PDO::FETCH_ASSOC);
$total_contact= $contact->rowCount();
						?>
                        <div class="col-sm-6 col-md-3">
                            <h2 style=" color:#0950AB">About DVI Holidays</h2>
                            <p><?php echo substr($row_contact['aboutus'],0,90)."..."; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="about.php" class="btn btn-info btn-sm">More</a></p>
                          
                            <address class="contact-details">
                                <span class="contact-phone"><i class="soap-icon-phone"></i>&nbsp;&nbsp;&nbsp;<?php echo $row_contact['phone'];?></span>
                                <br />
                                <span class="contact-phone " style="margin-left:-25px"><a href="contact.php" class="contact-email"><i class="soap-icon-generalmessage" style="font-size:30px;"></i>&nbsp;&nbsp;&nbsp;<strong style="color:#465567;"><?php echo $row_contact['email'];?></strong></a></span>
                            </address>
                            <!--<ul class="social-icons clearfix">
                               <li class="twitter"><a title="twitter" href="#" data-toggle="tooltip"><i class="soap-icon-twitter"></i></a></li>
                                <li class="googleplus"><a title="googleplus" href="https://plus.google.com/105116048533698225174/about?hl=en" data-toggle="tooltip" target="_blank" style="background:#F00"><i class="soap-icon-googleplus"></i></a></li>
                                <li class="facebook"><a title="facebook" href="https://www.facebook.com/pages/Dvi-Holidays/498114133655654" data-toggle="tooltip" target="_blank"><i class="soap-icon-facebook"></i></a></li>
                                <li class="linkedin"><a title="linkedin" href="https://in.linkedin.com/pub/dvi-holidays/28/582/261" data-toggle="tooltip" target="_blank"><i class="soap-icon-linkedin"></i></a></li>
                              <li class="vimeo"><a title="vimeo" href="#" data-toggle="tooltip"><i class="soap-icon-vimeo"></i></a></li>
                                <li class="dribble"><a title="dribble" href="#" data-toggle="tooltip"><i class="soap-icon-dribble"></i></a></li>
                            <li class="flickr"><a title="flickr" href="#" data-toggle="tooltip"><i class="soap-icon-flickr"></i></a></li>
                            </ul>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom gray-area" style=" background-color:#DFE3E6; color:#285A86">
                <div class="container" >
                    <div class="pull-left">
                        <a href="index.php" title="Logo">
                            <img src="images/logo.png" alt="tour packages for south india" title="travel agencies in trichy" style="height:54px" />
                        </a>
                    </div>
                    
                    <div class="pull-right">
                     <a id="back-to-top" href="#" class="animated" data-animation-type="bounce"><i class="soap-icon-longarrow-up circle"></i></a>
                    </div>
                    <div class="copyright" align="center">
                        <font>&copy; <?php echo $yy; ?> DoView Holidays, All Rights Reserved.</font>
                    </div>
                </div>
            </div>
        </footer>
        </div>
    </div>
    

    <!-- Javascript -->
   
               <!-- my edit on 02-dec-2015 start -->
     
  
          
	<script type="text/javascript" src="core/js/jquery.noconflict.js"></script>
    <script type="text/javascript" src="core/js/modernizr.2.7.1.min.js"></script>
    <script type="text/javascript" src="core/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="core/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="core/js/jquery-ui.1.10.4.min.js"></script>
    
    <script type="text/javascript" src="core/js/theme-scripts.js"></script>
<!-- my edit on 02-dec-2015 end -->   
    
    <!-- Twitter Bootstrap -->
    <script type="text/javascript" src="core/js/bootstrap.js"></script>
    
    <!-- load revolution slider scripts -->
    <script type="text/javascript" src="core/components/revolution_slider/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="core/components/revolution_slider/js/jquery.themepunch.revolution.min.js"></script>
    
    <!-- load BXSlider scripts -->
    <script type="text/javascript" src="core/components/jquery.bxslider/jquery.bxslider.min.js"></script>
    
    <!-- load FlexSlider scripts -->
    <script type="text/javascript" src="core/components/flexslider/jquery.flexslider-min.js"></script>
    
    <!-- Google Map Api -->
    <script type='text/javascript' src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
    <script type="text/javascript" src="core/js/gmap3.min.js"></script>
    <!-- parallax -->
    <script type="text/javascript" src="core/js/jquery.stellar.min.js"></script>
    <!-- waypoint -->
    <script type="text/javascript" src="core/js/waypoints.min.js"></script>
    <!-- load page Javascript -->
   <!-- <script type="text/javascript" src="core/js/theme-scripts.js"></script>-->
   <script src="core/assets/plugins/fancybox/lib/jquery-1.8.2.min.js"></script>
        <link href="core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
<script src="core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
        <script src="core/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>  
    <script type="text/javascript" src="core/js/scripts.js"></script>
    <script type="text/javascript">
        tjq(document).ready(function() {
            tjq('.revolution-slider').revolution(
            {
                dottedOverlay:"none",
                delay:9000,
                startwidth:1300,
                startheight:450,
                onHoverStop:"on",
                hideThumbs:10,
                fullWidth:"on",
                forceFullWidth:"on",
                navigationType:"none",
                shadow:0,
                spinner:"spinner4",
                hideTimerBar:"on",
            });
        });
    </script>
<?php 
$seo_script = $conn->prepare("SELECT * FROM seo_settings");
$seo_script->execute();
$row_seo_script = $seo_script->fetch(PDO::FETCH_ASSOC);
$totalRows_seo_script = $seo_script->rowCount();

if($totalRows_seo_script>0)
{
    echo "<script>".$row_seo_script['scripts']."</script>";

}
?>

</body>
</html>