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
  
  $tfrm=trim($_POST['tot_num_of_form']);
  $num_of_itinerary='';
  $num_of_itin_cost=0;
  
if($_SESSION['grp'] == 'AGENT')
{
	$agent_id=$_SESSION['uid'];

	$agent=$conn->prepare("select * from agent_pro where agent_id=?");
	$agent->execute(array($agent_id));
	$row_agent = $agent->fetch(PDO::FETCH_ASSOC);
	
	$user_fname=$row_agent['agent_fname'];
	$user_lname=$row_agent['agent_lname'];
	$user_email=$row_agent['email_id'];
	
	$distr_id = $row_agent['distr_id'];
	$agent_perc = $row_agent['my_percentage'];
	
	$agnt_adm_perc = $row_agent['brokerage_perc'];
	$creator=$user_fname.' '.$user_lname;
}
elseif ($_SESSION['grp'] == 'DISTRB')
{
	$agent_id='-';
	
	$distrbut=$conn->prepare("select * from distributor_pro where distr_id=?");
	$distrbut->execute(array($_SESSION['uid']));
	$row_distrbut = $distrbut->fetch(PDO::FETCH_ASSOC);
	
	$user_fname=$row_distrbut['distr_fname'];
	$user_lname=$row_distrbut['distr_lname'];
	$user_email=$row_distrbut['email_id'];
	
	$distr_id = $_SESSION['uid'];
	$agent_perc = 0; $agnt_adm_perc = $row_distrbut['my_percentage'];
	
	$creator=$user_fname.' '.$user_lname;
}

$sub_pln_arr=explode('-',$_SESSION['com_sub_plan_id']);
//echo "sub_pln_arr =";
//print_r($sub_pln_arr);
$arr_cnrr=0;
	for($frrr=0;$frrr<=$tfrm;$frrr++)
	{
		$fr="br".$frrr;
		$num_arr=$arr_cnrr;
	//print_r($num_arr);
	//echo "Explode =".$num_arr[1];
	if(isset($_POST['arrdate_'.$fr]) && $_POST['arrdate_'.$fr]!='')
	{

$com_plan_id= $_SESSION['com_plan_id']=$sub_pln_arr[$num_arr];
if(isset($_SESSION['com_plan_id']))
{
	$tmst_bef=$conn->prepare("select * from travel_master where plan_id=?");
	$tmst_bef->execute(array($_SESSION['com_plan_id']));
	$row_tmst_bef = $tmst_bef->fetch(PDO::FETCH_ASSOC);
	$additional_cost_bef=$row_tmst_bef['tot_additional_cost'];
}else
{
	$additional_cost_bef=0;	
}

	if($sub_pln_arr[$num_arr]!='')
	{
		$frm=$fr;
		$common_id='';
	
	$tr_veh = ''; $tr_vehnm = '';
	$tr_cnt = ((int)$_POST['num_traveller_'.$frm]+(int)$_POST['num_chd512_'.$frm]+(int)$_POST['num_chd_b5_'.$frm]);
	$arr_dt = $_POST['arrdate_'.$frm];
	$arr_tm = $_POST['arrtime_'.$frm];
	$arr_city = $_POST[$frm.'_st_city0'];
	$exp_arrcit = explode('-', $arr_city);
	$trim_cityid = trim($exp_arrcit[0]);
	$vehicles = $_POST[$frm.'_vehicles'];
	$impveh = implode(',',$vehicles);
	$expveh = explode(',',$impveh);
	$pervehamt = $_POST[$frm.'_pervehamt'];
	//$exp_perveh = explode('-',$pervehamt);
	
	$vehcitid = $_POST[$frm.'_vehcitid'];
	for ($v=0;$v<count($expveh);$v++)
	{
		$expgetveh = explode('~',$expveh[$v]);
		if(isset($expgetveh[1]))
		$tr_veh.= $expgetveh[1].',';
		
		$vnam=$conn->prepare("select * from vehicle_pro where vehi_id=?");
		$vnam->execute(array($expgetveh[1]));
		$row_vnam = $vnam->fetch(PDO::FETCH_ASSOC);
		
		$tr_vehnm.= $row_vnam['vehicle_type'].',';
	}
	
	$tr_vehnm = rtrim($tr_vehnm,',');
	$tr_days = $_POST['num_tradays_'.$frm];
	$tr_nights = $_POST['num_tranight_'.$frm];
	$adult_cnt = $_POST['num_traveller_'.$frm];
	$child_cnt = $_POST[$frm.'_trv_child'];
	$room_cnt = $_POST[$frm.'_trv_room'];
	$dest_city = $_POST[$frm.'_dest_id'];
	$trav_dist = $_POST[$frm.'_traveldist'];
	$trav_dist_ess = $_POST[$frm.'_traveldist_ess'];
	$return_dis = $_POST[$frm.'_ret_dist'];
	$net_tr_dist = $trav_dist + $return_dis;
	$tr_tot_amt = $_POST[$frm.'_tr_tot_amt'];
	$ch512=$_POST['num_chd512_'.$frm];
	$addrate_for=$adult_cnt+$ch512;
	
	if(trim($agent_id)!='' && trim($distr_id)!='')
	{
	
	if(trim($_POST['check_boxss_br0'])=='1' && $_GET['option']=='plan_mystay')
	{
		
		$del_tm=$conn->prepare("delete from travel_master where plan_id=?");
		$del_tm->execute(array($com_plan_id));
		
		$del_tdt=$conn->prepare("delete from travel_daytrip where travel_id=?");
		$del_tdt->execute(array($com_plan_id));
		
		//$del_ts="delete from travel_sched where travel_id='".$com_plan_id."'";
		//mysql_query($del_ts);
		
		$del_tv=$conn->prepare("delete from travel_vehicle where travel_id=?");
		$del_tv->execute(array($com_plan_id));
		
		$del_dtr=$conn->prepare("delete from dvi_trans_rpt where travel_id=?");
		$del_dtr->execute(array($com_plan_id));
		
		$adult_cnt =$_POST['num_traveller_'.$frm];
		$child_cnt =$_POST['num_chd_b5_'.$frm];
		$child512_no_cnt=(int)$_POST['num_chd512_'.$frm];
		//echo "traval + hotel";
		/*
		$query_genid = "SELECT * FROM setting_ids  where sno = $sno";
		$genid = mysql_query($query_genid, $divdb) or die(mysql_error());
		$row_genid = mysql_fetch_assoc($genid);
		
		$id=$row_genid['id_name'].$row_genid['id_number'];
		$idin=$row_genid['id_number']+1;*/
		
		//Get Day trip details if applicable
		$dt_totdis = $_POST[$frm.'_dt_dist'];
		
		if($dt_totdis > 0)
		{
			$dt_detls = $_POST[$frm.'_dt_detls'];
			$dt_cid   = $_POST[$frm.'_dt_citid'];
			$dt_trdist_ess   = $_POST[$frm.'_dt_altrdist'];
			$dt_ss_dist   = $_POST[$frm.'_dt_alssdist'];
			$dt_alldist   = $dt_totdis;
			$net_tr_dist+=$dt_totdis;
			
			$trim_dt = rtrim($dt_detls,',');
			$exp_dt = explode(',',$trim_dt);
			
			for($dt=0;$dt<count($exp_dt);$dt++)
			{
				$each_exp_dt = explode('-',$exp_dt[$dt]);
				$dt_totdist = ($each_exp_dt[2] * 2) + $each_exp_dt[3];
				
				$insertSQL2a = $conn->prepare("INSERT INTO travel_daytrip (travel_id, orig_cid, from_cid, to_cid, trav_dist, ss_dist, tot_dist, status) VALUES (?,?,?,?,?,?,?, 0)");
				$insertSQL2a->execute(array($com_plan_id,$each_exp_dt[0],$each_exp_dt[0],$each_exp_dt[1],$each_exp_dt[2],$each_exp_dt[3],$dt_totdist));
			}
		}
		else
		{
			$dt_detls = '-';
			$dt_cid   = '-';
			$dt_trdist_ess   = 0;
			$dt_ss_dist   = 0;
			$dt_alldist   = 0;
		}
		
		$allper_amt1 = $_POST[$frm.'_permt_amt'];
		$allper_amt = explode('-',$allper_amt1);
		$itiner_city = $_POST[$frm.'_citydata'];
		//$tr_dates = $_POST['start_date'];
		$itiner_city1 = implode(',', $itiner_city);
		$itiner_city2 = explode(',', $itiner_city1);
		//echo count($itiner_city2);
		for ($detl_itn=0;$detl_itn<count($itiner_city2);$detl_itn++)
		{
			$tr_dates = $_POST[$frm.'_start_date'.$detl_itn];
			$exp_itin_city = explode('-', $itiner_city2[$detl_itn]);
			$ssdist = $exp_itin_city[4] - $exp_itin_city[2];
			
			$ssddate=date("Y-m-d",strtotime($tr_dates));
			
			$trvia='-';
			if(isset($_POST['sel_via_trav_cids_'.$detl_itn.'_'.$frm]))
			{
				$trvia=	$_POST['sel_via_trav_cids_'.$detl_itn.'_'.$frm];
			}
			
			$addi_cst_name='';
			$addi_cst_amt='';
			if(isset($_POST[$frm.'_addi_sno_'.$ssddate]) && $_POST[$frm.'_addi_sno_'.$ssddate]=='')
			{
				$addi_cst_arry=explode(',',$_POST[$frm.'_addi_sno_'.$ssddate]);
				for($ac=0;$ac<count($addi_cst_arry);$ac++)
				{
									$saddi=$conn->prepare("SELECT * FROM additional_cost WHERE sno=?");
                                    $saddi->execute(array($addi_cst_arry[$ac]));
                                    $row_saddi=$saddi->fetch(PDO::FETCH_ASSOC);
                                    
									if($addi_cst_name=='')
									{
										$addi_cst_name=$row_saddi['short_desc'];
									}else{
										$addi_cst_name=$addi_cst_name.'/'.$row_saddi['short_desc'];
									}
				}
			if(isset($_POST[$frm.'_addi_cst_'.$ssddate]) && trim($_POST[$frm.'_addi_cst_'.$ssddate])!='')
				{
					$addi_cst_amt=$_POST[$frm.'_addi_cst_'.$ssddate];
				}
			}
			
			//$insertSQL2 = "INSERT INTO travel_sched (travel_id, tr_date, tr_from_cityid, tr_to_cityid, via_cities, ss_dist, tr_dist_ss, tr_dist_ess, tr_time, addi_cost_for, addi_amount, status) VALUES ('$com_plan_id', '$ssddate', '$exp_itin_city[0]', '$exp_itin_city[1]', '$trvia', '$ssdist', '$exp_itin_city[4]', '$exp_itin_city[2]', '".$_POST['trav_times'.$detl_itn]."','$addi_cst_name', '$addi_cst_amt', 1)";
			//
			//$Result2 = mysql_query($insertSQL2, $divdb) or die(mysql_error());
		}
		
		//for hotel+traval 
		
	$par=$_POST[$frm.'_day_of_stay'];
		$child=$_POST['num_room_htls_'.$frm]; 
		
		$cityy1=explode(',',$_POST[$frm.'_kit_cityidd']);
		 
		$totalday_amtcal=0;
		
	//	echo "day of stay par : ".$par;
		for($h1=1; $h1<=$par; $h1++)
		{   $perday_amtcal=0;
			
			$ch1=$h1-1;
			$shcity=trim($cityy1[$ch1]);
			
			$indu_rent='';
			$shdate=date("Y-m-d",strtotime($_POST[$frm.'_sdat'.$h1]));
			
			if(isset($_POST[$frm.'_food_id'.$h1]) && trim($_POST[$frm.'_food_id'.$h1])!='')
			{
				$shfood=$_POST[$frm.'_food_id'.$h1];
			}else{
				$shfood='';
			}
			
			if(isset($_POST[$frm.'_ext_item_id'.$h1][0]) && $_POST[$frm.'_ext_item_id'.$h1][0]!='')
			{
				$sh_extra=implode(',',$_POST[$frm.'_ext_item_id'.$h1]);
			}else
			{
				$sh_extra='';
			}
			
			$shotel=$_POST[$frm.'_hotel_sel_id'.$h1];
			$check_hpro='';
								$pro=$conn->prepare("select * from hotel_pro where hotel_id=?");
								$pro->execute(array($shotel));
								$row_pro=$pro->fetch(PDO::FETCH_ASSOC);
								if(trim($row_pro['category'])=='HOUSEBOAT' || trim($row_pro['category'])=='House Boat' )
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
							$shroom=$_POST[$frm.'_hot_rm_id'.$h1.'_'.$h3];
						}else{
							$shroom=$shroom.','.$_POST[$frm.'_hot_rm_id'.$h1.'_'.$h3];
						}
						//finding room name to add table
							$rm_snumber=$_POST[$frm.'_hot_rm_id'.$h1.'_'.$h3];
							
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
							$indu_room_rent=$_POST[$frm.'_hot_rm_rent'.$h1.'_'.$h3];
						}else{
							$indu_room_rent=$indu_room_rent.','.$_POST[$frm.'_hot_rm_rent'.$h1.'_'.$h3];
						}
						$perday_amtcal=$perday_amtcal+$_POST[$frm.'_hot_rm_rent'.$h1.'_'.$h3];
					}
					
			}else if($check_hpro=='HOUSEBOAT' || $check_hpro=='House Boat' )
			{
				
				echo "HOUSEBOAT".$h1;	
		
			print	$loop=$_POST[$frm.'_tr_cnt_'.$h1];
				for($hb=0;$hb<=$loop;$hb++)
				{
						//echo "Room".$h3."=".$_POST['hot_rm_id'.$h1.'_'.$h3];
						if($shroom=='')
						{
							$shroom=$_POST[$frm.'_hot_hb_rm_id'.$h1.'_'.$hb];
						}else{
							$shroom=$shroom.','.$_POST[$frm.'_hot_hb_rm_id'.$h1.'_'.$hb];
						}
						//finding room name to add table
							$rm_snumber=$_POST[$frm.'_hot_hb_rm_id'.$h1.'_'.$hb];
			
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
							$indu_room_rent=$_POST[$frm.'_hot_hb_rm_rent'.$h1.'_'.$hb];
						}else{
							$indu_room_rent=$indu_room_rent.','.$_POST[$frm.'_hot_hb_rm_rent'.$h1.'_'.$hb];
						}
						$perday_amtcal=$perday_amtcal+$_POST[$frm.'_hot_hb_rm_rent'.$h1.'_'.$hb];
				}
			}
			
			for($h4=1;$h4<=$child;$h4++)
			{
				if($h4 ==1)
				{
					$shadult=$_POST[$frm.'_sel_adlt_nw'.$h4];
				}else
				{
					$shadult=$shadult.','.$_POST[$frm.'_sel_adlt_nw'.$h4];
				}
			}
			
			
			for($h4=1;$h4<=$child;$h4++)
			{
				if($h4 ==1)
				{
					$shchild512=$_POST[$frm.'_sel_nw_512ch'.$h4];
				}else
				{
					$shchild512=$shchild512.','.$_POST[$frm.'_sel_nw_512ch'.$h4];
				}
			}
			
		/*	$shchild512=$_POST['youth_sel'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shchild512=$shchild512.','.$_POST['youth_sel'.$h1.'_'.$h4];
			}*/
			
			
			for($h4=1;$h4<=$child;$h4++)
			{
				if($h4 ==1)
				{
					$shchild=$_POST[$frm.'_sel_nw_b5ch'.$h4];
				}else
				{
					$shchild=$shchild.','.$_POST[$frm.'_sel_nw_b5ch'.$h4];
				}
			}
			
			/*$shchild=$_POST['child_sel'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shchild=$shchild.','.$_POST['child_sel'.$h1.'_'.$h4];
			}*/
			
			
				for($h4=1;$h4<=$child;$h4++)
				{
					if($h4 ==1)
					{
						if(!isset($_POST[$frm.'_sel_nw_extr'.$h4]))
						{
							$shextra='0';
							$_POST[$frm.'_sel_nw_extr'.$h4]=0;
						}else{
							$shextra=$_POST[$frm.'_sel_nw_extr'.$h4];
						}
					}else
					{
						if(!isset($_POST[$frm.'_sel_nw_extr'.$h4]))
						{
							$shextra=$shextra.',0';
							$_POST[$frm.'_sel_nw_extr'.$h4]=0;
						}else{
						$shextra=$shextra.','.$_POST[$frm.'_sel_nw_extr'.$h4];	
						}
					}
				}
			
			/*
			else if($check_hpro=='HOUSEBOAT' || $check_hpro=='House Boat')
			{
				$loop=$_POST[$frm.'_tr_cnt_'.$h1];
				for($hb1=0;$hb1<=$loop;$hb1++)
				{
					if($hb1 ==0)
					{
						if(!isset($_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb1]))
						{
							$shextra='0';
							$_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb1]=0;
						}else{
							$shextra=$_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb1];
						}
					}else
					{
						if(!isset($_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb1]))
						{
							$shextra=$shextra.',0';
							$_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb1]=0;
						}else{
						$shextra=$shextra.','.$_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb1];	
						}
					}
				}
			}
			*/
			//echo "<br>ext ".$shextra;
			//echo "['sel_nw_extr']= ".$_POST['sel_nw_extr'.$h4];
			//for child bet rate add to perday rate
			$rate_for_child_bed=0;
			
			if($check_hpro!='HOUSEBOAT')
			{
				for($h4=1;$h4<=$child;$h4++)
				{
					if($_POST[$frm.'_sel_nw_extr'.$h4]=='0')
					{
						$rate_for_child_bed=$rate_for_child_bed+$_POST[$frm.'_withbed_rate'.$h1];
					}else if($_POST[$frm.'_sel_nw_extr'.$h4]=='1')
					{
						$rate_for_child_bed=$rate_for_child_bed+$_POST[$frm.'_withoutbed_rate'.$h1];
					}else if($_POST[$frm.'_sel_nw_extr'.$h4]=='-')
					{
						$rate_for_child_bed=$rate_for_child_bed+0;
					}
					
				}
			}else if($check_hpro=='HOUSEBOAT' || $check_hpro=='House Boat')
			{
				$loop=$_POST[$frm.'_tr_cnt_'.$h1];
				for($hb2=0;$hb2<=$loop;$hb2++)
				{
					//echo "<br>sel_hb_nw_extr".$h1.'_'.$hb2." = ".$_POST['sel_hb_nw_extr'.$h1.'_'.$hb2];
					if(isset($_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb2]) && $_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb2]=='0')
					{
						$rate_for_child_bed=$rate_for_child_bed+$_POST[$frm.'_withbed_rate'.$h1];
					}else if(isset($_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb2]) && $_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb2]=='1')
					{
						$rate_for_child_bed=$rate_for_child_bed+$_POST[$frm.'_withoutbed_rate'.$h1];
					}else if(isset($_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb2]) && $_POST[$frm.'_sel_hb_nw_extr'.$h1.'_'.$hb2]=='-')
					{
						$rate_for_child_bed=$rate_for_child_bed+0;
					}
				}
				//echo "Bed rate=".$rate_for_child_bed;
			}
			$perday_amtcal=$perday_amtcal+$rate_for_child_bed;
			
			$food_person=$_POST['num_traveller_'.$frm]+$_POST['num_chd512_'.$frm];
			if(isset($_POST[$frm.'_food_id'.$h1]) && $_POST[$frm.'_food_id'.$h1]=='lunch_rate')
			{
				$perday_amtcal=$perday_amtcal+$food_person*$_POST[$frm.'_foood_rate'.$h1];
			}else if(isset($_POST[$frm.'_food_id'.$h1]) && $_POST[$frm.'_food_id'.$h1]=='dinner_rate')
			{
				$perday_amtcal=$perday_amtcal+$food_person*$_POST[$frm.'_foood_rate'.$h1];
			}else if(isset($_POST[$frm.'_food_id'.$h1]) && $_POST[$frm.'_food_id'.$h1]=='both_food')
			{
				$rate_fff=explode(',',$_POST[$frm.'_foood_rate'.$h1]);
				$perday_amtcal=$perday_amtcal+($rate_fff[0]*$food_person);
			}
			
			$rate_spl=explode(',',$_POST[$frm.'_others_rate'.$h1]);
			$perday_amtcal=$perday_amtcal+$rate_spl[0];
			
		/*	$shextra=$_POST['extra_bed'.$h1];
			$indu_rent=$indu_rent.'-'.$_POST['extra_rate'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shextra=$shextra.','.$_POST['extra_bed'.$h1.'_'.$h4];
				$indu_rent=$indu_rent.','.$_POST['extra_rate'.$h1.'_'.$h4];
			}*/
			$indu_rent=$indu_room_rent.'-'.$rate_for_child_bed.','.$_POST[$frm.'_withbed_rate'.$h1].','.$_POST[$frm.'_withoutbed_rate'.$h1].'-'.$_POST[$frm.'_foood_rate'.$h1].'-'.$_POST[$frm.'_others_rate'.$h1];
			
			//total amount calculation
			$totalday_amtcal=$totalday_amtcal+$perday_amtcal;
							if(!isset($shroom))
			{
				$shroom = "";
			}
							if(!isset($shroom_names))
			{
				$shroom_names = "";
			}
			
			//$perday_amount=$_POST['perdayid'.$h1];
			  $HotelSQL = $conn->prepare("INSERT INTO stay_sched (stay_id, hotel_id, sty_date, sty_city, sty_room_type, sty_room_name, sty_adults, sty_512child, sty_child, sty_child_bed, sty_food, sty_extra, sty_indu_rent, sys_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,'0')");
		      $HotelSQL->execute(array($com_plan_id,$shotel,$shdate,$shcity,$shroom,$shroom_names,$shadult,$shchild512,$shchild,$shextra,$shfood,$sh_extra,$indu_rent,$perday_amtcal));
			
			
	}//for end
	
		
		$grant_ttttol=$tr_tot_amt+$totalday_amtcal+$additional_cost_bef;
		
		$agnt_grnd_adm = $grant_ttttol + ($grant_ttttol * ($agent_perc / 100));
		$agnt_grnd_tot = $agnt_grnd_adm + ($agnt_grnd_adm * ($agnt_adm_perc / 100));
		//$agnt_grnd_adm = $grant_ttttol + ($grant_ttttol * ($agnt_adm_perc / 100));
		//$agnt_grnd_tot = $agnt_grnd_adm + ($agnt_grnd_adm * ($agent_perc / 100));
$currency_rate=0;
$is_conver_currency = is_conver_currency();
if($is_conver_currency){	
$currencydb = $conn->prepare("SELECT currency_rate FROM dvi_front_settings WHERE sno =1");
$currencydb->execute();
$row_currencydb = $currencydb->fetch(PDO::FETCH_ASSOC);
$currency_rate = $row_currencydb['currency_rate'];
}


		
		$insertSQL1 = $conn->prepare("INSERT INTO travel_master (plan_id, agent_id, distr_id, tr_name, tr_mobile, tr_arrdet, tr_depdet, pax_cnt, tr_arr_date, tr_arr_time, trv_depatr_time, pax_adults, pax_512child, pax_child, tr_days, tr_nights, arr_cityid, dest_cityid, tr_vehids, tr_vehname, tr_veh_cityid, veh_tot_rent, dt_cid, dt_detls, tot_tr_dist, tot_tr_dist_ess, dt_tot_dist, dt_trdist_ess, dt_ss_dist, tr_return_dist, net_tr_dist, perm_cityid, permit_amt, tr_net_amt, stay_rooms, stay_tot_amt, tot_additional_cost, grand_tot, agent_perc, agnt_grand_tot, agnt_adm_perc, date_of_reg, status, currency_rate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '5', ?)");
		$insertSQL1->execute(array($com_plan_id,$agent_id,$distr_id,$com_plan_id,$_POST['mobil'],$_POST['arrdet'],$_POST['depdet'],$tr_cnt,$arr_dt,$arr_tm,$_POST['depart_time_'.$frm],$adult_cnt,$child512_no_cnt,$child_cnt,$tr_days,$tr_nights,$trim_cityid,$dest_city,$tr_veh,$tr_vehnm,$vehcitid,$pervehamt,$dt_cid,$dt_detls,$trav_dist,$trav_dist_ess,$dt_alldist,$dt_trdist_ess,$dt_ss_dist,$return_dis,$net_tr_dist,$allper_amt[0],$allper_amt[1],$tr_tot_amt,$room_cnt,$totalday_amtcal,$additional_cost_bef,$grant_ttttol,$agent_perc,$agnt_grnd_tot,$agnt_adm_perc,$booking_date,$currency_rate));
	
		$veh_upl = $_POST[$frm.'_veh_upl'];
		$veh_upl1 = explode('/',$veh_upl);
		
		for($vcnt=0;$vcnt<count($veh_upl1)-1;$vcnt++)
		{
			$veh_upl2 = explode('-',$veh_upl1[$vcnt]);
	
			$insertSQL5 = $conn->prepare("INSERT INTO travel_vehicle (travel_id, vehicle_id, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
			$insertSQL5->execute(array($com_plan_id,$veh_upl2[0],$veh_upl2[1],$veh_upl2[2],$veh_upl2[3],$veh_upl2[4],$veh_upl2[5],$veh_upl2[6],$veh_upl2[7],$veh_upl2[8],$veh_upl2[9]));
		}
		
		//Insert All travel vehicles from every city's info
		
		$allveh_detl = $_POST[$frm.'_all_veh_upl'];
		$exp_allveh = explode('~',$allveh_detl);
		
		foreach($exp_allveh as $each_veh_det)
		{
			$exp_each_veh = explode('#', $each_veh_det);
			$each_cityid = $exp_each_veh[0];
			
			$exp_get_veh = explode('/', $exp_each_veh[1]);
			
			for($evcnt=0;$evcnt<count($exp_get_veh)-1;$evcnt++)
			{
				$each_veh_upl = explode('-',$exp_get_veh[$evcnt]);
		
				$insertSQL6 = $conn->prepare("INSERT INTO dvi_trans_rpt (travel_id, city_id, vehicle_id, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
				$insertSQL6->execute(array($com_plan_id,$each_cityid,$each_veh_upl[0],$each_veh_upl[1],$each_veh_upl[2],$each_veh_upl[3],$each_veh_upl[4],$each_veh_upl[5],$each_veh_upl[6],$each_veh_upl[7],$each_veh_upl[8],$each_veh_upl[9]));
			}
		}
		
		/*$upd_id="UPDATE setting_ids SET id_number=$idin where sno = $sno";
		
		$Resultupd = mysql_query($upd_id, $divdb) or die(mysql_error());*/
			
		$_SESSION['com_plan_id']=$common_id=$com_plan_id;
		
						if($num_arr==0)
						{
				$sub_paln=$conn->prepare("UPDATE travel_master set sub_paln_id=? where plan_id=?");
				$sub_paln->execute(array($_SESSION['com_sub_plan_id'],$_SESSION['com_plan_id']));			
						}
		
			
	}//if cond for traval + hotel
	else if(trim($_POST['check_boxss_br0'])=='1' && $_GET['option']=='dvi_sugg')
	{
		//echo "DVI SUG";
		
	    $del_tm=$conn->prepare("delete from travel_master where plan_id=?");
		$del_tm->execute(array($com_plan_id));
		
		$del_tdt=$conn->prepare("delete from travel_daytrip where travel_id=?");
		$del_tdt->execute(array($com_plan_id));
		
		//$del_ts="delete from travel_sched where travel_id='".$com_plan_id."'";
		//mysql_query($del_ts);
		
		$del_tv=$conn->prepare("delete from travel_vehicle where travel_id=?");
		$del_tv->execute(array($com_plan_id));
		
		$del_dtr=$conn->prepare("delete from dvi_trans_rpt where travel_id=?");
		$del_dtr->execute(array($com_plan_id));
		
		$adult_cnt =$_POST['num_traveller_'.$frm];
		$child_cnt =$_POST['num_chd_b5_'.$frm];
		$child512_no_cnt=(int)$_POST['num_chd512_'.$frm];
		//echo "traval + hotel $sno see  here ";
		/*
		$query_genid = "SELECT * FROM setting_ids  where sno = '$sno'";
		$genid = mysql_query($query_genid, $divdb) or die(mysql_error());
		$row_genid = mysql_fetch_assoc($genid);
		
		$id=$row_genid['id_name'].$row_genid['id_number'];
		$idin=$row_genid['id_number']+1;*/
		
		//Get Day trip details if applicable
		$dt_totdis = $_POST[$frm.'_dt_dist'];
		//echo "DVI SUG- dt_totdis $dt_totdis";
		if($dt_totdis > 0)
		{
			$dt_detls = $_POST[$frm.'_dt_detls'];
			$dt_cid   = $_POST[$frm.'_dt_citid'];
			$dt_trdist_ess   = $_POST[$frm.'_dt_altrdist'];
			$dt_ss_dist   = $_POST[$frm.'_dt_alssdist'];
			$dt_alldist   = $dt_totdis;
			$net_tr_dist+=$dt_totdis;
			
			$trim_dt = rtrim($dt_detls,',');
			$exp_dt = explode(',',$trim_dt);
			
			for($dt=0;$dt<count($exp_dt);$dt++)
			{
				$each_exp_dt = explode('-',$exp_dt[$dt]);
				$dt_totdist = ($each_exp_dt[2] * 2) + $each_exp_dt[3];
				$insertSQL2a = $conn->prepare("INSERT INTO travel_daytrip (travel_id, orig_cid, from_cid, to_cid, trav_dist, ss_dist, tot_dist, status) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
				$insertSQL2a->execute(array($com_plan_id,$each_exp_dt[0],$each_exp_dt[0],$each_exp_dt[1],$each_exp_dt[2],$each_exp_dt[3],$dt_totdist));
			}
		}
		else
		{
			$dt_detls = '-';
			$dt_cid   = '-';
			$dt_trdist_ess   = 0;
			$dt_ss_dist   = 0;
			$dt_alldist   = 0;
		}
		
		
		$allper_amt1 = $_POST[$frm.'_permt_amt'];
		$allper_amt = explode('-',$allper_amt1);
		$itiner_city = $_POST[$frm.'_citydata'];
		//$tr_dates = $_POST['start_date'];
		$itiner_city1 = implode(',', $itiner_city);
		$itiner_city2 = explode(',', $itiner_city1);
		//echo count($itiner_city2);
		for ($detl_itn=0;$detl_itn<count($itiner_city2);$detl_itn++)
		{
			$tr_dates = $_POST[$frm.'_start_date'.$detl_itn];
			$exp_itin_city = explode('-', $itiner_city2[$detl_itn]);
			$ssdist = $exp_itin_city[4] - $exp_itin_city[2];
			
			$ssddate=date("Y-m-d",strtotime($tr_dates));
			
			$trvia='-';
			if(isset($_POST['sel_via_trav_cids_'.$detl_itn.'_'.$frm]))
			{
				$trvia=	$_POST['sel_via_trav_cids_'.$detl_itn.'_'.$frm];
			}
			
			$addi_cst_name='';
			$addi_cst_amt='';
			if(isset($_POST[$frm.'_addi_sno_'.$ssddate]) && $_POST[$frm.'addi_sno_'.$ssddate]!='')
			{
				$addi_cst_arry=explode(',',$_POST[$frm.'addi_sno_'.$ssddate]);
				for($ac=0;$ac<count($addi_cst_arry);$ac++)
				{
									$saddi=$conn->prepare("SELECT * FROM additional_cost WHERE sno=?");
                                    $saddi->execute(array($addi_cst_arry[$ac]));
                                    $row_saddi=$saddi->fetch(PDO::FETCH_ASSOC);
                                    
									if($addi_cst_name=='')
									{
										$addi_cst_name=$row_saddi['short_desc'];
									}else{
										$addi_cst_name=$addi_cst_name.'/'.$row_saddi['short_desc'];
									}
				}
				$addi_cst_amt=$_POST[$frm.'addi_cst_'.$ssddate];
			}
			
			//$insertSQL2 = "INSERT INTO travel_sched (travel_id, tr_date, tr_from_cityid, tr_to_cityid, via_cities, ss_dist, tr_dist_ss, tr_dist_ess, tr_time, addi_cost_for, addi_amount, status) VALUES ('$com_plan_id', '$ssddate', '$exp_itin_city[0]', '$exp_itin_city[1]', '$trvia', '$ssdist', '$exp_itin_city[4]', '$exp_itin_city[2]', '".$_POST['trav_times'.$detl_itn]."','$addi_cst_name', '$addi_cst_amt', 1)";
		    //
			//$Result2 = mysql_query($insertSQL2, $divdb) or die(mysql_error());
		}
		
		//for hotel+traval 
		//echo "DVI SUG ***** Bas";
		$par=$_POST['num_tranight_'.$frm];
		$child=$_POST['num_room_htls_'.$frm];
		
		 $cityy1=explode(',',$_POST[$frm.'_kit_cityidd']);
		 
		 $totalday_amtcal=0;
		 if($_POST['prev_catg'] != '')
		 {
			 $sctg=trim($_POST['prev_catg']);
					for($h1=0; $h1<$par; $h1++)
					{   $perday_amtcal=0;
						$shcity=$_POST[$frm.'_cyid_'.$sctg.'_'.$h1];
						$indu_rent='';
						//$shdate=date("Y-m-d",strtotime($_POST['sdat'.$h1]));
						$shdate=$_POST[$frm.'_sdate_'.$sctg.'_'.$h1];
						
						$shfood='';
						$sh_extra='';
						//$shotel=$_POST['hotel_sel_id'.$h1];
						$shotel=$_POST[$frm.'_hid_'.$sctg.'_'.$h1];
				//echo "DVI SUG ***** Bas hotel_id $shotel";

				//my rooms
				$hrooom=$conn->prepare("select * from hotel_pro where hotel_id=?");
//echo "DVI SUG ***** sel_hctg $sel_hctg";
									$hrooom->execute(array($shotel));
									$row_hrooom = $hrooom->fetch(PDO::FETCH_ASSOC);
//echo "DVI SUG ***** row_hrooom $row_hrooom ";
//print_r ($row_hrooom );
									$tot_hrooom= $hrooom->rowCount();
									$ch_ctg='-';
									if($row_hrooom['category']=='HOUSEBOAT' || $row_hrooom['category']=='House Boat')
									{
										$ch_ctg="HB";	
									}
				//echo "DVI SUG ***** Bas ch_ctg  $ch_ctg";
						$shroom='';
						$indu_room_rent='';
						$shroom_names='';
				
						if($ch_ctg!="HB")//not house boating
						{
							//echo "NO HB =".$_POST['rmid_'.$sctg.'_'.$h1];
							for($rr=0;$rr<$child;$rr++)	
							{
								if($shroom=='')
								{
									if($_POST[$frm.'_rmid_'.$sctg.'_'.$h1]!='-')
									{
									$shroom=$_POST[$frm.'_rmid_'.$sctg.'_'.$h1];
									$indu_room_rent=$_POST[$frm.'_rent_'.$sctg.'_'.$h1];
									}else{
									$shroom='-';
									$indu_room_rent='0';
									}
								}else{
									if($_POST[$frm.'_rmid_'.$sctg.'_'.$h1]!='-')
									{
										$shroom=$shroom.','.$_POST[$frm.'_rmid_'.$sctg.'_'.$h1];
										$indu_room_rent=$indu_room_rent.','.$_POST[$frm.'_rent_'.$sctg.'_'.$h1];
									}else{
										$shroom=$shroom.',-';
										$indu_room_rent=$indu_room_rent.',0';
									}
								}
								
													//finding room name to add table
													$rm_snumber=$_POST[$frm.'_rmid_'.$sctg.'_'.$h1];
													
													$rnammm = $conn->prepare("SELECT * FROM hotel_season  where sno =?");
													$rnammm->execute(array($rm_snumber));
													$row_rnammm = $rnammm->fetch(PDO::FETCH_ASSOC);
													if($shroom_names=='')
													{
														$shroom_names=$row_rnammm['room_type'];
													}else{
														$shroom_names=$shroom_names.','.$row_rnammm['room_type'];
													}
								
								$perday_amtcal=$perday_amtcal+(int)$_POST[$frm.'_rent_'.$sctg.'_'.$h1];
							}
						}else{//for house boating
                        
							    //echo "ff".$_POST['rmid_'.$sctg.'_'.$h1];
								if($shroom=='')
								{
									if($_POST[$frm.'_rmid_'.$sctg.'_'.$h1]!='-')
									{
										$shroom=$_POST[$frm.'_rmid_'.$sctg.'_'.$h1];
										$indu_room_rent=$_POST[$frm.'_rent_'.$sctg.'_'.$h1];
									}else{
										$shroom='-';
										$indu_room_rent='0';
									}
								}else{
									if($_POST[$frm.'_rmid_'.$sctg.'_'.$h1]!='-')
									{
										$shroom=$shroom.','.$_POST[$frm.'_rmid_'.$sctg.'_'.$h1];
										$indu_room_rent=$indu_room_rent.','.$_POST[$frm.'_rent_'.$sctg.'_'.$h1];
									}else{
										$shroom=$shroom.',-';
										$indu_room_rent=$indu_room_rent.',0';
									}
								}
								
								
								$hbrent_arr=explode(',',$_POST[$frm.'_rent_'.$sctg.'_'.$h1]);
								$_POST[$frm.'_rent_'.$sctg.'_'.$h1]=array_sum($hbrent_arr);
								
							$perday_amtcal=$perday_amtcal+(int)$_POST[$frm.'_rent_'.$sctg.'_'.$h1];
							
								//finding room name to add table
									$ridd_arr=explode(',',$_POST[$frm.'_rmid_'.$sctg.'_'.$h1]);
//echo " ---------------------- "; 
									print_r($ridd_arr[0]);
                                    
//echo "%%%%% HB -1";
									for($y=0;$y<count($ridd_arr);$y++)
									{
													//$rm_snumber=$_POST['rmid_'.$sctg.'_'.$h1];echo "### HB -1  rm_snumber $rm_snumber ";
													$rm_snumber=$ridd_arr[$y];
if($rm_snumber != '') {
													
                                                    
													$rnammm = $conn->prepare("SELECT * FROM hotel_season  where sno =?");
					//echo "%%%%% HB -2  $rm_snumber $query_rnammm ";
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
							
						}

						//echo "<br>BBBB=".$perday_amtcal;
						//echo "<br>indu ".$indu_room_rent;
						for($h4=1;$h4<=$child;$h4++)
						{
							if($h4 ==1)
							{
								$shadult=$_POST[$frm.'_sel_adlt_nw'.$h4];
							}else
							{
								$shadult=$shadult.','.$_POST[$frm.'_sel_adlt_nw'.$h4];
							}
						}
						
						for($h4=1;$h4<=$child;$h4++)
						{
							if($h4 ==1)
							{
								$shchild512=$_POST[$frm.'_sel_nw_512ch'.$h4];
							}else
							{
								$shchild512=$shchild512.','.$_POST[$frm.'_sel_nw_512ch'.$h4];
							}
						}
						
						for($h4=1;$h4<=$child;$h4++)
						{
							if($h4 ==1)
							{
								$shchild=$_POST[$frm.'_sel_nw_b5ch'.$h4];
							}else
							{
								$shchild=$shchild.','.$_POST[$frm.'_sel_nw_b5ch'.$h4];
							}
						}
						
						for($h4=1;$h4<=$child;$h4++)
						{
							if($h4 ==1)
							{
								if(!isset($_POST[$frm.'_sel_nw_extr'.$h4]))
								{
									$shextra='0';
									$_POST[$frm.'_sel_nw_extr'.$h4]=0;
								}else{
									$shextra=$_POST[$frm.'_sel_nw_extr'.$h4];
								}
							}else
							{
								if(!isset($_POST[$frm.'_sel_nw_extr'.$h4]))
								{
									$shextra=$shextra.',0';
									$_POST[$frm.'_sel_nw_extr'.$h4]=0;
								}else{
								$shextra=$shextra.','.$_POST[$frm.'_sel_nw_extr'.$h4];	
								}
							}
						}
						
						if(isset($_POST[$frm.'_rmextr_'.$sctg.'_'.$h1]))
						{
									$shextra=$_POST[$frm.'_rmextr_'.$sctg.'_'.$h1];
						}
						//for child bet rate add to perday rate
						$rate_for_child_bed=0;
						if($ch_ctg!='HB')
						{
							for($h4=1;$h4<=$child;$h4++)
							{
								if($_POST[$frm.'_sel_nw_extr'.$h4]=='0')
								{
									$rate_for_child_bed=$rate_for_child_bed+$_POST[$frm.'_chwithbed_'.$sctg.'_'.$h1];
								}else if($_POST[$frm.'_sel_nw_extr'.$h4]=='1')
								{
									$rate_for_child_bed=$rate_for_child_bed+$_POST[$frm.'_chwithoutbed_'.$sctg.'_'.$h1];
								}else if($_POST[$frm.'_sel_nw_extr'.$h4]=='-')
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
									$rate_for_child_bed=$rate_for_child_bed+$_POST[$frm.'_chwithbed_'.$sctg.'_'.$h1];
								}else if($ex_bedd[$bd]=='1')
								{
									$rate_for_child_bed=$rate_for_child_bed+$_POST[$frm.'_chwithoutbed_'.$sctg.'_'.$h1];
								}else if($ex_bedd[$bd]=='-')
								{
									$rate_for_child_bed=$rate_for_child_bed+0;
								}
							}
						}
						//echo "<br>childbed bef=".$perday_amtcal;
						$perday_amtcal=$perday_amtcal+$rate_for_child_bed;
						//echo "<br>childbed=".$perday_amtcal;
						$food_person=$_POST['num_traveller_'.$frm]+$_POST['num_chd512_'.$frm];
						if($_POST['food_categ_dvi']=='lunch_rate')
						{
							$perday_amtcal=$perday_amtcal+$food_person*$_POST[$frm.'_lunchrate_'.$sctg.'_'.$h1];
							$ffood=$_POST[$frm.'_lunchrate_'.$sctg.'_'.$h1];
							$shfood=$_POST['food_categ_dvi'];
						}else if($_POST['food_categ_dvi']=='dinner_rate')
						{
							$perday_amtcal=$perday_amtcal+$food_person*$_POST[$frm.'_dinnerrate_'.$sctg.'_'.$h1];
							$ffood=$_POST[$frm.'_dinnerrate_'.$sctg.'_'.$h1];
							$shfood=$_POST['food_categ_dvi'];
						}else if($_POST['food_categ_dvi']=='both_food')
						{
							$bothfood=$_POST[$frm.'_dinnerrate_'.$sctg.'_'.$h1]+$_POST[$frm.'_lunchrate_'.$sctg.'_'.$h1];
							$ffood=$bothfood.','.$_POST[$frm.'_dinnerrate_'.$sctg.'_'.$h1].','.$_POST[$frm.'_lunchrate_'.$sctg.'_'.$h1];
							$perday_amtcal=$perday_amtcal+($bothfood*$food_person);
							$shfood=$_POST['food_categ_dvi'];
						}else if($_POST['food_categ_dvi']=='no'){
							$shfood="";
							$ffood='0';
						}
						
						$_POST[$frm.'_others_rate'.$h1]=0;
						$indu_rent=$indu_room_rent.'-'.$rate_for_child_bed.','.$_POST[$frm.'_chwithbed_'.$sctg.'_'.$h1].','.$_POST[$frm.'_chwithoutbed_'.$sctg.'_'.$h1].'-'.$ffood.'-'.$_POST[$frm.'_others_rate'.$h1];
						
						//total amount calculation
						$totalday_amtcal=$totalday_amtcal+$perday_amtcal;
						//echo "SEEEEEEEE ";
						//$perday_amount=$_POST['perdayid'.$h1];
						 $HotelSQL = $conn->prepare("INSERT INTO stay_sched (stay_id, hotel_id, sty_date, sty_city, sty_room_type, sty_room_name, sty_adults, sty_512child, sty_child, sty_child_bed, sty_food, sty_extra, sty_indu_rent, sys_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0')");
						 $HotelSQL->execute(array($com_plan_id,$shotel,$shdate,$shcity,$shroom,$shroom_names,$shadult,$shchild512,$shchild,$shextra,$shfood,$sh_extra,$indu_rent,$perday_amtcal));
						
						//echo "<br>Perday_amtcal=".$perday_amtcal;
				}//for end
		 }else{
			 echo "Resume..";
		 }
		//echo "DVI SUG ***** Bas 2";
		$grant_ttttol=$tr_tot_amt+$totalday_amtcal+$additional_cost_bef;
		
		$agnt_grnd_adm = $grant_ttttol + ($grant_ttttol * ($agent_perc / 100));
		$agnt_grnd_tot = $agnt_grnd_adm + ($agnt_grnd_adm * ($agnt_adm_perc / 100));
		
		if($num_arr==0)
		{
			$sub_paln_ids=$_SESSION['com_sub_plan_id'];
		}else{
			$sub_paln_ids='';
		}
$currency_rate=0;
$is_conver_currency = is_conver_currency();
if($is_conver_currency){	
$currencydb = $conn->prepare("SELECT currency_rate FROM dvi_front_settings WHERE sno =1");
$currencydb->execute();
$row_currencydb = $currencydb->fetch(PDO::FETCH_ASSOC);
$currency_rate = $row_currencydb['currency_rate'];
}



	 $insertSQL1 = $conn->prepare("INSERT INTO travel_master (plan_id, sub_paln_id, agent_id, distr_id, tr_name, tr_mobile, tr_arrdet, tr_depdet, pax_cnt, tr_arr_date, tr_arr_time, trv_depatr_time, pax_adults, pax_512child, pax_child, tr_days, tr_nights, arr_cityid, dest_cityid, tr_vehids, tr_vehname, tr_veh_cityid, veh_tot_rent, dt_cid, dt_detls, tot_tr_dist, tot_tr_dist_ess, dt_tot_dist, dt_trdist_ess, dt_ss_dist, tr_return_dist, net_tr_dist, perm_cityid, permit_amt, tr_net_amt, stay_rooms, stay_tot_amt,	tot_additional_cost, grand_tot, agent_perc, agnt_grand_tot, agnt_adm_perc, date_of_reg, status,currency_rate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, '5',?)");
	 $insertSQL1->execute(array($com_plan_id,$sub_paln_ids,$agent_id,$distr_id,$com_plan_id,$_POST['mobil'],$_POST['arrdet'],$_POST['depdet'],$tr_cnt,$arr_dt,$arr_tm,$_POST['depart_time_'.$frm],$adult_cnt,$child512_no_cnt,$child_cnt,$tr_days,$tr_nights,$trim_cityid,$dest_city,$tr_veh,$tr_vehnm,$vehcitid,$pervehamt,$dt_cid,$dt_detls,$trav_dist,$trav_dist_ess,$dt_alldist,$dt_trdist_ess,$dt_ss_dist,$return_dis,$net_tr_dist,$allper_amt[0],$allper_amt[1],$tr_tot_amt,$room_cnt,$totalday_amtcal,$additional_cost_bef,$grant_ttttol,$agent_perc,$agnt_grnd_tot,$agnt_adm_perc,$booking_date,$currency_rate));
	
		$veh_upl = $_POST[$frm.'_veh_upl'];
		$veh_upl1 = explode('/',$veh_upl);
		
		for($vcnt=0;$vcnt<count($veh_upl1)-1;$vcnt++)
		{
			$veh_upl2 = explode('-',$veh_upl1[$vcnt]);
	
			$insertSQL5 = $conn->prepare("INSERT INTO travel_vehicle (travel_id, vehicle_id, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
			$insertSQL5->execute(array($com_plan_id,$veh_upl2[0],$veh_upl2[1],$veh_upl2[2],$veh_upl2[3],$veh_upl2[4],$veh_upl2[5],$veh_upl2[6],$veh_upl2[7],$veh_upl2[8],$veh_upl2[9]));
		}
		
		//Insert All travel vehicles from every city's info
		
		$allveh_detl = $_POST[$frm.'_all_veh_upl'];
		$exp_allveh = explode('~',$allveh_detl);
		
		foreach($exp_allveh as $each_veh_det)
		{
			$exp_each_veh = explode('#', $each_veh_det);
			$each_cityid = $exp_each_veh[0];
			
			$exp_get_veh = explode('/', $exp_each_veh[1]);
			
			for($evcnt=0;$evcnt<count($exp_get_veh)-1;$evcnt++)
			{
				$each_veh_upl = explode('-',$exp_get_veh[$evcnt]);
		
				$insertSQL6 = $conn->prepare("INSERT INTO dvi_trans_rpt (travel_id, city_id, vehicle_id, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
				$insertSQL6->execute(array($com_plan_id,$each_cityid,$each_veh_upl[0],$each_veh_upl[1],$each_veh_upl[2],$each_veh_upl[3],$each_veh_upl[4],$each_veh_upl[5],$each_veh_upl[6],$each_veh_upl[7],$each_veh_upl[8],$each_veh_upl[9]));
			}
		}
		
		/*$upd_id="UPDATE setting_ids SET id_number=$idin where sno = $sno";
		
		$Resultupd = mysql_query($upd_id, $divdb) or die(mysql_error());*/
			
		$common_id=$com_plan_id=$_SESSION['com_plan_id'];
		
		
					/*if($num_of_itinerary=='')
					{
							$num_of_itinerary=$com_plan_id;
							echo $_SESSION['com_plan_id']=$common_id=$com_plan_id;
					}else{
						$num_of_itinerary=$num_of_itinerary."-".$com_plan_id;
					}
						//$_SESSION['com_sub_plan_id']=$num_of_itinerary;
						
						
						//echo $frm."SUB_PLAN=".$num_of_itinerary;*/
						
						if($num_arr==0)
						{
				$sub_paln=$conn->prepare("UPDATE travel_master set sub_paln_id=? where plan_id=?");
				$sub_paln->execute(array($_SESSION['com_sub_plan_id'],$_SESSION['com_plan_id']));		
						}

	}
	}//if agent and distributor id ==''
	else{
		
		if(trim($_SESSION['com_plan_id'])!='')
		{
		
		$del_tm=$conn->prepare("delete from travel_master where plan_id=?");
		$del_tm->execute(array(trim($_SESSION['com_plan_id'])));
		
		$del_tdt=$conn->prepare("delete from travel_daytrip where travel_id=?");
		$del_tdt->execute(array(trim($_SESSION['com_plan_id'])));
		
		$del_ts=$conn->prepare("delete from travel_sched where travel_id=?");
		$del_ts->execute(array(trim($_SESSION['com_plan_id'])));
		
		$del_tv=$conn->prepare("delete from travel_vehicle where travel_id=?");
		$del_tv->execute(array(trim($_SESSION['com_plan_id'])));
		
		$del_dtr=$conn->prepare("delete from dvi_trans_rpt where travel_id=?");
		$del_dtr->execute(array(trim($_SESSION['com_plan_id'])));
		}
		
		echo "<script>alert('Your session timing is out, please re-enter your itinerary..'); location.reload();</script>";
		
	}
	}
	$arr_cnrr++;
	}
}//main for loop forms

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date('d.m.Y');

$_GET['planid']=$sub_pln_arr[0];

//breakup start 

$breakup = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$breakup->execute(array($_GET['planid']));
$row_breakup = $breakup->fetch(PDO::FETCH_ASSOC);
$totalRows_breakup = $breakup->rowCount();

$break_arr=array();
//echo "Breakup =".$row_breakup['sub_paln_id'];
if(trim($row_breakup['sub_paln_id'])!='')//not empty
{
	$row_breakup['sub_paln_id'];
	$break_arr=explode('-',$row_breakup['sub_paln_id']);
	$break_arr_table=explode('-',$row_breakup['sub_paln_id']);
}
//print_r($break_arr);
//breakup end 

//total collection start 
$whole_itin_amt=0;
foreach($break_arr as $breakup_cal)
{
	
	$totcal = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
	$totcal->execute(array($breakup_cal));
	$row_totcal= $totcal->fetch(PDO::FETCH_ASSOC);
	$whole_itin_amt=$whole_itin_amt+$row_totcal['agnt_grand_tot'];
}
//total collection end

						//main break stay for
$break_chk=0;
foreach($break_arr as $breakup)
{
	$_GET['planid']=$breakup;

$idd=explode('#',$_GET['planid']);
$str=$idd[0];

	$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
	$orders->execute(array($_GET['planid']));
	$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
	$totalRows_orders = $orders->rowCount();


$srooms = $conn->prepare("SELECT * FROM stay_sched where stay_id =?");
$srooms->execute(array($_GET['planid']));
$row_srooms = $srooms->fetch(PDO::FETCH_ASSOC);
$totalRows_srooms = $srooms->rowCount();


$you = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$you->execute(array($_SESSION['uid']));
$row_you = $you->fetch(PDO::FETCH_ASSOC);
$totalRows_you = $you->rowCount();

//echo $row_you['comp_logo'];
?>
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
	font-family:roboto !important;
}

table td{
	padding:3px;
}

table td.tdstyle{
	padding:4px;
	border:#666 solid 1px;
}
</style>
							<?php
							$house_boat_avail="0";
							//////////
							if($break_chk!=0)
							{?>
                            <hr />
								<div class="row" style="padding:6px; text-align:center;border-top: 2px solid #E4AD69">
                                	<strong style="color:#C75A18"> Your Itinerary - will bypassing to below mentioned days [ Break-Stay ] </strong>
                                </div>
							<?php }
							//////////
							?>
							<div class="row">
								<?php if($break_chk==0)
								{ ?>
									<!--<div class="col-sm-12" style="padding:6px">
											<center><strong style="color:#6B4D1E; font-size: 22px;">Overall Package Cost : 
												<?php echo $whole_itin_amt."/- Only"; ?></strong></center>
									</div>-->

<center>
			<table style='width:94%; border:1px solid #ccc;' border='1'>
	<tr><th colspan="6" style="text-align: center;background-color: rgb(39, 96, 146);
color: whitesmoke; padding: 5px;"><?php echo "Itinerary Information "; ?></th></tr>
		<tr>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">S.No</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">Travelling Date</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">Total Pax</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">Vehicle Information</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">Total Rooms</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">Cost</th>
		</tr>
		<?php 
		$rno=1;
		$whole_pakcost=0;
		foreach($break_arr_table as $breakup1)
		{
			
			$or = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
			$or->execute(array($breakup1));
			$row_or = $or->fetch(PDO::FETCH_ASSOC);
			$totalRows_or = $or->rowCount();

			
			$htrm = $conn->prepare("SELECT * FROM stay_sched where stay_id = ?");
			$htrm->execute(array($breakup1));
			//$row_htrm= mysql_fetch_assoc($htrm);
			$row_htrm_main=$htrm->fetchAll();
			$totalRows_htrm = $htrm->rowCount();

			$room_arr=array();
			$exbeds_ch_arr=array();
			foreach($row_htrm_main as $row_htrm)
			{
				$exp_room=explode(',',$row_htrm['sty_room_name']);
				foreach($exp_room as $er)
				{
					array_push($room_arr, $er);
				}

				$exp_exbeds=explode(',',$row_htrm['sty_child_bed']);
				foreach($exp_exbeds as $ex)
				{
					array_push($exbeds_ch_arr, $ex);
				}
			}
		?>
		<tr>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;"><?php echo $rno; ?></th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">
				<?php echo date('d-M-Y',strtotime($row_or['tr_arr_date'])); 
				$date=date_create($row_or['tr_arr_date']);
				date_add($date,date_interval_create_from_date_string(($row_or['tr_days']-1)." days"));
				echo " - ".date_format($date,"d-M-Y");?>
			</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">
				<?php echo $row_or['pax_cnt']."&nbsp;Person(s)"; ?>
			</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">
			<?php
								$vah=explode(',',$row_or['tr_vehids']);
								for($r=0;$r<count($vah);$r++)
								{
									if(trim($vah[$r]) != '')
									{
						    
							$vpro = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id =?");
											$vpro->execute(array($vah[$r]));
											$row_vpro =$vpro->fetch(PDO::FETCH_ASSOC);
											$totalRows_vpro = $vpro->rowCount();
							if(isset($vah[$r+1]) && $vah[$r+1] != '')
							{
								 echo $row_vpro['vehicle_type'].",&nbsp;";
							}else
							{
								echo $row_vpro['vehicle_type'];
							}
									}
								}
								  ?>
			</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">
					<?php 
					//$arr_unq=array();
					//$arr_unq=array_unique($room_arr); 
					//print_r($arr_unq);

					$arr_unq_cnt=array();
					$arr_unq_cnt=array_count_values($room_arr); 

					//print_r($arr_unq_cnt);
					$tot_nroms=0;
					foreach ($arr_unq_cnt as $ckey => $cvalue) {
						//echo $ckey." - ".$cvalue;
						$tot_nroms=$tot_nroms+$cvalue;
					}
					//echo $tot_nroms." &nbsp;";
					//myeditd
					if($row_or['stay_rooms']==1)
					{
						echo $row_or['stay_rooms']." - room/day";
					}else if($row_or['stay_rooms']>1)
					{
						echo $row_or['stay_rooms']." - rooms/day";
					}

					//print_r($exbeds_ch_arr);
					$arr_exbedss=array();
					$arr_exbedss=array_count_values($exbeds_ch_arr); 
					//print_r($arr_exbedss);
					$clbra="1";
					foreach ($arr_exbedss as $key => $exvalue) {

						if(($key == "0" || $key == "1") && $clbra=="1")
						{
							echo " &nbsp; [ incl. ";
							$clbra++;
						}

						if($key=='0')
						{
							echo $exvalue." - Ex.Bed(s) ~";
						}else if($key=="1")
						{
							echo $exvalue." - Chld.Bed(s) ";
						}

						if($clbra>1)
						{
							echo " ]";
						}
					}

					?>
			</th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;">
					<?php  	 echo 	convert_currency_text("Rs",$_GET['planid'])." ".number_format(convert_currency($row_or['agnt_grand_tot'],$_GET['planid'])); 
					$whole_pakcost=$whole_pakcost+(float)$row_or['agnt_grand_tot']; ?>
			</th>
		</tr>
		<?php $rno++; } ?>
		<tr>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;text-align:center" colspan="5">Total Package Cost <small>( including food )</small></th>
			<th style="padding:6px; font-family:Calibri; font-size: 14px;background-color: rgb(227, 241, 254);">
			<?php echo convert_currency_text("Rs",$_GET['planid'])." ".convert_currency(($whole_pakcost),$_GET['planid'])." /-"; ?></th>
		</tr>
	</table>

<?php 
	$addon_arr=array();
	$addon_det=array();
		foreach($break_arr_table as $breakup2)
		{
			
			$shd = $conn->prepare("SELECT * FROM travel_sched where travel_id = ? and addi_cost_for!='' and addi_amount!=''");
			$shd->execute(array($breakup2));
			//$row_shd = mysql_fetch_assoc($shd);
			$row_shd_main=$shd->fetchAll();
			$totalRows_shd = $shd->rowCount();

				foreach($row_shd_main as $row_shd)
				{
					$addon_det['sdate']=$row_shd['tr_date'];
					$addon_det['sname']=$row_shd['addi_cost_for'];
					$addon_det['samt']=$row_shd['addi_amount'];
					$addon_det['sqnty']=$row_shd['num_person'];
					array_push($addon_arr,$addon_det);
				}
		}

//print_r($addon_arr);
		if(count($addon_arr)>0)
		{
			
	?>
	<div style="margin-left:30px; border-bottom:2px dotted rgb(102, 74, 34);">
		<p align="left" style="margin-top:5px"><strong style="font-size: 12px;color: #005598;"> Total Cost Including Special Add-ons On : </strong></p>
		<ul style="text-align: -moz-left;">
			<?php foreach($addon_arr as $spl){ ?>
			  <li style="font-size: 12px;text-align: left;"><?php //print_r($spl); 
		echo date("d-M-Y",strtotime($spl['sdate']))." - ".$spl['sname']." [ * ".$spl['sqnty']." ]";
			   ?> </li>
			<?php } ?>
		</ul></div>
	<?php  } ?>
		</center>
								<?php } ?>

                               <?php if($break_chk==0){?>
                               <input type="hidden" value="<?php echo $_GET['planid']; ?>" id='sub_planid' name="sub_planid" /><?php } 
					 $break_chk++;?>
                          
								<!--<center>
                                <table  style="width:95%; border:#EFC9A3 2px solid; background-color:#FFF4DF; color:#6B4D1E" class="table">
                               <tr><td width="18%">&nbsp;Creator</td><td width="3%">:</td><td width="25%"><?php echo $creator; ?></td>
                               <td width="18%">&nbsp;Reference Itinerary ID</td><td width="3%">:</td><td width="25%"><?php echo $row_orders['tr_name']; ?></td></tr>
                                <tr>
                               <td width="18%">&nbsp;Pax Count</td><td width="3%">:</td><td width="25%"><?php echo $row_orders['pax_cnt']."&nbsp;Person(s)"; ?></td>
                               <td width="18%">&nbsp;Room Count</td><td width="3%">:</td><td width="25%"><?php
							   $extra_bed=explode(',',$row_srooms['sty_child_bed']);
							   $bed='';
							   for($ex=0;$ex<count($extra_bed);$ex++)
							   {
								   if($extra_bed[$ex]=='0')
								   {
									   if($bed=='')
									   {
										  $bed="With Extra Bed"; 
									   }else{
										   $bed=$bed.", With Extra Bed"; 
									   }
								   }else if($extra_bed[$ex]=='1'){
									   
									   if($bed=='')
									   {
										  $bed="WithOut Extra Bed"; 
									   }else{
										   $bed=$bed.", WithOut Extra Bed"; 
									   }
								   }
							   }
							   
							   if($bed != '')
							   {
								   echo $row_orders['stay_rooms']." ( ".$bed." )";
							   }else{
							    	echo $row_orders['stay_rooms']; 
							   }?></td>
                                </tr>
                                <tr><td width="20%" >&nbsp;Total Traveling Days</td><td>:</td><td width="20%"><?php echo $row_orders['tr_days']; ?></td>			<td width="20%">&nbsp;Vehicle Infomation</td><td>:</td>
                                <td width="20%"><?php
								if($row_orders['tr_vehname'] == '')
								{
									$vah=explode(',',$row_orders['tr_vehids']);
									for($r=0;$r<count($vah);$r++)
									{
										if(trim($vah[$r]) != '')
										{
									  		
											$vpro = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id =?");
											$vpro->execute(array($vah[$r]));
											$row_vpro =$vpro->fetch(PDO::FETCH_ASSOC);
											$totalRows_vpro = $vpro->rowCount();
											if(isset($vah[$r+1]) && $vah[$r+1] != '')
											{
												 echo $row_vpro['vehicle_type'].",&nbsp;";
											}else
											{
												echo "&nbsp;".$row_vpro['vehicle_type'];
											}
										}
									}
								}
								else
								{
									$veh_arrs=explode(',',$row_orders['tr_vehname']);
									for($v=0;$v<count($veh_arrs);$v++)
									{
										echo $veh_arrs[$v];
											if(isset($veh_arrs[$v+1]))
											{
												echo "<br>";
											}
									} 
								}
								  ?></td></tr>
                                  <tr>
                                  <td> Travel Distance</td><td>:</td><td><?php echo $row_orders['tot_tr_dist']." Kms"; ?></td>
                                  <td> This Itinerary Charges</td><td>:</td><td><a href="javascript:void(0)" style="text-decoration:blink" class="flashit"><?php echo $row_orders['agnt_grand_tot']."/- Rupees"; ?></a></td></tr>
                                </table>
                                </center>-->
                                    <?php if($str =='H' || $str =='TH'){?>
                                    <div class="table-responsive" style="margin-left:30px; margin-right:30px;">
                                    <br />
                                    <p style="color:#F00; text-align:center"><u>Hotel List</u></p>
                                    <br />
                                    <?php 

$spro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$spro->execute(array($_GET['planid']));
//$row_spro = mysql_fetch_assoc($spro);
$row_spro_main=$spro->fetchAll();
$totalRows_spro = $spro->rowCount();
$scnt=1;	
									?>
                                    <!-- table table-th-block table-striped -->
                                    <table class="" width='100%' border="1">
                                    <tr><th>S.No</th><th>Date</th><th>Place</th><th>Hotel</th><th>Room Category</th><th>Meal Plan</th><!--<th>T Nights</th>--></tr>
                                    <?php foreach($row_spro_main as $row_spro){ ?>
                                    <tr><td><?php echo $scnt; ?></td><td><?php
									
$spro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=? ORDER BY sno ASC ");
$spro1->execute(array($_GET['planid'],$row_spro['hotel_id']));
$row_spro1 = $spro1->fetch(PDO::FETCH_ASSOC);
$totalRows_spro1 = $spro1->rowCount();
						
						$org_date= date('d-M-Y',strtotime(substr($row_spro['sty_date'],'0','10')));
echo $org_date;	
					 ?></td>
                                    <td><?php
									

$cityy = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$cityy->execute(array($row_spro['sty_city']));
$row_cityy = $cityy->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy = $cityy->rowCount();
									
									 echo  $row_cityy['name'];?></td>
                                     <td>
                                     <?php 
									  
$hotell = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotell->execute(array($row_spro['hotel_id']));
$row_hotell = $hotell->fetch(PDO::FETCH_ASSOC);
$totalRows_hotell = $hotell->rowCount();
echo $row_hotell['hotel_name'];

if($row_hotell['category']=="HOUSEBOAT" || $row_hotell['category']=="HOUSE BOAT" || $row_hotell['category']=="houseboat")
{
	$house_boat_avail++;
}
									 ?>
                                     </td>
                                     <td>
                                     <?php 
									$rrom=explode(',',$row_spro['sty_room_name']);
									$rrom1=array_unique($rrom);
									//print_r($rrom1);
									$rrom1=array_values($rrom1);
									$rrom2=array_count_values($rrom);
									//print_r($rrom2);
									
									for($tt=0;$tt<count($rrom1);$tt++)
									{
									// 
//$query_hroom = "SELECT * FROM hotel_season where sno = '".$rrom1[$tt]."'";
//$hroom = mysql_query($query_hroom, $divdb) or die(mysql_error());
//$row_hroom = mysql_fetch_assoc($hroom);
//$totalRows_hroom = mysql_num_rows($hroom);
if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='')
{
	echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]].",&nbsp;<br>"; 
}else
{
	echo $rrom1[$tt]." - ".$rrom2[$rrom1[$tt]]; 
}

$find_ex_bed=array();
$exbds_arr=explode(',',$row_spro['sty_child_bed']);
$find_ex_bed=array_count_values($exbds_arr);

$clbrax="1";
foreach ($find_ex_bed as $xkey => $xvalue) {
						if(($xkey == "0" || $xkey == "1") && $clbrax=="1")
						{
							echo " [ incl. ";
							$clbrax++;
						}

						if($xkey=='0')
						{
							echo $xvalue." - Ex.Bed(s) ~";
						}else if($xkey=="1")
						{
							echo $xvalue." - Chld.Bed(s) ";
						}

						if($clbrax>1)
						{
							echo " ]";
						}
}


									}?>
                                     </td><td><?php
									 //food items
									 if($row_spro['sty_food']=='dinner_rate')
									 {
										echo "Dinner"; 
									 }else if($row_spro['sty_food']=='lunch_rate')
									 {
										 echo "Lunch"; 
									 }else if($row_spro['sty_food']=='both_food')
									 {
										 echo "Lunch & Dinner"; 
									 }else{
										echo "Breakfast"; 
									 }
									 
									  ?></td>
                                     <!--<td><center><?php// echo $totalRows_spro1; ?></center></td>-->
                                     </tr>
                                    <?php 
									
									$scnt++; }  ?>
                                    </table>
                                    <p align="left" style="font-size:12px; color:#900"> * Breakfast complimentory throughout your stay</p>
                                  
                                    </div>  <?php } // if only for hotel?>
                                    <div>
                                    <br />
                                     <?php

$sspro = $conn->prepare("SELECT * FROM stay_sched where stay_id =? ORDER BY sno ASC ");
$sspro->execute(array($_GET['planid']));
//$row_sspro = mysql_fetch_assoc($sspro);
$row_sspro_main=$sspro->fetchAll();
$totalRows_sspro = $sspro->rowCount();;
$row_count=$totalRows_sspro;		

//my start


$trv_future = $conn->prepare("SELECT * FROM travel_sched where travel_id =?");
$trv_future->execute(array($_GET['planid']));
//$row_trv_future = mysql_fetch_assoc($trv_future);
$row_trv_future_main=$trv_future->fetchAll();
$area_arr=array();
$gv=0;
$dt_cnt_arr=array();
foreach($row_trv_future_main as $row_trv_future)
{
	$area_arr[$gv]=$row_trv_future['tr_from_cityid'];
	if($row_trv_future['tr_from_cityid']==$row_trv_future['tr_to_cityid']){
		$dt_cnt_arr[]=$gv;
	}
	$gv++;
	
}
$area_cnt = array_count_values($area_arr);
$area_cnt1=$area_cnt;
$copy_area_arr=$area_cnt;

$rem_area_cnt=array();
foreach($area_cnt1 as $key => $ac1)
{
	$rem_area_cnt[$key]=0;
}
$totaltrv_future = $trv_future->rowCount();

//daytrip here

 $dtrip = $conn->prepare("SELECT * FROM travel_daytrip where travel_id =? ORDER BY sno ASC");
$dtrip->execute(array($_GET['planid']));
$row_dtrip_main =$dtrip->fetchAll();
$totalRows_dtrip = $dtrip->rowCount();

$dt_arr = array(); $dt_cnt = 0;
if($totalRows_dtrip > 0)
{
	foreach($row_dtrip_main as $row_dtrip)
	{
		
		$dtcity1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
		$dtcity1->execute(array($row_dtrip['orig_cid']));
		$row_dtcity1 = $dtcity1->fetch(PDO::FETCH_ASSOC);
		$totalRows_dtcity1 = $dtcity1->rowCount();
		
		
		$dtcity2 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
		$dtcity2->execute(array($row_dtrip['to_cid']));
		$row_dtcity2 = $dtcity2->fetch(PDO::FETCH_ASSOC);
		$totalRows_dtcity2 = $dtcity2->rowCount();
		
		$dt_arr[$row_dtcity1['name']][] = $row_dtcity2['name'];
		$dt_arr[$row_dtcity1['name']]['id'] = $row_dtcity2['id'];
	}
	
}
//daytrip end

//my end
			
					            

$trv = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trv->execute(array($_GET['planid']));
//$row_trv = mysql_fetch_assoc($trv);
$row_trv_main =$trv->fetchAll();
$totalRows_trv = $trv->rowCount();
$chn=0; 
								if($totalRows_trv>0){	?>
                                    <span style="color:#005598; font-size:18px; text-align:center"><center><u>Tour Itinerary Plan (Program schedule)</u></center></span><span><center>Specially prepare for <?php echo $row_orders['tr_name'];?></center></span>
                                    <br />
                                    <?php  }  $i=0; ?>
                                    <div class="col-sm-12">
                                     <?php foreach($row_trv_main as $row_trv)
									 {
										
										
										if($row_count>0)
										{//for stay table - aft end day calculation
										$row_sspro = $row_sspro_main[$i];
										?>
                                    <div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                   
                                    <span style="color:#005598; font-weight:600;">
                                    <?php
									if($row_trv['tr_date'] == $row_sspro['sty_date'])
									{
										echo date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
									}
									?>
                                    </span>
                                    </div>
                                    <div class="col-sm-10" style="margin-top:15px; border-top:solid #DADADA 1px; text-align:justify">
                                          <?php
									
$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where name LIKE ?");
$cityy1->execute(array($row_trv['tr_from_cityid']));
$row_cityy1 = $cityy1->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy1 = $cityy1->rowCount();

									
$cityy_to = $conn->prepare("SELECT * FROM dvi_cities where name LIKE ?");
$cityy_to->execute(array($row_trv['tr_to_cityid']));
$row_cityy_to = $cityy_to->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy_to = $cityy_to->rowCount();


$hot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? ORDER BY spot_prior ASC");
$hot->execute(array($row_cityy1['id']));
//$row_hot = mysql_fetch_assoc($hot);
$row_hot_main=$hot->fetchAll();
$totalRows_hot = $hot->rowCount();
									
//calculate distance
	
$distanc = $conn->prepare("SELECT * FROM dvi_citydist where (from_cityid =? and to_cityid =?) or (from_cityid =? and to_cityid =?)");
$distanc->execute(array($row_cityy1['id'],$row_cityy_to['id'],$row_cityy_to['id'],$row_cityy1['id']));
$row_distanc= $distanc->fetch(PDO::FETCH_ASSOC);
$totalRows_distanc = $distanc->rowCount();									
									?>
                                    
                                    <span style="color:#005598;  font-size:14px; font-weight:600"> <?php if($chn=='0'){?>Arrival - <?php }?> <?php echo $row_trv['tr_from_cityid'];if($chn=='0'){echo " [ ".$row_orders['tr_arrdet']." @".$row_orders['tr_arr_time']." ]";}
									
									//via edit start
									if(trim($row_trv['via_cities'])!='')
									{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
$via_cty = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$via_cty->execute(array($via_cities_arr[$ci]));
$row_via_cty= $via_cty->fetch(PDO::FETCH_ASSOC);
$totalRows_via_cty = $via_cty->rowCount();	
												echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
											}
										}
									}
									}
									//via edit end
									echo "-&nbsp;&nbsp;".$row_trv['tr_to_cityid'];
									if($row_trv['tr_dist_ss']>0)
									{
										if(isset($dt_arr[$row_trv['tr_from_cityid']][0]) && $chn!=0 && in_array($chn,$dt_cnt_arr)){
											 $distanc = $conn->prepare("SELECT * FROM dvi_citydist where (from_cityid =? and to_cityid =?) or (from_cityid =? and to_cityid =?)");
$distanc->execute(array($row_cityy1['id'],$dt_arr[$row_trv['tr_from_cityid']]['id'],$dt_arr[$row_trv['tr_from_cityid']]['id'],$row_cityy1['id']));
$row_distanc= $distanc->fetch(PDO::FETCH_ASSOC);					
$totalRows_distanc = $distanc->rowCount();	
 $daytravel_dist=$row_distanc['dist']*2;
echo " (".$daytravel_dist." Kms)";
									 
								 
									 }
									 else{
									echo " (".$row_trv['tr_dist_ss']." Kms)";
									$today_dist=$row_trv['tr_dist_ss'];
									}
									}else{
$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist=$ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();		
									//echo " (".$row_ss_dist['ss_dist']." Kms)";
									$today_dist=$row_trv['ss_dist'];
									echo "";
									}?></span><br /><span><?php //echo $totalRows_hot; 
//hotel chng new place
$hotel2 = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotel2->execute(array($row_sspro['hotel_id']));
$row_hotel2 = $hotel2->fetch(PDO::FETCH_ASSOC);
$totalRows_hotel2 = $hotel2->rowCount();								
									
									//echo $chn;
									if($chn=='0'){
										//new change
										$next_stay=$row_trv['sno']+1;

$trv_new = $conn->prepare("SELECT * FROM travel_sched where sno=? and travel_id =? ORDER BY sno ASC");
$trv_new->execute(array($next_stay,$_GET['planid']));
$row_trv_new = $trv_new->fetch(PDO::FETCH_ASSOC);
$totalRows_trv_new = $trv_new->rowCount();

//hotel change from this place - query

if($totalRows_trv_new>0)
{
	$arr_date_time=$row_orders['tr_arr_date'].' '.$row_orders['tr_arr_time'];//$row_orders['tr_arr_time']
	$arr_date_tstmp=date('U',strtotime($arr_date_time));
	
	$arr_timenxday=date('Y-m-d', strtotime($row_orders['tr_arr_date']. ' +1 day'));
	$arr_timenx6am=date('U',strtotime($arr_timenxday.' 06:00 AM'));//for next day morning - arrival
	
	$time6am=date('U',strtotime($row_orders['tr_arr_date'].' 06:00 AM'));
	$time3pm=date('U',strtotime($row_orders['tr_arr_date'].' 03:00 PM'));
	$time6pm=date('U',strtotime($row_orders['tr_arr_date'].' 06:00 PM'));
	
				if($row_trv['tr_from_cityid']==$row_trv['tr_to_cityid'])
				{//next day also same city means
						if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in same city)
					
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel. Check in ( 12:00 noon - standard time) at hotel, refresh and later proceed to sight-seeing including - ";
						$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].' ,';
										}
										
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										
										//via edit start
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														echo $row_via_hspots['spot_name'];
													}
												}
											}
										}
									}
										}
									//via edit end
							
							echo " and later return to ".$row_hotel2['hotel_name']." and overnight stay at hotel.";
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to hotel, check-in and overnight at ".$row_hotel2['hotel_name'];//have to show sight-seeing in next day
							$show_in_next_day=2;
								$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in same city)
							echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to hotel, check-in and overnight stay at ".$row_hotel2['hotel_name']." hotel.";//have to show sight-seeing in next day
							$show_in_next_day=2;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-2;
						}
						// daytrip not applicable for arrival
						
				}else{//next day having different city means
					if($time6am <= $arr_date_tstmp && $arr_date_tstmp <= $time3pm)
						{//between 6am to 3pm ( over night in diff city)
					echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].", proceed to sight-seeing including - ";
						$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].' ,';
										}
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										
										//via edit start
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														echo $row_via_hspots['spot_name'];
													}
												}
											}
										}
									}
										}
									//via edit end
									
									//for first day - in diff city within 180km means show hotspots if the arrival time inbetween 11 clock
									
								$time11am=date('U',strtotime($row_orders['tr_arr_date'].' 11:00 AM'));	
								if($time11am >= $arr_date_tstmp)//within 11:00AM arrival means
								{
							if(($row_trv['tr_from_cityid'] != $row_trv['tr_to_cityid']) && $row_distanc['dist']<=180)
							{
								
$hot1= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =?");
$hot1->execute(array($row_cityy_to['id']));
//$row_hot1 = mysql_fetch_assoc($hot1);
$row_hot1_main=$hot1->fetchAll();
$totalRows_hot1 = $hot1->rowCount();
								$hots_array=array();
								$vg=0;
								foreach($row_hot1_main as $row_hot1){
										   $hots_array[$vg]=$row_hot1['spot_name'];
										   $vg++;
										} 
								
								$area_cnt[$row_trv['tr_to_cityid']]=$area_cnt[$row_trv['tr_to_cityid']]+1;
								$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]+1;
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_to_cityid']]);	
										
				for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
										{
											echo $hots_array[$hs1].', ';
										}
										$rem_area_cnt[$row_trv['tr_to_cityid']]=$rem_area_cnt[$row_trv['tr_to_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]-1;
							}
								}//within 11:00AM arrival means if- end
									
								
							echo "and later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at ".$row_hotel2['hotel_name']." hotel.";
	
						}else if($time3pm <= $arr_date_tstmp && $arr_date_tstmp <= $time6pm)
						{//between 3pm to 6pm ( over night in diff city)
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid'].". ";
						
						if($totalRows_hot>0){ 
						echo "If time permits proceed to sight-seeing including - ";
						
						$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											echo $hots_array[$hs].' ,';
										}
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
										
										//via edit start
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														echo $row_via_hspots['spot_name'];
													}
												}
											}
										}
									}
										}
									//via edit end
						
						echo "and ";
						}//more hot spot
						echo " later drive to ".$row_trv['tr_to_cityid'].", check-in and overnight stay at ".$row_hotel2['hotel_name']." hotel.";
							
						}else if($time6pm <= $arr_date_tstmp && $arr_date_tstmp <= $arr_timenx6am)
						{//between 6am to 3pm ( over night in diff city)
						echo "Greet and meet on arrival at ".$row_trv['tr_from_cityid']." and proceed to ".$row_trv['tr_to_cityid'].", arrival and check-in and Overnight stay at ".$row_hotel2['hotel_name']." hotel.";//skip sight-seeing and proceed to next day if
						
						//have to skip
						$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);
										//skip hot spot
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
						}
				}
}//if end -$totalRows_trv_new count 

									}//for first day
									else // for other days
									{
										if(!empty($dt_arr) && $chn != 0 && in_array($chn,$dt_cnt_arr) && isset($dt_arr[$row_trv['tr_from_cityid']][0]))
								 {
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
										



			echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]." (".$daytravel_dist." kms) : </span>";


$dayhpot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? and status='0'");
$dayhpot->execute(array($dt_arr[$row_trv['tr_from_cityid']]['id']));
//$row_dayhpot = mysql_fetch_assoc($dayhpot);
$row_dayhpot_main=$dayhpot->fetchAll();
$totalRows_dayhpot = $dayhpot->rowCount();

foreach($row_dayhpot_main as $row_dayhpot)
{
		echo  " - <strong>".$row_dayhpot['spot_name']."</strong>";
}
										 unset($dt_arr[$row_trv['tr_from_cityid']][0]);
										 $dt_arr[$row_trv['tr_from_cityid']] = array_values($dt_arr[$row_trv['tr_from_cityid']]);
									 }
									 
								 }else{
										if($row_trv['tr_from_cityid'] == $row_trv['tr_to_cityid'])
										{
											echo "After breakfast ";
										}else{//different ending city means show the ending city hotspot
											echo "After breakfast check out hotel and";
										}
									 
									
									if($totalRows_hot>0){ 
									echo " proceed to sight-seeing including- ";
									$hots_array=array();
									$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										
										
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{
											$show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
										}else{
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
										}
										
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<$tot_div_hot+$rem_area_cnt[$row_trv['tr_from_cityid']];$hs++)
										{
											if(isset($hots_array[$hs]))
											{
											echo $hots_array[$hs].' ,';
											}
										}
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
							
							//via edit start
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														echo $row_via_hspots['spot_name'];
													}
												}
											}
										}
									}
										}
									//via edit end
							
							//for ending city hotspot if ending in different city
							if(($row_trv['tr_from_cityid'] != $row_trv['tr_to_cityid']) && $row_distanc['dist']<=180)
							{
								
$hot1= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =?");
$hot1->execute(array($row_cityy_to['id']));
//$row_hot1 = mysql_fetch_assoc($hot1);
$row_hot1_main=$hot1->fetchAll();
$totalRows_hot1 = $hot1->rowCount();
								$hots_array=array();
								$vg=0;
								foreach($row_hot1_main as $row_hot1){
										   $hots_array[$vg]=$row_hot1['spot_name'];
										   $vg++;
										} 
								
								
								$area_cnt[$row_trv['tr_to_cityid']]=$area_cnt[$row_trv['tr_to_cityid']]+1;
								$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]+1;
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{  $show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_to_cityid']]-1));
										}else{
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_to_cityid']]);	
										}
										
				for($hs1=$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1<$tot_div_hot+$rem_area_cnt[$row_trv['tr_to_cityid']];$hs1++)
										{
											echo $hots_array[$hs1].', ';
										}
										$rem_area_cnt[$row_trv['tr_to_cityid']]=$rem_area_cnt[$row_trv['tr_to_cityid']]+$tot_div_hot;
										$copy_area_arr[$row_trv['tr_to_cityid']]=$copy_area_arr[$row_trv['tr_to_cityid']]-1;
							}
							
							//calculation for last day previouslly
							$dept_date_time1=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
	$dept_date_tstmp1=date('U',strtotime($dept_date_time1));
	$dept_time4pm1=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
									
							if(($totalRows_trv ==2 && $dept_date_tstmp1<$dept_time4pm1))
							{
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<count($hots_array);$hs++)
				{
											echo $hots_array[$hs].' ,';//for final day
				}
							}
										} ?></span>
                                      
                                        <?php
							if($row_trv['tr_from_cityid'] == $row_trv['tr_to_cityid'])
							{
								 echo "and later return to hotel. Overnight stay at ".$row_hotel2['hotel_name']." hotel.";
								 // daytrip goes here
								 if(!empty($dt_arr))
								 {
									 if(isset($dt_arr[$row_trv['tr_from_cityid']][0]))
									 {
	 echo "<br><span style='font-weight:bold; color:green'>"."DAYTRIP applicable to ".$dt_arr[$row_trv['tr_from_cityid']][0]."</span>";

	 
$dayhpot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =? and status='0'");
$dayhpot->execute(array($dt_arr[$row_trv['tr_from_cityid']]['id']));
//$row_dayhpot = mysql_fetch_assoc($dayhpot);
$row_dayhpot_main=$dayhpot->fetchAll();
$totalRows_dayhpot = $dayhpot->rowCount();

foreach($row_dayhpot_main as $row_dayhpot)
{
		echo  $row_dayhpot['spot_name'];
}
										 unset($dt_arr[$row_trv['tr_from_cityid']][0]);
										 $dt_arr[$row_trv['tr_from_cityid']] = array_values($dt_arr[$row_trv['tr_from_cityid']]);
									 }
								 }
							}else{
								 echo "and later proceed to ".$row_trv['tr_to_cityid'].". Overnight stay at ".$row_hotel2['hotel_name']." hotel. ";
							}
								 }		?>
                                        <?php }//fot other days else end
										
										//additional cost - addons
										if(trim($row_trv['addi_cost_for'])!='')
										{
											$addi_cost_name=explode('/',$row_trv['addi_cost_for']);
										?>
                                        <div class="col-sm-12" style="color: #7A7FA2; margin-top:10px; border: 1px dashed #5F83DE; padding:5px;" >
                                        <strong style="color:#AB5B14;" >* Special Add-ons to this date: </strong>
                                        <small style="color:#900; font-weight:600">( Additional cost added for this add-ons )</small>
                                        <ul style=" list-style-type:circle; ">
                                        <?php foreach($addi_cost_name as $acnam)
										{ ?>
                                        <li style="font-weight:500"><?php echo $acnam; ?></li>
                                        <?php }?>
                                        </ul>
                                        </div>
                                        <?php } 
										?>
                                    </div>
                                  
                                     <?php
									
									 $chn++;
										}//inner hotel while end
										else{?>
									<div class="col-sm-2" style="margin-top:15px; border-top:solid #DADADA 1px">
                                    <span style="color:#005598; font-weight:600;">
                                    <?php
									if($row_trv['tr_date'] != '')
									{
										echo date('d-M-Y D',strtotime(str_replace('-','/',$row_trv['tr_date'])));
									}
									?>
                                    </span>
                                    </div>
                                    <div class="col-sm-10" style="margin-top:15px; border-top:solid #DADADA 1px; text-align:justify">
                                          <?php
									
$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where name LIKE ?");
$cityy1->execute(array($row_trv['tr_from_cityid']));
$row_cityy1 = $cityy1->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy1 = $cityy1->rowCount();


								
$cityy_to = $conn->prepare("SELECT * FROM dvi_cities where name LIKE ?");
$cityy_to->execute(array($row_trv['tr_to_cityid']));
$row_cityy_to = $cityy_to->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy_to = $cityy_to->rowCount();

			
//calculate distance
	
$distanc = $conn->prepare("SELECT * FROM dvi_citydist where (from_cityid =? and to_cityid =?) or (from_cityid =? and to_cityid =?)");
$distanc->execute(array($row_cityy1['id'],$row_cityy_to['id'],$row_cityy_to['id'],$row_cityy1['id']));
$row_distanc= $distanc->fetch(PDO::FETCH_ASSOC);
$totalRows_distanc = $distanc->rowCount();





$hot= $conn->prepare("SELECT * FROM hotspots_pro where spot_city =?");
$hot->execute(array($row_cityy1['id']));
//$row_hot = mysql_fetch_assoc($hot);
$row_hot_main=$hot->fetchAll();
$totalRows_hot = $hot->rowCount();
									?>
                                    
                                    <span style="color:#005598;  font-size:14px; font-weight:600"> <?php echo $row_trv['tr_from_cityid']."&nbsp;&nbsp;";
									
									//via edit start
									if(trim($row_trv['via_cities'])!='')
									{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
$via_cty = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$via_cty->execute(array($via_cities_arr[$ci]));
$row_via_cty= $via_cty->fetch(PDO::FETCH_ASSOC);
$totalRows_via_cty = $via_cty->rowCount();	
												echo "&nbsp;&nbsp;-&nbsp;&nbsp;".$row_via_cty['name'];
											}
										}
									}
									}
									//via edit end
									echo "-&nbsp;&nbsp;".$row_trv['tr_to_cityid']."&nbsp;( Departure )  [ ".$row_orders['tr_depdet']."&nbsp; @".$row_orders['trv_depatr_time']." ]";
									
									if($row_trv['tr_dist_ss']>0)
									{
									echo " (".$row_trv['tr_dist_ss']." Kms)";
									$today_dist=$row_trv['tr_dist_ss'];
									}else{
$ss_dist = $conn->prepare("SELECT * FROM dvi_cities where id=?");
$ss_dist->execute(array($row_cityy_to['id']));
$row_ss_dist= $ss_dist->fetch(PDO::FETCH_ASSOC);
$totalRows_ss_dist = $ss_dist->rowCount();	
									//echo " (".$row_ss_dist['ss_dist']." Kms)";
									echo "";
									$today_dist=$row_trv['ss_dist'];
									}
									?></span><br />
                                    
                                    <?php echo "After breakfast check out hotel"; 
									//time calculation 
									
	$dept_date_time=$row_trv['tr_date'].' '.$row_orders['trv_depatr_time'];
	$dept_date_tstmp=date('U',strtotime($dept_date_time));
	$dept_time4pm=date('U',strtotime($row_trv['tr_date'].' 04:00 PM'));//for next day morning - arrival
									
									if($dept_date_tstmp>=$dept_time4pm)
									{//departure time is within 4-pm - show hot spots
									echo ", and proceed to sight-seeing including - ";
										$hots_array=array();
										$vg=0;
									foreach($row_hot_main as $row_hot){
										   $hots_array[$vg]=$row_hot['spot_name'];
										   $vg++;
										} 
										
										if(isset($show_in_next_day) && $show_in_next_day==2)
										{
											$show_in_next_day=3;
											$tot_div_hot=floor(count($hots_array)/($area_cnt[$row_trv['tr_from_cityid']]-1));
										}else{
										$tot_div_hot=floor(count($hots_array)/$area_cnt[$row_trv['tr_from_cityid']]);	
										}
										
				for($hs=$rem_area_cnt[$row_trv['tr_from_cityid']];$hs<floor(count($hots_array));$hs++)
										{
											if(isset($hots_array[$hs]))
											{
											echo $hots_array[$hs].' ,';
											}
										}
										$rem_area_cnt[$row_trv['tr_from_cityid']]=$rem_area_cnt[$row_trv['tr_from_cityid']]+$tot_div_hot;
							$copy_area_arr[$row_trv['tr_from_cityid']]=$copy_area_arr[$row_trv['tr_from_cityid']]-1;
							
							
							//via edit start
										if(trim($row_trv['via_cities'])!='')
										{
									$via_cities_arr=explode('-',$row_trv['via_cities']);
									for($ci=0;$ci<count($via_cities_arr);$ci++)
									{
										if($ci != 0 && ($ci != count($via_cities_arr)-1))
										{
											if(trim($via_cities_arr[$ci])!='-')
											{
												if($today_dist>=250)//if total dist >250 means show hotspots prior 1 and 2 only
												{
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2')");
												}else{//if total dist <250 means show hotspots prior 1,2,3 & 4 only
$via_hspots = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and (spot_prior='1' || spot_prior='2' || spot_prior='3' || spot_prior='4')");
												}
$via_hspots->execute(array($via_cities_arr[$ci]));
//$row_via_hspots= mysql_fetch_assoc($via_hspots);
$row_via_hspots_main=$via_hspots->fetchAll();
$totalRows_via_hspots =$via_hspots->rowCount();	

												if($totalRows_via_hspots>0)
												{
													foreach($row_via_hspots_main as $row_via_hspots)
													{
														echo $row_via_hspots['spot_name'];
													}
												}
											}
										}
									}
										}
									//via edit end
										
										echo "finally, we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
										
									}else{
										//departure time is not within 4-pm - dont show hot spots
										echo " and we transfer you to ".$row_trv['tr_to_cityid']." airport/railway station.";
									}
									
									//additional cost - addons
										if(trim($row_trv['addi_cost_for'])!='')
										{
											$addi_cost_name=explode('/',$row_trv['addi_cost_for']);
										?>
                                        <div class="col-sm-12" style="color: #7A7FA2; margin-top:10px; border: 1px dashed #5F83DE; padding:5px;" >
                                        <strong style="color:#AB5B14;" >* Special Add-ons to this date: </strong>
                                        <small style="color:#900; font-weight:600">( Additional cost added for this add-ons )</small>
                                        <ul style=" list-style-type:circle; ">
                                        <?php foreach($addi_cost_name as $acnam)
										{ ?>
                                        <li style="font-weight:500"><?php echo $acnam; ?></li>
                                        <?php }?>
                                        </ul>
                                        </div>
                                        <?php } 
									?>
                                    </div>
										<?php }
										 
										$row_count--;
									$totalRows_trv--;
									$i++;
									//$row_count--;
									 }
									//print_r($rem_area_cnt); ?>
                                    </div>
                                    </div>
							</div><!-- /.row -->
 <?php } //main for loop end?>     
                            
                    <div style="vertical-align: text-middle; border:thin #666 1px;">
							                                     <?php

$mst = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$mst->execute(array($_GET['planid']));
$row_mst = $mst->fetch(PDO::FETCH_ASSOC);
$totalRows_mst = $mst->rowCount();


$trl_scd = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trl_scd->execute(array($_GET['planid']));
$row_trl_scd =$trl_scd->fetch(PDO::FETCH_ASSOC);
//$row_trl_arr = mysql_fetch_array($trl_scd);
$totalRows_trl_scd = $trl_scd->rowCount();

$start_dtour=date("d- M- Y",strtotime($row_trl_scd['tr_date']));
for($ko=0;$ko<$totalRows_trl_scd-1;$ko++)
{
	$row_trl_scd = $trl_scd->fetch(PDO::FETCH_ASSOC);
}
$last_dtour=date("d- M- Y",strtotime($row_trl_scd['tr_date']));


$sy_scd = $conn->prepare("SELECT * FROM stay_sched where stay_id =?");
$sy_scd->execute(array($_GET['planid']));
$row_sy_scd = $sy_scd->fetch(PDO::FETCH_ASSOC);
$totalRows_sy_scd = $sy_scd->rowCount();

?>

                            <div class="row">
											<!-- /.col-sm-6 -->
                                <div class="col-sm-12"  style="margin-top:20px; border-top:1px solid #999; text-align:justify" >
                                <br>
                                	<p style="text-align:center">Package  Includes: </p><br>
                                    Transfers and sightseeing  by  deluxe  tourists vehicle <span style="color:#F00">(Vehicles up hill driving on the hills would be on Non AC) </span> <br>
                                    Toll & Parking <br>
                                    GST <br>
                                    All local sightseeing in the same vehicle, every day after breakfast till sunset. <br><br>
                                    <?php if($house_boat_avail>0){ ?>
                                    <span style="color:#F00">If staying in the House boat </span> <br>
                                    House Boat with all Meals and Ac In the house boat operates from 09 PM to 06 Am only.<br><br>
                                    <?php } ?>
                                    <span style="color:#F00">If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as per the hotel policy. </span> <br><br>
                                    
                                    
                                    <b> Package does not include </b><br>
			                        Any international / Domestic Air Fare if any quoted separately <br>
                                    English speaking guide / escort charges Airport Tax <br>
                                    Extra bed All meals (other than above mentioned ones) <br>
                                    Personal nature expenses such as telephone calls, Laundry, soft / hard drinks, lunch tipping etc., <br>
                                    Camera fee at monuments. <br>
                                    Monument / TEMPLE Entrance Fees / Boat ride<br>
                                    Insurance. <br>
                                    Any Porterage services at Airport / Railway station. <br>
                                    Any other expenses not mentioned in the above cost. <br>
									<span style="color:#F00">24th December gala dinner </span> <br>
									<span style="color:#F00">31st December gala dinner </span> <br><br>
                                   
								   
                                    <b>IMPORTANT: </b> Kindly note that names of hotels mentioned above only indicate that our rates have been based on usage of these hotels and it is not to be construed that accommodation is confirmed at these hotels until and unless we convey such confirmation to you. In the event of any of the above mentioned hotels not becoming available we shall book alternate accommodation at a similar or next best available hotel and shall pass on the difference of rates (supplement/reduction whatever applicable) <br><br>
<hr style="margin-top:10px; margin-bottom:10px;">
									<p style="color:#F00; ">Cancellation policy </p>
                                    CANCELLATION 30% of Package cost, if the cancellation is made 30 days prior to the departure. 50% of package cost, if the cancellation is made between 30-14 days prior to the departure.    |   70% of package cost, if the cancellation is made between 17-7 days prior to the departure.     |     100% of package cost, if the cancellation is made 7 days or less prior to the departure. <br><br>
                                    
                                    <b>General  Policy</b><br>
Child cost depends upon hotels rule which may vary from one hotel to another. The most common rules are as under: <br>
Child up to 5 years is free. Child above 5 years to 12 will be charged as per hotel rule. Child above 12 years will be charged as adult. <br>
If your reservation at hotels includes an extra bed, most hotels provide a folding cot or a mattress on floor as an extra bed. <br>
Check in and check out in most of the hotels at 1200 noon in the cities, In Hill stastions check in 1400 hrs check out 11 hrs. <br>
Early check-in or late check-out is subject to availability and may be chargeable by the hotel. <br>
To request for an early check-in or late check-out, kindly contact the hotel directly or inform us prior. <br>
                                </div>
							</div>
                            </div>
              
                 
                    
<script>
		$(document).ready(function(e) {
			$('.datatable-example').dataTable();
        });
	
</script>