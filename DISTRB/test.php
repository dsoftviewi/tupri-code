<?php
require_once('../Connections/divdb.php');
session_start();

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date("Y-m-d");

//finding hotel
if(isset($_GET['type']) && $_GET['type']==1)
{ 
$year=$_GET['year'];
// for finding all itinerary
$mst = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=?  and sub_paln_id!='' and distr_id=?");
$mst->execute(array($year,$_SESSION['uid']));
$row_mst= $mst->fetch(PDO::FETCH_ASSOC);
$tot_mst=$mst->rowCount();

// for finding admin approved itinerary
$mst1 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=?  and sub_paln_id!='' and status='0' and distr_id=? ");
$mst1->execute(array($year,$_SESSION['uid']));
$row_mst1= $mst1->fetch(PDO::FETCH_ASSOC);
$tot_mst1=$mst1->rowCount();

// for finding admin approved itinerary
 $mst_gt = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=?  and sub_paln_id!='' and status='0' and distr_id=? ");
$mst_gt->execute(array($year,$_SESSION['uid']));
//$row_mst_gt= mysql_fetch_assoc($mst_gt);
$row_mst_gt_main=$mst_gt->fetchAll();
$tot_mst_gt=$mst_gt->rowCount();

						
						$yprof = $conn->prepare("SELECT agnt_adm_perc, grand_tot, SUM((agnt_adm_perc / 100) * grand_tot) as prof_tot FROM travel_master t where SUBSTR(t.date_of_reg,1,4) =? and t.status = 0 and t.distr_id=?");
						$yprof->execute(array($year,$_SESSION['uid']));
						$row_yprof = $yprof->fetch(PDO::FETCH_ASSOC);
						$totalRows_yprof =$yprof->rowCount();

$totel_grand=0;
$agn_tott=0;
$div_prof=0;
if($tot_mst_gt>0)
{
	foreach($row_mst_gt_main as $row_mst_gt)
	{
    $sub_plan_arr=explode('-',$row_mst_gt['sub_paln_id']);
        //print_r($sub_plan_arr);
        foreach($sub_plan_arr as $splanid) 
        {
                // for finding admin approved itinerary
                $mst_gt_sub = $conn->prepare("SELECT * FROM  travel_master where plan_id=?");
                $mst_gt_sub->execute(array($splanid));
                $row_mst_gt_sub= $mst_gt_sub->fetch(PDO::FETCH_ASSOC);
                $tot_mst_gt_sub= $mst_gt_sub->rowCount();
		//$totel_grand=$totel_grand+($row_mst_gt['grand_tot']+($row_mst_gt['grand_tot']*($row_mst_gt['agnt_adm_perc']/100)));
		$div_prof=$div_prof+($row_mst_gt_sub['agnt_grand_tot']-($row_mst_gt_sub['grand_tot']+($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100))));
		$totel_grand=$totel_grand+($row_mst_gt_sub['agnt_grand_tot']-($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100)));
	     } //for each end 
  }
}
 

// for finding admin rejected itinerary 
$mst2 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and status='1' and distr_id=?");
$mst2->execute(array($year,$_SESSION['uid']));
$row_mst2= $mst2->fetch(PDO::FETCH_ASSOC);
$tot_mst2=$mst2->rowCount();

// for finding agent approved itinerary 
$mst3 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and status='2' and distr_id=?");
$mst3->execute(array($year,$_SESSION['uid']));
$row_mst3= $mst3->fetch(PDO::FETCH_ASSOC);
$tot_mst3=$mst3->rowCount();


// for finding agent rejected itinerary 
$mst4 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and status='3' and distr_id=?");
$mst4->execute(array($year,$_SESSION['uid']));
$row_mst4= $mst4->fetch(PDO::FETCH_ASSOC);
$tot_mst4=$mst4->rowCount();


if($tot_mst>0){
?>
											<div style="background-color:#F7F8FF; margin-left:20px; margin-bottom:20px;">
                                            <table width="100%">
                                            <tr  height="30px" style="background-color:#33A8D3; color:#FFFFFF; font-size:16px; font-weight:600"><td  class="padclass" colspan="3"><center>Report of <?php echo $year; ?></center></td></tr>
                                     <tr><td class="padclass " width="40%"><strong  style="color:#1F4979;">Number of Itinerary</strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst." &nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Approved by Admin</strong></td>
                                           <td width="10%">:</td> <td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst1."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Rejected by Admin</strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst2."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Total Collection </strong></td>
                                            <td width="10%">:</td><td class="padclass" ><strong style="color:#1F4979;"><?php echo round($totel_grand)."&nbsp;&nbsp; Rupees"; ?></strong> </td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Profit to DVi </strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979; "><?php echo round($div_prof)."&nbsp;&nbsp; Rupees"; ?></strong></td></tr>
                                            </table>
                                            </div>
                                            
                                            <div style="background-color:#F7F8FF; margin-left:20px; margin-bottom:20px;">
                                            <table width="100%">
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Approved by Agent</strong></td>
                                           <td width="10%">:</td> <td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst3+$tot_mst1."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Rejected by Agent</strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst4."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            </table>
                                            </div>
                                            
                                            <!-- Month vis report-->
                                            
                                            <div style="background-color:#F9F9F9; margin-left:20px; margin-bottom:20px;">
                                            <table width="100%">
                                            <tr  height="30px" style="background-color:#5F779D; color:#FFFFFF; font-size:16px; font-weight:600"><td  class="padclass" colspan="8"><center>Month-wise report of <?php echo $year; ?></center></td></tr>
                                            <tr><td class="padclass"><strong style="color:#1F4979;">Month</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Number of Itinerary</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Approved by Admin</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Rejected by Admin</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Approved by Agent</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Rejected by Agent</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Profit Amount (Rs.)</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Total Collection(Rs.)</strong></td></tr>
        <?php 
		for ($m=1; $m<=12; $m++) {
     	$month = date('F', mktime(0,0,0,$m, 1, date('Y')));
	 	$num_mon = date('m', mktime(0,0,0,$m, 1, date('Y')));
		
		
$mon=$num_mon;
// for finding all itinerary
$mst = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and distr_id=?");
$mst->execute(array($year,$mon,$_SESSION['uid']));
$row_mst= $mst->fetch(PDO::FETCH_ASSOC);
$tot_mst=$mst->rowCount();

// for finding admin approved itinerary
$mst1 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and distr_id=?");
$mst1->execute(array($year,$mon,$_SESSION['uid']));
$row_mst1= $mst1->fetch(PDO::FETCH_ASSOC);
$tot_mst1=$mst1->rowCount();

// for finding admin approved itinerary
 $mst_gt = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=?  and status='0' and distr_id=?");
$mst_gt->execute(array($year,$mon,$_SESSION['uid']));
//$row_mst_gt= mysql_fetch_assoc($mst_gt);
$row_mst_gt_main=$mst_gt->fetchAll();
$tot_mst_gt=$mst_gt->rowCount();

$totel_grand=0;
$agn_tott=0;
$div_prof=0;

	
						$yprof = $conn->prepare("SELECT agnt_adm_perc, grand_tot, SUM((agnt_adm_perc / 100) * grand_tot) as prof_tot FROM travel_master t where SUBSTR(t.date_of_reg,1,4) = ? and SUBSTR(t.date_of_reg,6,2) = ? and t.status = 0 and t.distr_id=?");
						$yprof->execute(array($year,$mon,$_SESSION['uid']));
						$row_yprof = $yprof->fetch(PDO::FETCH_ASSOC);
						$totalRows_yprof =$yprof->rowCount();

if($tot_mst_gt>0)
{
	foreach($row_mst_gt_main as $row_mst_gt)
	{
    $sub_plan_arr=explode('-',$row_mst_gt['sub_paln_id']);
        //print_r($sub_plan_arr);
        foreach($sub_plan_arr as $splanid) 
        {
                // for finding admin approved itinerary
                $mst_gt_sub = $conn->prepare("SELECT * FROM  travel_master where plan_id=?");
                $mst_gt_sub->execute(array($splanid));
                $row_mst_gt_sub= $mst_gt_sub->fetch(PDO::FETCH_ASSOC);
                $tot_mst_gt_sub=$mst_gt_sub->rowCount();
		//$totel_grand=$totel_grand+($row_mst_gt['grand_tot']+($row_mst_gt['grand_tot']*($row_mst_gt['agnt_adm_perc']/100)));
		$div_prof=$div_prof+($row_mst_gt_sub['agnt_grand_tot']-($row_mst_gt_sub['grand_tot']+($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100))));
		$totel_grand=$totel_grand+($row_mst_gt_sub['agnt_grand_tot']-($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100)));
      	}//for end
  }
}

// for finding admin rejected itinerary 
$mst2 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=?  and status='1' and distr_id=?");
$mst2->execute(array($year,$mon,$_SESSION['uid']));
$row_mst2= $mst2->fetch(PDO::FETCH_ASSOC);
$tot_mst2=$mst2->rowCount();

// for finding agent approved itinerary 
$mst3 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=?  and status='2' and distr_id=?");
$mst3->execute(array($year,$mon,$_SESSION['uid']));
$row_mst3= $mst3->fetch(PDO::FETCH_ASSOC);
$tot_mst3=$mst3->rowCount();

// for finding agent rejected itinerary 
$mst4 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=?  and status='3' and distr_id=?");
$mst4->execute(array($year,$mon,$_SESSION['uid']));
$row_mst4= $mst4->fetch(PDO::FETCH_ASSOC);
$tot_mst4=$mst4->rowCount();
	
	 	?>
    <tr><td class="padclass"><strong style="color:#1F4979;"><?php echo $month; ?></strong></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number of Itinerary" ><?php if($tot_mst>0){echo $tot_mst; }else{ echo "-"; } ?></strong></center></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number Of Itinerary Approved By Admin" ><?php if($tot_mst1>0){echo $tot_mst1; }else{ echo  "-"; } ?></strong></center></</td>                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number Of Itinerary Rejected By Admin" ><?php if($tot_mst2>0){ echo $tot_mst2;}else { echo  "-";} ?></strong></center></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number Of Itinerary Approved By Agent" ><?php if($tot_mst3>0){echo $tot_mst3+$tot_mst1; }else {echo "-"; } ?></strong></center></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number Of Itinerary Rejected By Agent" ><?php if($tot_mst4>0){ echo $tot_mst4; }else{ echo "-"; } ?></strong></center></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="<?php echo $month; ?> - Profit Amount (Rupees)" ><?php if($row_yprof['prof_tot']>0){echo round($div_prof); }else{echo "-";} ?></strong></center></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="<?php echo $month; ?> - Total Collection (Rupees)" ><?php if($totel_grand>0){echo round($totel_grand); }else {echo "-";} ?></strong></center></td></tr>
     <?php }?>

                                            </table>
                                            </div>
                                            

<?php 
}else{?>
	<div style="background-color:#F7F8FF; margin-left:20px; margin-bottom:20px;">
                                            <table width="100%">
                 <tr><td class="padclass"  width="100%"><center><strong style="color:#3F4E89">No collection from <?php echo $year; ?></strong></center></td></tr>
                                            </table>
                                            </div>
<?php }
}?>


<?php //finding collection in month vis
if(isset($_GET['type']) && $_GET['type']==2)
{ 
$year=$_GET['year'];
$mon=$_GET['month'];
// for finding all itinerary
$mst = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and distr_id=?");
$mst->execute(array($year,$mon,$_SESSION['uid']));
$row_mst= $mst->fetch(PDO::FETCH_ASSOC);
$tot_mst=$mst->rowCount();

// for finding admin approved itinerary
$mst1 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and distr_id=?");
$mst1->execute(array($year,$mon,$_SESSION['uid']));
$row_mst1= $mst1->fetch(PDO::FETCH_ASSOC);
$tot_mst1=$mst1->rowCount();

// for finding admin approved itinerary
$mst_gt = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and status='0' and distr_id=?");
$mst_gt->execute(array($year,$mon,$_SESSION['uid']));
//$row_mst_gt= mysql_fetch_assoc($mst_gt);
$row_mst_gt_main=$mst_gt->fetchAll();
$tot_mst_gt=$mst_gt->rowCount();

$totel_grand=0;
$agn_tott=0;
$div_prof=0;

						
						$yprof = $conn->prepare("SELECT agnt_adm_perc, grand_tot, SUM((agnt_adm_perc / 100) * grand_tot) as prof_tot FROM travel_master t where SUBSTR(t.date_of_reg,1,4) = ? and SUBSTR(t.date_of_reg,6,2) = ? and t.status = 0 and t.distr_id=?");
						$yprof->execute(array($year,$mon,$_SESSION['uid']));
						$row_yprof = $yprof->fetch(PDO::FETCH_ASSOC);
						$totalRows_yprof = $yprof->rowCount();


if($tot_mst_gt>0)
{
	foreach($row_mst_gt_main as $row_mst_gt)
	{

    $sub_plan_arr=explode('-',$row_mst_gt['sub_paln_id']);
        //print_r($sub_plan_arr);
        foreach($sub_plan_arr as $splanid) 
        {
                // for finding admin approved itinerary
                $mst_gt_sub = $conn->prepare("SELECT * FROM  travel_master where plan_id=?");
                $mst_gt_sub->execute(array($splanid));
                $row_mst_gt_sub= $mst_gt_sub->fetch(PDO::FETCH_ASSOC);
                $tot_mst_gt_sub=$mst_gt_sub->rowCount();
		//$totel_grand=$totel_grand+($row_mst_gt['grand_tot']+($row_mst_gt['grand_tot']*($row_mst_gt['agnt_adm_perc']/100)));
		$div_prof=$div_prof+($row_mst_gt_sub['agnt_grand_tot']-($row_mst_gt_sub['grand_tot']+($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100))));
		$totel_grand=$totel_grand+($row_mst_gt_sub['agnt_grand_tot']-($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100)));
        }//for each end
	}
}
 
// for finding admin rejected itinerary 
$mst2 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=?  and status='1' and distr_id=?");
$mst2->execute(array($year,$mon,$_SESSION['uid']));
$row_mst2= $mst2->fetch(PDO::FETCH_ASSOC);
$tot_mst2=$mst2->rowCount();

// for finding agent approved itinerary 
$mst3 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=?  and status='2' and distr_id=?");
$mst3->execute(array($year,$mon,$_SESSION['uid']));
$row_mst3= $mst3->fetch(PDO::FETCH_ASSOC);
$tot_mst3=$mst3->rowCount();


// for finding agent rejected itinerary 
$mst4 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=?  and status='3' and distr_id=?");
$mst4->execute(array($year,$mon,$_SESSION['uid']));
$row_mst4= $mst4->fetch(PDO::FETCH_ASSOC);
$tot_mst4=$mst4->rowCount();


if($tot_mst>0){
?>
											<div style="background-color:#F7F8FF; margin-left:20px; margin-bottom:20px;">
                                            <table width="100%">
                                            <tr  height="30px" style="background-color:#33A8D3; color:#FFFFFF; font-size:16px; font-weight:600"><td  class="padclass" colspan="3"><center>Report of <?php echo $year." - ".date('F', mktime(0,0,0,$mon, 1, date('Y'))); ?></center></td></tr>
                                            
                                     <tr><td class="padclass" width="40%"><strong style="color:#1F4979;">Number of Itinerary</strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst." &nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Approved by Admin</strong></td>
                                           <td width="10%">:</td> <td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst1."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Rejected by Admin</strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst2."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Total Collection </strong></td>
                                            <td width="10%">:</td><td class="padclass" ><strong style="color:#1F4979;"><?php echo round($totel_grand)."&nbsp;&nbsp; Rupees"; ?></strong> </td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Profit Amount </strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979; "><?php echo round($div_prof)."&nbsp;&nbsp; Rupees"; ?></strong></td></tr>
                                            </table>
                                            </div>
                                            
                                            <div style="background-color:#F7F8FF; margin-left:20px; margin-bottom:20px;">
                                            <table width="100%">
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Approved by Agent</strong></td>
                                           <td width="10%">:</td> <td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst3+$tot_mst1."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Rejected by Agent</strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979;"><?php echo $tot_mst4."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                            </table>
                                            </div>
                                            
                                            
                                            <?php
// for finding admin approved itinerary
$mst_gtt = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and substr(date_of_reg,6,2)=? and status='0' and sub_paln_id!='' and distr_id=? ORDER BY sno DESC ");
$mst_gtt->execute(array($year,$mon,$_SESSION['uid']));
//$row_mst_gtt= mysql_fetch_assoc($mst_gtt);
$row_mst_gtt_main=$mst_gtt->fetchAll();
$tot_mst_gtt=$mst_gtt->rowCount();
											?>
                                     <div class="col-sm-12" align="center" style="margin-top:20px; ">
                                     <a class="btn btn-default" id="more_agndet5" onclick="show_agndetail_div5()">More Details</a>
                                     </div>
                                            <div class="table-responsive" id="agnttbb5"  style="margin-top:20px; display:none; " >
                                     <table width="100%"  class="table table-th-block ttb5"><thead>
                                     <tr  height="30px" style=" color:#83501F; font-size:16px; font-weight:600"><td  class="padclass" colspan="5"><center>Detailed Report of <?php echo date('F', mktime(0,0,0,$mon, 1, date('Y'))).' - Month'; ?></center></td></tr>
                                     
                                     <tr style="background-color:#FCDABE; color:#83501F;">
                                     <td class="padclass" width="20%"><center><strong >Plan ID</strong></center></td>
                                     <td class="padclass" width="20%"><center><strong >Itinerary Cost</strong></center></td>
                                     <td class="padclass" width="20%"><center><strong >Grant Total </strong>(Rs)</center></td>
                                     <td class="padclass" width="20%"><center><strong >Profit to DVI </strong>(Rs)</center></td>
                                     <!--<td class="padclass" width="20%"><center><strong >Your Profit </strong>(Rs)</center></td>-->
                                     <td class="padclass" width="20%"><center><strong >More Details</strong></center></td></tr>
                                     </thead>
                                     <tbody>
                                     <?php 
									 $div_prof=0;
									 $totel_grand=0;
foreach($row_mst_gtt_main as $row_mst_gtt)
{
 $div_prof=0;
 $totel_grand=0;
 $ititns=0;
      $sub_plan_arr=explode('-',$row_mst_gtt['sub_paln_id']);
        //print_r($sub_plan_arr);
        foreach($sub_plan_arr as $splanid) 
        {
                // for finding admin approved itinerary
                $mst_gt_sub = $conn->prepare("SELECT * FROM  travel_master where plan_id=?");
                $mst_gt_sub->execute(array($splanid));
                $row_mst_gt_sub= $mst_gt_sub->fetch(PDO::FETCH_ASSOC);
                $tot_mst_gt_sub=$mst_gt_sub->rowCount();
				$div_prof=$div_prof+($row_mst_gt_sub['agnt_grand_tot']-($row_mst_gt_sub['grand_tot']+($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100))));
				$totel_grand=$totel_grand+($row_mst_gt_sub['agnt_grand_tot']-($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100)));
         $ititns= $ititns+$row_mst_gt_sub['agnt_grand_tot'];
				
        }?>
			<tr><td><strong style="color:#3F4E89"><?php echo $row_mst_gtt['plan_id'];?></strong></td>
        <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($totel_grand);?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($totel_grand);?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($div_prof);//echo round($pro_tot1);?></strong></td>
          <?php /*?>  <td><center><strong style="color:#3F4E89"><?php echo ceil($pro_tot1);?></strong></center></td><?php */?>
            <td><strong style="color:#3F4E89">
			   <?php 
			   $id_mas=substr($row_mst_gtt['plan_id'],0,2);
															if($id_mas =='TH')
															{?>
																<a class="show_pdf btn btn-default" title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?planid=<?php echo urlencode($row_mst_gtt['plan_id']); ?>"><i class="fa fa-ticket"></i> Plan detail</a>
															<?php }else if($id_mas =='H#')
															{?>
																<a class="show_pdf btn btn-default "  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_hotel.php?planid=<?php echo urlencode($row_mst_gtt['plan_id']); ?>"><i class="fa fa-ticket"></i></i> Plan detail</a>
															<?php }else if($id_mas =='T#')
															{?>
																<a class="show_pdf btn btn-default "  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?planid=<?php echo urlencode($row_mst_gtt['plan_id']); ?>"><i class="fa fa-ticket"></i> Plan detail</a>
																
															<?php }
															?></strong></td></tr>
		<?php }
									 ?>
                                     </tbody>
                                     </table>
                                   <center> <a class="btn btn-default" id="agnless_det5" onclick="hide_agndetail_div5()">Hide Details</a></center>
                                     </div>
                                            
                                            <!-- Monthvis  of year -->
<?php 
}else{?>
	<div style="background-color:#F7F8FF; margin-left:20px; margin-bottom:20px;">
                                            <table width="100%">
                 <tr><td class="padclass"  width="100%"><center><strong style="color:#3F4E89">No collection from  <?php echo $year." - ".date('F', mktime(0,0,0,$mon, 1, date('Y')))." Month"; ?></strong></center></td></tr>
                                            </table>
                                            </div>
<?php }
}?>


<?php //finding collection in month vis
if(isset($_GET['type']) && $_GET['type']==3)
{

$aid=$_GET['aid'];
$grd_tot=0;
$pro_tot=0;
$pay_dvi=0;

$orders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and distr_id=? and sub_paln_id!='' and status='0' ORDER BY sno DESC");
$orders->execute(array($aid,$_SESSION['uid']));
//$row_orders = mysql_fetch_assoc($orders);
$row_orders_main=$orders->fetchAll();
$totalRows_orders = $orders->rowCount();


$agentt = $conn->prepare("SELECT * FROM agent_pro where agent_id=? and distr_id=? and status='0' ");
$agentt->execute(array($aid,$_SESSION['uid']));
$row_agentt = $agentt->fetch(PDO::FETCH_ASSOC);
$totalRows_agentt =$agentt->rowCount();



foreach($row_orders_main as $row_orders)
		{

      $sub_plan_arr=explode('-',$row_orders['sub_paln_id']);
        //print_r($sub_plan_arr);
        foreach($sub_plan_arr as $splanid) 
        {
                // for finding admin approved itinerary
                $mst_gt_sub = $conn->prepare("SELECT * FROM  travel_master where plan_id=?");
                $mst_gt_sub->execute(array($splanid));
                $row_mst_gt_sub= $mst_gt_sub->fetch(PDO::FETCH_ASSOC);
                $tot_mst_gt_sub=$mst_gt_sub->rowCount();

				$agent_perc=round($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100));
				$upto_agent=$row_mst_gt_sub['grand_tot']+$agent_perc;
				$admin_perc=$upto_agent*($row_mst_gt_sub['agnt_adm_perc']/100);
				$total_itin_amt=$admin_perc+$upto_agent;
	
				$pro_tot=($pro_tot+$admin_perc);
				$pay_dvi1=$total_itin_amt-$agent_perc;
				$grd_tot=($grd_tot+$pay_dvi1);
      }
		}
?>
<table width="100%">
                                     <tr  height="30px" style="background-color:#33A8D3; color:#FFFFFF; font-size:16px; font-weight:600"><td  class="padclass" colspan="3"><center>Report of <?php echo $row_agentt['agent_fname'].' '.$row_agentt['agent_lname']; ?>
                                     <a class="profile_edit btn btn-sm btn-default pull-right" href="<?php echo $_SESSION['grp'];?>/agent_profile.php?uid=<?php echo $aid; ?>&group=AGENT">View Profile</a></center>
                                     </td></tr>
                                     
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Total Number Of Plan</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo $totalRows_orders."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Total Itinerary Collection</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo round($grd_tot)."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr>
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Profit to DVI</strong></td ><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo round($pro_tot)."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr>
                                     <?php /*?><tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Your Profit Amount</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo ceil($pro_tot)."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr><?php */?>
                                     </table>
                                     <div class="col-sm-12" align="center" style="margin-top:20px; ">
                                     <a class="btn btn-default" id="more_agndet" onclick="show_agndetail_div()">More Details</a>
                                     </div>
                                     
                                     <div class="table-responsive" id="agnttbb" style="margin-top:20px; display:none; " >
                                     <table width="100%"  class="table table-th-block ttb"><thead>
                                     <tr  height="30px" style=" color:#83501F; font-size:16px; font-weight:600"><td  class="padclass" colspan="5"><center>Detailed Report of <?php echo $row_agentt['agent_fname'].' '.$row_agentt['agent_lname']; ?></center></td></tr>
                                     
                                     <tr style="background-color:#FCDABE; color:#83501F;">
                                     <td class="padclass" width="20%"><center><strong >Plan ID</strong></center></td>
                                       <td class="padclass" width="20%"><center><strong >Itinerary Cost </strong>(Rs)</center></td>
                                     <td class="padclass" width="20%"><center><strong >Grant Total </strong>(Rs)</center></td>
                                     <td class="padclass" width="20%"><center><strong >Profit to DVI </strong>(Rs)</center></td>
                                     <!--<td class="padclass" width="20%"><center><strong >Your Profit </strong>(Rs)</center></td>-->
                                     <td class="padclass" width="20%"><center><strong >More Details</strong></center></td></tr>
                                     </thead>
                                     <tbody>
                                     <?php 
									 $pro_tot1=0;
									 $pay_dvi1=0;
                   $itinc=0;
$orders1 = $conn->prepare("SELECT * FROM travel_master where agent_id=? and distr_id=? and sub_paln_id!='' and status='0' ORDER BY sno DESC");
$orders1->execute(array($aid,$_SESSION['uid']));
//$row_orders = mysql_fetch_assoc($orders);
$row_orders1_main=$orders1->fetchAll();
$totalRows_orders1 = $orders1->rowCount();
foreach($row_orders1_main as $row_orders1)
		{
                  $pro_tot=0;
                  $pay_dvi1=0;
                  $itinc=0;
        $sub_plan_arr=explode('-',$row_orders1['sub_paln_id']);
        //print_r($sub_plan_arr);
        foreach($sub_plan_arr as $splanid) 
        {
                // for finding admin approved itinerary
                $mst_gt_sub = $conn->prepare("SELECT * FROM  travel_master where plan_id=?");
                $mst_gt_sub->execute(array($splanid));
                $row_mst_gt_sub= $mst_gt_sub->fetch(PDO::FETCH_ASSOC);
                $tot_mst_gt_sub=$mst_gt_sub->rowCount();

			    $agent_perc=round($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100));
				  $upto_agent=$row_mst_gt_sub['grand_tot']+$agent_perc;
				  $admin_perc=$upto_agent*($row_mst_gt_sub['agnt_adm_perc']/100);
				  $total_itin_amt=$admin_perc+$upto_agent;
	
				  $pro_tot=$pro_tot+$admin_perc;
				  $pay_dvi1=$pay_dvi1+($total_itin_amt-$agent_perc);
           $itinc= $itinc+$row_mst_gt_sub['agnt_grand_tot'];
        }
			?>
			<tr><td><strong style="color:#3F4E89"><?php echo $row_orders1['plan_id'];?></strong></td>
        <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($itinc);?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($pay_dvi1);?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($pro_tot);//echo round($pro_tot1);?></strong></td>
          <?php /*?>  <td><center><strong style="color:#3F4E89"><?php echo ceil($pro_tot1);?></strong></center></td><?php */?>
            <td><center><strong style="color:#3F4E89">
			   <?php 
			   $id_mas=substr($row_orders1['plan_id'],0,2);
															if($id_mas =='TH')
															{?>
																<a class="show_pdf btn btn-default" title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?planid=<?php echo urlencode($row_orders1['plan_id']); ?>"><i class="fa fa-ticket"></i> Plan detail</a>
															<?php }else if($id_mas =='H#')
															{?>
																<a class="show_pdf btn btn-default "  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_hotel.php?planid=<?php echo urlencode($row_orders1['plan_id']); ?>"><i class="fa fa-ticket"></i></i> Plan detail</a>
															<?php }else if($id_mas =='T#')
															{?>
																<a class="show_pdf btn btn-default "  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?planid=<?php echo urlencode($row_orders1['plan_id']); ?>"><i class="fa fa-ticket"></i> Plan detail</a>
																
															<?php }
															?></strong></center></td></tr>
		<?php }
									 ?>
                                     </tbody>
                                     </table>
                                   <center> <a class="btn btn-default" id="agnless_det" onclick="hide_agndetail_div()">Hide Details</a></center>
                                     </div>
<?php
}
?>