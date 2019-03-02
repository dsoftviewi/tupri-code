<?php

$vehipro = $conn->prepare("SELECT * FROM vehicle_pro  ORDER BY vehicle_type ASC");
$vehipro->execute();
$row_vehipro_main = $vehipro->fetchAll();
$totalRows_vehipro = $vehipro->rowCount();


$vehifilt = $conn->prepare("SELECT distinct(datetime) FROM vehicle_pro ORDER BY datetime ASC");
$vehifilt->execute();
$row_vehifilt_main = $vehifilt->fetchAll();
$totalRows_vehifilt = $vehifilt->rowCount();

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
				<h1 class="page-heading">Vehicle Pro <small>Manage Vehicle</small></h1>
				
					<div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
									<button class="btn btn-info  btn-sm btn-rounded-lg to-collapse" data-toggle="collapse" data-target="#panel-collapse-3"><i class="fa fa-chevron-up"></i></button>
								</div>
                                <h3 class="panel-title"><i class="fa fa-taxi"></i>&nbsp;Vehicle Pro</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                <?php if($totalRows_vehipro>0){?>
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable" >
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                  
                                    <div align="right">
                                    <span id="vs1"><strong> Add vehicle </strong></span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu" style="text-align:left">
                                  
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li><a class="add_vehiform " href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a></li>
									<li><a class="add_vehi " title="Upload file" href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                &nbsp;&nbsp;
                                    &nbsp;&nbsp;
                                    <input type="hidden" id="lcn" value="1" />
                                    <div class="btn-group">
								  <a class="btn btn-danger btn-sm dropdown-toggle" id="sptxt" data-toggle="dropdown">
									<i class="fa fa-filter"></i> All records (<?php echo $totalRows_vehipro;?>) <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu  " role="menu" style="text-align:left; margin-left:-55%; width:250px; " >
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>													
                                    <li>
											<div class="nav-dropdown-heading" style="text-align:center">
											<strong>Uploaded Date's</strong>
											</div><!-- /.nav-dropdown-heading -->
											<div class="nav-dropdown-contents  scroll-nav-dropdowns" style=" min-height:150px; max-height:240px;">
												<ul >
                                                
													 <?php
													 $ds=1; 
													 $sda='';
													 $dsd='';
													 $fns='';
													  foreach($row_vehifilt_main as $row_vehifilt){
									   
	$vehifilt1 = $conn->prepare("SELECT * FROM vehicle_pro where datetime=?");
	$vehifilt1->execute(array($row_vehifilt['datetime']));
	$row_vehifilt1 = $vehifilt1->fetch(PDO::FETCH_ASSOC);
	$totalRows_vehifilt1 = $vehifilt1->rowCount();
	
	
	$sda=str_replace('-','_',$row_vehifilt['datetime']);
								    $dsd=str_replace(' ','_',$sda);
									$fns=str_replace(':','_',$dsd).'.csv';
									   ?>
                                    <li class="col-sm-10 " >
                                    <a id="<?php echo 'h'.$ds;?>" style="margin-left:-3%;color:#656D8D;" onclick="lodrec('<?php echo $row_vehifilt['datetime'].' '.date('a',strtotime($row_vehifilt['datetime'])).' ('.$totalRows_vehifilt1.')';?>',<?php echo $totalRows_vehipro;?>,'<?php echo $row_vehifilt['datetime'];?>')"  data-toggle="tooltip" data-original-title="Click to view all records" href="javascript:void(0);"><i class="fa fa-calendar fa-fw"></i> <?php echo $row_vehifilt['datetime'].' '.date('a',strtotime($row_vehifilt['datetime'])).'<br>'.' ('.$totalRows_vehifilt1.')';?></a>
                                    </li>
                                    <li class="col-sm-2 " id="<?php echo 'h'.$ds.$ds;?>" ><a class="ss  pull-right"   href="javascript:void(0);" style="" onclick="rem('<?php echo $row_vehifilt['datetime'];?>','<?php echo $row_vehifilt['datetime'].' '.date('a',strtotime($row_vehifilt['datetime'])).' ('.$totalRows_vehifilt1.' records )';?>','<?php echo $fns;?>');"><i class="fa fa-trash-o " style="color:#D5472B" data-toggle="tooltip" data-original-title="Remove all records"></i></a></li>
                                     
									<?php $ds++;  $sda='';
													 $dsd='';
													 $fns='';}?>
													
												</ul>
											</div><!-- /.nav-dropdown-content scroll-nav-dropdown -->
											<div style="text-align:center" id="btdiv">
                                            
                                            </div>
										</li>
                                        <li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                </div>
                                    </div>
                                    <div class="table-responsive" id="tabonly">
                                   <?php ?>
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th># </th>
									<th><i class="fa fa-taxi"></i> Vehicle</th>
									<th><i class="fa fa-child"></i> Occupancy (seats)</th>
                                    <th><i class="fa fa-language"></i> Cities</th>
                                    <th><i  class="fa fa-inr"></i> Rental chart</th>
                                    <th><i class="fa fa-exclamation-triangle"></i> Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
							$es='';
							$es1='';
							
							$city='';
							$perkl='';
							$rents='';
							$trans='';
							$maxkl='';
							
							$ecity='';
							$eperkl='';
							$erents='';
							$etrans='';
							$emaxkl='';
							
							foreach($row_vehipro_main as $row_vehipro){
								
		$vehitab2 = $conn->prepare("SELECT * FROM vehicle_rent where vehicle_id=?");
		$vehitab2->execute(array($row_vehipro['vehi_id']));
		$row_vehitab2_main = $vehitab2->fetchAll();
		$totalRows_vehitab2 = $vehitab2->rowCount();
		
		foreach($row_vehitab2_main as $row_vehitab2){
			
		$city.=$row_vehitab2['city'].',';
		
		$perkl.=$row_vehitab2['charge_perkm'].',';
		
		$rents.=$row_vehitab2['rent_day'].',';
		
		$trans.=$row_vehitab2['rent_transfer'].',';
		
		$maxkl.=$row_vehitab2['maxkm_perday'].',';
		
		}
		
		$ecity=explode(',',substr($city,0,-1));
		
		$eperkl=explode(',',substr($perkl,0,-1));
		
		$erents=explode(',',substr($rents,0,-1));
		
		$etrans=explode(',',substr($trans,0,-1));
		
		$emaxkl=explode(',',substr($maxkl,0,-1));
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td ><?php echo $row_vehipro['vehicle_type'];?></td>
									<td style="text-align:center" width="18%"><?php echo $row_vehipro['vehicle_seat'];?></td>
									<td style="text-align:center" width="12%" >
                                    <div class="btn-group ">
								  <a  class="dropdown-toggle btn btn-xs btn-default"  data-toggle="dropdown" ><i class="fa fa-map-marker"></i> 
									<strong><?php if(count($ecity)>=2){ echo count($ecity).' Cities';}else{ echo count($ecity).' City'; }?></strong> <span class="caret"></span>
								  </a><!--div-nicescroller-->
								  <ul class="dropdown-menu  info with-triangle " role="menu" style=" text-align:left;" >
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <?php $ij=1; foreach($ecity as $ecty){
										
		$cname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
		$cname->execute(array($ecty));
		$row_cname = $cname->fetch(PDO::FETCH_ASSOC);
		
		?>
                                    <li><a href="javascript:void(0);" <?php if(strlen($row_cname['name'])>15){?> data-toggle="tooltip" data-original-title="<?php echo $row_cname['name']; ?>" <?php }?>><?php echo $ij.'.'.$row_cname['name'];?></a></li>
                                    <?php $ij++;}?>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                    </div>
                                    </td>
									<td style="text-align:center">
                                    <div class="btn-group">
								  <a  class="dropdown-toggle btn btn-xs btn-default"  data-toggle="dropdown" >
									<strong><i class="fa  fa-bar-chart-o"></i> Click</strong> <span class="caret"></span>
								  </a>
                                  <ul class="dropdown-menu margin-list-rounded info with-triangle pull-right" role="menu" style=" text-align:left;" >
								 <table class="table table-striped table-hover " style="width:420px; overflow-y:scroll;">
                                 <thead class="the-box dark full"><th>City</th><th>Transfer</th><th>Per day</th><th>Per km</th><th>Max km</th></thead>
                                 <tbody>
                                  <?php $ijw=1; $ik=0; foreach($ecity as $ecty){
										
		$cname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
		$cname->execute(array($ecty));
		$row_cname = $cname->fetch(PDO::FETCH_ASSOC);
		
		?>
        <tr class="even gradeA"><td><?php if(strlen($row_cname['name'])>14){?><span data-toggle="tooltip" data-original-title="<?php echo $row_cname['name'];?>"><?php echo substr($row_cname['name'],0,10).'&hellip;';?></span><?php }else { echo $row_cname['name']; }?></td><td ><i class="fa fa-inr"></i> <?php echo $erents[$ik];?></td><td ><i class="fa fa-inr"></i> <?php echo $etrans[$ik];?></td><td><i class="fa fa-inr"></i> <?php echo $eperkl[$ik];?></td><td><?php echo $emaxkl[$ik].' km';?></td></tr>
        <?php $ijw++; $ik++;}?></tbody>
                                 </table>
                                 </ul>
                                    </div>
                                    </td>
                                    <td class="center">
                                    <div class="btn-group">
								  <button  class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown" >
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <li>
                                    <a class="add_vehiform " title="Update - <?php echo $row_vehipro['vehicle_type'];?>" href="<?php echo $_SESSION['grp'];?>/update_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&vid=<?php echo $row_vehipro['vehi_id'];?>"><i class="fa fa-wrench"></i>&nbsp; Update</a></li>
                                    
                                    <li>
                                    <a class="add_perm " title="Update - <?php echo $row_vehipro['vehicle_type'];?>'s permit rates" href="<?php echo $_SESSION['grp'];?>/update_perm.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&vid=<?php echo $row_vehipro['vehi_id'];?>"><i class="fa fa-road"></i>&nbsp; Permit charges</a></li>
                                    
                                  <li><a href="javascript:void(0);" onclick="removes('<?php echo $row_vehipro['vehi_id'];?>','<?php echo $row_vehipro['vehicle_type'];?>')" ><i class="fa fa-trash-o"></i> Remove</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                    </div>
                                    </td>
								</tr>
                               <?php $i++;
							   $city='';
							$perkl='';
							$rents='';
							$trans='';
							$maxkl='';
							 } ?>
                                </tbody>
                                </table>
                                </div>
                                <div class="" id="tabon2">
                                </div>
                                  <?php }else{?>  
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable">
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                    <span class="text-muted">Vehicles not yet added... Please click to setup </span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu">
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li><a class="add_vehiform " href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a></li>
									<li><a class="add_vehi " title="Upload file" href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
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

//for load the current date records
function lodrec(dates,toos,dates1)
{
	var nli,type,vv,mm,sm;
	type=3;

	nli="<button class='btn btn-default btn-sm'  data-toggle='tooltip' data-original-title='Go back' onclick='vallrec()'>All Records"+" ("+toos+")"+"</button>";
	$('#sptxt').html("<i class='fa fa-calendar'></i> "+dates);
	if($('#lcn').val()==1)
	{
		$('#btdiv').html(nli);
	}
	
	
	$('#lcn').val(2);
	
	mm='<?php echo $_GET['mm']?>';
	sm='<?php echo $_GET['sm']?>';
	//ajax for load table
	$.ajax({
	 type:'GET',
	 url:"<?php echo $_SESSION['grp'];?>/load_page.php",
	 data:'type='+type+'&dads='+dates1+'&mm='+mm+'&sm='+sm,
	 cache:false,
	 success: function(dd)
	 {
		  toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.info('Records uploaded on - '+dates);
		 
		 $('#tabonly').empty().html(dd);
		 $('.datatable-example').dataTable();
		 $(".div-nicescroller").niceScroll({
		cursorcolor: "#656D78",
		cursorborder: "3px solid #313940",
		cursorborderradius: "10px",
		cursorwidth: "2px"

	});
	 }
		
	});
}

function lodrec1(dates,toos,dates1)
{
	var nli,type,mm,sm;
	type=3;
	nli="<button class='btn btn-default btn-sm'  data-toggle='tooltip' data-original-title='Go back' onclick='vallrec1()'>All Records"+" ("+toos+")"+"</button>";
	$('#sptxt1').html("<i class='fa fa-calendar'></i> "+dates);
	if($('#lcn1').val()==1)
	{
		$('#btdiv1').html(nli);
	}
	$('#lcn1').val(2);
	
	mm='<?php echo $_GET['mm']?>';
	sm='<?php echo $_GET['sm']?>';
	//ajax for load table
	$.ajax({
	 type:'GET',
	 url:"<?php echo $_SESSION['grp'];?>/load_page.php",
	 data:'type='+type+'&dads='+dates1+'&mm='+mm+'&sm='+sm,
	 cache:false,
	 success: function(dd)
	 {
		  toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.info('Records uploaded on - '+dates);
		
		 $('#tbonly1').html(dd);
		 $('.datatable-example').dataTable();
		 $(".div-nicescroller").niceScroll({
		cursorcolor: "#656D78",
		cursorborder: "3px solid #313940",
		cursorborderradius: "10px",
		cursorwidth: "2px"

	});
	 },
	error : function(xhr, status, error)
	{
 		 alert(xhr.responseText);
	}
		
	});
}



//for load all records
function vallrec()
{
    var type2,mm,sm;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	type2=1;
	$.ajax({
			type :'GET',
			url:"<?php echo $_SESSION['grp'];?>/load_page.php",
			data: "type="+type2+"&mm="+mm+"&sm="+sm,
			cache:false,
			
			success: function(da){
				
		toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.info('Showing all reocrds...!');
				
				$('#tabid').empty().html(da);
				$('.datatable-example').dataTable();
				$(".div-nicescroller").niceScroll({
		cursorcolor: "#656D78",
		cursorborder: "3px solid #313940",
		cursorborderradius: "10px",
		cursorwidth: "2px"

	});
				
			},
			error : function(xhr, status, error)
			{
				 alert(xhr.responseText);
			}
	});
	
}

function vallrec1()
{
	var type2,mm,sm;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	type2=1;
	$.ajax({
			type :'GET',
			url:"<?php echo $_SESSION['grp'];?>/load_page.php",
			data: "type="+type2+"&mm="+mm+"&sm="+sm,
			cache:false,
			success: function(da){
				
				toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.info('Showing all reocrds...!');
				
				$('#tabid').empty().html(da);
				$('.datatable-example').dataTable();
				$(".div-nicescroller").niceScroll({
		cursorcolor: "#656D78",
		cursorborder: "3px solid #313940",
		cursorborderradius: "10px",
		cursorwidth: "2px"

	});
			},
			error : function(xhr, status, error)
			{
				 alert(xhr.responseText);
			}
	});
}
//for remove the current date records
function rem(dd,tmsg,fil)
{
	var type,tn,fi,mm,sm,fls;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	tn='vehicle_pro';
	fi='datetime';
	type=1;
	$.ajax({
	
	type: 'POST',
	url: "<?php echo $_SESSION['grp'];?>/remove_page.php?",
	data: "sno="+dd+"&tname="+tn+"&field="+fi+'&fls='+fil,
	success: function(da){
		 toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.error(tmsg+' was successfully Removed..!');
			
			$.ajax({
			type :'GET',
			url:"<?php echo $_SESSION['grp'];?>/load_page.php",
			data: "type="+type+"&mm="+mm+"&sm="+sm,
			success: function(da){
				$('#tabid').empty().html(da);
				$('.datatable-example').dataTable();
				
			}
				});
		
	},
	error : function(xhr, status, error)
	{
 		 alert(xhr.responseText);
	}
		
	});
}

//For remove the current records in the table
function removes(i,vname)
{
	//alert("vname"+vname);
	var type,tn,fi,mm,sm,nn;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	tn='vehicle_pro';
	fi='vehi_id';
	type=1;
	$.ajax({
	
	type: 'POST',
	url: "<?php echo $_SESSION['grp'];?>/remove_page.php?",
	data: "sno="+i+"&tname="+tn+"&field="+fi,
	success: function(){
	
		 toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.error(vname+' was successfully Removed..!');
			
			$.ajax({
			type :'GET',
			url:"<?php echo $_SESSION['grp'];?>/load_page.php",
			data: "type="+type+"&mm="+mm+"&sm="+sm,
			success: function(daaa){

				$('#tabid').empty().html(daaa);
				
				$('.datatable-example').dataTable();
				 $('.tagname').tagsInput({width:'auto'});
			},
			error : function(xhr, status, error)
				{
					 alert(xhr.responseText);
				}
				});
		
	},
	error : function(xhr, status, error)
	{
 		 alert(xhr.responseText);
	}
		
	}); 
}

function removes1(i,tot,vname)
{
	
	var type,tn,fi,mm,sm,nn,dads,cals;
	cals=parseInt(tot)-1;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	tn='vehicle_pro';
	fi='vehi_id';
	type=3;
	dads=$('#gdtime').val();
	$.ajax({
	
	type: 'POST',
	url: "<?php echo $_SESSION['grp'];?>/remove_page.php?",
	data: "sno="+i+"&tname="+tn+"&field="+fi,
	success: function(){
		 toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.error(vname+' was successfully Removed..!');
			
			$.ajax({
			type :'GET',
			url:"<?php echo $_SESSION['grp'];?>/load_page.php",
			data: "type="+type+"&mm="+mm+"&sm="+sm+"&dads="+dads,
			success: function(daaa){
				
				if($('#vs1').is(':visible'))
				{
					var ss,sd;
					$('#tabonly').empty().html(daaa);
					ss=$('#sptxt').text();
					sd=ss.substr(0,ss.length-3);
					$('#sptxt').text(sd+' ('+cals+')');
				}
				else
				{
					var ss,sd;
					$('#tbonly1').empty().html(daaa);
					ss=$('#sptxt1').text();
					sd=ss.substr(0,ss.length-3);
					$('#sptxt1').text(sd+' ('+cals+')');
				}
				
				
				$('.datatable-example').dataTable();
			},
			error : function(xhr, status, error)
				{
					 alert(xhr.responseText);
				}
				});
		
	},
	error : function(xhr, status, error)
	{
 		 alert(xhr.responseText);
	}
		
	}); 
	
	

}


</script>