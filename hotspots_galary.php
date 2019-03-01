<?php 
//
require_once('Connections/divdb.php');
$htspots=$conn->prepare("SELECT * FROM hotspots_pro where  status='0' and spot_city=?");
$htspots->execute(array($_GET['cid']));
//$row_htspots=$htspots->fetch(PDO::FETCH_ASSOC);
$row_htspots_main=$htspots->fetchAll();
$total_htspots=$htspots->rowCount();

$cities = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$cities->execute(array($_GET['cid']));
$row_cities = $cities->fetch(PDO::FETCH_ASSOC);
$total_cities = $cities->rowCount();

$sts = $conn->prepare("SELECT * FROM dvi_states where code=?");
$sts->execute(array($_GET['sid']));
$row_sts = $sts->fetch(PDO::FETCH_ASSOC);
$total_sts = $sts->rowCount();

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

<?php include_once("analyticstracking.php") ;
include "header.php";
?>
<div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">Gallery - <?php echo $row_cities['name']." in ".$row_sts['name']; ?></h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="index.php">HOME</a></li>
                    <li class="active">Gallery</li>
                </ul>
            </div>
        </div>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-9" style="margin-top:-27px">
                            <div id="main">
                            
                            
                            
                    <div class="gallery-filter box">
                     <!--   <a href="hotspot.php?id=<?php// echo $_GET['sid']; ?>" class="button btn-medium active" data-filter="filter-all">Back</a>-->
                        <!--<div class="selector col-sm-4 pull-right" style="border:1px #CCCCCC solid">
                                                            <select data-placeholder="Choose City">
                                                            <option value="0">Choose City</option>
                                                                <option value="1">01a</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                            </select><span class="custom-select full-width">01</span>
                                                        </div>-->
                    </div>
                    <div class="items-container isotope image-box style9 row">
                    <?php 
					$z=1;
					foreach($row_htspots_main as $row_htspots){
						if(trim($row_htspots['spot_images']) != '')
						{
							$spot_arr=explode(',',$row_htspots['spot_images']);
							$spot=$spot_arr[0];
						}else{
							$spot='default_img.jpg';
						}
						?>
                        <div class="iso-item col-xs-12 col-sms-6 col-sm-6 col-md-3 filter-all filter-island filter-beach">
                            <article class="box">
                                <figure>
                        <?php   if(trim($row_htspots['spot_images']) != '')
						{?>
                                <a <?php echo 'href="core/ajax/hotspot_slide.php?'. http_build_query(array('cluster' => $spot_arr)). '"'; ?> class="hover-effect popup-gallery"><img src="img_upload/hot_spots/<?php echo $spot_arr[array_rand($spot_arr)]; ?>" alt="tour operators in trichy" title="travel agencies in trichy" style="height:130px;" /></a>
                                <?php }else{ ?>
                                    <a class="hover-effect" title="" href="#"><img alt="tour operators in trichy" title="travel agencies in trichy" src="img_upload/hot_spots/<?php echo $spot; ?>" style="height:130px;"></a>
                                    <?php }?>
                                </figure>
                                <div class="details" data-html='true'>
                                   <a href="javascript:void(0);" onclick="show_me(<?php echo $z; ?>)"> <h4 class="box-title">
									<?php if(strlen($row_htspots['spot_name'])>20){ 
											if(strlen($row_htspots['spot_name'])>35)
											{
												echo substr($row_htspots['spot_name'],0,33)."..";
											}else{
												echo $row_htspots['spot_name'];
											}}else{
									echo $row_htspots['spot_name']."<br><br>";
									}?><small>About</small></h4></a>
                                </div>
                            </article>
                        </div>
                        <?php  $z++; }?>
                    </div>
                   <!-- <ul class="pagination clearfix">
                        <li class="prev disabled"><a href="#">Previous</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li class="disabled"><span>...</span></li>
                        <li><a href="#">5</a></li>
                        <li class="next"><a href="#">Next</a></li>
                    </ul>-->
                    
                    <div id="hotel-features" class="tab-container">
                            
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="hotel-description">
                                    <!--<div class="intro table-wrapper full-width hidden-table-sms">
                                        <div class="col-sm-5 col-lg-4 features table-cell">
                                            <ul>
                                                <li><label>hotel type:</label>4 star</li>
                                                <li><label>Extra people:</label>No Charge</li>
                                                <li><label>Minimum Stay:</label>2 nights</li>
                                                <li><label>Security Deposit:</label>$279</li>
                                                <li><label>Country:</label>France</li>
                                                <li><label>City:</label>Paris</li>
                                                <li><label>Neighborhood:</label>République</li>
                                                <li><label>Cancellation:</label>strict</li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-7 col-lg-8 table-cell testimonials">
                                            <div class="testimonial style1">
                                                <ul class="slides ">
                                                    <li>
                                                        <p class="description">Always enjoyed my stay with Hilton Hotel and Resorts, top class room service and rooms have great outside views and luxury assessories. Thanks for great experience.</p>
                                                        <div class="author clearfix">
                                                            <a href="#"><img src="images/shortcodes/author1.png" alt="" width="74" height="74" /></a>
                                                            <h5 class="name">Jessica Brown<small>guest</small></h5>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <p class="description">Always enjoyed my stay with Hilton Hotel and Resorts, top class room service and rooms have great outside views and luxury assessories. Thanks for great experience.</p>
                                                        <div class="author clearfix">
                                                            <a href="#"><img src="images/shortcodes/author2.png" alt="" width="74" height="74" /></a>
                                                            <h5 class="name">Lisa Kimberly<small>guest</small></h5>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <p class="description">Always enjoyed my stay with Hilton Hotel and Resorts, top class room service and rooms have great outside views and luxury assessories. Thanks for great experience.</p>
                                                        <div class="author clearfix">
                                                            <a href="#"><img src="images/shortcodes/author1.png" alt="" width="74" height="74" /></a>
                                                            <h5 class="name">Jessica Brown<small>guest</small></h5>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>-->
                                     <?php 
									 
$htspotss = $conn->prepare("SELECT * FROM hotspots_pro where  status='0' and spot_city=?");
$htspotss->execute(array($cid));
//$row_htspotss= $htspotss->fetch(PDO::FETCH_ASSOC);
$row_htspotss_main=$htspotss->fetchAll();
$total_htspotss = $htspotss->rowCount();
									 $ii=1;
									 foreach($row_htspotss_main as $row_htspotss){ ?>
                                    <div class="long-description" id="div_id<?php echo $ii;  ?>"  <?php if($ii!=1){ ?>style="display:none;"<?php } ?> >
                                        <center><h2><?php echo $row_htspotss['spot_name']." - ".$row_cities['name']; ?></h2></center>
                                        <p data-html='true' style="text-align:justify" >
                                            <?php if(trim($row_htspotss['spot_desc'])!='' && $row_htspotss['spot_desc'] != '-'){ echo trim($row_htspotss['spot_desc']); }else{ echo "<br><center><strong style='color:#CCC;font-size:20px; '>Unavailable spot history</strong></center>"; }?>
                                        </p>
                                       <hr />
                                        
                                        <?php 
$cthistory = $conn->prepare("SELECT * FROM dvi_cities_history where status='0' and cid=?");
$cthistory->execute(array($row_htspotss['spot_city']));
$row_cthistory= $cthistory->fetch(PDO::FETCH_ASSOC);
$total_cthistory = $cthistory-rowCount();								
										
										if(trim($row_cthistory['cdesc']) !='' && $row_cthistory['cdesc']!='-')
										{
										?>                                        
                                        <p data-html='true' style="text-align:center; font-size:18px; color:#C33"><?php echo $row_cities['name']." -  History";  ?></p>
                                        
                                        <p data-html='true'><?php echo $row_cthistory['cdesc'];  ?></p>  <hr />
                                        <?php }?>
                                    </div>
                                    
                                    <?php $ii++; } ?>
                                    <input type="hidden" value="1" id="prev" name="prev" />
                                  
                          <a href="hotspot.php?id=<?php echo $_GET['sid']; ?>" class="button btn-medium active" data-filter="filter-all">Back</a>
                                </div>
                            </div>
                        
                        </div>
                    
                </div>
                            
                        </div>
                    
                    <?php include"sidebar.php";?>
                </div>
            </div>
        </section>
<?php include"footer.php";?>
    
 <script>
 function show_me(no)
 {
	var prev= document.getElementById('prev').value;
	document.getElementById('div_id'+prev).style.display='none';
	 document.getElementById('div_id'+no).style.display='block';
	 document.getElementById('prev').value=no;
 }
 </script>
    

