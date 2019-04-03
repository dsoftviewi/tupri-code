<style>
th{
	padding:5px;	
}
table{ 
		cellspacing:10;	
}
</style>

<?php
include("COMMN/smsfunc.php");

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  
if ($_SESSION['grp'] == 'AGENT')
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
	$agent_perc = 0; $agnt_adm_perc = 0;
}

if(isset($_POST['subform']) && $_POST['subform'] == 1)
{
	$book_opt = $_POST['book_opt'];
	
	if ($book_opt == 1)
	{
		$sno = 11;
	}
	elseif ($book_opt == 2)
	{
		$sno = 12;
	}
	elseif ($book_opt == 3)
	{
		$sno = 13;
	}
	$common_id='';
	
	$tr_veh = ''; $tr_vehnm = '';
	$tr_cnt = $_POST['trv_cnt'];
	 $arr_dt = $_POST['arrdate'];
	$arr_tm = $_POST['arrtime'];
	$arr_city = $_POST['st_city'];
	$exp_arrcit = explode('-', $arr_city);
	$trim_cityid = trim($exp_arrcit[0]);
	$vehicles = $_POST['vehicles'];
	$impveh = implode(',',$vehicles);
	$expveh = explode(',',$impveh);
	$pervehamt = $_POST['pervehamt'];
	//$exp_perveh = explode('-',$pervehamt);
	
	$vehcitid = $_POST['vehcitid'];
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
	/*for ($y=0;$y<count($exp_perveh)-1;$y++)
	{
		$perveh_rent.= $exp_perveh[$y].',';
	}*/
	$tr_days = $_POST['trv_days'];
	$tr_nights = $_POST['trv_nights'];
	$adult_cnt = $_POST['trv_adult'];
	$child_cnt = $_POST['trv_child'];
	$room_cnt = $_POST['trv_room'];
	$dest_city = $_POST['dest_id'];
	$trav_dist = $_POST['traveldist'];
	$trav_dist_ess = $_POST['traveldist_ess'];
	$return_dis = $_POST['ret_dist'];
	$net_tr_dist = $trav_dist + $return_dis;
	$tr_tot_amt = $_POST['tr_tot_amt'];
	$ch512=$_POST['child512_no_cnt'];
	$addrate_for=$adult_cnt+$ch512;
	
	if(trim($_POST['check_boxs'])=='1')
	{
		$adult_cnt =$_POST['adult_no_cnt'];
		$child_cnt =$_POST['child_no_cnt'];
		$child512_no_cnt=(int)$_POST['child512_no_cnt'];
		//echo "traval + hotel";
		
		$genid = $conn->prepare("SELECT * FROM setting_ids  where sno =?");
		$genid->execute(array($sno));
		$row_genid = $genid->fetch(PDO::FETCH_ASSOC);
		
		$id=$row_genid['id_name'].$row_genid['id_number'];
		$idin=$row_genid['id_number']+1;
		
		
		//Get Day trip details if applicable
		$dt_totdis = $_POST['dt_dist'];
		
		if($dt_totdis > 0)
		{
			$dt_detls = $_POST['dt_detls'];
			$dt_cid   = $_POST['dt_citid'];
			$dt_trdist_ess   = $_POST['dt_altrdist'];
			$dt_ss_dist   = $_POST['dt_alssdist'];
			$dt_alldist   = $dt_totdis;
			$net_tr_dist+=$dt_totdis;
			
			$trim_dt = rtrim($dt_detls,',');
			$exp_dt = explode(',',$trim_dt);
			
			for($dt=0;$dt<count($exp_dt);$dt++)
			{
				$each_exp_dt = explode('-',$exp_dt[$dt]);
				$dt_totdist = ($each_exp_dt[2] * 2) + $each_exp_dt[3];
				
				$insertSQL2a = $conn->prepare("INSERT INTO travel_daytrip (travel_id, orig_cid, from_cid, to_cid, trav_dist, ss_dist, tot_dist, status) VALUES (?,?,?,?,?,?,?, 0)");
				$insertSQL2a->execute(array($id,$each_exp_dt[0],$each_exp_dt[0],$each_exp_dt[1],$each_exp_dt[2],$each_exp_dt[3],$dt_totdist));
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
		
		
		$allper_amt1 = $_POST['permt_amt'];
		$allper_amt = explode('-',$allper_amt1);
		$itiner_city = $_POST['citydata'];
		$tr_dates = $_POST['start_date'];
		$itiner_city1 = implode(',', $itiner_city);
		$itiner_city2 = explode(',', $itiner_city1);
		//echo count($itiner_city2);
		for ($detl_itn=0;$detl_itn<count($itiner_city2);$detl_itn++)
		{
			$exp_itin_city = explode('-', $itiner_city2[$detl_itn]);
			$ssdist = $exp_itin_city[4] - $exp_itin_city[2];
			$insertSQL2 = $conn->prepare("INSERT INTO travel_sched (travel_id, tr_date, tr_from_cityid, tr_to_cityid, ss_dist,  tr_dist_ss, tr_dist_ess, tr_time, status) VALUES (?,?,?,?,?,?,?,?, 1)");
			$insertSQL2->execute(array($id,$tr_dates[$detl_itn],$exp_itin_city[0],$exp_itin_city[1],$ssdist,$exp_itin_city[4],$exp_itin_city[2],$exp_itin_city[3]));
		}
		
		//for hotel+traval 
		
		$par=$_POST['day_of_stay'];
		$child=$_POST['room_of_num'];
		
		 $cityy1=explode(',',$_POST['kit_cityidd']);
		 
		 $totalday_amtcal=0;
		for($h1=1; $h1<=$par; $h1++)
		{   $perday_amtcal=0;
			
			$ch1=$h1-1;
			$shcity=trim($cityy1[$ch1]);
			
			$indu_rent='';
			$shdate=$_POST['sdat'.$h1];
			
			if(trim($_POST['food_id'.$h1])!='')
			{
			$shfood=$_POST['food_id'.$h1];
			}else{
				$shfood='';
			}
			
			if(isset($_POST['ext_item_id'.$h1][0]) && $_POST['ext_item_id'.$h1][0]!='')
			{
				$sh_extra=implode(',',$_POST['ext_item_id'.$h1]);
			}else
			{
				$sh_extra='';
			}
			
			$shotel=$_POST['hotel_sel_id'.$h1];
	
			$shroom='';
			$indu_room_rent='';
			for($h3=1;$h3<=$child;$h3++)
			{
				if($shroom=='')
				{
					$shroom=$_POST['hot_rm_id'.$h1.'_'.$h3];
				}else{
					$shroom=$shroom.','.$_POST['hot_rm_id'.$h1.'_'.$h3];
				}
				
				if($indu_room_rent=='')
				{
					$indu_room_rent=$_POST['hot_rm_rent'.$h1.'_'.$h3];
				}else{
					$indu_room_rent=$indu_room_rent.','.$_POST['hot_rm_rent'.$h1.'_'.$h3];
				}
				
				$perday_amtcal=$perday_amtcal+$_POST['hot_rm_rent'.$h1.'_'.$h3];
			}
			
			for($h4=1;$h4<=$child;$h4++)
			{
				if($h4 ==1)
				{
					$shadult=$_POST['sel_adlt_nw'.$h4];
				}else
				{
					$shadult=$shadult.','.$_POST['sel_adlt_nw'.$h4];
				}
			}
			
			
			for($h4=1;$h4<=$child;$h4++)
			{
				if($h4 ==1)
				{
					$shchild512=$_POST['sel_nw_512ch'.$h4];
				}else
				{
					$shchild512=$shchild512.','.$_POST['sel_nw_512ch'.$h4];
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
					$shchild=$_POST['sel_nw_b5ch'.$h4];
				}else
				{
					$shchild=$shchild.','.$_POST['sel_nw_b5ch'.$h4];
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
			//echo "<br>ext ".$shextra;
			//echo "['sel_nw_extr']= ".$_POST['sel_nw_extr'.$h4];
			//for child bet rate add to perday rate
			$rate_for_child_bed=0;
			
			for($h4=1;$h4<=$child;$h4++)
			{
				if($_POST['sel_nw_extr'.$h4]=='0')
				{
					$rate_for_child_bed=$rate_for_child_bed+$_POST['withbed_rate'.$h1];
				}else if($_POST['sel_nw_extr'.$h4]=='1')
				{
					$rate_for_child_bed=$rate_for_child_bed+$_POST['withoutbed_rate'.$h1];
				}else if($_POST['sel_nw_extr'.$h4]=='-')
				{
					$rate_for_child_bed=$rate_for_child_bed+0;
				}
				
			}
			$perday_amtcal=$perday_amtcal+$rate_for_child_bed;
			
			$food_person=$_POST['adult_no_cnt']+$_POST['child512_no_cnt'];
			if($_POST['food_id'.$h1]=='lunch_rate')
			{
				$perday_amtcal=$perday_amtcal+$food_person*$_POST['foood_rate'.$h1];
			}else if($_POST['food_id'.$h1]=='dinner_rate')
			{
				$perday_amtcal=$perday_amtcal+$food_person*$_POST['foood_rate'.$h1];
			}else if($_POST['food_id'.$h1]=='both_food')
			{
				$rate_fff=explode(',',$_POST['foood_rate'.$h1]);
				$perday_amtcal=$perday_amtcal+($rate_fff[0]*$food_person);
			}
			
			$rate_spl=explode(',',$_POST['others_rate'.$h1]);
			$perday_amtcal=$perday_amtcal+$rate_spl[0];
			
		/*	$shextra=$_POST['extra_bed'.$h1];
			$indu_rent=$indu_rent.'-'.$_POST['extra_rate'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shextra=$shextra.','.$_POST['extra_bed'.$h1.'_'.$h4];
				$indu_rent=$indu_rent.','.$_POST['extra_rate'.$h1.'_'.$h4];
			}*/
			$indu_rent=$indu_room_rent.'-'.$rate_for_child_bed.','.$_POST['withbed_rate'.$h1].','.$_POST['withoutbed_rate'.$h1].'-'.$_POST['foood_rate'.$h1].'-'.$_POST['others_rate'.$h1];
			
			//total amount calculation
			$totalday_amtcal=$totalday_amtcal+$perday_amtcal;
			
			//$perday_amount=$_POST['perdayid'.$h1];
			 $HotelSQL = $conn->prepare("INSERT INTO stay_sched (stay_id, hotel_id, sty_date, sty_city, sty_room_type, sty_adults, sty_512child, sty_child, sty_child_bed, sty_food, sty_extra, sty_indu_rent, sys_amount, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, '0')");
			 $HotelSQL->execute(array($id,$shotel,$shdate,$shcity,$shroom,$shadult,$shchild512,$shchild,$shextra,$shfood,$sh_extra,$indu_rent,$perday_amtcal));
			
	}//for end
		
		$grant_ttttol=$tr_tot_amt+$totalday_amtcal;
		
		$agnt_grnd_adm = $grant_ttttol + ($grant_ttttol * ($agnt_adm_perc / 100));
		$agnt_grnd_tot = $agnt_grnd_adm + ($agnt_grnd_adm * ($agent_perc / 100));

		$my_name=$_POST['gtitle'].". ".$_POST['guestname'];
		$insertSQL1 = $conn->prepare("INSERT INTO travel_master (plan_id, agent_id, distr_id, tr_name, tr_mobile, tr_arrdet, tr_depdet, pax_cnt, tr_arr_date, tr_arr_time, trv_depatr_time, pax_adults, pax_512child, pax_child, tr_days, tr_nights, arr_cityid, dest_cityid, tr_vehids, tr_vehname, tr_veh_cityid, veh_tot_rent, dt_cid, dt_detls, tot_tr_dist, tot_tr_dist_ess, dt_tot_dist, dt_trdist_ess, dt_ss_dist, tr_return_dist, net_tr_dist, perm_cityid, permit_amt, tr_net_amt, stay_rooms, stay_tot_amt, grand_tot, agent_perc, agnt_grand_tot, agnt_adm_perc, date_of_reg, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NOW(), '4')");
		$insertSQL1->execute(array($id,$agent_id,$distr_id,$my_name,$_POST['mobil'],$_POST['arrdet'],$_POST['depdet'],$tr_cnt,$arr_dt,$arr_tm,$_POST['depart_time'],$adult_cnt,$child512_no_cnt,$child_cnt,$tr_days,$tr_nights,$trim_cityid,$dest_city,$tr_veh,$tr_vehnm,$vehcitid,$pervehamt,$dt_cid,$dt_detls,$trav_dist,$trav_dist_ess,$dt_alldist,$dt_trdist_ess,$dt_ss_dist,$return_dis,$net_tr_dist,$allper_amt[0],$allper_amt[1],$tr_tot_amt,$room_cnt,$totalday_amtcal,$grant_ttttol,$agent_perc,$agnt_grnd_tot,$agnt_adm_perc));
	
		$veh_upl = $_POST['veh_upl'];
		$veh_upl1 = explode('/',$veh_upl);
		
		for($vcnt=0;$vcnt<count($veh_upl1)-1;$vcnt++)
		{
			$veh_upl2 = explode('-',$veh_upl1[$vcnt]);
	
			$insertSQL5 = $conn->prepare("INSERT INTO travel_vehicle (travel_id, vehicle_id, rent_transfer, arr_day, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, 1)");
			$insertSQL5->execute(array($id,$veh_upl2[0],$veh_upl2[1],$veh_upl2[2],$veh_upl2[3],$veh_upl2[4],$veh_upl2[5],$veh_upl2[6],$veh_upl2[7],$veh_upl2[8],$veh_upl2[9],$veh_upl2[10],$veh_upl2[11]));
		}
		
		//Insert All travel vehicles from every city's info
		
		$allveh_detl = $_POST['all_veh_upl'];
		$exp_allveh = explode('~',$allveh_detl);
		
		foreach($exp_allveh as $each_veh_det)
		{
			$exp_each_veh = explode('#', $each_veh_det);
			$each_cityid = $exp_each_veh[0];
			
			$exp_get_veh = explode('/', $exp_each_veh[1]);
			
			for($evcnt=0;$evcnt<count($exp_get_veh)-1;$evcnt++)
			{
				$each_veh_upl = explode('-',$exp_get_veh[$evcnt]);
		
				$insertSQL6 = $conn->prepare("INSERT INTO dvi_trans_rpt (travel_id, city_id, vehicle_id, rent_transfer, arr_day, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?, 1)");
				$insertSQL6->execute(array($id,$each_cityid,$each_veh_upl[0],$each_veh_upl[1],$each_veh_upl[2],$each_veh_upl[3],$each_veh_upl[4],$each_veh_upl[5],$each_veh_upl[6],$each_veh_upl[7],$each_veh_upl[8],$each_veh_upl[9],$each_veh_upl[10],$each_veh_upl[11]));
			}
		}
		
		$upd_id=$conn->prepare("UPDATE setting_ids SET id_number=? where sno =?");
		$upd_id->execute(array($idin,$sno));
			
		$common_id=$id;
			
		//header("Location: agent_manaorder.php?mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=1&id=".$id);
	}//if cond for traval + hotel
	
	//if cond for traval
	if(trim($_POST['check_boxs'])=='2')
	{
		//echo 'Travel Only';
		
		$tgenid = $conn->prepare("SELECT * FROM setting_ids  where sno = '12'");
		$tgenid->execute();
		$row_tgenid = $tgenid->fetch(PDO::FETCH_ASSOC);
	
		$tid=$row_tgenid['id_name'].$row_tgenid['id_number'];
		$tidin=$row_tgenid['id_number']+1;
		
		//Get Day trip details if applicable
		$dt_totdis = $_POST['dt_dist'];
		
		if($dt_totdis > 0)
		{
			$dt_detls = $_POST['dt_detls'];
			$dt_cid   = $_POST['dt_citid'];
			$dt_trdist_ess   = $_POST['dt_altrdist'];
			$dt_ss_dist   = $_POST['dt_alssdist'];
			$dt_alldist   = $dt_totdis;
			$net_tr_dist+=$dt_totdis;
			
			$trim_dt = rtrim($dt_detls,',');
			$exp_dt = explode(',',$trim_dt);
			
			for($dt=0;$dt<count($exp_dt);$dt++)
			{
				$each_exp_dt = explode('-',$exp_dt[$dt]);
				$dt_totdist = ($each_exp_dt[2] * 2) + $each_exp_dt[3];
				
				$insertSQL2a = $conn->prepare("INSERT INTO travel_daytrip (travel_id, orig_cid, from_cid, to_cid, trav_dist, ss_dist, tot_dist, status) VALUES (?,?,?,?,?,?,?, 0)");
				$insertSQL2a->execute(array($tid,$each_exp_dt[0],$each_exp_dt[0],$each_exp_dt[1],$each_exp_dt[2],$each_exp_dt[3],$dt_totdist));
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
		
		$allper_amt1 = $_POST['permt_amt'];
		$allper_amt = explode('-',$allper_amt1);
		
		$agnt_grnd_adm = $tr_tot_amt + ($tr_tot_amt * ($agnt_adm_perc / 100));
		$agnt_grnd_tot = $agnt_grnd_adm + ($agnt_grnd_adm * ($agent_perc / 100));

		$insertSQL1 = $conn->prepare("INSERT INTO travel_master (plan_id, agent_id, distr_id, tr_name, tr_mobile, tr_arrdet, tr_depdet, pax_cnt, tr_arr_date, tr_arr_time, trv_depatr_time, pax_adults, pax_child, tr_days, tr_nights, arr_cityid, dest_cityid, tr_vehids, tr_vehname, tr_veh_cityid, veh_tot_rent, dt_cid, dt_detls, tot_tr_dist, tot_tr_dist_ess, dt_tot_dist, dt_trdist_ess, dt_ss_dist, tr_return_dist, net_tr_dist, perm_cityid, permit_amt, tr_net_amt, stay_rooms, stay_tot_amt, grand_tot, agent_perc, agnt_grand_tot, agnt_adm_perc, date_of_reg, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, 0, ?,?,?,?, NOW(), '4')");
		$insertSQL1->execute(array($tid,$agent_id,$distr_id,$_POST['gtitle'],$_POST['guestname'],$_POST['mobil'],$_POST['arrdet'],$_POST['depdet'],$tr_cnt,$arr_dt,$arr_tm,$_POST['depart_time'],$adult_cnt,$child_cnt,$tr_days,$tr_nights,$trim_cityid,$dest_city,$tr_veh,$tr_vehnm,$vehcitid,$pervehamt,$dt_cid,$dt_detls,$trav_dist,$trav_dist_ess,$dt_alldist,$dt_trdist_ess,$dt_ss_dist,$return_dis,$net_tr_dist,$allper_amt[0],$allper_amt[1],$tr_tot_amt,$room_cnt,$tr_tot_amt,$agent_perc,$agnt_grnd_tot,$agnt_adm_perc));
	
	
		$itiner_city = $_POST['citydata'];
		$tr_dates = $_POST['start_date'];
		$itiner_city1 = implode(',', $itiner_city);
		$itiner_city2 = explode(',', $itiner_city1);
		//echo count($itiner_city2);
		for ($detl_itn=0;$detl_itn<count($itiner_city2);$detl_itn++)
		{
			$exp_itin_city = explode('-', $itiner_city2[$detl_itn]);
			$ssdist = $exp_itin_city[4] - $exp_itin_city[2];
			$insertSQL2 = $conn->prepare("INSERT INTO travel_sched (travel_id, tr_date, tr_from_cityid, tr_to_cityid, ss_dist, tr_dist_ss, tr_dist_ess, tr_time, status) VALUES (?,?,?,?,?,?,?,?, 1)");
			$insertSQL2->execute(array($tid,$tr_dates[$detl_itn],$exp_itin_city[0],$exp_itin_city[1],$ssdist,$exp_itin_city[4],$exp_itin_city[2],$exp_itin_city[3]);
		}
		
		$veh_upl = $_POST['veh_upl'];
		$veh_upl1 = explode('/',$veh_upl);
		
		for($vcnt=0;$vcnt<count($veh_upl1)-1;$vcnt++)
		{
			$veh_upl2 = explode('-',$veh_upl1[$vcnt]);

			$insertSQL5 = $conn->prepare("INSERT INTO travel_vehicle (travel_id, vehicle_id, rent_transfer, arr_day, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, 1)");
			$insertSQL5->execute(array($tid,$veh_upl2[0],$veh_upl2[1],$veh_upl2[2],$veh_upl2[3],$veh_upl2[4],$veh_upl2[5],$veh_upl2[6],$veh_upl2[7],$veh_upl2[8],$veh_upl2[9],$veh_upl2[10],$veh_upl2[11]));
		}
		
		//Insert All travel vehicles from every city's info
		
		$allveh_detl = $_POST['all_veh_upl'];
		$exp_allveh = explode('~',$allveh_detl);
		
		foreach($exp_allveh as $each_veh_det)
		{
			$exp_each_veh = explode('#', $each_veh_det);
			$each_cityid = $exp_each_veh[0];
			
			$exp_get_veh = explode('/', $exp_each_veh[1]);
			
			for($evcnt=0;$evcnt<count($exp_get_veh)-1;$evcnt++)
			{
				$each_veh_upl = explode('-',$exp_get_veh[$evcnt]);
		
				$insertSQL6 = $conn->prepare("INSERT INTO dvi_trans_rpt (travel_id, city_id, vehicle_id, rent_transfer, arr_day, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?, 1)");
				$insertSQL6->execute(array($tid,$each_cityid,$each_veh_upl[0],$each_veh_upl[1],$each_veh_upl[2],$each_veh_upl[3],$each_veh_upl[4],$each_veh_upl[5],$each_veh_upl[6],$each_veh_upl[7],$each_veh_upl[8],$each_veh_upl[9],$each_veh_upl[10],$each_veh_upl[11]));
			}
		}
		
		$tupd_id=$conn->prepare("UPDATE setting_ids set id_number=? where sno = '12'");
		$tupd_id->execute(array($tidin));
		
		$common_id=$tid;
	}
	
	//if cond for hotel
	if(trim($_POST['check_boxs'])=='3')
	{
		//echo "hotel only";
		
		$genid = $conn->prepare("SELECT * FROM setting_ids  where sno = 13");
		$genid->execute();
		$row_genid = $genid->fetch(PDO::FETCH_ASSOC);
	
		$id=$row_genid['id_name'].$row_genid['id_number'];
		$idin=$row_genid['id_number']+1;
	
		$par=$_POST['day_of_stay'];
		$child=$_POST['room_of_num'];
		
		$totl_paxss=$_POST['hcnt_adl']+$_POST['hcnt_chd'];
		//mastrer table insert for hotel only
	

		for($h1=0; $h1<$par; $h1++)
		{
			$indu_rent='';
			$shcity=trim($_POST['sseell'.$h1]);
			$shdate=$_POST['sdate'.$h1];
			
			if(trim($_POST['food_id'.$h1])!='')
			{
			$shfood=$_POST['food_id'.$h1];
			}else{
				$shfood='';
			}
			
			if(isset($_POST['ext_item_id'.$h1][0]) && $_POST['ext_item_id'.$h1][0]!='')
			{
				$sh_extra=implode(',',$_POST['ext_item_id'.$h1]);
			}else
			{
				$sh_extra='';
			}
			
			$shotel=$_POST['hotel_sel_id'.$h1];
			/*for($h2=0;$h2<$child-1;$h2++)
			{
				$shotel=$shotel.','.$_POST['hotel_sel_id'.$h1.'_'.$h2];
			}*/
			
			$shroom=$_POST['hot_rm_id'.$h1];
			$indu_rent=$_POST['hot_rm_rent'.$h1];
			
			for($h3=0;$h3<$child-1;$h3++)
			{
				$shroom=$shroom.','.$_POST['hot_rm_id'.$h1.'_'.$h3];
				$indu_rent=$indu_rent.','.$_POST['hot_rm_rent'.$h1.'_'.$h3];
			}
			
			$shadult=$_POST['adult_sel'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shadult=$shadult.','.$_POST['adult_sel'.$h1.'_'.$h4];
			}
			
			
			$shchild512=$_POST['youth_sel'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shchild512=$shchild512.','.$_POST['youth_sel'.$h1.'_'.$h4];
			}
			
			
			$shchild=$_POST['child_sel'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shchild=$shchild.','.$_POST['child_sel'.$h1.'_'.$h4];
			}
			


			$shextra=$_POST['extra_bed'.$h1];
			$indu_rent=$indu_rent.'-'.$_POST['extra_rate'.$h1];
			for($h4=0;$h4<$child-1;$h4++)
			{
				$shextra=$shextra.','.$_POST['extra_bed'.$h1.'_'.$h4];
				$indu_rent=$indu_rent.','.$_POST['extra_rate'.$h1.'_'.$h4];
			}
			$indu_rent=$indu_rent.'-'.$_POST['foood_rate'.$h1].'-'.$_POST['others_rate'.$h1];
			
			
			$perday_amount=$_POST['perdayid'.$h1];
			$HotelSQL = $conn->prepare("INSERT INTO stay_sched (stay_id, hotel_id, sty_date, sty_city, sty_room_type, sty_adults, sty_512child, sty_child, sty_child_bed, sty_food, sty_extra, sty_indu_rent, sys_amount, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, '0')");
			$HotelSQL->execute(array($id,$shotel,$shdate,$shcity,$shroom,$shadult,$shchild512,$shchild,$shextra,$shfood,$sh_extra,$indu_rent,$perday_amount));
			
		}//for end
		
		$agnt_grnd_tot = $_POST['hotel_only_tot_amt'] + ($_POST['hotel_only_tot_amt'] * ($agent_perc / 100));
		
		$insertSQL1 = $conn->prepare("INSERT INTO travel_master (plan_id, agent_id, distr_id, tr_name, tr_mobile, tr_arrdet, tr_depdet, pax_cnt, tr_arr_date, tr_arr_time, pax_adults, pax_child, tr_days, tr_nights, arr_cityid, dest_cityid, tr_vehids, tr_vehname, tr_veh_cityid, veh_tot_rent, tot_tr_dist, tot_tr_dist_ess, tr_return_dist, net_tr_dist, tr_net_amt, stay_rooms, stay_tot_amt, grand_tot, agent_perc, agnt_grand_tot, agnt_adm_perc, date_of_reg, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, '-', ?, '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', ?,?,?,?,?,?, NOW(), '4')");
		$insertSQL1->execute(array($id,$agent_id,$distr_id,$_POST['gtitle'],$_POST['guestname'],$_POST['mobil'],$_POST['arrdet'],$_POST['depdet'],$totl_paxss,$arr_dt,$arr_tm,$_POST['hcnt_adl'],$_POST['hcnt_chd'],$par,$child,$_POST['hotel_only_tot_amt'],$_POST['hotel_only_tot_amt'],$agent_perc,$agnt_grnd_tot,$agnt_adm_perc));

		$upd_id=$conn->prepare("UPDATE setting_ids set id_number=? where sno = 13");
		$upd_id->execute(array($idin));

		$common_id=$id;
//header("Location: agent_manaorder.php?mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=1&id=".$id);
	}
	
	if($_SESSION['grp']=="AGENT")
	{
		$myy="agent";
	}else if($_SESSION['grp']=="DISTRB")
	{
		$myy="distributor";
	}
	
	//mail config - start
	//mail config - start
		$stringData ="<html><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Untitled Document</title></head><body><table width='90%' border='0' align='center' cellpadding='2' cellspacing='3';>  <tr>   <td colspan='3' style='font-family: Arial, Helvetica, sans-serif;	font-size: 24px;	font-weight: bold;	color: #960;'></td><td width='1%' rowspan='4' align='center' valign='middle'>&nbsp;</td>  </tr>  <tr align='center'>    <td height='4' colspan='4' style='border-bottom: solid #ccc 2px; float:left; width:100%;'> </td></tr><tr><td colspan='4'><table width='100%' border='0' cellpadding='3' cellspacing='4' style='border:1px solid #eeeeee; background-color: #FAFAFA'><tr><td colspan='3'><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;	font-weight: bold;	color: #000000;'><span style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 16px;	font-weight: bold;	color: #000000; padding-left:20px;'>Dear <span style='font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 16px;	font-weight: bold;	color: #FF0000;'>ADMIN</span>,</span></p></td></tr><tr> <td width='7%'></td><td width='83%'><p>New travel/hotel itinerary has been created by your ".$myy.", ".$user_fname." ".$user_lname." <br> Please login and verify details for approving the request. <br> Thank you,</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;	font-size: 14px;color: #000000;'> With Regards,<br/>".$user_fname." ".$user_lname."&nbsp;</p><table style='font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;'></table>&nbsp;</p><p align='left' style='font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px;	font-weight: bold;	color: '#CC6600;'>Please feel free to raise any queries on <a href='mailto:support@dvi.co.in' title='DVI Support' target='_blank'>support@dvi.co.in</a></p></td><td width='10%'>&nbsp;</td></tr><tr><td height='26'>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr><tr><td colspan='4'><span style='font-family: Arial, Helvetica, sans-serif;	font-size: 12px;	font-weight: bold;	color: #000000;'>Copyright &copy; 1999-".$yy." DoView Holidays Pvt. Ltd. All rights reserved.</span></td></tr></table></body></html>";
	
		//$to = $_POST['email_id'];
		$to="vsr@v-i.in";
		//$to="pco@elysiumservices.info";
		$from = $user_fname." ".$user_lname." <".$user_email.">"; 
		$subject="New Itinerary created (".$common_id.") by ".$user_fname; 
		$str=send_mail($to,$from,$subject,$stringData);
	
	if($_SESSION['grp'] == 'AGENT')
	{
		header("Location: agent_manaorder.php?mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=1&id=".urlencode($common_id));
	}
	else if($_SESSION['grp'] == 'DISTRB')
	{
		header("Location: distrb_manaorder.php?mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=1&id=".urlencode($common_id));
	}
}
?>
<style>

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
#loading_side
{
	width: 100%;
	position: absolute;
    left: 250px;
	margin-top:5px;
}
#loading_cityrow
{
	width: 100%;
	position: absolute;
    left: 250px;
	margin-top:5px;
}

</style>
<body onLoad="prelim(<?php if (isset($_GET['val'])) { echo $_GET['val']; } else { echo '0'; }  ?>);">
			<div class="container-fluid">
					<!-- Begin page heading -->
					<h1 class="page-heading">PLAN YOUR TOUR <small>Place order here</small></h1>
					<!-- End page heading -->
				
					<!-- Begin breadcrumb -->
					<ol class="breadcrumb default square rsaquo sm">
						<li><a href="index.html"><i class="fa fa-home"></i></a></li>
						<li><a style="text-decoration:none" href="dashboard.php">Dashboard</a></li>
						<li><a style="text-decoration:none">Order Pro</a></li>
                        <li class="active">Manage Orders</li>
                        
					</ol>
					<!-- End breadcrumb -->
					<form id="ExampleBootstrapValidationForm" name="thplan"  method="post" class="">
                    
					<div class="the-box">
                    <div class="modal fade" id="SuccessModalColor" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog">
											<div class="modal-content modal-no-shadow modal-no-border bg-default">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title">Client info</h4>
											  </div>
                                              <br />
                                              <small class="help-block" id="formerr" style=' display:none;color:#E9573F;'></small>
											  <div class="form-group">
                                              	
                                                <div class="col-sm-3">
                                                    <div class="input-group">
                                                    <span class="input-group-addon default tooltips" title="Enter guest name">@</span>
                                                    <select class="form-control" id="gtitle" name="gtitle" tabindex="2">

														<option value="Mr">Mr.</option>
                                                        <option value="Mrs">Mrs.</option>
														</select>
                                                    </div>
                                                    </div>
                                                
                                                <div class="col-sm-3">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Guest name" name="guestname" id="guestname">
                                                    </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon default tooltips" title="Enter contact number">@</span>
                                                        <input type="text" class="form-control" placeholder="Mobile number" name="mobil" id="mobil">
                                                    </div>
                                                    </div>
                                                </div>
                                                 
                                                 <br /><br />
                                                <!-- Left group danger -->
                                                <div class="form-group">
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon default tooltips" title="Enter arrival flight/train details">@</span>
                                                        <input type="text" class="form-control" placeholder="Arrival flight/train details" name="arrdet" id="arrdet">
                                                    </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon default tooltips" title="Enter departure flight/train details">@</span>
                                                        <input type="text" class="form-control" placeholder="Departure flight/train details" name="depdet" id="depdet">
                                                    </div>
                                                    </div>
                                                </div>
                                                <br />

											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												
                                                <button type="button" class="btn btn-info" id="subplan" onClick="return (validate() && sendappr());" value="SUBMIT FOR APPROVAL">Save</button>
											  </div>
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .success .full -->
										  </div><!-- /.modal-dialog -->
										</div>
                    <input type="hidden" id="check_boxs" name="check_boxs" <?php if (isset($_GET['val']) && $_GET['val'] == '1') { ?> value="1" <?php } elseif (isset($_GET['val']) && $_GET['val'] == '2') { ?> value="2" <?php } elseif (isset($_GET['val']) && $_GET['val'] == '3') { ?> value="3" <?php } ?> />
                             <legend>Enter your trip details</legend>
                        	
                            <div class="form-group">
                                <div class="row">
                                <label class="col-sm-2 control-label">Choose Travel Options1</label>
									<div class="col-sm-6">
                                   				<div class="radio">
												  <label>
													<input type="radio" value="1" id="" class="i-grey-square book_opt" name="book_opt" <?php if (isset($_GET['val']) && $_GET['val'] == '1') { ?> checked="checked" <?php } ?>>
													Transport + Hotel
												  </label>
												</div>
												<div class="radio">
												  <label>
													<input type="radio" value="2" id="" class="i-grey-square book_opt" name="book_opt" <?php if (isset($_GET['val']) && $_GET['val'] == '2') { ?> checked="checked" <?php } ?>>
													Transport
												  </label>
												</div>
												
										</div><!-- /.col-sm-6 -->
                                        <div class="col-sm-3">
                                        <a class="btn btn-sm btn-default pull-right" href="agent_manaorder1.php?mm=23311f54cbcb20fd815e2574e8b07b39&sm=f0e2efabf331f439ad99596cea1accf3">New</a>
                                	</div>
                                </div>
							</div>
                            
                            <div>
                            <div  style="margin:5px; background-color:rgb(247, 251, 255);display:none" id="new_pax_cnt">
                            <div class="row"   style=" margin:20px; ">
                            <div class="col-sm-12" align="center">
                            <div class="col-sm-4"><label class="control-label">Adult(s)</label></div>
                            <div class="col-sm-4"><label class="control-label">Child(ren) [5 -12 age]</label></div>
                            <div class="col-sm-4"><label class="control-label">Young Child(ren) [Below 5 age]</label></div>
                            </div> 
                            <div class="col-sm-12"  align="center" style="margin-top:5px">
                            <div class="col-sm-4"><div id="na"></div>
                            <input type="hidden" value="1" id="adult_no_cnt" name="adult_no_cnt"/>
                            <input type="hidden" value="1" id="adult_no_cal" name="adult_no_cal"/>
                           </div>
                            <div class="col-sm-4"><div id="nc512"></div>
                            <input type="hidden" value="0" id="child512_no_cnt" name="child512_no_cnt"/>
                            <input type="hidden" value="0" id="child512_no_cal" name="child512_no_cal"/></div>
                            <div class="col-sm-4"><div id="nc"></div>
                            <input type="hidden" value="0" id="child_no_cnt" name="child_no_cnt"/> 
                            <input type="hidden" value="0" id="child_no_cal" name="child_no_cal"/>   </div>
                            </div>
                                 
                            </div>
                            <br>
                            </div>
                            
                            <div  style="margin:5px; background-color:rgb(247, 251, 255);display:none" id="trvl_day_cnt">
                            <div class="row"  style="">
                            <div class="col-sm-12" align="center">
                            <div class="col-sm-4" id="lab_tavelpax_cnt" style="display:none"><label class="control-label" style="">Travellers Count</label></div>
                            <div class="col-sm-4"><label class="control-label" style="margin-left:48px">Travel Nights</label></div>
                            <div class="col-sm-4"><label class="control-label">Travel Days</label></div>
                            <div class="col-sm-4" id="lab_rrom_cntt"><label class="control-label" style="margin-left:-40px">Room Count</label></div>
                            </div>
                        	<div class="col-sm-12" align="center" style="margin-top:5px">
                            <div class="col-sm-4" id="div_tavelpax_cnt" style="display:none"><div id="np"></div></div>
                            <div class="col-sm-4"><div id="nd" style="margin-left:48px"></div></div>
                            <div class="col-sm-4"><div id="nn"></div></div>
                            <div class="col-sm-4" id="div_rrom_cntt"><div id="totrooms" style="margin-left:-40px"></div></div>
                        	</div>
                                <br />
		                </div>
                        <br>
                        </div>
                            </div>
                            
                            
                       		<div class="form-group" id="arr_info" style="display:none">
                            	<div class="col-sm-12" align="center" style="margin-top:20px;">
                                <div class="col-sm-4" align="center" ><label class="control-label">Arrival Date &nbsp;&nbsp;</label></div>
                                 <div class="col-sm-4" align="center"><label class="control-label">Arrival Time &nbsp;&nbsp;</label></div>
                                  <div class="col-sm-4" align="center"><label class="control-label">Departure Time &nbsp;&nbsp;</label></div>
                                  </div>
                                  <div class="col-sm-12" align="center" style="margin-top:20px;">
                                  <div class="col-sm-4" align="center"><input type="text" class="form-control datepickerz" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="arrdate" id="arrdate" readonly style="  width: 50%;"></div>
                                        <div class="col-sm-4" align="center">
                                        
                                         <!--<span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>-->
                                        <input type="text" class="form-control timepickera"  name="arrtime" id="arrtime" readonly style="  width: 50%;">
                                           
                                        </div>
                                        <div class="col-sm-4 " align="center">
                                     
                         <!--               <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span> -->
                                        	<input type="text" class="form-control timepickera"  name="depart_time" id="depart_time" readonly style="  width: 50%;">
                                             <br>
                                             <br>
                                        </div>
                                    </div>
                                   
                        			</div>
                           
                           <div id="hotel_cate_only"  class="form-group" style="display:none;" >
                             <?php 
								$cate=$conn->prepare("select DISTINCT category from hotel_pro where status='0'");
								$cate->execute();
								//$row_cate=mysql_fetch_assoc($cate);
								$row_cate=$cate->fetch(PDO::FETCH_ASSOC);
								$tot_cate=$cate->rowCount();
								?>
                           
                           </div>
                                                  
                            <div class="form-group" id="arrive_city" style="display:none; margin-top:20px">
                                <div class="row">
                                    <label class="control-label col-sm-2">Select Arrival City</label>
                                        <div class="col-sm-6">
                                            <div id="loading_side"></div>
                                            <div class="load_cities"></div>
                                        </div>
                                    
                                </div>
                                <br />
                            </div>
                        
                            <div class="form-group" id="sel_vehicl" style="display:none">
                                <div class="row">
                                    <label class="control-label col-sm-2">Select Vehicle</label>
                                    <div class="col-sm-6">
                                        <div id="load_vehicl"></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a data-toggle="tooltip" title="Add 1 more vehicle" class="btn btn-default" id="addrow" style="display:none" onClick="create_elmt();getvehicles1();"><i class="fa fa-plus" style="color:#3EAFDB"></i></a>
                                    </div>
                                </div>
                            </div>
							
                         	<div id="vehlist">
                         	</div>
							<br />
                            
                            <input type="hidden" id="vehdiv" name="vehdiv" value="0" />
                         <div id="hotel_cate"  class="form-group" style="display:none;" >
                             <?php 
								$cate=$conn->prepare("select DISTINCT category from hotel_pro where status='0'");
								$cate->execute();
								//$row_cate=mysql_fetch_assoc($cate);
								$tot_cate=$cate->rowCount();
								?>
                          
                           </div>
                         
             			
                            
                            <div class="form-group" id="stay_detail_id" style="display:none;" >
                            	<div class="row">
                                
                                <div class="col-sm-12">
                                <div class="col-sm-3"><label>Adults</label></div>
                                <div class="col-sm-3"><div id="nadult"></div><input type="hidden" id="hcnt_adl" name="hcnt_adl" /></div>
                                <div class="col-sm-3"><label>Children</label></div>
                                <div class="col-sm-3"><div id="nchild"></div><input type="hidden" id="hcnt_chd" name="hcnt_chd" /></div>
                                </div>
                                <div class="col-sm-12"  style="margin-top:15px;">
                                <div class="col-sm-3"><label>Days of stay</label></div>
                                <div class="col-sm-3"><div id="stayno"></div></div>
                                <div class="col-sm-3"><label>Rooms count</label></div>
                                <div class="col-sm-3"><div id="roomno"></div></div>
                                <input type="hidden" value="" id="nos_rms" />
                                </div>
                            
                        		</div>
							</div>
                            
                            <div class="form-group" id="adult_child_cnt" style="display:none">
                            	
							</div>
                                
							<div class="form-group" id="itiner_plan" style="display:none">
                            	<div class="row">
                                	<div class="col-sm-5">
                                    	<div>
                                        	<a href="javascript:void()" onClick="trans_hotel()" style="text-decoration:none" class="btn btn-info"><strong style="color: #004000;">Plan My Itinerary</strong></a>
                                            
                                        </div>
                                    </div>
                            	</div>
                            </div>

                                <div id="book_det" style="display:none;">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="control-label col-sm-3" id="labdiv0">Enter details for booking: DAY <label id="daycnt"></label></label>
                                            <div class="col-sm-9">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" id="div0">
                                    	<div class="row">
                                        	<label class="control-label col-sm-1">Travel Date &nbsp;&nbsp;</label>
                                    		<div class="col-sm-2">
                                            	<input type="text" class="form-control datepickerk" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="start_date[]" id="start_date00" readonly>

                                            </div>
                                            
                                            <div id="fromto_row0">
                                            	<label class="control-label col-sm-1">From: &nbsp;&nbsp;</label>
                                                 
                                            		<div class="col-sm-2">
                                                    	<input class="form-control bold-border tooltips" type="text" name="start_city[]" id="start_city00" readonly>
                                            		</div>
                                            	<label class="control-label col-sm-1">To: &nbsp;&nbsp;</label>
                                                	<div class="col-sm-3"  id="load_cityrow00" style="">
                                                	</div>
                                               <!----><!-- -->  
                                               
                                            <div class="col-sm-2">
                                            <center><table width="80%">
                                                        <tr><td width="50%" align="center">
                 <a class="add_hots4 btn btn-sm btn-default  " id="atxt0-0"  ><i  class="fa fa-picture-o"></i></a></td>
                   <td width="50%" align="center"><a  id="vvatxt0-0" class="view_video btn btn-sm btn-default" ><i class="fa fa-video-camera"></i></a> </td></tr></table></center>
                                            	
                                              </div><!-- -->
                                          </div>
                                      </div>
                                            <input type='hidden' id='d0' value='0' />
                                            <input type='hidden' id='c0' value='0' />
                                            <input type="hidden" id="callbackid" value="" />
                                            <input type="hidden" id="citarrid" value="" />
                                </div>
                                    <input type="hidden" id="daydiv" name="daydiv" value="0" />
                                   
                                   
                                    <div class="form-group">
                                    	<div class="row">
                                            <div class="col-sm-3">
                                            <a href="javascript:void()" onClick="my_route('m',<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);" style="text-decoration:none" class="btn btn-warning"><strong style="color: #004000;">My planned itinerary</strong></a>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                            <a href="javascript:void()" onClick="my_route('o',<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);" style="text-decoration:none" class="btn btn-info"><strong style="color: #004000;">Optimized itinerary(DVi Suggested)</strong></a>
                                            </div>
                                            
                                            <div class="col-sm-3" id="stay_plan11" style="display:none">
                                                	<a href="javascript:void()" onClick="plan_my_stay('hotelandtravelonly')" style="text-decoration:none" class="btn btn-info"><strong style="color: #004000;">Plan My Stay</strong></a>
                                                   
                                    		</div>
                                            
                                            </div>
                                            </div>
                                            
                                            
                            <input type="hidden" id="kit_kat" value=""  />
                            <input type="hidden" id="kit_cityidd" name="kit_cityidd" value=""  />
                            <input type="hidden" value="0" name="traveldist" id="traveldist" />
                            <input type="hidden" value="0" name="traveldist_ess" id="traveldist_ess" />
                            <input type="hidden" value="0" name="day_traveldist" id="day_traveldist" />
                            <input type="hidden" value="0" name="day_travdist_ess" id="day_travdist_ess" />
                            <input type="hidden" value="0" name="dt_dist" id="dt_dist" />
                            <input type="hidden" value="0" name="dt_alssdist" id="dt_alssdist" />
                            <input type="hidden" value="0" name="dt_altrdist" id="dt_altrdist" />
                            <input type="hidden" value="" name="dt_citid" id="dt_citid" />
                            <input type="hidden" value="" name="dt_detls" id="dt_detls" />
                            <input type="hidden" value="0" name="trv_cnt" id="trv_cnt" />
                            <input type="hidden" value="0" name="trv_days" id="trv_days" />
                            <input type="hidden" value="0" name="trv_nights" id="trv_nights" />
                            <input type="hidden" value="0" name="trv_adult" id="trv_adult" />
                            <input type="hidden" value="0" name="trv_child" id="trv_child" />
                            <input type="hidden" value="0" name="trv_room" id="trv_room" />
                            <input type="hidden" value="" id="vehicles" name="vehicles[]" />
                            <input type="hidden" value="" id="dest_id" name="dest_id" />
                            <input type='hidden' name='ret_dist' id='ret_dist' value=0>
                            <input type='hidden' name='tr_tot_amt' id='tr_tot_amt' value=0>
                            <input type='hidden' name='pervehamt' id='pervehamt' value=0>
                            <input type='hidden' name='vehcitid' id='vehcitid' value=''>
                            <input type='hidden' name='permt_amt' id='permt_amt' value=0>
                            <input type='hidden' name='citydata[]' id='citydata' value=''>
                            <input type='hidden' name='formatdata' id='formatdata' value=''>
                            <input type="hidden" name="veh_upl" id="veh_upl" value=''>
                            <input type="hidden" name="all_veh_upl" id="all_veh_upl" value=''>
                            <input type="hidden" name="cid_arr" id="cid_arr" value=''>
                            <input type="hidden" name="veh_cit_dis" id="veh_cit_dis" value=''>
							<input type="hidden" name="subform" value="1">
                            
                                            </div>
                     
                                <div class="form-group" id="stay_plan" style="display:none">
                                	<div class="row">
                                		<div class="col-sm-12">
                                    		<div>
                                        	<a href="javascript:void()" class="btn btn-info" onClick="plan_my_stay('hotelonly')" style="text-decoration:none"><strong style="color: #004000;">&nbsp;Plan My Stay</strong></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="tableee" style="display:none; background-color:#FFF">
<div align="center">
<p style=" font-weight:600; text-align:center">Room Information</p>
<table width="80%"  id="new_room_table" bgcolor="#999999" style=" border:thin #C96 1px; background-color:rgb(250, 243, 234); margin-top:20px" >
<tr id="new_rm_tr0"><th style="padding:10px" width="10%">Rooms</th><th style="padding:10px" width="10%">Adult</th><th style="padding:10px" width="15%">5 - 12 age child(ren)</th><th style="padding:10px" width="18%">Below 5 age child(ren)</th><th style="padding:10px" width="15%">Extra Bed</th></tr>
<tr id="new_rm_tr1"><td style="padding:10px" id="room_nw_td1">Room 1</td>
<td style="padding:10px" id="adlt_nw_td1"><input type="text" id="sel_adlt_nw1" name="sel_adlt_nw1"  readonly class="form-control tooltips" ></td>
<td style="padding:10px" id="ch512_nw_td1"><input type="text" id="sel_nw_512ch1" name="sel_nw_512ch1"  value="0" readonly class="form-control tooltips" ></td>
<td style="padding:10px" id="chb5_nw_td1"><input type="text" id="sel_nw_b5ch1" name="sel_nw_b5ch1" value="0" readonly class="form-control tooltips" ></td>
<td style="padding:10px" id="extr_nw_td1"><select id="sel_nw_extr1" name="sel_nw_extr1" class="form-control chosen-select"><option value="-" selected>Nil</option><option value="0">With Bed</option><option value="1">Without Bed</option></select></td></tr>
</table>
</div>
<hr>
<p style="color:#CCC; font-weight:600; text-align:center">Hotel Information</p>
<div id="table_collection0"> <!-- parent div -->
<!-- <table style="margin-top:20px" id="stay_tabell0"  class="table table-th-block " width="100%" ><thead align="center" ><th width="100%"><center>Progress Bar</center></th></table>-->
</div>
                                <input type="hidden" value="" id="prv_ch">
                                </div>
                                
                                <div class="the-box rounded" id="gmap_div1"  style="display:none; color:#000;">
                                    <p id="traval_para">
                                    <strong> Dear Mr. <?php echo $user_fname.' '.$user_lname; ?></strong><br /> <br />
    
    <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Greetings !!!!</strong>
    <br /><br />
    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you very much for your all time support. Welcome to the world of difference , please find the below is the quote for your kind perusal. We have tried our level best to quote you the best deals in the market, if you have any queries , we request you to call us or write our reservation team to send you the best deals.<br />
                                    </p>
                                	<br />
                                    <strong>Best possible travel route:</strong>
                                    <br />
                                    <table id="best_route" class="table table-th-block " width="60%" >
                                		<thead><th width="15%">Date</th><th width="20%">From</th><th width="20%">To</th><th width="18%">Kilometres</th><th width="15%">Time</th>
                                        </thead>
                               		</table>
                                    
                    				<div id="directions_panel" ></div>
                                    <div id="dt_panel"></div>
                        			<div id="show_distot" style="display:none"></div>
                                    <div id="show_days" style="display:none"></div>
                                    <div id="netamount" style="display:none"></div>
                       				<div id="show_terms" style="display:none"></div>
                    			</div>
                     
                               <div class="the-box rounded" id="stay"  style="display:none;">
                                <div class="row table-responsive">
                                <div id="show_stay_quote" style=" display:none;">
                                <p id="stay_para">
                                    <strong> Dear Mr. <?php echo $user_fname.' '.$user_lname; ?></strong><br /> <br />
    
    <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Greetings !!!!</strong>
    <br /><br />
    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you very much for your all time support. Welcome to the world of difference , please find the below is the quote for your kind perusal. We have tried our level best to quote you the best deals in the market, if you have any queries , we request you to call us or write our reservation team to send you the best deals.<br />
                                    </p>
                                <strong>Hotel(s) selected for itinerary</strong>
                                <table id="stay_quote_table" class="table table-th-block " width="100%" >
                                <thead id="base_id0"><th width="15%" style="color:indianred">Date</th><th width="20%" style="color:indianred">Hotel Detail</th><th width="20%" style="color:indianred">Room Detail</th><th width="18%" style="color:indianred">Food Details</th><th width="15%" style="color:indianred">Others</th></thead>
                                </table>
                                <div id="show_terms1" ></div>
                                <input type="hidden" id="hotel_only_tot_amt" name="hotel_only_tot_amt" />
                                </div>
	                                    </div>
                                
                                <input type="hidden" value="" id="day_of_stay" name="day_of_stay"  />
                                <input type="hidden" value="" id="room_of_num" name="room_of_num"  />
                                <input type="hidden" id="tab_cnt" value="1" />
                                <input type="hidden" id="htl_id0" value="" />

	                                </div>
                                    <div class="the-box" id="sun" style="background-color:#EFF2F5; display:none;" >
                                <br />
                                <center>
                                <button type="button" id="vali_quote" class="btn btn-info" name="vali_quote"  onclick="validate_stay()" value="vali_quote_val" >Validate</button>
                                <?php /*?><button type="button" id="get_sts_quote" class="btn btn-info" name="view_quote"  onclick="view_stay_quote(<?php echo $agent_perc; ?>),show_get_quote(),finalcall(0)" value="view_quote_val" >Get Quote</button><?php */?>
                   				<button type="button" id="get_sts_quote" class="btn btn-info" name="view_quote"  onclick="return quote_dt(<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>)" value="view_quote_val" style="display:none;">Get Quote</button>
                                 <!--<button type="button" id="subplan" class="btn btn-info btn-block" data-toggle="modal" data-target="#SuccessModalColor" style="text-decoration:none; display:none">SUBMIT FOR APPROVAL</button>--
                                <button type="button" style="display:none;" id="get_prev_quote" class="btn btn-sm btn-default" onclick="show_prev_quote()" >Back</button>-->
                                <button type="button" id="trav_quot" class="btn btn-info" name="trav_quot"  onclick="return quote_dt(<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>)" value="view_quote_val" style="display:none;">Get Quote</button>
                                 <button type="button" id="final_save_btn" style="display:none;"  class="btn btn-success" data-toggle="modal" data-target="#SuccessModalColor">Save</button>
                                </center>
                                <br />
                                </div>
                               
                                     <div id="vehrents"></div>
					</div><!-- /.the-box -->
                    
                    </form>
                
                    
                    <div class="the-box" id="gmap_div2" style="display:none;">
	                    <div class="row">
    	                    <div class="col-sm-12" id="diagramm">
        	                    <h4 class="small-title">TRAVEL MAP - ROAD PATH</h4>
                          		<div id="gmap_path2" style="height:1000px">
                               	</div>
                           	</div>
                        </div>
					</div>
             </div>
             
</body>	
<script>
$(document).ready(function(e) {
    $('.chosen-select').chosen({'width':'100%'});
	//$("#sel_dtid"+0).chosen({ max_selected_options: 2 });
});

var ndval;

$(document).ready(function()
{
	$("#np").dpNumberPicker(
	{
		min: 1,
	});
	
	$('#np').find('.dp-numberPicker-add').attr('id','add_np');
	$('#np').find('.dp-numberPicker-sub').attr('id','sub_np');
	$('#np').find('.dp-numberPicker-input').attr('id','input_np');
	
	$("#nd").dpNumberPicker(
	{
		min: 1,
		value:1
	});
	$('#nd').find('.dp-numberPicker-add').attr('id','add_nd');
	$('#nd').find('.dp-numberPicker-sub').attr('id','sub_nd');
	$('#nd').find('.dp-numberPicker-input').attr('id','input_nd');

	$("#nn").dpNumberPicker(
	{
		min: 2,
		value: 2
	});
	
	$('#nn').find('.dp-numberPicker-add').attr('id','add_nn');
	$('#nn').find('.dp-numberPicker-sub').attr('id','sub_nn');
	$('#nn').find('.dp-numberPicker-input').attr('id','input_nn');
	
	//$('#nn').find('.dp-numberPicker-add').attr('id','add_nn').addClass('disabled');
	//$('#nn').find('.dp-numberPicker-sub').attr('id','sub_nn').addClass('disabled');
	//$('#nn').find('.dp-numberPicker-input').attr('id','input_nn');
	
	$("#stayno").dpNumberPicker({ min: 1 });
	
	$("#roomno").dpNumberPicker({ min: 1, value:1 });
	
	$("#totrooms").dpNumberPicker({ min: 1, value:1 });
	
	$("#nadult").dpNumberPicker({ min: 0, value: 1 });
	
	$("#nchild").dpNumberPicker({min: 0, value: 0 });
	
	$("#na").dpNumberPicker({ min: 1, value:1 });
	
	$('#na').find('.dp-numberPicker-add').attr('id','add_na');
	$('#na').find('.dp-numberPicker-sub').attr('id','sub_na');
	$('#na').find('.dp-numberPicker-input').attr('id','input_na');
	
	$("#nc").dpNumberPicker(
	{
		min: 0,
		value:0,
	});
	
	$('#nc').find('.dp-numberPicker-add').attr('id','add_nc');
	$('#nc').find('.dp-numberPicker-sub').attr('id','sub_nc');
	$('#nc').find('.dp-numberPicker-input').attr('id','input_nc');
	
	$("#nc512").dpNumberPicker(
	{
		min: 0,
		value:0,
	});
	
	$('#nc512').find('.dp-numberPicker-add').attr('id','add_nc512');
	$('#nc512').find('.dp-numberPicker-sub').attr('id','sub_nc512');
	$('#nc512').find('.dp-numberPicker-input').attr('id','input_nc512');
	
	
	$('.book_opt').on('ifChecked', function(event){
		//alert($(this).val());
		
		<?php if ($_SESSION['grp'] == 'AGENT')
		{
			$code_nm = 'agent_manaorder';
		}
		else
		{
			$code_nm = 'distrb_manaorder';
		}
			?>
			if($(this).val() == 1)
			{
				window.location.href = '<?php echo $code_nm; ?>.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&val=1';
			}
			else if($(this).val() == 2)
			{
				window.location.href = '<?php echo $code_nm; ?>.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&val=2';
			}
			else if($(this).val() == 3)
			{
				window.location.href = '<?php echo $code_nm; ?>.php?mm=<?php echo $_GET['mm']; ?>&sm=<?php echo $_GET['sm'];?>&val=3';
			}
	});
});

$(document).ready(function(e) {
	var new_cnt=1;
	var room_new_cnt;
	$('#add_na').click(function()
	{
		$("#adult_no_cnt").val(parseInt($("#adult_no_cnt").val())+1);
		$("#adult_no_cal").val($("#adult_no_cnt").val());
		
		new_cnt=$("#np .dp-numberPicker-input").val();
		$("#np .dp-numberPicker-input").val(parseInt(new_cnt)+1);
	
		room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
		$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
		$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
	});
	
	$('#sub_na').click(function()
	{
		
		if(parseInt($("#adult_no_cnt").val())>1)
		{
		$("#adult_no_cnt").val(parseInt($("#adult_no_cnt").val())-1);
		$("#adult_no_cal").val($("#adult_no_cnt").val());
		
		new_cnt=$("#np .dp-numberPicker-input").val();
		$("#np .dp-numberPicker-input").val(parseInt(new_cnt)-1);	
	
		room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
		$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
		$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
		}
	});
	
	
	$('#add_nc').click(function()
	{
		$("#child_no_cnt").val(parseInt($("#child_no_cnt").val())+1);
		$("#child_no_cal").val($("#child_no_cnt").val());
	new_cnt=$("#np .dp-numberPicker-input").val();
	$("#np .dp-numberPicker-input").val(parseInt(new_cnt)+1);
	
	room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
	$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
	$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
	});
	
	$('#sub_nc').click(function()
	{
		if(parseInt($("#child_no_cnt").val())>0)
		{
		$("#child_no_cnt").val(parseInt($("#child_no_cnt").val())-1);
		$("#child_no_cal").val($("#child_no_cnt").val());
		
		new_cnt=$("#np .dp-numberPicker-input").val();
		$("#np .dp-numberPicker-input").val(parseInt(new_cnt)-1);
	
		room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
		$("#totrooms .dp-numberPicker-input").val(room_new_cnt);	
		$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
		}
		
	});
	
    $('#add_nc512').click(function()
	{
	$("#child512_no_cnt").val(parseInt($("#child512_no_cnt").val())+1);
	$("#child512_no_cal").val($("#child512_no_cnt").val());
	
	new_cnt=$("#np .dp-numberPicker-input").val();
	$("#np .dp-numberPicker-input").val(parseInt(new_cnt)+1);
	
	
	room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
	$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
	$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
	});
	
	$('#sub_nc512').click(function()
	{
	if(parseInt($("#child512_no_cnt").val())>0)
		{
		$("#child512_no_cnt").val(parseInt($("#child512_no_cnt").val())-1);
		$("#child512_no_cal").val($("#child512_no_cnt").val());
		
		new_cnt=$("#np .dp-numberPicker-input").val();
		$("#np .dp-numberPicker-input").val(parseInt(new_cnt)-1);
	
		room_new_cnt=Math.ceil(parseInt($("#np .dp-numberPicker-input").val())/4);
		$("#totrooms .dp-numberPicker-input").val(room_new_cnt);
		$("#totrooms").dpNumberPicker({ min: room_new_cnt, value:room_new_cnt });
		}
		
	});
});



function prelim(getv)
{
	if (getv == 1)
	{
		prelim1();
	}
	else if(getv == 2)
	{
		prelim2();
	}
	else if(getv == 3)
	{
		prelim3();
	}
}

function prelim1()
{
	$('#hotel_cate').show();
	$('#hotel_cate_only').hide();
	$('#sun').hide();
	$('#check_boxs').val('1');
	$('#lab_rrom_cntt').show();
	$('#div_rrom_cntt').show();
	$('#lab_tavelpax_cnt').hide();
	$('#div_tavelpax_cnt').hide();
	$('#get_sts_quote').hide();//get cote
	$('#new_pax_cnt').show();
	$('#trvlr_cnt').show();
	$('#arr_info').show();
	$('#arrive_city').show();
	$('#sel_vehicl').show();
	$('#trvl_day_cnt').show();
	$('#trvl_stay_det').show();
	$('#trvl_room_det').show();
	$('#adult_child_cnt').show();
	$('#itiner_plan').show();
	$('#stay_plan').hide();
	$('#stay').hide();
	$('#stay_para').hide();
	$('#tableee').hide();
	$('#vali_quote').show();
	if($('#of_tr0').length>0)
	{
		$('#of_tr0').remove();
	}
	
	if ($('#tab_cnt').val()>1) 
	{
		for(var ttt=0;ttt<=$('#tab_cnt').val();ttt++)
		{
			$('#of_tr0').remove();
			if($('#tr_id'+ttt).length>0)
			{
				if(ttt != 0)
				{
					$('#tr_id'+ttt).remove();
					$('#of_tr'+ttt).remove();
				}
				for(var ccc=0;ccc<$('#nos_rms').val();ccc++)
				{
					$('#tr_id'+ttt+'_'+ccc).remove();
				}
			}
		}
	}
			
	if($('#daydiv').val())
	{
		for(var ii=1; ii<$('#daydiv').val(); ii++)
		{
			$('#div'+ii).hide();
		}
		$('#book_det').hide();
	}
			
			
	$('#stay_detail_id').hide();
	$('#div0').show();
	$('#gmap_div1').hide();
}

function prelim2()
{
	$('#hotel_cate').hide();
	$('#hotel_cate_only').hide();
	//$('#stay_quote_table').hide();
	$('#sun').hide();
	$('#check_boxs').val('2');
	$('#lab_rrom_cntt').hide();
	$('#div_rrom_cntt').hide();
	$('#lab_tavelpax_cnt').show();
	$('#div_tavelpax_cnt').show();
	$('#get_sts_quote').hide();//get quote
	
	$('#new_pax_cnt').hide();
	$('#trvlr_cnt').show();////show()
	$('#arr_info').show();////show()
	$('#arrive_city').show();//show()
	$('#sel_vehicl').show();//show()
	$('#trvl_day_cnt').show();//show()
	$('#trvl_stay_det').hide();//show()
	$('#trvl_room_det').hide();//show()trvl_room_det
	$('#adult_child_cnt').hide();
	$('#itiner_plan').show();//show()
	$('#stay_plan').hide();
	$('#stay_plan11').hide();
	$('#stay').hide();
	$('#stay_detail_id').hide();
	$('#vali_quote').hide();
	
	$('#div0').show();
	$('#tableee').hide();
	if($('#of_tr0').length>0)
	{
		$('#of_tr0').remove();
	}
	if ($('#tab_cnt').val()>1) 
	{
		for(var ttt=0;ttt<=$('#tab_cnt').val();ttt++)
		{
			if($('#tr_id'+ttt).length>0)
			{
				$('#of_tr'+ttt).remove();
				if(ttt != 0)
				{
					$('#tr_id'+ttt).remove();
					$('#of_tr'+ttt).remove();
				}
				for(var ccc=0;ccc<$('#nos_rms').val();ccc++)
				{
					$('#tr_id'+ttt+'_'+ccc).remove();
				}
			}
		}
	}
			
	if($('#daydiv').val())
	{
		for(var ii=1; ii<$('#daydiv').val(); ii++)
		{
			$('#div'+ii).hide();
		}
		$('#book_det').hide();
	}
}

function prelim3()
{
			$('#hotel_cate').hide();
			$('#hotel_cate_only').show();
			$('#sun').hide();
			$('#check_boxs').val('3');
			
		
			$('#stay').hide();
			$('#trvlr_cnt').hide();
			$('#arr_info').show();
			$('#arrive_city').hide();//show()
			$('#sel_vehicl').hide();
			$('#trvl_day_cnt').hide();//show()
			$('#trvl_stay_det').hide();//show()
			$('#trvl_room_det').hide();//show()
			$('#adult_child_cnt').hide();//show()
			$('#stay_plan').show();//show()
			$('#stay_plan11').hide();
			$('#stay_para').show();
			$('#stay_detail_id').show();
			$('#itiner_plan').hide();
			//$('#show_rental').hide();
			$('#gmap_div1').hide();
			$('#gmap_div2').hide();
			$('#div0').hide();
			$('#tableee').hide();

if($('#of_tr0').length>0)
	{
$('#of_tr0').remove();
	}
	if($('#tr_id0_0').length>0)
	{
$('#tr_id0_0').remove();
	}

if ($('#tab_cnt').val()>1) 
{	
	for(var ttt=0;ttt<=$('#tab_cnt').val();ttt++)
	{
		if($('#tr_id'+ttt).length>0)
		{
			if(ttt != 0)
			{
				$('#tr_id'+ttt).remove();
				$('#of_tr'+ttt).remove();
			}
			for(var ccc=0;ccc<$('#nos_rms').val();ccc++)
			{
				$('#tr_id'+ttt+'_'+ccc).remove();
			}
		}
	}
}

$("#stayno").dpNumberPicker({ min: 1,});
if($('#daydiv').val())
{
	for(var ii=1; ii<$('#daydiv').val(); ii++)
	{
		$('#div'+ii).hide();
	}
	$('#book_det').hide();
}
}

function validate_stay()
{
	var csk=0;
	var prv_c=$('#prv_ch').val();
	if(prv_c != '')
	{
	$('#'+prv_c).css('background-color','#FFF');
	}
	var days=parseInt($("#nd .dp-numberPicker-input").val());
	var rooms=parseInt($("#totrooms .dp-numberPicker-input").val());
	
	var ck_ch512=0;
	var ck_chb5=0;
	for(var chy1=1;chy1<=rooms;chy1++)
	{
		ck_ch512=ck_ch512+parseInt($('#sel_nw_512ch'+chy1).val());
		ck_chb5=ck_chb5+parseInt($('#sel_nw_b5ch'+chy1).val());
	}
	
	if(ck_ch512!=$('#child512_no_cnt').val())
	{
		alert('Children 5 to 12 age group - Count value is mismatch,please validate..');
		$('#sel_adlt_nw1').focus();
		csk=1;
		return false;
	}
	
	if(ck_chb5 != $('#child_no_cnt').val())
	{
		alert('Children Below-5 age group - Count value is mismatch,please validate..');
		$('#sel_adlt_nw1').focus();
		csk=1;
		return false;
	}
	
	for(var dd=1;dd<=days;dd++)
	{
		var mybtn=parseInt($('body #vali_quote').offset().top);
		var dates=$('#sdat'+dd).val();
		if($('#hotel_sel_id'+dd).val().trim() =='')
		{
			
			alert('hotel does not choosed in '+dates);
			$('#hotel_nw_td'+dd).css('background-color','#FCC');
			$('#prv_ch').val('hotel_nw_td'+dd);
			csk=1;
			return false;
		}
	}
			for(var dd2=1;dd2<=days;dd2++)
			{
				var dates2=$('#sdat'+dd2).val();
				for(var chy2=1;chy2<=rooms;chy2++)
				{
					if($('#hot_rm_id'+dd2+'_'+chy2).val()=='')
					{
						alert('hotel room does not choosed in '+dates2);
						$('#tdroom_nw_td'+dd2).css('background-color','#FCC');
						$('#prv_ch').val('tdroom_nw_td'+dd2);
						csk=1;
						return false;
					}
				}
			}//parent for end
	
	if(csk==0)
	{
		alert('Hotel Details are validated successfully ..');
		$('#get_sts_quote').show();
		return true;
	}

}

function view_stay_quote(agnt_percnt,adm_brk_per)
{
	$('#show_stay_quote tbody tr').empty();
	$('#stay').show();
	var prt=parseInt($("#nd .dp-numberPicker-input").val());
	var chd=parseInt($("#totrooms .dp-numberPicker-input").val());
	var date;
	var view_elements,room_nmc;
	
	var tot_per_day=0;
	for(var s=1;s<=prt;s++)
	{
		var perday_amt=0;
		view_elements="<tr id='intr_id"+s+"'><td id='indt_id"+s+"'></td><td id='inhotel_id"+s+"'></td><td id='inroom_id"+s+"'></td><td id='foods_id"+s+"'></td><td id='inother_id"+s+"'><input type='hidden' id='perdayid"+s+"' name='perdayid"+s+"'></td></tr>";
		$(view_elements).appendTo('#stay_quote_table');
		
	date=$('#sdat'+s).val();
	label_date='<label>'+date+'</label><br>';
	$('#indt_id'+s).html(label_date);
	
	if($('#check_boxs').val()=='1')
	{
		s1=s-1;
		city_nm=$('#kitcity'+s1).val();
	}
	label_city='<label>In&nbsp;'+city_nm+'</label>';
	$('#indt_id'+s).append(label_city);
	
	hotel_nmp=$('#hotel_sel_id'+s+' option:selected').text();
	label_hotel='<label>'+hotel_nmp+'</label><br><label style="color:darkgray">'+$('#hot_addrs'+s).val()+'</label>';
	$('#inhotel_id'+s).html(label_hotel);

	for(var nw_rms=1;nw_rms<=chd;nw_rms++)
	{
		room_nmp=$('#hot_rm_id'+s+'_'+nw_rms+' option:selected').text();
		room_nmp_rent=+parseInt($('#hot_rm_rent'+s+'_'+nw_rms).val());
		tot_per_day=tot_per_day+room_nmp_rent;
		
		//for extra bed rate calculation
		if($('#sel_nw_extr'+nw_rms).val()=='0')
		{
			tot_per_day=tot_per_day+parseInt($('#withbed_rate'+s).val());
		}else if($('#sel_nw_extr'+nw_rms).val()=='1')
		{
			tot_per_day=tot_per_day+parseInt($('#withoutbed_rate'+s).val());
		}else if($('#sel_nw_extr'+nw_rms).val()=='-')
		{
			tot_per_day=tot_per_day+0;
		}
		
	}
	
	//for food rate calculation
	var food_person=parseInt($('#adult_no_cnt').val())+parseInt($('#child512_no_cnt').val());
	var ratt,oth_ratt;
	if($('#food_id'+s).val()=='lunch_rate')
	{
		tot_per_day=tot_per_day+(food_person*parseInt($('#foood_rate'+s).val()));
	}else if($('#food_id'+s).val()=='dinner_rate')
	{
		tot_per_day=tot_per_day+(food_person*parseInt($('#foood_rate'+s).val()));
	}else if($('#food_id'+s).val()=='both_food')
	{
		 ratt=$('#foood_rate'+s).val().split(',');
		tot_per_day=tot_per_day+(parseInt(food_person)* parseInt(ratt[0]));
	}
	
	oth_ratt=$('#others_rate'+s).val().split(',');
	tot_per_day=tot_per_day+parseInt(oth_ratt[0]);
	
	label_room='<label>'+room_nmp+'&nbsp;Room</label><br>';
	$('#inroom_id'+s).html(label_room);

	food_nmp=$('#food_id'+s+' option:selected').text();
	
	if(food_nmp.trim() != '')
	{
	var arr_frate=$('#foood_rate'+s).val().split(',');
	label_food='<label>&nbsp;'+food_nmp+'</label><br>';
	$('#foods_id'+s).append(label_food);
	}else
	{
		label_food='<label>&nbsp;No Food</label><br>';
	$('#foods_id'+s).append(label_food);
	}
	
	others_nmp=$('#food_id'+s+' option:selected').text();
	
	var values1 = []; 
	$('#ext_item_id'+s+' :selected').each(function(i, selected){ 
		  values1[i] = $(selected).val(); 
		});
	
		if(values1 != '')
		{
		label_other='<label>&nbsp;'+values1+'&nbsp;</label><br>';
		$('#inother_id'+s).append(label_other);
		}else
		{
			label_other='<label>&nbsp;No Special Amenities</label><br>';
		$('#inother_id'+s).append(label_other);
		}
	}
	//total amount
	$('#hotel_only_tot_amt').val(tot_per_day);
	view_elements1="<tr id='toat'><td id='tot_tr' colspan='5'></td></tr>";
	$(view_elements1).appendTo('#stay_quote_table');
	
	var net_tot = document.getElementById('netamount');
	
	net_tot.innerHTML = '';
	var hotel_chrg = $('#hotel_only_tot_amt').val();
	
	var trans_chrg = $("#tr_tot_amt").val();
	if ($('#check_boxs').val() == '2')
	{
		net_tot.innerHTML+= "<strong>Charge for transport: "+trans_chrg + "</strong>" + '<br>';
	}

	var grand_tot = parseInt(tot_per_day)+parseInt(trans_chrg);
	var admn_grt_ttol=parseInt(grand_tot) + ((parseInt(adm_brk_per) / 100) * parseInt(grand_tot));
	var agnt_grand_totl = parseInt(admn_grt_ttol) + ((parseInt(agnt_percnt) / 100) * parseInt(admn_grt_ttol));
	
	var label_totsts='<center><label>Total amount for transport and accomodation = Rs. '+Math.round(agnt_grand_totl)+'/-</label></center><br>';
	$('#tot_tr').append(label_totsts);
	var terms = "<br><strong><font color='red'>Terms & Conditions: </font></strong><br><strong>Package  Includes:</strong><br> Transfers and sightseeing  By  deluxe  tourists vehicle <strong><font color='red'>( Vehicles up hill driving and down hill would be on Non AC)</font></strong><br>Toll & Parking <br>Service Taxes <br>All local sightseeing in the same vehicle, every day after breakfast till sunset ( 0700 AM to 08PM)<br><font color='red'>If staying IN the House boat </font><br> House Boat with all Meals and Ac In the house boat operates from 09 PM to 06 Am only. <br> If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as per the hotel policy.<br><br><strong><font color='red'> Hotel Check in and check out time at Hotel is 1200 Noon </font></strong><br><br> Rate does not include <br> Any international / Domestic Air Fare if any quoted separately <br> English speaking guide / escort charges Airport Tax <br> Extra bed All meals (other than above mentioned ones) <br> Personal nature expenses such as telephone calls, Laundry, soft / hard drinks, lunch tipping etc., <br> Camera fee at monuments. <br> Monument OR TEMPLE Entrance Fees Boat ride <br> Insurance. <br> Any Porterage services at Airport / Railway station. <br> Any other expenses not mentioned in the above cost. <br> Rates are subject to change in case of inflation or tax hikes, rates based on currently applicable taxes <br><br>IMPORTANT: Kindly note that names of hotels mentioned above only indicate that our rates have been based on usage of these hotels and it is not to be construed that accommodation is confirmed at these hotels until and unless we convey such confirmation to you. In the event of any of the above mentioned hotels not becoming available we shall book alternate accommodation at a similar or next best available hotel and shall pass on the difference of rates (supplement/reduction whatever applicable). <br> <font color='red'>Cancellation policy </font><br> CANCELLATION 30% of Package cost, if the cancellation is made 30 days prior to the departure. 50% of package cost, if the cancellation is made between 30-14 days prior to the departure.    |   70% of package cost, if the cancellation is made between 17-7 days prior to the departure.     |     100% of package cost, if the cancellation is made 7 days or less prior to the departure. <br> General  Policy <br> Child cost depends upon hotels rule which may vary from one hotel to another. The most common rules are as under...<br><br> Child up to 5 years is free. Child above 5 years to 12 will be charged as per hotel rule. Child above 12 years will be charged as adult. <br> If your reservation at hotels includes an extra bed, most hotels provide a folding cot or a mattress on floor as an extra bed. <br> Check in and check out in most of the hotels at 1200 noon in the cities, In Hill stastions check in 1400 hrs check out 11 hrs, Early check-in or late check-out is subject to availability and may be chargeable by the hotel. <br> To request for an early check-in or late check-out, kindly contact the hotel directly or inform us prior.";
				
				document.getElementById('show_terms1').innerHTML=terms;
}




function find_hotel_categ(cid,no)
{
	var datt=$('#sdat'+no).val();
	var type=18;
		$.get('AGENT/ajax_agent.php?cid='+cid+'&no='+no+'&type='+type+'&tdate='+datt,function(result){
			//alert(cid+' no '+no+' '+result);
	$('#catag_nw_td'+no).empty().html(result);
		$('.chosen').chosen({'width':'100%'});
	});
}


function show_child_bed(val,pno)
{
if(val != '0')
{
$('#extra_bed'+pno).prop("disabled",false).addClass("chosen-select");
$('.chosen-select').chosen({width:'100%'});
}else
{
$('#extra_id'+pno).empty().html("<input class='form-control' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+pno+"' name='extra_rate"+pno+"'  value='0'/>");}
//alert('cfdfno'+pno);extra_id0
}

function show_child_bed1(val,pno,cno)
{
	//alert('c'+val);
	if(val != '0')
	{
$('#extra_bed'+pno+'_'+cno).prop("disabled",false).addClass("chosen-select");
$('.chosen-select').chosen({width:'100%'});
	}else
	{
		$('#extra_id'+pno+'_'+cno).empty().html("<input class='form-control' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+pno+"_"+cno+"' name='extra_rate"+pno+"_"+cno+"'  value='0'/>");
	}
}



$(document).ready(function(e) {

	$('#add_nd').click(function()
	{
		var daval1=parseInt($('#input_nd').val())+1;
		$('#input_nn').val(daval1);
	});
	
	$('#sub_nd').click(function()
	{
		var daval2=parseInt($('#input_nd').val())+1;
		$('#input_nn').val(daval2);
	});
	
	
	
	$('#add_nn').click(function()
	{
		var daval1=parseInt($('#input_nn').val())-1;
		$('#input_nd').val(daval1);
	});
	
	$('#sub_nn').click(function()
	{
		var daval2=parseInt($('#input_nn').val())-1;
		$('#input_nd').val(daval2);
	});
	
	
	
	
    $('#add_np').click(function()
	{
		$('#total_no_cnt').val($('#input_np').val());
		$("#na").dpNumberPicker({ min: 0, value:$('#input_np').val(), max:$('#input_np').val()}); 
		/*$('#na').find('.dp-numberPicker-add').attr('id','add_na');
		$('#na').find('.dp-numberPicker-sub').attr('id','sub_na');
		$('#na').find('.dp-numberPicker-input').attr('id','input_na');
		$('#adult_no_cnt').val($('#input_np').val());
		$('#add_na').attr('onclick','add_childdd()');
		$('#sub_na').attr('onclick','sub_childdd()');*/
		
		$("#nc512").dpNumberPicker({ min: 0, value:0, max:$('#input_np').val()}); 
		$("#nc").dpNumberPicker({ min: 0, value:0, max:$('#input_np').val()}); 
		$('#nc512').find('.dp-numberPicker-add').attr('id','add_nc512');
		$('#nc512').find('.dp-numberPicker-sub').attr('id','sub_nc512');
		$('#nc512').find('.dp-numberPicker-input').attr('id','input_nc512');
		$('#add_nc512').attr('onclick','add_nc512()');
		$('#sub_nc512').attr('onclick','sub_nc512()');
		$('#child_no_cnt').val(0);
		$('#child512_no_cnt').val(0);
	});
	
	$('#sub_np').click(function()
	{
		$('#total_no_cnt').val($('#input_np').val());
		$("#na").dpNumberPicker({ min: 0, value:$('#input_np').val(),  max:$('#input_np').val()}); 
		$('#na').find('.dp-numberPicker-add').attr('id','add_na');
		$('#na').find('.dp-numberPicker-sub').attr('id','sub_na');
		$('#na').find('.dp-numberPicker-input').attr('id','input_na');
		$('#input_na').val($('#input_np').val());
		$('#add_na').attr('onclick','add_childdd()');
		$('#sub_na').attr('onclick','sub_childdd()');
		
		$("#nc512").dpNumberPicker({ min: 0, max:$('#input_np').val()}); 
		$('#nc512').find('.dp-numberPicker-add').attr('id','add_nc512');
		$('#nc512').find('.dp-numberPicker-sub').attr('id','sub_nc512');
		$('#nc512').find('.dp-numberPicker-input').attr('id','input_nc512');
		
		$('#add_nc512').attr('onclick','add_nc512()');
		$('#sub_nc512').attr('onclick','sub_nc512()');
		$('#adult_no_cnt').val($('#input_np').val());
		$('#child512_no_cnt').val(0);
		$('#child_no_cnt').val(0);
		$('#input_nc512').val(0);
		
		
	});

});

function add_nc512()
{
	$('#child512_no_cnt').val(parseInt($("#nc512 .dp-numberPicker-input").val()));	
}

function sub_nc512()
{ 
	$('#child512_no_cnt').val(parseInt($("#nc512 .dp-numberPicker-input").val()));
}

function set_value(cid,no)
{
	//alert(cid);
	//cid=cid.trim();
	$('#pic_view'+no).attr('href','AGENT/view_img_desc.php?cid='+cid);
	$('#video_view'+no).attr('href','AGENT/view_video_spot.php?cid='+cid);
	$('#htl_id'+no).val(cid);	
}

function remove_this_row(pno,cno)
{
		$('#tr_id'+pno+'_'+cno).hide();
}
function add_new_row(pno,cno)
{
	var next_cno=parseInt(cno)+1;
	var prev_cno=parseInt(cno)-1;

	var new_row="<tr id='tr_id"+pno+"_"+cno+"'><td id='city_td"+pno+"_"+cno+"'></td><td id='categ_td"+pno+"_"+cno+"'></td><td id='hotel_td"+pno+"_"+cno+"'></td><td id='room_td"+pno+"_"+cno+"'><input class='form-control' type='text'  disabled='disabled' /></td><td id='adult_td"+pno+"_"+cno+"'><select id='adult_sel"+pno+"_"+cno+"' onchange='find_no_youth1(this.value,"+pno+","+cno+")' name='adult_sel"+pno+"_"+cno+"' class='form-control chosen-select' data-placeholder='Choose'><option></option><option value='0'>Nil</option><option value='1' >1</option><option value='2' >2</option><option value='3' >3</option></select></td><td id='youth_td"+pno+"_"+cno+"'><input class='form-control' type='text'  disabled='disabled' /></td><td id='child_td"+pno+"_"+cno+"'><input class='form-control' type='text'  disabled='disabled' /></td><td id='extra_id"+pno+"_"+cno+"'><input class='form-control' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+pno+"_"+cno+"' name='extra_rate"+pno+"_"+cno+"' value='0' /></td></tr>";
	

	if($('#tr_id'+pno+"_"+prev_cno).length>0)
	{
		$('#add_btn'+pno).attr('onclick','add_new_row('+pno+','+next_cno+')');
		$(new_row).insertAfter('#tr_id'+pno+'_'+prev_cno);
	}
	else
	{
		$('#add_btn'+pno).attr('onclick','add_new_row('+pno+','+next_cno+')');
		$(new_row).insertAfter('#tr_id'+pno);
	}
	
	var cityyy=$('#htl_id'+pno).val();
}

function find_all_categ(cid,pno)
{
	
	var type=21;
	var datt=$('#sdat'+pno).val();
	$.get('AGENT/ajax_agent.php?cid='+cid+'&pno='+pno+'&type='+type+'&tdate='+datt,function(result){
		//alert(result);
	$('#hotel_nw_td'+pno).empty().html(result);
	$('.chosen').chosen({'width':'100%'});
	});
}

function find_special_amenity(hid,no)
{
	var sdt=$('#sdat'+no).val();
	var type=22;
	$.get('AGENT/ajax_agent.php?hid='+hid+'&pno='+no+'&type='+type+'&daty='+sdt,function(result){
	$('#spl_nw_td'+no).empty().html(result);
	$('.tooltips').tooltip();
	$('.chosen-select').chosen({width:'100%'});
	$('.tooltips').tooltip();
	});
}

function find_food_category(hid,no)
{
	var sdt1=$('#sdat'+no).val();
	var type=23;
	$.get('AGENT/ajax_agent.php?hid='+hid+'&pno='+no+'&type='+type+'&daty='+sdt1,function(result){
	$('#food_nw_td'+no).empty().html(result);
	$('.chosen-select').chosen({width:'100%'});
	});
}

function find_hotel_rooms(hid,no)
{
	
	var type=2;
	var rms=parseInt($("#totrooms .dp-numberPicker-input").val());	
	var datt=$('#sdat'+no).val();
	$.get('AGENT/ajax_agent.php?hid='+hid+'&no='+no+'&type='+type+'&tdate='+datt+'&rooms='+rms,function(result){
		//alert(result);
	$('#tdroom_nw_td'+no).empty().html(result);
	$('.chosen').chosen({'width':'100%'});
	
	find_special_amenity(hid,no);
	find_food_category(hid,no);
	find_rate_cbed(hid,no);
	});
}

function find_stay_hotel1(cid,pno,cno)
{	
	var type=5,cates;
	var datt=$('#sdate'+pno).val();
	
	if($('#check_boxs').val() == '1')
	{
		 cates=$('#hotel_catet_sel').val();
	}else if($('#check_boxs').val() == '3')
	{
		 cates=$('#hotel_catet_sel_only').val();
	}
	
	$.get('AGENT/ajax_agent.php?cid='+cid+'&pno='+pno+'&cno='+cno+'&type='+type+'&cates='+cates+'&tdate='+datt,function(result){
		//alert(result);
	$('#hotel_td'+pno+'_'+cno).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
}

function find_hotel_rooms1(hid,pno,cno)
{
	var type=6;
	$.get('AGENT/ajax_agent.php?hid='+hid+'&pno='+pno+'&cno='+cno+'&type='+type,function(result){
	$('#room_td'+pno+'_'+cno).empty().html(result);
	//$('hotel_sel_id'+pno+'_'+cno).attr('id','sel'+pno+'_'+cno);
	
	 $('.chosen').chosen({'width':'100%'});
	});
}


function find_room_adult1(sno,pno,cno)
{
	//alert('re');	
	var type=7;
	$.get('AGENT/ajax_agent.php?sno='+sno+'&pno='+pno+'&cno='+cno+'&type='+type,function(result){
	$('#adult_td'+pno+'_'+cno).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
	
	var type2=8;
	$.get('AGENT/ajax_agent.php?sno='+sno+'&pno='+pno+'&cno='+cno+'&type='+type2,function(result){
	$('#child_td'+pno+'_'+cno).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
	
}

function find_stay_hotel(categ,cid,no)
{
	$('#food_nw_td'+no).empty().html("<input class='form-control' type='text' value='choose above hotel' disabled='disabled'>");
	$('#spl_nw_td'+no).empty().html("<input class='form-control' type='text' value='choose above hotel' disabled='disabled'>");
	$('#tdroom_nw_td'+no).empty().html("<center><br><br><label>Choose hotel for finding available rooms</label></center>");
	var type=1,cates;
	var datt=$('#sdat'+no).val();
	
	$.get('AGENT/ajax_agent.php?cid='+cid+'&no='+no+'&type='+type+'&cates='+categ+'&tdate='+datt,function(result){
	//alert(result);
	$('#hotel_nw_td'+no).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
}

function find_room_adult(sno,no)
{
	//alert('re');	
	var type=3;
	$.get('AGENT/ajax_agent.php?sno='+sno+'&no='+no+'&type='+type,function(result){
	$('#adult_td'+no).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
	
	var type1=4;
	$.get('AGENT/ajax_agent.php?sno='+sno+'&no='+no+'&type='+type1,function(result){
	$('#child_td'+no).empty().html(result);
	 $('.chosen').chosen({'width':'100%'});
	});
	
}

var hiu;

function find_room_rent1(val,pno,cno)
{
	var datt=$('#sdate'+pno).val();
	var type=10;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type,function(result){
	$('#hot_rm_rent'+pno+'_'+cno).val(result.trim());
	});
}

function find_room_rent(val,no,rmno)
{
	var datt=$('#sdat'+no).val();
	var type=10;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type,function(result){
		//alert(result);
			if(result.trim() != '00')
			{
			$('#hot_rm_rent'+no+'_'+rmno).val(result.trim());
			}else
			{
			alert('Hotel Rooms Unavailable for this season');	
			}
	});
	
	if(rmno==1){
	for(var yo1=2;yo1<=parseInt($("#totrooms .dp-numberPicker-input").val());yo1++)
	{
		$('.chosen').chosen('destroy');
		find_room_rent(val,no,yo1);
		
		hiu=$('#hot_rm_id'+no+'_1 option:selected').val();
		$('#hot_rm_id'+no+'_'+yo1+' option').each(function(i,val)
		{
			if(val.value==hiu)
			{
				$(this).attr('selected',true);
			}
		});
		$('.chosen').chosen({width:'100%'});
	}
	}
}

function find_rate_cbed(val,no)
{
	var datt=$('#sdat'+no).val();
	var ht_id=$('#hotel_sel_id'+no).val();
	var type=11;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id+'&no='+no,function(result){
	$('#tdroom_nw_td'+no).append(result);
	});
}

function find_rate_cbed1(val,pno,cno)
{
	//alert(val+','+pno+','+cno);
	
	var datt=$('#sdate'+pno).val();
	
	//var ht_id=$('#sel'+pno+'_'+cno).val();
	var ht_id=$('#hotel_sel_id'+pno).val();
	//var ht_id=$('#hotel_sel_id'+pno+'_'+cno).val();
	//alert('date'+datt+'  ht_id'+ht_id);
	var type=11;
	$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id,function(result){
	$('#extra_rate'+pno+'_'+cno).val(result.trim());
	});	
}


function find_food_rate(val,no)
{
	
    var datt=$('#sdat'+no).val();
	var nums=parseInt($("#totrooms .dp-numberPicker-input").val());;
	var ht_id=$('#hotel_sel_id'+no).val();
	if((datt.trim() != '')&& (ht_id.trim() != '') && (val.trim() != ''))
		{
		var type=12;
		$.get('AGENT/ajax_agent.php?val='+val+'&date='+datt+'&type='+type+'&hot_id='+ht_id,function(result){
		$('#foood_rate'+no).val(result.trim());
		});	
		}else{
	alert('Please enter hotel and date..');	
	}
}


function find_no_youth1(val,pno,cno)
{
	//alert(val+' / '+pno+' / '+cno);

	var type=15;
	$.get('AGENT/ajax_agent.php?val='+val+'&pno='+pno+'&type='+type+'&cno='+cno,function(result){
	$('#youth_td'+pno+'_'+cno).empty().html(result);
	$('#child_td'+pno+'_'+cno).empty().html('<input class="form-control" type="text" disabled="disabled">');
	$('.chosen').chosen({width:'100%'});
	});
	
	if(pno == 0)
	{
	for(var yout=1;yout<$('#day_of_stay').val();yout++)
			{  
			 $('.chosen-select').chosen('destroy');
				hiu=$('#adult_sel'+pno+'_'+cno+' option:selected').val();
				$('#adult_sel'+yout+'_'+cno+' option').each(function(i,val)
				{
					if(val.value==hiu)
					{
					$(this).attr('selected',true);
					find_no_youth1(hiu,yout,cno);
					$('.chosen-select').chosen({width:'100%'});
					}
				});
				
				$('.chosen-select').chosen({width:'100%'});
				
			}
	}
	
	
}


function change_below5(val,adl_val,no)
{
	var type=16;
	$.get('AGENT/ajax_agent.php?val='+val+'&no='+no+'&type='+type+'&adl_val='+adl_val,function(result){
	$('#child_td'+no).empty().html(result);
	$('.chosen').chosen({width:'100%'});
	});
	
	if(no == 0)
	{
	for(var yut=1;yut<$('#day_of_stay').val();yut++)
			{ 
			 $('.chosen').chosen('destroy');
				hiu=$('#youth_sel'+no+' option:selected').val();
				$('#youth_sel'+yut+' option').each(function(i,val)
				{ 
					if(val.value==hiu)
					{
					$(this).attr('selected',true);
					change_below5(val,adl_val,yut);
					$('.chosen').chosen({width:'100%'});
					}
				});
				
				$('.chosen').chosen({width:'100%'});
				
			}
	}
	
	

}


function change_below51(val,adl_val,pno,cno)
{
	var type=17;
	$.get('AGENT/ajax_agent.php?val='+val+'&adl_val='+adl_val+'&pno='+pno+'&type='+type+'&cno='+cno,function(result){
	$('#child_td'+pno+'_'+cno).empty().html(result);
	$('.chosen').chosen({width:'100%'});
	});
	
	if(pno == 0)
	{
	for(var yut=1;yut<$('#day_of_stay').val();yut++)
			{ 
			 $('.chosen').chosen('destroy');
				hiu=$('#youth_sel'+pno+'_'+cno+' option:selected').val();
				$('#youth_sel'+yut+'_'+cno+' option').each(function(i,val)
				{ 
				
					if(val.value==hiu)
					{
					$(this).attr('selected',true);
					change_below51(val,adl_val,yut,cno);
					$('.chosen').chosen({width:'100%'});
					}
				});
				
				$('.chosen').chosen({width:'100%'});
				
			}
	}
}


function extra_below5(val,no)
{
if($('#hotel_sel_id'+no).length>0) {
	if($('#hotel_sel_id'+no).val() !='')
	{
			if(val!=0)
			{
				var type=24;
				$.get('AGENT/ajax_agent.php?no='+no+'&type='+type,function(result){
					//alert(result)
				$('#extra_id'+no).empty().html(result);
				$('.chosen').chosen({width:'100%'});
			});
			}else{
				$('#extra_id'+no).empty().html("<input class='form-control' id='extra_bed"+no+"' name='extra_bed"+no+"' value='-' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+no+"' name='extra_rate"+no+"'  value='0'/>");
			}
	}else{
		alert("Please choose hotel..")	;
	}
}else{
alert("No hotel available..")	
}
	
	//var tot_dy= parseInt($("#nd .dp-numberPicker-input").val());
	/*if(no==0)
	{
		
	for(var yut=1;yut<$('#day_of_stay').val();yut++)
			{ 
			 $('.chosen').chosen('destroy');
				hiu=$('#child_sel'+no+' option:selected').val();
				$('#child_sel'+yut+' option').each(function(i,val)
				{ 
				
					if(val.value==hiu)
					{
					$(this).attr('selected',true);
					$('.chosen').chosen({width:'100%'});
					//change_below51(val,adl_val,yut,cno);
					if(val==0)
						{
		 $('#extra_bed'+yut).chosen('destroy');
		 $('#extra_bed'+yut).attr('disabled',true);
		 $('#extra_rate'+yut).val('0');
		
						}else{
		$('#extra_bed'+yut).removeAttr('disabled');
		$('#extra_bed'+yut).addClass('form-control chosen');
		$('.chosen').chosen({width:'100%'});
						}
					
					
					}
				});
				
				$('.chosen').chosen({width:'100%'});
				
			}
	
	}*/
	
}


function extra_below51(val,pno,cno)
{
if($('#hotel_sel_id'+pno).length>0) {
	if($('#hotel_sel_id'+pno).val() !='')
	{
			if(val!=0)
			{
				var type=25;
				$.get('AGENT/ajax_agent.php?pno='+pno+'&type='+type+'&cno='+cno,function(result){
					//alert(result)
				$('#extra_id'+pno+'_'+cno).empty().html(result);
				$('.chosen').chosen({width:'100%'});
			});
			}else{
				$('#extra_id'+pno+'_'+cno).empty().html("<input class='form-control' id='extra_bed"+pno+"_"+cno+"' name='extra_bed"+pno+"_"+cno+"' value='-' type='text' disabled='disabled'><input type='hidden' id='extra_rate"+pno+"_"+cno+"' name='extra_rate"+pno+"_"+cno+"'  value='0'/>");
			}
	}else{
		alert("Please choose hotel..")	;
	}
}else{
alert("No hotel available..");	
}
	
}

/*
$(document).ready(function(e) {
    $('.datepickerk').click(function() {
		alert('fdf'+$(this).val());
		/*datepicker({
    	onSelect: function(dateText, inst) {
        var date = $(this).val();
        alert('on select triggered'+date);
    }
	})
	});
});

function active_hotel_fun(pno)
{
	//alert('ff');
	
}*/

function find_others_rate(val,no)
{
//alert(val+'='+no);	
	var values = []; 
	$('#ext_item_id'+no+' :selected').each(function(i, selected){ 
	  values[i] = $(selected).val(); 
	});

	var datt=$('#sdate'+no).val();
	
	var nums=$('#room_of_num').val();
	var ht_id=$('#hotel_sel_id'+no).val();
	/*for(var ui=0;ui<nums-1;ui++)
	{
		ht_id=ht_id+','+$('#sel'+no+'_'+ui).val();
	}*/
	//alert(ht_id+','+values);
	var type=13;
	$.get('AGENT/ajax_agent.php?val='+values+'&date='+datt+'&type='+type+'&hot_id='+ht_id,function(result){
		
		if(result.trim() == '')
		{
			$('#others_rate'+no).val('0');
		}else
		{
		$('#others_rate'+no).val(result.trim());
		}
	});	
}

function show_get_quote()
{
	$('#final_save_btn').show();
	//alert("div"+$('#check_boxs').val());
	//$('#tableee').hide();
	//$('#get_sts_quote').hide();
	if($('#check_boxs').val() !='2')
	{
		$('#show_stay_quote').show();
		if($('#check_boxs').val() =='3')
		{
			$('#gmap_div1').hide();
		}
		if($('#check_boxs').val() =='1')
		{
			$('#stay').css('margin-top','-45px');
			$('#stay').css('border-top-style','hidden');
		}
	}
	else
	{
		$('#gmap_div1').show();	
		$('#stay').hide();
		$('#show_stay_quote').hide();
	}

	
	if($('#check_boxs').val() =='3')
	{
		$('#gmap_div1').hide();
		//alert('hhh'+$('#check_boxs').val());
	}
}


function find_no_chb5(val,no)
{
var adlt_val=$('#sel_adlt_nw'+no).val();
var ch512_val=$('#sel_nw_512ch'+no).val();;
var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());	
		if($('#child_no_cnt').val()>0 && $('#child512_no_cnt').val()>0)// for both the children having 
		{
				if(adlt_val==3 && ch512_val == 1)
				{//no b5
		$('#chb5_nw_td'+no).empty().html("<input type='text' id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' class='form-control tooltips' value='0'>");
				}else if(adlt_val==3 && ch512_val == 0)
				{
					// b5 - 1
			$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
				}
				else if(adlt_val==2 && ch512_val == 2)
				{// no b5
		$('#chb5_nw_td'+no).empty().html("<input type='text' id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' class='form-control tooltips' value='0'>");
				}else if(adlt_val==2 && ch512_val == 1)
				{//  b5 -1
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
					
				}else if(adlt_val==2 && ch512_val == 0)
				{//  b5 -2
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' name='sel_nw_b5ch"+no+"' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});	
				}else if(adlt_val==1 && ch512_val == 3)
				{//  b5 - no
		$('#chb5_nw_td'+no).empty().html("<input type='text' id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' class='form-control tooltips' value='0'>");			
				}else if(adlt_val==1 && ch512_val == 2)
				{//  b5 - 1
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' name='sel_nw_b5ch"+no+"' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
					
				}else if(adlt_val==1 && ch512_val == 1)
				{//  b5 - 2
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});		
				}else if(adlt_val==1 && ch512_val == 0)
				{//  b5 - 3
		$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'> <option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});		
				}
		}else if($('#child_no_cnt')>0)
		{
			alert('for no 5-12 but with b5ch');
		}
		else{// else for no young child ( below 5 not chosen)
			for(var ki=1;ki<=num_new_rooms;ki++)
			{
				$('#sel_nw_b5ch'+ki).removeAttr('data-original-title').attr('data-original-title','No need');
				$('.tooltips').tooltip();
			}
		}
		
}
function find_chbelow5_rem(val,no)
{
	//alert(val+'_'+no);
	
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());
	var chb5_ttoll=$('#child_no_cnt').val();	
		var no_nw=no+1;
		var jcnt=0;
		var cur_val=val;
		//alert("ch512"+$('#child512_no_cal').val());
		//alert($('#sel_adlt_nw'+no_nw).val());
		for(var dis=no_nw;dis<=num_new_rooms;dis++)
		{				
	$('#chb5_nw_td'+dis).empty().html("<input id='sel_nw_b5ch"+dis+"' name='sel_nw_b5ch"+dis+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
		//jcnt=jcnt+parseInt($('#sel_nw_512ch'+dis).val());
		}
		
		for(var prv=1;prv<no_nw;prv++)
		{
		jcnt=jcnt+parseInt($('#sel_nw_b5ch'+prv).val());
		}
		$('#child_no_cal').val(parseInt($('#child_no_cnt').val())-jcnt);
		
		
		//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
		
if(num_new_rooms >= no_nw)
{	
		if($('#sel_adlt_nw'+no_nw).val()==3)
		{
			if($('#sel_nw_512ch'+no_nw).val()==1)
			{ //alert("adl 3 - c512h 1");
				
			$('#chb5_nw_td'+no_nw).empty().html("<input id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
			//no b5	
			}else{
				//alert("adl 3 - c512h 0");
			//1 -b5	
					if($('#child_no_cal').val()>=1)
					{
			$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
						//no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==2)
		{
			if($('#sel_nw_512ch'+no_nw).val()==2)
			{
				//alert("adl 2 - c512h 2");
				if($('#child_no_cal').val()>=1)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<input id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}else{
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}
				//no need for	
				}
				
			//no b5	
			}else if($('#sel_nw_512ch'+no_nw).val()==1)
			{
				//alert("adl 2 - c512h 1");
				if($('#child_no_cal').val()>=1)
				{
					$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else{
					//no need for
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}
				}
				//1-b5
			}else{
				//alert("adl 2 - c512h 0");
					if($('#child_no_cal').val()>=2)
					{
					$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else if($('#child_no_cal').val()>=1)
					{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
						//no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
				//2-b5
			}
		}else if($('#sel_adlt_nw'+no_nw).val()==1)
		{
			if($('#sel_nw_512ch'+no_nw).val()==3)
			{
				//alert("adl 1 - c512h 3");
					if($('#child_no_cal').val()>=1)
					{
				$('#chb5_nw_td'+no_nw).empty().html("<input id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}else{
					//no need for	
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
			//no b5	
			}else if($('#sel_nw_512ch'+no_nw).val()==2)
			{
				//alert("adl 1 - c512h 2");
					if($('#child_no_cal').val()>=1)
					{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
						//no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}
					}
				//1-b5
			}else if($('#sel_nw_512ch'+no_nw).val()==1)
			{
				//alert("adl 1 - c512h 1");
					if($('#child_no_cal').val()>=2)
					{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else if($('#child_no_cal').val()>=1)
					{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
					}else{
					// no need for
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}	
					}
				//2-b5
			}else{
				//alert("adl 1 - c512h 0");
						if($('#child_no_cal').val()>=3)
						{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
$('.chosen-select').chosen({width:'100%'});
						}else if($('#child_no_cal').val()>=2)
						{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
						}else if($('#child_no_cal').val()>=1)
						{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
						}else
						{
						// no need for
							for( var ui=no_nw; ui<=num_new_rooms; ui++)
							{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
							}	
						}
				//3-b5
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==0)
		{
			if($('#sel_nw_512ch'+no_nw).val()==3)
			{
				//alert("adl 0 - c512h 3");
				if($('#child_no_cal').val()>=1)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else{
				// no need for	
					for( var ui=no_nw; ui<=num_new_rooms; ui++)
					{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}
				}
			//1 b5	
			}else if($('#sel_nw_512ch'+no_nw).val()==2)
			{
				//alert("adl 0 - c512h 2");
				if($('#child_no_cal').val()>=2)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else if($('#child_no_cal').val()>=1)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});	
				}else{
					// no need for
						for( var ui=no_nw; ui<=num_new_rooms; ui++)
						{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
						}
				}
				//2-b5
			}else if($('#sel_nw_512ch'+no_nw).val()==1)
			{
				//alert("adl 0 - c512h 1");
				if($('#child_no_cal').val()>=3)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else if($('#child_no_cal').val()>=2)
				{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else if($('#child_no_cal').val()>=1)
				{
						$('#chb5_nw_td'+no_nw).empty().html("<select id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_chbelow5_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
				}else
				{
				//no need for	
					for( var ui=no_nw; ui<=num_new_rooms; ui++)
					{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}
				}
				//3-b5
			}else{
				//alert("adl 0 - c512h 0");
				if($('#child_no_cal').val()>=1)
				{
				$('#chb5_nw_td'+no_nw).empty().html("<input id='sel_nw_b5ch"+no_nw+"' name='sel_nw_b5ch"+no_nw+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}else{
				//no need for
					for( var ui=no_nw; ui<=num_new_rooms; ui++)
					{
						$('#chb5_nw_td'+ui).empty().html("<input id='sel_nw_b5ch"+ui+"' name='sel_nw_b5ch"+ui+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
					}
				}
				//no-b5
			}
		}
}//outer if
		
}

function find_no_ch512_rem(val,no)
{
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());
	var ch512_ttoll=$('#child512_no_cnt').val();	
		var no_nw=no+1;
		var jcnt=0;
		var cur_val=val;
		//alert("ch512"+$('#child512_no_cal').val());
		//alert($('#sel_adlt_nw'+no_nw).val());
		for(var dis=no_nw;dis<=num_new_rooms;dis++)
		{				
	$('#ch512_nw_td'+dis).empty().html("<input id='sel_nw_512ch"+dis+"' name='sel_nw_512ch"+dis+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
		//jcnt=jcnt+parseInt($('#sel_nw_512ch'+dis).val());
		}
		
		for(var prv=1;prv<no_nw;prv++)
		{
		jcnt=jcnt+parseInt($('#sel_nw_512ch'+prv).val());
		}
		$('#child512_no_cal').val(parseInt($('#child512_no_cnt').val())-jcnt);
		
		
		//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
		
		if(num_new_rooms >= no_nw)
		{	
			
		if($('#sel_adlt_nw'+no_nw).val()==3)
		{
			//alert("adu 3");
			if($('#child512_no_cal').val()>=1)
			{
$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
$('.chosen-select').chosen({width:'100%'});
			}else{
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#ch512_nw_td'+rem_td).empty().html("<input id='sel_nw_512ch"+rem_td+"' name='sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==2)
		{
			//alert("adu 2");
			if($('#child512_no_cal').val()>=2)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else if($('#child512_no_cal').val()>=1)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else{ //$('#child512_no_cal').val() ==0
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#ch512_nw_td'+rem_td).empty().html("<input id='sel_nw_512ch"+rem_td+"' name='sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==1)
		{
			//alert("adu 1");
			if($('#child512_no_cal').val()>=3)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}
			else if($('#child512_no_cal').val()>=2)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else if($('#child512_no_cal').val()>=1)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else{ //$('#child512_no_cal').val() ==0
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#ch512_nw_td'+rem_td).empty().html("<input id='sel_nw_512ch"+rem_td+"' name='sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}else if($('#sel_adlt_nw'+no_nw).val()==0)
		{
			//alert("adu 0");
			if($('#child512_no_cal').val()>=3)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}
			else if($('#child512_no_cal').val()>=2)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else if($('#child512_no_cal').val()>=1)
			{
				$('#ch512_nw_td'+no_nw).empty().html("<select id='sel_nw_512ch"+no_nw+"' name='sel_nw_512ch"+no_nw+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no_nw+"); find_no_ch512_rem(this.value,"+no_nw+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				//$('#child512_no_cal').val(parseInt($('#child512_no_cal').val())-parseInt(cur_val));
			}else{ //$('#child512_no_cal').val() ==0
				for(var rem_td=no_nw;rem_td<=num_new_rooms;rem_td++)
				{
				$('#ch512_nw_td'+rem_td).empty().html("<input id='sel_nw_512ch"+rem_td+"' name='sel_nw_512ch"+rem_td+"' data-original-title='No need' class='form-control tooltips ' value='0' readonly>");
	$('.tooltips').tooltip();
				}
			}
			
		}
		}//outer if
		
		
	
}

function find_no_youth(val,no)
{
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());	
		var dis_nw=no+1;
		var jcnt=0;
	
	for(var dis=dis_nw;dis<=num_new_rooms;dis++)
	{				
	$('#ch512_nw_td'+dis).empty().html("<input id='sel_nw_512ch"+dis+"' name='sel_nw_512ch"+dis+"' class='form-control tooltips ' value='0' readonly>");
		jcnt=jcnt+parseInt($('#sel_nw_512ch'+dis).val());
	}
	for(var prv=1;prv<dis_nw;prv++)
	{
		jcnt=jcnt+parseInt($('#sel_nw_512ch'+prv).val());
	}
	
	$('#child512_no_cal').val(parseInt($('#child512_no_cnt').val())-jcnt);
	
	tt_ad_val=$('#child512_no_cal').val();
	tt_ad_val1=tt_ad_val;
	$('#child512_no_cal').val(tt_ad_val1);
	
	var new_no=no+1;
	
	var type=14;
		if($('#child512_no_cnt').val()>0)
		{
			/*$.get('AGENT/ajax_agent.php?val='+val+'&no='+no+'&type='+type,function(result){
			$('#ch512_nw_td'+no).empty().html(result);
			$('.chosen').chosen({width:'100%'});
			});*/
			
			if(val==3 )
			{
		$('#ch512_nw_td'+no).empty().html("<select id='sel_nw_512ch"+no+"' name='sel_nw_512ch"+no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no+"); find_no_ch512_rem(this.value,"+no+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
			if($('#child_no_cnt').val()>0)
			{
			$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else{
					$('#sel_nw_b5ch'+no).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
			}
		
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value==0){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',true);
		//$('#sel_nw_extr'+no).removeAttr('data-original-title').addClass('tooltips').attr('date-original-title','Mandatory');
		//$('.tooltips').tooltip();
		$('.chosen-select').chosen({width:'100%'});
		
		
			}else if(val==2 )
			{
		$('#ch512_nw_td'+no).empty().html("<select id='sel_nw_512ch"+no+"' name='sel_nw_512ch"+no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no+"); find_no_ch512_rem(this.value,"+no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
				if($('#child_no_cnt').val()>0)
				{
			$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
				}else{
						$('#sel_nw_b5ch'+no).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
				}
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
			}
			else if(val==1 )
			{
		$('#ch512_nw_td'+no).empty().html("<select id='sel_nw_512ch"+no+"' name='sel_nw_512ch"+no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_chb5(this.value,"+no+"); find_no_ch512_rem(this.value,"+no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});	
			
			if($('#child_no_cnt').val()>0)
			{
			$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});	
			}else{
				$('#sel_nw_b5ch'+no).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
			}
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
		
			}
			else 
			{
				alert('no need');
			}
			
		}else{ //outer else for child512 count<0
				for(var ki=1;ki<=num_new_rooms;ki++)
				{
				$('#sel_nw_512ch'+ki).removeAttr('data-original-title').attr('data-original-title','No need');
				$('.tooltips').tooltip();
				}
			
				if($('#child_no_cnt').val()>0)//for adult with below5 age // not ch512
				{
					if(val==3 )
					{
					$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				
			
		//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value==0){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',true);
		//$('#sel_nw_extr'+no).removeAttr('data-original-title').addClass('tooltips').attr('data-original-title','Mandatory');
		$('.chosen-select').chosen({width:'100%'});
		//$('.tooltips').tooltip();
				
					}else if(val==2 )
					{
					$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
				$('.chosen-select').chosen({width:'100%'});
				
				//for extra bed
		$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
					}
					else if(val==1 )
					{
				$('#chb5_nw_td'+no).empty().html("<select id='sel_nw_b5ch"+no+"' name='sel_nw_b5ch"+no+"' onchange='find_chbelow5_rem(this.value,"+no+")' class='form-control chosen-select' data-placeholder='choose'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
				$('.chosen-select').chosen({width:'100%'});	
				
				$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
					}
				}else{// for no ch512 and chb5
					for(var ki=1;ki<=num_new_rooms;ki++)
					{
					$('#sel_nw_b5ch'+ki).removeAttr('data-original-title').attr('data-original-title','No need');
					$('.tooltips').tooltip();
					}
					
					if(val==3)
					{
								$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='0'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
						}else if(val==2 )
					{
								$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
						}else if(val==1 )
					{
								$('.chosen-select').chosen('destroy');
		$('#sel_nw_extr'+no+' option').each(function(i,val){ if(val.value=='-'){ $(this).attr('selected',true); } });
		$('#sel_nw_extr'+no).attr('disabled',false);
		$('.chosen-select').chosen({width:'100%'});
						}
					
				}
		}
}

function find_no_adult_rem(val,no)
{
		
	var tt_ad_val, tt_ad_val1;
	var num_new_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());	
		var dis_nw=no+1;
		var jcnt=0;
	
	for(var dis=dis_nw;dis<=num_new_rooms;dis++)
	{				
		$('#adlt_nw_td'+dis).empty().html("<input id='sel_adlt_nw"+dis+"' name='sel_adlt_nw"+dis+"' class='form-control tooltips ' value='0' readonly>");
		jcnt=jcnt+parseInt($('#sel_adlt_nw'+dis).val());
	}
	for(var prv=1;prv<dis_nw;prv++)
	{
		jcnt=jcnt+parseInt($('#sel_adlt_nw'+prv).val());
	}
	
	$('#adult_no_cal').val(parseInt($('#adult_no_cnt').val())-jcnt);
	
	tt_ad_val=$('#adult_no_cal').val();
	tt_ad_val1=tt_ad_val;
	$('#adult_no_cal').val(tt_ad_val1);
	
	var new_no=no+1;
	if(tt_ad_val1>=3 && num_new_rooms>=new_no)
	{
		
		$('#adlt_nw_td'+new_no).empty().html("<select id='sel_adlt_nw"+new_no+"' name='sel_adlt_nw"+new_no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,"+new_no+"); find_no_adult_rem(this.value,"+new_no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
	}else if(tt_ad_val1>=2 && num_new_rooms>=new_no)
	{
		$('#adlt_nw_td'+new_no).empty().html("<select id='sel_adlt_nw"+new_no+"' name='sel_adlt_nw"+new_no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,"+new_no+"); find_no_adult_rem(this.value,"+new_no+")'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
		
	}else if(tt_ad_val1>=1 && num_new_rooms>=new_no)
	{
		$('#adlt_nw_td'+new_no).empty().html("<select id='sel_adlt_nw"+new_no+"' name='sel_adlt_nw"+new_no+"' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,"+new_no+"); find_no_adult_rem(this.value,"+new_no+")'><option selected value='0'>choose</option><option value='1'>1</option></select>");
		$('.chosen-select').chosen({width:'100%'});
	}else if(num_new_rooms>=new_no)
	{
	//no adult	
		for(var mm=new_no;mm<=num_new_rooms;mm++)
		{
			$('#sel_adlt_nw'+mm).removeAttr('data-original-title').attr('data-original-title','No need');
			$('.tooltips').tooltip();
		}
	}
}

function plan_my_stay(where)
{
	//for emptying initially
	$('#table_collection0').empty();
	var err_len=$('#new_room_table tbody').children().length;
	for(var er=2;er<err_len;er++)
	{
		$('#new_rm_tr'+er).remove();
	}
	$('#ch512_nw_td1').empty().html("<input type='text' id='sel_nw_512ch1' name='sel_nw_512ch1' value='0' readonly class='form-control tooltips' data-original-title=''>");
	
	$('#chb5_nw_td1').empty().html("<input type='text' id='sel_nw_b5ch1' name='sel_nw_b5ch1' value='0' readonly class='form-control tooltips' data-original-title=''>");
	
		$('#extr_nw_td1').empty().html("<select id='sel_nw_extr1' name='sel_nw_extr1' class='form-control chosen-select'><option value='-' selected>Nil</option><option value='0'>With Bed</option><option value='1'>Without Bed</option></select>");
	
	//room formation start
		$('#stay').hide();
		$('#tableee').show();
			var num_of_rooms=parseInt($("#totrooms .dp-numberPicker-input").val());	
			$('#room_of_num').val(num_of_rooms);
			var day_of_stay=parseInt($("#nd .dp-numberPicker-input").val());	
			$('#day_of_stay').val(day_of_stay);
			
			var tt_ad_val2=$('#adult_no_cal').val();
			var tt_ad_val3;
			
			if(tt_ad_val2>=3 )
			{
		$('#adlt_nw_td1').empty().html("<select id='sel_adlt_nw1' name='sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,1); find_no_adult_rem(this.value,1)'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else if(tt_ad_val2>=2 )
			{
		$('#adlt_nw_td1').empty().html("<select id='sel_adlt_nw1' name='sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange='find_no_youth(this.value,1); find_no_adult_rem(this.value,1)'><option selected value='0'>choose</option><option value='1'>1</option><option value='2'>2</option></select>");
		$('.chosen-select').chosen({width:'100%'});
			}else if(tt_ad_val2>=1 )
			{
	$('#adlt_nw_td1').empty().html("<select id='sel_adlt_nw1' name='sel_adlt_nw1' class='form-control chosen-select' data-placeholder='choose' onChange= find_no_youth(this.value,1); find_no_adult_rem(this.value,1)'> <option selected value='0'>choose</option><option value='1'>1</option></select>");
	$('.chosen-select').chosen({width:'100%'});
			}
			
			for(nw_rm=2;nw_rm<=num_of_rooms;nw_rm++)
			{//alert(nw_rm);
				var new_rm_add="<tr id='new_rm_tr"+nw_rm+"'><td style='padding:10px' id='room_nw_td"+nw_rm+"'>Room "+nw_rm+"</td><td style='padding:10px' id='adlt_nw_td"+nw_rm+"'><input type='text' id='sel_adlt_nw"+nw_rm+"' value='0' name='sel_adlt_nw"+nw_rm+"' readonly class='form-control tooltips'></td><td style='padding:10px' id='ch512_nw_td"+nw_rm+"'><input type='text' value='0' id='sel_nw_512ch"+nw_rm+"' name='sel_nw_512ch"+nw_rm+"' readonly class='form-control tooltips' ></td><td style='padding:10px' id='chb5_nw_td"+nw_rm+"'><input type='text' value='0' id='sel_nw_b5ch"+nw_rm+"' name='sel_nw_b5ch"+nw_rm+"' readonly class='form-control tooltips' ></td><td style='padding:10px' id='extr_nw_td"+nw_rm+"'><select id='sel_nw_extr"+nw_rm+"' name='sel_nw_extr"+nw_rm+"' class='form-control chosen-select'><option value='-' selected>Nil</option><option value='0'>With Bed</option><option value='1'>Without Bed</option></select></td></tr>";
				
				var prvv=nw_rm-1;
				$(new_rm_add).insertAfter('#new_rm_tr'+prvv);
				$('.chosen-select').chosen({width:'100%'});
			}
			
			//room formation end
			
			//hotel information start
			var stay_days=parseInt($("#nd .dp-numberPicker-input").val());
			var table_uniq;
			for(var days=1;days<=stay_days;days++)
			{
				table_uniq="<div id='table_collection"+days+"'><center><table id='stay_tabell"+days+"' class='table' style='width:90%;margin-top:15px; border:#DFDADA 1px solid;' ><tr style='height:20px; background-color:#FFFCF2'><td width='15%'>Date</td><td width='20%' id='sdate_nw_td"+days+"' >23-Jun-2015</td><td witdh='15%'>Place:</td><td colspan='2' id='city_nw_td"+days+"'>xxx</td></tr><tr><td width='15%'>Category</td><td width='25%' id='catag_nw_td"+days+"'><input type='text' class='form-control' disabled ></td><td width='5%'>&nbsp;</td><td id='tdroom_nw_td"+days+"' rowspan='4' colspan='2' width='40%' style='border: #CAC6C6 1px solid; background-color: rgb(245, 245, 244);'><br><br><center>Choose hotel for finding available rooms</center></td></tr></tr><tr><td width='15%'>Hotel</td><td width='25%' id='hotel_nw_td"+days+"' ><input type='text' class='form-control' disabled ></td><td>&nbsp;</td></tr></tr><tr><td width='5%'>Food</td><td id='food_nw_td"+days+"'><input type='text' class='form-control' id='food_id"+days+"' name='food_id"+days+"' disabled ></td><td width='5%'> </td></tr></tr><tr><td width='15%'>Special</td><td width='25%' id='spl_nw_td"+days+"'><input type='text' class='form-control' name='ext_item_id"+days+"' id='ext_item_id"+days+"' disabled ></td><td width='5%'></td></tr><tr style='height:60px; background-color:#FFFCF2'><td colspan='5'><strong style='font-size:10px;'>* Breakfast complimentory for all pax.</strong><br><center><a id='pic_view"+days+"' class='add_hots4 btn btn-sm btn-info' ><i class='fa fa-picture-o'></i>&nbsp;View Spot</a>&nbsp;&nbsp;&nbsp;&nbsp;<a  id='video_view"+days+"' class='view_video btn btn-sm btn-info'><i class='fa fa-video-camera'></i>&nbsp;Spot Video</a></center></td></tr></table><input type='hidden' id='htl_id"+days+"' value='' /></center></div>";

					var prv_day=days-1;
					if(days==1){
					$(table_uniq).appendTo('#table_collection'+prv_day);
					}else{
						$(table_uniq).insertAfter('#table_collection'+prv_day);
					}
				
			}
			
			
		var eat;
		for(var east=1;east<=stay_days;east++)
		{
			eat=east-1;
			var ddate=$('#start_date'+eat+'0').val();
			$('#sdate_nw_td'+east).empty().html("<input class='form-control' type='text' readonly id='sdat"+east+"' name='sdat"+east+"' value='"+ddate+"'>");
			
			city_kitname=$('#kit_kat').val().split(",");
			//alert(city_kitname);
			city_kitname1=city_kitname[eat];
		$('#city_nw_td'+east).empty().html("<input type='text' class='form-control' value='"+city_kitname1+"' id='kitcity"+eat+"' readonly='readonly' >");
		
		
			city_kitidd=$('#kit_cityidd').val().split(",");
			idds=city_kitidd[eat];
			$('#pic_view'+east).attr('href','AGENT/view_img_desc.php?cid='+idds);
			$('#video_view'+east).attr('href','AGENT/view_video_spot.php?cid='+idds);
			
		}
	
		var kitkkk=$('#kit_cityidd').val().split(",");
		var kithhh=kitkkk.length;
		var hugg;
		for(var hug=0; hug<kithhh; hug++)
		{
		  hugg=hug+1;
			$('#htl_id'+hugg).val(kitkkk[hug]);
			find_hotel_categ(kitkkk[hug],hugg);
			find_all_categ(kitkkk[hug],hugg);
			
		}
	
	$('#sun').show();

	
}


function trans_hotel()
{
	var date2 = ''; var date4 = '';  var date5 = '';
	var arr_city_id = document.getElementById("st_city").value;
	var var_city = $('#st_city option:selected').html().split('-');
	date2 = $('#arrdate').data('datepicker').date;
		if (var_city[0] != '' && $("#seaterr0").is(":hidden") && $("#arrdate").val() != '' && $("#st_vehic0").val() != '')
		{
			var get_day=$('#daydiv').val();
			if(get_day > 0)
			{
				get_day--;
				for (var j=1;j<=get_day;j++)
				{
					document.getElementById('labdiv'+j).remove();
					document.getElementById('div'+j).remove();
				}
			}
			
			$('#daydiv').val(0);
			var vehidarr = getvehids();
			get_cities1(0,0,arr_city_id,vehidarr);
			loading_cityrow();
			
			$("#start_city00").val(var_city[0].trim()).attr('data-original-title',var_city[0].trim());
			
			
			var dd = date2.getDate();
			
			var mm = date2.getMonth() + 1;
			var y = date2.getFullYear();
			
			if (mm < 10)
			{
				var mm1 = '0'+mm;
			}
			else
			{
				var mm1 = mm;
			}
			
			if (dd < 10)
			{
				var dd1 = '0'+dd;
			}
			else
			{
				var dd1 = dd;
			}
			var FormattedDate = y + '-' + mm1 + '-' + dd1;
			document.getElementById('start_date00').value = FormattedDate;
			
			
			$("#book_det").show();
			$("#daycnt").text(parseInt(day_cnt) + 1);
			//$("#row_line").show();
			
			var dy,cty;
			cty=0; dy=0;
			
			var tot_row_cnt = parseInt($("#nn .dp-numberPicker-input").val());
			
			for (var k=1;k<tot_row_cnt;k++)
			{
				dy++;
			
				//new_fromto = "<div class='form-group' id='labdiv"+dy+"'><div class='row'><label class='control-label col-sm-3'>Enter details for booking:DAY <label id='daycnt"+dy+cty+"'></label></label><div class='col-sm-9'></div></div></div><div class='form-group' id='div"+dy+"'><div class='row'><label class='control-label col-sm-1'>Travel Date &nbsp;&nbsp;</label><div class='col-sm-2'><input type='text' class='form-control datepickerm' data-date-format='yyyy-mm-dd' placeholder='yyyy-mm-dd' name='start_date[]' id='start_date"+dy+cty+"' readonly='readonly'></div><div><label class='col-sm-1 control-label'>From: &nbsp;&nbsp;</label><div class='col-sm-2'><input class='form-control bold-border' type='text' name='start_city[]' id='start_city"+dy+cty+"' readonly='readonly'></div><label class='control-label col-sm-1'>To: &nbsp;&nbsp;</label><div class='col-sm-3' id='load_cityrow"+dy+cty+"'></div></div><div class='col-sm-2'><div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'><i class='fa fa-cog'></i> Action <span class='caret'></span></button><ul class='dropdown-menu' role='menu'><li><a id='"+dy+"' href='javascript:void(0);' onclick='newfromto(this.id);loading_cityrow();'>Add Row</a></li><li><a href='javascript:void(0);' onclick='remfromto(this.id)' id='"+dy+"'>Remove Last</a></li><li class='divider'></li><li><center><table width='80%'><tr><td width='50%' align='center'><a  class='add_hots4 btn btn-sm btn-default' id='atxt"+dy+"-"+cty+"'><i class='fa fa-picture-o'></i></a></td><td width='50%' align='center'><a  id='vvatxt"+dy+"-"+cty+"' class='view_video btn btn-sm btn-default' ><i class='fa fa-video-camera'></i></a></td></tr></table></center></li></ul></div></div></div><input type='hidden' id='d"+dy+"' value='"+dy+"' /><input type='hidden' id='c"+dy+"' value='0' /></div>";
				
				new_fromto = "<div class='form-group' id='labdiv"+dy+"'><div class='row'><label class='control-label col-sm-3'>Enter details for booking:DAY <label id='daycnt"+dy+cty+"'></label></label><div class='col-sm-9'></div></div></div><div class='form-group' id='div"+dy+"'><div class='row'><label class='control-label col-sm-1'>Travel Date &nbsp;&nbsp;</label><div class='col-sm-2'><input type='text' class='form-control datepickerm' data-date-format='yyyy-mm-dd' placeholder='yyyy-mm-dd' name='start_date[]' id='start_date"+dy+cty+"' readonly='readonly'></div><div><label class='col-sm-1 control-label'>From: &nbsp;&nbsp;</label><div class='col-sm-2'><input class='form-control bold-border tooltips' type='text' name='start_city[]' id='start_city"+dy+cty+"' readonly='readonly'></div><label class='control-label col-sm-1'>To: &nbsp;&nbsp;</label><div class='col-sm-3' id='load_cityrow"+dy+cty+"'></div></div><div class='col-sm-2'><center><table width='80%'><tr><td width='50%' align='center'><a  class='add_hots4 btn btn-sm btn-default' id='atxt"+dy+"-"+cty+"'><i class='fa fa-picture-o'></i></a></td><td width='50%' align='center'><a  id='vvatxt"+dy+"-"+cty+"' class='view_video btn btn-sm btn-default' ><i class='fa fa-video-camera'></i></a></td></tr></table></center></div></div><input type='hidden' id='d"+dy+"' value='"+dy+"' /><input type='hidden' id='c"+dy+"' value='0' /></div>";
				
				date4 = $('#arrdate').data('datepicker').date;
				date5 = moment(date4);
				
				date5 = moment(date5).add('days', k);
				
				var dymimus = dy - 1;
				$(new_fromto).insertAfter('#div'+dymimus);
				document.getElementById('start_date'+dy+cty).value = moment(date5).format('YYYY-MM-DD');
				$("#daycnt"+dy+cty).text(parseInt(dy) + 1);
				
				date4 = ''; date5 = '';
				get_cities2(dy,cty);
			}
			
			 $('#daydiv').val(tot_row_cnt);
			 
			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

			$('.datepickerm').datepicker(
			{
			 	onRender: function(date) 
				{
					return date.valueOf() < now.valueOf() ? 'disabled' : '';
				}
			});
		}
		else
		{
			if (var_city[0] == '')
			{
				alert ('Choose arrival city');
			}
			else if ($("#seaterr0").is(":visible"))
			{
				alert ('Travellers number exceeds vehicle capacity');
			}
			else if($("#arrdate").val() == '')
			{
				alert ('Select arrival date and time');
			}
			else if ($("#st_vehic0").val() == '')
			{
				alert ('Choose vehicle for your travel');
			}
		}
		$('#quote').hide(); 
		//$('#subplan').hide(); 
		$('#stay_plan11').hide();
	
}

function nextrow_val(rowid)
{
	//alert("row"+rowid);
	var rowid1 = rowid.split('-');
	var mrowid = rowid1[0];
	var srowid = rowid1[1];

	var tocity_id = $('#row_city'+mrowid+srowid).val();
	var tocity_val = $('#row_city'+mrowid+srowid+' option:selected').text().split('-');
	srowid++;
	
	var getfrom_cit = $("#start_city"+mrowid+srowid).val();
	var lastrow_mins1 = $('#daydiv').val() - 2;
	var vehidarr = getvehids();
	$('.tooltips').tooltip();
	if (typeof getfrom_cit != "undefined" && lastrow_mins1 != mrowid)
	{
		$("#start_city"+mrowid+srowid).val(tocity_val[0].trim()).attr('data-original-title',tocity_val[0].trim());
		get_cities1(mrowid,srowid,tocity_id,vehidarr);
	}
	else if (lastrow_mins1 != mrowid)
	{
		srowid = 0; mrowid++;
		$("#start_city"+mrowid+srowid).val(tocity_val[0].trim()).attr('data-original-title',tocity_val[0].trim());
		get_cities1(mrowid,srowid,tocity_id,vehidarr);
	}
	else if (lastrow_mins1 == mrowid)
	{
		srowid = 0; mrowid++;
		$("#start_city"+mrowid+srowid).val(tocity_val[0].trim()).attr('data-original-title',tocity_val[0].trim());
		get_cities3(mrowid,srowid,tocity_id,vehidarr);
	}
	
	var cid1= tocity_id.split('-');
	//alert('#atxt'+rowid);
	$('#atxt'+rowid).attr('href','AGENT/view_img_desc.php?cid='+cid1[0]);
	$('#vvatxt'+rowid).attr('href','AGENT/view_video_spot.php?cid='+cid1[0]);
}

function newfromto(id)
{
	var cty,dya;
	dya=$('#d'+id).val();
	cty=$('#c'+id).val();

	var check_empty = '';

	for(var t1=0;t1<=dya;t1++)
	{
		for(var s1=0;s1<=cty;s1++)
		{
			if ($('#row_city'+t1+s1).val() == '')
			{
				check_empty = 'Y';
			}
		}
	}
	 
	var tocity_id = $('#row_city'+dya+cty).val();
	
	if (check_empty == '')
	{
		cty++;
		
		new_fromto = "<div id='fromto_row"+dya+cty+"'><div class='form-group'><div class='row'><div class='col-sm-3'></div><label class='col-sm-1 control-label'>From: &nbsp;&nbsp;</label><div class='col-sm-2'><input class='form-control bold-border tooltips1' type='text' name='start_city[]' id='start_city"+dya+cty+"' readonly='readonly'></div><label class='control-label col-sm-1'>To: &nbsp;&nbsp;</label><div class='col-sm-3' id='load_cityrow"+dya+cty+"'></div></div></div></div>";
		
		$('#c'+id).val(cty);
		//get_cities2(dya,cty);
		var vehidarr = getvehids(); 
		get_cities1(dya,cty,tocity_id,vehidarr);
	//	cty--;
		$(new_fromto).appendTo('#div'+id);			
		
		var curday=$('#d'+id).val();
		var currec=$('#c'+id).val();
		var prevrec=currec - 1;
		var tocity_val = $('#row_city'+curday+prevrec+' option:selected').text().split('-');
		
		$("#start_city"+curday+currec).val(tocity_val[0].trim());
	}
	else
	{
		alert ('Select '+'TO'+' location');
	}
}

function remfromto(id)
{
	var ccnt;
	ccnt=$('#c'+id).val();
	
	if (ccnt > 0)
	{
		$('#fromto_row'+id+ccnt).remove();
		ccnt--;
		$('#c'+id).val(ccnt);
		
		
		var tocity_id = $('#row_city'+id+ccnt).val();
		var tocity_val = $('#row_city'+id+ccnt+' option:selected').text().split('-');
		
		id++; ccnt = 0;
		$("#start_city"+id+ccnt).val(tocity_val[0].trim());
		var vehidarr = getvehids();
		get_cities1(id,ccnt,tocity_id,vehidarr);
	}
}

function show_flightmap()
{
	$("#gmap_div1").show();
	$("#gmap_div2").show();
	
	var mapOptions = {
    zoom: 5,
    center: new google.maps.LatLng(21.0000, 78.0000),
    mapTypeId: google.maps.MapTypeId.TERRAIN
	};
	
	var getcord1 = $("#st_city").val();
	var loc1 = getcord1.split("-");
	var loc1_latlng = '('+loc1[1].trim()+','+loc1[2].trim()+')';

	var map = new google.maps.Map(document.getElementById('gmap_path1'),mapOptions);

	var locat;
	var getfline;
	var myTrip=new Array(); var popup_markers=new Array(); var popup_info=new Array();
	myTrip.push(new google.maps.LatLng(loc1[1].trim(),loc1[2].trim()));
	popup_markers.push(loc1[1].trim(),loc1[2].trim());
	popup_info.push($('#st_city option:selected').text());
	
	var dya = $('#daydiv').val();
	for(var w1=0;w1<=dya;w1++)
	{
		var gethid = $('#c'+w1).val();
		for(var x1=0;x1<=gethid;x1++)
		{
			getfline = $("#row_city"+w1+x1).val();
			locat = getfline.split("-");
			myTrip.push(new google.maps.LatLng(locat[1].trim(),locat[2].trim()));
			popup_markers.push(locat[1].trim(),locat[2].trim());
			var cityname_info = $('#row_city'+w1+x1+' option:selected').text();
			popup_info.push(cityname_info);
		} 
	}

	var flightPath = new google.maps.Polyline({
   // path: flightPlanCoordinates,
	path: myTrip,
    geodesic: true,
    strokeColor: '#FF0000',
    strokeOpacity: 2.0,
    strokeWeight: 3
	});
	
	
	//Markers setting code
	for (var i = 0; i < myTrip.length; i++)
	{
		var lat = popup_markers[i][1]
		var long = popup_markers[i][2]
		var info_window =  popup_info[i]
	
		latlngset = myTrip[i];
	
		var marker = new google.maps.Marker({  
			map: map, title: 'Cityname' , position: latlngset  
			});
			
			map.setCenter(marker.getPosition())
			var currentinfo = null;
			var content = "Location: " + (i+1) +  '</h3>' + " : " + info_window     
	
			var infowindow = new google.maps.InfoWindow()
			
			google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
			return function() {
				if(currentinfo) { currentinfo.close();} 
			   infowindow.setContent(content);
			   infowindow.open(map,this);
			   currentinfo = infowindow;
			};
		})(marker,content,infowindow)); 
	  }
	
	flightPath.setMap(map);
	
}

function toRad(deg) 
{
	return deg * Math.PI/180;
}

var map;
var geocoder;
var origin1 = '';
var destination1 = '';
var destination2 = '';

function show_roadmap()
{
	
	if($('#kit_kat').val()!='')
	{
		$('#kit_kat').val('');	
		$('#stay_plan11').hide();
	}
	
	$("#callbackid").val('');
	//$("#gmap_div1").show();
	$("#gmap_div2").show();
	
	var mapOptions = 
	{
		zoom: 5,
		center: new google.maps.LatLng(21.0000, 78.0000),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var tot_dist = 0;
	var strt_city = $('#st_city option:selected').text().split('-');
	var strt_cityid = $('#st_city').val().split('-');
	
	var st_cit = strt_city[0].trim()+', '+strt_city[1].trim();
	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	var distance;
	var map = new google.maps.Map(document.getElementById('gmap_path2'),mapOptions);
  
	directionsDisplay = new google.maps.DirectionsRenderer();
	directionsDisplay.setMap(map);
	
	var start = st_cit;
	//alert(start);
	var waypts = [];
	var trav_cit = []; var idarr = [];
	var road_locat; var locat_format;
	
	trav_cit.push(start+','+strt_cityid[0].trim());
	idarr.push(strt_cityid[0].trim());
	
	var dyb = $('#daydiv').val();
	dyb--;
	for(var w1=0;w1<=dyb;w1++)
	{
		var gethid = $('#c'+w1).val();
		
		if (w1 == dyb)
		{
			gethid--
		}
		for(var x1=0;x1<=gethid;x1++)
		{
			var getrline = $("#row_city"+w1+x1+' option:selected').text();
			road_locat = getrline.split("-");
			var mid_cityid = $('#row_city'+w1+x1).val().split('-');
			if (road_locat[0] != '')
			{
				locat_format = road_locat[0].trim()+', '+road_locat[1].trim();
				waypts.push({
				location:locat_format,
				stopover:true});
				if (mid_cityid[3] == '1')
				{
					trav_cit.push(locat_format+','+mid_cityid[0].trim());
				}
				idarr.push(mid_cityid[0].trim());
			}
		}
	}
	//alert(JSON.stringify(trav_cit)); 
	var gethid1 = $('#c'+dyb).val();
	
	getrline1 = $("#row_city"+dyb+gethid1+' option:selected').text();
	road_locat1 = getrline1.split("-");
	var end = road_locat1[0].trim()+', '+road_locat1[1].trim();
	var end_cityid = $('#row_city'+dyb+gethid1).val().split('-');
	//alert(end);
	trav_cit.push(end+','+end_cityid[0].trim());
	idarr.push(end_cityid[0].trim());
	//alert(idarr);
	$('#cid_arr').val(idarr);
	$("#dest_id").val(end_cityid[0].trim());
	
	var request = {
		  origin: start,
		  destination: end,
		  waypoints: waypts,
		  optimizeWaypoints: true,
		  travelMode: google.maps.TravelMode.DRIVING
	  };
		
	directionsService.route(request, function(response, status) {
	//	alert(status);
	if (status == google.maps.DirectionsStatus.OK) 
	{
		directionsDisplay.setDirections(response);
		var route = response.routes[0];
		var summaryPanel = document.getElementById('directions_panel');
		var dist_total = document.getElementById('show_distot');
		var spl_dist;
		summaryPanel.innerHTML = ''; 
		  // For each route, display summary information.
		  var kitfin = $('#kit_kat').val(); var stor_city = ''; var format_dat = ''; var phparr = [];
		  //var kitfin;
		for (var i = 0; i < route.legs.length; i++) 
		{
			var routeSegment = i + 1;
			summaryPanel.innerHTML += '<b>DAY: ' + routeSegment + '</b> &nbsp;';
			var date_read = moment($('#start_date'+i+'0').val()).format('MMMM Do YYYY, dddd');
			summaryPanel.innerHTML += '<b>('+date_read + ')</b> <br>';
			summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
			summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
			spl_dist = route.legs[i].distance.text.split("km");
			//alert(route.legs[i].start_address);
			if (spl_dist[0] != '')
			{
				var spl_dist1=spl_dist[0].replace(/\,/g,'');
			}
			else
			{
				var spl_dist1 = 1;
			}
			//Add 30kms for sight seeing every day.
			var spl_dist2 = parseInt(spl_dist1) + 30;
			summaryPanel.innerHTML += 'Travel distance: '+spl_dist2 + 'kms.' + '<br>';
			summaryPanel.innerHTML += 'Aproximative driving time: '+route.legs[i].duration.text+'.<br><br>';
			
			tot_dist+=parseInt(spl_dist2);
			var spl_stcity = route.legs[i].start_address.split(',');
			var spl_nxcity = route.legs[i].end_address.split(',');
			var spl_trtime = route.legs[i].duration.text;
			stor_city+=spl_stcity[0]+'-'+spl_nxcity[0]+'-'+spl_dist1+'-'+spl_trtime;
			format_dat+=spl_stcity[0]+'-'+spl_nxcity[0]+'-'+spl_dist1+'-'+spl_trtime+'~';
			phparr.push(stor_city);
			stor_city = '';
			var kit,kit1;
			if(i != 0)
			{
				 kit=route.legs[i].start_address;
				 kit1=kit.split(",");
			 
				 if(kitfin == '')
				 {
					 kitfin=kit1[0];
				 }
				 else
				 {
					 kitfin= kitfin+','+kit1[0];
				 }
			}
		}
		
		$('#kit_kat').val(kitfin);
		$('#citydata').val(phparr);
		$('#formatdata').val(format_dat);
		var jojo=$('#kit_kat').val();
		//alert('bef'+jojo);
		var ttyy=9;
		$.get('AGENT/ajax_agent.php?cname='+jojo+'&type='+ttyy,function(result)
		{
			//alert(result);
			$('#kit_cityidd').val(result);
		});
		dist_total.innerHTML = "<strong> Total travel distance: "+tot_dist + " kms. </strong>" + '<br>';
		$('#traveldist').val(tot_dist);
	}
	});

	var directionsService1 = new google.maps.DirectionsService();
	var start1 = trav_cit[0].split(',');
	var start2 = start1[0]+', '+start1[1];
	var end1 = trav_cit[trav_cit.length-1].split(',');
	var end2 = end1[0]+', '+end1[1];
	var findistarr = []; var tot_dist1 = 0;
	//alert(trav_cit);
	var dhn='',cyid=new Array();
	var dhan;
 
	for (var d1=0;d1<=trav_cit.length-1;d1++)
	{
		dhan=trav_cit[d1].split(',');
		if(dhn!='')
		{
			dhn=dhn+'-'+dhan[0]+','+dhan[1];
			cyid[d1]=dhan[2];
		}
		else
		{
			dhn=dhan[0]+','+dhan[1];
			cyid[d1]=dhan[2];
		}
	}

	var splcit1 = cyid.length-1;
	$('#citarrid').val(cyid[splcit1]);

	var lendhan=dhn.length;
	var trvl = dhn.split('-');
	var bb; var cc;
 
	for(var nu=0;nu<trvl.length-1;nu++)
	{
	    if(nu == 0)
		{
			destination1=trvl[trvl.length-1];
			origin1=trvl[0];
			geocoder = new google.maps.Geocoder();
			var service = new google.maps.DistanceMatrixService();
			
			service.getDistanceMatrix(
			{
				origins: [origin1],
				destinations: [destination1],
				travelMode: google.maps.TravelMode.DRIVING,
				unitSystem: google.maps.UnitSystem.METRIC,
				avoidHighways: false,
				avoidTolls: false
			},callback(cyid[nu]));
		}
		else
		{
			destination1=trvl[0];
			destination2=trvl[trvl.length-1];
			origin1=trvl[nu];
			geocoder = new google.maps.Geocoder();
			var service = new google.maps.DistanceMatrixService();
			service.getDistanceMatrix(
			{
				origins: [origin1],
				destinations: [destination1,destination2],
				travelMode: google.maps.TravelMode.DRIVING,
				unitSystem: google.maps.UnitSystem.METRIC,
				avoidHighways: false,
				avoidTolls: false
			},callback(cyid[nu]));
		}
	}

		google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
			//$('#quote').show(); 
		if($('#check_boxs').val()!='2')
		{
		$('#stay_plan11').show();
		}
			
		if($('#check_boxs').val()=='2')
		{
 		$('#sun').show();
		}
    //google.maps.event.addListenerOnce(map, 'idle', function(){
    //if (typeof google === 'object' && typeof google.maps === 'object')
	//{
		/*var all_dist = $('#traveldist').val();
		vehrent(all_dist)
		$('#stay_plan11').show();*/
		
	//}
	//});
});
}

function my_route(route_typ, agent_percnt, adm_percent)
{
	/*if($('#check_boxs').val()=='2')
	{
		$('#final_save_btn').show();
	}*/
	
	if($('#kit_kat').val()!='')
	{
		$('#kit_kat').val('');	
		$('#stay_plan11').hide();
	}
	
	$("#callbackid").val('');
	//$("#gmap_div1").show();
	//$("#gmap_div2").show();
	var cit_names = [];
	var tot_dist = 0;
	var strt_city = $('#st_city option:selected').text().split('-');
	var strt_cityid = $('#st_city').val().split('-');
	
	var st_cit = strt_city[0].trim();	
	var distance;
  	cit_names.push(st_cit);
	var start = st_cit;
	var trav_cit = []; var idarr = [];
	var road_locat; var locat_format;
	
	trav_cit.push(strt_cityid[0].trim());
	idarr.push(strt_cityid[0].trim());
	
	var dyb = $('#daydiv').val();
	dyb--;
	for(var w1=0;w1<=dyb;w1++)
	{
		var gethid = $('#c'+w1).val();
		
		if (w1 == dyb)
		{
			gethid--
		}
		for(var x1=0;x1<=gethid;x1++)
		{
			var getrline = $("#row_city"+w1+x1+' option:selected').text();
			road_locat = getrline.split("-");
			var mid_cityid = $('#row_city'+w1+x1).val().split('-');

			if (road_locat[0] != '')
			{
				//locat_format = road_locat[0].trim()+', '+road_locat[1].trim();
				locat_format = road_locat[0].trim();				
				cit_names.push(locat_format);
				if (mid_cityid[2].trim() == '1')
				{
					trav_cit.push(mid_cityid[0].trim());
				}
				idarr.push(mid_cityid[0].trim());
			}
		}
	}
	//alert(JSON.stringify(trav_cit)); 
	var gethid1 = $('#c'+dyb).val();
	
	getrline1 = $("#row_city"+dyb+gethid1+' option:selected').text();
	road_locat1 = getrline1.split("-");
	var end = road_locat1[0].trim();
	var end_cityid = $('#row_city'+dyb+gethid1).val().split('-');
	cit_names.push(end);
	var last_veh_cid = '';
	if (end_cityid[2].trim() == '1')
	{
		last_veh_cid = 'y';
	}
	trav_cit.push(end_cityid[0].trim());
	idarr.push(end_cityid[0].trim());
	//alert(idarr);
	
	$("#dest_id").val(end_cityid[0].trim());
	var format_dat = ''; var stor_city = ''; var phparr = [];
	$.getJSON('<?php echo "AGENT/dist_cities.php"; ?>', { route_type: route_typ, allcids: idarr, vehcitids: trav_cit, last_chk: last_veh_cid }, function(data) {
			//alert("Value for 'detl': " + data.detl + "\nValue for 'retn': " + data.retn + "\nValue for 'netamt': " + data.netamt);
			//document.getElementById('directions_panel').innerHTML=data.detl;
			//alert(route_typ);
			//alert('tot'+data.trav_dist);
			 
			$('#kit_cityidd').val(data.cit_opt_idd);//for hotel city id 
			$('#kit_kat').val(data.cit_optnnmm);
			$('#cid_arr').val(data.cit_ord);
			$('#traveldist').val(data.trav_totdist);
			$('#traveldist_ess').val(data.trav_totdist_ess);
			$('#day_traveldist').val(data.trav_dist);
			$('#day_travdist_ess').val(data.trav_dist_ess);
			
			var cid_list = $('#cid_arr').val().split(',');
			var trav_eachdist = data.trav_dist_ess.split(',');
			var trav_eachdist_ss = data.trav_dist.split(',');
			
			var trav_eachtime = data.frmt_time.split(',');
			if(route_typ == 'o')
			{
				var trav_eachstnm = data.cit_optnams.split('-');
				//alert('fail'+data.opt_fail);
				if (data.opt_fail == 'y')
				{
					alertopt();
				}
			}
			var trav_tim = '';
			for(var r1=0;r1<cid_list.length-1;r1++)
			{
				var r2 = r1 + 1;
				if (route_typ == 'm')
				{
					if (trav_eachtime[r1] == '')
					{
						trav_tim = '-';
					}
					else
					{
						trav_tim = trav_eachtime[r1];
					}
					stor_city+= cit_names[r1]+'-'+cit_names[r2]+'-'+trav_eachdist[r1]+'-'+trav_tim+'-'+trav_eachdist_ss[r1];
					format_dat+=cit_names[r1]+'-'+cit_names[r2]+'-'+trav_eachdist[r1]+'-'+trav_tim+'-'+trav_eachdist_ss[r1]+'~';
				}
				else if(route_typ == 'o')
				{
					if (trav_eachtime[r1] == '')
					{
						trav_tim = '-';
					}
					else
					{
						trav_tim = trav_eachtime[r1];
					}
					var trav_eachstnm1 = trav_eachstnm[r1].split(',');
					var trav_eachstnm2 = trav_eachstnm[r2].split(',');
					stor_city+= trav_eachstnm1[0].trim()+'-'+trav_eachstnm2[0].trim()+'-'+trav_eachdist[r1]+'-'+trav_tim+'-'+trav_eachdist_ss[r1];
					format_dat+=trav_eachstnm[r1]+'-'+trav_eachstnm[r2]+'-'+trav_eachdist[r1]+'-'+trav_tim+'-'+trav_eachdist_ss[r1]+'~';
				}
				phparr.push(stor_city);
				stor_city = '';
			}
			//alert(phparr);
			$('#citydata').val(phparr);
			/*var dist_total = document.getElementById('show_distot');
			var total_days = document.getElementById('show_days');*/
			$('#formatdata').val(format_dat);
			var trval_cids = $('#cid_arr').val();
			var exp_trval_cids = trval_cids.split(',');
			var summaryPanel = document.getElementById('directions_panel');
			summaryPanel.innerHTML = '';
			var tr_data = $('#formatdata').val();
			
			var tr_data1 = tr_data.replace(/,\s*$/, "");
			var tr_data2 = tr_data1.split('~');
			//var plantrdays = parseInt($("#nn .dp-numberPicker-input").val());
			for (var i = 0; i < exp_trval_cids.length-1; i++) 
			{
				var tr_data3 = tr_data2[i].split('-');
				var routeSegment = i + 1;
				summaryPanel.innerHTML += '<b>DAY: ' + routeSegment + '</b> &nbsp;';
				var date_read = moment($('#start_date'+i+'0').val()).format('MMMM Do YYYY, dddd');
				summaryPanel.innerHTML += '<b>('+date_read + ')</b> <br>';
				summaryPanel.innerHTML += tr_data3[0] + ' to ';
				summaryPanel.innerHTML += tr_data3[1] + '<br>';
				summaryPanel.innerHTML += 'Travel distance: '+tr_data3[2] + 'kms.' + '<br>';
				summaryPanel.innerHTML += 'Aproximative driving time: '+tr_data3[3]+'.<br><br>';
				/*dist_total.innerHTML = "<strong> Total travel distance: "+data.trav_totdist_ess + " kms. </strong>" + '<br>';
				total_days.innerHTML = "<strong> Travel days: "+plantrdays + "</strong>" + '<br>';*/
			}
			
			$('#veh_cit_dis').val(data.extdist);
			daytrip(agent_percnt,adm_percent);
			//alert(data.trav_totdist);
		}).error(function(jqXHR, textStatus, errorThrown) {
			alert(jqXHR.responseText);
    // Inspect the values of jqXHR, textStatus, errorThrown here.
});
}

function daytrip(agent_percnt,adm_percent)
{
	var dt_cid = $('#cid_arr').val();
	var dt_carr = dt_cid.split(',');
	dt_carr.pop();
	dt_carr.shift();
	var temp_dtid = ''; var dt_selid = ''; var new_dtarr = []; var uni_dtar = [];
	for(var dt1=0;dt1<dt_carr.length;dt1++)
	{
		if(dt_carr[dt1] == temp_dtid)
		{
			new_dtarr.push(dt_carr[dt1]);
		}
		temp_dtid = dt_carr[dt1];
	}
	uni_dtar = new_dtarr.filter(function(item, i, ar){ return ar.indexOf(item) === i; });
	var dtPanel = document.getElementById('dt_panel');
	
	if(uni_dtar.length > 0)
	{
		$.get('<?php echo "AGENT/day_trip.php"; ?>', { dt_ids: uni_dtar }, function(data) {
				
				//alert(data);
				//$("#dt_panel").html(data);
				dtPanel.innerHTML = data;
				$('.chosen-select').chosen({width:'100%'});
			}).error(function(jqXHR, textStatus, errorThrown) {
				alert(jqXHR.responseText);
		// Inspect the values of jqXHR, textStatus, errorThrown here.
		});
	}
	
	if($('#check_boxs').val()!='2')
	{
		$('#stay_plan11').show();
	}
	
	if($('#check_boxs').val() != '3')
	{
		$("#gmap_div1").show();
	}
	else
	{
		$("#gmap_div1").hide();
	}

	if($('#check_boxs').val() == '2')
	{
		$('#sun').show();
		$('#get_sts_quote').hide();
		if(uni_dtar.length > 0)
		{
			$('#show_distot').hide();
			$('#show_days').hide();
			$('#netamount').hide();
			$('#trav_quot').show();
			$('#dt_panel').show();
			$('#dt_citid').val(uni_dtar);
			$('#final_save_btn').hide();
			bestroute();
		}
		else
		{
			$('#dt_panel').hide();
			$('#show_distot').show();
			$('#show_days').show();
			$('#netamount').show();
			$('#trav_quot').hide();
			$('#dt_citid').val('');
			$('#dt_dist').val(0);
			$('#final_save_btn').show();
			
			$('#dt_panel select option').prop('selected',false).trigger('chosen:updated');
			bestroute();
			finalcall(1,agent_percnt,adm_percent);
		}
	}
	
	if($('#check_boxs').val() == '1')
	{
		$('#sun').show();
		$('#get_sts_quote').hide();
		if(uni_dtar.length > 0)
		{
			$('#show_distot').hide();
			$('#show_days').hide();
			$('#netamount').hide();
			$('#trav_quot').hide();
			$('#dt_panel').show();
			$('#dt_citid').val(uni_dtar);
			$('#final_save_btn').hide();
			bestroute();
		}
		else
		{
			$('#dt_panel').hide();
			$('#show_distot').show();
			$('#show_days').show();
			$('#netamount').hide();
			$('#trav_quot').hide();
			$('#dt_citid').val('');
			$('#dt_dist').val(0);
			$('#final_save_btn').hide();
			
			$('#dt_panel select option').prop('selected',false).trigger('chosen:updated');
			bestroute();
			//finalcall(1,agent_percnt,adm_percent);
		}
	}
}

function quote_dt(agent_percnt,adm_percent)
{
	var c_str = $('#cid_arr').val();
	var c_arr = c_str.split(',');
	c_arr.pop();
	c_arr.shift();
	var dt_detl; var spl_dtl; var dt_ssdist = 0; var dt_alltrdist = 0; var dt_allssdist = 0; var dt_alldist = 0; var dt_trdist = 0; var stor_dt = ''; var valid_dt; var chk_cnt_dt = 0;
	dtcnt = $('#dt_citid').val().split(',');
	//Validate the number of daytrip cities entered for each city
	for(var dt2=0;dt2<dtcnt.length;dt2++)
	{
		valid_dt = $("#sel_dtid"+dt2).val();
		if (valid_dt != null && valid_dt != '')
		{
			chk_cnt_dt = c_arr.reduce(function(n, val) 
			{
				return n + (val === dtcnt[dt2]);
			}, 0);
			chk_cnt_dt1 = parseInt(chk_cnt_dt)-1;
			if(valid_dt.length > chk_cnt_dt1)
			{
				spl_valid_dt = valid_dt[0].split('-');
				alertdt(chk_cnt_dt1, spl_valid_dt[3]);
				return false;
			}
			chk_cnt_dt1 = 0;
		}
		chk_cnt_dt1 = 0;
	}
	
	for(var dt3=0;dt3<dtcnt.length;dt3++)
	{
		dt_detl = $("#sel_dtid"+dt3).val();
		if (dt_detl != null && dt_detl != '')
		{
			for(var dt4=0;dt4<dt_detl.length;dt4++)
			{
				spl_detl = dt_detl[dt4].split('-');
				dt_trdist=spl_detl[1];
				dt_ssdist=spl_detl[2];
				dt_alltrdist+=parseInt(dt_trdist);
				dt_allssdist+=parseInt(dt_ssdist);
				stor_dt+= dtcnt[dt3]+'-'+spl_detl[0]+'-'+spl_detl[1]+'-'+spl_detl[2]+',';
				dt_alldist+=parseInt(dt_ssdist)+parseInt(dt_trdist)+parseInt(dt_trdist);
			}
		}
	}
	$('#dt_dist').val(dt_alldist);
	$('#dt_detls').val(stor_dt);
	$('#dt_altrdist').val(dt_alltrdist);
	$('#dt_alssdist').val(dt_allssdist);
//	alert(stor_dt);
//	alert(dt_alldist);
	finalcall(1,agent_percnt,adm_percent);
	$('#final_save_btn').show();
}

function finalcall(getf,agent_percnt,adm_percent)
{
	var getdt_dis = $('#dt_dist').val();
	var show_dist_ess = $('#traveldist_ess').val();
	var show_dt_ess = $('#dt_altrdist').val();
	if(getdt_dis > 0)
	{
		var all_dist = parseInt($('#traveldist').val()) + parseInt(getdt_dis);
		var show_trdist = parseInt(show_dist_ess) + parseInt(show_dt_ess);
	}
	else
	{
		var all_dist = $('#traveldist').val();
		var show_trdist = parseInt(show_dist_ess);
	}

	if (getf == 1)
	{
		vehrent(all_dist,1,agent_percnt,adm_percent,show_trdist);
	}
	else
	{
		vehrent(all_dist,0,agent_percnt,adm_percent,show_trdist);
	}
	
	$('#show_distot').show();
	$('#show_days').show();
	
	if($('#check_boxs').val() == '1')
	{
		$('#netamount').hide();
	}
	else
	{
		$('#netamount').show();
	}
}

function bestroute()
{
	$("#best_route tbody tr").remove(); 
	var tabl_data = '';
	var alldata = $('#formatdata').val();
	
	var alldata1 = alldata.replace(/,\s*$/, "");
	var alldata2 = alldata1.split('~');
	
	for (var incr=0;incr<alldata2.length-1;incr++)
	{
		var date_read1 = moment($('#start_date'+incr+'0').val()).format('MMMM Do YYYY, dddd');
		var alldata3 = alldata2[incr].split('-');
		tabl_data="<tr><td>"+date_read1+"</td><td>"+alldata3[0]+"</td><td>"+alldata3[1]+"</td><td>"+alldata3[2]+"</td><td>"+alldata3[3]+"</td></tr>";
		$(tabl_data).appendTo('#best_route');
	}
}

function calculateDistances(org1,des1,des2) 
{
	destination1=des1;
	destination2=des2;
	origin1=org1;
	geocoder = new google.maps.Geocoder();
	var service = new google.maps.DistanceMatrixService();
	service.getDistanceMatrix(
	{
		origins: [origin1],
		destinations: [destination1,destination2],
		travelMode: google.maps.TravelMode.DRIVING,
		unitSystem: google.maps.UnitSystem.METRIC,
		avoidHighways: false,
		avoidTolls: false
	},callback);
}

var distarr = [];
function callback(city)
{
	return function(response, status) 
	{
		var pushstr=''; 
		var spl_dist4=0; var spl_dist3 = 0; var spl_dist21 = 0; 
		
		if (status != google.maps.DistanceMatrixStatus.OK) 
		{
			alert('Error was: ' + status);
		}
		else
		{
			var origins = response.originAddresses;
			var destinations = response.destinationAddresses;
			var ji;
			
			for (var i = 0; i < origins.length; i++) 
			{
				var results = response.rows[i].elements;
				for (var j = 0; j < results.length; j++) 
				{
					var spl_dist11 = results[j].distance.text.split("km");
					
					if (spl_dist11[0] != '')
					{
						spl_dist21=spl_dist11[0].replace(/\,/g,'');
					}
					else
					{
						spl_dist21 = 1;
					}
					spl_dist3 = parseInt(spl_dist21);
					spl_dist4+=spl_dist3;
			      }
				distarr.push(city+'-'+spl_dist4);
				$("#callbackid").val($("#callbackid").val()+','+city+'-'+spl_dist4);
				spl_dist4=0;
		    }
		}
	}
}

var vehcnt = 0;
function vehrent(travdist,flag,agent_percnt,adm_percent,disp_trdist)
{
	if (flag == 0)
	{
		var ct_extdis = ''; var getfirst = ''; var getfirst1 = ''; var appndcity = ''; var callbackid1 = '';
		callbackid1 = $("#callbackid").val();
		getfirst = callbackid1.split(',');
		getfirst1 = getfirst[1].split('-');
		appndcity = $("#citarrid").val()+'-'+getfirst1[1];
		ct_extdis =callbackid1+','+appndcity;
	}
	else if (flag == 1)
	{
		var ct_extdis = '';
		ct_extdis = $('#veh_cit_dis').val();
	}
	var plandays = parseInt($("#nn .dp-numberPicker-input").val());
	var vehrental = ''; var myVehicle = new Array();
	
	for (var z=0;z<=veh_cnt;z++)
	{
		var vehname = $("#st_vehic"+z).val();
		var getcityid = $("#st_city").val();
		
		if (typeof(vehname) != "undefined" && vehname !== null)
		{
			if (vehname != '')
			{
				var vehsplit = $('#st_vehic'+z+' option:selected').text().split('~');
				var vehtyp = vehsplit[0];
				var vehsplit = vehname.split('-');
				var citysplit = getcityid.split('-');
				vehcnt++;
				myVehicle.push(z+'~'+vehsplit[0].trim()+'~'+citysplit[0].trim()+'~'+vehtyp);
			}
		}
	}
	//alert(JSON.stringify(myVehicle));
	$("#vehicles").val(myVehicle);
	var allcitids = $('#cid_arr').val();
	//alert(ct_extdis);
	if(myVehicle.length > 0)
	{
		
		$.getJSON('<?php echo "AGENT/rent_vehicl.php"; ?>', { arrsend: myVehicle, trdist: travdist, trdays: plandays, ext_dist: ct_extdis, allcids: allcitids }, function(data) {
			//alert("Value for 'detl': " + data.detl + "\nValue for 'retn': " + data.retn + "\nValue for 'netamt': " + data.netamt);
			//document.getElementById('show_rental').innerHTML=data.detl;
			$("#veh_upl").val(data.vehupl);
			$("#all_veh_upl").val(data.all_veh_rent);
			$("#ret_dist").val(data.retn);
			$("#tr_tot_amt").val(data.netamt);
			$("#pervehamt").val(data.pervehamt);
			$("#vehcitid").val(data.vehcitid);
			$("#permt_amt").val(data.tot_perm_amt);
			if ($('#check_boxs').val() == '2')
			{
				var dist_total = document.getElementById('show_distot');
				var total_days = document.getElementById('show_days');
				var plantrdays = parseInt($("#nn .dp-numberPicker-input").val());
				
				dist_total.innerHTML = "<strong> Total travel distance: "+disp_trdist+ " kms. </strong>" + '<br>';
				total_days.innerHTML = "<strong> Travel days: "+plantrdays + "</strong>" + '<br>';
				
				var net_tot = document.getElementById('netamount');
				net_tot.innerHTML = ''; var netamt1=parseInt(data.netamt);
				var admn_grand_tot = netamt1 + ((parseInt(adm_percent) / 100) * parseInt(netamt1));
				var agnt_grand_totl = parseInt(admn_grand_tot) + ((parseInt(agent_percnt) / 100) * parseInt(admn_grand_tot));
				net_tot.innerHTML+= "<strong>Net charge for your transport: Rs. "+Math.round(agnt_grand_totl) + "</strong>" + '<br>';
				var terms = "<br><br><strong><font color='red'>Terms & Conditions: </font></strong><br> <strong>Package  Includes:</strong><br>Transfers and sightseeing  By  deluxe  tourists vehicle <strong><font color='red'>( Vehicles up hill driving and down hill would be on Non AC)</font></strong><br>Toll & Parking <br>Service Taxes <br>All local sightseeing in the same vehicle, every day after breakfast till sunset ( 0700 AM to 08PM)<br><br>IMPORTANT: Kindly note that  vehicles  mentioned above only indicate that our rates have been based on usage of the locations and Kilometres  and it is not to be construed that the same vehicles will be provided if the vehicles are not available in the selected locations we shall provide from the different neareast availble location for the same rate may change (supplement/reduction whatever applicable). Unless until we  Dvi Holidays sends you the written confirmation from reservation the quote is not final.";
				
				document.getElementById('show_terms').innerHTML=terms;
			}
			else if ($('#check_boxs').val() == '1')
			{
				var dist_total = document.getElementById('show_distot');
				var total_days = document.getElementById('show_days');
				var plantrdays = parseInt($("#nn .dp-numberPicker-input").val());
				
				dist_total.innerHTML = "<strong> Total travel distance: "+disp_trdist+ " kms. </strong>" + '<br>';
				total_days.innerHTML = "<strong> Travel days: "+plantrdays + "</strong>" + '<br>';
				
				var net_tot = document.getElementById('netamount');
				net_tot.innerHTML = ''; var netamt1=parseInt(data.netamt);
				var admn_grand_tot = netamt1 + ((parseInt(adm_percent) / 100) * parseInt(netamt1));
				var agnt_grand_totl = parseInt(admn_grand_tot) + ((parseInt(agent_percnt) / 100) * parseInt(admn_grand_tot));
				net_tot.innerHTML+= "<strong>Net charge for your transport: Rs. "+Math.round(agnt_grand_totl) + "</strong>" + '<br>';
				view_stay_quote(<?php echo $agent_perc; ?>,<?php echo $agnt_adm_perc; ?>);
				show_get_quote();
			}
			
		}).error(function(jqXHR, textStatus, errorThrown) {
			alert(jqXHR.responseText);
    // Inspect the values of jqXHR, textStatus, errorThrown here.
});
	}
}

function validate()
{
	if ($('#guestname').val() == '' || $('#mobil').val() == '' || $('#arrdet').val() == '' || $('#depdet').val() == '') 
	{
		$('#formerr').text("Enter all fields information").show();
		return false;
	}
	return true;
}
function sendappr()
{
	swal({
		title: 'Send Itinerary for approval.. CONFIRM?',
		type: 'info',
		showCancelButton: true,
		confirmButtonClass: 'btn-info',
		confirmButtonText: 'Yes!',
		closeOnConfirm: false,
		},
		function(isConfirm) 
		{
			if (isConfirm) 
			{
				$("#trv_cnt").val($("#np .dp-numberPicker-input").val());
				$("#trv_days").val($("#nn .dp-numberPicker-input").val());
				$("#trv_nights").val($("#nd .dp-numberPicker-input").val());
				$("#trv_adult").val($("#na .dp-numberPicker-input").val());
				$("#trv_child").val($("#nc .dp-numberPicker-input").val());
				$("#trv_room").val($("#totrooms .dp-numberPicker-input").val());
				document.thplan.submit();
			}
			else
			{
				return false;
			}
		});
}

function alertdist(distdiff)
{
	var alerdist = distdiff.split('-');
	if(alerdist[3].trim() > 175)
	{
		swal("NOTE - The distance to your chosen departure airport/railway-station is "+alerdist[3].trim()+" kms. Hence request you to organize your travel accordingly for your smooth onward journey");
	}
}
function alertopt()
{
	swal("Dear Agent, \n Great!!! you have created a better itnerary, hence you can go ahead with your own itinerary  !!!! \n\n Best regards - DVI Team");
}

function alertdt(allow_cnt, dt_cit)
{
	swal("Dear <?php echo $user_fname; ?>, Only "+allow_cnt+" daytrip city allowed for "+dt_cit+".\n Please deselect the other cities");
}

function hidesave()
{
	$('#final_save_btn').hide();
}

</script>