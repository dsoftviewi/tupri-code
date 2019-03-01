<?php
require_once('../Connections/divdb.php');

if ($_GET['route_type'] == 'm')
{
	$arrcid = $_GET['allcids'];
	$arrveh_cid = $_GET['vehcitids'];
	$last_chk = $_GET['last_chk'];
	
	$extdis_arr = array();
	//$extdis_uniq = array();
	
	$trav_dist = ''; $tot_dist = 0;
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
			}
		}
	}
	
	$trav_dist = trim($trav_dist,',');
	
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
				
				$$exdis1b = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
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
	
	$extdis_uniq = array_unique($extdis_arr, SORT_REGULAR);
	$extdis_str = ''; $extdis_str1 = '';
	
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
	//$extdis_str=trim($extdis_str,',');
	
	/*for($l1=0;$l1<count($extdis_arr);$l1++)
	{
		$extdis_str1.=','.$extdis_arr[$l1];
	}
	*/
	echo json_encode(array("trav_dist" => "$trav_dist", "trav_totdist" => "$tot_dist", "extdist" => "$extdis_str", "cit_ord" => "$cit_ord")); 
	//echo "<input type='hidden' name='ret_dist' value='$retdis_arr[$index]'>";
}
elseif ($_GET['route_type'] == 'o')
{
	$arrcid = $arrcid1 = $_GET['allcids'];
	$arrveh_cid = $_GET['vehcitids'];
	$last_chk = $_GET['last_chk'];
	$v=1; $sh_cid = '';
	$reord = array();
	
	sort($arrcid); $cnt_el = 0;
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
	
	unset($arrcid);
	$arrcid = array();
	
	foreach($reord as $cid_elem)
	{
		array_push($arrcid,$cid_elem);
	}
	
	print_r($arrcid);
	for($y=0;$y<count($arrcid)-1;$y++)
	{
		$temp_dis = 0; $short_dis = 0; $short_cid = '';
		for($z=$y+1;$z<count($arrcid);$z++)
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
					if($row_shdist1['dist'] < $temp_dis)
					{
						$temp_dis = $row_shdist1['dist'];
						$short_dis = $row_shdist1['dist'];
						$short_cid = $arrcid[$z];
						
						$cit_temp = $arrcid[$y+1];
						$arrcid[$y+1] = $arrcid[$z];
						$arrcid[$z] = $cit_temp;
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
						if($row_shdist2['dist'] < $temp_dis)
						{
							$temp_dis = $row_shdist2['dist'];
							$short_dis = $row_shdist2['dist'];
							$short_cid = $arrcid[$z];
							
							$cit_temp = $arrcid[$y+1];
							$arrcid[$y+1] = $arrcid[$z];
							$arrcid[$z] = $cit_temp;
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
					}
				}
			}
		}
		$v++; $sh_cid.=','.$short_cid; $temp_dis = 0;
	}
	$sh_cid = ltrim($sh_cid,',');
	//echo $sh_cid;
	$add_cid = $arrcid1[0].','.$sh_cid;
	
	$exp_cids = explode(',',$add_cid);
	
	$cnt_exp_cids = count($exp_cids)-1;
	$cnt_arr_cids = count($arrcid1)-1;
	
	if($exp_cids[$cnt_exp_cids] != $arrcid1[$cnt_arr_cids])
	{
		for ($inr=0;$inr<count($exp_cids)-1;$inr++)
		{
			if ($exp_cids[$inr] == $arrcid1[$cnt_arr_cids])
			{
				$temp_stor = $exp_cids[$inr];
				unset($exp_cids[$inr]);
				array_push($exp_cids,$temp_stor);
			}
		}
	}
	
	//print_r($exp_cids);
	$reindexed_array = array_values($exp_cids);
	$extdis_arr = array();
	//print_r($reindexed_array);
	$cit_optord = ''; $cit_optnams = '';
	foreach($reindexed_array as $sepcit)
	{
		$cit_optord.= ','.$sepcit;
		
		
		$cnames = $conn->prepare("SELECT * FROM dvi_cities where id=?");
		$cnames->execute(array($sepcit));
		$row_cnames = $cnames->fetch(PDO::FETCH_ASSOC);
		$totalRows_cnames = $cnames->rowCount();
		
		
		$snames = $conn->prepare("SELECT * FROM dvi_states where code=?");
		$snames->execute(array($row_cnames['region']));
		$row_snames = $snames->fetch(PDO::FETCH_ASSOC);
		$totalRows_snames = $snames->rowCount();
		
		$cit_optnams.= '-'.$row_cnames['name'].' ,'.$row_snames['name'];
	}
	$cit_optord = ltrim($cit_optord,',');
	$cit_optnams = ltrim($cit_optnams,'-');
	$trav_dist = ''; $tot_dist = 0;
	for ($a=0;$a<count($reindexed_array)-1;$a++)
	{
		$b = $a + 1;
		
		
		$citdist1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid =?");
		$citdist1->execute(array($reindexed_array[$a],$reindexed_array[$b]));
		$row_citdist1 = $citdist1->fetch(PDO::FETCH_ASSOC);
		$totalRows_citdist1 = $citdist1->rowCount();
		
		if($totalRows_citdist1 > 0)
		{
			
			$ss1 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
			$ss1->execute(array($reindexed_array[$b]));
			$row_ss1 = $ss1->fetch(PDO::FETCH_ASSOC);
			$totalRows_ss1 = $ss1->rowCount();
			
			$trav_dist.= ','.($row_citdist1['dist']+$row_ss1['ss_dist']);
			$tot_dist+=$row_citdist1['dist']+$row_ss1['ss_dist'];
		}
		else
		{
			
			$citdist2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=? and to_cityid = ?");
			$citdist2->execute(array($reindexed_array[$b],$reindexed_array[$a]));
			$row_citdist2 = $citdist2->fetch(PDO::FETCH_ASSOC);
			$totalRows_citdist2 =$citdist2->rowCount();
			
			if($totalRows_citdist2 > 0)
			{
				
				$ss2 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
				$ss2->execute(array($reindexed_array[$b]));
				$row_ss2 = $ss2->fetch(PDO::FETCH_ASSOC);
				$totalRows_ss2 = $ss2->rowCount();
			
				$trav_dist.= ','.($row_citdist2['dist']+$row_ss2['ss_dist']);
				$tot_dist+=$row_citdist2['dist']+$row_ss2['ss_dist'];
			}
		}
	}
	
	$trav_dist = trim($trav_dist,',');
	
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
			$totalRows_exdis2 = $exdis2->rowCount();
			
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
			$totalRows_exdis1a =$exdis1a->rowCount();
			
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
	
	$extdis_uniq = array_unique($extdis_arr, SORT_REGULAR);
	$extdis_str = ''; $extdis_str1 = '';
	
	//$temp2 = $extdis_uniq[1];
	for($l=0;$l<count($extdis_uniq);$l++)
	{
		$extdis_str.=','.$extdis_uniq[$l];
	}
	
	//$extdis_str=trim($extdis_str,',');
	
	/*for($l1=0;$l1<count($extdis_arr);$l1++)
	{
		$extdis_str1.=','.$extdis_arr[$l1];
	}
	*/
	echo json_encode(array("trav_dist" => "$trav_dist", "trav_totdist" => "$tot_dist", "extdist" => "$extdis_str", "cit_ord" => "$cit_optord", "cit_optnams" => "$cit_optnams")); 
	//echo "<input type='hidden' name='ret_dist' value='$retdis_arr[$index]'>";

}
?>