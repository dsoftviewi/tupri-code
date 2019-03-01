<?php

require_once("../dompdf_config.inc.php");

$html =
 <<<EOD
 
 
<div style="width:950px; height:650px; background-image:url(../Certificate/images/bg.png); margin:auto; 
 border-style:inset; border-width:20px; border-bottom-color:#000; border-left-color:#000;">
<div style="border-style:solid; margin:10px 10px 10px 10px;height:620px;">

<div style="font-family:'robotoregular';font-size:24px; text-align:center; padding-top:5px;">
ELYSIUM TECHNOLOGIES PRIVATE LIMITED
</div>
<div style="background-image:url(../Certificate/images/STAR.png); background-position:center; background-repeat:no-repeat; height:25px;">
</div>
<div style="font-family:'times-roman ';font-weight:bold; font-size:48px; text-align:center;">
CERTIFICATE
</div>
<div style="background-image:url(../Certificate/images/of.png); background-position:center; background-repeat:no-repeat; height:25px; padding-bottom:15px;" >
</div>
<div style="background-image:url(../Certificate/images/red.png); background-position:center; background-repeat:no-repeat; height:50px;
font-family:Arial, Helvetica, sans-serif; font-size:44px; color:#FFF; text-align:center; padding-top:5px;"> 
EXAM BOOKING
</div>
<div style="font-family:'sonoma_scriptregular'; font-size:22px; text-align:center;">
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
</div>
<div style="font-family:'robotoregular'; font-size:18px; text-align:left; margin-left:20px; margin-top:30px; float:left;">
Exam Code:123456<br />
Certificate ID:654321
</div>
<div style="float:left; margin-left:350px;">
<img src="../Certificate/images/exam.png" />
</div>
<div style="font-family:'robotoregular'; font-size:18px; text-align:right; margin-right:20px;">
<div  style="margin-left:115px;">
<img src="../Certificate/images/sig1.png"  / >
</div>
<div style="margin-right:25px;">
Issued by
</div>
</div>
</div>

</div>

EOD;



  $dompdf = new DOMPDF();
  $dompdf->load_html($html);
  $paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper($paper_size,'landscape');
   
 
  $dompdf->render();

  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

 


?>






