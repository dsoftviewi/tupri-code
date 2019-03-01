<html>
<?php
require_once('../Connections/divdb.php');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


if ((isset($_POST["hotel_add"])) && ($_POST["hotel_add"] == "hotel_add_val")) {
	
		
		$hid = $conn->prepare("SELECT * FROM setting_ids  where sno =3");
		$hid->execute();
		$row_hid = $hid->fetch(PDO::FETCH_ASSOC);
		$id=$row_hid['id_name'].$row_hid['id_number'];
		$idin=$row_hid['id_number']+1;
	
$insertSQLHotel=$conn->prepare('insert into hotel_pro(hotel_id, hotel_name, location, city, state, category, status) values(?,?,?,?,?,?,"0" )');
$insertSQLHotel->execute(array($id,$_POST['hotel_name'],$_POST['hotel_addr'],$_POST['hotel_city'],$_POST['hotel_state'],$_POST['hotel_cat']));
				
				 //Update setting ids
			 		$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=3');
			 	  	$insertSQLupd ->execute(array($idin));
				
		//$status=explode(",",$row_tstatus['tkt_status']);
		if(($_POST['room_type']) != '')
		{
			$room_type=explode(",",$_POST['room_type'][0]);
			$adults=explode(",",$_POST['adults'][0]);
			$child=explode(",",$_POST['child'][0]);
			$season1=explode(",",$_POST['season1'][0]);
			$season2=explode(",",$_POST['season2'][0]);
			$season3=explode(",",$_POST['season3'][0]);
			$season4=explode(",",$_POST['season4'][0]);
			$season5=explode(",",$_POST['season5'][0]);
			$season6=explode(",",$_POST['season6'][0]);
		$leng=count($room_type);
								for($counter=0;$counter<$leng; $counter++)
								{
					 $insertHotelSes=$conn->prepare('insert into hotel_season(hotel_id, room_type, no_of_adults, no_of_child, season1_rate, season2_rate, season3_rate, season4_rate, season5_rate, season6_rate, status) values(?,?,?,?,?,?,?,?,?,?,"0")');
					 $insertHotelSes->execute(array($id,$room_type[$counter],$adults[$counter],$child[$counter],$season1[$counter],$season2[$counter],$season3[$counter],$season4[$counter],$season5[$counter],$season6[$counter]));
						//echo $counter;			
								}
		}
		

		$cn=$_POST['hotel_name'].' was added Successfully..!';
		$cl='success';		
	echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."&rec=".$cn."&clr=".$cl."';</script>"; 
  	echo "<script>parent.jQuery.fancybox.close();</script>";


}


if(isset($_GET['type']) && $_GET['type']==md5(2))
{

if ((isset($_POST["subex_hotel"])) && ($_POST["subex_hotel"] == "subex_hotel_val")) {
	
	$timezone = new DateTimeZone("Asia/Kolkata");
$date = new DateTime();
$date->setTimezone($timezone);
$tstamp= $date->format('Y_m_d_H_i_s');
$cn='';
	
	$fpaths=pathinfo($_FILES["excl"]["name"], PATHINFO_EXTENSION);
	$fnames=$tstamp.'.'.$fpaths;
	$excelfile="../uploadexcel/hotel/".$fnames;
	move_uploaded_file($_FILES["excl"]["tmp_name"],$excelfile);
	
	define('CSV_PATH','../uploadexcel/hotel/'); 
	
	$csv_file1 = CSV_PATH . "$fnames"; 
	$fp = file("$csv_file1", FILE_SKIP_EMPTY_LINES);
	$csvfile1 = fopen($csv_file1, 'r');
	$theData1 = fgets($csvfile1);
	$i1=0;
		while (!feof($csvfile1)) {
			$csv_data1[] = fgets($csvfile1, 1024);

if (preg_match('/"([^"]+)"/', $csv_data1[$i1], $m)) {
	$res=preg_replace('/[,]+/', '\\', trim($m[1]));
   $csv_data1[$i1]=str_replace($m[1],'<<<', $csv_data1[$i1]);
}
			$csv_array1 = explode(",", $csv_data1[$i1]);
			
			$insert_csv1 = array();
			$insert_csv1['Hotel_name'] = (isset($csv_array1[0]) ? $csv_array1[0] : '');
			$insertLOC = (isset($csv_array1[1]) ? $csv_array1[1] : '');
			if(strpos($insertLOC,'<<<')!== false)
			{
				$result=$res;
			}else
			{
				$result=$insertLOC;
			}
			//$insert_csv1['Location'] = (isset($csv_array1[1]) ? $csv_array1[1] : '');
			$insert_csv1['Location'] = $result;
			$insert_csv1['City'] = (isset($csv_array1[2]) ? $csv_array1[2] : '');
			$insert_csv1['State'] = (isset($csv_array1[3]) ? $csv_array1[3] : '');
			$insert_csv1['Category'] = (isset($csv_array1[4]) ? $csv_array1[4] : '');
			$insert_csv1['Type'] = (isset($csv_array1[5]) ? $csv_array1[5] : '');
			$insert_csv1['Adults'] = (isset($csv_array1[6]) ? $csv_array1[6] : '');
			$insert_csv1['Children'] = (isset($csv_array1[7]) ? $csv_array1[7] : '');
			$insert_csv1['season_date'][1] = (isset($csv_array1[8]) ? $csv_array1[8] : '');
			$insert_csv1['season_date'][2] = (isset($csv_array1[9]) ? $csv_array1[9] : '');
			$insert_csv1['season_date'][3] = (isset($csv_array1[10]) ? $csv_array1[10] : '');
			$insert_csv1['season_date'][4] = (isset($csv_array1[11]) ? $csv_array1[11] : '');
			$insert_csv1['season_date'][5] = (isset($csv_array1[12]) ? $csv_array1[12] : '');
			$insert_csv1['season_date'][6] = (isset($csv_array1[13]) ? $csv_array1[13] : '');
			$insert_csv1['season1_rate'] = (isset($csv_array1[14]) ? $csv_array1[14] : '');
			$insert_csv1['season2_rate'] = (isset($csv_array1[15]) ? $csv_array1[15] : '');
			$insert_csv1['season3_rate'] = (isset($csv_array1[16]) ? $csv_array1[16] : '');
			$insert_csv1['season4_rate'] = (isset($csv_array1[17]) ? $csv_array1[17] : '');
			$insert_csv1['season5_rate'] = (isset($csv_array1[18]) ? $csv_array1[18] : '');
			$insert_csv1['season6_rate'] = (isset($csv_array1[19]) ? $csv_array1[19] : '');
			
			if($insert_csv1['Type']!='')
			{
				$hid = $conn->prepare("SELECT * FROM setting_ids  where sno =3");
				$hid->execute();
				$row_hid = $hid->fetch(PDO::FETCH_ASSOC);
				$id=$row_hid['id_name'].$row_hid['id_number'];
				$idin=$row_hid['id_number']+1;
				
			$insertHotel= $conn->prepare("INSERT INTO hotel_pro (hotel_id, hotel_name, location, city, state, category, status) VALUES (?,?,?,?,?,?,'0')");
			$insertHotel->execute(array($id,$insert_csv1['Hotel_name'],$insert_csv1['Location'],$insert_csv1['City'],$insert_csv1['State'],$insert_csv1['Category']));
			  
			  $expl_type = explode('\\',$insert_csv1['Type']);
			  $expl_adults = explode('\\',$insert_csv1['Adults']);
			  $expl_children = explode('\\',$insert_csv1['Children']);
			  $expl_season1 = explode('\\',$insert_csv1['season1_rate']);
			  $expl_season2 = explode('\\',$insert_csv1['season2_rate']);
			  $expl_season3 = explode('\\',$insert_csv1['season3_rate']);
			  $expl_season4 = explode('\\',$insert_csv1['season4_rate']);
			  $expl_season5 = explode('\\',$insert_csv1['season5_rate']);
			  $expl_season6 = explode('\\',$insert_csv1['season6_rate']);
			  
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
				 $insertSeason=$conn->prepare("INSERT INTO `hotel_season` (hotel_id, room_type, no_of_adults, no_of_child, season1_rate, season2_rate, season3_rate, season4_rate, season5_rate, season6_rate, status) values(?,?,?,?,?,?,?,?,?,?, '0')");
				 $insertSeason->execute(array($id,$expl_type[$type_cnt],$expl_adults[$type_cnt],$expl_children[$type_cnt],$expl_season11,$expl_season22,$expl_season33,$expl_season44,$expl_season55,$expl_season66,));
			  }
			  
			  
		  for($type_cnt1=1;$type_cnt1<=6;$type_cnt1++)
			  {
				  $sea_id="season".$type_cnt1."_rate";
				  $sea_name="Season".$type_cnt1." Name";
				  $expl_season_date = explode('\\',$insert_csv1['season_date'][$type_cnt1]);
				  
				   if($expl_season_date[0] !='' && $expl_season_date[1] != '')
				   {
				 $insertSeasonSet=$conn->prepare("INSERT INTO `setting_season` (hotel_id, season_id, season_name, from_date, to_date, status) values(?,?,?,?,?, '0')";
				 $insertSeasonSet->execute(array($id,$sea_id,$sea_name,$expl_season_date[0],$expl_season_date[1]));
				   }else{
				$insertSeasonSet1=$conn->prepare("INSERT INTO `setting_season` (hotel_id, season_id, season_name, from_date, to_date, status) values(?,?,?,'','', '0')";
		   	   $insertSeasonSet1->execute(array($id,$sea_id,$sea_name));
				   }
			  }
			  
			  
			  
			  //Update setting ids
			 	$insertSQLupd=$conn->prepare('update setting_ids set id_number=? where sno=3');
			  	$insertSQLupd->execute(array($idin));
			  
			}
			$i1++;
			
		}  
	fclose($csvfile1);
	
	$cn=count($fp)-1;
	$cn1=$cn.' records s are added Successfully..!';
	$cl='success';	
	
echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."&rec=".$cn1."&clr=".$cl."';</script>"; 
  	echo "<script>parent.jQuery.fancybox.close();</script>";
	
}

}


?>
<head>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- PLUGINS CSS -->
		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
        
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>

</head>
<body>
<?php if(isset($_GET['type']) && $_GET['type']==md5(1)){?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-building"></i> Add Hotel</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
								 <form   method="post" name="add_hotel"  ><!-- onSubmit="return exmapleval();" -->
                                 <input type="hidden" id="mm" value="<?php echo $_GET['mm'];?>">
                                   <input type="hidden" id="sm" value="<?php echo $_GET['sm'];?>">
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
										  <input type="text" name="hotel_cat" id="hotel_cat" class="form-control"  placeholder="Hotel Category">
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
										  <input type="text" class="tagname form-control" name="room_type[]" id="room_type" multiple placeholder="Room type" />
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
									<span class="input-group-addon tooltips" data-original-title="Hotel state location1"><i class="fa fa-globe fa-fw"></i></span>
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
                                   
									<span class="input-group-addon tooltips" data-original-title="Hotel city location"><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose a State" class="form-control chosen-select  input-lg" tabindex="2">						<option value="" disabled>Choose state - initially</option>	
										
									</select >
										</div>
                                        <!--<div class="input-group" id="active_city_id"></div>-->
                                        </div>
                                        </div>
                                         <!-- /.col-sm-6 -->
                                </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										<span class="input-group-addon tooltips" data-original-title="Number of adults"><i class="fa fa-user fa-fw"></i></span>
                                          <input type="text" class="tagname form-control" name="adults[]" id="adults" multiple placeholder="Adults" />
										</div>
                                       <!-- <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										<span class="input-group-addon tooltips" data-original-title="Number of children"><i class="fa  fa-users fa-fw"></i></span>
                                          <input type="text" class="tagname form-control" name="child[]" id="child" multiple placeholder="Children" />
										</div>
                                       <!-- <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                </div>
                                    
                                    
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										<span class="input-group-addon tooltips" data-original-title="Season 1 rates"><i class="fa  fa-cloud-download fa-fw"> 1</i></span>
                                          <input type="text" class="tagname form-control" name="season1[]" id="season1" multiple placeholder="Season 1 rates" />
										</div>
                                        <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										<span class="input-group-addon tooltips" data-original-title="Season 2 rates"><i class="fa  fa-cloud-download fa-fw"> 2</i></span>
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
                                  
										<span class="input-group-addon tooltips" data-original-title="Season 3 rates"><i class="fa  fa-cloud-download fa-fw"> 3</i></span>
                                          <input type="text" class="tagname form-control" name="season3[]" id="season3" multiple placeholder="Season 3 rates" />
										</div>
                                        <!--<small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										<span class="input-group-addon tooltips" data-original-title="Season 4 rates"><i class="fa  fa-cloud-download fa-fw"> 4</i></span>
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
                                  
										<span class="input-group-addon tooltips" data-original-title="Season 5 rates"><i class="fa  fa-cloud-download fa-fw"> 5</i></span>
                                          <input type="text" class="tagname form-control" name="season5[]" id="season5" multiple placeholder="Season 5 rates" />
										</div>
                                       <!-- <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                                  
										<span class="input-group-addon tooltips" data-original-title="Season 6 rates"><i class="fa fa-cloud-download fa-fw"> 6</i></span>
                                          <input type="text" class="tagname form-control" name="season6[]" id="season6" multiple placeholder="Season 6 rates" />
										</div>
                                       <!-- <small class="help-block" id="cityerr" style="color:#E9573F; display:none;"></small>-->
                                        </div>
                                        </div>
                                </div>
                                    
                                    
                                    
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-group pull-right">
                                    <button type="submit"  name="hotel_add" value="hotel_add_val" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Submit1</button>
                                    <button type="button" class="btn btn-sm btn-danger" onClick="parent.jQuery.fancybox.close();"><i class="fa fa-times"></i> Cancel</button>
                                        </div>
                                        </div>
                                </div>
                               <!--  <input type="hidden" class="form-control" name="MM_insertform" value="addvehiform">
                                <input type="hidden" id="cnt2"><input type="hidden" id="cnt3"><input type="hidden" id="cnt4"><input type="hidden" id="cnt5"><input type="hidden" id="cnt6"><input type="hidden" id="cnt7">-->
											
                                 </form>
                                 
                                </div>
							  </div>
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>
<?php }                    
  if(isset($_GET['type']) && $_GET['type']==md5(2)){?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-file-excel-o"></i> Upload file - Hotels</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
                            
								<div class="alert alert-danger alert-bold-border square fade in alert-dismissable">
								   <h4 align="center"><strong>Instructions!</strong></h4>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> Please Note that the allowed XL file format for upload is  <strong class="text-danger">*.CSV (Comma separated values) only.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i>  The File must consist of the following fields: Hotel_name, Location, City, State, Category, Type, Adults, Children,  season1_date, season2_date, season3_date, season4_date, season5_date, season6_date, Season1_rate, Season2_rate, Season3_rate, Season4_rate, Season5_rate, Season6_rate. Sample file attached for your reference<a href="../uploadexcel/Sample/hotel/sample_upload_hotels.csv" download style="text-decoration:none"><i class="fa fa-cloud-download fa-lg" ></i></a> .
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px; page-break-inside:auto">
                                <i class="fa fa-star"></i> Save your spreadsheet XL file with extension as <strong class="text-danger">.csv</strong> and click Upload. Files with format other than .csv will not be allowed. Once you upload and submit, your XL sheet will be validated and any errors found will be displayed. Correct the errors if any and re-upload the file&nbsp;.</strong>
                                 </p>
                                 <p class="text-muted text-justify" style="color:#434A54; text-indent:20px">
                                <i class="fa fa-star"></i> If you still get any problems on uploading your files, please Contact <a style="text-decoration:none;" href="http://www.elysiumtechnologies.com" target="new">Elysium Technologies</a>.</strong>
                                 </p>
                            
								</div>
                                 <form name="typeexcel" role="form"  method="post" enctype="multipart/form-data" onSubmit="Checkfiles()">
                                 <div class="row">
                                 <div class="col-sm-10" >
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
                                <div class="col-sm-2">
                                <div class="form-group">
									<div class="pull-right">
                                    <button type="submit"   class="btn btn-sm btn-success" name="subex_hotel" value="subex_hotel_val"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
                                </div>
                                 <input type="hidden" name="MM_insert" value="typeexcel" />
                                  <input type="hidden" id="errval" />
                                </form>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>
<?php }?>                        
                        </body>
                        
                        <script src="../core/assets/js/jquery.min.js"></script>
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
		<script src="../core/assets/plugins/skycons/skycons.js"></script>
		<script src="../core/assets/plugins/prettify/prettify.js"></script>
		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="../core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="../core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="../core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="../core/assets/plugins/markdown/markdown.js"></script>
		<script src="../core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="../core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
        
        
    <script>

$('.chosen-select').chosen({'width':'100%'});

function getXMLHTTP() 
{ //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
}


function find_city(state_id)
{
	var type=1;
		var strURL="ajax_hotel.php?sid="+state_id+"&type="+type;
		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4 && req.status == 200) {
							$('#default_city_id').empty().html(req.responseText);
							$('.chosen-select').chosen({'width':'100%'});
							$('.tooltips').tooltip({});
					} 
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}	
}
</script>     
        
        
        
                 
<script>

$('.tooltips').tooltip({});


//this is for tag validation
function ftagval()
{
	var tval;
	tval=$('#city').val();
	
	if(tval=='')
	{
		$('#tagerr').show('fade').html("Cities are required can't be empty.");
		return false;
	}
	else
	{
		$('#tagerr').empty().hide('fade');
		return true;
	}
}

$('.tagname').tagsInput({width:'auto'});

function chkfile()
{
	var filechk = $('#errval').val();
	if (filechk == '' || filechk ==1)
	{
		var txt;
		txt='Please choose file (.csv format) to upload';
		$('#err').html(txt).show('fade');
		$('#nametxt').css('border','1px solid #E9573F');
		return false
	}
	else
	{
		$('#err').empty().hide('fade');
		 $('#nametxt').css('border','1px solid #8CC152');
		return true;
	}
}

document.getElementById('confirm').addEventListener('change', checkFile, false);
approveletter.addEventListener('change', checkFile, false);

function checkFile(e) {

    var file_list = e.target.files;

    for (var i = 0, file; file = file_list[i]; i++) {
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
    }
	
}


</script>                        
<script>
//validation for vehicle update form
function exmapleval()
{
	
	//For name
	if($('#vnum').val()=='')
	{
		$('#vnum').css('border','1px solid #E8573F');
 		$('#vnumerr').html("This field is required.").slideDown('slow');
		$('#cnt2').val(0);
	}
	else
	{
		//For name
		$('#vnum').css('border','1px solid #8CC152');
		$('#vnumerr').empty().slideUp('slow');
		$('#cnt2').val(1);
		
	}
	
	//For perkilo meter
	if($('#perkilo').val()=='')
	{
		$('#perkilo').css('border','1px solid #E8573F');
 		$('#perklerr').html("This field is required.").slideDown('slow');
		$('#cnt3').val(0);
	}
	else if($.isNumeric($('#perkilo').val())==false)
	{
		$('#perkilo').css('border','1px solid #E8573F');
		$('#perklerr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt3').val(0);
	}
	else
	{
		//For perkilo meter
		$('#perkilo').css('border','1px solid #8CC152');
		$('#perklerr').empty().slideUp('slow');
		$('#cnt3').val(1);
		
	}
	
	//For total amount
	if($('#totamt').val()=='')
	{
		$('#totamt').css('border','1px solid #E8573F');
 		$('#totamterr').html("This field is required.").slideDown('slow');
		$('#cnt4').val(0);
	}
	else if($.isNumeric($('#totamt').val())==false)
	{
		$('#totamt').css('border','1px solid #E8573F');
		$('#totamterr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt4').val(0);
	}
	else
	{
		//For perkilo meter
		$('#totamt').css('border','1px solid #8CC152');
		$('#totamterr').empty().slideUp('slow');
		$('#cnt4').val(1);
	}
	
	//For seats
	if($('#seat').val()=='')
	{
		$('#totamt').css('border','1px solid #E8573F');
 		$('#seaterr').html("This field is required.").slideDown('slow');
		$('#cnt5').val(0);
	}
	else
	{
		//For perkilo meter
		$('#seat').css('border','1px solid #8CC152');
		$('#seaterr').empty().slideUp('slow');
		$('#cnt5').val(1);
		
	}
	
	//For extra charge
	if($('#exchrg').val()=='')
	{
		$('#exchrg').css('border','1px solid #E8573F');
 		$('#excherr').html("This field is required.").slideDown('slow');
		$('#cnt6').val(0);
	}
	else if($.isNumeric($('#exchrg').val())==false)
	{
		$('#exchrg').css('border','1px solid #E8573F');
		$('#excherr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt6').val(0);
	}
	else
	{
		//For perkilo meter
		$('#exchrg').css('border','1px solid #8CC152');
		$('#excherr').empty().slideUp('slow');
		$('#cnt6').val(1);
	}
	
	//For cities
	if($('#city').val()=='')
	{
 		$('#cityerr').html("This field is required.").slideDown('slow');
		$('#cnt7').val(0);
	}
	else
	{
		//For perkilo meter
		$('#cityerr').empty().slideUp('slow');
		$('#cnt7').val(1);
	}	
	var totval;
	totval=	parseInt($('#cnt2').val())+parseInt($('#cnt3').val())+parseInt($('#cnt4').val())+parseInt($('#cnt5').val())+parseInt($('#cnt6').val())+parseInt($('#cnt7').val());

	if(totval==6)
	{
		 return true;
	}
	else
	{
		return false;
	}

}
</script>
</html>
                        