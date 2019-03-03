<?php include("core/session.php");?>
<?php	if($_SESSION['grp'] == 'ADMIN'){
	header('location:dashboard.php');
}          ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta name="keywords" content="DVI Holidays, Tour website" />
        <meta name="description" content="DVI Holidays">
        <meta name="author" content="DVI Holidays">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>DVI Holidays</title>
		<!-- BOOTSTRAP CSS (REQUIRED ALL PAGE)-->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- PLUGINS CSS -->
<!--		<link href="core/assets/plugins/weather-icon/css/weather-icons.min.css" rel="stylesheet">-->
		<link href="core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="core/assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
		<link href="core/assets/plugins/owl-carousel/owl.theme.min.css" rel="stylesheet">
		<link href="core/assets/plugins/owl-carousel/owl.transitions.min.css" rel="stylesheet">
		<link href="core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<!--<link href="core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="core/assets/plugins/summernote/summernote.min.css" rel="stylesheet">
		<link href="core/assets/plugins/markdown/bootstrap-markdown.min.css" rel="stylesheet">-->
		<link href="core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="core/assets/plugins/morris-chart/morris.min.css" rel="stylesheet">
		<link href="core/assets/plugins/c3-chart/c3.min.css" rel="stylesheet">   
		<link href="core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="core/assets/plugins/toastr/toastr.css" rel="stylesheet">
        <link rel="shortcut icon" href="images/logo2.png" type="image/x-icon">
		<!--<link href="core/assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet">
		<link href="core/assets/plugins/fullcalendar/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print">-->
         <link href="core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
     
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="core/assets/css/style.css" rel="stylesheet">
		<link href="core/assets/css/style-responsive.css" rel="stylesheet">
        <link href="core/assets/bulletin.css" rel="stylesheet"><!-- news scroller -->
        
		<script src="core/assets/js/jquery.min.js"></script>
          
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
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
            
			<?php include("core/topbar_maintain.php");?>
            <div id="dvLoading"></div>
              <div class="loader_ax" style="display: none;"></div>
			<?php //include("core/sidebar.php");?>
           
			<!-- BEGIN PAGE CONTENT -->
            <?php include("maintain.php");?>
			<!-- /.page-content -->
          
            	<?php //include("core/news_scroller.php");?>					
		</div>
        <!-- /.wrapper -->
		<!-- END PAGE CONTENT -->
		<?php //include("core/footer.php");?>
		<!-- BEGIN BACK TO TOP BUTTON -->
		<div id="back-top">
			<a href="#top"><i class="fa fa-chevron-up"></i></a>
		</div>
		<!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
        <!--<script src="core/assets/plugins/fancybox/lib/jquery-1.8.2.min.js"></script> 
    	<script src="core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>-->
        
                                       
        <script src="core/assets/plugins/fancybox/lib/jquery-1.8.2.min.js"></script>
        <link href="core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
    	<script src="core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
        <link rel="stylesheet" type="text/css" href="core/assets/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
		<script type="text/javascript" src="core/assets/plugins/fancybox/source//helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
     	<script type="text/javascript" src="core/assets/plugins/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>

        
		<script src="core/assets/js/bootstrap.min.js"></script>
		<script src="core/assets/plugins/retina/retina.min.js"></script>
		<script src="core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
	
		<script src="core/assets/plugins/prettify/prettify.js"></script>
		<script src="core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="core/assets/plugins/icheck/icheck.min.js"></script>
        <script src="core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		
		<script src="core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		
		<script src="core/assets/plugins/slider/bootstrap-slider.js"></script>
		<script src="core/assets/plugins/toastr/toastr.js"></script>
        
   
		<!-- EASY PIE CHART JS -->
		<!--<script src="core/assets/plugins/easypie-chart/easypiechart.min.js"></script>
		<script src="core/assets/plugins/easypie-chart/jquery.easypiechart.min.js"></script>
	
		<script src="core/assets/plugins/jquery-knob/jquery.knob.js"></script>
		<script src="core/assets/plugins/jquery-knob/knob.js"></script>-->
		<!-- FLOT CHART JS -->
		<!--<script src="core/assets/plugins/flot-chart/jquery.flot.js"></script>
		<script src="core/assets/plugins/flot-chart/jquery.flot.tooltip.js"></script>
		<script src="core/assets/plugins/flot-chart/jquery.flot.resize.js"></script>
		<script src="core/assets/plugins/flot-chart/jquery.flot.selection.js"></script>
		<script src="core/assets/plugins/flot-chart/jquery.flot.stack.js"></script>
		<script src="core/assets/plugins/flot-chart/jquery.flot.time.js"></script>-->
		<!-- MORRIS JS -->
		<script src="core/assets/plugins/morris-chart/raphael.min.js"></script>
		<script src="core/assets/plugins/morris-chart/morris.min.js"></script>
		<!-- C3 JS -->
		<!--<script src="core/assets/plugins/c3-chart/d3.v3.min.js" charset="utf-8"></script>
		<script src="core/assets/plugins/c3-chart/c3.min.js"></script>-->
		<!-- MAIN APPS JS -->
		<script src="core/assets/js/apps.js"></script>
		<script src="core/assets/js/demo-panel-1.js"></script>
  
  <script src="core/assets/jquery.bulletin.js"></script>    
  <script>
   $(function() {
			$('#bulletin').bulletin();
		});
   </script>
   
<script>
$(window).load(function(){
	$('#dvLoading').fadeOut(500);
	$('.datatable-example').dataTable();
});
/*$(window).bind("load", function() {
    $('#dvLoading').fadeOut(slow);
});*/

$(document).ready(function(e) {
    
var w,h,pval;
        w = screen.height;
        h =screen.width;

 $('.show_hotss').fancybox({
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
		
		$('.add_host4').fancybox({
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
		
		

    $('#example1').datepicker({
        format: "yyyy-mm-dd"
    });

    $('.dp').on('changeDate', function () {
        $('.datepicker').hide();
		
		var datt=$('.dp').val();
		$('#cdate').val(datt);
		$('#tdate').empty().prepend(datt);
		$.get('<?php echo $_SESSION['grp']; ?>/ajax_log.php?type=2&datt='+datt,function(result){
		$('#log_table').empty().html(result);
		$('#example1').datepicker({format: "yyyy-mm-dd"});
		$('.datatable-example').dataTable().fnDestroy();
		$('.datatable-example').dataTable();
		});
    });



});



</script>	
   

        <script>
new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'morris-widget-22',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
				<?php for ($z1=0;$z1<count($all_years);$z1++)
				{?>
					{ year: '<?php echo $all_years[$z1]; ?>', value: <?php echo $yearcoll[$z1]; ?> },
				<?php } ?> ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Rs. ']
});
   </script>
   
 
       
	</body>
    
</html>

