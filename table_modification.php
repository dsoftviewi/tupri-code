<?php 
	require_once('Connections/divdb.php');
	
	$tables = $conn->prepare("SELECT * FROM travel_master where substr(date_of_reg,1,10) <'2016-02-04' and `sub_paln_id` =''");
	$tables->execute();
	//$row_tables = mysql_fetch_assoc($tables);
	$row_tables_main=$tables->fetchAll();
	$tot_tables= $tables->rowCount();

	foreach($row_tables_main as $row_tables)
	{
		$update=$conn->prepare("update travel_master set sub_paln_id=? where plan_id=?");
		$update->execute(array($row_tables['plan_id'],$row_tables['plan_id']));
	}

?>