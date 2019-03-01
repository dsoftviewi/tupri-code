<?php
require_once('../Connections/divdb.php');

$arr_vehids = $_GET['arr_vehids'];
$exp_vehids = explode(',',$arr_vehids);
//print_r($exp_vehids);
$city_id = $_GET['city_id'];
$exp_cityid = explode('-',$city_id);
$arr_cityid = trim($exp_cityid[0]);
//$arr_lat = trim($exp_cityid[1]);
//$arr_lng = trim($exp_cityid[2]);



if(trim($_GET['chek'])=='2')
{
$cities = $conn->prepare("SELECT * FROM dvi_cities where status = 0 ORDER BY name ASC");
}else if(trim($_GET['chek'])=='1')
{
$cities=$conn->prepare("SELECT * FROM dvi_cities where id IN (select city from hotel_pro GROUP BY city )ORDER BY name ASC");
}
$cities->execute();
$row_cities_main =$cities->fetchAll();
$totalRows_cities = $cities->rowCount();


$chkrow = $conn->prepare("SELECT * FROM setting_dist");
$chkrow->execute();
$row_chkrow = $chkrow->fetch(PDO::FETCH_ASSOC);
$totalRows_chkrow =$chkrow->rowCount();

$bfrm=$_GET['frm'];
?>

<select class="form-control chosen-select1" id="<?php echo $bfrm; ?>_row_city<?php echo $_GET['incr1']; ?>" name="row_city[]" tabindex="2" onchange="nextrow_val('<?php echo $bfrm; ?>','<?php echo $_GET['incr1'] ?>')">
	<option value="">-- Choose city to visit --</option>
    <?php
	foreach($row_cities_main as $row_cities)
	{
		$dist_diff = 0;
		//$dist_diff = distanceGeoPoints($arr_lat,$arr_lng,$row_cities['latitude'],$row_cities['longitude']);
		
		$dist_calc1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid =? and to_cityid =?");
		$dist_calc1->execute(array($arr_cityid,$row_cities['id']));
		$row_dist_calc1 = $dist_calc1->fetch(PDO::FETCH_ASSOC);
		$Rows_dist_calc1 = $dist_calc1->rowCount();
		
		if($Rows_dist_calc1 > 0)
		{
			$dist_diff = $row_dist_calc1['dist'];
		}
		else
		{
			
			$dist_calc2 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid =? and to_cityid =?");
			$dist_calc2->execute(array($row_cities['id'],$arr_cityid));
			$row_dist_calc2 = $dist_calc2->fetch(PDO::FETCH_ASSOC);
			$Rows_dist_calc2 = $dist_calc2->rowCount();
			
			if($Rows_dist_calc2 > 0)
			{
				$dist_diff = $row_dist_calc2['dist'];
			}
		}

		if ($dist_diff <= $row_chkrow['gen_dist'])
		{
			
			$city_main_arr[$dist_diff."_".$row_cities['id']]=$row_cities;
		}
	}
	ksort($city_main_arr);
	
		foreach($city_main_arr as $row_cities ){	
			$states = $conn->prepare("SELECT * FROM dvi_states where code=?");
			$states->execute(array($row_cities['region']));
			$row_states = $states->fetch(PDO::FETCH_ASSOC);
			$totalRows_states =$states->rowCount();
			
			$fnd = '';
			for($n=0;$n<count($exp_vehids);$n++)
			{
				
				$chkveh = $conn->prepare("SELECT * FROM vehicle_rent where vehicle_id=? and city=?");
				$chkveh->execute(array($exp_vehids[$n],$row_cities['id']));
				$row_chkveh =$chkveh->fetch(PDO::FETCH_ASSOC);
				$totalRows_chkveh = $chkveh->rowCount();
				
				if ($totalRows_chkveh == 0)
				{
					$fnd = 'N';
				}
			}
			if ($fnd == 'N')
			{
				$vehflag = '0';
			}
			else
			{
				$vehflag = '1';
			}
		?>
			<option value="<?php echo $row_cities['id'].' - '.$row_cities['ss_dist'].'-'.$vehflag; ?>"><?php echo $row_cities['name'].' - '.$row_states['name']; ?></option>
			<?php
		
	}
	
	?>
</select>

