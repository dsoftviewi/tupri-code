<style>
.ss{
   border: 1px solid #C7CED4;
   padding-bottom:6px;
}

.tt{
	background-color:#F9EEE0;
	padding-bottom:6px;
	color:#B16D14;
}
</style>
<?php 
require_once('../Connections/divdb.php');
session_start();

$plan_id= $_GET['plan_id1'].'#'.$_GET['plan_id2'];

if($_GET['res']=='show')//to show hotel information  before resume itinerary from ordstatus.php 
{

$resume = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$resume->execute(array($plan_id));
$row_resume = $resume->fetch(PDO::FETCH_ASSOC);
$totalRows_resume = $resume->rowCount();

$plan_idss_arr=explode('-',$row_resume['sub_paln_id']);
//print_r($plan_idss_arr);

$transport_only=0;
$addi_cost_of_itin=0;
foreach($plan_idss_arr as $pia)
{
	
	$resume_child = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
	$resume_child->execute(array($pia));
	$row_resume_child = $resume_child->fetch(PDO::FETCH_ASSOC);
	  
	$transport_only=$transport_only+$row_resume_child['tr_net_amt'];
	$addi_cost_of_itin=$addi_cost_of_itin+$row_resume_child['tot_additional_cost'];
}?>

<input type="hidden" value="<?php  echo $row_resume['sub_paln_id']; ?>" id="itn_form_tot" name="itn_form_tot"> 
<?php
//$transport_only=$row_resume['tr_net_amt'];
$agent_perc=$row_resume['agent_perc'];
$admin_perc=$row_resume['agnt_adm_perc'];

  $timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $ttoday=$date->format('Y-m-d');

	$hot_cag=$conn->prepare("select category from hotel_pro where status='0' GROUP BY category");
	$hot_cag->execute();
	//$row_hot_cag = mysql_fetch_assoc($hot_cag);
	$row_hot_cag_main=$hot_cag->fetchAll();
	$tot_hot_cag= $hot_cag->rowCount();
$gflag=0;
$cg=1;$hide5star=0;
foreach($row_hot_cag_main as $row_hot_cag)
{
	//echo "ALL =".$row_hot_cag['category'];
	if($row_hot_cag['category']!='HOUSEBOAT')
	{
		$categ=str_replace(' ', '', $row_hot_cag['category']);
		//echo "TA : ".$total_amount;
		$total_amount=0;
	?>
	<div class='col-sm-12' style="margin-top:5px;" id="div_catg_<?php echo $categ; ?>">
    <div class="row">
    <div class="col-sm-6" style="text-align:right; color:#930; font-weight:700"><?php echo "Option - ".$cg." : "; ?></div>
    <div class="col-sm-6"><a class="btn btn-sm  btn-info" id="btn_<?php echo $categ; ?>" onClick="set_cate('<?php echo $categ; ?>')"><?php echo $row_hot_cag['category']." Hotels"; ?></a></div>
    </div>
    <div id="catg_tab_<?php echo $categ; ?>" style="margin-top:5px;">
    <br />
    <center> 
    <table class="ss" style="width:95%" >
    <tr class="ss"><th style="width:5%" class="tt"  > &nbsp;S.No</th>
    <th style="width:12%" class="tt"> &nbsp;Date</th>
    <th style="width:20%" class="tt"> &nbsp;Place</th>
    <th style="width:25%" class="tt"> &nbsp;Hotel</th>
    <th style="width:20%" class="tt"> &nbsp;Room Category </th>
    <th style="width:8%" class="tt"> &nbsp;T Nights</th></tr>
    <?php 
$fr='';
$sno=1;
for($itin=0;$itin<count($plan_idss_arr);$itin++)
{
	$fr=$plan_idss_arr[$itin];
	

$resume = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$resume->execute(array($fr));
$row_resume =$resume->fetch(PDO::FETCH_ASSOC);
$totalRows_resume =$resume->rowCount();

	//start
	
$retrav = $conn->prepare("SELECT * FROM travel_sched where travel_id=? ORDER BY sno ASC");
$retrav->execute(array($fr));
//$row_retrav = mysql_fetch_assoc($retrav);
$row_retrav_main=$retrav->fetchAll();
$totalRows_retrav = $retrav->rowCount();

	$t=0;
	$ccid='';
	$ccid_names='';
	foreach($row_retrav_main as $row_retrav)
	{
		if($t!=$totalRows_retrav-1)
		{
			
			$cid = $conn->prepare("SELECT * FROM dvi_cities where name=?");
		$cid->execute(array($row_retrav['tr_to_cityid']));
		$row_cid = $cid->fetch(PDO::FETCH_ASSOC);
		$totalRows_cid = $cid->rowCount();
			
			if($ccid=='')
			{
				$ccid=$row_cid['id'];
				$ccid_names=$row_cid['name'];
			}else
			{
				$ccid=$ccid.','.$row_cid['id'];
				$ccid_names=$ccid_names.','.$row_cid['name'];
			}
		}
		$t++;
	}

		$stdate=$row_resume['tr_arr_date'];  
		//$stay_cnt=$_GET['stay_cntt'];  
		$cities_arr=explode(',',$ccid);
		$troom=trim($row_resume['stay_rooms']);
		$tot_fpax=(int)$row_resume['pax_adults']+(int)$row_resume['pax_512child'];
		$tot_pax=trim($row_resume['pax_cnt']);

		if($row_hot_cag['category']=="2STAR")
		{
		?>
			<input type="hidden" value="<?php echo $row_resume['room_info']; ?>" id="<?php echo $fr; ?>_room_info_pow" name="<?php echo $fr; ?>_room_info_pow" />
		    <input type="hidden" value="<?php echo $ccid; ?>" id="<?php echo $fr; ?>_city_ids_pow" name="<?php echo $fr; ?>_city_ids_pow" />
		    <input type="hidden" value="<?php echo $ccid_names; ?>" id="<?php echo $fr; ?>_city_idname_pow" name="<?php echo $fr; ?>_city_idname_pow" />
		    <input type="hidden" value="<?php echo $stdate; ?>" id="<?php echo $fr; ?>_stdate_pow" name="<?php echo $fr; ?>_stdate_pow" />
		    <input type="hidden" value="<?php echo $row_resume['stay_rooms']; ?>" id="<?php echo $fr; ?>_stay_rooms_pow" name="<?php echo $fr; ?>_stay_rooms_pow" />
		<?php
	}
	$food_catd="";
	$extbed=array();
	$choose_food='Breakfast';
	if(!empty($row_resume['room_info']))
	{
		$room_info_arr=explode('/',$row_resume['room_info']);
		$food_catd=$room_info_arr[4];
		$exbd=$room_info_arr[3];
		$extbed=explode(',',$exbd);
		//print_r($cities_arr);
		//end
	}
	
    for($ct=0;$ct<count($cities_arr);$ct++)
	{?>
		<tr class="ss"><td class="ss"><?php echo $sno++; ?></td>
        <td class="ss"><?php
			echo date("d-M-Y",strtotime($stdate));
			$stay_date=date("Y-m-d",strtotime($stdate));
		?>
        <input type="hidden" value="<?php echo $stay_date; ?>" name="<?php echo $fr.'_sdate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_sdate_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
			$hot_city=$conn->prepare("select * from dvi_cities where status='0' and id=?");
			$hot_city->execute(array($cities_arr[$ct]));
			$row_hot_city = $hot_city->fetch(PDO::FETCH_ASSOC);
		 	echo $row_hot_city['name']; 
		?>
    <input type="hidden" value="<?php echo $cities_arr[$ct]; ?>" name="<?php echo $fr.'_cyid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_cyid_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
		$check='-';
			$tdate=date("Y-m-d",strtotime($stdate));
			$season=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)");
			$season->execute();
			$row_season =$season->fetch(PDO::FETCH_ASSOC);
			$tot_season= $season->rowCount();
		
		if($tot_season>0)
		{
			// $sel_hotel="select * from hotel_pro where status='0' and (category='House Boat' or category='".$row_hot_cag['category']."') and city='".$cities_arr[$ct]."' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ";
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and  category=? and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC");
			$hotel->execute(array($row_hot_cag['category'],$cities_arr[$ct]));
			$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
			$tot_hotel= $hotel->rowCount();
			
			$season_id=$row_season['season_id'];
			if($tot_hotel>0)
			{
			//echo $row_hotel['hotel_name'];
			
				$hotel_edit=$conn->prepare("select * from hotel_pro where status='0' and category='HOUSEBOAT' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
				$hotel_edit->execute(array($cities_arr[$ct]));
				//$row_hotel_edit = mysql_fetch_assoc($hotel_edit);
				$row_hotel_edit_main=$hotel_edit->fetchAll();
				$tot_hotel_edit= $hotel_edit->rowCount();
				
				if($tot_hotel_edit>0)
				{
					?>
                    <select class="form-control chosen-select" onchange="houseboat_editable(this.value,'<?php echo $categ; ?>','<?php echo $ct; ?>','<?php echo $fr; ?>')">
                    	<option selected="selected" value="<?php echo $row_hotel['hotel_id']; ?>"><?php echo $row_hotel['hotel_name'];?></option>
                        <?php
						foreach($row_hotel_edit_main as $row_hotel_edit)
						{?>
							<option value="<?php echo $row_hotel_edit['hotel_id']; ?>"><?php echo $row_hotel_edit['hotel_name']; ?></option>
						<?php } ?>
                    </select>
                     <?php
				}else{
					echo $row_hotel['hotel_name'];
				}
			
			/*	if($row_hotel['category']=='House Boat')
				{
					echo "HOUSE";
					echo $tot_fpax;
					$check='HB';
				}*/
			
			$hotl_id=$row_hotel['hotel_id'];
			
			$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
			$hfood->execute(array($row_hotel['hotel_id']));
			$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=substr($season_id, -6, 1);
									$lunchrate_arr=explode('\\',$row_hfood['lunch_rate']);
									$lunchrate=$lunchrate_arr[$ss-1];
									
									$dinnerrate_arr=explode('\\',$row_hfood['dinner_rate']);
									$dinnerrate=$dinnerrate_arr[$ss-1];
									
									$chwithbed_arr=explode('\\',$row_hfood['child_with_bed']);
									$chwithbedrate=$chwithbed_arr[$ss-1];
									
									$chwithoutbed_arr=explode('\\',$row_hfood['child_without_bed']);
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									
									$flowerbed_arr=explode('\\',$row_hfood['flower_bed']);
									$flowerbedrate=$flowerbed_arr[$ss-1];
									
									$candle_arr=explode('\\',$row_hfood['candle_light']);
									$candlerate=$candle_arr[$ss-1];
									
									$cake_arr=explode('\\',$row_hfood['cake_rate']);
									$cakerate=$cake_arr[$ss-1];
									
									$fruit_arr=explode('\\',$row_hfood['fruit_basket']);
									$fruitrate=$cake_arr[$ss-1];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									//if($check!='HB')//extra bed calc to only without house boating/ because extra bed calculated below - room category
									//{
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
											//echo "f".$check;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
									//}
			}else if(trim($row_hot_cag['category'])!='5 Star' && trim($row_hot_cag['category'])!='5STAR' && trim($row_hot_cag['category'])!='5star'){// if unavailable hotel for particular hotel_categories - without 5 star category
			$hotel1=$conn->prepare("select * from hotel_pro where status='0' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
			$hotel1->execute(array($cities_arr[$ct]));
			$row_hotel1 = $hotel1->fetch(PDO::FETCH_ASSOC);
			$tot_hotel1= $hotel1->rowCount();
			
			echo $row_hotel1['hotel_name']." ( ".$row_hotel1['category']." )";
			$hotl_id=$row_hotel1['hotel_id'];
			
			$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
			$hfood->execute(array($row_hotel1['hotel_id']));
			$row_hfood =$hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=substr($season_id, -6, 1);
									$lunchrate_arr=explode('\\',$row_hfood['lunch_rate']);
									$lunchrate=$lunchrate_arr[$ss-1];
									
									$dinnerrate_arr=explode('\\',$row_hfood['dinner_rate']);
									$dinnerrate=$dinnerrate_arr[$ss-1];
									
									$chwithbed_arr=explode('\\',$row_hfood['child_with_bed']);
									$chwithbedrate=$chwithbed_arr[$ss-1];
									
									$chwithoutbed_arr=explode('\\',$row_hfood['child_without_bed']);
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									
									$flowerbed_arr=explode('\\',$row_hfood['flower_bed']);
									$flowerbedrate=$flowerbed_arr[$ss-1];
									
									$candle_arr=explode('\\',$row_hfood['candle_light']);
									$candlerate=$candle_arr[$ss-1];
									
									$cake_arr=explode('\\',$row_hfood['cake_rate']);
									$cakerate=$cake_arr[$ss-1];
									
									$fruit_arr=explode('\\',$row_hfood['fruit_basket']);
									$fruitrate=$cake_arr[$ss-1];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else if($food_catd=='no'){
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
			}else{
				echo "-";
				$hotl_id='-';
			}
			
		}else{
			echo " Locked ";	//season lock
			$hotl_id='-';
		}
		
		if(trim($row_hot_cag['category'])=='5 Star' || trim($row_hot_cag['category'])=='5STAR' || trim($row_hot_cag['category'])=='5star')
		{
			if($hotl_id=='-' && $hide5star==0)
			{?>
					<input type="hidden" value="<?php echo $categ; ?>" id="hide_5star" name="hide_5star" />
			<?php 
			$hide5star++;
			$cg--;
			}
		}
		?>
<input type="hidden" value="<?php echo $hotl_id; ?>" name="<?php echo $fr.'_hid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_hid_'.$categ.'_'.$ct; ?>"  />

        </td>
        <td class="ss"><?php
			if($hotl_id != '-')
			{
				if($check=='HB')//HB means House Boating
				{
					//$tot_fpax=5;
						$num_fpaxs=$tot_fpax;
						if($num_fpaxs==2)
						{
							$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='01 Bed Room - Premium' ORDER BY $season_id ASC");
									$hrooom->execute(array($hotl_id));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									//echo $row_hrooom['room_type'].'- With extra bed';
									echo $row_hrooom['room_type'];
									$room_sno=$row_hrooom['sno'];
									$room_rent=$row_hrooom[$season_id];
									$total_amount=$total_amount+($room_rent);
									//echo "01 Bed Room - Premium";
							
						}else if($num_fpaxs==3)
						{
									$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='01 Bed Room - Premium' ORDER BY $season_id ASC");
									$hrooom->execute(array($hotl_id));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									echo $row_hrooom['room_type'].'- With extra bed';
									$room_sno=$row_hrooom['sno'];
									$room_rent=$row_hrooom[$season_id];
									echo "LOLO=".$total_amount;
									echo "BT=".$total_amount=$total_amount+$room_rent;
								echo "chbed=".$chwithbedrate;
								echo "TTT".$room_rent=$room_rent+$chwithbedrate;
								echo "AT=".$total_amount=$total_amount+$chwithbedrate;//for one extra bed
																	
							//echo "01 Bed Room - Premium+ extra bed";
						}else if($num_fpaxs>=4)
						{
							 $no_rrs=floor($num_fpaxs / 2);
							 $tempMod = (float)($num_fpaxs / 2);
  							 $tempMod = ($tempMod - (int)$tempMod)*2;
							
									$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='02 Bed Room - Premium' ORDER BY $season_id ASC");
									$hrooom->execute(array($hotl_id));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									//echo $row_hrooom['room_type'].'- With extra bed';
									$room_sno=$row_hrooom['sno'];
									$room_rent=$row_hrooom[$season_id];
									$total_amount=$total_amount+($room_rent*$no_rrs);
									$rom_rent_tt=$room_rent*$no_rrs;
									//to input below
									$room_rent=$rom_rent_tt;
									
							echo $no_rrs."-02 Bed Room - Premium";
							if($tempMod==1)
							{
							echo "+one extra bed";	
							$room_rent=$room_rent+$chwithbedrate;
							$total_amount=$total_amount+$chwithbedrate;
							}
							
						}
				}else{
					$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? ORDER BY $season_id ASC");
					$hrooom->execute(array($hotl_id));
					$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
					$tot_hrooom= $hrooom->rowCount();
					echo $row_hrooom['room_type'];
					$room_sno=$row_hrooom['sno'];
					$room_rent=$row_hrooom[$season_id];
					$total_amount=$total_amount+($room_rent*$troom);
				}
			}else{
				echo " - ";	
				$room_sno='-';
				$room_rent='-';
			}
		?>
        <input type="hidden" value="<?php echo $room_sno; ?>" name="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>"  />
        <input type="hidden" value="<?php echo $room_rent; ?>" name="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php echo "1"; ?></td></tr>
	<?php
			$date=date_create($stdate);
			date_add($date,date_interval_create_from_date_string("1 days"));
			$stdate= date_format($date,"d-M-Y");
	//echo $hotl_id."-".$total_amount;
	 }//for end

	}//main for loop?>
    </table>
    </center>
    <div class="row" style="margin-top:10px;">
    <div class="col-sm-6" align="center"><?php echo "Number of Rooms - ".$troom." ( Pax : ".$tot_pax." )";
								
								$rrom=$extbed;
	$rrom1=array_unique($rrom);
	//print_r($rrom1);
	$rrom1=array_values($rrom1);
	$rrom2=array_count_values($rrom);
	//print_r($rrom2);
	
	for($tt=0;$tt<count($rrom1);$tt++)
	{
		if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='' && $rrom1[$tt+1] !='-')
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg.",&nbsp;"; 
			}
		}else
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg; 
			}
		}
	}
								/*	for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											echo "- With Bed -";
										}else if($extbed[$e]=='1'){
											echo "- Without Extra Bed -";
										}
									}*/
	?>
    </div>
    <?php 
	//echo "hotel only ".$total_amount;
	//echo "<br>trans".$transport_only; 
	$itin_amt=($total_amount+$transport_only+$addi_cost_of_itin);
	//echo "AGENT =".$agent_perc;
	//echo "ADMIN =".$admin_perc;
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
    <div class="col-sm-6" align="center">Cost: <?php echo round($admin_itin_amt)."/- Only";?> [ including <?php echo $choose_food; ?> ]</div>
    </div>
    <hr style="margin-top:10px; margin-bottom:10px;" />
    </div>
   
	</div>
<?php 
$cg++;
$stdate=$row_resume['tr_arr_date'];
	}//if for house boat
}//while end
//combination of 2star and 3 star hotels

//combination of HOUSEBOAT hotels
$check_city=explode(',',$ccid);//to find houseboating is available in any cities
$house_avail='no';
for($hh=0;$hh<count($check_city);$hh++)
{
	$hotel_avail=$conn->prepare("select * from hotel_pro where status='0' and category='HOUSEBOAT' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
			$hotel_avail->execute(array($check_city[$hh]));
			$row_hotel_avail = $hotel_avail->fetch(PDO::FETCH_ASSOC);
			$tot_hotel_avail= $hotel_avail->rowCount();
			if($tot_hotel_avail>0)
			{
				$house_avail='yes';
			}
}
//echo $house_avail;

if($house_avail=='yes')
{
$check='-';
$categ="HOUSEBOAT"; 
$total_amount=0;
$same_city=0;
?>
<div class='col-sm-12' style="margin-top:5px;" id="div_catg_<?php echo $categ; ?>">
<div class="row">
<div class="col-sm-6" style="text-align:right; color:#930; font-weight:700"><?php echo "Option - ".$cg." : "; $cg++;?>
</div>
<div class="col-sm-6"><a class="btn btn-sm  btn-info" id="btn_<?php echo $categ; ?>" onClick="set_cate('<?php echo $categ; ?>')"><?php echo "HOUSE BOAT"; ?></a></div>
</div>
	    
    <div id="catg_tab_<?php echo $categ; ?>" style="margin-top:5px;">
    <br />
    <center>
    <table class="ss" style="width:95%">
    <tr class="ss"><th style="width:5%" class="tt"  > &nbsp;S.No</th>
    <th style="width:12%" class="tt"> &nbsp;Date</th>
    <th style="width:20%" class="tt"> &nbsp;Place</th>
    <th style="width:25%" class="tt"> &nbsp;Hotel</th>
    <th style="width:20%" class="tt"> &nbsp;Room Category </th>
    <th style="width:8%" class="tt"> &nbsp;T Nights</th></tr>
    <?php 
$fr='';
$sno=1;
for($itin=0;$itin<count($plan_idss_arr);$itin++)
{
	$fr=$plan_idss_arr[$itin];
	

$resume = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$resume->execute(array($fr));
$row_resume =$resume->fetch(PDO::FETCH_ASSOC);
$totalRows_resume =$resume->rowCount();
	
	//start
	
	$retrav = $conn->prepare("SELECT * FROM travel_sched where travel_id=? ORDER BY sno ASC");
$retrav->execute(array($fr));
//$row_retrav = mysql_fetch_assoc($retrav);
$row_retrav_main=$retrav->fetchAll();
$totalRows_retrav = $retrav->rowCount();

	$t=0;
	$ccid='';
	$ccid_names='';
	foreach($row_retrav_main as $row_retrav)
	{
		if($t!=$totalRows_retrav-1)
		{
			
			$cid = $conn->prepare("SELECT * FROM dvi_cities where name=?");
		$cid->execute(array($row_retrav['tr_to_cityid']));
		$row_cid = $cid->fetch(PDO::FETCH_ASSOC);
		$totalRows_cid = $cid->rowCount();
			
			if($ccid=='')
			{
				$ccid=$row_cid['id'];
				$ccid_names=$row_cid['name'];
			}else
			{
				$ccid=$ccid.','.$row_cid['id'];
				$ccid_names=$ccid_names.','.$row_cid['name'];
			}
		}
		$t++;
	}

		$stdate=$row_resume['tr_arr_date'];  
		//$stay_cnt=$_GET['stay_cntt'];  
		$cities_arr=explode(',',$ccid);
		$troom=trim($row_resume['stay_rooms']);
		$tot_fpax=(int)$row_resume['pax_adults']+(int)$row_resume['pax_512child'];
		$tot_pax=trim($row_resume['pax_cnt']);
		?>
			<!--<input type="hidden" value="<?php echo $row_resume['room_info']; ?>" id="<?php echo $fr; ?>_room_info_pow" name="<?php echo $fr; ?>_room_info_pow" />
		    <input type="hidden" value="<?php echo $ccid; ?>" id="<?php echo $fr; ?>_city_ids_pow" name="<?php echo $fr; ?>_city_ids_pow" />
		    <input type="hidden" value="<?php echo $ccid_names; ?>" id="<?php echo $fr; ?>_city_idname_pow" name="<?php echo $fr; ?>_city_idname_pow" />
		    <input type="hidden" value="<?php echo $stdate; ?>" id="<?php echo $fr; ?>_stdate_pow" name="<?php echo $fr; ?>_stdate_pow" />
		    <input type="hidden" value="<?php echo $row_resume['stay_rooms']; ?>" id="<?php echo $fr; ?>_stay_rooms_pow" name="<?php echo $fr; ?>_stay_rooms_pow" /> -->
		<?php
		$room_info_arr=explode('/',$row_resume['room_info']);
		$food_catd=$room_info_arr[4];
		$exbd=$room_info_arr[3];
		$extbed=explode(',',$exbd);
		//print_r($cities_arr);
		//end
	
	$flag=0;
	for($ct=0;$ct<count($cities_arr);$ct++)
	{
		$check='-';
		?>
		<tr class="ss"><td class="ss"><?php echo $sno++; ?></td>
        <td class="ss"><?php
			echo date("d-M-Y",strtotime($stdate)); 
			$stay_date=date("Y-m-d",strtotime($stdate));
		?>
        <input type="hidden" value="<?php echo $stay_date; ?>" name="<?php echo $fr.'_sdate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_sdate_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
			$hot_city=$conn->prepare("select * from dvi_cities where status='0' and id=?");
			$hot_city->execute(array($cities_arr[$ct]));
			$row_hot_city = $hot_city->fetch(PDO::FETCH_ASSOC);
		 	echo $row_hot_city['name']; 
		?>
      <input type="hidden" value="<?php echo $cities_arr[$ct]; ?>" name="<?php echo $fr.'_cyid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_cyid_'.$categ.'_'.$ct; ?>"/>
        </td>
        <td class="ss"><?php
			$tdate=date("Y-m-d",strtotime($stdate));
			$season=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)");
			$season->execute();
			$row_season =$season->fetch(PDO::FETCH_ASSOC);
			$tot_season= $season->rowCount();
			$season_id=$row_season['season_id'];
		if($tot_season>0)
		{
			if($flag==0)
			{
				$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='HOUSEBOAT' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
				$hotel->execute(array($cities_arr[$ct]));
				$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
				$tot_hotel= $hotel->rowCount();
			
			}else{//this is for next day having same city - choose hotel - not houseboat
				
				 $hotel=$conn->prepare("select * from hotel_pro where status='0' and category='HOUSEBOAT' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
				$hotel->execute(array($cities_arr[$ct]));
				$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
				$tot_hotel= $hotel->rowCount();
			
			}
			
					if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
					{
						$flag=1;//same
					}else
					{
						$flag=0;
					}
					
			if($tot_hotel>0)
			{
				
				if($row_hotel['category']=='HOUSEBOAT')
				{
					//echo "HOUSE";
					//echo $tot_fpax;
					$check='HB';
				}
			echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
			$hotl_id=$row_hotel['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=substr($season_id, -6, 1);
									$lunchrate_arr=explode('\\',$row_hfood['lunch_rate']);
									$lunchrate=$lunchrate_arr[$ss-1];
									
									$dinnerrate_arr=explode('\\',$row_hfood['dinner_rate']);
									$dinnerrate=$dinnerrate_arr[$ss-1];
									
									$chwithbed_arr=explode('\\',$row_hfood['child_with_bed']);
									$chwithbedrate=$chwithbed_arr[$ss-1];
									
									$chwithoutbed_arr=explode('\\',$row_hfood['child_without_bed']);
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									
									$flowerbed_arr=explode('\\',$row_hfood['flower_bed']);
									$flowerbedrate=$flowerbed_arr[$ss-1];
									
									$candle_arr=explode('\\',$row_hfood['candle_light']);
									$candlerate=$candle_arr[$ss-1];
									
									$cake_arr=explode('\\',$row_hfood['cake_rate']);
									$cakerate=$cake_arr[$ss-1];
									
									$fruit_arr=explode('\\',$row_hfood['fruit_basket']);
									$fruitrate=$cake_arr[$ss-1];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									if($check!='HB')//extra bed calc to only without house boating/ because extra bed calculated below - room category
									{
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
									}
				
			}else{ //if the hotels unavailable in HouseBoating pick any hotel from any category by priority
				$hote2=$conn->prepare("select * from hotel_pro where status='0' and category='HOUSEBOAT' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
				$hote2->execute(array($cities_arr[$ct]));
				$row_hote2 = $hote2->fetch(PDO::FETCH_ASSOC);
				$tot_hote2= $hote2->rowCount();
			
			echo $row_hotel2['hotel_name']." ( ".$row_hotel2['category']." )";
			$hotl_id=$row_hotel2['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel2['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=substr($season_id, -6, 1);
									$lunchrate_arr=explode('\\',$row_hfood['lunch_rate']);
									$lunchrate=$lunchrate_arr[$ss-1];
									
									$dinnerrate_arr=explode('\\',$row_hfood['dinner_rate']);
									$dinnerrate=$dinnerrate_arr[$ss-1];
									
									$chwithbed_arr=explode('\\',$row_hfood['child_with_bed']);
									$chwithbedrate=$chwithbed_arr[$ss-1];
									
									$chwithoutbed_arr=explode('\\',$row_hfood['child_without_bed']);
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									
									$flowerbed_arr=explode('\\',$row_hfood['flower_bed']);
									$flowerbedrate=$flowerbed_arr[$ss-1];
									
									$candle_arr=explode('\\',$row_hfood['candle_light']);
									$candlerate=$candle_arr[$ss-1];
									
									$cake_arr=explode('\\',$row_hfood['cake_rate']);
									$cakerate=$cake_arr[$ss-1];
									
									$fruit_arr=explode('\\',$row_hfood['fruit_basket']);
									$fruitrate=$cake_arr[$ss-1];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									if($check!='HB')//extra bed calc to only without house boating/ because extra bed calculated below - room category
									{
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
									}
			}
			
		}else{
			echo " Locked ";	//season lock
			$hotl_id='-';
		}
		?>
        <input type="hidden" value="<?php echo $hotl_id; ?>" name="<?php echo $fr.'_hid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_hid_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
			if($hotl_id != '-')
			{
				//echo $check;
				$bed_cn=1;
				if($check=='HB')
				{
					$dvn=0;
					$remd=0;
					$rm_sel_name1='-';
					$rm_sel_name2='-';
					$with_extra='-';
					$bet='';
						 $num_fpaxs=$tot_fpax;
						 
						 $dvn=floor($num_fpaxs/6);
						 $remd=floor($num_fpaxs%6);
						 
						 if($remd==0)
						 {
							// $rm_sel_name="  $dvn  - Trible";
							 	$rm_sel_name1='Three Cabin';
								$rm_sel_name2='-';
								$with_extra='';
						 }else if($remd==1)
						 {
							if($dvn==0)
							{
								//echo "single bed";
								$rm_sel_name1='One Cabin';
								$rm_sel_name2='-';
								$with_extra='';
								
							}else if($dvn>0)
							{
								$rm_sel_name1='Three Cabin';
								$rm_sel_name2='-';
								$with_extra='yes';
								//echo "$dvn - trible +1ext";	
							}
						 }else if($remd==2)
						 {
							if($dvn==0)
							{
								//$rm_sel_name="single bed";
								$rm_sel_name1='One Cabin';
								$rm_sel_name2='-';
								$with_extra='';
									
							}else if($dvn>=$remd){
								//$rm_sel_name=" $dvn  - Trible + $remd extrabed";
								$rm_sel_name1='Three Cabin';
								$rm_sel_name2='-';
								$with_extra='yes';
								$bed_cn=$remd;
							}else{
								//$rm_sel_name=" $dvn  - Trible + single bed";
								$rm_sel_name1='Three Cabin';
								$rm_sel_name2='One Cabin';
								$with_extra='';
							}
						 }
						 else if($remd==3)
						 {
							 if($dvn==0)
							 {
								// $rm_sel_name="single bed + extra";
								 $rm_sel_name1='One Cabin';
								 $rm_sel_name2='-';
								 $with_extra='yes';
							 }else if($dvn>=$remd)
							 {
								//$rm_sel_name=" $dvn  - Trible + $remd extrabed"; 
								$rm_sel_name1='Three Cabin';
								 $rm_sel_name2='-';
								 $with_extra='yes';
								 $bed_cn=$remd;
							 }else{
								 //$rm_sel_name="$dvn - Trible + single + extra";
								 $rm_sel_name1='Three Cabin';
								 $rm_sel_name2='One Cabin';
								 $with_extra='yes';
							 }
							
						 }else if($remd==4)
						 {
							 if($dvn==0)
							 {
								//$rm_sel_name="Double";
								 $rm_sel_name1='Two Cabin';
								 $rm_sel_name2='-';
								 $with_extra='';
							 }else 
							 {
								// $rm_sel_name=" $dvn  - Trible + Double"; 
								 $rm_sel_name1='Three Cabin';
								 $rm_sel_name2='Two Cabin';
								 $with_extra='';
							 }
							
						 }else if($remd==5)
						 {
							  if($dvn==0)
							  {
								//$rm_sel_name="Double + extra";  
								$rm_sel_name1='Two Cabin';
								 $rm_sel_name2='-';
								 $with_extra='yes';
							  }else{
								  //$rm_sel_name="$dvn  - Trible + Double + 1extra"; 
								 $rm_sel_name1='Three Cabin';
								 $rm_sel_name2='Two Cabin';
								 $with_extra='yes'; 
							  }
						 }
						 //logic 
						if($rm_sel_name1!='-')
						{
							
							$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=? ORDER BY $season_id ASC");
									$hrooom->execute(array($hotl_id,$rm_sel_name1));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									//echo $row_hrooom['room_type'].'- With extra bed';
									
									if($tot_hrooom==0)
									{//if trible bedroom unavailable means
									$num_fpaxs=$tot_fpax;
						 			$dvn=floor($num_fpaxs/4);
									$remd=floor($num_fpaxs%4);
									
									if($remd==0)
									{
										//only counted Two Cabin
										$rm_sel_name1='Two Cabin';
								 		$rm_sel_name2='-';
								 		$with_extra='';
										
									}else if($remd==1)
									{
										//only counted Two Cabin + extra
										if($dvn==0)
										{
											$rm_sel_name1='One Cabin';
								 			$rm_sel_name2='-';
								 			$with_extra='';
										}else if($dvn>0){
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='-';
								 			$with_extra='yes';
											$bed_cn=$remd;
										}
									}else if($remd==2)
									{
										if($dvn==0)
										{
											$rm_sel_name1='One Cabin';
								 			$rm_sel_name2='-';
								 			$with_extra='';
										}else if($dvn>=$remd){
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='One Cabin';
								 			$with_extra='';
											$bed_cn=$remd;
										}else{
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='One Cabin';
								 			$with_extra='';
										}
									}else if($remd==3)
									{
										if($dvn==0)
										{
											$rm_sel_name1='One Cabin';
								 			$rm_sel_name2='-';
								 			$with_extra='yes';
										}else if($dvn>=$remd){
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='One Cabin';
								 			$with_extra='yes';
											$bed_cn=$remd;
										}else{
											$rm_sel_name1='Two Cabin';
								 			$rm_sel_name2='One Cabin';
								 			$with_extra='yes';
										}
									}
									 $hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=? ORDER BY $season_id ASC");
									$hrooom->execute(array($hotl_id,$rm_sel_name1));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									
									}//if trible bedroom is unavailable
									
									$room_sno=$row_hrooom['sno'];
									$room_rent=$row_hrooom[$season_id];
									if($dvn==0)
									{
										
										$total_amount=$total_amount+($room_rent);
										echo $row_hrooom['room_type'];
										$bet='-';
									}else{
										$bet='-';
										$total_amount=$total_amount+($dvn*$room_rent);
										for($d=0;$d<$dvn-1;$d++)
										{
											$room_sno=$room_sno.','.$row_hrooom['sno'];
											$room_rent=$room_rent.','.$room_rent;
											$bet=$bet.',-';
										}
										echo $dvn."-".$row_hrooom['room_type'];
									}
						}
						if($rm_sel_name2!='-')
						{
									$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=? ORDER BY $season_id ASC");
									$hrooom->execute(array($hotl_id,$rm_sel_name2));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									echo ", ".$row_hrooom['room_type'];
									$room_snoo=$row_hrooom['sno'];
									$room_sno=$room_sno.','.$room_snoo;
									
									$room_rento=$row_hrooom[$season_id];
									$room_rent=$room_rent.','.$room_rento;
									$total_amount=$total_amount+$room_rento;
						}
						
						if($with_extra=='yes')
						{
							$bet='';
							if($dvn==1 && $bed_cn==1)
							{
								$bet="0";
							}else if($dvn>0)
							{
								$bcn=$bed_cn;
								if($dvn>=$bed_cn)
								{
									for($nu=0;$nu<$dvn;$nu++)
									{  
									 if($bcn!=0)
										{	
											if($bet=='')
											{
												$bet="0";
											}else{
												$bet=$bet.",0";
											}
									 	$bcn--;
										}
									}
								}
							}else{
								$bet='0';
							}
							    echo ", ".$bed_cn."-Extra Bed";
								//echo "chbed=".$chwithbedrate;
								$total_amount=$total_amount+($bed_cn*$chwithbedrate);//for one extra bed
						}
						if($rm_sel_name2!='-')
							{
								$bet=$bet.",-";
							}
						?>
                        <input type="hidden" value="<?php echo $bet; ?>" name="<?php echo $fr.'_rmextr_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rmextr_'.$categ.'_'.$ct; ?>"  />
                        <?php
				}else{
					$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? ORDER BY $season_id ASC");
					$hrooom->execute(array($hotl_id));
					$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
					$tot_hrooom= $hrooom->rowCount();
					echo $row_hrooom['room_type'];
					$room_sno=$row_hrooom['sno'];
					$room_rent=$row_hrooom[$season_id];
					$total_amount=$total_amount+($room_rent*$troom);
				}
			}else{
			echo " - ";	
			$room_sno='-';
			$room_rent='-';
			}
			
		?>
        
        <input type="hidden" value="<?php echo $room_sno; ?>" name="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>"  />
        <input type="hidden" value="<?php echo $room_rent; ?>" name="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>"  />
        
        </td>
        <td class="ss"><?php echo "1"; ?></td></tr>
	<?php
			$date=date_create($stdate);
			date_add($date,date_interval_create_from_date_string("1 days"));
			$stdate= date_format($date,"d-M-Y");
	
	 }//for end

	}//main for loop 
	?>
    </table>
    </center>
    <div class="row" style="margin-top:10px;">
     <div class="col-sm-6" align="center"><?php echo "Number of Rooms - ".$troom." ( Pax : ".$tot_pax." )";
							
							$rrom=$extbed;
	$rrom1=array_unique($rrom);
	$rrom1=array_values($rrom1);
	//print_r($rrom1);
	$rrom2=array_count_values($rrom);
	//print_r($rrom2);
	
	for($tt=0;$tt<count($rrom1);$tt++)
	{
		if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='' && $rrom1[$tt+1] !='-')
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
				echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg.",&nbsp;"; 
			}
		}else
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
				echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg; 
			}
		}
	}
	?>
    </div>
    <?php // echo "hotel only ".$total_amount; 
	// echo "hotel only ".$total_amount;
	//echo "<br>trans".$transport_only; 
	$itin_amt=($total_amount+$transport_only+$addi_cost_of_itin);
	//echo "AGENT =".$agent_perc;
	//echo "ADMIN =".$admin_perc;
	$itin_amt=($total_amount+$transport_only);
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
    
    <div class="col-sm-6" align="center">Cost: <?php echo round($admin_itin_amt)."/- Only";?> [ including <?php echo $choose_food; ?> ]</div>
    </div>
    <hr style="margin-top:10px; margin-bottom:10px;" />
	</div>
    
    
    </div>
	</div>
<!--- combination of houseboat hotels end -->

<?php
}//if houseboat available means else dont display houseboat option


//combination of 2star and 3 star hotels

$categ="2star3star"; 
$total_amount=0;
$same_city=0;
$stdate=$row_resume['tr_arr_date']; 

?>
<div class='col-sm-12' style="margin-top:5px;" id="div_catg_<?php echo $categ; ?>">
<div class="row">
<div class="col-sm-6" style="text-align:right; color:#930; font-weight:700"><?php echo "Option - ".$cg." : "; $cg++;?>
</div>
<div class="col-sm-6"><a class="btn btn-sm  btn-info" id="btn_<?php echo $categ; ?>" onClick="set_cate('<?php echo $categ; ?>')"><?php echo "Combination of 2 star & 3 star Hotels"; ?></a></div>
</div>
	    
    <div id="catg_tab_<?php echo $categ; ?>" style="margin-top:5px;">
    <br />
    <center>
    <table class="ss" style="width:95%">
    <tr class="ss"><th style="width:5%" class="tt"  > &nbsp;S.No</th>
    <th style="width:12%" class="tt"> &nbsp;Date</th>
    <th style="width:20%" class="tt"> &nbsp;Place</th>
    <th style="width:25%" class="tt"> &nbsp;Hotel</th>
    <th style="width:20%" class="tt"> &nbsp;Room Category </th>
    <th style="width:8%" class="tt"> &nbsp;T Nights</th></tr>
    <?php 
 
$fr='';
$sno=1;
for($itin=0;$itin<count($plan_idss_arr);$itin++)
{
	$fr=$plan_idss_arr[$itin];
	

$resume = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$resume->execute(array($fr));
$row_resume =$resume->fetch(PDO::FETCH_ASSOC);
$totalRows_resume =$resume->rowCount();
	
	//start
	
	$retrav = $conn->prepare("SELECT * FROM travel_sched where travel_id=? ORDER BY sno ASC");
$retrav->execute(array($fr));
//$row_retrav = mysql_fetch_assoc($retrav);
$row_retrav_main=$retrav->fetchAll();
$totalRows_retrav = $retrav->rowCount();

	$t=0;
	$ccid='';
	$ccid_names='';
	foreach($row_retrav_main as $row_retrav)
	{
		if($t!=$totalRows_retrav-1)
		{
			
			$cid = $conn->prepare("SELECT * FROM dvi_cities where name=?");
		$cid->execute(array($row_retrav['tr_to_cityid']));
		$row_cid = $cid->fetch(PDO::FETCH_ASSOC);
		$totalRows_cid = $cid->rowCount();
			
			if($ccid=='')
			{
				$ccid=$row_cid['id'];
				$ccid_names=$row_cid['name'];
			}else
			{
				$ccid=$ccid.','.$row_cid['id'];
				$ccid_names=$ccid_names.','.$row_cid['name'];
			}
		}
		$t++;
	}

		$stdate=$row_resume['tr_arr_date'];  
		//$stay_cnt=$_GET['stay_cntt'];  
		$cities_arr=explode(',',$ccid);
		$troom=trim($row_resume['stay_rooms']);
		$tot_fpax=(int)$row_resume['pax_adults']+(int)$row_resume['pax_512child'];
		$tot_pax=trim($row_resume['pax_cnt']);
		?>
			<!-- <input type="hidden" value="<?php echo $row_resume['room_info']; ?>" id="<?php echo $fr; ?>_room_info_pow" name="<?php echo $fr; ?>_room_info_pow" />
		    <input type="hidden" value="<?php echo $ccid; ?>" id="<?php echo $fr; ?>_city_ids_pow" name="<?php echo $fr; ?>_city_ids_pow" />
		    <input type="hidden" value="<?php echo $ccid_names; ?>" id="<?php echo $fr; ?>_city_idname_pow" name="<?php echo $fr; ?>_city_idname_pow" />
		    <input type="hidden" value="<?php echo $stdate; ?>" id="<?php echo $fr; ?>_stdate_pow" name="<?php echo $fr; ?>_stdate_pow" />
		    <input type="hidden" value="<?php echo $row_resume['stay_rooms']; ?>" id="<?php echo $fr; ?>_stay_rooms_pow" name="<?php echo $fr; ?>_stay_rooms_pow" />  -->
		
		<?php
		$food_catd="";
	$extbed=array();
	$choose_food='Breakfast';
	if(!empty($row_resume['room_info']))
	{
		
		$room_info_arr=explode('/',$row_resume['room_info']);
		$food_catd=$room_info_arr[4];
		$exbd=$room_info_arr[3];
		$extbed=explode(',',$exbd);
		//print_r($cities_arr);
		//end
	
	}
	$flag=0;
	for($ct=0;$ct<count($cities_arr);$ct++)
	{?>
		<tr class="ss"><td class="ss"><?php echo $sno++; ?></td>
        <td class="ss"><?php
			echo date("d-M-Y",strtotime($stdate)); 
			$stay_date=date("Y-m-d",strtotime($stdate));
		?>
        <input type="hidden" value="<?php echo $stay_date; ?>" name="<?php echo $fr.'_sdate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_sdate_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
			$hot_city=$conn->prepare("select * from dvi_cities where status='0' and id=?");
			$hot_city->execute(array($cities_arr[$ct]));
			$row_hot_city = $hot_city->fetch(PDO::FETCH_ASSOC);
		 	echo $row_hot_city['name']; 
		?>
      <input type="hidden" value="<?php echo $cities_arr[$ct]; ?>" name="<?php echo $fr.'_cyid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_cyid_'.$categ.'_'.$ct; ?>"/>
        </td>
        <td class="ss"><?php
			$tdate=date("Y-m-d",strtotime($stdate));
			$season=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)");
			$season->execute();
			$row_season =$season->fetch(PDO::FETCH_ASSOC);
			$tot_season= $season->rowCount();
			$season_id=$row_season['season_id'];
		if($tot_season>0)
		{
			if($flag==0)
			{
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='2STAR' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
			//myedit
									if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
									{
									///echo "same";
									$flag=0;
									}else
									{
										$flag=1;
									}
			//$flag=1;
			}else{
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='3STAR' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");	
									//myedit
									if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
									{
									//echo "same";
									$flag=1;
									}else
									{
										$flag=0;
									}
					
			//$flag=0;
			}
			
			$hotel->execute(array($cities_arr[$ct]));
			$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
			$tot_hotel= $hotel->rowCount();
			
			if($tot_hotel>0)
			{
				//echo $row_hotel['hotel_name'];
				$hotel_edit=$conn->prepare("select * from hotel_pro where status='0' and category='HOUSEBOAT' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
				$hotel_edit->execute(array($cities_arr[$ct]));
				//$row_hotel_edit = mysql_fetch_assoc($hotel_edit);
				$row_hotel_edit_main=$hotel_edit->fetchAll();
				$tot_hotel_edit= $hotel_edit->rowCount();
				
				if($tot_hotel_edit>0)
				{
					?>
                    <select class="form-control chosen-select" onchange="houseboat_editable(this.value,'<?php echo $categ; ?>','<?php echo $ct; ?>')">
                    	<option selected="selected" value="<?php echo $row_hotel['hotel_id']; ?>"><?php echo $row_hotel['hotel_name'];?></option>
                        <?php
						foreach($row_hotel_edit_main as $row_hotel_edit)
						{?>
							<option value="<?php echo $row_hotel_edit['hotel_id']; ?>"><?php echo $row_hotel_edit['hotel_name']; ?></option>
						<?php } ?>
                    </select>
                     <?php
				}else{
					echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
				}
				
			//echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
			$hotl_id=$row_hotel['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel1['hotel_id']));
						$row_hfood =$hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=substr($season_id, -6, 1);
									$lunchrate_arr=explode('\\',$row_hfood['lunch_rate']);
									$lunchrate=$lunchrate_arr[$ss-1];
									
									$dinnerrate_arr=explode('\\',$row_hfood['dinner_rate']);
									$dinnerrate=$dinnerrate_arr[$ss-1];
									
									$chwithbed_arr=explode('\\',$row_hfood['child_with_bed']);
									$chwithbedrate=$chwithbed_arr[$ss-1];
									
									$chwithoutbed_arr=explode('\\',$row_hfood['child_without_bed']);
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									
									$flowerbed_arr=explode('\\',$row_hfood['flower_bed']);
									$flowerbedrate=$flowerbed_arr[$ss-1];
									
									$candle_arr=explode('\\',$row_hfood['candle_light']);
									$candlerate=$candle_arr[$ss-1];
									
									$cake_arr=explode('\\',$row_hfood['cake_rate']);
									$cakerate=$cake_arr[$ss-1];
									
									$fruit_arr=explode('\\',$row_hfood['fruit_basket']);
									$fruitrate=$cake_arr[$ss-1];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
				
			}else{ //if the hotels unavailable in 2star and 3star pick any hotel from any category by priority
			$hotel2=$conn->prepare("select * from hotel_pro where status='0' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
			$hotel2->execute(array($cities_arr[$ct]));
			$row_hotel2 = $hotel2->fetch(PDO::FETCH_ASSOC);
			$tot_hotel2= $hotel2->rowCount();
			
			echo $row_hotel2['hotel_name']." ( ".$row_hotel2['category']." )";
			$hotl_id=$row_hotel2['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel2['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=substr($season_id, -6, 1);
									$lunchrate_arr=explode('\\',$row_hfood['lunch_rate']);
									$lunchrate=$lunchrate_arr[$ss-1];
									
									$dinnerrate_arr=explode('\\',$row_hfood['dinner_rate']);
									$dinnerrate=$dinnerrate_arr[$ss-1];
									
									$chwithbed_arr=explode('\\',$row_hfood['child_with_bed']);
									$chwithbedrate=$chwithbed_arr[$ss-1];
									
									$chwithoutbed_arr=explode('\\',$row_hfood['child_without_bed']);
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									
									$flowerbed_arr=explode('\\',$row_hfood['flower_bed']);
									$flowerbedrate=$flowerbed_arr[$ss-1];
									
									$candle_arr=explode('\\',$row_hfood['candle_light']);
									$candlerate=$candle_arr[$ss-1];
									
									$cake_arr=explode('\\',$row_hfood['cake_rate']);
									$cakerate=$cake_arr[$ss-1];
									
									$fruit_arr=explode('\\',$row_hfood['fruit_basket']);
									$fruitrate=$cake_arr[$ss-1];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
			}
			
		}else{
			echo " Locked ";	//season lock
			$hotl_id='-';
		}
		?>
        <input type="hidden" value="<?php echo $hotl_id; ?>" name="<?php echo $fr.'_hid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_hid_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
			if($hotl_id != '-')
			{
			$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? ORDER BY $season_id ASC");
			$hrooom->execute(array($hotl_id));
			$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
			$tot_hrooom= $hrooom->rowCount();
			echo $row_hrooom['room_type'];
			$room_sno=$row_hrooom['sno'];
			$room_rent=$row_hrooom[$season_id];
			$total_amount=$total_amount+($room_rent*$troom);
			}else{
			echo " - ";	
			$room_sno='-';
			$room_rent='-';
			}
		?>
        <input type="hidden" value="<?php echo $room_sno; ?>" name="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>"  />
        <input type="hidden" value="<?php echo $room_rent; ?>" name="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php echo "1"; ?></td></tr>
	<?php
			$date=date_create($stdate);
			date_add($date,date_interval_create_from_date_string("1 days"));
			$stdate= date_format($date,"d-M-Y");
	
	 }//for end
	}//main for loop?>
    </table>
    </center>
    <div class="row" style="margin-top:10px;">
     <div class="col-sm-6" align="center"><?php echo "Number of Rooms - ".$troom." ( Pax : ".$tot_pax." )";
								
								$rrom=$extbed;
	$rrom1=array_unique($rrom);
	$rrom1=array_values($rrom1);
	//print_r($rrom1);
	$rrom2=array_count_values($rrom);
	//print_r($rrom2);
	
	for($tt=0;$tt<count($rrom1);$tt++)
	{
		if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='' && $rrom1[$tt+1] !='-')
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]=='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg.",&nbsp;"; 
			}
		}else
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg; 
			}
		}
	}
								/*	for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											echo "-With Bed-";
										}else if($extbed[$e]=='1'){
											echo "-Without Extra Bed-";
										}
									}*/
	?>
    </div>
    <?php //echo "hotel only ".$total_amount; 
	$itin_amt=($total_amount+$transport_only+$addi_cost_of_itin);
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
    
    <div class="col-sm-6" align="center">Cost: <?php echo round($admin_itin_amt)."/- Only";?> [ including <?php echo $choose_food; ?> ]</div>
    </div>
    <hr style="margin-top:10px; margin-bottom:10px;" />
	</div>
    
    
    </div>
	</div>
<!--- combination of 2 star and 3 star hotels end -->
<!-- combination of 3 star and 4 star hotels start -->
<?php
$stdate=$row_resume['tr_arr_date']; 
 $categ="3star4star"; 
$total_amount=0;
?>
<div class='col-sm-12' style="margin-top:20px;" id="div_catg_<?php echo $categ; ?>" >
<div class="row">
<div class="col-sm-6" style="text-align:right; color:#930; font-weight:700"><?php echo "Option - ".$cg." : "; ?></div>
<div class="col-sm-6"><a class="btn btn-sm  btn-info" id="btn_<?php echo $categ; ?>" onClick="set_cate('<?php echo $categ; ?>')"><?php echo "Combination of 3 star & 4 star Hotels"; ?></a></div>
</div>
    
    <div id="catg_tab_<?php echo $categ; ?>" style="margin-top:5px;">
    <br />
    <center>
    <table class="ss" style="width:95%" >
    <tr class="ss"><th style="width:5%" class="tt"  > &nbsp;S.No</th>
    <th style="width:12%" class="tt"> &nbsp;Date</th>
    <th style="width:20%" class="tt"> &nbsp;Place</th>
    <th style="width:25%" class="tt"> &nbsp;Hotel</th>
    <th style="width:20%" class="tt"> &nbsp;Room Category </th>
    <th style="width:8%" class="tt"> &nbsp;T Nights</th></tr>
    <?php 
$fr='';
$sno=1;
for($itin=0;$itin<count($plan_idss_arr);$itin++)
{
	$fr=$plan_idss_arr[$itin];
	

$resume = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$resume->execute(array($fr));
$row_resume =$resume->fetch(PDO::FETCH_ASSOC);
$totalRows_resume =$resume->rowCount();
	
	//start
	
	$retrav = $conn->prepare("SELECT * FROM travel_sched where travel_id=? ORDER BY sno ASC");
$retrav->execute(array($fr));
//$row_retrav = mysql_fetch_assoc($retrav);
$row_retrav_main=$retrav->fetchAll();
$totalRows_retrav = $retrav->rowCount();

	$t=0;
	$ccid='';
	$ccid_names='';
	foreach($row_retrav_main as $row_retrav)
	{
		if($t!=$totalRows_retrav-1)
		{
			
			$cid = $conn->prepare("SELECT * FROM dvi_cities where name=?");
		$cid->execute(array($row_retrav['tr_to_cityid']));
		$row_cid = $cid->fetch(PDO::FETCH_ASSOC);
		$totalRows_cid = $cid->rowCount();
			
			if($ccid=='')
			{
				$ccid=$row_cid['id'];
				$ccid_names=$row_cid['name'];
			}else
			{
				$ccid=$ccid.','.$row_cid['id'];
				$ccid_names=$ccid_names.','.$row_cid['name'];
			}
		}
		$t++;
	}

		$stdate=$row_resume['tr_arr_date'];  
		//$stay_cnt=$_GET['stay_cntt'];  
		$cities_arr=explode(',',$ccid);
		$troom=trim($row_resume['stay_rooms']);
		$tot_fpax=(int)$row_resume['pax_adults']+(int)$row_resume['pax_512child'];
		$tot_pax=trim($row_resume['pax_cnt']);
		?>
			<!-- <input type="hidden" value="<?php echo $row_resume['room_info']; ?>" id="<?php echo $fr; ?>_room_info_pow" name="<?php echo $fr; ?>_room_info_pow" />
		    <input type="hidden" value="<?php echo $ccid; ?>" id="<?php echo $fr; ?>_city_ids_pow" name="<?php echo $fr; ?>_city_ids_pow" />
		    <input type="hidden" value="<?php echo $ccid_names; ?>" id="<?php echo $fr; ?>_city_idname_pow" name="<?php echo $fr; ?>_city_idname_pow" />
		    <input type="hidden" value="<?php echo $stdate; ?>" id="<?php echo $fr; ?>_stdate_pow" name="<?php echo $fr; ?>_stdate_pow" />
		    <input type="hidden" value="<?php echo $row_resume['stay_rooms']; ?>" id="<?php echo $fr; ?>_stay_rooms_pow" name="<?php echo $fr; ?>_stay_rooms_pow" /> -->
		<?php
		$food_catd="";
	$extbed=array();
	$choose_food='Breakfast';
	if(!empty($row_resume['room_info']))
	{
		
		$room_info_arr=explode('/',$row_resume['room_info']);
		$food_catd=$room_info_arr[4];
		$exbd=$room_info_arr[3];
		$extbed=explode(',',$exbd);
		//print_r($cities_arr);
		//end
	}
	$flag=0;
	for($ct=0;$ct<count($cities_arr);$ct++)
	{?>
		<tr class="ss"><td class="ss"><?php echo $sno++; ?></td>
        <td class="ss"><?php
			$stay_date=date("Y-m-d",strtotime($stdate));
			echo date("d-M-Y",strtotime($stdate)); 
			
		?>
        <input type="hidden" value="<?php echo $stay_date; ?>" name="<?php echo $fr.'_sdate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_sdate_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
			$hot_city=$conn->prepare("select * from dvi_cities where status='0' and id=?");
			$hot_city->execute(array($cities_arr[$ct]));
			$row_hot_city = $hot_city->fetch(PDO::FETCH_ASSOC);
		 	echo $row_hot_city['name']; 
		?>
      <input type="hidden" value="<?php echo $cities_arr[$ct]; ?>" name="<?php echo $fr.'_cyid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_cyid_'.$categ.'_'.$ct; ?>"/>
        </td>
        <td class="ss"><?php
			$tdate=date("Y-m-d",strtotime($stdate));
			$season=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)");
			$season->execute();
			$row_season =$season->fetch(PDO::FETCH_ASSOC);
			$tot_season= $season->rowCount();
		
		if($tot_season>0)
		{
			if($flag==0)
			{
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='3STAR' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
									//myedit
									if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
									{
									///echo "same";
									$flag=0;
									}else
									{
										$flag=1;
									}
			//$flag=1;
			}else{
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='4STAR' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");	
			
									//myedit
									if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
									{
									///echo "same";
									$flag=1;
									}else
									{
										$flag=0;
									}
			//$flag=0;
			}
			
			$hotel->execute(array($cities_arr[$ct]));
			$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
			$tot_hotel= $hotel->rowCount();
			
			if($tot_hotel>0)
			{
				//echo $row_hotel['hotel_name'];
				$hotel_edit=$conn->prepare("select * from hotel_pro where status='0' and category='HOUSEBOAT' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
				$hotel_edit->execute(array($cities_arr[$ct]));
				//$row_hotel_edit = mysql_fetch_assoc($hotel_edit);
				$row_hotel_edit_main=$hotel_edit->fetchAll();
				$tot_hotel_edit= $hotel_edit->rowCount();
				
				if($tot_hotel_edit>0)
				{
					?>
                    <select class="form-control chosen-select" onchange="houseboat_editable(this.value,'<?php echo $categ; ?>','<?php echo $ct; ?>','<?php echo $fr; ?>')">
                    	<option selected="selected" value="<?php echo $row_hotel['hotel_id']; ?>"><?php echo $row_hotel['hotel_name'];?></option>
                        <?php
						foreach($row_hotel_edit_main as $row_hotel_edit)
						{?>
							<option value="<?php echo $row_hotel_edit['hotel_id']; ?>"><?php echo $row_hotel_edit['hotel_name']; ?></option>
						<?php } ?>
                    </select>
                     <?php
				}else{
					echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
				}
				
			//echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
			$hotl_id=$row_hotel['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=substr($season_id, -6, 1);
									$lunchrate_arr=explode('\\',$row_hfood['lunch_rate']);
									$lunchrate=$lunchrate_arr[$ss-1];
									
									$dinnerrate_arr=explode('\\',$row_hfood['dinner_rate']);
									$dinnerrate=$dinnerrate_arr[$ss-1];
									
									$chwithbed_arr=explode('\\',$row_hfood['child_with_bed']);
									$chwithbedrate=$chwithbed_arr[$ss-1];
									
									$chwithoutbed_arr=explode('\\',$row_hfood['child_without_bed']);
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									
									$flowerbed_arr=explode('\\',$row_hfood['flower_bed']);
									$flowerbedrate=$flowerbed_arr[$ss-1];
									
									$candle_arr=explode('\\',$row_hfood['candle_light']);
									$candlerate=$candle_arr[$ss-1];
									
									$cake_arr=explode('\\',$row_hfood['cake_rate']);
									$cakerate=$cake_arr[$ss-1];
									
									$fruit_arr=explode('\\',$row_hfood['fruit_basket']);
									$fruitrate=$cake_arr[$ss-1];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
			}else{
			$hotel3=$conn->prepare("select * from hotel_pro where status='0' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
			$hotel3->execute(array($cities_arr[$ct]));
			$row_hotel3 = $hotel3->fetch(PDO::FETCH_ASSOC);
			$tot_hotel3= $hotel3->rowCount();
			
					echo $row_hotel3['hotel_name']." ( ".$row_hotel3['category']." )";
					$hotl_id=$row_hotel3['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel3['hotel_id']));
						$row_hfood =$hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=substr($season_id, -6, 1);
									$lunchrate_arr=explode('\\',$row_hfood['lunch_rate']);
									$lunchrate=$lunchrate_arr[$ss-1];
									
									$dinnerrate_arr=explode('\\',$row_hfood['dinner_rate']);
									$dinnerrate=$dinnerrate_arr[$ss-1];
									
									$chwithbed_arr=explode('\\',$row_hfood['child_with_bed']);
									$chwithbedrate=$chwithbed_arr[$ss-1];
									
									$chwithoutbed_arr=explode('\\',$row_hfood['child_without_bed']);
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									
									$flowerbed_arr=explode('\\',$row_hfood['flower_bed']);
									$flowerbedrate=$flowerbed_arr[$ss-1];
									
									$candle_arr=explode('\\',$row_hfood['candle_light']);
									$candlerate=$candle_arr[$ss-1];
									
									$cake_arr=explode('\\',$row_hfood['cake_rate']);
									$cakerate=$cake_arr[$ss-1];
									
									$fruit_arr=explode('\\',$row_hfood['fruit_basket']);
									$fruitrate=$cake_arr[$ss-1];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>"/>

<input type="hidden" value="<?php echo $dinnerrate; ?>" name="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_dinnerrate_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $lunchrate; ?>" name="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_lunchrate_'.$categ.'_'.$ct; ?>"/>
                                    <?php
									if($food_catd=='lunch_rate')
									{
										$total_amount=$total_amount+($lunchrate*$tot_fpax);
										$choose_food="Breakfast & Lunch";
									}else if($food_catd=='dinner_rate')
									{
										$total_amount=$total_amount+($dinnerrate*$tot_fpax);
										$choose_food="Breakfast & Dinner";
									}else if($food_catd=='both_food')
									{
										$boths=$dinnerrate+$lunchrate;
										$total_amount=$total_amount+($boths*$tot_fpax);
										$choose_food="Breakfast, Lunch & Dinner";
									}else{
									$choose_food='Breakfast';	
									}
									
									$ext_bed='';
									for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											$total_amount=$total_amount+$chwithbedrate;
										}else if($extbed[$e]=='1'){
											$total_amount=$total_amount+$chwithoutbedrate;
										}
									}
			
			
			}
			$season_id=$row_season['season_id'];
		}else{
			echo " Locked ";	//season lock
			$hotl_id='-';
		}
		?>
        <input type="hidden" value="<?php echo $hotl_id; ?>" name="<?php echo $fr.'_hid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_hid_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
			if($hotl_id != '-')
			{
			$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? ORDER BY $season_id ASC");
			$hrooom->execute(array($hotl_id));
			$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
			$tot_hrooom= $hrooom->rowCount();
			echo $row_hrooom['room_type'];
			$room_sno=$row_hrooom['sno'];
			$room_rent=$row_hrooom[$season_id];
			$total_amount=$total_amount+($room_rent*$troom);
			}else{
			echo " - ";	
			$room_sno='-';
			$room_rent='-';
			}
		?>
        <input type="hidden" value="<?php echo $room_sno; ?>" name="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>"  />
        <input type="hidden" value="<?php echo $room_rent; ?>" name="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php echo "1"; ?></td></tr>
	<?php
			$date=date_create($stdate);
			date_add($date,date_interval_create_from_date_string("1 days"));
			$stdate= date_format($date,"d-M-Y");
	
	 }//for end
	}//main for loop?>
    </table>
    </center>
   <div class="row" style="margin-top:10px;">
     <div class="col-sm-6" align="center">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "Number of Rooms - ".$troom." ( Pax : ".$tot_pax." )";
							
	$rrom=$extbed;
	$rrom1=array_unique($rrom);
	$rrom1=array_values($rrom1);
	//print_r($rrom1);
	$rrom2=array_count_values($rrom);
	//print_r($rrom2);
	
	for($tt=0;$tt<count($rrom1);$tt++)
	{
		if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='' && $rrom1[$tt+1] !='-')
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg.",&nbsp;";
			}
		}else
		{
			if($rrom1[$tt]=='0')
			{
				$rg="With Extra Bed";
			}else if($rrom1[$tt]=='1'){
				$rg="Without Extra Bed";
			}
			if($rrom1[$tt]!='-')
			{
			echo "&nbsp; ".$rrom2[$rrom1[$tt]]."-".$rg; 
			}
		}
	}
								/*	for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											echo "- With Bed -";
										}else if($extbed[$e]=='1'){
											echo "- Without Extra Bed -";
										}
									}*/
	?>
    </div>
     <?php //echo "hotel only ".$total_amount; 
	$itin_amt=($total_amount+$transport_only+$addi_cost_of_itin);
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
    <div class="col-sm-6" align="center">Cost: <?php echo round($admin_itin_amt)."/- Only";?> [ including <?php echo $choose_food; ?> ]</div>
    </div>
    <hr style="margin-top:10px; margin-bottom:10px;" />
     </div>
	</div>
<!-- combination of 3star and 4 star hotels end --->

<input type="hidden" value="" id="prev_catg" name="prev_catg" >
<input type="hidden" value="<?php echo $ccid; ?>" id="kit_cityidd" name="kit_cityidd" />

<?php }else if($_GET['res']=='insert')//to insert hotel information after resume from ordstatus.php - manage_status(sts)
{


$breakstay = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$breakstay->execute(array($plan_id));
$row_breakstay = $breakstay->fetch(PDO::FETCH_ASSOC);
$totalRows_breakstay = $breakstay->rowCount();

$break_arr=explode('-',$row_breakstay['sub_paln_id']);

for($bk=0;$bk<count($break_arr);$bk++)
{
	$plan_id=$break_arr[$bk];
	//hotel insert after resume
	
$resume = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$resume->execute(array($plan_id));
$row_resume = $resume->fetch(PDO::FETCH_ASSOC);
$totalRows_resume = $resume->rowCount();


$transport_only=$row_resume['tr_net_amt'];
$agent_perc=$row_resume['agent_perc'];
$admin_perc=$row_resume['agnt_adm_perc'];

$room_info_arr=explode('/',$row_resume['room_info']);


$retrav = $conn->prepare("SELECT * FROM travel_sched where travel_id=? ORDER BY sno ASC");
$retrav->execute(array($plan_id));
//$row_retrav = mysql_fetch_assoc($retrav);
$row_retrav_main=$retrav->fetchAll();
$totalRows_retrav = $retrav->rowCount();

		 $cityy1=explode(',',$_POST['kit_cityidd']);
		 $par=$row_resume['tr_nights'];
		 $child=$row_resume['stay_rooms'];
		 $_POST['adult_no_cnt']=$row_resume['pax_adults'];
		 $_POST['child512_no_cnt']=$row_resume['pax_512child'];
		 
		 $totalday_amtcal=0;
		 if($_POST['prev_catg'] != '')
		 {
			 $sctg=trim($_POST['prev_catg']);
					for($h1=0; $h1<$par; $h1++)
					{   $perday_amtcal=0;
						
						$shcity=$_POST[$plan_id.'_cyid_'.$sctg.'_'.$h1];
						
						$indu_rent='';
						//$shdate=date("Y-m-d",strtotime($_POST['sdat'.$h1]));
						$shdate=$_POST[$plan_id.'_sdate_'.$sctg.'_'.$h1];
						$shfood='';
						$sh_extra='';
						$shotel=$_POST[$plan_id.'_hid_'.$sctg.'_'.$h1];
				
				
				//my rooms
				 $hrooom=$conn->prepare("select * from hotel_pro where hotel_id=?");
									$hrooom->execute(array($shotel));
									$row_hrooom =$hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									$ch_ctg='-';
									if($row_hrooom['category']=='HOUSEBOAT')
									{
										$ch_ctg="HB";	
									}
				
						$shroom='';
						$indu_room_rent='';
						$shroom_names='';
						if($ch_ctg!="HB")//not house boating
						{
							for($rr=0;$rr<$child;$rr++)	
							{
								if($shroom=='')
								{
									if($_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1]!='-')
									{
									$shroom=$_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1];
									$indu_room_rent=$_POST[$plan_id.'_rent_'.$sctg.'_'.$h1];
									}else{
									$shroom='-';
									$indu_room_rent='0';
									}
								}else{
									if($_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1]!='-')
									{
									$shroom=$shroom.','.$_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1];
									$indu_room_rent=$indu_room_rent.','.$_POST[$plan_id.'_rent_'.$sctg.'_'.$h1];
									}else{
										$shroom=$shroom.',-';
										$indu_room_rent=$indu_room_rent.',0';
									}
								}
								
									//finding room name to add table
													$rm_snumber=$_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1];
													
												echo 	$rnammm = $conn->prepare("SELECT * FROM hotel_season  where sno =?");
													$rnammm->execute(array($rm_snumber));
													$row_rnammm = $rnammm->fetch(PDO::FETCH_ASSOC);
													if($shroom_names=='')
													{
														$shroom_names=$row_rnammm['room_type'];
													}else{
														$shroom_names=$shroom_names.','.$row_rnammm['room_type'];
													}
								
								$perday_amtcal=$perday_amtcal+(int)$_POST[$plan_id.'_rent_'.$sctg.'_'.$h1];
							}
						}else{//for house boating
							    //echo "ff".$_POST['rmid_'.$sctg.'_'.$h1];
								if($shroom=='')
								{
									if($_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1]!='-')
									{
										$shroom=$_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1];
										$indu_room_rent=$_POST[$plan_id.'_rent_'.$sctg.'_'.$h1];
									}else{
										$shroom='-';
										$indu_room_rent='0';
									}
								}else{
									if($_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1]!='-')
									{
										$shroom=$shroom.','.$_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1];
										$indu_room_rent=$indu_room_rent.','.$_POST[$plan_id.'_rent_'.$sctg.'_'.$h1];
									}else{
										$shroom=$shroom.',-';
										$indu_room_rent=$indu_room_rent.',0';
									}
								}
								
								
								$hbrent_arr=explode(',',$_POST[$plan_id.'_rent_'.$sctg.'_'.$h1]);
								$_POST[$plan_id.'_rent_'.$sctg.'_'.$h1]=array_sum($hbrent_arr);
								
								
							$perday_amtcal=$perday_amtcal+(int)$_POST[$plan_id.'_rent_'.$sctg.'_'.$h1];
							
								//finding room name to add table
									$ridd_arr=explode(',',$_POST[$plan_id.'_rmid_'.$sctg.'_'.$h1]);
									//print_r($ridd_arr);
									for($y=0;$y<count($ridd_arr);$y++)
									{
													//$rm_snumber=$_POST['rmid_'.$sctg.'_'.$h1];
													$rm_snumber=$ridd_arr[$y];
													
													$rnammm = $conn->prepare("SELECT * FROM hotel_season  where sno =?");
													$rnammm->execute(array($rm_snumber));
													$row_rnammm = $rnammm->fetch(PDO::FETCH_ASSOC);
													if($shroom_names=='')
													{
														$shroom_names=$row_rnammm['room_type'];
													}else{
														$shroom_names=$shroom_names.','.$row_rnammm['room_type'];
													}
									}
							
						}
						$shadult=$room_info_arr[0];
						
						$shchild512=$room_info_arr[1];
						
					
						$shchild=$room_info_arr[2];
						
						$shextra=$room_info_arr[3];
						
						if(isset($_POST[$plan_id.'_rmextr_'.$sctg.'_'.$h1]))
						{
									$shextra=$_POST[$plan_id.'_rmextr_'.$sctg.'_'.$h1];
						}
						
						$bedd=explode(',',$room_info_arr[3]);
						$rate_for_child_bed=0;
					
						if($ch_ctg!='HB')
						{
							for($h4=0;$h4<count($bedd);$h4++)
							{
								if($bedd[$h4]=='0')
								{
									$rate_for_child_bed=$rate_for_child_bed+$_POST['chwithbed_'.$sctg.'_'.$h1];
								}else if($bedd[$h4]=='1')
								{
									$rate_for_child_bed=$rate_for_child_bed+$_POST['chwithoutbed_'.$sctg.'_'.$h1];
								}else if($bedd[$h4]=='-')
								{
									$rate_for_child_bed=$rate_for_child_bed+0;
								}
							}
						}else if($ch_ctg=='HB')
						{
							$ex_bedd=explode(',',$shextra);
							for($bd=0;$bd<count($ex_bedd);$bd++)
							{
								if($ex_bedd[$bd]=='0')
								{
									$rate_for_child_bed=$rate_for_child_bed+$_POST['chwithbed_'.$sctg.'_'.$h1];
								}else if($ex_bedd[$bd]=='1')
								{
									$rate_for_child_bed=$rate_for_child_bed+$_POST['chwithoutbed_'.$sctg.'_'.$h1];
								}else if($ex_bedd[$bd]=='-')
								{
									$rate_for_child_bed=$rate_for_child_bed+0;
								}
							}
						}
						$perday_amtcal=$perday_amtcal+$rate_for_child_bed;
						
						$food_person=$_POST['adult_no_cnt']+$_POST['child512_no_cnt'];
						$_POST['food_categ_dvi']=$room_info_arr[4];
						if($_POST['food_categ_dvi']=='lunch_rate')
						{
							$perday_amtcal=$perday_amtcal+$food_person*$_POST[$plan_id.'_lunchrate_'.$sctg.'_'.$h1];
							$ffood=$_POST['lunchrate_'.$sctg.'_'.$h1];
							$shfood=$_POST['food_categ_dvi'];
						}else if($_POST['food_categ_dvi']=='dinner_rate')
						{
							$perday_amtcal=$perday_amtcal+$food_person*$_POST[$plan_id.'_dinnerrate_'.$sctg.'_'.$h1];
							$ffood=$_POST['dinnerrate_'.$sctg.'_'.$h1];
							$shfood=$_POST['food_categ_dvi'];
						}else if($_POST['food_categ_dvi']=='both_food')
						{
							$bothfood=$_POST[$plan_id.'_dinnerrate_'.$sctg.'_'.$h1]+$_POST[$plan_id.'_lunchrate_'.$sctg.'_'.$h1];
							$ffood=$bothfood.','.$_POST[$plan_id.'_dinnerrate_'.$sctg.'_'.$h1].','.$_POST[$plan_id.'_lunchrate_'.$sctg.'_'.$h1];
							$perday_amtcal=$perday_amtcal+($bothfood*$food_person);
							$shfood=$_POST['food_categ_dvi'];
						}else if($_POST['food_categ_dvi']=='no'){
							$shfood="";
							$ffood='0';
						}
						
						$_POST['others_rate'.$h1]=0;
						$indu_rent=$indu_room_rent.'-'.$rate_for_child_bed.','.$_POST[$plan_id.'_chwithbed_'.$sctg.'_'.$h1].','.$_POST[$plan_id.'_chwithoutbed_'.$sctg.'_'.$h1].'-'.$ffood.'-'.$_POST['others_rate'.$h1];
						
						//total amount calculation
						$totalday_amtcal=$totalday_amtcal+$perday_amtcal;
						
						//$perday_amount=$_POST['perdayid'.$h1];
						  $HotelSQL = $conn->prepare("INSERT INTO stay_sched (stay_id, hotel_id, sty_date, sty_city, sty_room_type, sty_room_name, sty_adults, sty_512child, sty_child, sty_child_bed, sty_food, sty_extra, sty_indu_rent, sys_amount, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?, '0')");
						  $HotelSQL->execute(array($plan_id,$shotel,$shdate,$shcity,$shroom,$shroom_names,$shadult,$shchild512,$shchild,$shextra,$shfood,$sh_extra,$indu_rent,$perday_amtcal));
						
				}//for end
		 }
		
		$grant_ttttol=$transport_only+$totalday_amtcal+$row_resume['tot_additional_cost'];
		
		$agnt_grnd_adm = $grant_ttttol + ($grant_ttttol * ($agent_perc / 100));
		$whole_grnd_tot = $agnt_grnd_adm + ($agnt_grnd_adm * ($admin_perc / 100));


$htl_amt=$totalday_amtcal;
$trav_name=$_POST['gtitle1'].'. '.$_POST['guestname1'];
$updatemaster=$conn->prepare("update travel_master set tr_name=?, tr_mobile=?, tr_arrdet=?, tr_depdet=?, stay_tot_amt=?, grand_tot=?, agnt_grand_tot=?, status='2' where plan_id=? and  date_of_reg=? and status='5'");
$updatemaster->execute(array($trav_name,$_POST['mobil1'],$_POST['arrdet1'],$_POST['depdet1'],$htl_amt,$grant_ttttol,$whole_grnd_tot,$plan_id,$row_resume['date_of_reg']));
		}//main for loop
}?>