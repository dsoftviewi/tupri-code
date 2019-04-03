<?php require_once('Connections/divdb.php');
$row = 1;
$conn->beginTransaction();
if (($handle = fopen("missingdates_feb.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        print_r($data);
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
		$hotel_id=$data[0];
		$hotel_name=$data[1];
		$room_type=$data[2];
		$date=date("Y-m-d",strtotime($data[3]));
		$season_rate=$data[4];
		$lunch_rate=$data[5];
		$dinner_rate=$data[6];
		$child_with_bed=$data[7];
		$child_without_bed=$data[8];
		$flower_bed=$data[9];
		$cake_rate=$data[10];
		$candle_light=$data[11];
		$fruit_basket=$data[12];
		$setting = $conn->prepare("SELECT * FROM setting_season where from_date =? and  to_date = ? ");
	$setting->execute(array($date,$date));
	$row_setting= $setting->fetch(PDO::FETCH_ASSOC);
	$totalRows_setting= $setting->rowCount();
	if($totalRows_setting==0){
							$insert_setting=$conn->prepare("INSERT into setting_season set from_date =? ,	to_date = ?,status=0");
							$insert_setting->execute(array($date,$date));
							$stmt = $conn->query("SELECT LAST_INSERT_ID()");
							$sno = $stmt->fetchColumn();
							 
							$season_id = "season".$sno."_id";
							$season_name = date("d M Y", strtotime($date))." TO ".date("d M Y", strtotime($date));
							$up_agent=$conn->prepare("UPDATE setting_season set season_id=?,season_name=?,datetime=now() where sno =?");
							$up_agent->execute(array($season_id,$season_name,$sno));
							$insertHotel=1;
	}
	else{
		$sno=$row_setting['sno'];
	}
	$hotelses = $conn->prepare("SELECT * FROM hotel_season where hotel_id=? and room_type=? and season_sno=?");
	$hotelses->execute(array($hotel_id,$room_type,$sno));
	$row_hotelses= $hotelses->fetch(PDO::FETCH_ASSOC);
	$totalRows_hotelses= $hotelses->rowCount(); 
	
	if($totalRows_hotelses == 0)
	{
		$insert_hotelses=$conn->prepare("INSERT into hotel_season set hotel_id=?, room_type=?, season_sno=?, season_rate=?");
							$insert_hotelses->execute(array($hotel_id,$room_type,$sno,$season_rate));
								}
	else{
		
	$update_hotelses=$conn->prepare("UPDATE  hotel_season set season_rate=? where hotel_id=? and  room_type=? and  season_sno=? ");
							$update_hotelses->execute(array($season_rate,$hotel_id,$room_type,$sno));
	}
	
	
$hotelfd = $conn->prepare("SELECT * FROM hotel_food where hotel_id=?");
$hotelfd->execute(array($hotel_id));
$row_hotelfd= $hotelfd->fetch(PDO::FETCH_ASSOC);
$tot_hotelfd=$hotelfd->rowCount();

$lunch_rate_str = $row_hotelfd['lunch_rate'];
$lunch_rate_arr=unserialize(base64_decode($lunch_rate_str));
if(!is_array($lunch_rate_arr)){
	$lunch_rate_arr[0]=600;
	}
	  

       $lunch_rate_arr[$sno]=$lunch_rate;
	    //print_r($lunch_rate_arr);
		//print "Lunch";
	   $lunch_rate_db=base64_encode(serialize($lunch_rate_arr));

	   //print_r($lunch_rate_arr);
		
	$dinner_rate_str = $row_hotelfd['dinner_rate'];

    $dinner_rate_arr=unserialize(base64_decode($dinner_rate_str));
//print 'hiiiiiiii';
	if(!is_array($dinner_rate_arr)){
	$dinner_rate_arr[0]=600;
	}
	   //print_r($dinner_rate_arr);

       $dinner_rate_arr[$sno]=$dinner_rate;
	   $dinner_rate_db=base64_encode(serialize($dinner_rate_arr));

	   //print_r($dinner_rate_arr);
	   	  	
	$child_with_bed_str = $row_hotelfd['child_with_bed'];

    $child_with_bed_arr=unserialize(base64_decode($child_with_bed_str));
//print "child_with_bed";
	if(!is_array($child_with_bed_arr)){
	$child_with_bed_arr[0]=600;
	}	
	//print_r($child_with_bed_arr);

       $child_with_bed_arr[$sno]=$child_with_bed;
	   $child_with_bed_db=base64_encode(serialize($child_with_bed_arr));

	   //print_r($child_with_bed_arr);
	   
	$child_without_bed_str = $row_hotelfd['child_without_bed'];

    $child_without_bed_arr=unserialize(base64_decode($child_without_bed_str));
if(!is_array($child_without_bed_arr)){
	$child_without_bed_arr[0]=600;
	}
	   //print_r($child_without_bed_arr);

       $child_without_bed_arr[$sno]=$child_without_bed;
	   $child_without_bed_db=base64_encode(serialize($child_without_bed_arr));

	   //print_r($child_without_bed_arr);
	   
	$flower_bed_str = $row_hotelfd['flower_bed'];

    $flower_bed_arr=unserialize(base64_decode($flower_bed_str));
	if(!is_array($flower_bed_arr)){
	$flower_bed_arr[0]=600;
	}

	   //print_r($flower_bed_arr);

       $flower_bed_arr[$sno]=$flower_bed;
	   $flower_bed_db=base64_encode(serialize($flower_bed_arr));

	   //print_r($flower_bed_arr);
	   
	  	
	$candle_light_str = $row_hotelfd['candle_light'];

    $candle_light_arr=unserialize(base64_decode($candle_light_str));
	if(!is_array($candle_light_arr)){
	$candle_light_arr[0]=600;
	}
	   //print_r($candle_light_arr);

       $candle_light_arr[$sno]=$candle_light;
	   $candle_light_db=base64_encode(serialize($candle_light_arr));

	   //print_r($candle_light_arr);
	   	   	
	$cake_rate_str = $row_hotelfd['cake_rate'];

	$cake_rate_arr=unserialize(base64_decode($cake_rate_str));
	if(!is_array($cake_rate_arr)){
	$cake_rate_arr[0]=600;
	}
	   //print_r($cake_rate_arr);

       $cake_rate_arr[$sno]=$cake_rate;
	   $cake_rate_db=base64_encode(serialize($cake_rate_arr));

	   //print_r($cake_rate_arr);
	   	   	
	$fruit_basket_str = $row_hotelfd['fruit_basket'];

	$fruit_basket_arr=unserialize(base64_decode($fruit_basket_str));
	if(!is_array($fruit_basket_arr)){
	$fruit_basket_arr[0]=600;
	}

	   //print_r($fruit_basket_arr);

       $fruit_basket_arr[$sno]=$fruit_basket;
	   $fruit_basket_db=base64_encode(serialize($fruit_basket_arr));

	   //print_r($fruit_basket_arr);
	   
	   if($tot_hotelfd == 0)
	   {
		   $insert_hotelses=$conn->prepare("INSERT into hotel_food set lunch_rate=?, dinner_rate=?, child_with_bed=?, child_without_bed=?, flower_bed=?, candle_light=?, cake_rate=?, fruit_basket=?, status=0");
							$insert_hotelses->execute(array($lunch_rate_db,$dinner_rate_db,$child_with_bed_db,$child_without_bed_db,$flower_bed_db,$candle_light_db,$cake_rate_db,$fruit_basket_db));
						print 	$lunch_rate_db;
								}
	else{
		
	$update_hotelses=$conn->prepare("UPDATE hotel_food set lunch_rate=?, dinner_rate=?, child_with_bed=?, child_without_bed=?, flower_bed=?, candle_light=?, cake_rate=?, fruit_basket=?, status=0 where hotel_id=?");
							$update_hotelses->execute(array($lunch_rate_db,$dinner_rate_db,$child_with_bed_db,$child_without_bed_db,$flower_bed_db,$candle_light_db,$cake_rate_db,$fruit_basket_db,$hotel_id));
		   print 	$lunch_rate_db;
    }
    }
    $conn->commit();
    fclose($handle);
}
?>