<?php require_once('Connections/divdb_new.php');
include("COMMN/smsfunc.php");
//mysql_select_db($database_divdb, $divdb);

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
	<meta name="google-site-verification" content="0vbHDVicRqeDtkXXOs4jaMvyNtMV5h8z0iAUz8aDCys" />
<title>DVI Holidays : Travel Agency : Tourism</title>
<?php
//mysql_select_db($database_divdb, $divdb);
$hStmt=$conn->prepare("SELECT * FROM seo_settings_new where type='HOT'");
$hStmt->execute();
//$query_seo = "SELECT * FROM seo_settings_new where type='HOT'";
//$seo = mysql_query($query_seo, $divdb) or die(mysql_error());
$row_seo = $hStmt->fetch(PDO::FETCH_ASSOC);;
$totalRows_seo = $hStmt->rowCount();
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
//include "header.php";

$id = $_GET['id'];
if(isset($_GET['more']) && $_GET['more']=='more')
{
	$hStmt=$conn->prepare("SELECT * FROM hotspots_pro where  status='0' and spot_state=?  GROUP BY spot_city ASC");
}else{
	$hStmt=$conn->prepare("SELECT * FROM hotspots_pro where  status='0' and spot_state=?  GROUP BY spot_city ASC LIMIT 10");
	
}

$hStmt->execute(array($id));
 $row_htspots_main = $hStmt->fetchAll();
$total_htspots = $hStmt->rowCount();


$hStmt=$conn->prepare("SELECT * FROM dvi_states where code = ?");
$hStmt->execute(array($id));

$row_states = $hStmt->fetch(PDO::FETCH_ASSOC);;
$total_states = $hStmt->rowCount();


?>
<div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">HotSpot In <?php echo $row_states['name']; ?></h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="index.php">HOME</a></li>
                    <li class="active">HotSpot</li>
                </ul>
            </div>
        </div>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-9" style="margin-top:-27px">
                            
                            <div class="hotel-list listing-style3 hotel">
                            <?php foreach($row_htspots_main as  $row_htspots){ 
							if($row_htspots['spot_images'] != ''){
								$spot_one=explode(',',$row_htspots['spot_images']);
								$spot=$spot_one[0];
							}else{
								$spot='default_img.jpg';
							}
				
$hStmt=$conn->prepare("SELECT * FROM dvi_cities where region = ? and id= ?");
$hStmt->execute(array($id,$row_htspots['spot_city']));

$row_cities = $hStmt->fetch(PDO::FETCH_ASSOC);;
$total_cities = $hStmt->rowCount();			


				
$hStmt=$conn->prepare("SELECT * FROM dvi_states where code = ?");
$hStmt->execute(array($id));

$row_states1 = $hStmt->fetch(PDO::FETCH_ASSOC);;
$total_states1 = $hStmt->rowCount();			

							?>
                                <article class="box">
                                    <figure class="col-sm-5 col-md-4">
                                        <a title="City wise" href="hotspots_galary.php?cid=<?php echo $row_htspots['spot_city']; ?>&sid=<?php echo $_GET['id']; ?>" >
                                        <img alt="<?php echo $spot; ?>" src="img_upload/hot_spots/<?php echo $spot; ?>" alt="travel agencies in trichy" title="travel agencies in trichy" style="height:170px; width:290px"></a>
                                    </figure>
                                    <div class="details col-sm-7 col-md-8">
                                        <div>
                                            <div>
                                                <h4 class="box-title"><?php echo trim($row_htspots['spot_name']); ?><small><i class="soap-icon-departure yellow-color"></i>&nbsp; <?php echo $row_cities['name']; ?>, <?php echo $row_states1['name'];?>.</small></h4>
                                             
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
                                        <div data-html='true' style="text-align:justify; word-wrap:break-word">
                                        <?php
										$sdesc=strip_tags($row_htspots['spot_desc']);
										$r='The purpose of life is to live it, to taste travelling to the utmost, to reach out eagerly and without fear for newer and richer experience. Do Travel with DoView Holidays. Traveliing anywhere is now made easy and speedy through DVi.';
										 if(trim($row_htspots['spot_desc'])!=''){ echo trim(substr($sdesc,0,220)).".."; }else { echo substr($r,0,220)."..."; }?>
                                        </div>
                                            <div>
                                            <?php 
															
$hStmt=$conn->prepare("SELECT * FROM hotspots_pro where  status='0' and spot_city= ?");
$hStmt->execute(array($row_htspots['spot_city']));

$row_numhtspots = $hStmt->fetch(PDO::FETCH_ASSOC);;
$total_numhtspots = $hStmt->rowCount();
											
											?>
                                                <span class="price"><small>Spots</small><?php echo $total_numhtspots."+" ;?></span>
                                                <a class="button btn-small full-width text-center" title="" href="hotspots_galary.php?cid=<?php echo $row_htspots['spot_city']; ?>&sid=<?php echo $_GET['id']; ?>">More</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <?php } ?>
                                
                            
                            </div>
                            <?php 
					if(!isset($_GET['more']) && $total_htspots>=10)
						{
					?>
                     <a href="hotspot.php?id=<?php echo $_GET['id']; ?>&more=more" class="button uppercase full-width btn-large box">load more collection</a>
                     <?php }?>
                        </div>
                    
                    <?php include"sidebar.php";?>
                </div>
            </div>
        </section>
<?php include"footer.php";?>
    
    

