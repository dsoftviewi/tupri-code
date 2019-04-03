<?php
$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  
  $datetime=date("Y-m-d H:i:s");
  
$htpro = $conn->prepare("SELECT * FROM hotel_pro  ORDER BY sno ASC");
$htpro->execute();
$row_htpro = $htpro->fetch(PDO::FETCH_ASSOC);
$totalRows_htpro = $htpro->rowCount();

$hot = $conn->prepare("SELECT distinct(datetime) FROM hotel_pro ORDER BY datetime ASC");
$hot->execute();
$row_hot = $hot->fetch(PDO::FETCH_ASSOC);
$totalRows_row_hot = $hot->rowCount(); 
//$row_vehifilt = mysql_fetch_assoc($vehifilt);


if(isset($_POST['prior_forms_sub']) && $_POST['prior_forms_sub']=="prior_forms_sub_val")
{
	
	$tot_ph=$_POST['tot_prior'];
	for($t=1;$t<=$tot_ph;$t++)
	{
		if(isset($_POST['hp_id_'.$t]) && $_POST['hp_id_'.$t]!='')
		{
			$upprior=$conn->prepare("update hotel_pro set hotel_prior=? where hotel_id=?");
			$upprior->execute(array($_POST['hprior_'.$t],$_POST['hp_id_'.$t]));
		}
	}
//echo "<script>parent.document.location.href='admin_manahotel.php?&mm=76a732673da97ccc606eb6482d25f298&sm=28b5856335dedd80e0dd2bf5915448e0&tost=".md5(1)."';</script>"; 
}

//form entry
if ((isset($_POST["submit_modal"])) && ($_POST["submit_modal"] == "submit_modal_val")) 
{
	 include('db_downloads.php');//for backuping all db
		/*	$query_hid = "SELECT * FROM hotel_pro ORDER BY sno DESC";
		$hid = mysql_query($query_hid, $divdb) or die(mysql_error());
		$row_hid = mysql_fetch_assoc($hid);
		$totalRows_row_hot = mysql_num_rows($hot);
		
		if($totalRows_row_hot>0)
		{
			$hot_no_arr=explode('HOTEL',$row_hid['hotel_id']);
			$id_hot=$hot_no_arr[1]+1;
			$id="HOTEL".$id_hot;
		}else{
			$id=='HOTEL1';
		}*/
		$id=$_POST['form_idds'];
	if(!isset($_POST['hotel_city']) || empty($_POST['hotel_city']))
	{
		$_POST['hotel_city']=0;
	}		
$insertSQLHotel=$conn->prepare('insert into hotel_pro(hotel_id, hotel_name, location, city, state, category, hotel_link, datetime, status) values(?,?,?,?,?,?,?,?,"0")');
$insertSQLHotel->execute(array($id,$_POST['hotel_name'],$_POST['hotel_addr'],$_POST['hotel_city'],$_POST['hotel_state'],$_POST['hotel_cat'],$_POST['hotel_link'],$datetime));
				
				//print_r($_POST['lunch_rate']);
				if(trim($_POST['lunch_rate'][0])!='')
				{
				$lunch_rate_arr=explode(',',$_POST['lunch_rate'][0]);
				$lunch_rate=implode('\\',$lunch_rate_arr);
				}else{
					$lunch_rate="0\\0\\0\\0\\0\\0\\0\\0\\0";
				}
				
				if(trim($_POST['dinner_rate'][0])!='')
				{
				$dinner_rate_arr=explode(',',$_POST['dinner_rate'][0]);
				$dinner_rate=implode('\\',$dinner_rate_arr);
				}else{
				$dinner_rate="0\\0\\0\\0\\0\\0\\0\\0\\0";
				}
				
				if(trim($_POST['child_bed_rent'][0])!='')
				{
				$chbed_rate_arr=explode(',',$_POST['child_bed_rent'][0]);
				$chbed_rate=implode('\\',$chbed_rate_arr);
				}else{
				$chbed_rate="0\\0\\0\\0\\0\\0\\0\\0\\0";
				}
				
				if(trim($_POST['child_wobed_rent'][0])!='')
				{
				$chbedwo_rate_arr=explode(',',$_POST['child_wobed_rent'][0]);
				$chbedwo_rate=implode('\\',$chbedwo_rate_arr);
				}else{
				$chbedwo_rate="0\\0\\0\\0\\0\\0\\0\\0\\0";
				}
				
				if(trim($_POST['flower_bed'][0])!='')
				{
				$flower_rate_arr=explode(',',$_POST['flower_bed'][0]);
				$flower_rate=implode('\\',$flower_rate_arr);
				}else{
				$flower_rate="0\\0\\0\\0\\0\\0\\0\\0\\0";
				}
				
				if(trim($_POST['candle_light'][0])!='')
				{
				$candle_rate_arr=explode(',',$_POST['candle_light'][0]);
				$candle_rate=implode('\\',$candle_rate_arr);
				}else{
				$candle_rate="0\\0\\0\\0\\0\\0\\0\\0\\0";
				}
				
				if(trim($_POST['cake_rate'][0])!='')
				{
				$cake_rate_arr=explode(',',$_POST['cake_rate'][0]);
				$cake_rate=implode('\\',$cake_rate_arr);
				}else{
				$cake_rate="0\\0\\0\\0\\0\\0\\0\\0\\0";
				}
				
				if(trim($_POST['fruit_basket'][0])!='')
				{
				$fruit_rate_arr=explode(',',$_POST['fruit_basket'][0]);
				$fruit_rate=implode('\\',$fruit_rate_arr);
				}else{
				$fruit_rate="0\\0\\0\\0\\0\\0\\0\\0\\0";	
				}
				$insertfood= $conn->prepare("INSERT INTO hotel_food (hotel_id, lunch_rate, dinner_rate, child_with_bed, child_without_bed, flower_bed, candle_light, cake_rate, fruit_basket, datetime, status) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
				$insertfood->execute(array($id,$lunch_rate,$dinner_rate,$chbed_rate,$chbedwo_rate,$flower_rate,$candle_rate,$cake_rate,$fruit_rate,$datetime,0));
				
				
		//$status=explode(",",$row_tstatus['tkt_status']);
		if(($_POST['room_type']) != '')
		{
			$room_type=explode(",",$_POST['room_type'][0]);
			$season1=explode(",",$_POST['season1'][0]);
			$season2=explode(",",$_POST['season2'][0]);
			$season3=explode(",",$_POST['season3'][0]);
			$season4=explode(",",$_POST['season4'][0]);
			$season5=explode(",",$_POST['season5'][0]);
			$season6=explode(",",$_POST['season6'][0]);
			$season7=explode(",",$_POST['season7'][0]);
			$season8=explode(",",$_POST['season8'][0]);
			$season9=explode(",",$_POST['season9'][0]);
		$leng=count($room_type);
								for($counter=0;$counter<$leng; $counter++)
								{
					$insertHotelSes=$conn->prepare('insert into hotel_season(hotel_id, room_type, season1_rate, season2_rate, season3_rate, season4_rate, season5_rate, season6_rate, season7_rate, season8_rate, season9_rate, datetime, status) values(?,?,?,?,?,?,?,?,?,?,?,?,"0" )');
				    $insertHotelSes->execute(array($id,$room_type[$counter],$season1[$counter],$season2[$counter],$season3[$counter],$season4[$counter],$season5[$counter],$season6[$counter],$season7[$counter],$season8[$counter],$season9[$counter],$datetime));
						//echo $counter;			
								}
		}

		$cn=$_POST['hotel_name'].' was added Successfully..!';
		$cl='success';		
	echo "<script>parent.document.location.href='admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."&rec=".$cn."&clr=".$cl."';</script>"; 

}

set_include_path(get_include_path() . PATH_SEPARATOR . 'xl_up/Classes/');
include 'xl_up/Classes/PHPExcel/IOFactory.php';
//excel uploading for insert
if ((isset($_POST["subex_hotel"])) && ($_POST["subex_hotel"] == "subex_hotel_val")) 
{
	
	$timezone = new DateTimeZone("Asia/Kolkata");
$date = new DateTime();
$date->setTimezone($timezone);
$tstamp= $date->format('Y_m_d_H_i_s');
$cn='';
	
$excel=$_FILES["excl"]["name"]; 
	$excelfile="uploadexcel/hotel/".$tstamp.'.'.$excel;
	move_uploaded_file($_FILES["excl"]["tmp_name"],$excelfile);
	
// This is the file path to be uploaded.
	$inputFileName = 'uploadexcel/hotel/'.$tstamp.'.'.$excel; 
	
try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

$col_arry=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W');
for($i=2;$i<=$arrayCount;$i++)
{
$Hotel_name = trim($allDataInSheet[$i]["A"]);
$Location = trim($allDataInSheet[$i]["B"]);
$City = trim($allDataInSheet[$i]["C"]);
$Category = trim($allDataInSheet[$i]["D"]);
$Type = trim($allDataInSheet[$i]["E"]);
$Lunch = trim($allDataInSheet[$i]["F"]);	
$Dinner = trim($allDataInSheet[$i]["G"]);
$Child_with_bed = trim($allDataInSheet[$i]["H"]);
$Child_without_bed = trim($allDataInSheet[$i]["I"]);
$Flower_bed = trim($allDataInSheet[$i]["J"]);
$Candle_light = trim($allDataInSheet[$i]["K"]);
$Cake = trim($allDataInSheet[$i]["L"]);
$Fruit_Basket = trim($allDataInSheet[$i]["M"]);
$Season1 = trim($allDataInSheet[$i]["N"]);
$Season2 = trim($allDataInSheet[$i]["O"]);
$Season3 = trim($allDataInSheet[$i]["P"]);
$Season4 = trim($allDataInSheet[$i]["Q"]);
$Season5 = trim($allDataInSheet[$i]["R"]);
$Season6 = trim($allDataInSheet[$i]["S"]);
$Season7 = trim($allDataInSheet[$i]["T"]);
$Season8 = trim($allDataInSheet[$i]["U"]);
$Season9 = trim($allDataInSheet[$i]["V"]);
if($Type!=''){
	$hidd = $conn->prepare("SELECT hotel_id FROM hotel_pro ORDER BY sno DESC");
		$hidd->execute();
		$row_hidd = $hidd->fetch(PDO::FETCH_ASSOC);
		 $totalRows_row_hotd = $hidd->rowCount();
	
		if($totalRows_row_hotd>0)
		{
		
			$hot_no_arr=explode('HOTEL',$row_hidd['hotel_id']);
			 $id_hot=intval($hot_no_arr[1]+1);
			
			$id="HOTEL".$id_hot;
		}else{
			$id='HOTEL'.intval(1);
		}

$stateid = $conn->prepare("SELECT * FROM dvi_cities where id=?");
				$stateid->execute(array($City));
				$row_stateid = $stateid->fetch(PDO::FETCH_ASSOC);
				$state_id=$row_stateid['region'];

$insertHotel= $conn->prepare("INSERT INTO hotel_pro (hotel_id, hotel_name, location, city, state, category, hotel_link, datetime, status) VALUES (?,?,?,?,?,?,' ',?,'0')");
$insertHotel->execute(array($id,$Hotel_name,$Location,$City,$state_id,$Category,$datetime));
			  
			  
			  $insertfood= $conn->prepare("INSERT INTO hotel_food (hotel_id, lunch_rate, dinner_rate, child_with_bed, child_without_bed, flower_bed, candle_light, cake_rate, fruit_basket,datetime, status) VALUES (?,?,?,?,?,?,?,?,?,?,'0')");
			  $insertfood->execute(array($id,$Lunch,$Dinner,$Child_with_bed,$Child_without_bed,$Flower_bed,$Candle_light,$Cake,$Fruit_Basket,$datetime));
			  

 $expl_type = explode('\\',$Type);
			  $expl_season1 = explode('\\',$Season1);
			  $expl_season2 = explode('\\',$Season2);
			  $expl_season3 = explode('\\',$Season3);
			  $expl_season4 = explode('\\',$Season4);
			  $expl_season5 = explode('\\',$Season5);
			  $expl_season6 = explode('\\',$Season6);
			  $expl_season7 = explode('\\',$Season7);
			  $expl_season8 = explode('\\',$Season8);
			  $expl_season9 = explode('\\',$Season9);
			  
			 $type_tot = count($expl_type);
 for($type_cnt=0;$type_cnt<$type_tot;$type_cnt++)
			  {

if(!isset($expl_season1[$type_cnt]))
{
	$expl_season11='';
}else
{
	$expl_season11=$expl_season1[$type_cnt];
}
if(!isset($expl_season2[$type_cnt]))
{
	$expl_season22='';
}else
{
	$expl_season22=$expl_season2[$type_cnt];
}
if(!isset($expl_season3[$type_cnt]))
{
	$expl_season33='';
}else
{
	$expl_season33=$expl_season3[$type_cnt];
}
if(!isset($expl_season4[$type_cnt]))
{
	$expl_season44='';
}else
{
	$expl_season44=$expl_season4[$type_cnt];
}
if(!isset($expl_season5[$type_cnt]))
{
	$expl_season55='';
}else
{
	$expl_season55=$expl_season5[$type_cnt];
}
if(!isset($expl_season6[$type_cnt]))
{
	$expl_season66='';
}else
{
	$expl_season66=$expl_season6[$type_cnt];
}
if(!isset($expl_season7[$type_cnt]))
{
	$expl_season77='';
}else
{
	$expl_season77=$expl_season7[$type_cnt];
}
if(!isset($expl_season8[$type_cnt]))
{
	$expl_season88='';
}else
{
	$expl_season88=$expl_season8[$type_cnt];
}
if(!isset($expl_season9[$type_cnt]))
{
	$expl_season99='';
}else
{
	$expl_season99=$expl_season9[$type_cnt];
}

				 $insertSeason=$conn->prepare("INSERT INTO `hotel_season` (hotel_id, room_type, season1_rate, season2_rate, season3_rate, season4_rate, season5_rate, season6_rate, season7_rate, season8_rate, season9_rate, datetime, status) values(?,?,?,?,?,?,?,?,?,?,?,?, '0')");
     			 $insertSeason->execute(array($id,$expl_type[$type_cnt],$expl_season11,$expl_season22,$expl_season33,$expl_season44,$expl_season55,$expl_season66,$expl_season77,$expl_season88,$expl_season99,$datetime));
			  }
			}
}
}
//excel uploading for update
if ((isset($_POST["subex_hotel"])) && ($_POST["subex_hotel"] == "subex_hotel_val1")) 
{
	
	$timezone = new DateTimeZone("Asia/Kolkata");
$date = new DateTime();
$date->setTimezone($timezone);
$tstamp= $date->format('Y_m_d_H_i_s');
$cn='';
	
$excel=$_FILES["excl"]["name"]; 
	$excelfile="uploadexcel/hotel/".$tstamp.'.'.$excel;
	move_uploaded_file($_FILES["excl"]["tmp_name"],$excelfile);
	
// This is the file path to be uploaded.
	$inputFileName = 'uploadexcel/hotel/'.$tstamp.'.'.$excel; 
	
try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

$col_arry=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X');
for($i=2;$i<=$arrayCount;$i++)
{
$Hotel_id = trim($allDataInSheet[$i]["A"]);
$Hotel_name = trim($allDataInSheet[$i]["B"]);
$Location = trim($allDataInSheet[$i]["C"]);
$City = trim($allDataInSheet[$i]["D"]);
$Category = trim($allDataInSheet[$i]["E"]);
$Type = trim($allDataInSheet[$i]["F"]);
$Lunch = trim($allDataInSheet[$i]["G"]);	
$Dinner = trim($allDataInSheet[$i]["H"]);
$Child_with_bed = trim($allDataInSheet[$i]["I"]);
$Child_without_bed = trim($allDataInSheet[$i]["J"]);
$Flower_bed = trim($allDataInSheet[$i]["K"]);
$Candle_light = trim($allDataInSheet[$i]["L"]);
$Cake = trim($allDataInSheet[$i]["M"]);
$Fruit_Basket = trim($allDataInSheet[$i]["N"]);
$Season1 = trim($allDataInSheet[$i]["O"]);
$Season2 = trim($allDataInSheet[$i]["P"]);
$Season3 = trim($allDataInSheet[$i]["Q"]);
$Season4 = trim($allDataInSheet[$i]["R"]);
$Season5 = trim($allDataInSheet[$i]["S"]);
$Season6 = trim($allDataInSheet[$i]["T"]);
$Season7 = trim($allDataInSheet[$i]["U"]);
$Season8 = trim($allDataInSheet[$i]["V"]);
$Season9 = trim($allDataInSheet[$i]["W"]);
if($Type!=''){

$stateid = $conn->prepare("SELECT * FROM dvi_cities where id=?");
				$stateid->execute(array($City));
				$row_stateid = $stateid->fetch(PDO::FETCH_ASSOC);
				$state_id=$row_stateid['region'];

$updateHotel = $conn->prepare(" UPDATE hotel_pro SET  hotel_name=?,location=?,city=?,state=?, 	category=?,hotel_link=' ',datetime=?,status='0' where hotel_id=?");
$updateHotel->execute(array($Hotel_name,$Location,$City,$state_id,$Category,$datetime,$Hotel_id));
	
$updateFood = $conn->prepare(" UPDATE hotel_food SET  lunch_rate=?,dinner_rate=?,child_with_bed=?,child_without_bed=?,flower_bed=?,candle_light=?,cake_rate=?,fruit_basket=?,datetime=?,status='0' where hotel_id=?");					
$updateFood->execute(array($Lunch,$Dinner,$Child_with_bed,$Child_without_bed,$Flower_bed,$Candle_light,$Cake,$Fruit_Basket,$datetime,$Hotel_id));
			  
$delete=$conn->prepare("DELETE FROM hotel_season WHERE hotel_id=?");
$delete->execute(array($Hotel_id));


 $expl_type = explode('\\',$Type);
			  $expl_season1 = explode('\\',$Season1);
			  $expl_season2 = explode('\\',$Season2);
			  $expl_season3 = explode('\\',$Season3);
			  $expl_season4 = explode('\\',$Season4);
			  $expl_season5 = explode('\\',$Season5);
			  $expl_season6 = explode('\\',$Season6);
			  $expl_season7 = explode('\\',$Season7);
			  $expl_season8 = explode('\\',$Season8);
			  $expl_season9 = explode('\\',$Season9);
			  
			 $type_tot = count($expl_type);
 for($type_cnt=0;$type_cnt<$type_tot;$type_cnt++)
			  {
if(!isset($expl_season1[$type_cnt]))
{
	$expl_season11='';
}else
{
	$expl_season11=$expl_season1[$type_cnt];
}
if(!isset($expl_season2[$type_cnt]))
{
	$expl_season22='';
}else
{
	$expl_season22=$expl_season2[$type_cnt];
}
if(!isset($expl_season3[$type_cnt]))
{
	$expl_season33='';
}else
{
	$expl_season33=$expl_season3[$type_cnt];
}
if(!isset($expl_season4[$type_cnt]))
{
	$expl_season44='';
}else
{
	$expl_season44=$expl_season4[$type_cnt];
}
if(!isset($expl_season5[$type_cnt]))
{
	$expl_season55='';
}else
{
	$expl_season55=$expl_season5[$type_cnt];
}
if(!isset($expl_season6[$type_cnt]))
{
	$expl_season66='';
}else
{
	$expl_season66=$expl_season6[$type_cnt];
}
if(!isset($expl_season7[$type_cnt]))
{
	$expl_season77='';
}else
{
	$expl_season77=$expl_season7[$type_cnt];
}
if(!isset($expl_season8[$type_cnt]))
{
	$expl_season88='';
}else
{
	$expl_season88=$expl_season8[$type_cnt];
}
if(!isset($expl_season9[$type_cnt]))
{
	$expl_season99='';
}else
{
	$expl_season99=$expl_season9[$type_cnt];
}

				 $insertSeason=$conn->prepare("INSERT INTO `hotel_season` (hotel_id, room_type, season1_rate, season2_rate, season3_rate, season4_rate, season5_rate, season6_rate, season7_rate, season8_rate, season9_rate, datetime, status) values(?,?,?,?,?,?,?,?,?,?,?,?,'0')");
				 $insertSeason->execute(array($Hotel_id,$expl_type[$type_cnt],$expl_season11,$expl_season22,$expl_season33,$expl_season44,$expl_season55,$expl_season66,$expl_season77,$expl_season88,$expl_season99,$datetime));
			  }
			}
}
}
?>
<style>
.datepicker{
	z-index:10000000;
	
}
 .ss
{
	background-color:transparent !important ;
}
.nav-dropdown-contents{

	height: auto;

	min-width: 248px;

	max-width: 240px;
	overflow-y:auto;
	
}

.nav-dropdown-contents ul{

	padding: 0;

	margin: 0;

	list-style: none;

}

.nav-dropdown-contents ul li{

	display: block;

	border-bottom: 1px solid #F5F7FA;

}

.nav-dropdown-contents.static-list ul li,

.nav-dropdown-contents ul li a{

	padding: 20px 10px 10px 20px;

	display: block;

	position: relative;

	height: 60px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

	text-decoration: none;

	color: #656D78;

	background: #fff;

}

.nav-dropdown-contents ul li a:hover{

	color: #434A54;

}
.scroll-nav-dropdowns
{
	height:auto;
	width:240px;
}

</style>
<style>
@media screen and (max-width: 1280px) {
  .table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #ddd;
  }
  .table-responsive > .table {
    margin-bottom: 0;
  }
  .table-responsive > .table > thead > tr > th,
  .table-responsive > .table > tbody > tr > th,
  .table-responsive > .table > tfoot > tr > th,
  .table-responsive > .table > thead > tr > td,
  .table-responsive > .table > tbody > tr > td,
  .table-responsive > .table > tfoot > tr > td {
    white-space: nowrap;
  }
  .table-responsive > .table-bordered {
    border: 0;
  }
  .table-responsive > .table-bordered > thead > tr > th:first-child,
  .table-responsive > .table-bordered > tbody > tr > th:first-child,
  .table-responsive > .table-bordered > tfoot > tr > th:first-child,
  .table-responsive > .table-bordered > thead > tr > td:first-child,
  .table-responsive > .table-bordered > tbody > tr > td:first-child,
  .table-responsive > .table-bordered > tfoot > tr > td:first-child {
    border-left: 0;
  }
  .table-responsive > .table-bordered > thead > tr > th:last-child,
  .table-responsive > .table-bordered > tbody > tr > th:last-child,
  .table-responsive > .table-bordered > tfoot > tr > th:last-child,
  .table-responsive > .table-bordered > thead > tr > td:last-child,
  .table-responsive > .table-bordered > tbody > tr > td:last-child,
  .table-responsive > .table-bordered > tfoot > tr > td:last-child {
    border-right: 0;
  }
  .table-responsive > .table-bordered > tbody > tr:last-child > th,
  .table-responsive > .table-bordered > tfoot > tr:last-child > th,
  .table-responsive > .table-bordered > tbody > tr:last-child > td,
  .table-responsive > .table-bordered > tfoot > tr:last-child > td {
    border-bottom: 0;
  }
}

.flashit{
	-webkit-animation: flash linear 1s infinite;
	animation: flash linear 1s infinite;
	color: #EF0000;
}
@-webkit-keyframes flash {
	0% { opacity: 1; } 
	50% { opacity: .1; } 
	100% { opacity: 1; }
}
@keyframes flash {
	0% { opacity: 1; } 
	50% { opacity: .1; } 
	100% { opacity: 1; }
}
</style>
			<div class="container-fluid">
				<!-- Begin page heading -->
				<h1 class="page-heading">Hotel Pro <small>Manage Hotels</small></h1>
				
					<div class="row">
                        <div class="col-lg-12">
                        <div id="lock_hotel_gall">
                        <!--  Loading hotel lock modal from ajax_other.php  type=10 -->
                          </div>
                        
                        <div class="modal fade" id="download_hotel_info" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"><i class="fa fa-university"></i>&nbsp;Download Hotel- Info</h5>
											  </div>
											  <div class="modal-body">
                                               <div class="row">
                                               <div class="col-sm-12">
                                               <div class="col-sm-8" align="center">
                                               <strong style="color:#F00">Hotel Info : [ ID's, Hotel Name, Hotel Address ]</strong>
                                               </div>
                                               <div class="col-sm-4" align="center">
                                               <a target="_blank" href="<?php echo $_SESSION['grp']; ?>/hotel_ids.php" style="color:#0E86D0; text-decoration:none;" >
                                               <i class="fa  fa-download"></i>&nbsp;&nbsp;Download
                                               </a>
                                               </div>
                                               </div>
                                               <div class="col-sm-12" style="margin-top:10px; border-top:1px solid #CADAE0">
                                                   <?php
		$hinfo= $conn->prepare("SELECT * FROM hotel_pro ORDER BY sno DESC");
		$hinfo->execute();
		$row_hinfo = $hinfo->fetch(PDO::FETCH_ASSOC);
		$totalRows_row_hinfo = $hinfo->rowCount();
		$link=0;
												//echo $totalRows_row_hinfo;
												?>
                                <p align="center" style="color:#2498C3; margin-top:5px; ">
                                <u>Download Room Info Links Below ( Total Entries : <?php echo $totalRows_row_hinfo; ?> )</u></p>
                                <?php 
								$tlk=30;
								for($lk=0;$lk<$totalRows_row_hinfo;)
								{
									if($totalRows_row_hinfo>=$tlk)
									{
										$tlk=$tlk;
									}else{
										$tlk=$totalRows_row_hinfo;	
									}
								?>
                                   <div class="col-sm-6" style="margin-top:10px; border:1px solid #DADADA" >
                                    <a  target="_blank" id="btn_room_htl" href="<?php echo $_SESSION['grp']; ?>/hotel_rooms.php?frm=<?php echo $lk; ?>&to=<?php echo $tlk; ?>" style="color:#0E86D0; text-decoration:none;" ><i class="fa  fa-download"></i>&nbsp;Link To : <?php echo ($lk+1).'-'.$tlk; ?></a></div>
                                 <?php 
								 $lk=$lk+30;
								 $tlk=$tlk+30;
								 }?>              
                                              <!-- <div class="col-sm-6" align="center">2</div>-->
                                               </div>
                                               
                                               </div>
                                            
                                                
											  </div>
											  <div class="modal-footer">
                                              <strong style="color:#F00; font-weight:600;">Note : </strong>
                                              <strong style="color:#F00; font-weight:600; font-size:12px">* Please click the above mentioned links one by one, after downloading whole sheet </strong>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											  </div><!-- /.modal-footer -->
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->										  </div><!-- /.modal-dialog -->
										</div>
                        
                        <div class="modal fade" id="InfoModalColor212" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" style="width:60%">
                    <form  name="hotel_add"  id="hotel_add"  method="post" enctype="multipart/form-data" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <?php
		$hid = $conn->prepare("SELECT * FROM hotel_pro ORDER BY sno DESC");
		$hid->execute();
		$row_hid = $hid->fetch(PDO::FETCH_ASSOC);
		$totalRows_row_hot = $hid->rowCount();
		
		if($totalRows_row_hot>0)
		{
			$hot_no_arr=explode('HOTEL',$row_hid['hotel_id']);
			$id_hot=$hot_no_arr[1]+1;
			$id="HOTEL".$id_hot;
		}else{
			$id=='HOTEL1';
		}
												
												?>
												<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"><i class="fa fa-university"></i>&nbsp;New Hotel - Form ( <?php echo $id; ?> )
                                                <input type="hidden" id="form_idds" name="form_idds" value="<?php echo $id; ?>" />
                                                </h5>
                                                
											  </div>
											  <div class="modal-body">
                                                <div class="row">
							<div class="col-sm-12">
                                
                                   <div id="first_div_id" >
                                   <center><strong style="color:#CCC"> Hotel Form Entry</strong></center>
                                   <br />
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Hotel Name" ><i class="fa fa-building fa-fw"  ></i></span>
										  <input type="text" name="hotel_name" class="form-control" placeholder="Hotel Name">
										</div>
                                       <!-- <small class="help-block" >(Optional).</small>-->
                                        </div>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Hotel Category"><i class="fa fa-star-half-empty (alias) fa-fw" ></i></span>
										  <!-- <input type="text" name="hotel_cat" id="hotel_cat" class="form-control"  placeholder="Hotel Category"> -->
										  <select class="chosen-select" id="hotel_cat" name="hotel_cat" data-placeholder="Choose Hotel Category">
										  	<option></option>
 											<option value="2STAR" >2STAR</option>
 											<option value="3STAR" >3STAR</option>
 											<option value="4STAR" >4STAR</option>
 											<option value="5STAR" >5STAR</option>
 											<option value="House Boat" >House Boat</option>
 											</select>
										</div>
                                        <small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Room types" ><i class="fa fa-home fa-fw"  ></i></span>
				<input type="text" class="tagname form-control" name="room_type[]" id="room_type" multiple data-placeholder="Room Type"  />
										</div>
                                       <!-- <small class="help-block" >(Optional).</small>-->
                                        </div>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Residencial address of hotel"><i class="fa  fa-pencil-square-o fa-fw"></i></span>
										  <textarea name="hotel_addr" rows="4" class="form-control no-resize"></textarea>
										</div>
                                        <small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
									</div>
                                    </div>
                                
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group ">
                                    <?php 
									$hotelstate = $conn->prepare("SELECT * FROM dvi_states");
									$hotelstate->execute();
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelstate_main=$hotelstate->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="Hotel - State"><i class="fa fa-globe fa-fw"></i></span>
										 <select data-placeholder="Choose a State" name="hotel_state" class="form-control chosen-select col-lg-12 " tabindex="2" onChange="find_city(this.value)" >									
                                         <option >Choose state</option>	
										 <?php foreach($row_hotelstate_main as $row_hotelstate) {?>
										<option value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option>
                                        <?php } ?>
									</select>
										</div>
                                       <!-- <small class="help-block" id="perklerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group " id="default_city_id">
                                   
									<span class="input-group-addon tooltips" data-original-title="Hotel - City "><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose a State" class="form-control chosen-select  input-lg" tabindex="2">						<option value="" disabled>Choose state - initially</option>	
										
									</select >
										</div>
                                        <!--<div class="input-group" id="active_city_id"></div>-->
                                        </div>
                                        </div>
                                         <!-- /.col-sm-6 -->
                                </div>
                                
                                <div class="row" style="margin-top:10px">
                                    <div class="col-sm-12">
                                <div class="form-group">
										 <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Hotel URL (Link)"><i class="fa fa-link fa-fw"></i></span>
										 <input type="text" placeholder="Hotel URL ( EX : www.examplehotel.com )" class="form-control" name="hotel_link">
										</div>
                                        </div>
                                </div>
                                </div>
                                </div><!-- first_div_id -->
                                
                                <div id="second_div_id" style="display:none;">
                                <center><strong style="color:#CCC;">Food & Other - Details</strong></center>
                                <br />
                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-html="true" data-original-title="Child With Bed Rent <br>( for 9 seasons )" ><i class="fa fa-road   fa-fw"  ></i></span>
										  <input type="text" class="tagname form-control" name="child_bed_rent[]" id="child_bed_rent" multiple data-placeholder="Child With Bed Rent"  />
										</div>
                                       <!-- <small class="help-block" >(Optional).</small>-->
                                        </div>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-html="true" data-original-title="Child Without Bed Rent <br>( for 9 seasons )" ><i class="fa fa-columns fa-fw"  ></i></span>
										  <input type="text" class="tagname form-control" name="child_wobed_rent[]" id="child_wobed_rent" multiple data-placeholder="Child Without Bed Rent"  />
										</div>
                                        </div>
                                    
                                        </div>
                                    </div>
                                
                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-html="true" data-original-title="Lunch Rate <br>( for 9 seasons )" ><i class="fa fa-foursquare fa-fw"  ></i></span>
										  <input type="text" class="tagname form-control" name="lunch_rate[]" id="lunch_rate" multiple data-placeholder="Lunch Rate"  />
										</div>
                                       <!-- <small class="help-block" >(Optional).</small>-->
                                        </div>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-html="true" data-original-title="Dinner Rate <br>( for 9 seasons )" ><i class="fa fa-coffee fa-fw"  ></i></span>
										  <input type="text" class="tagname form-control" name="dinner_rate[]" id="dinner_rate" multiple data-placeholder="Dinner Rate"  />
										</div>
                                        </div>
                                    
                                        </div>
                                    </div>
                                    
                                     <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-html="true" data-original-title="Flower Bed Rent <br>( for 9 seasons )" ><i class="fa  fa-empire fa-fw"  ></i></span>
										  <input type="text" class="tagname form-control" name="flower_bed[]" id="flower_bed" multiple data-placeholder="Flower Bed Rent"  />
										</div>
                                         </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-html="true" data-original-title="Candle Light Rent <br>( for 9 seasons )" ><i class="fa  fa-fire fa-fw"  ></i></span>
										  <input type="text" class="tagname form-control" name="candle_light[]" id="candle_light" multiple data-placeholder="Candle Light Rent"  />
										</div>
                                        </div>
                                        </div>
                                    </div> 
                                      
                                    
                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                    
                                    
                                    
										<span class="input-group-addon tooltips" data-html="true" data-original-title="Special Cake Rate <br>( for 9 seasons )" ><i class="fa  fa-credit-card fa-fw"  ></i></span>
										  <input type="text" class="tagname form-control" name="cake_rate[]" id="cake_rate" multiple data-placeholder="Special Cake Rate"  />
										</div>
                                       <!-- <small class="help-block" >(Optional).</small>-->
                                        </div>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-html="true" data-original-title="Fruit Basket Rate <br>( for 9 seasons )" ><i class="fa  fa-life-saver (alias) fa-fw"  ></i></span>
										  <input type="text" class="tagname form-control" name="fruit_basket[]" id="fruit_basket" multiple data-placeholder="Fruit Basket Rate"  />
										</div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="third_div_id" style="display:none;">
                                <center><strong style="color:#CCC;">Season Wise Rent - Details</strong></center>
                                <br />
                                <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
                                  <span class="input-group-addon tooltips" data-original-title="Season 1 rates" ><i class="fa fa-cloud" style="font-size:24px; color:#848689"></i><i class="fa" style="color:#FFF; font-weight:600; font-size:10px; margin-left:-17px; margin-top:-5%" >1</i></span>
                                  
										<!--<span class="input-group-addon tooltips" data-original-title="Season 1 rates"><i class="fa  fa-cloud-download fa-fw"> 1</i></span>-->
                                          <input type="text" class="tagname form-control" name="season1[]" id="season1" multiple placeholder="Season 1 rates" />
										</div>
                                        <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
                                   <span class="input-group-addon tooltips" data-original-title="Season 2 rates" ><i class="fa fa-cloud" style="font-size:24px;color:#848689""></i><i class="fa" style="color:#FFF; font-weight:600; font-size:10px; margin-left:-17px; margin-top:-5%" >2</i></span>
                                          <input type="text" class="tagname form-control" name="season2[]" id="season1" multiple placeholder="Season 2 rates" />
										</div>
                                       <!-- <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
                                  <span class="input-group-addon tooltips" data-original-title="Season 3 rates" ><i class="fa fa-cloud" style="font-size:24px;color:#848689""></i><i class="fa" style="color:#FFF; font-weight:600; font-size:10px; margin-left:-17px; margin-top:-5%" >3</i></span>
										
                                          <input type="text" class="tagname form-control" name="season3[]" id="season3" multiple placeholder="Season 3 rates" />
										</div>
                                        <!--<small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										  <span class="input-group-addon tooltips" data-original-title="Season 4 rates" ><i class="fa fa-cloud" style="font-size:24px;color:#848689""></i><i class="fa" style="color:#FFF; font-weight:600; font-size:10px; margin-left:-17px; margin-top:-5%" >4</i></span>
                                          <input type="text" class="tagname form-control" name="season4[]" id="season4" multiple placeholder="Season 4 rates" />
										</div>
                                        <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>
                                        </div>
                                        </div>
                                </div>
                                    
                                     <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										  <span class="input-group-addon tooltips" data-original-title="Season 5 rates" ><i class="fa fa-cloud" style="font-size:24px;color:#848689""></i><i class="fa" style="color:#FFF; font-weight:600; font-size:10px; margin-left:-17px; margin-top:-5%" >5</i></span>
                                          <input type="text" class="tagname form-control" name="season5[]" id="season5" multiple placeholder="Season 5 rates" />
										</div>
                                       <!-- <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										  <span class="input-group-addon tooltips" data-original-title="Season 6 rates" ><i class="fa fa-cloud" style="font-size:24px;color:#848689""></i><i class="fa" style="color:#FFF; font-weight:600; font-size:10px; margin-left:-17px; margin-top:-5%" >6</i></span>
                                          <input type="text" class="tagname form-control" name="season6[]" id="season6" multiple placeholder="Season 6 rates" />
										</div>
                                       <!-- <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                </div> 
                                      
                                    
                                <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										  <span class="input-group-addon tooltips" data-original-title="Season 7 rates" ><i class="fa fa-cloud" style="font-size:24px;color:#848689""></i><i class="fa" style="color:#FFF; font-weight:600; font-size:10px; margin-left:-17px; margin-top:-5%" >7</i></span>
                                          <input type="text" class="tagname form-control" name="season7[]" id="season7" multiple placeholder="Season 7 rates" />
										</div>
                                       <!-- <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										  <span class="input-group-addon tooltips" data-original-title="Season 8 rates" ><i class="fa fa-cloud" style="font-size:24px;color:#848689""></i><i class="fa" style="color:#FFF; font-weight:600; font-size:10px; margin-left:-17px; margin-top:-5%" >8</i></span>
                                          <input type="text" class="tagname form-control" name="season8[]" id="season8" multiple placeholder="Season 8 rates" />
										</div>
                                       <!-- <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										 <span class="input-group-addon tooltips" data-original-title="Season 9 rates" ><i class="fa fa-cloud" style="font-size:24px;color:#848689""></i><i class="fa" style="color:#FFF; font-weight:600; font-size:10px; margin-left:-17px; margin-top:-5%" >9</i></span>
                                          <input type="text" class="tagname form-control" name="season9[]" id="season9" multiple placeholder="Season 9 rates" />
										</div>
                                      
                                        </div>
                                        </div>
                                        
                                        
                                </div>
                                
                                </div>
                                
                                </div>
							  </div>
                                                
											  </div>
											  <div class="modal-footer">
                                              
                                              <button type="button" id="prev_btn" class="btn btn-info pull-left" onclick="show_first_div()" style="display:none;"><i class="fa fa-backward" ></i>&nbsp;Go Back</button>
                                              <button type="button" id="prev_btn2" class="btn btn-info pull-left" onclick="show_second_div()" style="display:none;"><i class="fa fa-backward" ></i>&nbsp;Go Back</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="button" id="continue_btn" class="btn btn-info" onclick="hide_first_div()">Continue&nbsp;<i class="fa  fa-forward" ></i></button>
                                                <button type="button" id="continue_btn2" class="btn btn-info" onclick="hide_second_div()" style="display:none;">Continue&nbsp;<i class="fa fa-forward" ></i></button>
                                                <button type="submit" id="submit_id" name="submit_modal" value="submit_modal_val" class="btn btn-success" style="display:none;"><i class="fa fa-thumbs-o-up"></i>&nbsp;Submit</button>
											  </div><!-- /.modal-footer -->
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->                                </form>
										  </div><!-- /.modal-dialog -->
										</div>
                                                                              <!-- upload excel -- start -->
                          <div class="modal fade" id="InfoModalColor2" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" style="width:60%">
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"><i class="fa fa-university"></i>&nbsp;New Hotel- Form</h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
							<div class="col-sm-12">
                            
								<div class="alert alert-danger alert-bold-border square fade in alert-dismissable">
								   <h4 align="center"><strong>Instructions!</strong></h4>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> Please Note that the allowed XL file format for upload is  <strong class="text-danger">*.xlsx only.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i>  The File must consist of the following fields: Hotel_name, Location, City, State, Category, Type, Adults, Children,  season1_date, season2_date, season3_date, season4_date, season5_date, season6_date, Season1_rate, Season2_rate, Season3_rate, Season4_rate, Season5_rate, Season6_rate. Sample file attached for your reference<a href="uploadexcel/Sample/hotel/sample_upload_hotels.xlsx" download style="text-decoration:none"><i class="fa fa-cloud-download fa-lg" ></i></a> .
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px; page-break-inside:auto">
                                <i class="fa fa-star"></i> Save your spreadsheet XL file with extension as <strong class="text-danger">.xlsx</strong> and click Upload. Files with format other than .xlsx will not be allowed. Once you upload and submit, your XL sheet will be validated and any errors found will be displayed. Correct the errors if any and re-upload the file&nbsp;.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> If you still get any problems on uploading your files, please Contact <a style="text-decoration:none;" href="http://www.dvi.co.in" target="new">DVI Holidays (India) Pvt. Ltd</a>.</strong>
                                 </p>
                            
								</div>
                                 
                                </div>
							  </div>
                                                
											  </div>
											  <div class="modal-footer">
                  <form name="typeexcel" role="form"  method="post" enctype="multipart/form-data" >
                                             <div class="row">
                                 <div class="col-sm-9" >
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-btn">
											<span class="btn btn-default btn-file">
												Browse&hellip; <input type="file" name="excl"  id="confirm">
											</span>
										</span>
                                        <input type="text" class="form-control" id="nametxt" readonly>
									</div><!-- /.input-group -->
                                    <small id="err" class="help-block" style="color:#E9575C; display:none"></small>
								</div>
                                </div>
                                <div class="col-sm-3">
                                <div class="form-group">
									<div class="pull-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit"   class="btn btn-sm btn-info" name="subex_hotel" value="subex_hotel_val"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
                                </div>
                                </form>
											  </div><!-- /.modal-footer -->
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->										  </div><!-- /.modal-dialog -->
										</div>
                                        
                                        <!-- upload excel --end -->

                                        <!-- upload excel for update option -- start -->
                          <div class="modal fade" id="InfoModalColor2C" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" style="width:60%">
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"><i class="fa fa-university"></i>&nbsp;Update Hotel- Form</h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
							<div class="col-sm-12">
                            
								<div class="alert alert-danger alert-bold-border square fade in alert-dismissable">
								   <h4 align="center"><strong>Instructions!</strong></h4>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> Please Note that the allowed XL file format for upload is  <strong class="text-danger">*.xlsx only.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i>  The File must consist of the following fields: Hotel_name, Location, City, State, Category, Type, Adults, Children,  season1_date, season2_date, season3_date, season4_date, season5_date, season6_date, Season1_rate, Season2_rate, Season3_rate, Season4_rate, Season5_rate, Season6_rate. Click to download current hotel details<a onclick="download_details()" style="text-decoration:none;cursor:pointer"><i class="fa fa-cloud-download fa-lg" ></i></a> .
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px; page-break-inside:auto">
                                <i class="fa fa-star"></i> Save your spreadsheet XL file with extension as <strong class="text-danger">.xlsx</strong> and click Upload. Files with format other than .xlsx will not be allowed. Once you upload and submit, your XL sheet will be validated and any errors found will be displayed. Correct the errors if any and re-upload the file&nbsp;.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> If you still get any problems on uploading your files, please Contact <a style="text-decoration:none;" href="http://www.dvi.co.in" target="new">DVI Holidays (India) Pvt. Ltd</a>.</strong>
                                 </p>
                            
								</div>
                                 
                                </div>
							  </div>
                                                
											  </div>
											  <div class="modal-footer">
                  <form name="typeexcel" role="form"  method="post" enctype="multipart/form-data" >
                                             <div class="row">
                                 <div class="col-sm-9" >
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-btn">
											<span class="btn btn-default btn-file">
												Browse&hellip; <input type="file" name="excl"  id="confirm">
											</span>
										</span>
                                        <input type="text" class="form-control" id="nametxt" readonly>
									</div><!-- /.input-group -->
                                    <small id="err" class="help-block" style="color:#E9575C; display:none"></small>
								</div>
                                </div>
                                <div class="col-sm-3">
                                <div class="form-group">
									<div class="pull-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit"   class="btn btn-sm btn-info" name="subex_hotel" value="subex_hotel_val1"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
                                </div>
                                </form>
											  </div><!-- /.modal-footer -->
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->										  </div><!-- /.modal-dialog -->
										</div>
                                        
                                        <!-- upload excel for update option --end -->
                                        
                        
                        
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
                                <?php 
	$hcity = $conn->prepare("SELECT city FROM hotel_pro where  status = '0' GROUP BY city");
	$hcity->execute();
	//$row_hcity = mysql_fetch_assoc($hcity);
	$row_hcity_main=$hcity->fetchAll();
	
	$totalRows_hcity = $hcity->rowCount();
								?>
								<table>
<tr>
<td style="padding-left: 15px;padding-right: 15px;width:200px">
<select class="chosen-select" id="city_sel" name="city_sel" >
	<?php 
	foreach($row_hcity_main as $row_hcity)
	{
		
	$hcity_nm = $conn->prepare("SELECT * FROM dvi_cities where id =?");
	$hcity_nm->execute(array($row_hcity['city']));
	$row_hcity_nm = $hcity_nm->fetch(PDO::FETCH_ASSOC);

		?>
		<option value="<?php echo $row_hcity['city']; ?>" style="background-color:#C9E0F7; color:#043969"><?php echo $row_hcity_nm['name']; ?></option>
	<?php } ?>
</select>
</td>
<td style="padding-left: 15px;padding-right: 15px;">
<select class="chosen-select" id="cat_sel" name="cat_sel">
	<option value="2STAR" style="background-color:#C9E0F7; color:#043969">2STAR</option>
	<option value="3STAR" style="background-color:#C9E0F7; color:#043969">3STAR</option>
	<option value="4STAR" style="background-color:#C9E0F7; color:#043969">4STAR</option>
	<option value="5STAR" style="background-color:#C9E0F7; color:#043969">5STAR</option>
</select>
</td>
<td style="padding-left: 15px;padding-right: 15px;">
<button class="btn btn-info" onclick="load_my_hotels()"><i class="fa fa-search"></i>&nbsp;Search</button>
</td>
</tr>
								</table>


                              <!-- <div class="btn-group" style="margin-right:80px;">
								  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-search"></i> Hotel &nbsp;<span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" role="menu" style="height:350px; overflow-y:scroll;">
                                  <li >
                       <a href="javascript:void(0);" onclick="search_hotel('<?php echo 'all';?>')" >
					   <?php echo "<strong>All Hotels</strong>";?>
                       </a>
                                    </li>
                                  <?php  foreach($row_hol_main as $row_hol) {?>
									<li >
                       <a href="javascript:void(0);" onclick="search_hotel('<?php echo $row_hol['hotel_id'];?>')" >
					   <?php echo $row_hol['hotel_name'];?>
                       </a>
                                    </li>
                                    <?php }?>
									
								  </ul>
								</div>  -->

								</div>
                                <h3 class="panel-title"><i class="fa fa-building icon-sidebar"></i>&nbsp;Hotel Pro</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                <?php if($totalRows_htpro>0){?>
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable" >
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                  
                                    <div align="right">
                                    <span id="vs1"><strong> Add Hotel </strong></span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu pull-right" role="menu" style="text-align:left">
                                  
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li>
                                    <a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor212"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a>
                                    <!--<a class="add_hotelform " href="<?php// echo $_SESSION['grp'];?>/add_hotel.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&type=<?php// echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a>--></li>
									<li>
                                     <a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor2"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload For New</a>
                                     <a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor2C"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload For Update</a>
                                     
                                    <!--<a class="add_vehi " title="Upload file" href="<?php// echo $_SESSION['grp'];?>/add_hotel.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&type=<?php// echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a>--></li>
                                   <!-- <li>
                                     <a target="_blank" href="<?php echo $_SESSION['grp']; ?>/hotel_ids.php" ><i class="fa  fa-download"></i>&nbsp;&nbsp;Generate - Hotel ID </a>
                                 	</li>
                                    <li>
                                     <a  target="_blank" id="btn_room_htl" href="<?php echo $_SESSION['grp']; ?>/hotel_rooms.php"  ><i class="fa  fa-download"></i>&nbsp;Hotel Room & Rates </a>
                                 	</li>-->
                                    <?php if($totalRows_row_hinfo>0) {?>
                                    <li>
                                     <a  data-target='#download_hotel_info' data-toggle='modal' >
                                     <i class="fa  fa-download"></i>&nbsp;Download Hotel Info
                                     </a>
                                 	</li>
                                    <?php }?>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                &nbsp;&nbsp;
                                    &nbsp;&nbsp;
                                    <input type="hidden" id="lcn" value="1" />
                                </div>
                                    </div>
                                    <div class="table-responsive" id="default_table1">
                                   <?php 
	$hotelpro = $conn->prepare("SELECT * FROM hotel_pro where status = '0' ORDER BY sno ASC");
	$hotelpro->execute();
	//$row_hotelpro = mysql_fetch_assoc($hotelpro);
	$row_hotelpro_main=$hotelpro->fetchAll();
	$totalRows_hotelpro = $hotelpro->rowCount();
								   
								 if($totalRows_hotelpro>0)  {
								   ?>
						<table class="table table-striped table-hover datatable-example" width="100%">
							<thead class="the-box dark full">
								<tr>
									<th width="5%"># </th>
									<th width="20%">Hotel Name</th>
                                    <th width="20%"> Address</th>
                                    <!--<th width="12%"><i class="fa fa-star-half-o"></i> Hotel Type</th>-->
                                    <th width="15%"> Room Type</th>
                                    <th width="10%"> Meal</th>
                                    <th width="18%">Special Amenities</th>
									<th width="12%"> Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
				foreach($row_hotelpro_main as $row_hotelpro)
				{
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_hotelpro['city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);	
							?>
								<tr class="even gradeA">
									<td width="5%" ><?php echo $i;?></td>
									<td width="20%">
                                    <font class="tooltips" data-toggle='tooltip' data-original-title='<?php echo 'Hotel Priority -'.$row_hotelpro['hotel_prior'].' ( '.$row_hotelcity['name'].' )'; ?>'><?php echo $row_hotelpro['hotel_name'];?></font>
                          
                          <a id="btn_<?php echo $row_hotelpro['sno'].'_'.$row_hotelpro['city']; ?>" class="badge badge-info icon-count pull-right tooltips" data-toggle='tooltip' data-original-title='Priority -<?php echo $row_hotelpro['hotel_prior'].' ( '.$row_hotelpro['hotel_name'].' )'; ?>' style="background-color:#2893BD; color:#FDFEFF;" ondblclick="show_prior_tab_escap('<?php echo $row_hotelpro['sno']; ?>','<?php echo $row_hotelpro['city']; ?>')"><strong style="font-size:14px;"><?php echo $row_hotelpro['hotel_prior']; ?></strong></a>
                          
                         <br /> <label style="color:#B07A7A;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star-half-full (alias)"></i> <?php echo "&nbsp;".$row_hotelpro['category'];?></label>&nbsp;&nbsp;
                       
                         <a class="btn" id="lck_btn_<?php echo $row_hotelpro['hotel_id']; ?>" style="color:#666" ondblclick="show_lock_hotel('<?php echo $row_hotelpro['hotel_id']; ?>')">
                           <?php if(trim($row_hotelpro['hotel_slock'])=='0000-00-00' && trim($row_hotelpro['hotel_elock'])=='0000-00-00'){?>
                         <i class="fa fa-unlock-alt tooltips" data-original-title='Double Click To Lock' ></i>
                         <?php }
						 else{ 
						 $llock="From ".date('d-M-Y',strtotime($row_hotelpro['hotel_slock']))." To ".date('d-M-Y',strtotime($row_hotelpro['hotel_elock']));
						 ?>
                          <i class="fa fa-lock tooltips" data-original-title='<?php echo $llock; ?>'></i>
                         <?php }
						 ?>
 						</a>                         
                          <!-- For Priority adding hiddden table - to update -->
                         <table id="tab_<?php echo $row_hotelpro['sno'].'_'.$row_hotelpro['city']; ?>" style="display:none;"><tr>
                         <td><?php
									$hotprior = $conn->prepare("SELECT * FROM  hotel_pro where city=?");
									$hotprior->execute(array($row_hotelpro['city']));
									//$row_hotprior= mysql_fetch_assoc($hotprior);
									$row_hotprior=$hotprior->fetch(PDO::FETCH_ASSOC);
									$tot_hotprior=$hotprior->rowCount();
										 ?>
                                    <?php if($tot_hotprior>0){ ?>
                                 <select name="prior_<?php echo $row_hotelpro['sno'].'_'.$row_hotelpro['city']; ?>" id="prior_<?php echo $row_hotelpro['sno'].'_'.$row_hotelpro['city']; ?>" data-placeholder="Choose Priority" class="form-control city_cls<?php echo $row_hotelpro['city']; ?>">
                                 <?php for($pr=1;$pr<= $tot_hotprior;$pr++)
								 {
									 if($pr==$row_hotelpro['hotel_prior'])
									 {?>
								<option selected value="<?php echo $pr; ?>"><?php echo $pr; ?></option>		<?php }else{ ?>
					 			<option value="<?php echo $pr; ?>"><?php echo $pr; ?></option>
									<?php 			
									  } 
								 }//for loop end?>
                                 </select> <?php } ?> </td>
                                 <td><a class="btn  btn-default" onclick="update_prior('<?php echo $row_hotelpro['sno']; ?>','<?php echo $row_hotelpro['city']; ?>','<?php echo $row_hotelpro['hotel_name']; ?>')"><i class="  fa fa-check-square" style="color:#23691E"></i></a></td><td><a class="btn  btn-default" onclick="hide_prior_tab('<?php echo $row_hotelpro['sno']; ?>','<?php echo $row_hotelpro['city']; ?>')"><i class="  fa fa-times-circle" style="color:#900"></i></a></td></tr></table>
                          </td>
                                    <td style="word-wrap:break-word" width="20%">
                                     <?php
									 $addr= str_replace('\\',',',$row_hotelpro['location']);
									 echo $addr."<br>";
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_hotelpro['state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									 ?>
                                     </td>
                                    <td  width="15%" style="word-wrap:break-word">
									<?php
	$hotelroom = $conn->prepare("SELECT * FROM hotel_season where status = '0' and hotel_id='$row_hotelpro[hotel_id]' group by room_type");
	$hotelroom->execute(array($row_hotelpro['hotel_id']));
	$tot_room=$hotelroom->rowCount();
	$row_hotelroom_main=$hotelroom->fetchAll();
	if($tot_room>0){
	foreach($row_hotelroom_main as $row_hotelroom)
	{	?>	
    
    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/view_season.php?sno=<?php echo $row_hotelroom['sno'];?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&room_type=<?php echo $row_hotelroom['room_type']; ?>"><i class="fa fa-tags"></i>&nbsp;<?php
	if(strlen($row_hotelroom['room_type'])<24)
	{
		echo $row_hotelroom['room_type']; 
	}else{
		echo substr($row_hotelroom['room_type'],0,24)."..."; 
	}
	 ?></a>
    <br />	
<?php    }
	}else{ //if end
	echo "No Room types";
	}?>
                                    </td>
                                    <td  width="10%" ><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '5';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Lunch </a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '6';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Dinner</a>
                                     <hr style="margin:0px" />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '7';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-puzzle-piece"></i>&nbsp;WithBed</a>
                                    <br />
                                     <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '8';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-puzzle-piece"></i>&nbsp;WithOutBed</a>
                                    </td>
                                   
                                    <td  width="18%" ><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '1';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Flower bed decoration</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '2';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Cake</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '3';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Candle light dinner</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '4';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Fruit basket</a>
                                    </td>
                                     <td  width="12%">
                                     <div class="btn-group">
								  <button class="dropdown-toggle btn btn-sm btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle pull-right" role="menu" style="width:12%">
                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/hotel_update.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-wrench"></i>&nbsp; Update</a></li>
                                    
                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/ajax_hotel.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&type=<?php echo "3";?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
								  </ul>
                                    </div>
                                    
                                    <br />
                                    <strong class="tooltips" data-toggle='tooltip' data-placement='left' data-original-title='This Hotel ID' style="color:#933; font-weight:600; font-size:14px">[ <?php echo $row_hotelpro['hotel_id'];?> ]</strong>
                                     </td>
                                     
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
                                <?php } else{?>
                                <h4 style="color:#900; font-weight:600;" align="center" > No Entry Found...</h4>
                                <?php } ?>
                                </div>
                                <div class="" id="tabon2">
                                </div>
                                  <?php }else{?>  
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable">
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                    <span class="text-muted">Hotels not yet added. Click to add entries </span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu pull-right" role="menu" >
                                  
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li>
                                    <a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor212"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a>
                                    <!--<a class="add_hotelform " href="<?php// echo $_SESSION['grp'];?>/add_hotel.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&type=<?php// echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a>--></li>
									<li>
                                     <a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor2"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a>
                                    <!--<a class="add_vehi " title="Upload file" href="<?php// echo $_SESSION['grp'];?>/add_hotel.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&type=<?php// echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a>--></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                    </div>
                                    <?php }?>
                                </div>
                                </div>
                                <!-- /.panel-body -->
                             <!--<div class="panel-footer">Panel footer</div>-->
                            </div>
                            
                            
                        </div><!-- /.col-sm-8 -->
					</div><!-- /.row -->
			
				</div>
                <!-- /.container-fluid -->
<script>
$(document).ready(function(e) {
   	$('.tooltips').tooltip({});
	//$('.tagsinput').tagsinput({height:'2%'});
	$('.chosen-select').chosen({width :'100%'});
	$('.date_pick').datepicker();
});

function download_details(){
	$("#dvLoading").show();
	$.get("<?php echo $_SESSION['grp'];?>/download_excel.php",function(result){
	
window.location.href=("uploadexcel/Sample/hotel/sample_update_hoted_details.xlsx");
$("#dvLoading").hide();
	});
}

function find_city(state_id)
{
	var type=1;
	$.get("<?php echo $_SESSION['grp']; ?>/ajax_hotel.php?sid="+state_id+"&type="+type,function(result)
	{
		$('#default_city_id').empty().html(result);
							$('.chosen-select').chosen({'width':'100%'});
							$('.tooltips').tooltip({});
		
	});
}

function model_div_hide()
{
	$('#second_div_id').hide();
	$('#third_div_id').hide();
	$('#submit_id').hide();
	$('#prev_btn').hide();	
	$('#prev_btn2').hide();	
	$('#first_div_id').show();
 	$('#continue_btn').show();
	$('#continue_btn2').hide();
		
}

function hide_first_div()
{
 $('#first_div_id').hide();
 $('#note_id').hide();
 $('#second_div_id').show();
 $('#prev_btn').show();	
 
// $('#submit_id').show();
 $('#continue_btn').hide();	
  $('#continue_btn2').show();
}

function show_first_div()
{
	$('#continue_btn2').hide();
	$('#second_div_id').hide();
	$('#submit_id').hide();
	$('#prev_btn').hide();	
	$('#first_div_id').show();
 	$('#continue_btn').show();		
}

function hide_second_div()
{
	$('#prev_btn').hide();	
	$('#prev_btn2').show();
	$('#continue_btn2').hide();
	 $('#second_div_id').hide();
	 $('#third_div_id').show();
	 $('#submit_id').show();

}

function show_second_div()
{
	$('#prev_btn').show();	
	$('#prev_btn2').hide();
	$('#continue_btn').show();
	 $('#second_div_id').show();
	 $('#third_div_id').hide();
	 $('#submit_id').hide();
}

function show_third_div()
{
	$('#second_div_id').hide();
	$('#submit_id').hide();
	$('#prev_btn').hide();	
	$('#first_div_id').show();
 	$('#continue_btn').show();		
}

//for load the current date records
function lodrec(dates,toos,dates1)
{
	var nli,type,vv,mm,sm;
	type=5;

	nli="<button class='btn btn-default btn-sm'  data-toggle='tooltip' data-original-title='Go back' onclick='vallrec()'>All Records"+" ("+toos+")"+"</button>";
	$('#sptxt').html("<i class='fa fa-calendar'></i> "+dates);
	if($('#lcn').val()==1)
	{
		$('#btdiv').html(nli);
	}
	
	
	$('#lcn').val(2);
	
	mm='<?php echo $_GET['mm']?>';
	sm='<?php echo $_GET['sm']?>';
	//ajax for load table
	$.ajax({
	 type:'GET',
	 url:"<?php echo $_SESSION['grp'];?>/load_page.php",
	 data:'type='+type+'&dads='+dates1+'&mm='+mm+'&sm='+sm,
	 cache:false,
	 success: function(dd)
	 {
		  toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.info('Records uploaded on '+dates+' are showing..!');
		 
		 //alert('table'+dd);
		 $('#default_table1').empty().html(dd);
		 $('.datatable-example').dataTable();
		 //$('.tagname').tagsInput();
		 //alert('tag');
	 }
		
	});
}


//for load all records
function vallrec()
{
	//alert('aall');
    var type2,mm,sm;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	type2=9;
	$.ajax({
			type :'GET',
			url:"<?php echo $_SESSION['grp'];?>/load_page.php",
			data: "type="+type2+"&mm="+mm+"&sm="+sm,
			cache:false,
			
			success: function(da){
				
		toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.info('Main page records are viewing..!');
				
				//alert("all "+da);
				$('#default_table1').empty().html(da);
				$('.datatable-example').dataTable();
				//$('.tagname').tagsInput();
				
			},
			error : function(xhr, status, error)
			{
				 alert(xhr.responseText);
			}
	});
	
}

//for remove the current date records
function rem(dd,tmsg,fil)
{
	//alert('d');
	var type,tn,fi,mm,sm,fls;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	tn='hotel_pro';
	fi='datetime';
	type=6;
	$.ajax({
	
	type: 'POST',
	url: "<?php echo $_SESSION['grp'];?>/remove_hotel.php?",
	data: "sno="+dd+"&tname="+tn+"&field="+fi+'&fls='+fil,
	success: function(da){
		 toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.error(tmsg+' was successfully Removed..!');
			
			$.ajax({
			type :'GET',
			url:"<?php echo $_SESSION['grp'];?>/load_page.php",
			data: "type="+type+"&mm="+mm+"&sm="+sm,
			success: function(da){
				$('#tabid').empty().html(da);
				$('.datatable-example').dataTable();
				
			}
				});
		
	},
	error : function(xhr, status, error)
	{
 		 alert(xhr.responseText);
	}
		
	});
}

//For remove the current records in the table
function removes(i,vname)
{
	var type,tn,fi,mm,sm,nn;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	tn='vehicle_pro';
	fi='vehi_id';
	type=1;
	$.ajax({
	
	type: 'POST',
	url: "<?php echo $_SESSION['grp'];?>/remove_page.php?",
	data: "sno="+i+"&tname="+tn+"&field="+fi,
	success: function(){
	
		 toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.error(vname+' was successfully Removed..!');
			
			$.ajax({
			type :'GET',
			url:"<?php echo $_SESSION['grp'];?>/load_page.php",
			data: "type="+type+"&mm="+mm+"&sm="+sm,
			success: function(daaa){

				$('#tabid').empty().html(daaa);
				
				$('.datatable-example').dataTable();
				 $('.tagname').tagsInput();
			},
			error : function(xhr, status, error)
				{
					 alert(xhr.responseText);
				}
				});
		
	},
	error : function(xhr, status, error)
	{
 		 alert(xhr.responseText);
	}
	}); 
}

function removes1(i,tot,vname)
{
	var type,tn,fi,mm,sm,nn,dads,cals;
	cals=parseInt(tot)-1;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	tn='vehicle_pro';
	fi='vehi_id';
	type=3;
	dads=$('#gdtime').val();
	$.ajax({
	
	type: 'POST',
	url: "<?php echo $_SESSION['grp'];?>/remove_page.php?",
	data: "sno="+i+"&tname="+tn+"&field="+fi,
	success: function(){
	
		 toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.error(vname+' was successfully Removed..!');
			
			$.ajax({
			type :'GET',
			url:"<?php echo $_SESSION['grp'];?>/load_page.php",
			data: "type="+type+"&mm="+mm+"&sm="+sm+"&dads="+dads,
			success: function(daaa){
				
				if($('#vs1').is(':visible'))
				{
					var ss,sd;
					$('#tabonly').empty().html(daaa);
					ss=$('#sptxt').text();
					sd=ss.substr(0,ss.length-3);
					$('#sptxt').text(sd+' ('+cals+')');
				}
				else
				{
					var ss,sd;
					$('#tbonly1').empty().html(daaa);
					ss=$('#sptxt1').text();
					sd=ss.substr(0,ss.length-3);
					$('#sptxt1').text(sd+' ('+cals+')');
				}
				
				
				$('.datatable-example').dataTable();
			},
			error : function(xhr, status, error)
				{
					 alert(xhr.responseText);
				}
				});
		
	},
	error : function(xhr, status, error)
	{
 		 alert(xhr.responseText);
	}
		
	}); 
	
	

}
function search_hotel(hid)
{
	//alert(hid);
	$.get("ADMIN/ajax_hotel?type=10&hid="+hid, function (result){
				$('#default_table1').empty().html(result);
							// $('.datepick').datepicker();
        });
}

function chkfile()
{
	 var file_list = $('#confirm').val();
	 var extension = file_list.substr((file_list.lastIndexOf('.') +1));
	if(extension)
	{
		var txt;
		txt='Please choose file (.csv format) to upload';
		$('#err').html(txt).show('fade');
		$('#nametxt').css('border','1px solid #E9573F');
		return false;	
	}else{
		 $('#err').empty().hide('fade');
		 $('#nametxt').css('border','1px solid #8CC152');
		 return true;
	}
}

/*document.getElementById('confirm').addEventListener('change', checkFile, false);
approveletter.addEventListener('change', checkFile, false);

function checkFile(e) {

    var file_list = e.target.files;

        var sFileName = file.name;
        var sFileExtension = sFileName.split('.')[sFileName.split('.').length - 1].toLowerCase();
        var iFileSize = file.size;
        var iConvert = (file.size / 10485760).toFixed(2);

        if (!(sFileExtension === "csv")) {
			
            txt = "File type : " + sFileExtension + "\n\n";
            txt += "Please make sure your file is in CSV format\n\n";
          	$('#err').html(txt).show('fade');
		   $('#nametxt').css('border','1px solid #E9573F');
		   $('#errval').val(1);
        }
		else
		{
			 $('#err').empty().hide('fade');
			 $('#nametxt').css('border','1px solid #8CC152');
			 $('#errval').val(0);
		}
  }*/

function show_prior_tab(sno,cid)
{
	$('#btn_'+sno+'_'+cid).hide();
	$('#tab_'+sno+'_'+cid).show();	
}

function hide_prior_tab(sno,cid)
{
	$('#tab_'+sno+'_'+cid).hide();
	$('#btn_'+sno+'_'+cid).show();
}

function update_prior(sno,cid,cname)
{
	//alert(cname);
	var type=22;
	var str=$('#prior_'+sno+'_'+cid).val();
	$.get("ADMIN/ajax_hotel.php?type="+type+"&cid="+cid+"&sno="+sno+"&prior="+str,function(result){
				$('#btn_'+sno+'_'+cid+' strong').empty().prepend(str);
				$('#tab_'+sno+'_'+cid).hide();
				
				$('#btn_'+sno+'_'+cid).attr('data-original-title','Priority -'+str+' ( '+cname+' )');
				$('#btn_'+sno+'_'+cid).show();
				
				hide_option_others(str,sno,cid);
		});
}

function hide_option_others(opt,sno,cid)
{
//alert(opt+' - '+sno+' - '+cid);
	var len=$('.city_cls'+cid).length;
	
					$('.city_cls'+cid+' > option').each(function() 
						{
						
						if(this.value == opt)
						{
						//alert($('select[id$="'+cid+'"]').attr('id'));
							this.remove();
						}
					});
					var opt1=parseInt(opt)-1;
					var opt2=parseInt(opt1)+1;
					//$('<option value='+opt+'>'+opt+'</option>').insertAfter($('#prior_'+sno+'_'+cid+' option:eq('+opt1+')'));
					if(opt1>0)
					{
					$('<option value='+opt+'>'+opt+'</option>').insertAfter($('#prior_'+sno+'_'+cid+' option[value="'+opt1+'"]'));
					}else{
						$('<option value='+opt+'>'+opt+'</option>').insertBefore($('#prior_'+sno+'_'+cid+' option[value="2"]'));
					}
					
					$('#prior_'+sno+'_'+cid+' > option').each(function() 
					{
						if(this.value==opt)
						{
							this.attr('selected','selected');
						}
					});
}


function show_lock_hotel(hid)
{
	if($('#hotel_lock_'+hid).length==0)
	{
	$.get('ADMIN/ajax_others.php?type=11&hid='+hid,function(res){
		$('#err_'+hid).hide();
		$('#lock_hotel_gall').append(res);
		$('#hotel_lock_'+hid).modal('show');
		$('.date_pick').datepicker();	
		});
	}else{
		$('#err_'+hid).hide();
		$('#hotel_lock_'+hid).modal('show');
	}
}

function submit_lock(hid)
{
	var fdate=$('#from_dt_'+hid).val().trim();	
	var edate=$('#end_dt_'+hid).val().trim();	
	if(fdate!='' && edate!='')
	{
		var ss="From "+fdate+" To "+edate;
		$.get('ADMIN/ajax_others.php?type=12&hid='+hid+'&fdate='+fdate+'&edate='+edate,function(ress){
			$('#lck_btn_'+hid).empty().html('<i class="fa fa-lock tooltips" data-original-title="'+ss+'"></i>');
			$('#hotel_lock_'+hid).modal('hide');
			$('#unlck_'+hid).show();
			$('.tooltips').tooltip();
			
				toastr.options={"closeButton":true, "positionClass":"toast-top-right", "showMethod": "fadeIn","hideMethod": "fadeOut"}
      			toastr.info('Locked Successfully..!');
		});	
	}else{
	    $('#err_'+hid).show();	
	}
}

function unlock_hotel_fun(hid)
{
	$.get('ADMIN/ajax_others.php?type=13&hid='+hid,function(ress){
			$('#lck_btn_'+hid).empty().html('<i class="fa fa-unlock-alt tooltips" data-original-title="Double Click To Lock"></i>');
			$('#hotel_lock_'+hid).modal('hide');
			$('#unlck_'+hid).hide();
			$('#from_dt_'+hid).val('');
			$('#end_dt_'+hid).val('');
			$('.tooltips').tooltip();
			
			toastr.options={"closeButton":true, "positionClass":"toast-top-right", "showMethod": "fadeIn","hideMethod": "fadeOut"}
      		toastr.error('Unlocked Successfully ..!');
	});	
}

function load_my_hotels()
{
	//alert('dddd');
	var scat=$('#cat_sel').val();
	var scity=$('#city_sel').val();
	$('#dvLoading').fadeIn();
	$.post('ADMIN/ajax_hotel.php?type=23',{"scat":scat, "scity":scity },function(res){
		$('#dvLoading').fadeOut(500);
		//alert(res);
		$('#default_table1').empty().html(res); 
	});
}

function fun_prior_chck(no)
{
	$('#warn').empty().prepend('This priority already assigned to another hotel.').hide();
	var temp1=$('#tot_prior').val().trim();

	var hval=parseInt($('#hprior_'+no).val());
	if(hval<=parseInt(temp1))
	{
    var temp2,temp3='';
	for(var t=1;t<=temp1;t++)
	{
		$('#hprior_'+t).css('background-color','#FFF');
		$('#hplab_'+t).css('background-color','#FFF');
		if(t!=no)
		{
			temp2=$('#hprior_'+t).val();
			
			if(temp2!='')
			{
				$('#hplab_'+t).css('background-color','rgb(4, 255, 128)');
				if(temp3!='')
				{
						temp3=temp3+'-'+temp2;
				}else{
						temp3=temp2;
				}	
			}
		}
	}
	$('#picked_prior').val(temp3); 

	var temp4=temp3.split('-');
	for(var t1=0;t1<temp4.length;temp4++)
	{
		if($('#hprior_'+no).val()==temp4[t1])
		{
			$('#warn').show();
			$('#hprior_'+no).css('background-color','rgb(249, 199, 199)').focus();
		}
		$('#hplab_'+temp4[t1]).css('background-color','rgb(4, 255, 128)');
	}
	$('#hplab_'+$('#hprior_'+no).val()).css('background-color','rgb(4, 255, 128)');

}else{

	$('#hprior_'+no).css('background-color','rgb(249, 199, 199)').focus();
	$('.ddd').css('background-color','#FFF');
	$('#warn').empty().prepend('Limit of prirority must 0 - '+temp1).show();
}
	
}
 
</script>