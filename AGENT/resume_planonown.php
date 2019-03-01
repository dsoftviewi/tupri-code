<?php
include("../COMMN/smsfunc.php");
require_once('../Connections/divdb.php');
session_start();

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $ttoday=$date->format('Y-m-d');
  $booking_date=$date->format('Y-m-d H:i:s');

$pid=$_GET['plan_id1'].'#'.$_GET['plan_id2'];
$master_multi=$conn->prepare("select * from travel_master where plan_id=?");
$master_multi->execute(array($pid));
$row_master_multi=$master_multi->fetch(PDO::FETCH_ASSOC);

$plan_idss_arr=explode('-',$row_master_multi['sub_paln_id']);
print_r($plan_idss_arr);

for($fb=0;$fb<count($plan_idss_arr);$fb++)
{
	$fr="fr".$fb;
$pid=$plan_idss_arr[$fb];
$master=$conn->prepare("select * from travel_master where plan_id=?");
$master->execute(array($pid));
$row_master= $master->fetch(PDO::FETCH_ASSOC);

		//for hotel+traval 
		$par=$row_master['tr_nights'];
		$child=$_POST[$pid.'_stay_rooms_pow'];
		echo "CITY ID = ".$_POST[$pid.'_city_ids_pow'];
		$cityy1=explode(',',$_POST[$pid.'_city_ids_pow']);
		print_r($cityy1);
		$totalday_amtcal=0;
		
		$room_info_pow_arr=explode('/',$_POST[$pid.'_room_info_pow']);//adultperroom/child512 perroom/childb5 perroom/extra bed/food
		//print_r($room_info_pow_arr);
		
	    //	echo "day of stay par : ".$par;
		for($h1=1; $h1<=$par; $h1++)
		{   $perday_amtcal=0;
			
			$ch1=$h1-1;
			$shcity=trim($cityy1[$ch1]);
			
			$indu_rent='';
			$shdate=date("Y-m-d",strtotime($_POST[$fr.'_sdat'.$h1]));
			
			if(trim($_POST[$fr.'_food_id'.$h1])!='')
			{
				$shfood=$_POST[$fr.'_food_id'.$h1];
			}else{
				$shfood='';
			}
			
			if(isset($_POST[$fr.'_ext_item_id'.$h1][0]) && $_POST[$fr.'_ext_item_id'.$h1][0]!='')
			{
				$sh_extra=implode(',',$_POST[$fr.'_ext_item_id'.$h1]);
			}else
			{
				$sh_extra='';
			}
			
			$shotel=$_POST[$fr.'_hotel_sel_id'.$h1];
			$check_hpro='';
								$pro=$conn->prepare("select * from hotel_pro where hotel_id=?");
								$pro->execute(array($shotel));
								$row_pro=$pro->fetch(PDO::FETCH_ASSOC);
								if(trim($row_pro['category'])=='HOUSEBOAT')
								{
									$check_hpro='HOUSEBOAT';
								}
								
			$shroom='';
			$indu_room_rent='';
			$shroom_names='';
			//to check that hotel is houseboat or not
			if($check_hpro!='HOUSEBOAT')
			{
					for($h3=1;$h3<=$child;$h3++)
					{
						//echo "Room".$h3."=".$_POST['hot_rm_id'.$h1.'_'.$h3];
						if($shroom=='')
						{
							$shroom=$_POST[$fr.'_hot_rm_id'.$h1.'_'.$h3];
						}else{
							$shroom=$shroom.','.$_POST[$fr.'_hot_rm_id'.$h1.'_'.$h3];
						}
						//finding room name to add table
							$rm_snumber=$_POST[$fr.'_hot_rm_id'.$h1.'_'.$h3];
							
							$rnammm = $conn->prepare("SELECT * FROM hotel_season  where sno =?");
							$rnammm->execute(array($rm_snumber));
							$row_rnammm = $rnammm->fetch(PDO::FETCH_ASSOC);
							if($shroom_names=='')
							{
								$shroom_names=$row_rnammm['room_type'];
							}else{
								$shroom_names=$shroom_names.','.$row_rnammm['room_type'];
							}
						
						if($indu_room_rent=='')
						{
							$indu_room_rent=$_POST[$fr.'_hot_rm_rent'.$h1.'_'.$h3];
						}else{
							$indu_room_rent=$indu_room_rent.','.$_POST[$fr.'_hot_rm_rent'.$h1.'_'.$h3];
						}
						$perday_amtcal=$perday_amtcal+$_POST[$fr.'_hot_rm_rent'.$h1.'_'.$h3];
					}
					
			}else if($check_hpro=='HOUSEBOAT')
			{
				//echo "HOUSEBOAT".$h1;	
				$loop=$_POST[$fr.'_tr_cnt_'.$h1];
				for($hb=0;$hb<=$loop;$hb++)
				{
						//echo "Room".$h3."=".$_POST['hot_rm_id'.$h1.'_'.$h3];
						if($shroom=='')
						{
							$shroom=$_POST[$fr.'_hot_hb_rm_id'.$h1.'_'.$hb];
						}else{
							$shroom=$shroom.','.$_POST[$fr.'_hot_hb_rm_id'.$h1.'_'.$hb];
						}
						//finding room name to add table
							$rm_snumber=$_POST[$fr.'_hot_hb_rm_id'.$h1.'_'.$hb];
							
							$rnammm = $conn->prepare("SELECT * FROM hotel_season  where sno =?");
							$rnammm->execute(array($rm_snumber));
							$row_rnammm = $rnammm->fetch(PDO::FETCH_ASSOC);
							if($shroom_names=='')
							{
								$shroom_names=$row_rnammm['room_type'];
							}else{
								$shroom_names=$shroom_names.','.$row_rnammm['room_type'];
							}
						
						if($indu_room_rent=='')
						{
							$indu_room_rent=$_POST[$fr.'_hot_hb_rm_rent'.$h1.'_'.$hb];
						}else{
							$indu_room_rent=$indu_room_rent.','.$_POST[$fr.'_hot_hb_rm_rent'.$h1.'_'.$hb];
						}
						$perday_amtcal=$perday_amtcal+$_POST[$fr.'_hot_hb_rm_rent'.$h1.'_'.$hb];
				}
			}
			
			/*for($h4=1;$h4<=$child;$h4++)
			{
				if($h4 ==1)
				{
					$shadult=$_POST['sel_adlt_nw'.$h4];
				}else
				{
					$shadult=$shadult.','.$_POST['sel_adlt_nw'.$h4];
				}
			}*/
			$shadult=$room_info_pow_arr[0];
			
			
			/*for($h4=1;$h4<=$child;$h4++)
			{
				if($h4 ==1)
				{
					$shchild512=$_POST['sel_nw_512ch'.$h4];
				}else
				{
					$shchild512=$shchild512.','.$_POST['sel_nw_512ch'.$h4];
				}
			}*/
			$shchild512=$room_info_pow_arr[1];
			
		/*	$shchild512=$_POST['youth_sel'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shchild512=$shchild512.','.$_POST['youth_sel'.$h1.'_'.$h4];
			}*/
			
			
			/*for($h4=1;$h4<=$child;$h4++)
			{
				if($h4 ==1)
				{
					$shchild=$_POST['sel_nw_b5ch'.$h4];
				}else
				{
					$shchild=$shchild.','.$_POST['sel_nw_b5ch'.$h4];
				}
			}*/
			$shchild=$room_info_pow_arr[2];
			
			/*$shchild=$_POST['child_sel'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shchild=$shchild.','.$_POST['child_sel'.$h1.'_'.$h4];
			}*/
			
			if($check_hpro!='HOUSEBOAT')
			{
				$shextra=$room_info_pow_arr[3];
				/*
				for($h4=1;$h4<=$child;$h4++)
				{
					
					if($h4 ==1)
					{
						if(!isset($_POST['sel_nw_extr'.$h4]))
						{
							$shextra='0';
							$_POST['sel_nw_extr'.$h4]=0;
						}else{
							$shextra=$_POST['sel_nw_extr'.$h4];
						}
					}else
					{
						if(!isset($_POST['sel_nw_extr'.$h4]))
						{
							$shextra=$shextra.',0';
							$_POST['sel_nw_extr'.$h4]=0;
						}else{
						$shextra=$shextra.','.$_POST['sel_nw_extr'.$h4];	
						}
					}
				}
			*/}else if($check_hpro=='HOUSEBOAT')
			{
				$loop=$_POST[$fr.'_tr_cnt_'.$h1];
				for($hb1=0;$hb1<=$loop;$hb1++)
				{
					if($hb1 ==0)
					{
						if(!isset($_POST[$fr.'_sel_hb_nw_extr'.$h1.'_'.$hb1]))
						{
							$shextra='0';
							$_POST[$fr.'_sel_hb_nw_extr'.$h1.'_'.$hb1]=0;
						}else{
							$shextra=$_POST[$fr.'_sel_hb_nw_extr'.$h1.'_'.$hb1];
						}
					}else
					{
						if(!isset($_POST[$fr.'_sel_hb_nw_extr'.$h1.'_'.$hb1]))
						{
							$shextra=$shextra.',0';
							$_POST[$fr.'_sel_hb_nw_extr'.$h1.'_'.$hb1]=0;
						}else{
						$shextra=$shextra.','.$_POST[$fr.'_sel_hb_nw_extr'.$h1.'_'.$hb1];	
						}
					}
				}
			}
			//echo "<br>ext ".$shextra;
			//echo "['sel_nw_extr']= ".$_POST['sel_nw_extr'.$h4];
			//for child bet rate add to perday rate
			$rate_for_child_bed=0;
			
			if($check_hpro!='HOUSEBOAT')
			{
				$ext_bd_arr=explode(',',$shextra);
				for($h4=0;$h4<count($ext_bd_arr);$h4++)
				{
					if($ext_bd_arr[$h4]=='0')
					{
						$rate_for_child_bed=$rate_for_child_bed+$_POST[$fr.'_withbed_rate1'.$h1];
					}else if($ext_bd_arr[$h4]=='1')
					{
						$rate_for_child_bed=$rate_for_child_bed+$_POST[$fr.'_withoutbed_rate'.$h1];
					}else if($ext_bd_arr[$h4]=='-')
					{
						$rate_for_child_bed=$rate_for_child_bed+0;
					}
				}
			}else if($check_hpro=='HOUSEBOAT')
			{
				
				$loop=$_POST[$fr.'_tr_cnt_'.$h1];
				for($hb2=0;$hb2<=$loop;$hb2++)
				{
					//echo "<br>sel_hb_nw_extr".$h1.'_'.$hb2." = ".$_POST['sel_hb_nw_extr'.$h1.'_'.$hb2];
					if($_POST[$fr.'_sel_hb_nw_extr'.$h1.'_'.$hb2]=='0')
					{
						$rate_for_child_bed=$rate_for_child_bed+$_POST[$fr.'_withbed_rate'.$h1];
					}else if($_POST[$fr.'_sel_hb_nw_extr'.$h1.'_'.$hb2]=='1')
					{
						$rate_for_child_bed=$rate_for_child_bed+$_POST[$fr.'_withoutbed_rate'.$h1];
					}else if($_POST[$fr.'_sel_hb_nw_extr'.$h1.'_'.$hb2]=='-')
					{
						$rate_for_child_bed=$rate_for_child_bed+0;
					}
				}
				//echo "Bed rate=".$rate_for_child_bed;
			}
			$perday_amtcal=$perday_amtcal+$rate_for_child_bed;
			
			//$shfood=$room_info_pow_arr[4];
			
			$food_person=($row_master['pax_adults']+$row_master['pax_512child']);
			if($_POST[$fr.'_food_id'.$h1]=='lunch_rate')
			{
				$perday_amtcal=$perday_amtcal+$food_person*$_POST[$fr.'_foood_rate'.$h1];
			}else if($_POST[$fr.'_food_id'.$h1]=='dinner_rate')
			{
				$perday_amtcal=$perday_amtcal+$food_person*$_POST[$fr.'_foood_rate'.$h1];
			}else if($_POST[$fr.'_food_id'.$h1]=='both_food')
			{
				$rate_fff=explode(',',$_POST[$fr.'_foood_rate'.$h1]);
				$perday_amtcal=$perday_amtcal+($rate_fff[0]*$food_person);
			}
			
			$rate_spl=explode(',',$_POST[$fr.'_others_rate'.$h1]);
			$perday_amtcal=$perday_amtcal+$rate_spl[0];
			
			$indu_rent=$indu_room_rent.'-'.$rate_for_child_bed.','.$_POST[$fr.'_withbed_rate'.$h1].','.$_POST[$fr.'_withoutbed_rate'.$h1].'-'.$_POST[$fr.'_foood_rate'.$h1].'-'.$_POST[$fr.'_others_rate'.$h1];
			
			//total amount calculation
			$totalday_amtcal=$totalday_amtcal+$perday_amtcal;
			
			//$perday_amount=$_POST['perdayid'.$h1];
			 $HotelSQL = $conn->prepare("INSERT INTO stay_sched (stay_id, hotel_id, sty_date, sty_city, sty_room_type, sty_room_name, sty_adults, sty_512child, sty_child, sty_child_bed, sty_food, sty_extra, sty_indu_rent, sys_amount, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?, '0')");
			 $HotelSQL->execute(array($row_master['plan_id'],$shotel,$shdate,$shcity,$shroom,$shroom_names,$shadult,$shchild512,$shchild,$shextra,$shfood,$sh_extra,$indu_rent,$perday_amtcal));
			
	}//for end
		
		$grant_ttttol=($row_master['tr_net_amt']+$totalday_amtcal);
		
		$agnt_grnd_adm = $grant_ttttol + ($grant_ttttol * ($row_master['agent_perc'] / 100));
		$agnt_grnd_tot = $agnt_grnd_adm + ($agnt_grnd_adm * ($row_master['agnt_adm_perc'] / 100));
		
		$trav_name=$_POST['gtitle1'].'.'.$_POST['guestname1'];
		$upd_master=$conn->prepare("update travel_master set tr_name=?, tr_mobile=?, tr_arrdet=?, tr_depdet=?, stay_tot_amt=?, grand_tot=?, agnt_grand_tot=?, status='2' where plan_id=?");
		$upd_master->execute(array($trav_name,$_POST['mobil1'],$_POST['arrdet1'],$_POST['depdet1'],$totalday_amtcal,$grant_ttttol,$agnt_grnd_tot,$row_master['plan_id']));
}//main for loop
		
?>