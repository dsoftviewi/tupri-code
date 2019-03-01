<?php 
//===================17-08-2016 by junior Developer A Ganeshkumar=============
require_once('Connections/divdb.php');
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
    <!-- Page Title -->
<title>DVI Holidays : Travel Agency : Tourism</title>
<?php
$seo = $conn->prepare("SELECT * FROM seo_settings_new where type='DOM'");
$seo->execute();
$row_seo = $seo->fetch(PDO::FETCH_ASSOC);
$totalRows_seo = $seo->rowCount();
?>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <?php if($totalRows_seo >0){ ?>
  <meta name="keywords" content="<?php echo $row_seo['keywords']; ?>" />
  <meta name="description" content="<?php echo $row_seo['description']; ?>">
        
    <meta name="author" content="<?php echo $row_seo['author']; ?>">
    <?php } ?>
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
     
</head><?php 
include "header.php";

$_GET['id']=2;
if(isset($_GET['more']) && $_GET['more']=='more')
{
	$package = $conn->prepare("SELECT * FROM dvi_packages where status='0' and sno=? and pack_grp='DI' ORDER BY pack_prior ASC");
}else{
	$package = $conn->prepare("SELECT * FROM dvi_packages where status='0' and sno=? and pack_grp='DI' ORDER BY pack_prior ASC LIMIT 10");
}
$package->execute(array($_GET['pack_id']));
$row_package = $package->fetch(PDO::FETCH_ASSOC);
$total_package = $package->rowCount();
?>
<style type="text/css">
.fancybox-overlay{display: none!important;}
#fancybox-loading{display: none;}
.full-width{width:50px}
.button, a.button {padding:0px;}
.button.btn-small, a.button.btn-small {padding:0px;}
</style>
<div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">Domestic Itineraries - Packages</h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="index.php">HOME</a></li>
                    <li class="active">Domestic Itineraries</li>
                </ul>
            </div>
        </div>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-9" style="margin-top:-27px">
                          
                            <div class="hotel-list listing-style3 hotel">
                               <article class="box">
                                
                                  <?php if(strpos($row_package['day_title'],'~')){ 
                                     $exdaytitle=explode('~',$row_package['day_title']);
                                     $expackdesc=explode('~',$row_package['p_d']);
                                     $expackimg=explode('~',$row_package['pack_img']);
                                     $expacklocatg=explode('~',$row_package['day_locat']);
                                     $i=0;
                                    while($i<count($exdaytitle)){
                                    ?>
                                    <div class="row">
                                     <figure class="col-sm-5 col-md-4">
<a <?php echo 'href="core/ajax/packages_slide.php?'. http_build_query(array('cluster' => $expackimg[$i])). '"'; ?> class="hover-effect popup-gallery">
  <img src="packages/images/<?php echo $expackimg[$i]; ?>" alt="Image" style="height:170px; width:290px" /></a>                                     
                                    </figure>
                                    <div class="details col-sm-7 col-md-8" <?php if($i!=0) { ?>style="width:480px!important;"<?php } ?> >
                                        <div>
                                            <div>
                      <table width="100%">
                                <tr>
                                    <td width="65%">
                                        <h4 class="box-title"><?php
                                        if(strlen(trim($exdaytitle[$i]))>40)
                                        {?>
                                            <span data-toggle="tooltip" title="<?php echo $exdaytitle[$i]; ?>"><?php echo substr($exdaytitle[$i],0,40).".."; ?></span>
                                        <?php }else{
                                         echo trim($exdaytitle[$i]); } ?><small style="color: rgb(186, 132, 22);font-weight: 600;"><i class="soap-icon-departure yellow-color"></i>&nbsp; <?php
                                        if(strlen(trim($expacklocatg[$i]))>43)
                                        {?>
                                            <span data-toggle="tooltip" title="<?php echo $expacklocatg[$i]; ?>"><?php echo substr($expacklocatg[$i],0,43).".."; ?></span>
                                        <?php }else{
                                         echo trim($expacklocatg[$i]); } ?>
                                         </small></h4>
                                     </td>
                                     <?php 
                                            if($i==0){
                                             ?>
                                     <td width="35%"><span class="price"></span>
<a  class="button btn-small  text-center " style="background-color: rgb(148, 183, 54);width:46%;float:left;"  href="domestic_itin.php" >Back</a>
                                      <a class="button btn-small  text-center"  href="view_package_pdf.php?pack_id=<?php echo $row_package['sno']; ?>" target="_blank" style="background-color: rgb(148, 183, 54);margin-left:3px;">&nbsp;&nbsp;<i class="fa fa-download"></i>&nbsp; Download &nbsp;</a></td>
                                     <?php } ?>
                                 </tr>
                             </table>
                                            </div>
                                            <?php 
                                            if($i==0){
                                             ?>
                                            <div>
                                                <div class="five-stars-container">
                                                <?php $rnd= rand(275,500);
                        $per=($rnd/500)*100; ?> 
      <span class="five-stars" style="width: <?php echo $per;?>%;"></span>
                                                </div>
                                                <span class="review"><?php echo $rnd;?> reviews</span>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div>
           <div data-html='true' style="text-align:justify; word-wrap:break-word;font-weight: 600; color: #515457;">
                                        <?php
                    $sdesc=strip_tags($expackdesc[$i]);
                    
                     if(trim($expackdesc[$i])!=''){ echo $sdesc; }else { echo $sdesc; }?>
                                        </div>
                                        <?php 
                                            if($i==0){
                                             ?>
                                            <div></div>
                                            <?php } ?>
                                       </div>
                                    </div>
                                    </div>

                                    <br>
                                  <?php 
                                  $i++;
                                }
                                }else{ ?>
                                    <figure class="col-sm-5 col-md-4">
<a <?php echo 'href="core/ajax/packages_slide.php?'. http_build_query(array('cluster' => $row_package['pack_img'])). '"'; ?> class="hover-effect popup-gallery">
  <img src="packages/images/<?php echo $row_package['pack_img']; ?>" alt="Image" style="height:170px; width:290px" /></a>                                     
                                    </figure>
                                    <div class="details col-sm-7 col-md-8" style="width:480px!important;">
                                        <div>
                                            <div>
                      <table width="100%">
                                <tr>
                                    <td width="55%">
                                        <h4 class="box-title"><?php
                                        if(strlen(trim($row_package['pack_name']))>40)
                                        {?>
                                            <span data-toggle="tooltip" title="<?php echo $row_package['pack_name']; ?>"><?php echo substr($row_package['pack_name'],0,40).".."; ?></span>
                                        <?php }else{
                                         echo trim($row_package['pack_name']); } ?><small style="color: rgb(186, 132, 22);font-weight: 600;"><i class="soap-icon-departure yellow-color"></i>&nbsp; <?php
                                        if(strlen(trim($row_package['day_locat']))>43)
                                        {?>
                                            <span data-toggle="tooltip" title="<?php echo $row_package['day_locat']; ?>"><?php echo substr($row_package['day_locat'],0,43).".."; ?></span>
                                        <?php }else{
                                         echo trim($row_package['day_locat']); } ?>
                                         </small></h4>
                                     </td>
                                     <td width="45%">
                                      <span class="price"></span>
<a  class="button btn-small  text-center " style="background-color: rgb(148, 183, 54);width:42%;float:left;"  href="domestic_itin.php" data_target="_blank">Back</a>
                                      <a class="button btn-small text-center"  href="view_package_pdf.php?pack_id=<?php echo $row_package['sno']; ?>" target="_blank" style="background-color: rgb(148, 183, 54);margin-left:3px;">&nbsp;&nbsp;<i class="fa fa-download"></i>&nbsp; Download &nbsp;</a></td>
                                 </tr>
                             </table>
                                            </div>
                                            <div>
                                                <div class="five-stars-container">
                                                <?php $rnd= rand(275,500);
												$per=($rnd/500)*100; ?> 
      <span class="five-stars" style="width: <?php echo $per;?>%;"></span>
                                                </div>
                                                <span class="review"><?php echo $rnd;?> reviews</span>
                                            </div>
                                        </div>
                                        <div>
           <div data-html='true' style="text-align:justify; word-wrap:break-word;font-weight: 600;
color: #515457;width:75%;">
                                        <?php
										$sdesc=strip_tags($row_package['p_d']);
										
										 if(trim($row_package['p_d'])!=''){ echo $sdesc; }else { echo $sdesc; }?>
                                        </div>

           <div>

                                            </div>
                                       </div>
                                    </div>
                                    <?php  } ?>
                                </article>
                                
                                
                            </div>
                            <?php 
					if(!isset($_GET['more']) && $total_package>=10)
						{
					?>
                     <a href="domestic_itin.php?more=more" class="button uppercase full-width btn-large box">load more packages</a>
                     <?php }?>
                        </div>
                    
                    <?php include "sidebar.php"; ?>
                </div>
            </div>
        </section>

<script type="text/javascript">
$(document).ready(function() {
 
$('.fancybox').fancybox({
    width  : 900,
    height : 800,
    type   :'iframe'
});
});
var check1='';
function validate_final1(pna,tit)
{

    var fname=$('#fname').val();
    var mail=$('#mail').val();
    var mble=$('#mble').val();
    var desc=$('#desc').val();
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    var numbers =  /^\d+$/; 
    var strin = /^[a-zA-Z ]{4,30}$/;
    var lstrin = /^[a-zA-Z ]{1,30}$/;

    //alert(document.getElementById('agentt').checked);
    if(fname=='')
    {
        alert('Please Enter valid first name');
        document.getElementById('fname').focus();
        check1=0;
        
    }else if(!strin.test(fname))
    {
        alert('Characters only acceptable on first-name');
        document.getElementById('fname').focus();
        check1=0;
       
    }
  else if(mble=='')
    {
        alert('Please Enter Mobile number');
        document.getElementById('mble').focus();
        check1=0;
        
    }else if(!numbers.test(mble))
    {
        alert('Please Enter Valid Mobile Number');
        document.getElementById('mble').focus();
        check1=0;
       
    }else if(document.getElementById('mble').value.trim().length<10 || document.getElementById('mble').value.trim().length>13)
    {
        alert('Invalid Mobile Number');
        document.getElementById('mble').focus();
        check1=0;
        
    }
    else if(mail=='')
    {
        alert('Please Enter valid email id');
        document.getElementById('mail').focus();
        check1=0;
       
    }else if(!expr.test(mail))
    {
        alert('Invalid email id, Please Enter Valid email id');
        document.getElementById('mail').focus();
        check1=0;
       
    }
    else if(desc=='')
    {
        alert('Please Enter Your Description');
        document.getElementById('desc').focus();
        check1=0;
        
    }else{

    var pack_name=pna;
    var title=tit;    
    var data_string1=$("#enquiry_add").serialize();
    alert(data_string1);
    var dataString='pack_name='+pack_name+'&title='+title; 
    $.ajax({
type: "POST",
url: "ajax_mail.php",
data: dataString+data_string1,
cache: false,
success: function(result){ 
alert(result);
   alert("Mail has been send successfully");
   window.location.reload(-1);
       
     }
});
   
    }
        
}
function pdftohtml(val){
  //.alert();
   $.ajax({
   type: "GET",
   url: "ajax_pdf_to_html.php?name="+val,
   cache: false,
   success: function(result){ 
   alert(result);
   //alert("Mail has been send successfully");
   //window.location.reload(-1);
  }
});

}
</script> 
       <!-- <script src="core/assets/js/jquery.min.js"></script>
         <link href="core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
        <script src="core/assets/plugins/fancybox/lib/jquery-1.8.2.min.js"></script>
        <script src="core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
        <script type="text/javascript">
        $(".fancybox").fancybox({ });
        </script>  -->

<?php  include"footer.php";?>
    
    

