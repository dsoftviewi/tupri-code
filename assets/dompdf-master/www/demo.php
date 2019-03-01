<?php

require_once("../dompdf_config.inc.php");

// We check wether the user is accessing the demo locally
$local = array("::1", "127.0.0.1");
$is_local = in_array($_SERVER['REMOTE_ADDR'], $local);

if ( isset( $_POST["html"] ) && $is_local ) {

  if ( get_magic_quotes_gpc() )
    $_POST["html"] = stripslashes($_POST["html"]);
  
  $dompdf = new DOMPDF();
  $dompdf->load_html($_POST["html"]);
  $dompdf->set_paper($_POST["paper"], $_POST["orientation"]);
  $dompdf->render();

  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

  exit(0);
}

?>
<?php include("head.inc"); ?>

<a name="demo"> </a>
<h2>Demo</h2>

<?php if ($is_local) { ?>

<p>Enter your html snippet in the text box below to see it rendered as a
PDF: (Note by default, remote stylesheets, images &amp; inline PHP are disabled.)</p>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
<p>Paper size and orientation:
<select name="paper">
<?php
foreach ( array_keys(CPDF_Adapter::$PAPER_SIZES) as $size )
  echo "<option ". ($size == "letter" ? "selected " : "" ) . "value=\"$size\">$size</option>\n";
?>
</select>
<select name="orientation">
  <option value="portrait">portrait</option>
  <option value="landscape">landscape</option>
</select>
</p>

<textarea name="html" cols="60" rows="20">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Certificate</title>
</head>


<body>


<div style="width:950px; height:550px; background-image:url(../Certificate/images/bg.png); margin:auto; 
 border-style:inset; border-width:20px; border-bottom-color:#000; border-left-color:#000;">

<div style="border-style:solid; margin:10px 10px 10px 10px;height:520px;">

<div style="font-family:'robotoregular';
 font-size:24px; text-align:center; padding-top:5px;">
ELYSIUM TECHNOLOGIES PRIVATE LIMITED
</div>

<div style="background-image:url(../Certificate/images/STAR.png); background-position:center; background-repeat:no-repeat; height:25px;">

</div>

<div style="font-family:'Lucida Console', Monaco, monospace; font-size:48px; text-align:center;">
CERTIFICATE

</div>

<div style="background-image:url(../Certificate/images/of.png); background-position:center; background-repeat:no-repeat; height:25px; padding-bottom:15px;" >

</div>

<div style="background-image:url(../Certificate/images/red.png); background-position:center; background-repeat:no-repeat; height:50px;
font-family:Arial, Helvetica, sans-serif; font-size:44px; color:#FFF; text-align:center; padding-top:5px;"> 

EXAM BOOKING

</div>

<div style="font-family:'sonoma_scriptregular'; font-size:22px; text-align:center; padding-top:5px;">
Present to
</div>

<div style="font-family:'robotoregular'; font-size:55px; text-align:center" >
PERUMAL SAMY S
</div>

<div style="font-family:Segoe UI Symbol; font-size:30px; text-align:center;">  
as a winer in balapan kerupuk eontest
</div>



<div style="font-family:'sonoma_scriptregular'; font-size:20px; width:550px; text-align:center; margin-right:200px;
padding-bottom:5px; margin-left:200px;">

It has a rule based optimizer for optimizing logical plans. 
Supports partitioning of data at the level of tables to improve performance. 
</div>


<div style="font-family:'robotoregular'; font-size:18px; text-align:left; margin-left:20px; margin-top:30px; float:left;">
Exam Code:123456<br />
Certificate ID:654321
</div>


<div style="float:left; margin-left:210px; padding-top:20px;">
<img src="images/exam.png" />

</div>



<div style="font-family:'robotoregular'; font-size:18px; text-align:right; margin-right:20px; margin-top:18px;">

<div  style="margin-left:115px;">

<img src="../Certificate/images/sig1.png"  / >
</div>
<div style="margin-right:25px;">
Issued by
</div>
</div>






</div>



</div>


</body>
</html>




</textarea>

<div style="text-align: center; margin-top: 1em;">
  <button type="submit">Download</button>
</div>

</form>
<p style="font-size: 0.65em; text-align: center;">(Note: if you use a KHTML
based browser and are having difficulties loading the sample output, try
saving it to a file first.)</p>

<?php } else { ?>

  <p style="color: red;">
    User input has been disabled for remote connections.
  </p>
  
<?php } ?>

<?php include("foot.inc"); ?>