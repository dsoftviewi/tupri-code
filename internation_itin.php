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
    $package = $conn->prepare("SELECT * FROM dvi_packages where status='0' and pack_grp='IN' ORDER BY pack_prior ASC");
}else{
    $package = $conn->prepare("SELECT * FROM dvi_packages where status='0' and pack_grp='IN' ORDER BY pack_prior ASC LIMIT 10");
}
$package->execute();
$row_package_main = $package->fetchAll();
$total_package = $package->rowCount();

?>
<style type="text/css">
.fancybox-overlay{display: none!important;}
#fancybox-loading{display: none;}
</style>
<div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">International Itineraries - Packages</h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="index.php">HOME</a></li>
                    <li class="active">International Itineraries</li>
                </ul>
            </div>
        </div>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-9" style="margin-top:-27px">
                            
                            <div class="hotel-list listing-style3 hotel">
                            <?php foreach($row_package_main as $row_package){ ?>
                             <?php if(strpos($row_package['pack_img'],'~')){ 
                                    $expackimg=explode('~',$row_package['pack_img']);
                                    $img_view=$expackimg[0];
                                  }else{
                                    $img_view=$row_package['pack_img'];
                                  }
                                     ?>
                                <article class="box">
                                    <figure class="col-sm-5 col-md-4">
<a <?php echo 'href="core/ajax/packages_slide.php?'. http_build_query(array('cluster' => $img_view)). '"'; ?> class="hover-effect popup-gallery">
<img src="packages/images/<?php echo $img_view; ?>" alt="tour operators in trichy" title="travel agencies in trichy" style="height:170px; width:290px" /></a>

                                        <!-- <a title="City wise" href="" >
                                        <img alt="<?php echo $row_package['pack_img']; ?>" src="packages/images/<?php echo $row_package['pack_img']; ?>" style="height:170px; width:290px"></a> -->
                                    </figure>
                                    <div class="details col-sm-7 col-md-8">
                                        <div>
                                            <div>
                      <table width="100%">
                                <tr>
                                    <td width="85%">
                                        <h4 class="box-title"><?php
                                        if(strlen(trim($row_package['pack_name']))>40)
                                        {?>
                                            <span data-toggle="tooltip" title="<?php echo $row_package['pack_name']; ?>"><?php echo substr($row_package['pack_name'],0,40).".."; ?></span>
                                        <?php }else{
                                         echo trim($row_package['pack_name']); } ?><small style="color: rgb(186, 132, 22);font-weight: 600;"><i class="soap-icon-departure yellow-color"></i>&nbsp; <?php
                                        if(strlen(trim($row_package['pack_location']))>43)
                                        {?>
                                            <span data-toggle="tooltip" title="<?php echo $row_package['pack_location']; ?>"><?php echo substr($row_package['pack_location'],0,43).".."; ?></span>
                                        <?php }else{
                                         echo trim($row_package['pack_location']); } ?>
                                         </small></h4>
                                     </td>
                                     <td width="15%"><a class="button btn-small full-width text-center"  href="view_package_pdf.php?pack_id=<?php echo $row_package['sno']; ?>" target="_blank">&nbsp;&nbsp;<i class="fa fa-download"></i>&nbsp; Download &nbsp;</a></td>
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
color: #515457;">
                                        <?php
                                        $sdesc=strip_tags($row_package['pack_desc']);
                                        // $r='The purpose of life is to live it, to taste travelling to the utmost, to reach out eagerly and without fear for newer and richer experience. Do Travel with DoView Holidays. Traveliing anywhere is now made easy and speedy through DVi.';
                                         if(trim($row_package['pack_desc'])!=''){ echo $sdesc; }else { echo $sdesc; }?>
                                        </div>
           <div>
<span class="price"></span>
<a class="button btn-small full-width text-center" style="background-color: rgb(148, 183, 54);" href="view_package_in.php?pack_id=<?php echo $row_package['sno']; ?>">View</a>
<!-- <a  class="button btn-small full-width text-center fancybox" style="background-color: rgb(148, 183, 54);" title="<?php echo $row_package['pack_name']; ?>" onclick="pdftohtml('<?php echo $row_package['pack_pdf']; ?>')" >View</a> -->
<a class="button btn-small full-width text-center fancybox" style="background-color:  #2D3E52;" href="javascript:void(0)" data-toggle="modal" data-target="#Enquiry1">Enquiry</a>
<div class="modal fade" id="Enquiry1" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" style="width:60%">
<form  name="enquiry_add"  id="enquiry_add"  method="post" enctype="multipart/form-data"  >
<div class="modal-content modal-no-shadow modal-no-border" >
<div class="modal-header bg-info no-border" style="background-color:rgb(237, 238, 239);padding-bottom: 5px;padding-top: 5px;">
<div >
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
</div><div align="left">
<img src="images/logo.png" alt="tour operators in trichy" title="travel agencies in trichy" />
</div></div>
                                              <div class="modal-body" style=" padding-bottom: 5px;">
                                                <div class="row">
                            <div class="col-sm-12">
                                
                                   <div id="first_div_id" >
                               
                                   <center><strong style="color:#F00" id="reg_head"> Enquiry Form</strong></center>
                                   <br />
                                                <div class="row">
                                                  <input type="hidden" name="rname" id="rname">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="First Name" ><i class="fa fa-tag fa-fw"  ></i></span>
                                          <input type="text" name="fname" id="fname"  class="form-control" placeholder="First Name">
                                        </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Last Name" ><i class="fa fa-tag fa-fw"  ></i></span>
                                          <input type="text" name="lname" id="lname"  class="form-control" placeholder="Last Name">
                                        </div>
                                          </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:5px">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Mobile Number" ><i class="fa  fa-mobile fa-fw"  ></i></span>
                                          <input type="text" name="mble" id="mble" class="form-control" placeholder="Mobile Number">
                                        </div>
                                       </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Email ID"><i class="fa fa-envelope  fa-fw"></i></span>
                                         <input type="text" placeholder="Email ID" class="form-control" id="mail" name="mail">
                                        </div>
                                       </div>
                                        </div>
                                </div>
                                
                               
                                    <div class="row" style="margin-top:5px">
                                <div class="col-sm-12">
                                <div class="form-group">
                                         <div class="input-group">
                                        <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Residential Address"><i class="fa fa-home fa-fw"></i></span>
                                          <textarea class="form-control no-resize" name="desc" id="desc" style="resize:none" placeholder="Description"></textarea>
                                        </div>
                                       
                                        </div>
                                </div>
                                </div>
                                                           
                                </div><!-- first_div_id -->
                                </div>
                              </div>
                                              </div>
                                              <div class="modal-footer" style="margin-top:0px">
                                                <button type="button" id="modal_sub_cancel" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" id="submit_id" name="submit_modal" value="submit_modal_val" class="btn btn-success pull-right" onClick="return validate_final1('<?php echo $row_package['pack_name'];?>','Domestic Itineraries')"  ><i class="fa fa-thumbs-o-up"></i>&nbsp;Submit</button>
                                              </div><!-- /.modal-footer -->
                                            </div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->                              
                                              </form>
                                          </div><!-- /.modal-dialog -->
                                        </div>
                                            </div>

                                        </div>
                                    </div>
                                </article>
                                <?php } ?>
                                
                            </div>
                            <?php 
                    if(!isset($_GET['more']) && $total_package>=10)
                        {
                    ?>
                     <a href="internation_itin.php?more=more" class="button uppercase full-width btn-large box">load more packages</a>
                     <?php }?>
                        </div>
                    
                    <?php include"sidebar.php";?>
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
    var dataString='pack_name='+pack_name+'&title='+title; 
    $.ajax({
type: "POST",
url: "ajax_mail.php",
data: dataString+data_string1,
cache: false,
success: function(result){ 

  alert("Mail has been send successfully");
   window.location.reload(-1);
       
     }
});
   
    }
        
}
</script> 

<?php include"footer.php";?>
    
    

