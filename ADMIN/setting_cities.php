<?php


$states = $conn->prepare("SELECT * FROM dvi_states ORDER BY name ASC");
$states->execute();
$row_states_main = $states->fetchAll();
$totalRows_states = $states->rowCount();

if(isset($_POST['submit_city']) && $_POST['submit_city']='submit_city_val')
{
	
	$getcode = $conn->prepare("SELECT * FROM dvi_states where code =?");
	$getcode->execute(array($_POST['state']));
	$row_getcode = $getcode->fetch(PDO::FETCH_ASSOC);
		
 	$insertSQL1 = $conn->prepare("INSERT INTO dvi_cities (id ,country, region, name) VALUES ('".trim($_POST['new_city_idd'])."','IN', '".$row_getcode['code']."', '".$_POST['cityname']."')");
	$insertSQL1->execute();
	
	
	$cityid=$conn->prepare("select * from dvi_cities where region=? and name=?");
	$cityid->execute(array($row_getcode['code'],$_POST['cityname']));
	$row_cityid = $cityid->fetch(PDO::FETCH_ASSOC);
	
	$from_city=trim($_POST['new_city_idd']);
	for($f=1;$f<=trim($_POST['new_city_idd']);$f++)
	{
		$to_city=$f;
		$insertSQL1=$conn->prepare("INSERT INTO dvi_citydist (from_cityid, to_cityid, dist, status) values('$from_city','$to_city','0',0)");
		$insertSQL1->execute();
	}
	
	if(trim($_POST['cdesc'])=='')
	{
		$_POST['cdesc']='-';	
	}
	
	 $insertSQL1 = $conn->prepare("UPDATE dvi_states SET cities = $row_getcode[cities]+1 WHERE code = '".$_POST['state']."'");
     $insertSQL1->execute();
	
	
	$updatecnt =$conn->prepare("UPDATE dvi_states SET cities = ?+1 WHERE code = ?");
	$updatecnt->execute(array($row_getcode['cities'],$_POST['state']));
	
	echo "<script>parent.location.reload();</script>";
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

</style>
	<div class="container-fluid">
				
				<!-- Begin page heading -->
				<h1 class="page-heading">States/Cities Setting <small>Manage Cities(India)</small></h1>
				
					<div class="row">
                        <div class="col-lg-12">
                        
                        <div class="modal fade" id="search_dist" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" style="width:40%">
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                                <?php
													
													$search= $conn->prepare("SELECT * FROM dvi_cities ORDER BY id ASC");
													$search->execute();
													//$row_search= mysql_fetch_assoc($search);
													$row_search_main=$search->fetchAll();
													$totalRows_search = $search->rowCount();
												?>
					<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;">Distance Between Cities </h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
							<div class="col-sm-12" align="center">
                              <div class="col-sm-4" align="right" style="color:#C60; font-weight:700"> From City : </div>
                              <div class="col-sm-6">
                              <select class="chosen-select" name="sdistance" id="sdistance" data-placeholder="Choose City" onchange="search_dist(this.value)">
                               	<option></option>
                                <?php
								foreach($row_search_main as $row_search)
								{?>
										<option value="<?php echo $row_search['id']; ?>"><?php echo $row_search['name']; ?></option>
								<?php }
								 ?>
                               </select>
                  				</div>
                           <div class="col-sm-2"></div>
                                   <!-- first_div_id -->
                                </div>
                                <div class="col-sm-12" id="dsearch_result" style="height:400px; overflow-y:scroll">
                                
                                <br /><br /><center><strong style="font-size:18px; font-weight:600; color:#A4C3DE">Select Any City To Update Distance</strong></center>
                                <!--- ajax result from -->
                                </div>
							  </div>
                                                
											  </div>
											  <!--<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											  </div>--><!-- /.modal-footer -->
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->                               
										  </div><!-- /.modal-dialog -->
										</div>
                        
                        
                        
                        <div class="modal fade" id="InfoModalColor5" tabindex="-1" role="dialog" aria-hidden="true">
										  <div class="modal-dialog" style="width:60%">
                    <form  name="form_city"  id="form_city"  method="post" enctype="multipart/form-data" onsubmit="return check_new_city()" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <?php
												
										$ncity = $conn->prepare("SELECT * FROM dvi_cities ORDER BY id DESC");
										$ncity->execute();
										$row_ncity= $ncity->fetch(PDO::FETCH_ASSOC);
										$totalRows_ncity = $ncity->rowCount();
												?>
										<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;">New City - Form [ City ID : <?php echo ($row_ncity['id']+1); ?>]</h5>
                                        <input type="hidden" id="new_city_idd" name="new_city_idd" value="<?php echo ($row_ncity['id']+1); ?>" />
											  </div>
											  <div class="modal-body">
                                                <div class="row">
							<div class="col-sm-12">
                                
                                   <div id="first_div_id" >
                                   <center><strong style="color:#E47272"> City Infomation</strong></center>
                                   <br />
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title='City Name' ><i class="fa fa-building"  ></i></span>
										  <input type="text" name="cityname" id="cityname" class="form-control" placeholder="City name" onBlur="retcity()">
										</div>
                                        <small class="help-block" id="cityerr" style="display:none; color:#E9573F;" ></small>
                                        </div>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title='Select State'><i class="fa fa-cube" ></i></span>
                                        <?php 
										
										$st = $conn->prepare("SELECT * FROM dvi_states ORDER BY name ASC");
										$st->execute();
										$row_st_main= $st->fetchAll();
										$totalRows_st = $st->rowCount();
										?>
										  <select class="form-control chosen-select" name="state" id="state" tabindex="2" onChange="retstate()">
											<option value="">-- Select State --</option>
                                            <?php
											foreach($row_st_main as $row_st)
											{
											?>
											<option value="<?php echo $row_st['code']; ?>"><?php echo $row_st['name']; ?></option>
                                            <?php
											}
											
											?>
										</select>
										</div>
                                        <small class="help-block" id="staterr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
									</div>
                                    </div>
                                  
                                <div class="row">
                                <div class="col-sm-12">
                                <div class="the-box">
						<h4 class="small-title" align="center" style="color:#946A1C;">Provide little description about this city</h4>
							<textarea name="cdesc"  placeholder="History or Description" style="width:738px; height:113px; resize:vertical"></textarea><!--class="summernote-sm"-->
					</div><!-- /.the-box -->
                    </div>
                    </div>
                                </div><!-- first_div_id -->
                                </div>
							  </div>
                                                
											  </div>
											  <div class="modal-footer">
                                              <strong class="pull-left" style=" font-size:12px; color:#F00;">* Kindly note above refered city id to your future use </strong>
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="submit_id" name="submit_city" value="submit_city_val" class="btn btn-info" onClick="return chkdata();">Submit</button>
											  </div><!-- /.modal-footer -->
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->                                </form>
										  </div><!-- /.modal-dialog -->
										</div>
                        
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
                                
                                <a class="btn btn-info add_city tooltips" title="Change distance between cities" href="<?php echo $_SESSION['grp'];?>/dist_setting.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Distance setting </a>
                                
                                <a class="btn btn-info tooltips" title="Download cities list with id" href="<?php echo $_SESSION['grp'];?>/download_city.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-download"></i>&nbsp;&nbsp;Cities </a>
                                    &nbsp;&nbsp;
                                <a class="btn btn-info tooltips upl_city" title="Upload cities" href="<?php echo $_SESSION['grp'];?>/upl_cities_dist.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-upload"></i>&nbsp;&nbsp;Upload cities (DVi served)</a>
                                &nbsp;&nbsp;
                                
                                <div class="btn-group">
										  <a class="btn btn-info dropdown-toggle tooltips" data-toggle="dropdown" title="Cities distance matrix">
											<i class="fa fa-file-excel-o" style="font-weight:bold"></i> <span style=""> Distance chart </span> <span class="caret"></span>
										  </a>
										  <ul class="dropdown-menu" role="menu" style="text-align:left">
		                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <li><a class="upl_dist" title="Upload distance between cities" href="<?php echo $_SESSION['grp'];?>/upl_cities_dist.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-upload"></i>&nbsp;&nbsp;Upload distance chart</a></li>
                                    
                                    <li><a class="upload_city_dist fancybox.ajax" href="<?php echo $_SESSION['grp'];?>/update_city_dist.php"><i class="fa fa-refresh"></i>&nbsp;&nbsp; Update chart </a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                  
								</div>
                                
                                    &nbsp;&nbsp;
									<button class="btn btn-info  btn-sm btn-rounded-lg to-collapse" data-toggle="collapse" data-target="#panel-collapse-3"><i class="fa fa-chevron-up"></i></button>
								</div>
                                <h3 class="panel-title"><i class="fa fa-empire"></i>&nbsp;&nbsp;Indian states list</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                <div class="alert alert-danger alert-bold-border fade in alert-dismissable" >
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                  
                                    <div align="right">
                                    <!--<a data-toggle="tooltip" title="Add New City (if not found in list)" class="add_city btn btn-default" href="<?php// echo $_SESSION['grp'];?>/add_city.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&type=<?php// echo md5(1);?>"><i class="fa fa-plus" style="color:#3EAFDB"></i> City</a>-->
                                    <a class="btn btn-info tooltips" title="Search Distance" data-toggle="modal" data-target="#search_dist"><i class="fa fa-search"></i>&nbsp; <span style=" font-weight:bold"> Search Distance </span> </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    
                                     <a class="btn btn-info tooltips" title="Add new city via form entry" data-toggle="modal" data-target="#InfoModalColor5"><i class="fa fa-plus"></i>&nbsp; <span style=" font-weight:bold"> Add City </span> </a>
                                </div>
                                    </div>
                                <?php if($totalRows_states>0){?>
                                    
                                    <div class="table-responsive" id="tabonly">
                                   <?php ?>
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th colspan="2" width="35%"><i class="fa fa-bank"></i> States</th>
                                    <th width="15%" style="text-align:center"> State - id </th>
									<th width="25%"><i class="fa fa-building"></i> Cities Count </th>
                                    <!--<th><i class="fa fa-inr"></i> State Permit cost </th>-->
                                    <th><i class="fa fa-exclamation-triangle"></i> Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
							foreach($row_states_main as $row_states){
							?>
								<tr class="even gradeA">
									<td> <label id="hidedit<?php echo $i; ?>"><?php echo $row_states['name'];?></label>
                                    <input type="text" name="statedit<?php echo $i; ?>" id="statedit<?php echo $i; ?>" class="form-control"  value="<?php echo $row_states['name']; ?>" style="display:none;">
                                    <br />
                                    <button type="button" name="updst<?php echo $i; ?>" id="updst<?php echo $i; ?>" class="btn btn-info btn-rounded-xs" style="display:none" onclick="editsub(<?php echo $i; ?>,<?php echo $row_states['code']; ?>)">Update</button>
                                    <button type="button" name="canst<?php echo $i; ?>" id="canst<?php echo $i; ?>" class="btn btn-danger btn-rounded-xs" style="display:none" onclick="canedit(<?php echo $i; ?>)">cancel</button>
                                    <input type="hidden" name="hidid<?php echo $i; ?>" value="<?php echo $row_states['code'];?>" />
                                    </td>
                                    <td>
                                     <?php if($row_states['status']=='1'){?>
                                <i class="fa fa-lock tooltips" data-original-title='Locked State & Cities'></i><?php }else if($row_states['status']=='0'){?>
                                 <i class="fa fa-unlock tooltips" data-original-title='Active State & Cities'></i>
                                  <?php } ?>
                                    </td>
									<td align="center"><?php echo $row_states['code'];?></td>
									<td>
                                  <a <?php if ($row_states['cities']== 0) { ?>  disabled="disabled" <?php } ?> href="ADMIN/city_view.php?sid=<?php echo $row_states['code'];?>" class="btn btn-default btn-rounded-lg view_city tooltips" data-original-title="View cities in <?php echo $row_states['name'];?>" title="View cities in <?php echo $row_states['name'];?>" ><?php echo $row_states['cities'];?></a>
                                    </td>
                                    <td>
                                    <div class="btn-group">
								  <button  class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown" >
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:180px">
                                    <li>
                                    <a class="" onclick="showtext(<?php echo $i ?>)" title="Update - <?php echo $row_states['name'];?>" href="javascript:void(0);"><i class="fa fa-wrench"></i>&nbsp; Update State</a></li>
                                  <li>
                                  <?php if($row_states['status']=='0'){?>
                                  <a href="javascript:void(0);" onclick="rem_state('<?php echo $row_states['code']; ?>','1')" ><i class="fa fa-lock"></i> &nbsp; Lock</a><?php }else if($row_states['status']=='1'){?>
                                  <a href="javascript:void(0);" onclick="rem_state('<?php echo $row_states['code']; ?>','0')" ><i class="fa fa-unlock"></i>  &nbsp;UnLock</a>
                                  <?php } ?>
                                  </li>
									
								  </ul>
                                    </div>
                                    </td>
								</tr>
                               <?php $i++;
							   $city='';
							$perkl='';
							$rents='';
							$maxkl='';
							}?>
                                </tbody>
                                </table>
                                </div>
                                <div class="" id="tabon2">
                                </div>
                                  <?php }else{?>  
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable">
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                    <span class="text-muted">Cities not yet added... </span>
                                    
                                    </div>
                                    <?php }?>
                                </div>
                                </div>
                                <!-- /.panel-body -->
                             <!--<div class="panel-footer">Panel footer</div>-->
                            </div>
                            
                            
                        </div><!-- /.col-sm-8 -->
					</div><!-- /.row -->
			
				</div>
                <!-- /.container-fluid -->
<script>

$(document).ready(function(e) {
    $('.chosen-select').chosen({width:'100%'});
	$('.summernote-sm').summernote({height:'100px'});
});

function showtext(cnt)
{
	$('#hidedit'+cnt).hide();
	$('#statedit'+cnt).show();
	$('#updst'+cnt).show();
	$('#canst'+cnt).show();
}

function canedit(cnt)
{
	$('#hidedit'+cnt).show();
	$('#statedit'+cnt).hide();
	$('#updst'+cnt).hide();
	$('#canst'+cnt).hide();
}

function showpermit(cnt)
{
	$('#permlab'+cnt).hide();
	$('#permedit'+cnt).show();
	$('#updperm'+cnt).show();
	$('#canperm'+cnt).show();
}

function canperm(cnt)
{
	$('#permlab'+cnt).show();
	$('#permedit'+cnt).hide();
	$('#updperm'+cnt).hide();
	$('#canperm'+cnt).hide();
}

function editsub(cnt,sno)
{
	var stname = $('#statedit'+cnt).val();
	
	$.get('<?php echo $_SESSION['grp'].'/upd_state.php' ?>', { sno : sno, stname : stname, typ : 1 }, function(data) 
	{
		$('#hidedit'+cnt).show();
		$('#statedit'+cnt).hide();
		$('#updst'+cnt).hide();
		$('#canst'+cnt).hide();
		parent.location.reload();
	});
}

function updperm(cnt,sno)
{
	var perm_val = $('#permedit'+cnt).val();
	
	$.get('<?php echo $_SESSION['grp'].'/upd_state.php' ?>', { sno : sno, perm_val : perm_val, typ : 3 }, function(data) 
	{
		parent.location.reload();
	});
}

function rem_state(id,ss)
{
	$.get('<?php echo $_SESSION['grp'].'/upd_state.php' ?>', { sno : id, typ : 2,sts : ss }, function(data) {
	parent.location.reload();
	});
}
</script>

<script>	

/*function check_new_city()
{
	var cn=$('#cityname').val().trim();
	var sts=$('#state').val().trim();
	var cdesc=$('#cdesc').val().trim();
	if(cn !='' && sts!='')
	{
		return true;
	}else{
		if(cn=='')
		{
			alert('Please Enter City Name..')	;
		}else if(sts =='')
		{
			alert('Please Select Any State..')	;
		}
		return false;
	}
}*/
	
function chkdata()
{
	var chkcity = $('#cityname').val();
	if (chkcity == '')
	{
		$('#cityerr').text("Enter city name.").show();
		return false
	}
	else
	{
		if ($("#cityerr").show())
		{
			$("#cityerr").hide();
		}
	}
	
	var chkstate = $('#state').val();
	if (chkstate == '')
	{
		$('#staterr').text("Choose the state where city belongs to.").show();
		return false
	}
	
	var chklat = $('#latit').val();
	if (chklat == '')
	{
		$('#laterr').text("Enter latitude of city added.").show();
		return false
	}
	else
	{
		if ($("#laterr").show())
		{
			$("#laterr").hide();
		}
	}
	
	var chklon = $('#longit').val();
	if (chklon == '')
	{
		$('#longerr').text("Enter longitude of city added.").show();
		return false
	}
	else
	{
		if ($("#longerr").show())
		{
			$("#longerr").hide();
		}
	}
	
	return true
}

function retstate()
{
	if ($("#staterr").show() && $('#state').val() != '')
	{
		$("#staterr").hide();
	}
}

function retcity()
{
	if ($("#cityerr").show() && $('#cityname').val() != '')
	{
		$("#cityerr").hide();
	}
}

function retlat()
{
	if ($("#laterr").show() && $('#latit').val() != '')
	{
		$("#laterr").hide();
	}
}

function retlong()
{
	if ($("#longerr").show() && $('#longit').val() != '')
	{
		$("#longerr").hide();
	}
}

function search_dist(cid)
{
	//alert(cid);	
	$.get('<?php echo $_SESSION['grp']; ?>/ajax_log.php?type=3&cid='+cid,function(res){
		//alert(res);
		$('#dsearch_result').empty().html(res);
		$('.tooltips').tooltip();
		//$('.dttt').dataTable();
		});
}

function update_dist(sno)
{
	var dist=$('#txt_'+sno).val();
	var ty=5;
	$.get('ADMIN/ajax_others.php?sno='+sno+'&dist='+dist+'&type='+ty,function(result)
	{
		//alert(result);
		$('#txt_'+sno).hide();
		$('#up_'+sno).hide();
		$('#can_'+sno).hide();
		$('#lab_'+sno).empty().prepend(dist);
		$('#lab_'+sno).show();
		//$('#lab_'+sno).css('background-color','#FFF');
		//$('#txt'+sno).css('background-color','#FFF');
	
	});
}

function cancel_update(sno)
{
	$('#lab_'+sno).show();
	$('#txt_'+sno).hide();
	$('#up_'+sno).hide();
	$('#can_'+sno).hide();
	//$('#lab_'+sno).css('background-color','#FFF');
	//$('#txt'+sno).css('background-color','#FFF');
	
}

function show_dist(sno)
{
$('#lab_'+sno).hide();
$('#txt_'+sno).show();
$('#up_'+sno).show();
$('#can_'+sno).show();
}
</script>