<?php
require_once('../Connections/divdb.php');

$arr_vehids = $_GET['arr_vehids'];
$exp_vehids = explode(',',$arr_vehids);

$city_id = $_GET['city_id'];
$exp_cityid = explode('-',$city_id);
$arr_cityid = trim($exp_cityid[0]);
//$arr_lat = trim($exp_cityid[1]);
//arr_lng = trim($exp_cityid[2]);


$cities = $conn->prepare("SELECT * FROM dvi_cities WHERE type = 'AD' and status = 0 ORDER BY name ASC");
$cities->execute();
$row_cities_main = $cities->fetchAll();
$totalRows_cities = $cities->rowCount();


$chkrow = $conn->prepare("SELECT * FROM setting_dist");
$chkrow->execute();
$row_chkrow = $chkrow->fetch(PDO::FETCH_ASSOC);
$totalRows_chkrow = $chkrow->rowCount();

$bfrm=$_GET['frm'];
?>

<select class="form-control chosen-select1 tooltips" id="<?php echo $bfrm; ?>_row_city<?php echo $_GET['incr1']; ?>" name="row_city[]" tabindex="2" onchange="alertdist(this.value)">
	<option value="">-- Nearest Departure Point --</option>
    <?php
	foreach($row_cities_main as $row_cities)
	{
		//$dist_diff = distanceGeoPoints($arr_lat,$arr_lng,$row_cities['latitude'],$row_cities['longitude']);
		$dist_diff = 0;
		
		
		$dist_calc1 = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid =? and to_cityid =?");
		$dist_calc1->execute(array($arr_cityid,$row_cities['id']));
		$row_dist_calc1 =$dist_calc1->fetch(PDO::FETCH_ASSOC);
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
		
		if ($dist_diff <= $row_chkrow['dep_dist'])
		{
			
			$states = $conn->prepare("SELECT * FROM dvi_states where code=?");
			$states->execute(array($row_cities[region]));
			$row_states =$states->fetch(PDO::FETCH_ASSOC);
			$totalRows_states = $states->rowCount();
			
			$fnd = '';
			for($n=0;$n<count($exp_vehids);$n++)
			{
				
				
				$chkveh = $conn->prepare("SELECT * FROM vehicle_rent where vehicle_id=? and city=?");
				$chkveh->execute(array($exp_vehids[$n],$row_cities[id]));
				$row_chkveh = $chkveh->fetch(PDO::FETCH_ASSOC);
				$totalRows_chkveh =$chkveh->rowCount();
				
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
				<option value="<?php echo $row_cities['id'].' - '.$row_cities['ss_dist'].'-'.$vehflag.'-'.$dist_diff; ?>"><?php echo $row_cities['name'].' - '.$row_states['name']; ?></option>
				<?php
		}
	}
	
	
	function distanceGeoPoints($lat1, $lng1, $lat2, $lng2) 
	{
		$earthRadius = 3958.75;
	
		$dLat = deg2rad($lat2-$lat1);
		$dLng = deg2rad($lng2-$lng1);
		
		
		$a = sin($dLat/2) * sin($dLat/2) +
		   cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
		   sin($dLng/2) * sin($dLng/2);
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		$dist = $earthRadius * $c;
		
		// from miles
		$kmeterConversion = 1.609;
		$geopointDistance = $dist * $kmeterConversion;
		
		return $geopointDistance;
	}
	
		?>
</select>
