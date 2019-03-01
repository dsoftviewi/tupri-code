<?php
require_once('../Connections/divdb.php');

$cityid = $_GET['city_id'];
$frm=$_GET['frm'];

$vehics = $conn->prepare("SELECT * FROM vehicle_pro where vehi_id in (SELECT vehicle_id FROM vehicle_rent where city=?) Order by vehicle_seat");
$vehics->execute(array($cityid));
$row_vehics_main = $vehics->fetchAll();
$totalRows_vehics = $vehics->rowCount();
?>

<select class="form-control chosen-select" id="<?php echo $frm; ?>_st_vehic<?php echo $_GET['incr']; ?>" name="<?php echo $frm; ?>_st_vehic<?php echo $_GET['incr']; ?>" tabindex="2" onchange="seatinfo('<?php echo $frm; ?>')">
	<!--<option value="">-- Available vehicles in chosen city --</option>-->
        <?php
		if ($totalRows_vehics > 0)
		{
			foreach($row_vehics_main as $row_vehics)
			{
			?>
			<option value="<?php echo $row_vehics['vehi_id'].'-'.$row_vehics['vehicle_seat']; ?>"><?php echo $row_vehics['vehicle_type'].' ~ '.$row_vehics['vehicle_seat'].' seater'; ?></option>
			<?php
			}
			
		}
		else
		{
			
			$citynm1 = $conn->prepare("SELECT * FROM dvi_cities where id=?");
			$citynm1->execute(array($cityid));
			$row_citynm1 = $citynm1->fetch(PDO::FETCH_ASSOC);
			$totalRows_citynm1 = $citynm1->rowCount();
			
			if ($totalRows_citynm1 > 0)
			{
			?>
                <option value="" style="color:#903" disabled>-- NO VEHICLES AVAILABLE IN  <?php echo strtoupper($row_citynm1['name']); ?>--</option>
            <?php
			}
		}
        ?>
</select>
