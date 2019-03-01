<?php
 if(isset($_POST['insert_season']) && ($_POST['insert_season']=="insert_season_val"))
 {
	for($z=1; $z<=9; $z++)
	{
		 $sname=$_POST['sname'.$z];
		 $fdate=$_POST['fdate'.$z];
		 $tdate=$_POST['tdate'.$z];
		  $sel=$_POST['locksts'.$z];
		 $sea_id="season".$z."_rate";
		 
	$insert_season=$conn->prepare("insert into setting_season(season_id,season_name,from_date,to_date,lock_sts,status)values(?,?,?,?,?,'0')");
	$insert_season->execute(array($sea_id,$sname,$fdate,$tdate,$sel));
	}
	echo "<script>window.location.reload();</script>";
 }
 
  if(isset($_POST['update_season']) && ($_POST['update_season']=="update_season_val"))
 {
	 for($z=1; $z<=9; $z++)
	{
		 $sname=$_POST['ed_sname'.$z];
		 $fdate=$_POST['ed_fdate'.$z];
		 $tdate=$_POST['ed_tdate'.$z];
		 $sel=$_POST['locksts'.$z];
		 $sno=$_POST['sno'.$z];
		 
		$updatesea=$conn->prepare("update setting_season set season_name=?,from_date=?,to_date=?, lock_sts=? where sno=?");
		$updatesea->execute(array($sname,$fdate,$tdate,$sel,$sno));
	}
	
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

</style>

<?php 
						   
	$sea = $conn->prepare("SELECT * FROM setting_season where  status = '0' ORDER BY sno ASC");
	$sea->execute();
	//$row_sea = mysql_fetch_assoc($sea);
	$row_sea_main=$sea->fetchAll();
	$totalRows_sea = $sea->rowCount();
?>
	<div class="container-fluid">
				
				<!-- Begin page heading -->
				<h1 class="page-heading">Master Pro<small>&nbsp;Manage Seasons</small></h1>
				
					<div class="row">
                    <form name="season" method="post">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
                                 <?php 
								 if($totalRows_sea>0)  {
								   ?>
                                   <div class="input-group">
                                   <a id="edit_id" class="btn btn-info " onclick="make_editable()" ><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                  
                                  <button type="submit" id="update_id" onclick="return validate_season()"  name="update_season" value="update_season_val" class="btn btn-info pull-left" style="display:none;" ><i class="fa fa-mail-reply-all (alias)"></i>&nbsp; Update&nbsp;</button> 
                             <a id="cancel_id" class="btn btn-default btn-sm " style="display:none;" onclick="cancel_fun()" >&nbsp; Cancel </a>
                                  </div>
                                   <?php 
								 }else{
								   ?>
                           <button type="submit"  name="insert_season" value="insert_season_val" class="btn btn-info btn-block" ><i class="fa fa-plus"></i>&nbsp; Add Season </button>
                           <?php } ?>
								</div>
                                <h3 class="panel-title"><i class="fa  fa-cogs icon-sidebar"></i>&nbsp;Season Settings</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                    <div class="table-responsive" id="default_table">
                                   <?php 
								 if($totalRows_sea>0)  {
								   ?>
						<table class="table table-striped table-hover datatable-example" >
							<thead class="the-box dark full">
								<tr>
									<th width="10%"><center> S.No.</center> </th>
                                <th width="25%"><center><i class="fa fa-cloud-upload "></i>&nbsp; Season Name</center></th>
								<th width="20%" ><center><i class="fa fa-calendar-o "></i>&nbsp; From Date</center></th>
                                <th width="20%" ><center><i class="fa fa-calendar "></i>&nbsp; To Date</center></th>
                                <th width="20%" ><center><i class="fa fa-flag "></i>&nbsp; Status</center></th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
				foreach($row_sea_main as $row_sea)
				{
							?>
<tr class="even gradeA">
<td ><center>season<?php echo $i;?></center></td>
<td><center><label id="sn_label<?php echo $i; ?>"><?php echo $row_sea['season_name']; ?></label>
<input type="text" id="ed_sname<?php echo $i; ?>" class="form-control " value="<?php echo $row_sea['season_name']; ?>" name="ed_sname<?php echo $i; ?>" style="display:none" /></center></td>
<td><center><label id="fd_label<?php echo $i; ?>"><?php echo $row_sea['from_date']; ?></label>
<input type="text" data-date-format="yyyy-mm-dd"  id="ed_fdate<?php echo $i; ?>" class="datepick11 form-control " value="<?php echo $row_sea['from_date']; ?>" name="ed_fdate<?php echo $i; ?>" style="display:none" onclick="clear_bgc('#ed_fdate<?php echo $i; ?>')" /></center></td>
<td><center><label id="td_label<?php echo $i; ?>"><?php echo $row_sea['to_date']; ?></label>
<input type="text" data-date-format="yyyy-mm-dd"  id="ed_tdate<?php echo $i; ?>" class="datepick11 form-control " value="<?php echo $row_sea['to_date']; ?>" name="ed_tdate<?php echo $i; ?>" style="display:none"  onclick="clear_bgc('#ed_tdate<?php echo $i; ?>')" /></center>
<input type="hidden" id="sno_id<?php echo $i; ?>" name="sno<?php echo $i; ?>" value="<?php echo $row_sea['sno']; ?>" />
</td>
<td>
<?php if($row_sea['lock_sts'] == '0')
{?>
<a class="btn btn-default btn-sm btn-rounded-sm" id="sel_label<?php echo $i; ?>" style=" margin-left:60px;background-color:#E7F2D2; font-weight:700; color:#5CA578">&nbsp;<i class="fa fa-thumbs-up" style="color:#188943"></i>&nbsp; Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<!--<a class="btn btn-success btn-sm" href="javascript:void(0)" ><i class="fa fa-lock"></i>&nbsp; Active</a>-->
<?php }else{?>
<a class="btn btn-default btn-sm btn-rounded-sm" id="sel_label<?php echo $i; ?>" style=" margin-left:60px;background-color:#F2E4DE; font-weight:700; color:#DB7F4F">&nbsp;<i class="fa fa-thumbs-down" style="color:#E77B7B"></i>&nbsp; Deactive&nbsp;</a>
<?php } ?>
<div id="locksts<?php echo $i; ?>" style="display:none">
<select  name="locksts<?php echo $i; ?>" data-placeholder="Choose" class="form-control chosen-select" >
<option > </option>
<option <?php if($row_sea['lock_sts']=='0'){ ?> selected="selected" <?php } ?> value="0"><i class="fa fa-thumbs-up"></i>&nbsp;Active&nbsp;</option>
<option <?php if($row_sea['lock_sts']=='1'){ ?> selected="selected" <?php } ?> value="1"><i class="fa fa-thumbs-down"></i>&nbsp;Deactive&nbsp;</option>
</select>
</div>


</td>
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
                                <?php } else{?>
                              <table class="table table-striped table-hover datatable-example" >
							<thead class="the-box dark full">
								<tr>
									<th width="10%"><center>S.No. </center></th>
                                <th width="20%"><center><i class="fa fa-cloud-upload "></i>&nbsp; Season Name</center></th>
								<th width="25%" ><center><i class="fa fa-calendar-o "></i>&nbsp; From Date</center></th>
                                <th width="25%" ><center><i class="fa fa-calendar "></i>&nbsp; To Date</center></th>
                                 <th width="20%" ><center><i class="fa fa-flag "></i>&nbsp; Status</center></th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
				while($i<=9)
				{
							?>
<tr class="even gradeA">
<td ><center>Season <?php echo $i;?></center></td>
<td><center><div class="input-group"><span class="input-group-addon tooltips" ><i class="fa fa-tag fa-fw"></i></span><input type="text"  class="form-control" id="sname<?php echo $i; ?>" name="sname<?php echo $i; ?>" /></div></center></td>
<td><center><div class="input-group"><span class="input-group-addon" ><i class="fa  fa-calendar-o fa-fw"></i></span><input  class="datepick11 form-control " data-date-format="yyyy-mm-dd"  type="text" id="fdate<?php echo $i; ?>" name="fdate<?php echo $i; ?>" /></div></center></td>
<td><center><div class="input-group"><span class="input-group-addon" ><i class="fa  fa-calendar fa-fw"></i></span><input  class="datepick11 form-control" data-date-format="yyyy-mm-dd"  type="text" id="tdate<?php echo $i; ?>" name="tdate<?php echo $i; ?>" /></div></center></td>
<td>
<center>
<div class="input-group"><span class="input-group-addon" ><i class="fa  fa-flag fa-fw"></i></span>
<select id="locksts<?php echo $i; ?>" name="locksts<?php echo $i; ?>"  data-placeholder="Choose" class="form-control chosen-select" style="display:none;">
<option > </option>
<option  value="0"><i class="fa fa-thumbs-up"></i>&nbsp;Active&nbsp;</option>
<option  value="1"><i class="fa fa-thumbs-down"></i>&nbsp;Deactive&nbsp;</option>
</select>
</div>
</center>
</td>

</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
                                <?php } ?>
                                </div>
                                
                                </div>
                                </div>
                            </div>
                        </div><!-- /.col-sm-8 -->
                        </form>
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


function make_editable()
{
	for(var r=1;r<=9;r++)
	{
		$('#sn_label'+r).fadeOut();
		$('#ed_sname'+r).fadeIn(1000);
		$('#fd_label'+r).fadeOut();
		$('#ed_fdate'+r).fadeIn(1000);
		$('#td_label'+r).fadeOut();
		$('#ed_tdate'+r).fadeIn(1000);
		$('#sel_label'+r).fadeOut();
		$('#locksts'+r).fadeIn(1000);
	}
	
	$('#edit_id').hide();
	$('#update_id').show();
	$('#cancel_id').show();
}

function cancel_fun()
{
	for(var r=1;r<=9;r++)
	{
		$('#sn_label'+r).fadeIn();
		$('#ed_sname'+r).fadeOut();
		$('#fd_label'+r).fadeIn();
		$('#ed_fdate'+r).fadeOut();
		$('#td_label'+r).fadeIn();
		$('#ed_tdate'+r).fadeOut();
		$('#sel_label'+r).fadeIn();
		$('#locksts'+r).fadeOut();
	}
	
	$('#edit_id').show();
	$('#update_id').hide();
	$('#cancel_id').hide();
}



function validate_season()
{
	var sts='';
	for(var r=1;r<=9;r++)
	{
		if($('#ed_sname'+r).val().trim() == '')
		{
			$('#ed_sname'+r).css('background','#F0E7DD');
			$('#ed_sname'+r).focus();
			return false;
		}
		if($('#ed_fdate'+r).val().trim() == '')
		{
			$('#ed_fdate'+r).css('background','#F0E7DD');
			$('#ed_fdate'+r).focus();
			return false;
		}
		if($('#ed_tdate'+r).val().trim() == '')
		{
			$('#ed_tdate'+r).css('background','#F0E7DD');
			$('#ed_tdate'+r).focus();
			return false;
		}
	}
	
	/*for(var r=1;r<=9;r++)
	{
		
		var fDate,lDate,cDate;
    fDate = Date.parse($('#ed_fdate'+r).val());
    lDate = Date.parse($('#ed_tdate'+r).val());
	
		for(var rr=1;rr<=9;rr++)
		{
				if(rr != r)
				{
    				cDate1 = Date.parse($('#ed_fdate'+r).val());
					cDate2 = Date.parse($('#ed_tdate'+r).val());
    				if((cDate1 <= lDate && cDate1 >= fDate) && (cDate2 <= lDate && cDate2 >= fDate)) {
       				 sts='yes';
    				}else
					{
					sts='no';	
					}
				}
		}
		
	}
	
	alert(sts);*/
	return true;
}

function clear_bgc(id)
{
	$(id).css('background','#FFF');
}


$(document).ready(function(e) {
	$('.chosen-select').chosen({width : '100%'});
});
/*function search_hotel(hid)
{
	//alert(hid);
	$.get("ADMIN/ajax_hotel?type=9&hid="+hid, function (result){
				$('#default_table').empty().html(result);
				$('.datatable-example').dataTable();
				$('.tagname').tagsInput({width:'auto'});
							 $('.datepick').datepicker();
        });
}*/
</script>