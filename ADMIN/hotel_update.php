<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>

<html>
<head>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- PLUGINS CSS -->
		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
</head>        
      <body>

<?php 
require_once('../Connections/divdb.php');
$hotel_id=$_GET['hid'];

	$hotel = $conn->prepare("SELECT * FROM hotel_pro where status = '0' and hotel_id=?");
	$hotel->execute(array($hotel_id));
	$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);

if ((isset($_POST["update_hotel"])) && ($_POST["update_hotel"] == "update_hotel_val")) {	

	
 	$update_hot=$conn->prepare("update hotel_pro set hotel_name=?, location=?, city=?, state=?, category=?, hotel_link=?, hotel_prior=? where hotel_id=?");
	$update_hot->execute(array($_POST['hotel_name'],$_POST['hotel_addr'],$_POST['hotel_city'],$_POST['hotel_state'],$_POST['hotel_type'],$_POST['hotel_url'],$_POST['prior'],$hotel_id));

//echo $_POST['rt_name'];
		for($i=0;$i<$_POST['rt_name']; $i++)
		{
			//echo $_POST['room_type'][$i];
		$update_season=$conn->prepare("update hotel_season set room_type=? where hotel_id=? and sno=?");
		$update_season->execute(array($_POST['room_type'][$i],$hotel_id,$_POST['sno'][$i]));

		}
		$zero=0;
		$leng=trim($_POST['new_count']);
		if($leng!='')
		{
			for($h=0;$h<=$leng;$h++)
			{
				if(trim($_POST['new_room_add'][$h]) !='')
				{
			 $insertHotelSes=$conn->prepare('insert into hotel_season(hotel_id, room_type, season1_rate, season2_rate, season3_rate, season4_rate, season5_rate, season6_rate,season7_rate, season8_rate, season9_rate, datetime,  status) values(?,?,?,?,?,?,?,?,?,?,?,?,"0" )');
			
			  	$insertHotelSes->execute(array($hotel_id,$_POST['new_room_add'][$h],$zero,$zero,$zero,$zero,$zero,$zero,$zero,$zero,$zero,$row_hotel['datetime']));
				}
			}
		}else
		{
			if(trim($_POST['new_room_add'][0]) !='')
				{
			 $insertHotelSes=$conn->prepare('insert into hotel_season(hotel_id, room_type, season1_rate, season2_rate, season3_rate, season4_rate, season5_rate, season6_rate, season7_rate, season8_rate, season9_rate, datetime, status) values(?,?,?,?,?,?,?,?,?,?,?,?,"0" )');
			
			  	$insertHotelSes->execute(array($hotel_id,$_POST['new_room_add'][0],$zero,$zero,$zero,$zero,$zero,$zero,$zero,$zero,$zero,$row_hotel['datetime']));
				}
			
		}
		echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."';</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";

}
	

	
								
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']; ?>&nbsp; - Update 
								<span class="right-content">
													<?php echo "Hotel ID : ".$row_hotel['hotel_id'];?>				
                                        </span>
								</h3>
							  </div> 
                           
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
                            <form name="update_hotel" role="form"  method="post" class="form-horizontal" onSubmit="return validate_me()" >   
					
                    <div class="row">
									<div class="col-sm-12">
                                    <div class="form-group">
                                   <div class="input-group-sm col-sm-6">
										  <label >		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Hotel Name </label>
								</div>
                                <div class="input-group-sm col-sm-6">
										  <input type="text" name="hotel_name" id="hotel_name" class="form-control"   placeholder="Name of the hotel" value="<?php echo $row_hotel['hotel_name']; ?>">
								</div>
                                        </div>
                                        </div>
                    </div>
                    
                    
								<div class="row">
									<div class="col-sm-12 ">
                                    <div class="form-group">
                                    <div class="input-group-sm col-sm-6">
										  <label >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          Hotel Type </label>
										</div>
                                        <div class="input-group-sm col-sm-6">
										  <!-- <input type="text" name="hotel_type" id="hotel_type" class="form-control"  placeholder="Hotel category" value="<?php echo $row_hotel['category']; ?>"> -->
										  <select class="chosen-select" id="hotel_type" name="hotel_type" data-placeholder="Choose Hotel Category">
										  	<option></option>
<option <?php if($row_hotel['category']=='2STAR' || $row_hotel['category']=='2 STAR' || $row_hotel['category']=='2star' || $row_hotel['category']=='2 star' || $row_hotel['category']=='2Star' || $row_hotel['category']=='2 Star') { ?> selected <?php } ?> value="2STAR" >2STAR</option>
<option <?php if($row_hotel['category']=='3STAR' || $row_hotel['category']=='3 STAR' || $row_hotel['category']=='3star' || $row_hotel['category']=='3 star' || $row_hotel['category']=='3Star' || $row_hotel['category']=='3 Star') { ?> selected <?php } ?> value="3STAR" >3STAR</option>
<option <?php if($row_hotel['category']=='4STAR' || $row_hotel['category']=='4 STAR' || $row_hotel['category']=='4star' || $row_hotel['category']=='4 star' || $row_hotel['category']=='4Star' || $row_hotel['category']=='4 Star') { ?> selected <?php } ?> value="4STAR" >4STAR</option>
<option <?php if($row_hotel['category']=='5STAR' || $row_hotel['category']=='5 STAR' || $row_hotel['category']=='5star' || $row_hotel['category']=='5 star' || $row_hotel['category']=='5Star' || $row_hotel['category']=='5 Star') { ?> selected <?php } ?> value="5STAR" >5STAR</option>
<option <?php if($row_hotel['category']=='Houseboat' || $row_hotel['category']=='houseboat' || $row_hotel['category']=='HOUSEBOAT' || $row_hotel['category']=='House boat' || $row_hotel['category']=='HOUSE BOAT' || $row_hotel['category']=='house boat' || $row_hotel['category']=='House Boat') { ?> selected <?php } ?> value="House Boat" >House Boat</option>
 											</select>
										</div>
                                        </div>
                                        </div>
                                    </div>
                                						
                        <div class="row">
									<div class="col-sm-12 ">
                                    <div class="form-group">
                                    <div class="input-group-sm col-sm-6">
										  <label >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          State</label>
										</div>
                                        <div class="input-group-sm col-sm-6">
										   <?php 
									
									$hotelstate = $conn->prepare("SELECT * FROM dvi_states");
									$hotelstate->execute();
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelstate_main=$hotelstate->fetchAll();
									?>
									 <select data-placeholder="Choose a State" name="hotel_state" id="hotel_state" class="form-control chosen-select " tabindex="2" onChange="find_city1(this.value);change_prio_def();">									
                                         <option></option>	
										 <?php foreach($row_hotelstate_main as $row_hotelstate) {
											 if($row_hotel['state']==$row_hotelstate['code'])
											 {
											 ?>
                                  <option selected value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option>           
                                             <?php }else{?>
										<option value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option>
                                        <?php 
											 }
											 } ?>
									</select>
										</div>
                                        </div>
                                        </div>
                  </div>
                                    
                  <div class="row">
									<div class="col-sm-12 ">
                                    <div class="form-group">
                                    <div class="input-group-sm col-sm-6">
										  <label >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          city</label>
										</div>
                                        <div class="input-group-sm col-sm-6" id="default_city_id">
										  <?php 
									
									$hotelcity = $conn->prepare("SELECT * FROM  dvi_cities where region=?");
									$hotelcity->execute(array($row_hotel['state']));
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelcity_main=$hotelcity->fetchAll();
									?>
										 <select data-placeholder="Choose City" name="hotel_city" id="hotel_city" class="form-control chosen-select " tabindex="2" onChange="show_priority(this.value)" >									
                                         <option ></option>	
										 <?php foreach($row_hotelcity_main as $row_hotelcity) {
											 if($row_hotel['city']==$row_hotelcity['id'])
											 {
											 ?>
                                  <option selected value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>           
                                             <?php }else{?>
										<option value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>
                                        <?php 
											 }
											 } ?>
									</select>
										</div>
                                        </div>
                                        </div>
                                    
                      </div>
                                    
                    <div class="row">
									<div class="col-sm-12 ">
                                    <div class="form-group">
                                    <div class="input-group-sm col-sm-6">
										  <label >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          Address of the hotel </label>
										</div>
                                        <div class="input-group-sm col-sm-6">
						 <textarea class="form-control"  style="height:100px;resize:none;" id="hotel_addr" name="hotel_addr"><?php echo $row_hotel['location']; ?></textarea>
										</div>
                                        </div>
                                        </div>
                        </div>
                        
                        <div class="row">
									<div class="col-sm-12 ">
                                    <div class="form-group">
                                    <div class="input-group-sm col-sm-6">
										  <label >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          URL of the hotel </label>
										</div>
                                        <div class="input-group-sm col-sm-6">
						 <input type="text" name="hotel_url" id="hotel_url" class="form-control"  placeholder="Hotel URL (Link)" value="<?php echo $row_hotel['hotel_link']; ?>">
										</div>
                                        </div>
                                        </div>
                        </div>
                        
                        <div class="row">
									<div class="col-sm-12 ">
                                    <div class="form-group">
                                    <div class="input-group-sm col-sm-6">
										  <label > 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          Hotel priority </label>
										</div>
                                        <div class="input-group-sm col-sm-6" id="def_hotl_prior">
										  <?php 
									
									$hotelprior = $conn->prepare("SELECT * FROM  hotel_pro where city=?");
									$hotelprior->execute(array($row_hotel['city']));
									//$row_hotelprior= mysql_fetch_assoc($hotelprior);
									$row_hotelprior=$hotelprior->fetch(PDO::FETCH_ASSOC);
									$tot_prior=$hotelprior->rowCount();
									?>
								 <select data-placeholder="Choose Priority" name="prior" id="prior" class="form-control chosen-select " tabindex="2" >									
                                         <option ></option>	
										<?php for($pr=1;$pr<=$tot_prior;$pr++){
											$row_hotelprior= $hotelprior->fetch(PDO::FETCH_ASSOC);
													if($pr==$row_hotelprior['hotel_prior'])
													{?>
                                         <option selected value="<?php echo $pr; ?>"><?php echo $pr; ?></option>          
                                                    <?php }else{ ?>
                                         <option value="<?php echo $pr; ?>"><?php echo $pr; ?></option>
                                        <?php }
										 }//for loop?>
									</select>
										</div>
                                        </div>
                                        </div>
                        </div>
                                    <hr>
<?php

	$season = $conn->prepare("SELECT * FROM hotel_season where status = '0' and hotel_id=?");
	$season->execute(array($hotel_id));
	//$row_season = mysql_fetch_assoc($season);
	$row_season_main=$season->fetchAll();
?>

			<div class="row">
									<div class="col-sm-12 ">
                                    <div class="form-group">
                                     <?php
									$rt=0;
									 foreach($row_season_main as $row_season){ ?>
                                    <div class="input-group-sm col-sm-6" id="diva<?php echo $rt; ?>">
                                    <?php if($rt==0){?>
										  <label >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          Available room type(s) </label>
                                          <?php }?>
										</div>
                                        <div class="input-group-sm col-sm-5" id="divb<?php echo $rt; ?>">
										  
				<input type="text" name="room_type[<?php echo $rt; ?>]" id="room_type<?php echo $rt; ?>" class="form-control"  placeholder="Room type" value="<?php echo $row_season['room_type']; ?>"> 
                <input type="hidden" value="<?php echo $row_season['sno'];?>" name="sno[<?php echo $rt; ?>]" >
               
                <br>
                
                
										</div>
                                        <div class="input-group-sm col-sm-1" id="divc<?php echo $rt; ?>">
                                        <a class="btn" id="rem<?php echo $rt;?>" onClick="remove_room_type('<?php echo $row_season['sno']; ?>','<?php echo $rt;?>')"><i class="fa fa-minus"></i></a>
                                        </div>
                                        <?php 
				$rt++;
				} ?>
                <input type="hidden" value="<?php echo $rt;?>" name="rt_name" id="rt_id">
                                        </div>
                                        </div>
                  </div>
                  
                  <div class="row" id="new_rooms">
									<div class="col-sm-12 ">
                                    <div class="form-group">
                                   
                                    <div class="input-group-sm col-sm-6">
                                 <label >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          Add room type(s) </label>
										</div>
                                        <div class="input-group-sm col-sm-5">
			<input type="text" name="new_room_add[<?php echo "0"; ?>]" id="new_room_add<?php echo '0'; ?>" class="form-control"  placeholder="Room type">
										</div>
                                        <div class="input-group-sm col-sm-1">
                                       <a class="btn" id="addd0" onClick="add_new_rooms()"><i class="fa fa-plus"></i></a>
                                        </div>
                                    
                                        </div>
                                        </div>
                  </div>
                  <input type="hidden" name="new_count" id="new_count" >
                  
                  
                  

							<div class="form-group">
                            <hr>
								<div class=" col-lg-offset-9 col-lg-3">
						<button type="submit" class="btn btn-primary pull-right" name="update_hotel" value="update_hotel_val">Update</button>
								</div>
							</div>
						</form>
					 
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                    
						</div>
                        </div>
                        </div>
                        
 </body>    
 </html>    
 
 <script>

function getXMLHTTP() 
{ //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
}


function find_city1(state_id)
{
		var type=2;
		var strURL="ajax_hotel.php?sid="+state_id+"&type="+type;
		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4 && req.status == 200) {
					//alert(req.responseText);
					$('#default_city_id').empty().html(req.responseText);
							$('.chosen-select').chosen();
					} 
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}	
}

function show_priority(cid)
{ 
	var type=20;
	$.get('ajax_hotel.php?cid='+cid+'&type='+type,function(result){ 
		//alert(result);
		$('#def_hotl_prior').empty().html(result);
		$('.chosen-select').chosen();
	});
}


function change_prio_def()
{
	$('#def_hotl_prior').empty().html("<input type='text' name='prior' id='prior' value='1' class='form-control'/>");
}

function remove_room_type(sno,rno)
{

var type=5;
		var strURL="ajax_hotel.php?sno="+sno+"&type="+type;
		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4 && req.status == 200) {
					$('#room_type'+rno).hide();
					$('#rem'+rno).hide();
					$('#diva'+rno).hide();
						$('#divb'+rno).hide();
							$('#divc'+rno).hide();
					} 
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}	
}
var rcnt=1;
function add_new_rooms()
{
	//alert('add'+rcnt);
	document.getElementById('new_count').value=rcnt;
	
$("#new_rooms").append("<div class='col-sm-12 ' id='div"+rcnt+"'><div class='form-group'><div class='input-group-sm col-sm-6'><label></label></div><div class='input-group-sm col-sm-5'><input type='text' name='new_room_add["+rcnt+"]' id='new_room_add"+rcnt+"' class='form-control' placeholder='Room type'></div><div class='input-group-sm col-sm-1'><a class='btn' id='addd"+rcnt+"' onClick='remove_new_rooms("+rcnt+")'><i class='fa fa-minus'></i></a></div></div></div>");

rcnt++;
}

function remove_new_rooms(cnt)
{
	//alert(cnt);
	$('#div'+cnt).hide();
	document.getElementById('new_room_add'+cnt).value='';
}

function validate_me()
{
	var numbers =  /^\d+$/;
	if($('#hotel_name').val().trim()=='')
	{
		alert('Please Enter Hotel Name');
		$('#hotel_name').focus();
		return false;	
	}else if($('#hotel_name').val().trim().length < 4)
	{
		alert('Hotel name should be minimum 4 characters');
		$('#hotel_name').focus();
		return false;
	}else if($('#hotel_type').val().trim() == '')
	{
		alert('Please Enter Hotel Type');
		$('#hotel_type').focus();
		return false;
	}else if($('#hotel_state').val().trim() == '')
	{
		alert('Please Enter Hotel Located State');
		$('#hotel_state').focus();
		return false;
	}else if($('#hotel_city').val().trim() == '')
	{
		alert('Please Enter Hotel Located City');
		$('#hotel_city').focus();
		return false;
	}else if($('#hotel_addr').val().trim() =='')
	{
		alert('Please Enter Hotel Address');
		$('#hotel_addr').focus();
		return false;
	}else if($('#hotel_addr').val().trim().length < 5)
	{
		alert('Please Enter Valid Hotel Address');
		$('#hotel_addr').focus();
		return false;
	}else if($('#prior').val()=='')
	{
		alert('Please Enter Priority (integer value)');
		$('#prior').focus();
		return false;
	}else if(!numbers.test($('#prior').val()))
	{
		alert('Please Enter Priority In Integer Value');
		$('#prior').focus();
		return false;
	}else{
		return true;	
	}
}

</script>
                               
                        <script src="../core/assets/js/jquery.min.js"></script>
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
		<script src="../core/assets/plugins/skycons/skycons.js"></script>
		<script src="../core/assets/plugins/prettify/prettify.js"></script>
		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<!--<script src="../core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="../core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="../core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>-->
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
	<!--	<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="../core/assets/plugins/markdown/markdown.js"></script>
		<script src="../core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="../core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>
		<script src="../core/assets/plugins/toastr/toastr.js"></script>-->
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
       
       <script>
         $('.chosen-select').chosen({'width':'100%'});
		 </script>