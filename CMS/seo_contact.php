<?php
require_once('Connections/divdb.php');

mysql_select_db($database_divdb, $divdb);
$query_seo = "SELECT * FROM seo_settings_new where type='CON'";
$seo = mysql_query($query_seo, $divdb) or die(mysql_error());
$row_seo = mysql_fetch_assoc($seo);
$totalRows_seo = mysql_num_rows($seo);

?>
					<div class="container-fluid">
					<!-- Begin page heading -->
					<h1 class="page-heading">SEO Pro - Contact</h1>
					<!-- End page heading -->
					<!-- BEGIN DATA TABLE -->
					<div class="the-box">
                    	<div class="panel with-nav-tabs panel-info panel-square panel-no-border">
						  <div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#keywords" data-toggle="tab"><i class="fa  fa-list"></i>&nbsp; Keywords</a>
								</li>
								<li><a href="#author" data-toggle="tab"><i class="fa fa-user"></i>&nbsp; Author </a></li>
                                <li><a href="#desc" data-toggle="tab"><i class="fa fa-files-o"></i>&nbsp; Description</a></li>
							
                                <!-- <li><a href="#scripts" data-toggle="tab"><i class="fa fa-rocket"></i>&nbsp; Analytic Script</a></li> -->
							</ul>
						  </div>
							<div id="panel-collapse-1" class="collapse in">
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="keywords">
<div class="row">
	<div class="col-sm-12" style="text-align:center; padding:10px; background-color: rgb(230, 248, 255);color: rgb(57, 123, 171);margin-bottom:20px">
		<div class="col-sm-10"><strong>Meta Tag - Keywords </strong><p style="color:#F00;">Note: Add 120 characters only.</p></div>
		<div class="col-sm-2" align="center">
			<button class="btn btn-info" type="button" name="sub_keywords" id="sub_keywords" onclick="fun_keywords('keywords')">
				<i class="fa fa-edit"></i>&nbsp;Submit</button>
		</div>
	</div>
	<div class="col-sm-12" sytle="text-align:center; padding:3px; ">
		<input name="seo_keywords[]" id="seo_keywords" style="width:100%" class="tagname form-control" value="<?php echo $row_seo['keywords']; ?>"/>
	</div>
</div>
										</div>

										<div class="tab-pane fade" id="desc">
<div class="row">
	<div class="col-sm-12" style="text-align:center; padding:10px; background-color: rgb(230, 248, 255);color: rgb(57, 123, 171);margin-bottom:20px">
		<div class="col-sm-10"><strong>Meta Tag - Description </strong>
			<p style="color:#F00;">Note: Add 250 characters only.</p>
			</div>
		<div class="col-sm-2" align="center">
			<button class="btn btn-info" type="button" name="sub_description" id="sub_description" onclick="fun_keywords('description')">
				<i class="fa fa-edit"></i>&nbsp;Submit</button>
		</div>
	</div>
	<div class="col-sm-12" sytle="text-align:center; padding:3px; ">
		<textarea name="seo_description" id="seo_description" style="width:100%; resize: vertical; min-height:100px" class="form-control" rows='8' placeholder="Enter description" ><?php echo $row_seo['description']; ?></textarea>
		<!--<input name="seo_description[]" id="seo_description" style="width:100%" class="tagname form-control" value="<?php echo $row_seo['description']; ?>"/> -->
	</div>
</div>							
										</div>

										<div class="tab-pane fade" id="author">
<div class="row">
	<div class="col-sm-12" style="text-align:center; padding:10px; background-color: rgb(230, 248, 255);color: rgb(57, 123, 171);margin-bottom:20px">
		<div class="col-sm-10"><strong>Meta Tag - Author </strong></div>
		<div class="col-sm-2" align="center">
			<button class="btn btn-info" type="button" name="sub_author" id="sub_author" onclick="fun_keywords('author')">
				<i class="fa fa-edit"></i>&nbsp;Submit</button>
		</div>
	</div>
	<div class="col-sm-12" sytle="text-align:center; padding:3px; ">
		<input name="seo_author[]" id="seo_author" style="width:100%" class="tagname form-control" value="<?php echo $row_seo['author']; ?>"/>
	</div>
</div>			
										</div>
                                        <div class="tab-pane fade" id="scripts">
<div class="row">
	<div class="col-sm-12" style="text-align:center; padding:10px; background-color: rgb(230, 248, 255);color: rgb(57, 123, 171);margin-bottom:20px">
		<div class="col-sm-10"><strong>Meta Tag - Analytic Script </strong></div>
		<div class="col-sm-2" align="center">
			<button class="btn btn-info" type="button" name="sub_scripts" id="sub_scripts" onclick="fun_keywords('scripts')">
				<i class="fa fa-edit"></i>&nbsp;Submit</button>
		</div>
	</div>
	<div class="col-sm-12" sytle="text-align:center; padding:3px; ">
<textarea name="seo_scripts" id="seo_scripts" style="width:100%; resize: vertical; min-height:100px" class="form-control" rows='8' placeholder="Enter Analytic Scripts" ><?php echo $row_seo['scripts']; ?></textarea>

	<!--	<input name="seo_scripts[]" id="seo_scripts" style="width:100%" class="tagname form-control" value="<?php echo $row_seo['scripts']; ?>"/> -->
	</div>
</div>			
										
                                        </div>
                                       
										<!-- /.tab-pane fade -->
									</div><!-- /.tab-content -->
								</div><!-- /.panel-body -->
							</div><!-- /.collapse in -->
						</div>
                    
					</div><!-- /.the-box .default -->
					<!-- END DATA TABLE -->
				</div><!-- /.container-fluid -->
                <!-- /.container-fluid -->
<script>
$(document).ready(function(){
	$('.tagname').tagsInput({allowDuplicates: 'true', width: '100%', height:'200px' });
});

//keywords

function fun_keywords(fld)
{
	var kvals;
	if(fld=="keywords")
	{
		kvals=$('#seo_keywords').val().trim();
		
	}else if(fld=="description")
	{
		kvals=$('#seo_description').val().trim();
	}else if(fld=="author")
	{
		kvals=$('#seo_author').val().trim();
	}else
	{
		kvals=$('#seo_scripts').val().trim();
	}
	var typ='CON';
	//alert(kvals);
	if(kvals!='')
	{
		if(fld=='keywords'){var len='120';} else if(fld=='description'){var len='250';}
		if(fld=='keywords' && kvals.length<=len) {

		
		$('#dvLoading').fadeIn();
		$.post('ADMIN/ajax_seo.php?type=2',{'field':fld, 'vals':kvals,'typ':typ},function(result)
		{
			$('#dvLoading').fadeOut();	
			//alert(result);
			toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      		toastr.success(fld+' are successfully updated !');
		});	
	} else{
		alert('You only enter limited characters');
	}
	}else{
		toastr.options={ "closeButton":true,"positionClass":"toast-top-right", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
      		toastr.info('Please Enter Any Inputs !');
	}
}

function delete_fdbk(no,sno)
{
  var ty=7;
	var cname=$('#client_name').val();
	var cfeed=$('#feedtarea').val();
	$.post('ADMIN/ajax_front_end.php?type='+ty,{'sno':sno},function(result)
	{
		$('#fdbk_main'+no).hide();
	});	
}

</script>                