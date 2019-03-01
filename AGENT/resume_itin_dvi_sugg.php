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

$plan_id = $_GET['plan_id1'].'#'.$_GET['plan_id2'];


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

	$hot_cag=$conn->prepare("select category from hotel_pro where status='0' GROUP BY category");
	$hot_cag->execute();
	//$row_hot_cag = mysql_fetch_assoc($hot_cag);
	$row_hot_cag=$hot_cag->fetch(PDO::FETCH_ASSOC);
	$tot_hot_cag= $hot_cag->rowCount();

$cg=1;$hide5star=0;

$selected_ctg=trim($_GET['edit_ctg']);
$selected_htl_id=trim($_GET['edit_hid']);
$edit_number=trim($_GET['edit_no']);

$row_hot_cag['category']=$selected_ctg;

	//echo "ALL =".$row_hot_cag['category'];
	if($row_hot_cag['category']!='HOUSEBOAT')
	{
		$categ=str_replace(' ', '', $row_hot_cag['category']);
		//echo "TA : ".$total_amount;
		$total_amount=0;
	?>
	<!--<div class='col-sm-12' style="margin-top:5px;" id="div_catg_<?php echo $categ; ?>">-->
    <!--<div id="catg_tab_<?php echo $categ; ?>" style="margin-top:5px;">-->
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
$csno=0;
for($itin=0;$itin<count($plan_idss_arr);$itin++)
{
	$fr=$plan_idss_arr[$itin];


$resume = $conn->prepare("SELECT * FROM travel_master where plan_id=? and status='5'");
$resume->execute(array($fr));
$row_resume =$resume->fetch(PDO::FETCH_ASSOC);
$totalRows_resume =$resume->rowCount();


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
$flag=0;

$room_info_arr=explode('/',$row_resume['room_info']);
$food_catd=$room_info_arr[4];
$exbd=$room_info_arr[3];
$extbed=explode(',',$exbd);
//print_r($cities_arr);

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
			//$sel_hotel="select * from hotel_pro where status='0' and category='".$row_hot_cag['category']."' and city='".$cities_arr[$ct]."' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC";
			if($edit_number!=$csno)
			{
				//echo "fff".$row_hot_cag['category'];
				if($row_hot_cag['category']=='3star4star')//for 3star+4star hotels
				{
								if($flag==0)
								{
										$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='3STAR' and city='".$cities_arr[$ct]."' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
										//myedit
										if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
										{
										///echo "same";
										$flag=0;
										}else
										{
											$flag=1;
										}
										$next_Catg="3STAR";
								}else{
										 $hotel=$conn->prepare("select * from hotel_pro where status='0' and category='4STAR' and city='".$cities_arr[$ct]."' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");	
				
										//myedit
										if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
										{
										///echo "same";
										$flag=1;
										}else
										{
											$flag=0;
										}
										$next_Catg="4STAR";
								}
				}else if($row_hot_cag['category']=='2star3star')//for 2star+3star hotels
				{
								if($flag==0)
								{
									$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='2STAR' and city='".$cities_arr[$ct]."' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");
						//myedit
												if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
												{
												///echo "same";
												$flag=0;
												}else
												{
													$flag=1;
												}
												$next_Catg="2STAR";
								}else{
									$hotel=$conn->prepare("select * from hotel_pro where status='0' and category='3STAR' and city='".$cities_arr[$ct]."' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC ");	
												//myedit
												if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
												{
												//echo "same";
												$flag=1;
												}else
												{
													$flag=0;
												}
												$next_Catg="3STAR";
								}
				}else{//normal star hotel
					$hotel=$conn->prepare("select * from hotel_pro where status='0' and category=? and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC");
					$next_Catg=$row_hot_cag['category'];
				}
			}else{
			$hotel=$conn->prepare("select * from hotel_pro where hotel_id=?");
							if($row_hot_cag['category']=='3star4star')
							{
								if($flag==0)
								{
										if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
										{
										///echo "same";
										$flag=0;
										}else
										{
											$flag=1;
										}
										$next_Catg="3STAR";
								}else{
										if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
										{
										///echo "same";
										$flag=1;
										}else
										{
											$flag=0;
										}
										$next_Catg="4STAR";
								}
						
							}
							else if($row_hot_cag['category']=='2star3star')//for 2star+3star hotels
							{
									if($flag==0)
									{
												if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
												{
												///echo "same";
												$flag=0;
												}else
												{
													$flag=1;
												}
												$next_Catg="2STAR";
									}else{
												if(isset($cities_arr[$ct+1]) && $cities_arr[$ct+1]==$cities_arr[$ct])//for next day having same city
												{
												//echo "same";
												$flag=1;
												}else
												{
													$flag=0;
												}
												$next_Catg="3STAR";
									}
								}else{
												$next_Catg=$row_hot_cag['category'];
								}
			}
			
			$hotel->execute(array($row_hot_cag['category'],$cities_arr[$ct],$selected_htl_id));
			$row_hotel =$hotel->fetch(PDO::FETCH_ASSOC);
			$tot_hotel= $hotel->rowCount();
			
			$season_id=$row_season['season_id'];
			if($tot_hotel>0)
			{
				
				$hotel_bef=$conn->prepare("select * from hotel_pro where status='0' and category=? and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ORDER BY hotel_prior ASC");
				$hotel_bef->execute(array($next_Catg,$cities_arr[$ct]));
				$row_hotel_bef = $hotel_bef->fetch(PDO::FETCH_ASSOC);
				$tot_hotel_bef= $hotel_bef->rowCount();
				
				//echo $row_hotel['hotel_name'];
				$hotel_edit=$conn->prepare("select * from hotel_pro where status='0' and hotel_id!=? and category='HOUSEBOAT' and city=? and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
				$hotel_edit->execute(array($selected_htl_id,$cities_arr[$ct]));
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
                        <option value="<?php echo $row_hotel_bef['hotel_id']; ?>"><?php echo $row_hotel_bef['hotel_name']; ?></option>
                    </select>
                     <?php
				}else{
					echo $row_hotel['hotel_name']." ( ".$row_hotel['category']." )";
				}
				
				if($row_hotel['category']=='HOUSEBOAT')
				{
					//echo "HOUSE";
					//echo $tot_fpax;
					$check='HB';
				}
			
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
												//echo "f".$check;
											}else if($extbed[$e]=='1'){
												$total_amount=$total_amount+$chwithoutbedrate;
											}
										}
									}
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
									$hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=? ORDER BY $season_id ASC");
									$hrooom->execute(array($hotl_id,$rm_sel_name1));
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
									 $hrooom=$conn->prepare("select * from hotel_season where status='0' and hotel_id=? and room_type=? ORDER BY $season_id ASC";
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
			$csno++;
	 }//for end
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
	
									/*for($e=0;$e<count($extbed);$e++)
									{
										if($extbed[$e]=='0'){
											//echo "- With Bed -";
										}else if($extbed[$e]=='1'){
											//echo "- Without Extra Bed -";
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
   <!-- </div>-->
   
	<!--</div>-->
<?php 
$cg++;
$stdate=$row_resume['tr_arr_date'];
}//if for house boat