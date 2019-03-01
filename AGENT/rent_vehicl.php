<?php
require_once('../Connections/divdb.php');

$arrveh = $_GET['arrsend'];
$trdist = $_GET['trdist'];
$trdays = $_GET['trdays'];
$allcids = $_GET['allcids'];
$arrext_dist = ltrim($_GET['ext_dist'],",");

$exp_extdis = explode(',',$arrext_dist);
//print_r($exp_extdis);
$rentalrept = ''; $rent_upl = ''; $rent_allveh = '';
$impveh = implode(',',$arrveh);
$expveh = explode(',',$impveh);
$netamount = 0;$tot_amount_per_veh = 0;
$rent_eachveh = '';

$netamt_arr = array();
$data_arr = array();
$vehupl_arr = array();
$allveh_arr = array();
$retdis_arr = array();
$tr_tot_amt = array();
$rent_perveh_arr = array();
$veh_citid_arr = array();
$state_arr = array();
$perm_arr = array();
$stor_perm = '';
/*$last_city1 = $exp_extdis[count($exp_extdis)-1];
$last_city2 = explode('-',$last_city1);
$last_city = $last_city2[1];
*/
//$impcids = implode(',',$allcids);
$expcids = explode(',',$allcids);
//print_r($expcids);
/*
$query_orgst = "SELECT * FROM dvi_cities where id='$expcids[0]' and status = 0";
$orgst = mysql_query($query_orgst, $divdb) or die(mysql_error());
$row_orgst = mysql_fetch_assoc($orgst);
$totalRows_orgst = mysql_num_rows($orgst);
	
for($r=1;$r<count($expcids);$r++)
{
	
	$query_chkcit = "SELECT * FROM dvi_cities where id='$expcids[$r]' and status = 0";
	$chkcit = mysql_query($query_chkcit, $divdb) or die(mysql_error());
	$row_chkcit = mysql_fetch_assoc($chkcit);
	$totalRows_chkcit = mysql_num_rows($chkcit);
	
	if ($row_orgst['region'] != $row_chkcit['region'])
	{
		array_push($state_arr,$row_chkcit['region']);
	}
}

$tot_perm = 0; $tot_perm1 = 0;
$unique_st = array_unique($state_arr);

for($r2=0;$r2<count($expveh);$r2++)
{
	$expgetveh1 = explode('~',$expveh[$r2]);
	$expvehid1 = $expgetveh1[1];
	
	for($r1=0;$r1<count($unique_st);$r1++)
	{
		
		$query_chkstt = "SELECT * FROM vehicle_permit where vehicle_id='$expvehid1' and state_id = '$unique_st[$r1]'";
		$chkstt = mysql_query($query_chkstt, $divdb) or die(mysql_error());
		$row_chkstt = mysql_fetch_assoc($chkstt);
		
		$tot_perm1+= $row_chkstt['permit_amt'];
	}
	
	array_push($perm_arr,$expvehid1.'-'.$tot_perm1);
	$tot_perm+= $tot_perm1; $tot_perm1 = 0;
}
*/
/*$fnd = '';
for($n=0;$n<count($expveh);$n++)
{
	$expgetveh = explode('~',$expveh[$n]);
	$expvehid = $expgetveh[1];
		
	
	$query_chkveh = "SELECT * FROM vehicle_rent where vehicle_id='$expvehid' and city='$last_city'";
	$chkveh = mysql_query($query_chkveh, $divdb) or die(mysql_error());
	$row_chkveh = mysql_fetch_assoc($chkveh);
	$totalRows_chkveh = mysql_num_rows($chkveh);
	if ($totalRows_chkveh == 0)
	{
		$fnd = 'N';
	}
}
if ($fnd == 'N')
{
	$lvehflag = '0';
}
else
{
	$lvehflag = '1';
}
*/
//$cnt_cities = count($exp_citiid);
$cnt_cities = count($exp_extdis);
/*if ($lvehflag == '0')
{
	$cnt_cities--;
}
*/
$tot_perm = 0; $tot_perm1 = 0; $perm_flag = '';
for ($q=0;$q<$cnt_cities;$q++)
{
	for ($l=0;$l<count($expveh);$l++)
	{
		$expgetinfo = explode('~',$expveh[$l]);
		$idval = $expgetinfo[0];
		$vehid = $expgetinfo[1];
		$exp_extdis1 = explode('-',$exp_extdis[$q]);
		
		//$cityid = $expgetinfo[2];
		//$cityid = $exp_citiid[$q];
		$cityid = $exp_extdis1[0];
		$vehtype = $expgetinfo[3];
	
		
		$vehics = $conn->prepare("SELECT * FROM vehicle_rent where vehicle_id =? and city =?");
		$vehics->execute(array($vehid,$cityid));
		$row_vehics = $vehics->fetch(PDO::FETCH_ASSOC);
		$totalRows_vehics = $vehics->rowCount();
		
		
		$cities = $conn->prepare("SELECT * FROM dvi_cities  WHERE id =?");
		$cities->execute(array($cityid));
		$row_cities = $cities->fetch(PDO::FETCH_ASSOC);
		$totalRows_cities =$cities->rowCount();
		
		if (count($expveh) > 1)
		{
			$rentalrept.= "VEHICLE ".($l+1)." TAKEN FROM ".$row_cities['name']." - ".$vehtype."<br>";
		}
		else
		{
			$rentalrept.= "VEHICLE TAKEN FROM ".$row_cities['name']." - ".$vehtype."<br>";
		}
		
		
		//Permit calculation
		if ($perm_flag == '')
		{
			
			$orgst = $conn->prepare("SELECT * FROM dvi_cities where id=? and status = 0");
			$orgst->execute(array($cityid));
			$row_orgst = $orgst->fetch(PDO::FETCH_ASSOC);
			$totalRows_orgst = $orgst->rowCount();
				
			for($r=0;$r<count($expcids);$r++)
			{
				
				$chkcit = $conn->prepare("SELECT * FROM dvi_cities where id=? and status = 0");
				$chkcit->execute(array($expcids[$r]));
				$row_chkcit = $chkcit->fetch(PDO::FETCH_ASSOC);
				$totalRows_chkcit = $chkcit->rowCount();
				
				if ($row_orgst['region'] != $row_chkcit['region'])
				{
					array_push($state_arr,$row_chkcit['region']);
				}
			}
			
			
			$unique_st1 = array_unique($state_arr);
			$unique_st = array_values($unique_st1);
			$perm_flag = 'y';
			unset($state_arr); $state_arr = array();
			unset($unique_st1); $unique_st1 = array();
		}
		//$expgetveh1 = explode('~',$expveh[$r2]);
		//$expvehid1 = $expgetveh1[1];
		for($r1=0;$r1<count($unique_st);$r1++)
		{
			
			$chkstt = $conn->prepare("SELECT * FROM vehicle_permit where vehicle_id=? and state_id =?");
			$chkstt->execute(array($vehid,$unique_st[$r1]));
			$row_chkstt = $chkstt->fetch(PDO::FETCH_ASSOC);
				
			$stor_perm.=','.$unique_st[$r1];
			$tot_perm1+= $row_chkstt['permit_amt'];
		}
		
		//array_push($perm_arr,$expvehid1.'-'.$tot_perm1);
		//$tot_perm+= $tot_perm1; $tot_perm1 = 0;
		$tot_perm+= $tot_perm1;
		$stor_perm = ltrim($stor_perm,',');
		
			
		//$rentalrept.= "VEHICLE ".($l+1)." - ".$vehtype."<br>";
		$rentalrept.= "Transfers Rental - &#8377; ".$row_vehics['rent_transfer']."<br>";
		$rent_upl.= $row_vehics['vehicle_id'].'-';
		$rent_upl.= $row_vehics['rent_transfer'].'-';
		$rentalrept.= "Day Rental - &#8377; ".$row_vehics['rent_day']."<br>";
		$rent_upl.= $row_vehics['vehicle_id'].'-';
		$rent_upl.= $row_vehics['rent_day'].'-';
		$rentalrept.= "Max KM Per day - ".$row_vehics['maxkm_perday']." kms"."<br>";
		$rent_upl.= $row_vehics['maxkm_perday'].'-';
		$rentalrept.= "Per KM charge - &#8377; ".$row_vehics['charge_perkm']."<br>";
		$rent_upl.= $row_vehics['charge_perkm'].'-';
		$rentalrept.= "Return travel distance=".$exp_extdis1[1]." kms"."<br>";
		$rent_upl.= $exp_extdis1[1].'-';
		
		$totrent_amt = $trdays * $row_vehics['rent_day'];
		$max_allwd_kms = $trdays * $row_vehics['maxkm_perday'];
		//echo $max_allwd_kms;
		$trdist_extrdis = $trdist + $exp_extdis1[1];
		$rentalrept.= "Distance including return =".$trdist_extrdis." kms"."<br>";
		$rent_upl.= $trdist_extrdis.'-';
		//$permexp = explode('-',$perm_arr[$l]);

		$rentalrept.= "Permit charges - &#8377; ".$tot_perm1."<br>";
		if ($trdist_extrdis > $max_allwd_kms)
		{
			$rentalrept.= "Maximum allowed KMs for ".$trdays." days - ".$max_allwd_kms." kms"."<br>";
			$rent_upl.= $max_allwd_kms.'-';
			$exceed_km = $trdist_extrdis - $max_allwd_kms;
			$rentalrept.= "Exceeded KMs -".$exceed_km." kms"."<br>";
			$rent_upl.= $exceed_km.'-';
			
			$exceed_amt = $exceed_km * $row_vehics['charge_perkm'];
			$totrent_exeed_amt1 = $totrent_amt + $exceed_amt;
			$totrent_exeed_amt = $totrent_amt + $exceed_amt + $tot_perm1;
			$tot_amount_per_veh = $totrent_exeed_amt;
			$rentalrept.= "Rental including extra KMs - &#8377; ".$totrent_exeed_amt1."<br>";
			$rentalrept.= "Rental including extra KMs and permit - &#8377; ".$totrent_exeed_amt."<br><br>";
			//$rent_upl.= $stor_perm.'-';
			$rent_upl.= $tot_perm1.'-';
			$rent_upl.= $totrent_exeed_amt.'/';
		}
		else
		{
			$totrent_exeed_amt1 = $totrent_amt;
			$totrent_exeed_amt = $totrent_amt + $tot_perm1;
			$rentalrept.= "Rental for ".$trdays." days - &#8377; ".$totrent_exeed_amt1."<br>";
			$rentalrept.= "Rental for ".$trdays." days including permit charges - &#8377; ".$totrent_exeed_amt."<br><br>";
			//$rent_upl.= $stor_perm.'-';
			$rent_upl.= $max_allwd_kms.'-'.'0-'.$tot_perm1.'-'.$totrent_exeed_amt.'/';
			$tot_amount_per_veh = $totrent_exeed_amt;
			//$rent_upl.= $tot_perm1.'-';
		}
		$netamount+=$tot_amount_per_veh;
		$rent_eachveh.=$tot_amount_per_veh.'-';
		if (count($arrveh) > 0)
		{
			$rentalrept.= "Amount payable for  ".($l+1)." vehicle(s) - &#8377; ".$netamount."<br><br>";
		}
		$tot_perm1 = 0;
	}
	
	$rentalrept = "Travel days - ".$trdays."<br>".$rentalrept."<br><br>";
	$rentalrept = "Travel distance - ".$trdist."<br>".$rentalrept."<br>";

	$rent_allveh = $cityid.'#'.$rent_upl;

	array_push($netamt_arr,$netamount);
	array_push($retdis_arr,$exp_extdis1[1]);
	array_push($rent_perveh_arr,$rent_eachveh);
	array_push($veh_citid_arr,$cityid);
	array_push($tr_tot_amt,$netamount);
	array_push($data_arr,$rentalrept);
	array_push($vehupl_arr,$rent_upl);
	array_push($allveh_arr,$rent_allveh);
	array_push($perm_arr,$stor_perm.'-'.$tot_perm);
	$rent_eachveh = ''; $stor_perm = '';
	$netamount = 0; $tot_amount_per_veh = 0; $tot_perm = 0; $tot_perm1 = 0; $perm_flag = '';
	$rentalrept = ''; $rent_upl = ''; $rent_allveh = ''; $stor_perm = '';
}
$index = array_search(min($netamt_arr), $netamt_arr);

$new_allveh = '';
foreach($allveh_arr as $eachveh)
{
	$new_allveh.= '~'.$eachveh;
}
$new_allveh = ltrim($new_allveh, '~');
//echo $perm_arr[$index];
//echo $vehupl_arr[$index];
//print_r($vehupl_arr);
//print_r($data_arr);
//echo $data_arr[$index];
echo json_encode(array("detl" => "$data_arr[$index]", "vehupl" => "$vehupl_arr[$index]", "retn" => "$retdis_arr[$index]", "netamt" => "$tr_tot_amt[$index]", "pervehamt" => "$rent_perveh_arr[$index]", "vehcitid" => "$veh_citid_arr[$index]", "tot_perm_amt" => "$perm_arr[$index]", "all_veh_rent" => "$new_allveh")); 
//echo "<input type='hidden' name='ret_dist' value='$retdis_arr[$index]'>";
?>