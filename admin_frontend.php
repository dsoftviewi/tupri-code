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
		<title>DVI Holidays | Frontend Pro</title>
		<!-- BOOTSTRAP CSS (REQUIRED ALL PAGE)-->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- PLUGINS CSS -->
		<link href="core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		<link href="core/assets/plugins/toastr/toastr.css" rel="stylesheet">
        <link href="core/assets/plugins/swal/sweet-alert.css" rel="stylesheet" type="text/css"/>
        <link href="core/assets/plugins/spinner/css/jquery.dpNumberPicker-holoLight-1.0.1-min.css" rel="stylesheet">
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="core/assets/plugins/summernote/summernote.min.css" rel="stylesheet">
		<link href="core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="core/assets/css/style.css" rel="stylesheet">
		<link href="core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="core/assets/plugins/Tags/jquery.tagsinput.css" />
         <link href="core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
          <link rel="shortcut icon" href="images/logo2.png" type="image/x-icon">
          
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
			opacity:0.8;
			background: url(images/arrow_loader.gif) center no-repeat #fff;
			background-size:200px;
		}	
	</style>
	</head>
 <body class="tooltips">
			          
			<div class="wrapper">
            
			<?php include("core/topbar.php");?>
            <div id="dvLoading"></div>
			<?php include("core/sidebar.php");?>
          <div class="page-content">

			<!-- BEGIN PAGE CONTENT -->
            <?php include($_SESSION['grp']."/front_end.php");?>
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
    	<script src="core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
    	<script src="core/assets/plugins/summernote/summernote.min.js"></script>
        <script type="text/javascript">
		$('.tooltips').tooltip();
    $(document).ready(function() 
	{
		var w,h,pval;
        w = screen.height;
        h =screen.width;
		
		 $('.show_plan').fancybox({
			width: w/0.7,
			height: h/0.8,
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
			//parent.location.reload();
			},
		});
		
		$('.show_rep').fancybox({
			width: w/0.8,
			height: h/0.8,
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
			//parent.location.reload();
			},
		});
		
		 $('.show_pdf').fancybox({
			width: w/0.8,
			height: h/0.8,
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
			//parent.location.reload();
			},
		}); 
		
		
		
		});
    
	
	function display_change(cc)
	{
		$('#view_details_'+cc).hide();
		$('#change_btn_'+cc).hide();
		$('#editable_'+cc).show();
	}
	
	function cancel_contact(vv)
	{
		$('#view_details_'+vv).show();
		$('#change_btn_'+vv).show();
		$('#editable_'+vv).hide();
	}
    </script>
		<!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
		<script src="core/assets/js/bootstrap.min.js"></script>
		<script src="core/assets/plugins/retina/retina.min.js"></script>
		<script src="core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="core/assets/plugins/Tags/jquery.tagsinput.js"></script>
		<script src="core/assets/plugins/prettify/prettify.js"></script>
        <script src="core/assets/plugins/swal/sweet-alert.js"></script>
		<script src="core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<!--<script src="core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="core/assets/plugins/markdown/markdown.js"></script>
		<script src="core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="core/assets/plugins/slider/bootstrap-slider.js"></script>-->
		<script src="core/assets/plugins/toastr/toastr.js"></script>
        <script src="core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="core/assets/plugins/spinner/js/jquery.dpNumberPicker-1.0.1-min.js"></script>
      
		<!-- MAIN APPS JS -->
		<script src="core/assets/js/apps.js"></script>
		<script src="core/assets/js/demo-panel-1.js"></script>
        <script src="core/assets/js/moment.js"></script>
        
  <script src="core/assets/jquery.bulletin.js"></script>    
  <script>
   $(function() { $('#bulletin').bulletin(); });
   $(window).load(function(){  $('#dvLoading').fadeOut(500);  });
  </script>
        
		<script>
		$(document).ready(function(e) {
			$('.datatable-example').dataTable(
			 {
 				 "bSort": false
			});
        });
		
		//window.onload = get_cities;
		
		$(".div-nicescroller").niceScroll({
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

	});

</script>

<?php if((isset($_GET['tost'])) && ($_GET['tost']==1)){?>
    
    $(document).ready(function() {
      toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          }
      toastr.info('Itinerary plan sent successfully for approval with Plan id:<?php echo $_GET['id'] ?>');
            });
     
<?php } ?>
        
	</body>
    
</html>