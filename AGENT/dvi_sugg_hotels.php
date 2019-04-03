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
include("../COMMN/smsfunc.php");
require_once('../Connections/divdb.php');
ini_set('session.gc_maxlifetime', 3600); 
session_start();
//print_r($_SESSION);
$com_plan_id= $_SESSION['com_plan_id'];

$tot_itineraries=$_POST['tot_num_of_form'];


$resume = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$resume->execute(array($com_plan_id));
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
}


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
  
/*$stdate=$_GET['stdate'];  
$stay_cnt=$_GET['stay_cntt'];  
$cities_arr=explode(',',$_GET['ccids']);
//print_r($cities_arr);
$troom=$_GET['troom'];
$tot_fpax=$_GET['tot_fpax'];
$tot_pax=$_GET['tot_pax'];
$food_catd=$_GET['food_catd'];
$extbed=explode(',',$_GET['extbed']);
$fr=$_GET['fr'];*/
//print_r($extbed);

	$hot_cag=$conn->prepare("select category from hotel_pro where status='0' GROUP BY category");
	$hot_cag->execute();
	//$row_hot_cag = mysql_fetch_assoc($hot_cag);
	$row_hot_cag_main=$hot_cag->fetchAll();
	$tot_hot_cag= $hot_cag->rowCount();

$cg=1;$hide5star=0;
foreach($row_hot_cag_main as $row_hot_cag)
{
	//echo "ALL =".$row_hot_cag['category'];
	if($row_hot_cag['category']!='House Boat' && $row_hot_cag['category']!='')
	{
		$categ=str_replace(' ', '', $row_hot_cag['category']);
		//echo "TA : ".$total_amount;
		$total_amount=0;
	?>
	<div class='col-sm-12' style="margin-top:5px;" id="div_catg_<?php echo $categ; ?>">
    <div class="row">
    <div class="col-sm-6" style="text-align:right; color:#930; font-weight:700"><?php echo "Option - ".$cg." : "; ?></div>
    <div class="col-sm-4"><a class="btn btn-sm  btn-info" id="btn_<?php echo $categ; ?>" onClick="set_cate('<?php echo $categ; ?>')"><?php echo $row_hot_cag['category']." Hotels"; ?></a>
    </div>
    <div class="col-sm-2">
     <a class="btn btn-info btn-sm" id="plan_hotel_sub_<?php echo $categ; ?>" name="plan_hotel_sub_<?php echo $categ; ?>" onclick="show_hotel_list('dvi_sugg')" style="display:none;"><i class="fa fa-hand-o-right"></i>&nbsp; Proceed</a></div>
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
for($itin=0;$itin<=$tot_itineraries;$itin++)
{
	$fr='br'.$itin;
	if(isset($_POST['arrdate_'.$fr]))
	{
	$stdate=$_POST['arrdate_'.$fr];  
$stay_cnt=$_POST['num_tranight_'.$fr];  
$cities_arr=explode(',',$_POST[$fr.'_kit_cityidd']);
//print_r($cities_arr);
$troom=$_POST['num_room_htls_'.$fr];
$tot_fpax=$_POST['num_traveller_'.$fr]+$_POST['num_chd512_'.$fr];
$tot_pax=$_POST['num_traveller_'.$fr]+$_POST['num_chd512_'.$fr]+$_POST['num_chd_b5_'.$fr];
$food_catd=$_POST['foodd_id'];
$ch_extr_bed='';

	//finding extrabed start
		for($rm=1;$rm<=$troom;$rm++)
		{
			if($ch_extr_bed=='')
			{
				$ch_extr_bed=$_POST[$fr.'_sel_nw_extr'.$rm];
			}else{
				$ch_extr_bed=$ch_extr_bed.','.$_POST[$fr.'_sel_nw_extr'.$rm];
			}
		}
		$extbed=explode(',',$ch_extr_bed);
	//finding extrabed end
	
	for($ct=0;$ct<count($cities_arr);$ct++)
	{?>
		<tr class="ss"><td class="ss"><?php echo $sno++; ?></td>
        <td class="ss"><?php
			echo date("d-M-Y",strtotime($stdate));
			$stay_date=date("Y-m-d",strtotime($stdate));
		?>
        <input type="hidden" value="<?php echo $stay_date; ?>" name="<?php echo $fr; ?>_<?php echo 'sdate_'.$categ.'_'.$ct; ?>" id="<?php echo $fr; ?>_<?php echo 'sdate_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
			$hot_city=$conn->prepare("select * from dvi_cities where status='0' and id=?");
			$hot_city->execute(array($cities_arr[$ct]));
			$row_hot_city = $hot_city->fetch(PDO::FETCH_ASSOC);
		 	echo $row_hot_city['name']; 
		?>
    <input type="hidden" value="<?php echo $cities_arr[$ct]; ?>" name="<?php echo $fr; ?>_<?php echo 'cyid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr; ?>_<?php echo 'cyid_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php
		$check='-';
			$tdate=date("Y-m-d",strtotime($stdate));
			$season=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)");
			//print "SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date)";
			$season->execute();
			$row_season =$season->fetch(PDO::FETCH_ASSOC);
			$tot_season= $season->rowCount();
		
		if($tot_season>0)
		{
			// $sel_hotel="select * from hotel_pro where status='0' and (category='House Boat' or category='".$row_hot_cag['category']."') and city='".$cities_arr[$ct]."' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ";
			$hotel=$conn->prepare("select * from hotel_pro where status='0' and category=? and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC");
			$hotel->execute(array($row_hot_cag['category'],$cities_arr[$ct]));
			$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
			$tot_hotel= $hotel->rowCount();
			
			$ses_id=$row_season['sno'];
			if($tot_hotel>0)
			{
				//echo $row_hotel['hotel_name'];
				$hotel_edit=$conn->prepare("select * from hotel_pro where status='0' and category='House Boat' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
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
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
																	
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
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
			$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=$ses_id+1;
									//print $row_hfood['lunch_rate'];
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];	
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];	
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];	
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];	
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];	
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];	
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];	
									
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
					<input type="text" value="<?php echo $categ; ?>" id="<?php echo $fr; ?>_hide_5star" name="<?php echo $fr; ?>_hide_5star" />
					<script>
					hidden_divs('<?php echo $categ; ?>');
					</script>
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
							
							$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='01 Bed Room - Premium' and season_sno = ?  ORDER by season_rate ASC");
									$hrooom->execute(array($hotl_id,$ses_id));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									//echo $row_hrooom['room_type'].'- With extra bed';
									echo $row_hrooom['room_type'];
									$room_sno=$row_hrooom['sno'];
									$room_rent=$row_hrooom['season_rate'];
									$total_amount=$total_amount+($room_rent);
									//echo "01 Bed Room - Premium";
							
						}else if($num_fpaxs==3)
						{
									$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='01 Bed Room - Premium' and season_sno = ?  ORDER by season_rate ASC");
									$hrooom->execute(array($hotl_id,$ses_id));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									echo $row_hrooom['room_type'].'- With extra bed';
									$room_sno=$row_hrooom['sno'];
									$room_rent=$row_hrooom['season_rate'];
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
							
									$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type='02 Bed Room -  Premium'  and season_sno = ?  ORDER by season_rate ASC");
									$hrooom->execute(array($hotl_id,$ses_id));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									//echo $row_hrooom['room_type'].'- With extra bed';
									$room_sno=$row_hrooom['sno'];
									$room_rent=$row_hrooom['season_rate'];
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
					$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and season_sno = ? ORDER by season_rate ASC");
					//print "select * from hotel_season where status='0' and hotel_id=? and season_sno = ? ORDER by season_rate ASC";
					//print_r(array($hotl_id,$ses_id));
					$hrooom->execute(array($hotl_id,$ses_id));
					$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
					$tot_hrooom= $hrooom->rowCount();
					echo  $row_hrooom['room_type'];
					$room_sno=$row_hrooom['sno'];
					$room_rent=$row_hrooom['season_rate'];
					$total_amount=$total_amount+($room_rent*$troom);
				}
			}else{
				echo " - ";	
				$room_sno='-';
				$room_rent='-';
			}
			//print $room_rent."KKKK";
		?>
       <input type="hidden" value="<?php echo $room_sno; ?>" name="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rmid_'.$categ.'_'.$ct; ?>"  />
       <input type="hidden" value="<?php echo $room_rent; ?>" name="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_rent_'.$categ.'_'.$ct; ?>"  />
        </td>
        <td class="ss"><?php echo "1"; ?></td></tr>
	<?php
			$date=date_create($stdate);
			date_add($date,date_interval_create_from_date_string("1 days"));
			$stdate= date_format($date,"d-M-Y");;
	//echo $hotl_id."-".$total_amount;
	 }//for end
	 
	}//live if end
	/*$ch_fr='br'.($itin+1);
	if(isset($_POST['arrdate_'.$ch_fr]) && $_POST['arrdate_'.$ch_fr]!='')
	 {?>
		 <tr><td colspan="6"><center><strong style="color:#AF9977">Your itinerary will bypassing to following places</strong></center></td></tr>
	 <?php }*/
}//main for loop ?>
    </table>
    </center>
    <div class="row" style="margin-top:10px;">
    <div class="col-sm-6" align="center"><?php echo "Number of Rooms - ".$troom." ( Pax : ".$tot_pax." )";
	//print_r($extbed);
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
    <?php 
	//echo "hotel only ".$total_amount;
	//echo "<br>trans".$transport_only; 
	$itin_amt=($total_amount+$transport_only+$addi_cost_of_itin);
	//echo "AGENT =".$agent_perc;
	//echo "ADMIN =".$admin_perc;
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
    <div class="col-sm-6" align="center"><a href="javascript:void(0)" style="text-decoration:blink" class="flashit">Cost: <?php echo convert_currency_text("Rs")." ".convert_currency(round($admin_itin_amt))."/- Only";?></a> [ including <?php echo $choose_food; ?> ]</div>
    </div>
    <hr style="margin-top:10px; margin-bottom:10px;" />
    </div>
   
	</div>
<?php 
$cg++;
$stdate=$stdate;
	}//if for house boat
}//while end

//combination of HOUSEBOAT hotels
$house_avail='no';
for($itin=0;$itin<=$tot_itineraries;$itin++)
{
	$fr='br'.$itin;
	if(isset($_POST[$fr.'_kit_cityidd']))
	{

	$check_city=explode(',',$_POST[$fr.'_kit_cityidd']);//to find houseboating is available in any cities
	//print_r($check_city);
		for($hh=0;$hh<count($check_city);$hh++)
		{
		        $hotel_avail=$conn->prepare("select * from hotel_pro where status='0' and category='House Boat' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
				$hotel_avail->execute(array($check_city[$hh]));
				$row_hotel_avail = $hotel_avail->fetch(PDO::FETCH_ASSOC);
				$tot_hotel_avail= $hotel_avail->rowCount();
				if($tot_hotel_avail>0)
				{
					$house_avail='yes';
				}
		}
	}
}
//echo "IS HOUSE =".$house_avail;
//$house_avail='yes';
if($house_avail=='yes')
{
$check='-';
$categ="House Boat"; 
$total_amount=0;
$same_city=0;
?>
<div class='col-sm-12' style="margin-top:5px;" id="div_catg_<?php echo $categ; ?>">
<div class="row">
<div class="col-sm-6" style="text-align:right; color:#930; font-weight:700"><?php echo "Option - ".$cg." : "; $cg++;?>
</div>
<div class="col-sm-4"><a class="btn btn-sm  btn-info" id="btn_<?php echo $categ; ?>" onClick="set_cate('<?php echo $categ; ?>')"><?php echo "House Boat"; ?></a></div>
<div class="col-sm-2">
     <a class="btn btn-info btn-sm" id="plan_hotel_sub_<?php echo $categ; ?>" name="plan_hotel_sub_<?php echo $categ; ?>" onclick="show_hotel_list('dvi_sugg')" style="display:none;"><i class="fa fa-hand-o-right"></i>&nbsp; Proceed</a></div>
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
for($itin=0;$itin<=$tot_itineraries;$itin++)
{
	$fr='br'.$itin;
	if(isset($_POST['arrdate_'.$fr]))
	{
	$stdate=$_POST['arrdate_'.$fr];  
$stay_cnt=$_POST['num_tranight_'.$fr];  
$cities_arr=explode(',',$_POST[$fr.'_kit_cityidd']);
//print_r($cities_arr);
$troom=$_POST['num_room_htls_'.$fr];
$tot_fpax=$_POST['num_traveller_'.$fr]+$_POST['num_chd512_'.$fr];
$tot_pax=$_POST['num_traveller_'.$fr]+$_POST['num_chd512_'.$fr]+$_POST['num_chd_b5_'.$fr];
$food_catd=$_POST['foodd_id'];
$ch_extr_bed='';

	//finding extrabed start
		for($rm=1;$rm<=$troom;$rm++)
		{
			if($ch_extr_bed=='')
			{
				$ch_extr_bed=$_POST[$fr.'_sel_nw_extr'.$rm];
			}else{
				$ch_extr_bed=$ch_extr_bed.','.$_POST[$fr.'_sel_nw_extr'.$rm];
			}
		}
		$extbed=explode(',',$ch_extr_bed);
	//finding extrabed end


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
			$ses_id=$row_season['sno'];
		if($tot_season>0)
		{
			if($flag==0)
			{
				 $hotel=$conn->prepare("select * from hotel_pro where status='0' and category!='House Boat' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
				 $hotel->execute(array($cities_arr[$ct]));
				 $row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);
				 $tot_hotel= $hotel->rowCount();
			
			}else{//this is for next day having same city - choose hotel - not houseboat
				
				 $hotel=$conn->prepare("select * from hotel_pro where status='0' and category!='House Boat' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)  ORDER BY hotel_prior ASC ");
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
				
				if($row_hotel['category']=='House Boat')
				{
					//echo "HOUSE";
					$check='HB';
				}
			echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
			$hotl_id=$row_hotel['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
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
			$hotel2=$conn->prepare("select * from hotel_pro where status='0' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
			$hotel2->execute(array($cities_arr[$ct]));
			$row_hotel2 = $hotel2->fetch(PDO::FETCH_ASSOC);
			$tot_hotel2= $hotel2->rowCount();
			
			echo $row_hotel2['hotel_name']." ( ".$row_hotel2['category']." )";
			$hotl_id=$row_hotel2['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel2['hotel_id']));
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
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
					$bet="";
				
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
									$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=? and season_sno = ? ORDER by season_rate ASC");
									$hrooom->execute(array($hotl_id,$rm_sel_name1,$ses_id));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									
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
									 $hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=?  and season_sno = ?  ORDER by season_rate ASC");
									$hrooom->execute(array($hotl_id,$rm_sel_name1,$ses_id));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									
									}//if trible bedroom is unavailable
									
									$room_sno=$row_hrooom['sno'];
									$room_rent=$row_hrooom['season_rate'];
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
									$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=?  and season_sno = ?  ORDER by season_rate ASC");
									$hrooom->execute(array($hotl_id,$rm_sel_name2,$ses_id));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
									$tot_hrooom= $hrooom->rowCount();
									echo ", ".$row_hrooom['room_type'];
									$room_snoo=$row_hrooom['sno'];
									$room_sno=$room_sno.','.$room_snoo;
									
									
									$room_rento=$row_hrooom['season_rate'];
									$room_rent=$room_rent.','.$room_rento;
									$total_amount=$total_amount+$room_rento;
						}
						
						if($with_extra=='yes')
						{
							$bet='';
							//echo "vvvv".$dvn;
							if($dvn==1 && $bed_cn==1 && $rm_sel_name2=='-')
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
										}else{
											$bet=$bet.",-";
										}
									}
								}
							}
							else{
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
					$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=?   and season_sno = ?  ORDER by season_rate ASC");
					$hrooom->execute(array($hotl_id,$ses_id));
					$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
					$tot_hrooom=$hrooom->rowCount();
					echo $row_hrooom['room_type'];
					$room_sno=$row_hrooom['sno'];
					$room_rent=$row_hrooom['season_rate'];
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

	}//live if end

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
    <?php  
	//echo "hotel only ".$total_amount;
	//echo "<br>trans".$transport_only; 
	//$itin_amt=($total_amount+$transport_only);
	//echo "AGENT =".$agent_perc;
	//echo "ADMIN =".$admin_perc;
	$itin_amt=($total_amount+$transport_only+$addi_cost_of_itin);
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
    
    <div class="col-sm-6" align="center"><a href="javascript:void(0)" style="text-decoration:blink" class="flashit">Cost:  <?php echo convert_currency_text("Rs")." ".convert_currency(round($admin_itin_amt))."/- Only";?> </a>[ including <?php echo $choose_food; ?> ]</div>
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
?>
<div class='col-sm-12' style="margin-top:5px;" id="div_catg_<?php echo $categ; ?>">
<div class="row">
<div class="col-sm-6" style="text-align:right; color:#930; font-weight:700"><?php echo "Option - ".$cg." : "; $cg++;?>
</div>
<div class="col-sm-4"><a class="btn btn-sm  btn-info" id="btn_<?php echo $categ; ?>" onClick="set_cate('<?php echo $categ; ?>')"><?php echo "Combination of 2 star & 3 star Hotels"; ?></a></div>
<div class="col-sm-2">
     <a class="btn btn-info btn-sm" id="plan_hotel_sub_<?php echo $categ; ?>" name="plan_hotel_sub_<?php echo $categ; ?>" onclick="show_hotel_list('dvi_sugg')" style="display:none;"><i class="fa fa-hand-o-right"></i>&nbsp; Proceed</a></div>
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
for($itin=0;$itin<=$tot_itineraries;$itin++)
{
	$fr='br'.$itin;
	if(isset($_POST['arrdate_'.$fr]))
	{
	$stdate=$_POST['arrdate_'.$fr];  
$stay_cnt=$_POST['num_tranight_'.$fr];  
$cities_arr=explode(',',$_POST[$fr.'_kit_cityidd']);
//print_r($cities_arr);
$troom=$_POST['num_room_htls_'.$fr];
$tot_fpax=$_POST['num_traveller_'.$fr]+$_POST['num_chd512_'.$fr];
$tot_pax=$_POST['num_traveller_'.$fr]+$_POST['num_chd512_'.$fr]+$_POST['num_chd_b5_'.$fr];
$food_catd=$_POST['foodd_id'];
$ch_extr_bed='';

	//finding extrabed start
		for($rm=1;$rm<=$troom;$rm++)
		{
			if($ch_extr_bed=='')
			{
				$ch_extr_bed=$_POST[$fr.'_sel_nw_extr'.$rm];
			}else{
				$ch_extr_bed=$ch_extr_bed.','.$_POST[$fr.'_sel_nw_extr'.$rm];
			}
		}
		$extbed=explode(',',$ch_extr_bed);
	//finding extrabed end
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
			$ses_id=$row_season['sno'];
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
				$hotel_edit=$conn->prepare("select * from hotel_pro where status='0' and category='House Boat' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
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
			
			$hotl_id=$row_hotel['hotel_id'];
			
						$hfood=$conn->prepare("select * from hotel_food where status='0' and hotel_id=?");
						$hfood->execute(array($row_hotel['hotel_id']));
						$row_hfood =$hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
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
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
									?>
<input type="hidden" value="<?php echo $chwithbedrate; ?>" name="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithbed_'.$categ.'_'.$ct; ?>"/>
<input type="hidden" value="<?php echo $chwithoutbedrate; ?>" name="<?php echo 'chwithoutbed_'.$categ.'_'.$ct; ?>" id="<?php echo $fr.'_chwithoutbed_'.$categ.'_'.$ct; ?>"/>

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
			$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and season_sno = ? ORDER by season_rate ASC");
			$hrooom->execute(array($hotl_id,$ses_id));
			$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
			$tot_hrooom= $hrooom->rowCount();
			echo $row_hrooom['room_type'];
			$room_sno=$row_hrooom['sno'];
			$room_rent=$row_hrooom['season_rate'];
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
			$stdate= date_format($date,"d-M-Y");;
	
	 }//for end

	}//live if end
}//main for loop ?>
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
    
    <div class="col-sm-6" align="center"><a href="javascript:void(0)" style="text-decoration:blink" class="flashit">Cost: <?php echo convert_currency_text("Rs")." ".convert_currency(round($admin_itin_amt))."/- Only";?> </a>[ including <?php echo $choose_food; ?> ]</div>
    </div>
    <hr style="margin-top:10px; margin-bottom:10px;" />
	</div>
    </div>
	</div>
<!--- combination of 2 star and 3 star hotels end -->
<!-- combination of 3 star and 4 star hotels start -->
<?php

 $categ="3star4star"; 
$total_amount=0;
?>
<div class='col-sm-12' style="margin-top:20px;" id="div_catg_<?php echo $categ; ?>" >
<div class="row">
<div class="col-sm-6" style="text-align:right; color:#930; font-weight:700"><?php echo "Option - ".$cg." : "; ?></div>
<div class="col-sm-4"><a class="btn btn-sm  btn-info" id="btn_<?php echo $categ; ?>" onClick="set_cate('<?php echo $categ; ?>')"><?php echo "Combination of 3 star & 4 star Hotels"; ?></a></div>
<div class="col-sm-2">
     <a class="btn btn-info btn-sm" id="plan_hotel_sub_<?php echo $categ; ?>" name="plan_hotel_sub_<?php echo $categ; ?>" onclick="show_hotel_list('dvi_sugg')" style="display:none;"><i class="fa fa-hand-o-right"></i>&nbsp; Proceed</a></div>
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
for($itin=0;$itin<=$tot_itineraries;$itin++)
{
	$fr='br'.$itin;
	if(isset($_POST['arrdate_'.$fr]))
	{
	$stdate=$_POST['arrdate_'.$fr];  
$stay_cnt=$_POST['num_tranight_'.$fr];  
$cities_arr=explode(',',$_POST[$fr.'_kit_cityidd']);
//print_r($cities_arr);
$troom=$_POST['num_room_htls_'.$fr];
$tot_fpax=$_POST['num_traveller_'.$fr]+$_POST['num_chd512_'.$fr];
$tot_pax=$_POST['num_traveller_'.$fr]+$_POST['num_chd512_'.$fr]+$_POST['num_chd_b5_'.$fr];
$food_catd=$_POST['foodd_id'];
$ch_extr_bed='';

	//finding extrabed start
		for($rm=1;$rm<=$troom;$rm++)
		{
			if($ch_extr_bed=='')
			{
				$ch_extr_bed=$_POST[$fr.'_sel_nw_extr'.$rm];
			}else{
				$ch_extr_bed=$ch_extr_bed.','.$_POST[$fr.'_sel_nw_extr'.$rm];
			}
		}
		$extbed=explode(',',$ch_extr_bed);
	//finding extrabed end

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
				$hotel_edit=$conn->prepare("select * from hotel_pro where status='0' and category='House Boat' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
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
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
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
						$row_hfood = $hfood->fetch(PDO::FETCH_ASSOC);
			
									$ss=$ses_id+1;
									$lunchrate_arr=decode_unserialize($row_hfood['lunch_rate']);
									//print_r($lunchrate_arr);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_hfood['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$chwithbed_arr=decode_unserialize($row_hfood['child_with_bed']);
										if(isset($chwithbed_arr[$ss-1]))
									$chwithbedrate=$chwithbed_arr[$ss-1];
									else
									$chwithbedrate=$chwithbed_arr[0];
									
									$chwithoutbed_arr=decode_unserialize($row_hfood['child_without_bed']);
										if(isset($chwithoutbed_arr[$ss-1]))
									$chwithoutbedrate=$chwithoutbed_arr[$ss-1];
									else
									$chwithoutbedrate=$chwithoutbed_arr[0];
									
									$flowerbed_arr=decode_unserialize($row_hfood['flower_bed']);
										if(isset($flowerbed_arr[$ss-1]))
									$flowerbedrate=$flowerbed_arr[$ss-1];
									else
									$flowerbedrate=$flowerbed_arr[0];
									
									$candle_arr=decode_unserialize($row_hfood['candle_light']);
										if(isset($candle_arr[$ss-1]))
									$candlerate=$candle_arr[$ss-1];
									else
									$candlerate=$candle_arr[0];
									
									$cake_arr=decode_unserialize($row_hfood['cake_rate']);
										if(isset($cake_arr[$ss-1]))
									$cakerate=$cake_arr[$ss-1];
									else
									$cakerate=$cake_arr[0];
									
									$fruit_arr=decode_unserialize($row_hfood['fruit_basket']);
										if(isset($fruit_arr[$ss-1]))
									$fruitrate=$fruit_arr[$ss-1];
									else
									$fruitrate=$fruit_arr[0];
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
			$ses_id=$row_season['sno'];
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
			$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=?  and season_sno = ? ORDER by season_rate ASC");
			$hrooom->execute(array($hotl_id,$ses_id));
			$row_hrooom =$hrooom->fetch(PDO::FETCH_ASSOC);
			$tot_hrooom= $hrooom->rowCount();
			echo $row_hrooom['room_type'];
			$room_sno=$row_hrooom['sno'];
			$room_rent=$row_hrooom['season_rate'];
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
			$stdate= date_format($date,"d-M-Y");;
	
	 }//for end
	}//live if end
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
	?>
    </div>
     <?php //echo "hotel only ".$total_amount; 
	$itin_amt=($total_amount+$transport_only+$addi_cost_of_itin);
	$agnt_itin_amt=$itin_amt+($itin_amt*($agent_perc/100));
	$admin_itin_amt=$agnt_itin_amt+($agnt_itin_amt*($admin_perc/100));
	?>
    <div class="col-sm-6" align="center"><a href="javascript:void(0)" style="text-decoration:blink" class="flashit">Cost: <?php echo convert_currency_text("Rs")." ".convert_currency(round($admin_itin_amt))."/- Only";?> </a>[ including <?php echo $choose_food; ?> ]</div>
    </div>
    <hr style="margin-top:10px; margin-bottom:10px;" />
     </div>
	</div>
<!-- combination of 3star and 4 star hotels end --->



<input type="hidden" value="" id="prev_catg" name="prev_catg" >
