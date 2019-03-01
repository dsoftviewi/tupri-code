<?php
require_once('../Connections/divdb.php');


//$query_cities = "SELECT * FROM dvi_cities WHERE type = 'AD' and status = 0 ORDER BY name ASC";
$cities= $conn->prepare("select t2.* from vehicle_rent as t1 inner join dvi_cities as t2 on t2.id=t1.city group by t1.city");
$cities->execute();
$row_cities_main = $cities->fetchAll();
$totalRows_cities = $cities->rowCount();
?>

<select class="form-control chosen-select" id="st_city" name="st_city" tabindex="2" onChange="getvehicles(this.value);delrow();">
	<option value="">-- Select Source Point --</option>
    <?php
	foreach($row_cities_main as $row_cities)
	{
		
		    $states = $conn->prepare("SELECT * FROM dvi_states where code=?");
			$states->execute(array($row_cities[region]));
			$row_states =$states->fetch(PDO::FETCH_ASSOC);
			$totalRows_states = $states->rowCount();
	?>
		<option value="<?php echo $row_cities['id'].'-'.$row_cities['ss_dist']; ?>"><?php echo $row_cities['name'].' - '.$row_states['name']; ?></option>
        <?php
	}
	
		?>
</select>