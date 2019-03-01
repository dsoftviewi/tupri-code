<?php


$hspotpro = $conn->prepare("SELECT * FROM hotspots_pro where status = '0' ORDER BY sno DESC");
$hspotpro->execute();
$row_hspotpro_main = $hspotpro->fetchAll();
$totalRows_hspotpro = $hspotpro->rowCount();


$hot = $conn->prepare("SELECT distinct(datetime) FROM hotspots_pro ORDER BY datetime ASC");
$hot->execute();
$row_hot_main  = $hot->fetchAll();
$totalRows_row_hot = $hot->rowCount(); 

?>
<style>
 .ss
{
	background-color:transparent !important ;
}
.nav-dropdown-contents
{
	height: auto;
	min-width: 248px;
	max-width: 240px;
	overflow-y:auto;
}

.nav-dropdown-contents ul
{
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

#loading_side{
                width: 100%;
                position: absolute;
                left:45%;
				margin-top:10%;
            }
</style>
	<div class="container-fluid">

				<h1 class="page-heading">Itinerary Pro <small>Manage Itineraries</small></h1>
				
					<div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
								</div>
                                <h3 class="panel-title"><i class="fa fa-map-marker"></i>&nbsp;Hotspots Info</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                <?php if($totalRows_hspotpro>0){?>
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable" >
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                  
                                    <div align="right">
                                    <span id="vs1"><strong> Add Hotspots </strong></span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu" style="text-align:left">
                                  
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li><a class="add_hots1" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a></li>
									<li><a class="add_hots2 " title="Upload file" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                &nbsp;&nbsp;
                                    &nbsp;&nbsp;
                                    <input type="hidden" id="lcn" value="1" />
                                    <div class="btn-group">
								  <a class="btn btn-danger btn-sm dropdown-toggle" id="sptxt" data-toggle="dropdown">
									<i class="fa fa-filter"></i> All records (<?php echo $totalRows_hspotpro;?>) <span class="caret"></span>
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
											
													  foreach($row_hot_main as $row_hot)
													  {
									   
	
	$hot1 = $conn->prepare("SELECT * FROM hotspots_pro where datetime=?");
	$hot1->execute(array($row_hot['datetime']));
	$row_hot1 = $hot1->fetch(PDO::FETCH_ASSOC);
 $totalRows_hot1 = $hot1->rowCount();
	
	
	$sda=str_replace('-','_',$row_hot['datetime']);
								    $dsd=str_replace(' ','_',$sda);
									 $fns=str_replace(':','_',$dsd).'.csv';
									   ?>
                                    <li class="col-sm-10 " >
                                    <a id="<?php echo 'h'.$ds;?>" style="margin-left:-3%;color:#656D8D;" onclick="lodloc('<?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).' ('.$totalRows_hot1.')';?>','<?php echo $totalRows_hspotpro;?>','<?php echo $row_hot['datetime'];?>')"  data-toggle="tooltip" data-original-title="Click to view all records" href="javascript:void(0);"><i class="fa fa-calendar fa-fw"></i> <?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).'<br>'.' ('.$totalRows_hot1.')';?></a>
                                    </li>
                                    <li class="col-sm-2 " id="<?php echo 'h'.$ds.$ds;?>" ><a class="ss pull-right"   href="javascript:void(0);" style="" onclick="rem('<?php echo $row_hot['datetime'];?>','<?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).' ('.$totalRows_hot1.' records )';?>','<?php echo $fns;?>');"><i class="fa fa-trash-o " style="color:#D5472B" data-toggle="tooltip" data-original-title="Remove all records"></i></a></li>
                                     
									<?php $ds++;  $sda='';
													 $dsd='';
													 $fns='';}
													 ?>
													
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

 <?php

 ?>
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th># </th>
									<th colspan="2"><i class="fa fa fa-map-marker"></i> Hotspot Name</th>
									<th><i class="fa fa-clock-o"></i> Timing </th>
									<th><i  class="fa fa-globe"></i> City </th>
									<th ><center><i class="fa fa-film"></i> Spot View </center></th>
                                    <th><i class="fa fa-exclamation-triangle"></i> Process </th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
							$es='';
							$es1='';
							foreach($row_hspotpro_main as $row_hspotpro)
							{
								
								
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_hspotpro[spot_city]));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);	
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td width="25%" ><?php echo $row_hspotpro['spot_name'];?></td>
                                    <td width='12%'>
                                    	<a id="btn_<?php echo $row_hspotpro['sno'].'_'.$row_hspotpro['spot_city']; ?>" class="badge badge-info icon-count" data-toggle='tooltip' data-original-title='Priority -<?php echo $row_hspotpro['spot_prior'].' ( '.$row_hotelcity['name'].' )'; ?>' style="background-color:#2893BD; color:#FDFEFF;" ondblclick="show_prior_tab('<?php echo $row_hspotpro['sno']; ?>','<?php echo $row_hspotpro['spot_city']; ?>')"><strong style="font-size:14px;"><?php echo $row_hspotpro['spot_prior']; ?></strong></a>
                                        
                                        <table id="tab_<?php echo $row_hspotpro['sno'].'_'.$row_hspotpro['spot_city']; ?>" style="display:none;"><tr><td> 			<?php
									 
									$hotprior = $conn->prepare("SELECT * FROM  hotspots_pro where spot_city=?");
									$hotprior->execute(array($row_hspotpro['spot_city']));
									//$row_hotprior= mysql_fetch_assoc($hotprior);
									$row_hotprior_main=$hotprior->fetchAll();
									$tot_hotprior=$hotprior->rowCount();
										 ?>
                                    <?php if($tot_hotprior>0){ ?>
                                 <select name="prior_<?php echo $row_hspotpro['sno'].'_'.$row_hspotpro['spot_city']; ?>" id="prior_<?php echo $row_hspotpro['sno'].'_'.$row_hspotpro['spot_city']; ?>" data-placeholder="Choose Priority" class="form-control city_cls<?php echo $row_hspotpro['spot_city']; ?>">
                                 <?php for($pr=1;$pr<= $tot_hotprior;$pr++)
								 {
									 if($pr==$row_hspotpro['spot_prior'])
									 {?>
								  <option selected value="<?php echo $pr; ?>"><?php echo $pr; ?></option>		 
									<?php }else{
									?>
													<option value="<?php echo $pr; ?>"><?php echo $pr; ?></option>
									<?php 			
									  }
								 }//for loop end?>
                                 </select> <?php }?>  </td><td><a class="btn  btn-default" onclick="update_prior('<?php echo $row_hspotpro['sno']; ?>','<?php echo $row_hspotpro['spot_city']; ?>','<?php echo $row_hotelcity['name']; ?>')"><i class="  fa fa-check-square" style="color:#23691E"></i></a></td><td><a class="btn  btn-default" onclick="hide_prior_tab('<?php echo $row_hspotpro['sno']; ?>','<?php echo $row_hspotpro['spot_city']; ?>')"><i class="  fa fa-times-circle" style="color:#900"></i></a></td></tr></table>
                                    </td>
									<td width="18%"><?php 
									$match[1]='';
									$text =$row_hspotpro['spot_timings'];
								 $strpos=strpos($text,'(');
								$endpos=strpos($text,')');
								if($strpos != 0)
								{
									$txt= $row_hspotpro['spot_timings'];
									echo substr($row_hspotpro['spot_timings'],0,$strpos)."<br>";
									echo $stext=substr($txt,$strpos);
								}else
								{
									echo $row_hspotpro['spot_timings'];
								}
								?></td>
									<td  width="15%" > <?php
									
									
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_hspotpro[spot_city]));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);								 
									  echo $row_hotelcity['name']."<br>";
									  
	
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_hspotpro[spot_state]));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									  echo "".$row_hotelstate['name']."";
									?></td>
                                    
									<td align="center" width="18%" >
                                    <div class="btn-group" align="center">
<?php if( $row_hspotpro['spot_images'] != '') 
{?>
<a class="add_hots4 btn  btn-default"  title="Images of - <?php echo $row_hspotpro['spot_name'];?>" href="ADMIN/hotspot_images.php?sid=<?php echo $row_hspotpro['hotspot_id'];?>"><i class="fa fa-picture-o" style="color:#3576AC"></i></a>
<?php }else{ ?>
<a class=" btn  btn-default"  title="Images of - <?php echo $row_hspotpro['spot_name'];?>" style="color:#CCC;" ><i class="fa fa-picture-o" ></i></a>
<?php }
if($row_hspotpro['video_link'] != '')
{
?>
                                    <a class="viewspot1 btn  btn-default"  title="Video of - <?php echo $row_hspotpro['spot_name'];?>" href="<?php echo $row_hspotpro['video_link'];?>"><i class="fa fa-video-camera" style="color:#3576AC"></i></a>
	<?php }else{?>
    								<a class=" btn  btn-default"  title="Video of - <?php echo $row_hspotpro['spot_name'];?>" style="color:#CCC;" ><i class="fa fa-video-camera" ></i></a>
    <?php }?>								
                                    
										</div>
                                   <input type="hidden" id='img<?php echo $row_hspotpro['hotspot_id']; ?>' value='<?php echo $row_hspotpro['spot_images']; ?>'  />
                                    </td>
                                    <td class="center" width="14%">
                                    <div class="btn-group">
								  <button  class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown" >
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle pull-right" role="menu" style="width:12%">
                                    <li>
                                    <a class="update_hot" title="Update - <?php echo $row_hspotpro['spot_name'];?>" href="<?php echo $_SESSION['grp'];?>/update_hotspot.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&hid=<?php echo $row_hspotpro['hotspot_id'];?>"><i class="fa fa-wrench"></i>&nbsp; Update Details</a></li>
                                    <li><a class="add_hots3" href="<?php echo $_SESSION['grp'];?>/spot_img_upload.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&hid=<?php echo  $row_hspotpro['hotspot_id'];?>" onclick="get_sid('<?php echo  $row_hspotpro['hotspot_id'];?>')" ><i class="fa fa-upload"></i>&nbsp; Upload Images</a></li>
                                  <li><a href="javascript:void(0);" onclick='removes("<?php  echo $row_hspotpro['hotspot_id'];?>")' ><i class="fa fa-trash-o"></i>&nbsp; Remove</a>
                                  <input type="hidden" value="<?php echo $row_hspotpro['spot_name']; ?>" id="txt_<?php echo $row_hspotpro['hotspot_id']; ?>"  /></li>
								  </ul>
                                    </div>
                                    </td>
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
                                </div>
                                <div class="" id="tabon2">
                                </div>
                                  <?php }else{?>  
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable">
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                    <span class="text-muted">Vehicle's are not yet setting. Click to setup </span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu">
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li><a class="add_hots1" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a></li>
									<li><a class="add_hots2 " title="Upload file" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a></li>
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

function loading_sidediv(){
$('#loading_side').html("<img src='assets/loader/ajax-loader.gif' height='50px'/>").fadeIn('fast');
}

function loading_hide_sidediv(){
$('#loading_side').fadeOut('fast');
}

function show_prior_tab(sno,cid)
{
	$('#btn_'+sno+'_'+cid).hide();
	$('#tab_'+sno+'_'+cid).show();	
	
}

function hide_prior_tab(sno,cid)
{
	$('#tab_'+sno+'_'+cid).hide();
	$('#btn_'+sno+'_'+cid).show();
		
}
function update_prior(sno,cid,cname)
{
	//alert(cname);
	var type=21;
	var str=$('#prior_'+sno+'_'+cid).val();
	$.get("ADMIN/ajax_hotel.php?type="+type+"&cid="+cid+"&sno="+sno+"&prior="+str,function(result){
				//alert(result);
				$('#btn_'+sno+'_'+cid+' strong').empty().prepend(str);
				//alert($('#btn_'+sno+'_'+cid+' strong').text());
				$('#tab_'+sno+'_'+cid).hide();
				
				$('#btn_'+sno+'_'+cid).attr('data-original-title','Priority -'+str+' ( '+cname+' )');
				$('#btn_'+sno+'_'+cid).show();
				
				hide_option_others(str,sno,cid);
		});
}

function hide_option_others(opt,sno,cid)
{

	var len=$('.city_cls'+cid).length;
	
					$('.city_cls'+cid+' > option').each(function() 
						{
						
						if(this.value == opt)
						{
						//alert($('select[id$="'+cid+'"]').attr('id'));
							this.remove();
						}
					});
					var opt1=parseInt(opt)-1;
					//alert(opt1);
					var opt2=parseInt(opt1)+1;
					//$('<option value='+opt+'>'+opt+'</option>').insertAfter($('#prior_'+sno+'_'+cid+' option:eq('+opt1+')'));
					if(opt1>0)
					{
					$('<option value='+opt+'>'+opt+'</option>').insertAfter($('#prior_'+sno+'_'+cid+' option[value="'+opt1+'"]'));
					}else{
						$('<option value='+opt+'>'+opt+'</option>').insertBefore($('#prior_'+sno+'_'+cid+' option[value="2"]'));
					}
					
					$('#prior_'+sno+'_'+cid+' > option').each(function() 
					{
						if(this.value==opt)
						{
							this.attr('selected','selected');
						}
					});
					
				//	$('#prior_'+sno+'_'+cid+' option:eq('+opt2+')').attr('selected','selected');
	/*for(var h=0;h<len;h++)
	{
		alert($('select[id$="'+cid+'"]').attr('id'));
	}*/
}

function search_hotspot(cid)
{
	var type=14;
	$.get("ADMIN/ajax_hotel.php?type="+type+"&cid="+cid,function(result)
	{
		alert(result);
	});
}


//for load the current date records
function lodloc(dates,toos,dates1)
{
	//alert('dd');
	var nli,type,vv,mm,sm;
	type=7;

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
      	toastr.info(dates+' records are viewing..!');
		 
		 $('#tabonly').empty().html(dd);
		 $('.datatable-example').dataTable();
		 $('.tagname').tagsInput({width:'auto'});
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
      	toastr.info(dates+' records are viewing..!');
		
		 $('#tbonly1').html(dd);
		 $('.datatable-example').dataTable();
		 $('.tagname').tagsInput({width:'auto'});
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
	type2=8;
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
      	toastr.info('Main page records are viewing..!');
				
				$('#tabid').empty().html(da);
				$('.datatable-example').dataTable();
				$('.tagname').tagsInput({width:'auto'});
				
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
	type2=8;
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
      	toastr.info('Main page records are viewing..!');
				
				$('#tabid').empty().html(da);
				$('.datatable-example').dataTable();
				$('.tagname').tagsInput({width:'auto'});
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
	tn='hotspots_pro';
	fi='datetime';
	type=8;
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
function removes(i)
{
	var vname=$('#txt_'+i).val();
	//alert('remove');
	var type,tn,fi,mm,sm,nn;
	mm='<?php echo $_GET['mm'];?>';
	sm='<?php echo $_GET['sm'];?>';
	tn='hotspots_pro';
	fi='hotspot_id';
	type=8;
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
window.location.reload(-1);
				//$('#tabid').empty().html(daaa);
				
				//$('.datatable-example').dataTable();
				// $('.tagname').tagsInput({width:'auto'});
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