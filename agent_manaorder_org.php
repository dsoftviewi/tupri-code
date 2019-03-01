<?php 
include("core/session.php"); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta name="keywords" content="DVI Holidays, Tour website" />
        <meta name="description" content="DVI Holidays">
        <meta name="author" content="DVI Holidays">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>DVI Holidays | Create Itinerary</title>
		<!-- BOOTSTRAP CSS (REQUIRED ALL PAGE)-->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- PLUGINS CSS -->
		<link href="core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<!--		<link href="core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">-->
		<link href="core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
	<!--	<link href="core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">-->
		<link href="core/assets/plugins/toastr/toastr.css" rel="stylesheet">
        <link href="core/assets/plugins/swal/sweet-alert.css" rel="stylesheet" type="text/css"/>
        <link href="core/assets/plugins/spinner/css/jquery.dpNumberPicker-holoLight-1.0.1-min.css" rel="stylesheet">
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="core/assets/css/style.css" rel="stylesheet">
		<link href="core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="core/assets/plugins/Tags/jquery.tagsinput.css" />
         <link rel="shortcut icon" href="images/logo2.png" type="image/x-icon">
         
 <link href="core/assets/bulletin.css" rel="stylesheet"><!-- news scroller -->
            	
        <script src="core/assets/js/jquery.min.js"></script>
 
	
        <style>
		#dvLoading
		{
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url(images/arrow_loader.gif) center no-repeat #fff;
			background-size:200px;
		}

		</style>
	</head>
 <body class="tooltips">
			          
			<div class="wrapper">
            
			<?php include("core/topbar.php");?>
            <div id="dvLoading"></div>
            <div class="loader_ax" style="display: none;"></div>
			<?php include("core/sidebar.php");?>
          <div class="page-content">

			<!-- BEGIN PAGE CONTENT -->
            <?php include($_SESSION['grp']."/tourplan.php");?>
            <?php include("core/news_scroller.php");?>
            <?php include("core/footer.php");?>
            </div>
			<!-- /.page-content -->
		</div>
        <!-- /.wrapper -->
		<!-- END PAGE CONTENT -->
		
		<!-- BEGIN BACK TO TOP BUTTON -->
		<div id="back-top">
			<a href="#top"><i class="fa fa-chevron-up"></i></a>
		</div>
        
       
        
         <script src="core/assets/plugins/fancybox/lib/jquery-1.8.2.min.js"></script>
         <link href="core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
    	<script src="core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
        <script type="text/javascript">
    $(document).ready(function() {
		
        $('.chosen-select1').chosen({'width':'100%'});
		 $(".chosen-select1").outerWidth(230);
        var w = screen.height;
            var h =screen.width;
			
		//this is for excel upload
    $('.add_city').fancybox({
	  width: w/2,
		height: h/3.9,
		autoSize	:  false,
		openEffect	: 'fade',
		closeEffect	: 'none',
		scrolling : 'no',
		type : 'iframe',
		 topRatio     : 0,
		 padding  :[10,10,0,10],
		 helpers   : { 
      overlay : {closeClick: false} 
                   },
	
        afterClose : function() {
			loading_sidediv();
    //parent.location.reload();
	$.get('<?php echo $_SESSION['grp'].'/ref_cities.php' ?>', function(data) {
		loading_hide_sidediv();
	  $('.load_cities').html(data);
	  $('.chosen-select').chosen({ 'width':'100%'});
	});
  },
		}); 
		
		
		 $('.add_hots4').fancybox({
	  width: w/0.8,
		height: h/2.70,
		autoSize	:  false,
		openEffect	: 'fade',
		closeEffect	: 'none',
		scrolling : 'no',
		type : 'iframe',
		 topRatio     : 0,
		 padding  :[10,10,0,10],
		 
		  
		 helpers   : { 
      overlay : {closeClick: false} 
                   },
		
        afterClose : function() {
  //  parent.location.reload();
	
  },
		});
		
			 $('.view_video').fancybox({
	  width: w/1,
		height: h/2.55,
		autoSize	:  false,
		openEffect	: 'fade',
		closeEffect	: 'none',
		scrolling : 'no',
		type : 'iframe',
		 topRatio     : 0,
		 padding  :[10,10,0,10],
		 
		  
		 helpers   : { 
      overlay : {closeClick: false} 
                   },
		});
		
    });
   
    </script>
		<!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
		<script src="core/assets/js/bootstrap.min.js"></script>
		<script src="core/assets/plugins/retina/retina.min.js"></script>
		<script src="core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="core/assets/plugins/Tags/jquery.tagsinput.js"></script>
		<!--<script src="core/assets/plugins/skycons/skycons.js"></script>-->
		<script src="core/assets/plugins/prettify/prettify.js"></script>    
        <script src="core/assets/plugins/swal/sweet-alert.js"></script>
		<script src="core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="core/assets/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
<!--		<script src="core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="core/assets/plugins/markdown/markdown.js"></script>
		<script src="core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="core/assets/plugins/slider/bootstrap-slider.js"></script>-->
		<script src="core/assets/plugins/toastr/toastr.js"></script>
        <script src="core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="core/assets/plugins/spinner/js/jquery.dpNumberPicker-1.0.1-min.js"></script>
      
		<script src="core/assets/js/apps.js"></script>
		<script src="core/assets/js/demo-panel-1.js"></script>
        <script src="core/assets/jQuery1/form-validator/spin.js"></script>
        <script src="core/assets/js/moment.js"></script>
        
        
  <script src="core/assets/jquery.bulletin.js"></script>    
  <script>
   $(function() {$('#bulletin').bulletin(); });
  </script>
        
		<script>
		 <?php if((isset($_GET['tost'])) && ($_GET['tost']==1)){?>
	$(document).ready(function() {
     //for showing detailed itinerary report after submit
	 <?php if(substr($_GET['id'],0,2)=='T#') {?>
			 $.get('<?php echo $_SESSION['grp']; ?>/itin_submit_trav_report.php?planid=<?php echo urlencode($_GET['id']); ?>',function(result)
			 {
				 //alert(result);
				 $('#plan_det_info_modbody').html(result);
				 $('#plan_det_info_mod').modal('show');
			 });
	 <?php }else if(substr($_GET['id'],0,2)=='TH'){?>
	 		
			$.get('<?php echo $_SESSION['grp']; ?>/itin_submit_trhot_report.php?planid=<?php echo urlencode($_GET['id']); ?>',function(result)
			 {
				 //alert(result);
				 $('#plan_det_info_modbody').html(result);
				 $('#plan_det_info_mod').modal('show');
			 });
	 
	 <?php } ?>
     
            });
<?php } ?>
		
		
		$(window).load(function(){
		$('#dvLoading').fadeOut("slow");
		});

		$('.tooltips').tooltip();
		$('.tooltips1').tooltip();
		$(document).ready(function(e) {
		
		$('.datatable-example').dataTable();
		    //get_cities();
			//getvehicles(0);
			//loading_sidediv();
			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
			$('.datepickerk').datepicker(
			{
				onRender: function(date) 
				{
					return date.valueOf() < now.valueOf() ? 'disabled' : '';
				}
			});
			
			$('.datepickerz').datepicker(
			{
				onRender: function(date) 
				{
					return date.valueOf() < now.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev){
    			$(this).datepicker('hide');
				var dd=parseInt($("#nd .dp-numberPicker-input").val());
				
				var d = new Date($('#arrdate').val());
				d.setDate(d.getDate() + dd);
				var end_date=moment(d).format('YYYY-MM-DD');
				$('#depart_ddat').val(end_date);
				
			});
			
			/*$('.datepicker').datepicker()
    .on(picker_event, function(e){
        # `e` here contains the extra attributes
    });*/
			


			
			$('.timepickera').timepicker({
                defaultTime: '12:00 PM',
            });
			
			$('.timepickera2').timepicker({
                defaultTime: '12:00 PM',
				
            });
        });
		
		//window.onload = get_cities;
		
		/*$(".div-nicescroller").niceScroll({
		cursorcolor: "#656D78",
		cursorborder: "3px solid #313940",
		cursorborderradius: "10px",
		cursorwidth: "2px"

	});
	
	$(".div-nicescroller1").niceScroll({
		cursorcolor: "#3BAFDA",
		cursorborder: "3px solid #3BAFDA",
		cursorborderradius: "10px",
		cursorwidth: "2px"

	});*/

$(function() {
			$('.tagname').tagsInput({width:'auto'});
		});

function loading_sidediv(){
$('#loading_side').html("<img src='images/loader1.gif' width='30' height='30'/>").fadeIn('fast');
}
function loading_hide_sidediv(){
$('#loading_side').fadeOut('fast');
}

function loading_cityrow(){
	$('#loading_cityrow').html("<img src='images/loader1.gif' width='30' height='30'/>").fadeIn('fast');
}
function loading_hide_cityrow(){
	
$('#loading_cityrow').fadeOut('fast');
}

</script>

<script>
function get_cities() 
{
	$.get('<?php echo $_SESSION['grp'].'/ref_cities.php' ?>', function(data)
	{
	//loading_hide_sidediv();
	$('.load_cities').html(data);
	//$('.chosen-select').chosen('destroy');  
	$('.chosen-select').chosen({ 'width':'100%'});
			 
	});
}

function get_cities1(mrow,srow,arr_city_id,vehids)
{
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp']; ?>/row_cities.php?chek='+$('#check_boxs').val(), { incr1 : mrow, incr2 : srow, city_id: arr_city_id, arr_vehids: vehids }, function(data,sts,xh) {
		$('.loader_ax').fadeOut(500);
	//alert(data);
	//alert('check'+$('#check_boxs').val());
		loading_hide_cityrow();
		$('#load_cityrow'+mrow+srow).html(data);
		$('.chosen-select1').chosen({ 'width':'100%'});
		
		
	});
}

function get_cities2(incdy,cty) 
{
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp'].'/row_allcities.php' ?>', { incr1 : incdy, incr2 : cty }, function(data) {
		$('.loader_ax').fadeOut(500);
		loading_hide_cityrow();
	$('#load_cityrow'+incdy+cty).html(data);
	//$('.chosen-select').chosen('destroy');  
	$('.chosen-select1').chosen({ 'width':'100%'});
	});
}

function get_cities3(mrow,srow,arr_city_id,vehids) 
{
	$('.tooltips').tooltip();
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp'].'/ref_cities1.php' ?>', { incr1 : mrow, incr2 : srow, city_id: arr_city_id, arr_vehids: vehids }, function(data,sts,xh) {
		$('.loader_ax').fadeOut(500);
//		alert(data);
		$('.tooltips').tooltip();
		loading_hide_cityrow();
	$('#load_cityrow'+mrow+srow).html(data);
	$('.chosen-select1').chosen({ 'width':'100%'});
	});
}

function getvehicles(city_id)
{
	if (city_id != 0)
	{
		var cit_id = city_id.split('-');
		cit_id = cit_id[0].trim();
	}
	else
	{
		var cit_id = 0;
	}
	var inc=$('#vehdiv').val();
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp'].'/ref_vehicl.php' ?>', { city_id: cit_id, incr : inc }, function(data) {
		$('.loader_ax').fadeOut(500);
	  $('#load_vehicl').html(data);
	  $('.chosen-select').chosen({ 'width':'100%'});
	});
}

function getvehicles1()
{
	var city_id = document.getElementById("st_city").value;
	var cit_id = city_id.split('-');
	cit_id = cit_id[0].trim();
	
	var inc=$('#vehdiv').val();
	$('.loader_ax').fadeIn();
	$.get('<?php echo $_SESSION['grp'].'/ref_vehicl.php' ?>', { city_id: cit_id, incr : inc }, function(data) {
		$('.loader_ax').fadeOut(500);
	//alert(data);
	  $('#divs1'+veh_cnt).html(data);
	  $('.chosen-select').chosen({ 'width':'100%'});
	});
}

function remove_elmt(l)
{ 
	//veh_cnt--;
	var res = l.split("delete");
	if (res[1] == veh_cnt)
	{
		veh_cnt--;
	}
	document.getElementById('vehdiv').value=veh_cnt;
	document.getElementById(l).remove();
	
	seatinfo();
}
	 
var veh_cnt=0;
function create_elmt()
{
	veh_cnt++;
	document.getElementById('vehdiv').value=veh_cnt;
	var sel_claus = "<div class='form-group' id='delete"+veh_cnt+"'><div class='row'><div class='col-sm-12' style='margin-left:15px;'><div class='col-sm-1'></div><label class='col-sm-3 control-label'>Select Extra Vehicle</label><div class='col-sm-6' id='divs1"+veh_cnt+"'></div><div class='col-sm-2'><a title='Remove row' class='btn btn-default' onclick=remove_elmt('delete"+veh_cnt+"')><i class='fa fa-trash-o' style='color:#3EAFDB'></i></a></div><small class='help-block' id='seaterr"+veh_cnt+"' style='display:none; color:#E9573F;'></small></div></div></div>";

	var div1 = document.createElement('div');
	div1.innerHTML = sel_claus;
	//div1.id="divs1["+veh_cnt+"]";
	document.getElementById('vehlist').appendChild(div1);	
}

function showadd(t)
{
	$('#addrow').show();
}

function seatinfo()
{
	var trave_cnt = $('#np .dp-numberPicker-input').val();
	var seat_cnt=0; var tot_seats=0;
	var chosen_city = $("#st_city").val();
	
	if (chosen_city != '')
	{
		for (z=0;z<=veh_cnt;z++)
		{
			var getvehinfo = $("#st_vehic"+z).val();
			if (typeof(getvehinfo) != "undefined" && getvehinfo !== null)
			{
				if (getvehinfo != '')
				{
					var res = getvehinfo.split("-");
					seat_cnt = res[1];
					tot_seats = tot_seats + parseInt(seat_cnt);
				}
			}
		}
		
		//alert (tot_seats);
		if (tot_seats < trave_cnt)
		{
			for (x=0;x<=veh_cnt;x++)
			{

				$('#seaterr'+x).text("Travellers count exceeds vehicle capacity.").show();
			}
		}
		else 
		{
			for (z1=0;z1<=veh_cnt;z1++)
			{
				var geterrinfo = $("#seaterr"+z1).val();
				if (typeof(geterrinfo) != "undefined" && getvehinfo !== null)
				{
					if ($("#seaterr"+z1).show())
					{
						$("#seaterr"+z1).hide();
					}
				}
			}
		}
	}
}

function getvehids()
{
	var vehidarr='';
	for (var h=0;h<=veh_cnt;h++)
	{
		var getvehinfo = $("#st_vehic"+h).val();
		if (typeof(getvehinfo) != "undefined" && getvehinfo !== null)
		{
			if (getvehinfo != '')
			{
				var res = getvehinfo.split("-");
				vehidarr+=','+res[0];
			}
		}
	}
	return vehidarr;
}

function showbook()
{
	if ($('.book_opt').is(':checked')) 
	{
		var var_city = $('#st_city option:selected').html().split('-');
		if (var_city[0] != '')
		{
			get_cities1();
			loading_cityrow();
			$("#start_city00").val(var_city[0].trim());
			//$("input[name='start_city[][0]']").val(var_city[0]);
			$("#book_det").show();
			$("#daycnt").text(parseInt(day_cnt) + 1);
			$("#row_line").show();
		}
	}
}
function delrow()
{
	for (z2=1;z2<=veh_cnt;z2++)
	{
		document.getElementById('delete'+z2).remove();
	}
}

function qtyplus()
{
	//alert($('#daydiv').val());
	//x = $("input[name='start_city[]']").val();
	//alert (x);
	//alert(document.getElementsByName("start_city[]")[0].value);
	var bookdays = parseInt($("#daydiv").val()) + 1;
	var plandays = parseInt($("#nn .dp-numberPicker-input").val());
	if (bookdays >= plandays)
	{
		alert('Your planned travel is for '+plandays+' day(s)');
		return false;
	}
	newfromto1();
}

var day_cnt=0;
var city_cnt=0;


function newfromto1()  
{
	var dy,cty;
	cty=0;
	dy=$('#daydiv').val();

	var check_empty = '';
	var dyb=$('#d'+dy).val();
	var ctz=$('#c'+dy).val();

	for(var t1=0;t1<=dyb;t1++)
	{
		for(var s1=0;s1<=ctz;s1++)
		{
			if ($('#row_city'+t1+s1).val() == '')
			{
				check_empty = 'Y';
			}
		}
	}
	
	if (check_empty == '')
	{
		dy++;
		
		new_fromto = "<div class='form-group' id='labdiv"+dy+"'><div class='row'><label class='control-label col-sm-3'>Enter details for booking: DAY <label id='daycnt"+dy+cty+"'></label></label><div class='col-sm-9'></div></div></div><div class='form-group' id='div"+dy+"'><div class='row'><label class='control-label col-sm-1'>Travel Date &nbsp;&nbsp;</label><div class='col-sm-2'><input type='text' class='form-control datepicker' data-date-format='yyyy-mm-dd' placeholder='yyyy-mm-dd' name='start_date[]' id='start_date"+dy+cty+"' readonly='readonly'></div><div><label class='col-sm-1 control-label'>From: &nbsp;&nbsp;</label><div class='col-sm-2'><input class='form-control bold-border' type='text' name='start_city[]' id='start_city"+dy+cty+"' readonly='readonly'></div><label class='control-label col-sm-1'>To: &nbsp;&nbsp;</label><div class='col-sm-3' id='load_cityrow"+dy+cty+"'></div></div><div class='col-sm-2'><div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'><i class='fa fa-cog'></i> Action <span class='caret'></span></button><ul class='dropdown-menu' role='menu'><li><a id='"+dy+"' href='javascript:void(0);' onclick='newfromto(this.id);loading_cityrow();'>Add Row</a></li><li><a href='javascript:void(0);'>Book Hotel</a></li><li><a href='javascript:void(0);' onclick='show_roadmap();show_flightmap();'>Show Map</a></li><li><a href='javascript:void(0);' onclick='remfromto(this.id)' id='"+dy+"'>Remove Last</a></li></ul></div></div></div><input type='hidden' id='d"+dy+"' value='"+dy+"' /><input type='hidden' id='c"+dy+"' value='0' /></div>";
		
		
		$('#daydiv').val(dy);
		dy--;
		$(new_fromto).insertAfter('#div'+dy);
		
		dayrec = dy + 1;
		$("#daycnt"+dayrec+cty).text(parseInt(dayrec) + 1);
		
		var gethid = $('#c'+dy).val();
		var tocity_val = $('#row_city'+dy+gethid+' option:selected').text().split('-');
		$("#start_city"+dayrec+"0").val(tocity_val[0].trim());
		
		var incdy = dy+1;
		get_cities2(incdy,cty);
	}
	else
	{
		alert ('Select '+'TO'+' location');
	}
	
	
	$('.datepicker').datepicker('#datepicker1');
	/*var nowDate = new Date();
	var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
	$('#start_date'+dy+cty).datepicker({ 
		"startDate": today 
	});*/
   
}

//Remove last day
function qtyminus()
{
	var dcy;
	dcy=$('#daydiv').val();
	if(dcy!=0)
	{
		$('#labdiv'+dcy).remove();
		$('#div'+dcy).remove();
		dcy--;
		$('#daydiv').val(dcy);
	}
	else
	{
		alert('Cannot remove default row');
	}
	
}

	//$('.datepickerz').click(function(res){alert('date')});
	
	



</script>        
	</body>
    
</html>