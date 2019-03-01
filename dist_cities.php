<?php

require_once('../Connections/divdb.php');

if ($_GET['route_type'] == 'm')
{
	$arrcid = $_GET['allcids'];
	$arrveh_cid = $_GET['vehcitids'];
	$last_chk = $_GET['last_chk'];
	
	$extdis_arr = array();
	//$extdis_uniq = array();
	
	$trav_dist = ''; $tot_dist = 0; $trav_dist_ess = ''; $tot_dist_ess = 0;
	for ($a=0;$a<count($arrcid)-1;$a++)
	{
		$b = $a + 1;
		
		
		$citdist1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
		$citdist1->execute(array($arrcid[$a],$arrcid[$b]));
		$row_citdist1 = $citdist1->fetch(PDO::FETCH_ASSOC);
		$totalRows_citdist1 = $citdist1->rowCount();
		
		if($totalRows_citdist1 > 0)
		{
			
			$ss1 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
			$ss1->execute(array($arrcid[$b]));
			$row_ss1 = $ss1->fetch(PDO::FETCH_ASSOC);
			$totalRows_ss1 = $ss1->rowCount();
			
			$trav_dist.= ','.($row_citdist1['dist']+$row_ss1['ss_dist']);
			$tot_dist+=$row_citdist1['dist']+$row_ss1['ss_dist'];
			
			$trav_dist_ess.= ','.$row_citdist1['dist'];
			$tot_dist_ess+=$row_citdist1['dist'];
		}
		else
		{
			
			$citdist2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
			$citdist2->execute(array($arrcid[$b],$arrcid[$a]));
			$row_citdist2 = $citdist2->fetch(PDO::FETCH_ASSOC);
			$totalRows_citdist2 = $citdist2->rowCount();
			
			if($totalRows_citdist2 > 0)
			{
				
				$ss2 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
				$ss2->execute(array($arrcid[$b]));
				$row_ss2 = $ss2->fetch(PDO::FETCH_ASSOC);
				$totalRows_ss2 =$ss2->rowCount();
			
				$trav_dist.= ','.($row_citdist2['dist']+$row_ss2['ss_dist']);
				$tot_dist+=$row_citdist2['dist']+$row_ss2['ss_dist'];
				
				$trav_dist_ess.= ','.$row_citdist2['dist'];
				$tot_dist_ess+=$row_citdist2['dist'];
			}
		}
	}
	
	$trav_dist = trim($trav_dist,',');
	$trav_dist_ess = trim($trav_dist_ess,',');
	
	//Calculate extra distance taken for vehicle from each city
	$cnt_arrveh = count($arrveh_cid);	
	
	$org_cit_veh = $arrveh_cid[0];
	$dest_cit_veh = $arrveh_cid[$cnt_arrveh-1];
	$st_extdis = 0;
	if ($org_cit_veh != $dest_cit_veh)
	{
		
		$exdis1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
		$exdis1->execute(array($org_cit_veh,$dest_cit_veh));
		$row_exdis1 = $exdis1->fetch(PDO::FETCH_ASSOC);
		$totalRows_exdis1 = $exdis1->rowCount();
		
		if ($totalRows_exdis1 > 0)
		{
			$st_extdis = $row_exdis1['dist'];
		}
		else
		{
			
			$exdis2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
			$exdis2->execute(array($dest_cit_veh,$org_cit_veh));
			$row_exdis2 = $exdis2->fetch(PDO::FETCH_ASSOC);
			$totalRows_exdis2 =$exdis2->rowCount();
			
			if ($totalRows_exdis2 > 0)
			{
				$st_extdis = $row_exdis2['dist'];
			}
		}
	}
	else
	{
		$st_extdis = 0;
	}
	array_push($extdis_arr,$org_cit_veh.'-'.$st_extdis);
	
	if($cnt_arrveh > 2)
	{
		$cal_ext1 = 0; $cal_ext1 = 0;
		for($m=1;$m<count($arrveh_cid)-1;$m++)
		{
			
			$exdis1a = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid = ?");
			$exdis1a->execute(array($arrveh_cid[$m],$org_cit_veh));
			$row_exdis1a = $exdis1a->fetch(PDO::FETCH_ASSOC);
			$totalRows_exdis1a = $exdis1a->rowCount();
			
			if($totalRows_exdis1a > 0)
			{
				$cal_ext1 = $row_exdis1a['dist'];
			}
			else
			{
				
				$exdis1b = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
				$exdis1b->execute(array($org_cit_veh,$arrveh_cid[$m]));
				$row_exdis1b = $exdis1b->fetch(PDO::FETCH_ASSOC);
				$totalRows_exdis1b = $exdis1b->rowCount();
				
				if($totalRows_exdis1b > 0)
				{
					$cal_ext1 = $row_exdis1b['dist'];
				}
			}
			
			
			$exdis1c = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid = ?");
			$exdis1c->execute(array($arrveh_cid[$m],$dest_cit_veh));
			$row_exdis1c = $exdis1c->fetch(PDO::FETCH_ASSOC);
			$totalRows_exdis1c = $exdis1c->rowCount();
			
			if($totalRows_exdis1c > 0)
			{
				$cal_ext1+= $row_exdis1c['dist'];
			}
			else
			{
				
				$exdis1d = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
				$exdis1d->execute(array($dest_cit_veh,$arrveh_cid[$m]));
				$row_exdis1d = $exdis1d->fetch(PDO::FETCH_ASSOC);
				$totalRows_exdis1d = $exdis1d->rowCount();
				
				if($totalRows_exdis1d > 0)
				{
					$cal_ext1+= $row_exdis1d['dist'];
				}
			}
			
			array_push($extdis_arr,$arrveh_cid[$m].'-'.$cal_ext1);
			$cal_ext1 = 0;
		}
	}
	
	//$extdis_uniq = array_map("unserialize", array_unique(array_map("serialize", $extdis_arr)));
	if ($last_chk == 'y')
	{
		array_push($extdis_arr,$dest_cit_veh.'-'.$st_extdis);
	}
	
	$extdis_uniq1 = array_unique($extdis_arr, SORT_REGULAR);
	$extdis_str = ''; $extdis_str1 = '';
	$extdis_uniq = array_values($extdis_uniq1);
	//$temp2 = $extdis_uniq[1];
	for($l=0;$l<count($extdis_uniq);$l++)
	{
		$extdis_str.=','.$extdis_uniq[$l];
	}
	
	$cit_ord = '';
	foreach($arrcid as $sepcit)
	{
		$cit_ord.= ','.$sepcit;
	}
	$cit_ord = ltrim($cit_ord,',');
	$extdis_str=trim($extdis_str,',');
	
	/*for($l1=0;$l1<count($extdis_arr);$l1++)
	{
		$extdis_str1.=','.$extdis_arr[$l1];
	}
	*/
	
	$cit_optid1='';
$city_opt_nnn1='';
	$cit_optord1=explode(',',$cit_ord);
	
	if(count($cit_optord1)>2)
	{
			for($opt_id=1;$opt_id<count($cit_optord1);$opt_id++)
			{
				if($opt_id != count($cit_optord1)-1)
				{
					$cit_optid1[$opt_id-1]=$cit_optord1[$opt_id];
					
						
					$cnames = $conn->prepare("SELECT * FROM dvi_cities where id=?");
					$cnames->execute(array($cit_optord1[$opt_id]));
					$row_cnames = $cnames->fetch(PDO::FETCH_ASSOC);
					$totalRows_cnames = $cnames->rowCount();
					
					if($city_opt_nnn1=='')
					{
						$city_opt_nnn1=$row_cnames['name'];
					}else{
						$city_opt_nnn1=$city_opt_nnn1.','.$row_cnames['name'];
					}
				}
			}
			$cit_optid2=implode(',',$cit_optid1);
	}else{
		$cit_optid2='';
	}
	
	function convertToHoursMins($time, $format = '%d:%d') 
	{
		settype($time, 'integer');
		if ($time < 1) 
		{
			return;
		}
    	$hours = floor($time / 60);
    	$minutes = ($time % 60);
    	return sprintf($format, $hours, $minutes);
	}
	$time_taken = '';
	$exp_dis_ord = explode(',',$trav_dist_ess);
	for($timcnt=0;$timcnt<count($exp_dis_ord);$timcnt++)
	{
		$time_cvt = $exp_dis_ord[$timcnt] / 50;
		$time_cvt1 = $time_cvt * 60;
		$time_taken.=','.convertToHoursMins($time_cvt1, '%02d hours %02d minutes'); // should output in format 4 hours 17 minutes
	}
	
	$frmt_time = substr($time_taken,1);
	
	
	echo json_encode(array("trav_dist" => "$trav_dist", "trav_dist_ess" => "$trav_dist_ess", "trav_totdist" => "$tot_dist", "trav_totdist_ess" => "$tot_dist_ess", "extdist" => "$extdis_str", "frmt_time" => "$frmt_time", "cit_ord" => "$cit_ord", "cit_opt_idd" => "$cit_optid2","cit_optnnmm" => "$city_opt_nnn1")); 
}
elseif ($_GET['route_type'] == 'o')
{
	$arrcid = $arrcid1 = $_GET['allcids'];
	$arrveh_cid = $_GET['vehcitids'];
	$last_chk = $_GET['last_chk'];
	$v=1; $sh_cid = '';
	$reord = array();
	//print_r($arrcid);
	
	if($arrcid[0] == $arrcid[count($arrcid)-1])
	{
		if (count(array_unique($arrcid)) === 1 && end($arrcid) === $arrcid1[0]) 
		{
			$reord = $arrcid;
		}
		else
		{
			sort($arrcid); $cnt_el = 0;
			$counts = array_count_values($arrcid);
			$num_fl = $counts[$arrcid1[0]];
			if ($num_fl == 2)
			{
				foreach($arrcid as $valueKey =>$eachcit)
				{
					if ($eachcit == $arrcid1[0])
					{
						unset($arrcid[$valueKey]);
						$cnt_el++;
					}
				}
				array_unshift($arrcid, $arrcid1[0]);
				array_push($arrcid, $arrcid1[0]);
				$reord = array_values($arrcid);
			}
			elseif($num_fl > 2)
			{
				foreach($arrcid as $valueKey =>$eachcit)
				{
					if ($eachcit == $arrcid1[0])
					{
						unset($arrcid[$valueKey]);
						$cnt_el++;
					}
				}
				for($addel=0;$addel<($cnt_el-1);$addel++)
				{
					array_unshift($arrcid, $arrcid1[0]);
				}
				array_push($arrcid, $arrcid1[0]);
				$reord = array_values($arrcid);
			}
		}
	}
	else
	{
		sort($arrcid); $cnt_el = 0;
		//print_r($arrcid);
		if ($arrcid[0] != $arrcid1[0])
		{
			foreach($arrcid as $valueKey =>$eachcit)
			{
				if ($eachcit == $arrcid1[0])
				{
					unset($arrcid[$valueKey]);
					$cnt_el++;
				}
			}
		}
		
		for($addel=0;$addel<$cnt_el;$addel++)
		{
			array_unshift($arrcid, $arrcid1[0]);
		}
		
		$reord = array_values($arrcid);
		//print_r($reord);
		$cnt_el1 = 0;
		if ($reord[count($reord)-1] != $arrcid1[count($arrcid1)-1])
		{
			foreach($reord as $valueKey1 =>$eachcit1)
			{
				if ($eachcit1 == $arrcid1[count($arrcid1)-1])
				{
					unset($reord[$valueKey1]);
					$cnt_el1++;
				}
			}
		}
		
		for($addel1=0;$addel1<$cnt_el1;$addel1++)
		{
			array_push($reord, $arrcid1[count($arrcid1)-1]);
		}
	}
	
	$reord1 = array_values($reord);
	//print_r($reord1);
	unset($arrcid);
	$arrcid = array();
	
	foreach($reord1 as $cid_elem)
	{
		array_push($arrcid,$cid_elem);
	}
	
	//$arrcid=array_reverse($arrcid);
	//print_r($arrcid);
	if($arrcid[0] != $arrcid[count($arrcid)-1])
	{
		$lst_item = $arrcid[count($arrcid)-1];
		$find_litem = array_count_values($arrcid);
		$count_litm = $find_litem[$lst_item];
		$count_litm1 = count($arrcid) - $count_litm;
		
		$fst_item = $arrcid[0];
		$find_fitem = array_count_values($arrcid);
		$count_fitm = $find_fitem[$fst_item];
		$count_fitm1 = $count_fitm - 1;
	}
	else
	{
		$count_fitm = 0; $count_litm = 0;
		for($cc=0;$cc<count($arrcid)-1;$cc++)
		{
			if($arrcid[$cc] == $arrcid[0])
			{
				$count_fitm++;
			}
			else
			{
				$cc = count($arrcid)+1;
			}
		}
		
		for($dd=count($arrcid)-1;$dd>=0;$dd--)
		{
			if($arrcid[$dd] == $arrcid[0])
			{
				$count_litm++;
			}
			else
			{
				$dd = -1;
			}
		}
	}
	
	//get cities between start and end points
	
	$fin_arrcid = array();
	
	for ($waypt=$count_fitm;$waypt<count($arrcid)-$count_litm;$waypt++)
	{
		array_push($fin_arrcid,$arrcid[$waypt]);
	}
	
	//permutation of all waypoint cities
	
	$pass_arrcid = array();
	function pc_permute($items, $perms = array()) 
	{
		if (empty($items)) 
		{
			//echo join(' ', $perms) . "<br />";
			//print_r($perms).'<br>';
			$addperms = ''; global $pass_arrcid;
			foreach($perms as $permval)
			{
				$addperms.=','.$permval;
			}
			$addperms = ltrim($addperms,',');
			
			array_push($pass_arrcid,$addperms);
			
		}
		else
		{
			for ($i = count($items) - 1; $i >= 0; --$i) 
			{
				$newitems = $items;
				$newperms = $perms;
				list($foo) = array_splice($newitems, $i, 1);
				array_unshift($newperms, $foo);
				pc_permute($newitems, $newperms);
			}
		}
	}
	$comp_flag = '';
	//print_r($fin_arrcid);
	if (!empty($fin_arrcid))
	{
		if(count($arrcid1) <= 7)
		{
			pc_permute($fin_arrcid);
			
			$addfitms = ''; $addlitms = '';
			for($fc=0;$fc<$count_fitm;$fc++)
			{
				$addfitms.=$arrcid[0].',';
			}
			
			for($lc=0;$lc<$count_litm;$lc++)
			{
				$addlitms.=','.$arrcid[count($arrcid)-1];
			}
			
			for($pscnt=0;$pscnt<count($pass_arrcid);$pscnt++)
			{
				$pass_arrcid[$pscnt] = $addfitms.$pass_arrcid[$pscnt];
				$pass_arrcid[$pscnt].= $addlitms;
			}
		}
		else
		{
			$comp_flag = 'y';
			$fin_arrcid_bk = $fin_arrcid;
			$fin_arrcid_cnt = array_count_values($fin_arrcid);
			//print_r($fin_arrcid_cnt);
			$fin_arrcid_un = array_unique($fin_arrcid);
			
			$fin_arrcid_ord1 = array_values($fin_arrcid_un);
			
			array_unshift($fin_arrcid_ord1, $arrcid1[0]);
			
			array_push($fin_arrcid_ord1, $arrcid1[count($arrcid1)-1]);
			
			$fin_arrcid_ord = array_values($fin_arrcid_ord1);
			$fincnt = count($fin_arrcid_ord);
			$new_final = array();
			for($y=0;$y<$fincnt-1;$y++)
			{
				$temp_dis = 0; $short_dis = 0; $short_cid = '';
				for($z=$y+1;$z<$fincnt;$z++)
				{
					
					$shdist1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
					$shdist1->execute(array($fin_arrcid_ord[$y],$fin_arrcid_ord[$z]));
					$row_shdist1 = $shdist1->fetch(PDO::FETCH_ASSOC);
					$totalRows_shdist1 = $shdist1->rowCount();
					
					if($totalRows_shdist1 > 0)
					{
						//echo 'dist from'.$arrcid[$y].'to'.$arrcid[$z].'='.$row_shdist1['dist'].'<br>';
						if ($temp_dis != 0)
						{
							//echo '~'.$arrcid[$y].'~'.$arrcid[$z].'~';
							if(($row_shdist1['dist'] < $temp_dis) && (trim($fin_arrcid_ord[$y]) != $arrcid1[count($arrcid1)-1] && trim($fin_arrcid_ord[$z]) != $arrcid1[count($arrcid1)-1]))
							{
								$temp_dis = $row_shdist1['dist'];
								$short_dis = $row_shdist1['dist'];
								$short_cid = $arrcid[$z];
								
								$cit_temp = $fin_arrcid_ord[$y+1];
								$fin_arrcid_ord[$y+1] = $fin_arrcid_ord[$z];
								$fin_arrcid_ord[$z] = $cit_temp;
								//print_r($arrcid);
							}
						}
						else
						{
							if($row_shdist1['dist'] == 0)
							{
								$temp_dis = 1;
							}
							else
							{
								$temp_dis = $row_shdist1['dist'];
							}
							$short_dis = $row_shdist1['dist'];
							$short_cid = $arrcid[$z];
							//print_r($arrcid);
						}
					}
					else
					{
						
						$shdist2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
						$shdist2->execute(array($fin_arrcid_ord[$z],$fin_arrcid_ord[$y]));
						$row_shdist2 = $shdist2->fetch(PDO::FETCH_ASSOC);
						$totalRows_shdist2 = $shdist2->rowCount();
						
						if($totalRows_shdist2 > 0)
						{
							//echo 'dist from'.$arrcid[$y].'to'.$arrcid[$z].'='.$row_shdist2['dist'].'<br>';
							if ($temp_dis != 0)
							{
								//echo '~'.$arrcid[$y].'~'.$arrcid[$z].'~';
								if(($row_shdist2['dist'] < $temp_dis) && (trim($fin_arrcid_ord[$y]) != $arrcid1[count($arrcid1)-1] && trim($fin_arrcid_ord[$z]) != $arrcid1[count($arrcid1)-1]))
								{
									$temp_dis = $row_shdist2['dist'];
									$short_dis = $row_shdist2['dist'];
									$short_cid = $arrcid[$z];
									
									$cit_temp = $fin_arrcid_ord[$y+1];
									$fin_arrcid_ord[$y+1] = $fin_arrcid_ord[$z];
									$fin_arrcid_ord[$z] = $cit_temp;
									//print_r($arrcid);
								}
							}
							else
							{
								if ($row_shdist2['dist'] == 0)
								{
									$temp_dis = 1;
								}
								else
								{
									$temp_dis = $row_shdist2['dist'];
								}
								$short_dis = $row_shdist2['dist'];
								$short_cid = $arrcid[$z];
								//print_r($arrcid);
							}
						}
					}
				}
				$v++; $sh_cid.=','.$short_cid; $temp_dis = 0;
			}
			//print_r($fin_arrcid_ord);
			$fin_arrcid_per = array();
			$cnt_finarr = count($fin_arrcid_ord);
			$fin_rem = $cnt_finarr % 5;
			
			$fin_quot = ($cnt_finarr - $fin_rem) / 5;
			
			if($fin_rem > 0)
			{
				$lo = $fin_quot + 1;
			}
			else
			{
				$lo = $fin_quot;
			}

			$set_cnt = 0;
			for($za=0;$za<$lo;$za++)
			{
				if($za == $lo-1)
				{
					if ($fin_rem != 0)
					{
						$zc = $fin_rem;
					}
					else
					{
						$zc = 5;
					}
				}
				else
				{
					$zc = 5;
				}
				
				if($za != 0)
				{
					array_push($fin_arrcid_per,$new_final[count($new_final)-1]);
				}
				
				$ze = $zc+$set_cnt;
				for($zb=$set_cnt;$zb<$ze;$zb++)
				{
					array_push($fin_arrcid_per,$fin_arrcid_ord[$zb]);
				}
				//print_r($fin_arrcid_per);
				pc_permute($fin_arrcid_per);
				unset($fin_arrcid_per);
				$fin_arrcid_per = array();
				$send_fin = array();
				unset($send_fin);
				$send_fin = array();
				
				
				
				foreach($pass_arrcid as $val_passcid)
				{
					$val_passcid1 = explode(',',$val_passcid);
					if($za == 0)
					{
						if ($val_passcid1[0] == $arrcid1[0])
						{
							array_push($send_fin,$val_passcid);
						}
					}
					elseif($za == $lo-1)
					{
						
						if (($val_passcid1[count($val_passcid1)-1] == $arrcid1[count($arrcid1)-1]) && ($val_passcid1[0] == $new_final[count($new_final)-1]))
						{
							array_push($send_fin,$val_passcid);
						}
					}
					else
					{
						if ($val_passcid1[0] == $new_final[count($new_final)-1])
						{
							array_push($send_fin,$val_passcid);
						}
					}
				}
				$set_cnt+=5;
				$chk_dist = array();
				unset($pass_arrcid);
				$pass_arrcid = array();
				//print_r($send_fin);
				foreach($send_fin as $pass_vals)
				{
					$exp_pass = explode(',',$pass_vals);
					$trav_dist = ''; $tot_dist = 0; $trav_dist_ess = ''; $tot_dist_ess = 0;
					for ($a=0;$a<count($exp_pass)-1;$a++)
					{
						$b = $a + 1;
						
						
						$citdist1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
						$citdist1->execute(array($exp_pass[$a],$exp_pass[$b]));
						$row_citdist1 = $citdist1->fetch(PDO::FETCH_ASSOC);
						$totalRows_citdist1 =$citdist1->rowCount();
						
						if($totalRows_citdist1 > 0)
						{
							/*
							$query_ss1 = "SELECT * FROM dvi_cities where id='$exp_pass[$b]'";
							$ss1 = mysql_query($query_ss1, $divdb) or die(mysql_error());
							$row_ss1 = mysql_fetch_assoc($ss1);
							$totalRows_ss1 = mysql_num_rows($ss1);*/
							
							//$trav_dist.= ','.($row_citdist1['dist']+$row_ss1['ss_dist']);
							//$tot_dist+=$row_citdist1['dist']+$row_ss1['ss_dist'];
							
							//$trav_dist_ess.= ','.$row_citdist1['dist'];
							$tot_dist_ess+=$row_citdist1['dist'];
							
						}
						else
						{
							
							$citdist2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
							$citdist2->execute(array($exp_pass[$b],$exp_pass[$a]));
							$row_citdist2 = $citdist2->fetch(PDO::FETCH_ASSOC);
							$totalRows_citdist2 =$citdist2->rowCount();
							
							if($totalRows_citdist2 > 0)
							{
								/*
								$query_ss2 = "SELECT * FROM dvi_cities where id='$exp_pass[$b]'";
								$ss2 = mysql_query($query_ss2, $divdb) or die(mysql_error());
								$row_ss2 = mysql_fetch_assoc($ss2);
								$totalRows_ss2 = mysql_num_rows($ss2);*/
							
								/*$trav_dist.= ','.($row_citdist2['dist']+$row_ss2['ss_dist']);
								$tot_dist+=$row_citdist2['dist']+$row_ss2['ss_dist'];
								
								$trav_dist_ess.= ','.$row_citdist2['dist'];*/
								$tot_dist_ess+=$row_citdist2['dist'];
							}
						}
					}
					//$trav_dist = trim($trav_dist,',');
					//$trav_dist_ess = trim($trav_dist_ess,',');
					array_push($chk_dist,$tot_dist_ess); 
					
					$trav_dist = ''; $tot_dist = 0; $trav_dist_ess = ''; $tot_dist_ess = 0;
				}
				//print_r($chk_dist);
				$index = array_search(min($chk_dist), $chk_dist);
				//echo $send_fin[$index];
				$fin_arr1 = explode(',',$send_fin[$index]);
				
				if($za != 0)
				{
					for($ze=1;$ze<count($fin_arr1);$ze++)
					{
						array_push($new_final,$fin_arr1[$ze]);
					}
				}
				else
				{
					for($ze=0;$ze<count($fin_arr1);$ze++)
					{
						array_push($new_final,$fin_arr1[$ze]);
					}
				}
			}
			//print_r($new_final);
			$new_final1 = $new_final;
			foreach($fin_arrcid_cnt as $fin_key=>$fin_arr_val)
			{
				if($fin_arr_val > 1)
				{
					for($zk=0;$zk<count($new_final);$zk++)
					{
						if($new_final[$zk] == $fin_key)
						{
							for($zj=1;$zj<$fin_arr_val;$zj++)
							{
								array_splice($new_final1, $zk+1, 0, $fin_key);
								$fin_splic = array_values($new_final1);
								unset($new_final1);
								$new_final1 = array();
								$new_final1 = $fin_splic;
							}
						}
					}
				}
			}
			
			if ($count_fitm > 1)
			{
				$new_final2 = array();
				$new_final2 = $new_final1;
				for($zt=1;$zt<$count_fitm;$zt++)
				{
					array_unshift($new_final2, $arrcid1[0]);
				}
				unset($new_final1);
				$new_final1 = array();
				$new_final1 = array_values($new_final2);
			}
			
			if ($count_litm > 1)
			{
				$new_final3 = array();
				$new_final3 = $new_final1;
				for($zj=1;$zj<$count_litm;$zj++)
				{
					array_push($new_final3, $arrcid1[count($arrcid1)-1]);
				}
				unset($new_final1);
				$new_final1 = array();
				$new_final1 = array_values($new_final3);
			}
			
			
			//print_r($new_final1);
			$trav_dist = ''; $tot_dist = 0; $trav_dist_ess = ''; $tot_dist_ess = 0;
			
			for ($a=0;$a<count($new_final1)-1;$a++)
			{
				$b = $a + 1;
				
				
				$citdist1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
				$citdist1->execute(array($new_final1[$a],$new_final1[$b]));
				$row_citdist1 = $citdist1->fetch(PDO::FETCH_ASSOC);
				$totalRows_citdist1 = $citdist1->rowCount();
					
				if($totalRows_citdist1 > 0)
				{
					
					$ss1 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
					$ss1->execute(array($new_final1[$b]));
					$row_ss1 = $ss1->fetch(PDO::FETCH_ASSOC);
					$totalRows_ss1 = $ss1->rowCount();
						
					$trav_dist.= ','.($row_citdist1['dist']+$row_ss1['ss_dist']);
					$tot_dist+=$row_citdist1['dist']+$row_ss1['ss_dist'];
						
					$trav_dist_ess.= ','.$row_citdist1['dist'];
					$tot_dist_ess+=$row_citdist1['dist'];
				}
				else
				{
					
					$citdist2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
					$citdist2->execute(array($new_final1[$b],$new_final1[$a]));
					$row_citdist2 = $citdist2->fetch(PDO::FETCH_ASSOC);
					$totalRows_citdist2 = $citdist2->rowCount();
						
					if($totalRows_citdist2 > 0)
					{
						
						$ss2 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
						$ss2->execute(array($new_final1[$b]));
						$row_ss2 = $ss2->fetch(PDO::FETCH_ASSOC);
						$totalRows_ss2 = $ss2->rowCount();
						
						$trav_dist.= ','.($row_citdist2['dist']+$row_ss2['ss_dist']);
						$tot_dist+=$row_citdist2['dist']+$row_ss2['ss_dist'];
							
						$trav_dist_ess.= ','.$row_citdist2['dist'];
						$tot_dist_ess+=$row_citdist2['dist'];
					}
				}
			}
			$trav_dist = trim($trav_dist,',');
			$trav_dist_ess = trim($trav_dist_ess,',');
			//array_push($finarr_dist,$tot_dist); 
			//array_push($finarr_dist_ess,$tot_dist_ess); 
			
			//array_push($finarr_edist,$trav_dist); 
			//array_push($finarr_edist_ess,$trav_dist_ess);
			//$index = array_search(min($finarr_dist_ess), $finarr_dist_ess);
			//$pass_arrcid1 = explode(',',$pass_arrcid[$index]);
			$pass_arrcid1 =  $new_final1;
			$send_edist = $trav_dist;
			$send_edist_ess = $trav_dist_ess;
			$send_dist = $tot_dist;
			$send_dist_ess = $tot_dist_ess;
			
			function convertToHoursMins($time, $format = '%d:%d') 
			{
				settype($time, 'integer');
				if ($time < 1) 
				{
					return;
				}
				$hours = floor($time / 60);
				$minutes = ($time % 60);
				return sprintf($format, $hours, $minutes);
			}
			$time_taken = '';
			$exp_cit_ord = explode(',',$trav_dist_ess);
			for($timcnt=0;$timcnt<count($exp_cit_ord);$timcnt++)
			{
				$time_cvt = $exp_cit_ord[$timcnt] / 50;
				$time_cvt1 = $time_cvt * 60;
				$time_taken.=','.convertToHoursMins($time_cvt1, '%02d hours %02d minutes'); // should output 4 hours 17 minutes
			}
			$frmt_time = substr($time_taken,1);
		}
	}
	elseif($arrcid[0] != $arrcid[count($arrcid)-1])
	{
		$fin_arrcid = $arrcid1;
		pc_permute($fin_arrcid);
	}
	else
	{
		$pass_arrcid = array();
	}
	//print_r($pass_arrcid);
	
	$extdis_arr = array();
	$exp_cids = array();
	$exp_cids = $arrcid;
	
	//$finarr_res = $pass_arrcid;
	//print_r($exp_cids);

	$finarr_edist = array();
	$finarr_edist_ess = array();
	$finarr_dist = array();
	$finarr_dist_ess = array();
	
	if ($comp_flag == '')
	{
		if (!empty($pass_arrcid))
		{
			foreach($pass_arrcid as $pass_vals)
			{
				$exp_pass = explode(',',$pass_vals);
				$trav_dist = ''; $tot_dist = 0; $trav_dist_ess = ''; $tot_dist_ess = 0;
				for ($a=0;$a<count($exp_pass)-1;$a++)
				{
					$b = $a + 1;
					
					
					$citdist1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
					$citdist1->execute(array($exp_pass[$a],$exp_pass[$b]));
					$row_citdist1 = $citdist1->fetch(PDO::FETCH_ASSOC);
					$totalRows_citdist1 = $citdist1->rowCount();
					
					if($totalRows_citdist1 > 0)
					{
						
						$ss1 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
						$ss1->execute(array($exp_pass[$b]));
						$row_ss1 = $ss1->fetch(PDO::FETCH_ASSOC);
						$totalRows_ss1 = $ss1->rowCount();
						
						$trav_dist.= ','.($row_citdist1['dist']+$row_ss1['ss_dist']);
						$tot_dist+=$row_citdist1['dist']+$row_ss1['ss_dist'];
						
						$trav_dist_ess.= ','.$row_citdist1['dist'];
						$tot_dist_ess+=$row_citdist1['dist'];
						
					}
					else
					{
						
						$citdist2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
						$citdist2->execute(array($exp_pass[$b],$exp_pass[$a]));
						$row_citdist2 = $citdist2->fetch(PDO::FETCH_ASSOC);
						$totalRows_citdist2 =$citdist2->rowCount();
						
						if($totalRows_citdist2 > 0)
						{
							
							$ss2 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
							$ss2->execute(array($exp_pass[$b]));
							$row_ss2 = $ss2->fetch(PDO::FETCH_ASSOC);
							$totalRows_ss2 = $ss2->rowCount();
						
							$trav_dist.= ','.($row_citdist2['dist']+$row_ss2['ss_dist']);
							$tot_dist+=$row_citdist2['dist']+$row_ss2['ss_dist'];
							
							$trav_dist_ess.= ','.$row_citdist2['dist'];
							$tot_dist_ess+=$row_citdist2['dist'];
						}
					}
				}
				$trav_dist = trim($trav_dist,',');
				$trav_dist_ess = trim($trav_dist_ess,',');
				array_push($finarr_dist,$tot_dist); 
				array_push($finarr_dist_ess,$tot_dist_ess); 
				
				array_push($finarr_edist,$trav_dist); 
				array_push($finarr_edist_ess,$trav_dist_ess);
				$trav_dist = ''; $tot_dist = 0; $trav_dist_ess = ''; $tot_dist_ess = 0;
			}
			$index = array_search(min($finarr_dist_ess), $finarr_dist_ess);
			$pass_arrcid1 = explode(',',$pass_arrcid[$index]);
			
			$send_edist = $finarr_edist[$index];
			$send_edist_ess = $finarr_edist_ess[$index];
			$send_dist = $finarr_dist[$index];
			$send_dist_ess = $finarr_dist_ess[$index];
			function convertToHoursMins($time, $format = '%d:%d') 
			{
				settype($time, 'integer');
				if ($time < 1) 
				{
					return;
				}
				$hours = floor($time / 60);
				$minutes = ($time % 60);
				return sprintf($format, $hours, $minutes);
			}
			$time_taken = '';
			$exp_cit_ord = explode(',',$finarr_edist_ess[$index]);
			for($timcnt=0;$timcnt<count($exp_cit_ord);$timcnt++)
			{
				$time_cvt = $exp_cit_ord[$timcnt] / 50;
				$time_cvt1 = $time_cvt * 60;
				$time_taken.=','.convertToHoursMins($time_cvt1, '%02d hours %02d minutes'); // should output 4 hours 17 minutes
			}
			$frmt_time = substr($time_taken,1);
		}
		else
		{
			$trav_dist = ''; $tot_dist = 0; $trav_dist_ess = ''; $tot_dist_ess = 0;
			$pass_arrcid1 = $arrcid1; $frmt_time = ''; $ss_onlidis = 0;
	
			
			$ss1 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
			$ss1->execute(array($arrcid1[0]));
			$row_ss1 = $ss1->fetch(PDO::FETCH_ASSOC);
			$totalRows_ss1 = $ss1->rowCount();
			
			foreach($arrcid1 as $same_cit)
			{
				array_push($finarr_edist,$row_ss1['ss_dist']);
				$ss_onlidis+= $row_ss1['ss_dist'];
				array_push($finarr_edist_ess,0);
				$frmt_time.=','.'-';
			}
			array_push($finarr_dist,$ss_onlidis);
			array_push($finarr_dist_ess,0); 
			$frmt_time = ltrim($frmt_time,',');
			$send_edist = implode(',',$finarr_edist);
			$send_edist_ess = implode(',',$finarr_edist_ess);
			$send_dist = 0;
			$send_dist_ess = 0;
		}
	}
	
	$cit_optord = ''; $cit_optnams = ''; 
	foreach($pass_arrcid1 as $sepcit)
	{
		$cit_optord.= ','.$sepcit;
		
		
		$cnames = $conn->prepare("SELECT * FROM dvi_cities where id=?");
		$cnames->execute(array($sepcit));
		$row_cnames =$cnames->fetch(PDO::FETCH_ASSOC);
		$totalRows_cnames = $cnames->rowCount();
		
		
		$snames = $conn->prepare("SELECT * FROM dvi_states where code=?");
		$snames->execute(array($row_cnames['region']));
		$row_snames = $snames->fetch(PDO::FETCH_ASSOC);
		$totalRows_snames = $snames->rowCount();
		
		$cit_optnams.= '-'.$row_cnames['name'].' ,'.$row_snames['name'];
		
	}
	$cit_optord = ltrim($cit_optord,',');
	$cit_optnams = ltrim($cit_optnams,'-');
	
	//Calculate extra distance taken for vehicle from each city
	$cnt_arrveh = count($arrveh_cid);	
	
	$org_cit_veh = $arrveh_cid[0];
	$dest_cit_veh = $arrveh_cid[$cnt_arrveh-1];
	$st_extdis = 0;
	if ($org_cit_veh != $dest_cit_veh)
	{
		
		$exdis1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
		$exdis1->execute(array($org_cit_veh,$dest_cit_veh));
		$row_exdis1 = $exdis1->fetch(PDO::FETCH_ASSOC);
		$totalRows_exdis1 = $exdis1->rowCount();
		
		if ($totalRows_exdis1 > 0)
		{
			$st_extdis = $row_exdis1['dist'];
		}
		else
		{
			
			$exdis2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
			$exdis2->execute(array($dest_cit_veh,$org_cit_veh));
			$row_exdis2 = $exdis2->fetch(PDO::FETCH_ASSOC);
			$totalRows_exdis2 =$exdis2->rowCount();
			
			if ($totalRows_exdis2 > 0)
			{
				$st_extdis = $row_exdis2['dist'];
			}
		}
	}
	else
	{
		$st_extdis = 0;
	}
	array_push($extdis_arr,$org_cit_veh.'-'.$st_extdis);
	
	if($cnt_arrveh > 2)
	{
		$cal_ext1 = 0; $cal_ext1 = 0;
		for($m=1;$m<count($arrveh_cid)-1;$m++)
		{
			
			$exdis1a = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid = ?");
			$exdis1a->execute(array($arrveh_cid[$m],$org_cit_veh));
			$row_exdis1a = $exdis1a->fetch(PDO::FETCH_ASSOC);
			$totalRows_exdis1a = $exdis1a->rowCount();
			
			if($totalRows_exdis1a > 0)
			{
				$cal_ext1 = $row_exdis1a['dist'];
			}
			else
			{
				
				$exdis1b = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
				$exdis1b->execute(array($org_cit_veh,$arrveh_cid[$m]));
				$row_exdis1b = $exdis1b->fetch(PDO::FETCH_ASSOC);
				$totalRows_exdis1b = $exdis1b->rowCount();
				
				if($totalRows_exdis1b > 0)
				{
					$cal_ext1 = $row_exdis1b['dist'];
				}
			}
			
			
			$exdis1c = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid = ?");
			$exdis1c->execute(array($arrveh_cid[$m],$dest_cit_veh));
			$row_exdis1c = $exdis1c->fetch(PDO::FETCH_ASSOC);
			$totalRows_exdis1c = $exdis1c->rowCount();
			
			if($totalRows_exdis1c > 0)
			{
				$cal_ext1+= $row_exdis1c['dist'];
			}
			else
			{
				
				$exdis1d = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
				$exdis1d->execute(array($dest_cit_veh,$arrveh_cid[$m]));
				$row_exdis1d = $exdis1d->fetch(PDO::FETCH_ASSOC);
				$totalRows_exdis1d = $exdis1d->rowCount();
				
				if($totalRows_exdis1d > 0)
				{
					$cal_ext1+= $row_exdis1d['dist'];
				}
			}
			
			array_push($extdis_arr,$arrveh_cid[$m].'-'.$cal_ext1);
			$cal_ext1 = 0;
		}
	}
	
	//$extdis_uniq = array_map("unserialize", array_unique(array_map("serialize", $extdis_arr)));
	if ($last_chk == 'y')
	{
		array_push($extdis_arr,$dest_cit_veh.'-'.$st_extdis);
	}
	
	$extdis_uniq1 = array_unique($extdis_arr, SORT_REGULAR);
	$extdis_str = ''; $extdis_str1 = '';
	$extdis_uniq = array_values($extdis_uniq1);
	
	//$temp2 = $extdis_uniq[1];
	for($l=0;$l<count($extdis_uniq);$l++)
	{
		$extdis_str.=','.$extdis_uniq[$l];
	}
	$extdis_str=trim($extdis_str,',');
	
	/*for($l1=0;$l1<count($extdis_arr);$l1++)
	{
		$extdis_str1.=','.$extdis_arr[$l1];
	}
	*/
	$cit_optord1=explode(',',$cit_optord);
	//$city_opt_nnn1=explode(',',$city_opt_nnn);
	$city_opt_nnn='';
	
	if (count($cit_optord1) > 2)
	{
	for($opt_id=1;$opt_id<count($cit_optord1);$opt_id++)
	{
		if($opt_id != count($cit_optord1)-1)
		{
			$cit_optid1[$opt_id-1]=$cit_optord1[$opt_id];
			//$city_opt_nnn2[$opt_id-1]=$city_opt_nnn1[$opt_id];
			
		$cnames = $conn->prepare("SELECT * FROM dvi_cities where id=?");
		$cnames->execute(array($cit_optord1[$opt_id]));
		$row_cnames = $cnames->fetch(PDO::FETCH_ASSOC);
		$totalRows_cnames =$cnames->rowCount();
		
		if($city_opt_nnn=='')
		{
			$city_opt_nnn=$row_cnames['name'];
		}else{
			$city_opt_nnn=$city_opt_nnn.','.$row_cnames['name'];
		}
			
		}
	}
	$cit_optid2=implode(',',$cit_optid1);
	}
	else
	{
		$cit_optid2 = '';
	}
	
	echo json_encode(array("trav_dist" => "$send_edist", "trav_dist_ess" => "$send_edist_ess", "trav_totdist" => "$send_dist", "trav_totdist_ess" => "$send_dist_ess", "frmt_time" => "$frmt_time", "extdist" => "$extdis_str", "cit_ord" => "$cit_optord", "cit_opt_idd" => "$cit_optid2", "cit_optnams" => "$cit_optnams" , "cit_optnnmm" => "$city_opt_nnn")); 

}
?>