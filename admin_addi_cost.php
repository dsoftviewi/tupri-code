<?php include("core/session.php");?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta name="keywords" content="DVI Holidays, Tour website" />
        <meta name="description" content="DVI Holidays">
        <meta name="author" content="DVI Holidays">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>DVI Holidays | Additional Cost</title>
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
        <link rel="shortcut icon" href="images/logo2.png" type="image/x-icon">
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="core/assets/css/style.css" rel="stylesheet">
		<link href="core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="core/assets/plugins/Tags/jquery.tagsinput.css" />
        
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

		
		
        .loader_ax{
position: fixed;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
z-index: 9999;
background: url('images/ajax_loader.gif') center no-repeat ;
background-size:120px;
background-color:rgba(0, 0, 0, 0.5);
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
            <?php include($_SESSION['grp']."/additional_cost.php");?>
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
       
		
        var w = screen.height;
            var h =screen.width;
			
			
			 $('.view_season').fancybox({
	  width: w/1,
		height: h/3.452,
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
		
		 $('.update_hotel').fancybox({
	  width: w/1,
		height: h/2.452,
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
    parent.location.reload();
  },
		}); 
			
			
			
		//this is for excel upload
    $('.add_vehi').fancybox({
	  width: w/1,
		height: h/3.252,
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
    parent.location.reload();
  },
		}); 
		
		//this is for form entry
		 $('.add_hotelform').fancybox({
	  width: w/0.8,
		height: h/2.3,
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
    parent.location.reload();
	
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
		<script src="core/assets/plugins/skycons/skycons.js"></script>
		<script src="core/assets/plugins/prettify/prettify.js"></script>
		<script src="core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="core/assets/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<!--<script src="core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="core/assets/plugins/markdown/markdown.js"></script>
		<script src="core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="core/assets/plugins/slider/bootstrap-slider.js"></script>-->
		<script src="core/assets/plugins/toastr/toastr.js"></script>
         <script src="core/assets/jQuery1/form-validator/jquery.form-validator.js"></script>
		
		<!-- MAIN APPS JS -->
		<script src="core/assets/js/apps.js"></script>
		<script src="core/assets/js/demo-panel-1.js"></script>
        
 <script src="core/assets/jquery.bulletin.js"></script>    
<script>
$(function() { $('#bulletin').bulletin(); });

$(window).load(function(){  $('#dvLoading').fadeOut(500);  });
</script>
       
		<script>
		
		
		
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


		$(document).ready(function(e) {
				$('.datatable-example').dataTable();
				$('.tagname').tagsInput({width:'auto'});
        });
		
		
		$('.datepicker_ac').on('changeDate', function(ev){
    			$(this).datepicker('hide');
			});
		
		
<?php if((isset($_GET['tost'])) && ($_GET['tost']==md5(2))){?>
    
    $(document).ready(function() {
      toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          }
      toastr.info('<?php echo $_GET['rec'];?> records are uploaded Successfully..!');
            });
     
<?php } ?>		
<?php if((isset($_GET['tost'])) && ($_GET['tost']==md5(1))){?>
	 $(document).ready(function() {
      toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          }
      toastr.<?php echo $_GET['clr'];?>('<?php echo $_GET['rec']?>');
            });
<?php }?>

		</script>
	</body>
    
</html>

