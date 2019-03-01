<?php


if (!function_exists("GetSQLValueString")) { 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}



 if(isset($_POST['addtion_submit']) && ($_POST['addtion_submit']=="addtion_submit_val"))
 {
	$cnt=trim($_POST['tot_cnt_addi']);
	
	for($l=1;$l<=$cnt;$l++)
	{
		if(isset($_POST['ac_name'.$l]))
		{
			$insert_addi= $conn->prepare("insert into additional_cost (city_id,short_desc,fdate,tdate,amount,status,place)values(?,?,?,?,?,'0',?)");
            $insert_addi->execute(array($_POST['ac_sel'.$l],$_POST['ac_name'.$l],$_POST['ac_fdate'.$l],$_POST['ac_tdate'.$l],$_POST['ac_amount'.$l],$_POST['place'.$l]));
		}
	}
	
echo "<script>window.location.reload();</script>";
 }
 
 
 if(isset($_POST['addtion_submit_updt']) && ($_POST['addtion_submit_updt']=="addtion_submit_updt_val"))
 {
			$sno=trim($_POST['addi_updt_id']);

			$insert_addi=$conn->prepare("UPDATE additional_cost set city_id=?, short_desc=?, fdate=?, tdate=?, amount=?, place=? where sno=?");
			$insert_addi->execute(array($_POST['ac_sel_upd'],$_POST['ac_name_upd'],$_POST['ac_fdate_upd'],$_POST['ac_tdate_upd'],$_POST['ac_amount_upd'],$_POST['ac_pla_upd'],$sno));

			echo "<script>window.location.reload();</script>";
 }
 
 
 
?>
<style>
 .ss
{
	background-color:transparent !important ;
}
.nav-dropdown-contents{

	height: auto;

	min-width: 248px;

	max-width: 240px;
	overflow-y:auto;
	
}

.nav-dropdown-contents ul{

	padding: 0;

	margin: 0;

	list-style: none;

}

.nav-dropdown-contents ul li{

	display: block;

	border-bottom: 1px solid #F5F7FA;

}

.nav-dropdown-contents.static-list ul li,

.nav-dropdown-contents ul li a{

	padding: 20px 10px 10px 20px;

	display: block;

	position: relative;

	height: 60px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

	text-decoration: none;

	color: #656D78;

	background: #fff;

}

.nav-dropdown-contents ul li a:hover{

	color: #434A54;

}
.scroll-nav-dropdowns
{
	height:auto;
	width:240px;
}

.red_col
{
	font-weight:600;
	color:#900;
	text-align:center;
}
.reduce_padd
{
    padding-left: 3px;
    padding-right: 3px;
	text-align:center;
}

.datepicker{
	z-index:10000000;
	
}


</style>

<?php 
						   
	$addi = $conn->prepare("SELECT * FROM additional_cost where status != '2' ORDER BY sno ASC");
	$addi->execute();
	//$row_addi = mysql_fetch_assoc($addi);
	$row_addi_main=$addi->fetchAll();
	$totalRows_addi = $addi->rowCount();
?>
	<div class="container-fluid">
				
				<!-- Begin page heading -->
				<h1 class="page-heading">Itinerary Additional Cost<small>&nbsp;Manage Additional Cost</small></h1>
				
					<div class="row">
                        <div class="col-lg-12">
                        <div class="modal fade in" id="addi_cost_updt" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
										  <!-- ajax update additional cost from ajax_voucher.php type 2 -->
										</div>
                        
                        
                        <div class="modal fade in" id="addi_cost" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
										  <div class="modal-dialog modal-lg" style="width: 1190px">
                    <form name="form_addi_cost_sett" id="form_addi_cost_sett" method="post" onsubmit="return vali_additional()">
											<div class="modal-content modal-no-shadow modal-no-border">
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-cogs"></i>&nbsp;Additional Cost</h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
                                                <div id="paret_div">
                                                  <?php 
													$city_par= $conn->prepare("SELECT * FROM dvi_cities where status = '0' ORDER BY name ASC");
													$city_par->execute();
													//$row_city_par = mysql_fetch_assoc($city_par);
													$row_city_par_main=$city_par->fetchAll();
													$totalRows_city_par = $city_par->rowCount();
												?>
                                                <select name="ac_sel_par" id="ac_sel_par" style="display:none">
                                                	<?php foreach($row_city_par_main as $row_city_par)
													{ ?>
                                                	<option value="<?php echo $row_city_par['id']; ?>"> <?php echo $row_city_par['name']; ?> </option>
                                                    <?php } ?>
                                                </select>
                                                
                                                <div class="col-sm-12">
                                                <div class="col-sm-2 red_col" > Choose City </div>
                                                 <div class="col-sm-2 red_col" > Choose Place </div>
                                                <div class="col-sm-2 red_col"> Short Name </div>
                                                <div class="col-sm-1 red_col" style="width: 133px"> From Date </div>
                                                <div class="col-sm-1 red_col" style="width: 133px"> To Date </div>
                                                <div class="col-sm-1 red_col"> Amount </div>
                                                <div class="col-sm-2 red_col"> Add/Remove </div>
                                                </div>
                                                
                                                <div class="col-sm-12" id="ac_div1" style="margin-top:20px;">
                                                <div class="col-sm-2 reduce_padd" > 
                                                <?php 
													$city= $conn->prepare("SELECT * FROM dvi_cities where status = '0' ORDER BY name ASC");
													$city->execute();
													//$row_city = mysql_fetch_assoc($city);
													$row_city_main=$city->fetchAll();
													$totalRows_city = $city->rowCount();
												?>
                                                <select class="chosen-select" name="ac_sel1" id="ac_sel1" onchange="place_det(this.value,'1')">
                                                	<?php foreach($row_city_main as $row_city)
													{ ?>
                                                	<option value="<?php echo $row_city['id']; ?>"> <?php echo $row_city['name']; ?> </option>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                                <div class="col-sm-2 reduce_padd" id="place_view1" > 
                                                
                                                <select class="chosen-select" hidden>                                     	
                                                </select>
                                                </div>
                                                <div class="col-sm-2 reduce_padd">
                                                	<input type="text" class="form-control" name="ac_name1" id="ac_name1" >
                                                </div>
                                                <div class="col-sm-2 reduce_padd" style="width: 133px">
                                                	<input type="text" class="form-control datepicker_ac datepicker" name="ac_fdate1" id="ac_fdate1" data-date-format='yyyy-mm-dd' readonly="readonly" >
                                                </div>
                                                <div class="col-sm-2 reduce_padd" style="width: 133px">
                                                	<input type="text" class="form-control datepicker_ac datepicker" name="ac_tdate1" id="ac_tdate1" data-date-format='yyyy-mm-dd' readonly="readonly">
                                                </div>
                                                <div class="col-sm-1 reduce_padd"  > 
                                                	<input type="text" class="form-control" name="ac_amount1" id="ac_amount1" onkeypress="decemal_or_number('1')" >
                                                 </div>
                                                <div class="col-sm-1 reduce_padd" >
                                                	<div class="col-sm-6"><a class="btn btn-sm btn-danger" name="ac_sub_btn1" id="ac_sub_btn1" onClick="sub_addi_fun('1')"><i class="fa fa-minus"></i></a></div>
                                                    <div class="col-sm-6">
                                                	<a class="btn btn-sm btn-info" name="ac_add_btn1" id="ac_add_btn1" onClick="addi_add_fun()"><i class="fa fa-plus"></i></a> 									</div>					
                                                </div>
                                                </div>
                                                </div>
							  					</div>
											  </div>
											  <div class="modal-footer">
                                              <strong class="pull-left" style="font-size:12px; color:#F00;" id="msg_addi">Note : Please Enter All Required Fields..</strong>
                                              <input type="hidden" value="1" name="tot_cnt_addi" id="tot_cnt_addi">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="addtion_submit" name="addtion_submit" value="addtion_submit_val" class="btn btn-success">Submit</button>
											  </div>
											</div>                                </form>
										  </div>
										</div>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
                           <a class="btn btn-sm btn-info" name="add_cost" data-toggle='modal' href="#addi_cost"><i class="fa fa-plus"></i>&nbsp; Add Cost </a>
								</div>
                                <h3 class="panel-title"><i class="fa fa-rupee (alias)"></i>&nbsp;Additional Cost Settings</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                    <div class="table-responsive" id="default_table">
                                   <?php 
								 if($totalRows_addi>0){
								   ?>
						<table class="table table-striped table-hover datatable-example" >
							<thead class="the-box dark full">
								<tr>
								<th width="5%"><center> #</center> </th>
								<th width="25%" ><i class="fa fa-tag "></i>&nbsp; Short Name</th>
                                <th width="18%"><i class="fa  fa-map-marker"></i>&nbsp; City Name</th>
                                <th width="18%"><i class="fa  fa-map-marker"></i>&nbsp;Place</th>
                                <th width="20%" ><center><i class="fa fa-calendar "></i>&nbsp; Date Limit</center></th>
                                <th width="12%" ><i class="fa fa-rupee (alias)"></i>&nbsp; Cost</th>
                                <th width="15%" ><center><i class="fa fa-flag "></i>&nbsp; Action </center></th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
							foreach($row_addi_main as $row_addi)
							{?>
								<tr>
                                <td><?php echo $i; ?></td>
                                <td><?php 
									 $len=strlen($row_addi['short_desc']); 
									 if($len>31)
									 {?>
									 <span data-toggle='tooltip' data-original-title='<?php echo $row_addi['short_desc']; ?>'><?php echo substr($row_addi['short_desc'],0,30).'..'; ?></span>
									 <?php }else{
										 echo $row_addi['short_desc'];
									 }
									 
									 if($row_addi['status']==0)
									 {?>
										 <i class="fa fa-unlock-alt pull-right" data-toggle='tooltip' data-original-title='Active'></i>
									 <?php }else if($row_addi['status']==1){ ?>
										 <i class="fa fa-lock pull-right"  data-toggle='tooltip' data-original-title='Deactive'></i>
									 <?php } ?>
                                </td>
                                <td><?php
													$city_name= $conn->prepare("SELECT * FROM dvi_cities where id=?");
													$city_name->execute(array($row_addi['city_id']));
													$row_city_name = $city_name->fetch(PDO::FETCH_ASSOC);
								
								 echo $row_city_name['name']; 
									 ?></td>
									 <td><?php
													$hotspots_pro= $conn->prepare("SELECT * FROM hotspots_pro where hotspot_id=?");
													$hotspots_pro->execute(array($row_addi['place']));
													$row_hotspots_pro = $hotspots_pro->fetch(PDO::FETCH_ASSOC);
								
								 echo $row_hotspots_pro['spot_name']; 
									 ?></td>
                                <td align="center"  style="font-size:11px"><?php echo date('d-M-Y',strtotime($row_addi['fdate'])).' <i class="fa fa-arrows-h"></i> '.date('d-M-Y',strtotime($row_addi['tdate'])); ?></td>
                                <td><i class="fa fa-rupee (alias)"></i>&nbsp; <?php echo $row_addi['amount']; ?></td>
                                <td align="center">
                                <div class="btn-group" align="left">
								  <button class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class=" pull-right dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
									<li><a href="javascript:void(0);" onclick="update_addi_cost('<?php echo $row_addi['sno']; ?>')"><i class="fa fa-edit"></i>&nbsp; Update</a></li>
                                    <?php  if($row_addi['status']==0){?>
                                    <li><a href="javascript:void(0);" onclick="lock_addi_cost('<?php echo $row_addi['sno']; ?>','1')" ><i class="fa fa-lock"></i>&nbsp; Lock</a></li><?php }else if($row_addi['status']==1){?>
                                    <li><a href="javascript:void(0);" onclick="lock_addi_cost('<?php echo $row_addi['sno']; ?>','0')" ><i class="fa  fa-unlock-alt"></i>&nbsp; UnLock</a></li>
                                    <?php }?>
                                    <li class="divider"></li>
                                  	<li><a href="javascript:void(0);" onclick="remove_addi_cost('<?php echo $row_addi['sno']; ?>','2')" ><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
								  </ul>
                                    </div></td>
                                </tr>
							<?php
							$i++;
							 }?>
                                </tbody>
                                </table>
                                <?php } else{?>
                              	<div class="alert alert-danger alert-bold-border square fade in alert-dismissable">
								  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								  <center><strong style="font-weight:600; color:#930;">No Entry Found !</strong></center>
								</div>
                                <?php } ?>
                                </div>
                                
                                </div>
                                </div>
                            </div>
                        </div><!-- /.col-sm-8 -->
					</div><!-- /.row -->
				</div>
                <!-- /.container-fluid -->
<script>

$(document).ready(function(e) {
	 $('.datepick11').datepicker();
    $('.form-control').css('width','100%');
});

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

function lock_addi_cost(sno,sts)
{
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_voucher.php?type=3&sno='+sno+'&sts='+sts,function(res){
		$('.loader_ax').fadeOut(500);
		$('#default_table').empty().html(res);
		$('.datatable-example').dataTable();
	});
}

function remove_addi_cost(sno,sts)
{
	var re=confirm('Are you sure to remove ?');
	if(re==true)
	{
		$('.loader_ax').fadeIn();
		$.get('<?php echo $_SESSION['grp']; ?>/ajax_voucher.php?type=3&sno='+sno+'&sts='+sts,function(res){
			$('.loader_ax').fadeOut(500);
			$('#default_table').empty().html(res);
			$('.datatable-example').dataTable();
		});
	}
}


function vali_additional_updt()
{
	var upd_name=$('#ac_name_upd').val().trim();
	var upd_fdate=$('#ac_fdate_upd').val().trim();
	var upd_tdate=$('#ac_tdate_upd').val().trim();
	var upd_amt=$('#ac_amount_upd').val().trim();	
	
	$('#ac_name_upd').css('background-color','#FFF');
	$('#ac_fdate_upd').css('background-color','#FFF');
	$('#ac_tdate_upd').css('background-color','#FFF');
	$('#ac_amount_upd').css('background-color','#FFF');
	$('#msg_addi_upd').empty().prepend('Note : Please Enter All Required Fields..');
	
	if(upd_name=='')
	{
		$('#ac_name_upd').css('background-color','rgb(255, 232, 232)');
		$('#ac_name_upd').focus();
		$('#msg_addi_upd').empty().prepend('Short Name Cannot Be Empty !');
		return false;	
	}else if(upd_fdate=='')
	{
		$('#ac_fdate_upd').css('background-color','rgb(255, 232, 232)');
		$('#ac_fdate_upd').focus();
		$('#msg_addi_upd').empty().prepend('From-Date Cannot Be Empty !');
		return false;	
	}else if(upd_tdate=='')
	{
		$('#ac_tdate_upd').css('background-color','rgb(255, 232, 232)');
		$('#ac_tdate_upd').focus();
		$('#msg_addi_upd').empty().prepend('To-Date Cannot Be Empty !');
		return false;	
	}else if(upd_amt=='')
	{
		$('#ac_amount_upd').css('background-color','rgb(255, 232, 232)');
		$('#ac_amount_upd').focus();
		$('#msg_addi_upd').empty().prepend('Amount - Cannot Be Empty !');
		return false;	
	}else{
		return true;	
	}
}





function decemal_or_number_update()
{
	 $('#ac_amount_upd').val($('#ac_amount_upd').val().replace(/[^0-9\.]/g,''));
	  if ((event.which != 46 || $('#ac_amount_upd').val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
      }
}

function decemal_or_number(n)
{
	 $('#ac_amount'+n).val($('#ac_amount'+n).val().replace(/[^0-9\.]/g,''));
	  if ((event.which != 46 || $('#ac_amount'+n).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
      }
}

function addi_add_fund()
{
	var tcnt=$('#tot_cnt_addi').val().trim();
	var next_tcnt=parseInt(tcnt)+1;
	
	var city_def='<select name="ac_sel'+next_tcnt+'" id="ac_sel'+next_tcnt+'" class="chosen-select" >';
	$('#ac_sel_par option').each(function(index, element) {
        city_def=city_def+'<option value="'+$(this).val()+'">'+$(this).text()+'</option>';
    });
	city_def=city_def+'</select>';
	
	var new_element='<div class="col-sm-12" id="ac_div'+next_tcnt+'" style="margin-top:10px;"><div class="col-sm-3 reduce_padd" >'+city_def+'</div><div class="col-sm-2 reduce_padd"><input type="text" class="form-control" name="ac_name'+next_tcnt+'" id="ac_name'+next_tcnt+'" ></div><div class="col-sm-2 reduce_padd" ><input type="text" class="form-control datepicker_ac datepicker" name="ac_fdate'+next_tcnt+'" id="ac_fdate'+next_tcnt+'" data-date-format="yyyy-mm-dd" ></div><div class="col-sm-2 reduce_padd" ><input type="text" class="form-control datepicker_ac datepicker" name="ac_tdate'+next_tcnt+'" id="ac_tdate'+next_tcnt+'" data-date-format="yyyy-mm-dd" ></div><div class="col-sm-1 reduce_padd" ><input type="text" class="form-control" name="ac_amount'+next_tcnt+'" id="ac_amount'+next_tcnt+'" onkeypress="decemal_or_number('+next_tcnt+')" ></div><div class="col-sm-2 reduce_padd"><div class="col-sm-6"><a class="btn btn-sm btn-danger" name="ac_sub_btn'+next_tcnt+'" id="ac_sub_btn1" onClick="sub_addi_fun('+next_tcnt+')"><i class="fa fa-minus"></i></a></div><div class="col-sm-6"><a class="btn btn-sm btn-info" name="ac_add_btn'+next_tcnt+'" id="ac_add_btn'+next_tcnt+'" onClick="addi_add_fun()"><i class="fa fa-plus"></i></a></div></div></div>';
	
		var arr=new Array();
		var a=0,a1;
		for(var e=1;e<=tcnt;e++)
		{
			if($('#ac_div'+e).length>0)
			{
				arr[a++]=e;
				$('#ac_add_btn'+e).hide();
			}
		}
	
	$(new_element).appendTo('#paret_div');
	$('#ac_add_btn'+tcnt).hide();
	$('#tot_cnt_addi').val(next_tcnt);
	$('.chosen-select').chosen({width:'100%'});
	$('.datepicker').datepicker();
	
}

function sub_addi_fun(n)
{
		var totc=$('#tot_cnt_addi').val().trim();
		var arr=new Array();
		var a=0,a1,tot,chk=0;
		for(var e=1;e<=totc;e++)
		{
			if($('#ac_add_btn'+e).length>0)
			{
				arr[a++]=e;
			}
		}
		
		tot=a;
		a=(parseInt(a)-1);
		a1=(parseInt(a)-1);
		if(tot!=1)
		{
		$('#ac_div'+n).remove(); 
			for(var y=1;y<=totc;y++)
			{
				if($('#ac_add_btn'+y).is(":visible"))
				{
					chk=1;
				}
			}
			
			if(chk!=1)
			{
				$('#ac_add_btn'+arr[a1]).show();
			}
		}else{
			$('#ac_name'+n).val('');
			$('#ac_fdate'+n).val('');
			$('#ac_tdate'+n).val('');
			$('#ac_amount'+n).val('');
		}
}

function vali_additional()
{
	var ttc=$('#tot_cnt_addi').val().trim();
	
	for(e=1;e<=ttc;e++)
	{
		if($('#ac_div'+e).length>0)	
		{
				$('#ac_name'+e).css('background-color','#FFF');
				$('#ac_fdate'+e).css('background-color','#FFF');
				$('#ac_tdate'+e).css('background-color','#FFF');
				$('#ac_amount'+e).css('background-color','#FFF');
			if($('#ac_name'+e).val().trim()=='')
			{
				$('#msg_addi').empty().prepend(' * Please Enter Short Name');
				$('#ac_name'+e).css('background-color','rgb(255, 230, 230)');
				$('#ac_name'+e).focus();
				return false;
			}else if($('#ac_fdate'+e).val().trim()==''){
				$('#msg_addi').empty().prepend(' * Please Pick Start Date (YYYY-MM-DD)');
				$('#ac_fdate'+e).css('background-color','rgb(255, 230, 230)');
				$('#ac_fdate'+e).focus();
				return false;
			}else if($('#ac_tdate'+e).val().trim()==''){
				$('#msg_addi').empty().prepend(' * Please Pick End Date (YYYY-MM-DD)');
				$('#ac_tdate'+e).css('background-color','rgb(255, 230, 230)');
				$('#ac_tdate'+e).focus();
				return false;
			}else if($('#ac_amount'+e).val().trim()==''){
				$('#msg_addi').empty().prepend(' * Please Enter Rupees (only numerical values)');
				$('#ac_amount'+e).css('background-color','rgb(255, 230, 230)');
				$('#ac_amount'+e).focus();
				return false;
			}
		}
	}
	
	return true;
}

$(document).ready(function(e) {
	$('.chosen-select').chosen({width : '100%'});
});
function update_addi_cost(sno)
{
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_voucher.php?type=2&sno='+sno,function(result){
			$('.loader_ax').fadeOut(500);
			$('#addi_cost_updt').empty().html(result);
			$('.chosen-select').chosen({width:'100%'});
			$('#addi_cost_updt').modal('show');
			$('.datepicker').datepicker();
		});
	
}

function place_det(val1,val2){           	

		var type="&type=VIEW_PLACE";
		var id="&id="+val1;
		var val="&val="+val2;
		$.ajax({
		type:"POST",
		data:val+type+id,
		url:'ADMIN/ajax_set_page.php',
		beforeSend: function()
		{		
				 
		},
		success:function(result)
		{
		
$("#place_view"+val2).empty().html(result); 
$('.chosen-select').chosen({width : '100%'});
//window.location.reload(-1);
		},
		error:function(error,sts,sh)
		{
			alert(error.responseText);
		}
		
		});	
}
function upd_place(val1){           	

		var type="&type=VIEW_PLACE_UP";
		var id="&id="+val1;
		
		$.ajax({
		type:"POST",
		data:type+id,
		url:'ADMIN/ajax_set_page.php',
		beforeSend: function()
		{		
				 
		},
		success:function(result)
		{
		
$("#up_place").empty().html(result); 
$('.chosen-select').chosen({width : '100%'});
//window.location.reload(-1);
		},
		error:function(error,sts,sh)
		{
			alert(error.responseText);
		}
		
		});	
}
function addi_add_fun()
{
	var tcnt=$('#tot_cnt_addi').val().trim();
	var next_tcnt=parseInt(tcnt)+1;
	
	var type="&type=VIEW_FULL_DET";
		var id="&id="+next_tcnt;
		
		$.ajax({
		type:"POST",
		data:type+id,
		url:'ADMIN/ajax_set_page.php',
		beforeSend: function()
		{		
				 
		},
		success:function(result)
		{
		
var arr=new Array();
		var a=0,a1;
		for(var e=1;e<=tcnt;e++)
		{
			if($('#ac_div'+e).length>0)
			{
				arr[a++]=e;
				$('#ac_add_btn'+e).hide();
			}
		}
	
	$(result).appendTo('#paret_div');
	$('#ac_add_btn'+tcnt).hide();
	$('#tot_cnt_addi').val(next_tcnt);
	$('.chosen-select').chosen({width:'100%'});
	$('.datepicker').datepicker();
	
		},
		error:function(error,sts,sh)
		{
			alert(error.responseText);
		}
		
		});	
	
		
}

</script>