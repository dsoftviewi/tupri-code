<?php
require_once('../Connections/divdb.php');

$cities = $conn->prepare("SELECT * FROM dvi_cities  ORDER BY name ASC");
$cities->execute();
$row_cities = $cities->fetch(PDO::FETCH_ASSOC);
$totalRows_cities =$cities->rowCount();
?>

<select class="form-control chosen-select1" id="row_city<?php echo $_GET['incr1'].$_GET['incr2']; ?>" name="row_city<?php echo $_GET['incr1'].$_GET['incr2']; ?>" tabindex="2" onchange="">
	<option value="">-- Choose city to visit --</option>
    <?php /*?><?php
	do
	{
		mysql_select_db($database_divdb, $divdb);
		$query_states = "SELECT * FROM dvi_states where code='$row_cities[region]'";
		$states = mysql_query($query_states, $divdb) or die(mysql_error());
		$row_states = mysql_fetch_assoc($states);
		$totalRows_states = mysql_num_rows($states);
	?>
		<option value="<?php echo $row_cities['id'].' - '.$row_cities['latitude'].' - '.$row_cities['longitude']; ?>"><?php echo $row_cities['name'].' - '.$row_states['name']; ?></option>
		<?php
	}
	while($row_cities = mysql_fetch_assoc($cities));
		?><?php */?>
</select>

