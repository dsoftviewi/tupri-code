<?php

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
	$agent_perc = 0; $agnt_adm_perc = $row_distrbut['my_percentage'];
}
if(isset ($_POST['tot_num_of_form']) && trim($_POST['tot_num_of_form'])!='')
{
$num_form=trim($_POST['tot_num_of_form']);
error_log("numform".$num_form,3,"eLog.txt");
$num_of_itinerary='';
$num_of_itin_cost=0;

	$common_id='';
for($frm=0;$frm<=$num_form;$frm++)
{
	$fr="br".$frm;
	if(isset($_POST['arrdate_'.$fr]) && trim($_POST['arrdate_'.$fr])!='')
	{
	
	$tr_veh = ''; $tr_vehnm = '';
	$tr_cnt = $_POST[$fr.'_trv_cnt'];
	$arr_dt = $_POST['arrdate_'.$fr];
	$arr_tm = $_POST['arrtime_'.$fr];
	$arr_city = $_POST[$fr.'_st_city0'];
	$exp_arrcit = explode('-', $arr_city);
	$trim_cityid = trim($exp_arrcit[0]);
	$vehicles = $_POST[$fr.'_vehicles'];
	$impveh = implode(',',$vehicles);
	//echo "FFF ".$impveh;
	$expveh = explode(',',$impveh);
	$pervehamt = $_POST[$fr.'_pervehamt'];
	//$exp_perveh = explode('-',$pervehamt);
	
	$vehcitid = $_POST[$fr.'_vehcitid'];
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
	$tr_days = $_POST[$fr.'_trv_days'];
	$tr_nights = $_POST[$fr.'_trv_nights'];
	$adult_cnt = $_POST[$fr.'_trv_adult'];
	$child_cnt = $_POST[$fr.'_trv_child'];
	$room_cnt = $_POST[$fr.'_trv_room'];
	$dest_city = $_POST[$fr.'_dest_id'];
	$trav_dist = $_POST[$fr.'_traveldist'];
	$trav_dist_ess = $_POST[$fr.'_traveldist_ess'];
	$return_dis = $_POST[$fr.'_ret_dist'];
	$net_tr_dist = $trav_dist + $return_dis;
	$tr_tot_amt = $_POST[$fr.'_tr_tot_amt'];
	$ch512=$_POST['num_chd512_'.$fr];
	$addrate_for=$adult_cnt+$ch512;
	
	//if cond for traval
		//echo 'Travel Only';
		
		if($_GET['checkboxx']==2)
		{
		
		
		$tgenid = $conn->prepare("SELECT * FROM setting_ids  where sno = '12'");
		$tgenid->execute();
		$row_tgenid =$tgenid->fetch(PDO::FETCH_ASSOC);
	
		$tid=$row_tgenid['id_name'].$row_tgenid['id_number'];
		$tidin=$row_tgenid['id_number']+1;
		
		//Get Day trip details if applicable
		$dt_totdis = $_POST[$fr.'_dt_dist'];
		
		if($dt_totdis > 0)
		{
			$dt_detls = $_POST[$fr.'_dt_detls'];
			$dt_cid   = $_POST[$fr.'_dt_citid'];
			$dt_trdist_ess   = $_POST[$fr.'_dt_altrdist'];
			$dt_ss_dist   = $_POST[$fr.'_dt_alssdist'];
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
		
		$allper_amt1 = $_POST[$fr.'_permt_amt'];
		$allper_amt = explode('-',$allper_amt1);
		
		$agnt_grnd_adm = $tr_tot_amt + ($tr_tot_amt * ($agnt_adm_perc / 100));
		$agnt_grnd_tot = $agnt_grnd_adm + ($agnt_grnd_adm * ($agent_perc / 100));

				$currency_rate=0;
		$is_conver_currency = is_conver_currency();
		if($is_conver_currency){	
		$currencydb = $conn->prepare("SELECT currency_rate FROM dvi_front_settings WHERE sno =1");
		$currencydb->execute();
		$row_currencydb = $currencydb->fetch(PDO::FETCH_ASSOC);
		$currency_rate = $row_currencydb['currency_rate'];
		}

		 $insertSQL1 = $conn->prepare("INSERT INTO travel_master (plan_id, agent_id, distr_id, tr_name, tr_mobile, tr_arrdet, tr_depdet, pax_cnt, tr_arr_date, tr_arr_time, trv_depatr_time, pax_adults, pax_child, tr_days, tr_nights, arr_cityid, dest_cityid, tr_vehids, tr_vehname, tr_veh_cityid, veh_tot_rent, dt_cid, dt_detls, tot_tr_dist, tot_tr_dist_ess, dt_tot_dist, dt_trdist_ess, dt_ss_dist, tr_return_dist, net_tr_dist, perm_cityid, permit_amt, tr_net_amt, stay_rooms, stay_tot_amt, grand_tot, agent_perc, agnt_grand_tot, agnt_adm_perc, date_of_reg, status, currency_rate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0,?,?,?,?,?, '5',?)");
		 $insertSQL1->execute(array($tid,$agent_id,$distr_id,$tid,$_POST['mobil'],$_POST['arrdet'],$_POST['depdet'],$tr_cnt,$arr_dt,$arr_tm,$_POST['depart_time_'.$fr],$adult_cnt,$child_cnt,$tr_days,$tr_nights,$trim_cityid,$dest_city,$tr_veh,$tr_vehnm,$vehcitid,$pervehamt,$dt_cid,$dt_detls,$trav_dist,$trav_dist_ess,$dt_alldist,$dt_trdist_ess,$dt_ss_dist,$return_dis,$net_tr_dist,$allper_amt[0],$allper_amt[1],$tr_tot_amt,$room_cnt,$tr_tot_amt,$agent_perc,$agnt_grnd_tot,$agnt_adm_perc,$booking_date,$currency_rate));
	
	
		$itiner_city = $_POST[$fr.'_citydata'];
		//$tr_dates = $_POST['start_date'];
		
		
		$itiner_city1 = implode(',', $itiner_city);
		$itiner_city2 = explode(',', $itiner_city1);
		
//count($itiner_city2);
		for ($detl_itn=0;$detl_itn<count($itiner_city2);$detl_itn++)
		{
			$tr_dates = $_POST[$fr.'_start_date'.$detl_itn];
			$exp_itin_city = explode('-', $itiner_city2[$detl_itn]);
			$ssdist = $exp_itin_city[4] - $exp_itin_city[2];
			
			$ssddate=date("Y-m-d",strtotime($tr_dates));
			$trvia='-';
			if(isset($_POST['sel_via_trav_cids_'.$detl_itn.'_'.$fr]))
			{
				$trvia=	$_POST['sel_via_trav_cids_'.$detl_itn.'_'.$fr];
			}
			
			$addi_cst_name='';
			$addi_cst_amt='';
			if(isset($_POST['addi_sno_'.$ssddate]) && $_POST['addi_sno_'.$ssddate]=='')
			{
				$addi_cst_arry=explode(',',$_POST['addi_sno_'.$ssddate]);
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
				$addi_cst_amt=$_POST['addi_cst_'.$ssddate];
			}
			
			//rough work start
			if(!isset($_POST['trav_times'.$detl_itn]))
			{
				$_POST['trav_times'.$detl_itn]="";	
			}
			//rough work start
			
			$insertSQL2 = $conn->prepare("INSERT INTO travel_sched (travel_id, tr_date, tr_from_cityid, tr_to_cityid, via_cities, ss_dist, tr_dist_ss, tr_dist_ess, tr_time, addi_cost_for, addi_amount, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,1)");
			$insertSQL2->execute(array($tid,$ssddate,$exp_itin_city[0],$exp_itin_city[1],$trvia,$ssdist,$exp_itin_city[4],$exp_itin_city[2],$_POST['trav_times'.$detl_itn],$addi_cst_name,$addi_cst_amt));
			error_log("travelsched2",3,"eLog.txt");
		}
		
		$veh_upl = $_POST[$fr.'_veh_upl'];
		$veh_upl1 = explode('/',$veh_upl);
		
		for($vcnt=0;$vcnt<count($veh_upl1)-1;$vcnt++)
		{
			$veh_upl2 = explode('-',$veh_upl1[$vcnt]);
			error_log(print_r($veh_upl1,true));
			$insertSQL5 = $conn->prepare("INSERT INTO travel_vehicle (travel_id, vehicle_id, rent_transfer, arr_day, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,1)");
			$insertSQL5->execute(array($tid,$veh_upl2[0],$veh_upl2[1],$veh_upl2[2],$veh_upl2[3],$veh_upl2[4],$veh_upl2[5],$veh_upl2[6],$veh_upl2[7],$veh_upl2[8],$veh_upl2[9],$veh_upl2[10],$veh_upl2[11]));
		}
		
		//Insert All travel vehicles from every city's info
		
		$allveh_detl = $_POST[$fr.'_all_veh_upl'];
		$exp_allveh = explode('~',$allveh_detl);
		
		foreach($exp_allveh as $each_veh_det)
		{
			$exp_each_veh = explode('#', $each_veh_det);
			$each_cityid = $exp_each_veh[0];
			
			$exp_get_veh = explode('/', $exp_each_veh[1]);
			
			for($evcnt=0;$evcnt<count($exp_get_veh)-1;$evcnt++)
			{
				$each_veh_upl = explode('-',$exp_get_veh[$evcnt]);
				error_log(print_r($veh_upl1,true));
				$insertSQL6 = $conn->prepare("INSERT INTO dvi_trans_rpt (travel_id, city_id, vehicle_id, rent_transfer, arr_day, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)");
				$insertSQL6->execute(array($tid,$each_cityid,$each_veh_upl[0],$each_veh_upl[1],$each_veh_upl[2],$each_veh_upl[3],$each_veh_upl[4],$each_veh_upl[5],$each_veh_upl[6],$each_veh_upl[7],$each_veh_upl[8],$each_veh_upl[9],$each_veh_upl[10],$each_veh_upl[11]));
			}
		}
		
		$tupd_id=$conn->prepare("UPDATE setting_ids set id_number=? where sno = '12'");
		$tupd_id->execute(array($tidin));
		
		$common_id=$tid;
					if($num_of_itinerary=='')
					{
							$num_of_itinerary=$tid;
							echo $_SESSION['com_plan_id']=$common_id;
					}else{
						$num_of_itinerary=$num_of_itinerary."-".$tid;
					}
						$_SESSION['com_sub_plan_id']=$num_of_itinerary;
						
						
						//echo $frm."SUB_PLAN=".$num_of_itinerary;
						
						if($num_form==$frm)
						{
							$sub_paln=$conn->prepare("UPDATE travel_master set sub_paln_id=? where plan_id=?");
							$sub_paln->execute(array($num_of_itinerary,$_SESSION['com_plan_id']));	
						}

		}//for travel only
		else if($_GET['checkboxx']=='1')
		{
			error_log("CheckBox1",3,"eLog.txt");
	//for transpot+hotel
		$adult_cnt =$_POST['num_traveller_'.$fr];
		$child_cnt =$_POST['num_chd_b5_'.$fr];
		$child512_no_cnt=(int)$_POST['num_chd512_'.$fr];
		//echo "traval + hotel";
		
		$genid = $conn->prepare("SELECT * FROM setting_ids where sno = '11'");
		$genid->execute();
		$row_genid = $genid->fetch(PDO::FETCH_ASSOC);
		
		$id=$row_genid['id_name'].$row_genid['id_number'];
		$idin=$row_genid['id_number']+1;
		
		//Get Day trip details if applicable
		$dt_totdis = $_POST[$fr.'_dt_dist'];
		
		if($dt_totdis > 0)
		{
			$dt_detls = $_POST[$fr.'_dt_detls'];
			$dt_cid   = $_POST[$fr.'_dt_citid'];
			$dt_trdist_ess   = $_POST[$fr.'_dt_altrdist'];
			$dt_ss_dist   = $_POST[$fr.'_dt_alssdist'];
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
		
		$allper_amt1 = $_POST[$fr.'_permt_amt'];
		$allper_amt = explode('-',$allper_amt1);
		if(!isset($allper_amt[0]))
			$allper_amt[0]=0;
		if(!isset($allper_amt[1]))
			$allper_amt[1]=0;
		$itiner_city = $_POST[$fr.'_citydata'];
		//$tr_dates = $_POST['start_date'];
		$itiner_city1 = implode(',', $itiner_city);
		$itiner_city2 = explode(',', $itiner_city1);
		
		error_log(print_r($_POST[$fr.'_citydata'],true),3,"eLog.txt");
		//echo count($itiner_city2);
		for ($detl_itn=0;$detl_itn<count($itiner_city2);$detl_itn++)
		{
			$tr_dates=$_POST[$fr.'_start_date'.$detl_itn];
			$exp_itin_city = explode('-', $itiner_city2[$detl_itn]);
			$ssdist = $exp_itin_city[4] - $exp_itin_city[2];
			
			$ssddate=date("Y-m-d",strtotime($tr_dates));
			
			$trvia='-';
			if(isset($_POST['sel_via_trav_cids_'.$detl_itn.'_'.$fr]))
			{
				$trvia=	$_POST['sel_via_trav_cids_'.$detl_itn.'_'.$fr];
			}
			
			$insertSQL2 = $conn->prepare("INSERT INTO travel_sched (travel_id, tr_date, tr_from_cityid, tr_to_cityid, via_cities, ss_dist, tr_dist_ss, tr_dist_ess, tr_time, status) VALUES (?,?,?,?,?,?,?,?,?, 1)");
			 
			$insertSQL2->execute(array($id,$ssddate,$exp_itin_city[0],$exp_itin_city[1],$trvia,$ssdist,$exp_itin_city[4],$exp_itin_city[2],$_POST['trav_times'.$detl_itn]));
			error_log(print_r(array($id,$ssddate,$exp_itin_city[0],$exp_itin_city[1],$trvia,$ssdist,$exp_itin_city[4],$exp_itin_city[2],$_POST['trav_times'.$detl_itn]),true),3,"eLog.txt");
			error_log("CheckBox1",3,"eLog.txt");
			error_log("travelsched1",3,"eLog.txt");
			
			
		}
		
		//for hotel+traval 
		
		$par=$_POST['num_tranight_'.$fr];
		$child=$_POST['num_room_htls_'.$fr];
		
		$cityy1=explode(',',$_POST[$fr.'_kit_cityidd']);
		 
		$totalday_amtcal=0;
		$grant_ttttol=$tr_tot_amt+$totalday_amtcal;
		
		$agnt_grnd_adm = $grant_ttttol + ($grant_ttttol * ($agnt_adm_perc / 100));
		$agnt_grnd_tot = $agnt_grnd_adm + ($agnt_grnd_adm * ($agent_perc / 100));

		//$my_name=$_POST['gtitle'].". ".$_POST['guestname'];
		$currency_rate=0;
		$is_conver_currency = is_conver_currency();
		if($is_conver_currency){	
		$currencydb = $conn->prepare("SELECT currency_rate FROM dvi_front_settings WHERE sno =1");
		$currencydb->execute();
		$row_currencydb = $currencydb->fetch(PDO::FETCH_ASSOC);
		$currency_rate = $row_currencydb['currency_rate'];
		}
		$insertSQL1 = $conn->prepare("INSERT INTO travel_master (plan_id, agent_id, distr_id, tr_name, tr_mobile, tr_arrdet, tr_depdet, pax_cnt, tr_arr_date, tr_arr_time, trv_depatr_time, pax_adults, pax_512child, pax_child, tr_days, tr_nights, arr_cityid, dest_cityid, tr_vehids, tr_vehname, tr_veh_cityid, veh_tot_rent, dt_cid, dt_detls, tot_tr_dist, tot_tr_dist_ess, dt_tot_dist, dt_trdist_ess, dt_ss_dist, tr_return_dist, net_tr_dist, perm_cityid, permit_amt, tr_net_amt, stay_rooms, stay_tot_amt, grand_tot, agent_perc, agnt_grand_tot, agnt_adm_perc, date_of_reg, status, currency_rate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, '5',?)");
		$insertSQL1->execute(array($id,$agent_id,$distr_id,$id,$_POST['mobil'],$_POST['arrdet'],$_POST['depdet'],$tr_cnt,$arr_dt,$arr_tm,$_POST['depart_time_'.$fr],$adult_cnt,$child512_no_cnt,$child_cnt,$tr_days,$tr_nights,$trim_cityid,$dest_city,$tr_veh,$tr_vehnm,$vehcitid,$pervehamt,$dt_cid,$dt_detls,$trav_dist,$trav_dist_ess,$dt_alldist,$dt_trdist_ess,$dt_ss_dist,$return_dis,$net_tr_dist,$allper_amt[0],$allper_amt[1],$tr_tot_amt,$room_cnt,$totalday_amtcal,$grant_ttttol,$agent_perc,$agnt_grnd_tot,$agnt_adm_perc,$booking_date,$currency_rate));
	
		$veh_upl = $_POST[$fr.'_veh_upl'];
		$veh_upl1 = explode('/',$veh_upl);
		
		for($vcnt=0;$vcnt<count($veh_upl1)-1;$vcnt++)
		{
			$veh_upl2 = explode('-',$veh_upl1[$vcnt]);
			//echo "<br>";
			//print_r($veh_upl2);
	
			$insertSQL5 = $conn->prepare("INSERT INTO travel_vehicle (travel_id, vehicle_id, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,  ?, ?, 1)");
			$insertSQL5->execute(array($id,$veh_upl2[0],$veh_upl2[1],$veh_upl2[2],$veh_upl2[3],$veh_upl2[4],$veh_upl2[5],$veh_upl2[6],$veh_upl2[7],$veh_upl2[8],$veh_upl2[9]));
		}
		
		//Insert All travel vehicles from every city's info
		
		$allveh_detl = $_POST[$fr.'_all_veh_upl'];
		$exp_allveh = explode('~',$allveh_detl);
		
		foreach($exp_allveh as $each_veh_det)
		{
			$exp_each_veh = explode('#', $each_veh_det);
			$each_cityid = $exp_each_veh[0];
			
			$exp_get_veh = explode('/', $exp_each_veh[1]);
			
			for($evcnt=0;$evcnt<count($exp_get_veh)-1;$evcnt++)
			{
				$each_veh_upl = explode('-',$exp_get_veh[$evcnt]);
/*
				$rent_transfer = 	$each_veh_upl[3];
				$arr = 	$each_veh_upl[4];
				unset($each_veh_upl[3]); unset($each_veh_upl[4]);
*/
	$insertSQL6 = $conn->prepare("INSERT INTO dvi_trans_rpt (travel_id, city_id, vehicle_id, rent_day, max_km_day, rent_per_km, return_dist, tot_dist, max_allwd_km, exceed_km, permit_amt, rent_amt, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
				$insertSQL6->execute(array($id,$each_cityid,$each_veh_upl[0],$each_veh_upl[1],$each_veh_upl[2],$each_veh_upl[3],$each_veh_upl[4],$each_veh_upl[5],$each_veh_upl[6],$each_veh_upl[7],$each_veh_upl[8],$each_veh_upl[9]));
				

			}
		}
		
		$upd_id=$conn->prepare("UPDATE setting_ids SET id_number=? where sno = '11'");
		$upd_id->execute(array($idin));
			
		//echo  $_SESSION['com_plan_id']=$common_id=$id;
		
					if($num_of_itinerary=='')
					{
							$num_of_itinerary=$id;
							echo $_SESSION['com_plan_id']=$common_id=$id;
					}else{
						$num_of_itinerary=$num_of_itinerary."-".$id;
					}
						$_SESSION['com_sub_plan_id']=$num_of_itinerary;
						
						
						//echo $frm."SUB_PLAN=".$num_of_itinerary;
						
						
		}
	}//live or not loop
						if($num_form==$frm)
						{
							$sub_paln=$conn->prepare("UPDATE travel_master set sub_paln_id=? where plan_id=?");
							$sub_paln->execute(array($num_of_itinerary,$_SESSION['com_plan_id']));	
						}


}//tot form loop
}
?>