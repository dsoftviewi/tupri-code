

<style>
  #slider {
    margin:0px auto;
    padding:0px;
  height:20px;
  overflow:hidden;
  }
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<?php 
include("core/session.php");
if (!isset($_SESSION['uid']))
{
include ("header.php"); include ("slider.php");
?>
<?php
}
else
{
	header("Location: ".$_SESSION['setmmsm']);
}
?>
<script>
function show_welcome()
{
	document.getElementById('show_welcome').style.display='none';
		document.getElementById('hide_welcome').style.display='block';
			document.getElementById('wel_desc_short').style.display='none';
				document.getElementById('wel_desc_detailed').style.display='block';
}

function hide_welcome()
{
	document.getElementById('show_welcome').style.display='block';
		document.getElementById('hide_welcome').style.display='none';
			document.getElementById('wel_desc_short').style.display='block';
				document.getElementById('wel_desc_detailed').style.display='none';
}

function show_feature()
{
	document.getElementById('show_feature').style.display='none';
		document.getElementById('hide_feature').style.display='block';
			document.getElementById('feat_desc_short').style.display='none';
				document.getElementById('feat_desc_detailed').style.display='block';
}

function hide_feature()
{
	document.getElementById('show_feature').style.display='block';
		document.getElementById('hide_feature').style.display='none';
			document.getElementById('feat_desc_short').style.display='block';
				document.getElementById('feat_desc_detailed').style.display='none';
}
</script>