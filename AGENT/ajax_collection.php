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
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==1)
{ 
$year=$_GET['year'];
// for finding all itinerary
$mst = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and agent_id=?");
$mst->execute(array($year,$_SESSION['uid']));
$row_mst= $mst->fetch(PDO::FETCH_ASSOC);
$tot_mst=$mst->rowCount();

// for finding admin approved itinerary
$mst1 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and  status='0' and agent_id=?");
$mst1->execute(array($year,$_SESSION['uid']));
$row_mst1= $mst1->fetch(PDO::FETCH_ASSOC);
$tot_mst1=$mst1->rowCount();

// for finding admin approved itinerary
$mst_gt = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and status='0' and agent_id=?");
$mst_gt->execute(array($year,$_SESSION['uid']));
//$row_mst_gt= mysql_fetch_assoc($mst_gt);
$row_mst_gt_main=$mst_gt->fetchAll();
$tot_mst_gt=$mst_gt->rowCount();

$totel_grand=0;
$agn_tott=0;
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

          		  $totel_grand=$totel_grand+$row_mst_gt_sub['agnt_grand_tot'];
          		
          			$adn_perc=(($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100)));
          			$agn_tott=($agn_tott+$adn_perc);
        }
	}
}
 
// for finding admin rejected itinerary 
$mst2 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and  status='1' and agent_id=?");
$mst2->execute(array($year,$_SESSION['uid']));
$row_mst2= $mst2->fetch(PDO::FETCH_ASSOC);
$tot_mst2=$mst2->rowCount();

// for finding agent approved itinerary 
$mst3 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and  status='2' and agent_id=?");
$mst3->execute(array($year,$_SESSION['uid']));
$row_mst3= $mst3->fetch(PDO::FETCH_ASSOC);
$tot_mst3=$mst3->rowCount();

// for finding agent rejected itinerary 
$mst4 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and  status='3' and agent_id=?");
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
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Profit Amount </strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979; "><?php echo round($agn_tott)."&nbsp;&nbsp; Rupees"; ?></strong></td></tr>
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
                                            <tr class="togg"  height="30px" style="background-color:#5F779D; color:#FFFFFF; font-size:16px; font-weight:600"><td  class="padclass" colspan="8"><center>Month vis report of <?php echo $year; ?></center></td></tr>
                                            <tr><td class="padclass"><strong style="color:#1F4979;">Month</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Number of Itinerary</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Approved by Admin</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Rejected by Admin</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Approved by Agent</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Rejected by Agent</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Profit Amount(Rs.)</strong></td>
                                            <td class="padclass"><strong style="color:#1F4979;">Total Collection(Rs.)</strong></td></tr>
        <?php 
		for ($m=1; $m<=12; $m++) {
    $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
	 	$num_mon = date('m', mktime(0,0,0,$m, 1, date('Y')));
		
$mon=$num_mon;
// for finding all itinerary
$mst = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and agent_id=?");
$mst->execute(array($year,$mon,$_SESSION['uid']));
$row_mst= $mst->fetch(PDO::FETCH_ASSOC);
$tot_mst=$mst->rowCount();

// for finding admin approved itinerary
$mst1 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and agent_id=?");
$mst1->execute(array($year,$mon,$_SESSION['uid']));
$row_mst1= $mst1->fetch(PDO::FETCH_ASSOC);
$tot_mst1=$mst1->rowCount();

// for finding admin approved itinerary
$mst_gt = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and status='0' and agent_id=?");
$mst_gt->execute(array($year,$mon,$_SESSION['uid']));
//$row_mst_gt= mysql_fetch_assoc($mst_gt);
$row_mst_gt_main=$mst_gt->fetchAll();
$tot_mst_gt=$mst_gt->rowCount();

$totel_grand=0;
$agn_tott=0;
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
			
                $totel_grand=$totel_grand+$row_mst_gt_sub['agnt_grand_tot'];

          			$adn_perc=(($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100)));
          			$agn_tott=($agn_tott+$adn_perc);
        }

	}
}
 

// for finding admin rejected itinerary 
$mst2 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and agent_id=?");
$mst2->execute(array($year,$mon,$_SESSION['uid']));
$row_mst2= $mst2->fetch(PDO::FETCH_ASSOC);
$tot_mst2=$mst2->rowCount();

// for finding agent approved itinerary 
$mst3 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and agent_id=?");
$mst3->execute(array($year,$mon,$_SESSION['uid']));
$row_mst3= $mst3->fetch(PDO::FETCH_ASSOC);
$tot_mst3=$mst3->rowCount();


// for finding agent rejected itinerary 
$mst4 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and agent_id=?");
$mst4->execute(array($year,$mon,$_SESSION['uid']));
$row_mst4= $mst4->fetch(PDO::FETCH_ASSOC);
$tot_mst4=$mst4->rowCount();
	
	 	?>
        <tr><td class="padclass"><strong style="color:#1F4979;"><?php echo $month; ?></strong></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number of Itinerary" ><?php if($tot_mst>0){echo $tot_mst; }else{ echo "-"; } ?></strong></center></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number Of Itinerary Approved By Admin" ><?php if($tot_mst1>0){echo $tot_mst1; }else{ echo  "-"; } ?></strong></center></</td>                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number Of Itinerary Rejected By Admin" ><?php if($tot_mst2>0){ echo $tot_mst2;}else { echo  "-";} ?></strong></center></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number Of Itinerary Approved By Agent" ><?php if($tot_mst3+$tot_mst1>0){echo $tot_mst3+$tot_mst1; }else {echo "-"; } ?></strong></center></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="Number Of Itinerary Rejected By Agent" ><?php if($tot_mst4>0){ echo $tot_mst4; }else{ echo "-"; } ?></strong></center></td>
                                            <td class="padclass"><center><strong style="color:#1F4979;" class="tooltips"  data-original-title="<?php echo $month; ?> - Profit (Rupees)" ><?php if($agn_tott>0){echo round($agn_tott); }else{echo "-";} ?></strong></center></td>
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
$mst = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and agent_id=?");
$mst->execute(array($year,$mon,$_SESSION['uid']));
$row_mst= $mst->fetch(PDO::FETCH_ASSOC);
$tot_mst=$mst->rowCount();

// for finding admin approved itinerary
$mst1 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and agent_id=?");
$mst1->execute(array($year,$mon,$_SESSION['uid']));
$row_mst1= $mst1->fetch(PDO::FETCH_ASSOC);
$tot_mst1=$mst1->rowCount();

// for finding admin approved itinerary
$mst_gt = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and status='0' and agent_id=?");
$mst_gt->execute(array($year,$mon,$_SESSION['uid']));
//$row_mst_gt= mysql_fetch_assoc($mst_gt);
$row_mst_gt_main=$mst_gt->fetchAll();
$tot_mst_gt=$mst_gt->rowCount();

$totel_grand=0;
$agn_tott=0;
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

          		  $totel_grand=$totel_grand+$row_mst_gt_sub['agnt_grand_tot'];
          			
          			$adn_perc=(($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100)));
          			$agn_tott=($agn_tott+$adn_perc);
        }
	}
}
 

// for finding admin rejected itinerary 
$mst2 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and agent_id=?");
$mst2->execute(array($year,$mon,$_SESSION['uid']));
$row_mst2= $mst2->fetch(PDO::FETCH_ASSOC);
$tot_mst2=$mst2->rowCount();

// for finding agent approved itinerary 
$mst3 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and agent_id=?");
$mst3->execute(array($year,$mon,$_SESSION['uid']));
$row_mst3= $mst3->fetch(PDO::FETCH_ASSOC);
$tot_mst3=$mst3->rowCount();

// for finding agent rejected itinerary 
$mst4 = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and sub_paln_id!='' and substr(date_of_reg,6,2)=? and  status='0' and agent_id=?");
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
                                            <tr><td class="padclass" width="40%"><strong style="color:#1F4979">Your Profit Amount </strong></td>
                                            <td width="10%">:</td><td class="padclass"><strong style="color:#1F4979; "><?php echo round($agn_tott)."&nbsp;&nbsp; Rupees"; ?></strong></td></tr>
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
                                            
                                            <!-- Monthvis  of year -->
                                            <!-- Monthvis  of year -->
                       <?php
// for finding admin approved itinerary
$mst_gtt = $conn->prepare("SELECT * FROM  travel_master where substr(date_of_reg,1,4)=? and substr(date_of_reg,6,2)=?  and status='0' and sub_paln_id!='' and agent_id=? ORDER BY sno DESC");
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
                                     <td class="padclass" width="20%"><center><strong >Collection </strong>(Rs)</center></td>
                                     <td class="padclass" width="20%"><center><strong >Percentage </strong>(%)</center></td>
                                     <td class="padclass" width="20%"><center><strong >Your Profit </strong>(Rs)</center></td>
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
          $sub_plan_arr=explode('-',$row_mst_gtt['sub_paln_id']);
        //print_r($sub_plan_arr);
        foreach($sub_plan_arr as $splanid) 
        {
                // for finding admin approved itinerary
                $mst_gt_sub = $conn->prepare("SELECT * FROM  travel_master where plan_id=?");
                $mst_gt_sub->execute(array($splanid));
                $row_mst_gt_sub= $mst_gt_sub->fetch(PDO::FETCH_ASSOC);
                $tot_mst_gt_sub=$mst_gt_sub->rowCount();

			          $totel_grand= $totel_grand+$row_mst_gt_sub['agnt_grand_tot'];
			          $div_prof=$div_prof+(($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100)));
        }
				?>
			     <tr>
            <td><strong style="color:#3F4E89"><?php echo $row_mst_gtt['plan_id'];?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($totel_grand);?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".$row_mst_gtt['agent_perc'].' %';?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($div_prof);//echo round($pro_tot1);?></strong></center></td>
          <?php /*?>  <td><center><strong style="color:#3F4E89"><?php echo ceil($pro_tot1);?></strong></center></td><?php */?>
            <td><center><strong style="color:#3F4E89">
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
															?></strong></center></td></tr>
		<?php }
									 ?>
                                     </tbody>
                                     </table>
                                   <center> <a class="btn btn-default" id="agnless_det5" onclick="hide_agndetail_div5()">Hide Details</a></center>
                                     </div>
                                 

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
    $pid=$_GET['show_id'];
    $grd_tot=0;
    $pro_tot=0;
    $pay_dvi=0;

if($pid=="ALL")
{
		$orders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and sub_paln_id!='' and status='0' ORDER BY sno DESC ");
		$pln="all plans";
}else if($pid=="TH"){
		$orders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and sub_paln_id!='' and substr(plan_id,1,2)='TH' and status='0' ORDER BY sno DESC ");
		$pln="travel with hotel - plans";
}else if($pid=="TT"){
		$orders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and sub_paln_id!='' and substr(plan_id,1,2)='T#' and status='0' ORDER BY sno DESC ");
		$pln="travel only - plans";
}else if($pid=="HH"){
		$orders = $conn->prepare("SELECT * FROM travel_master where agent_id=? and sub_paln_id!='' and substr(plan_id,1,2)='H#' and status='0' ORDER BY sno DESC");
		$pln="hotel only - plans";
}
$orders->execute(array($_SESSION['uid']));
//$row_orders = mysql_fetch_assoc($orders);
$row_orders_main =$orders->fetchAll();
$totalRows_orders = $orders->rowCount();
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

          			$grd_tot=$grd_tot+round($row_mst_gt_sub['agnt_grand_tot']);
          			$admin_perc=$row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agnt_adm_perc']/100);
              		
          			$pro_tot=$pro_tot+((($row_mst_gt_sub['grand_tot'])*($row_mst_gt_sub['agent_perc']/100)));
          }
			
		}
		$pay_dvi=$grd_tot-$pro_tot;
?>
<table width="100%">
                                     <tr  height="30px" style="background-color:#33A8D3; color:#FFFFFF; font-size:16px; font-weight:600"><td  class="padclass" colspan="3"><center>Report of <?php echo $pln; ?></center></td></tr>
                                     
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Total Number Of Plan</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo $totalRows_orders."&nbsp;&nbsp; Plan(s)"; ?></strong></td></tr>
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Total Itinerary Collection</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo round($grd_tot)."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr>
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Amount Payable To DVI</strong></td ><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo round($pay_dvi)."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr>
                                     <tr><td class="padclass" width="40%"><strong  style="color:#1F4979;">Your Profit Amount</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="50%"><strong style="color:#1F4979;"><?php echo round($pro_tot)."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr>
                                     </table>
                                     <div class="col-sm-12" align="center" style="margin-top:20px; ">
                                     <a class="btn btn-default" id="more_det" onclick="show_detail_div()">More Details</a>
                                     </div>
                                     
                                     <div class="table-responsive" id="ttbb" style="margin-top:20px; display:none; " >
                                     <table width="100%"  class="table table-th-block ttb"><thead>
                                     <tr  height="30px" style=" color:#83501F; font-size:16px; font-weight:600"><td  class="padclass" colspan="5"><center>Detailed Report of <?php echo $pln; ?></center></td></tr>
                                     
                                     <tr style="background-color:#FCDABE; color:#83501F;">
                                     <td class="padclass" width="20%"><center><strong >Plan ID</strong></center></td>
                                     <td class="padclass" width="20%"><center><strong >Collection </strong>(Rs)</center></td>
                                     <td class="padclass" width="20%"><center><strong >Payable to DVI </strong>(Rs)</center></td>
                                     <td class="padclass" width="20%"><center><strong >Your Profit </strong>(Rs)</center></td>
                                     <td class="padclass" width="20%"><center><strong >More Details</strong></center></td></tr>
                                     </thead>
                                     <tbody>
                                     <?php 
									 $pro_tot1=0;
                   $pay_dvi1=0;
				   

//$row_orders1 = mysql_fetch_assoc($orders1);

reset($row_orders_main);
foreach($row_orders_main as $row_orders1)
		{
			             $pro_tot1=0;
                   $pay_dvi1=0;
                   $tot_collst=0;
        $sub_plan_arr=explode('-',$row_orders1['sub_paln_id']);
        //print_r($sub_plan_arr);
        foreach($sub_plan_arr as $splanid) 
        {
                // for finding admin approved itinerary
                $mst_gt_sub = $conn->prepare("SELECT * FROM  travel_master where plan_id=?");
                $mst_gt_sub->execute(array($splanid));
                $row_mst_gt_sub= $mst_gt_sub->fetch(PDO::FETCH_ASSOC);
                $tot_mst_gt_sub=$mst_gt_sub->rowCount();

			//myedit
                  $agent_perc=round($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100));
                	$upto_agent=$row_mst_gt_sub['grand_tot']+$agent_perc;
                	$admin_perc=$upto_agent*($row_mst_gt_sub['agnt_adm_perc']/100);
                	$total_itin_amt=$admin_perc+$upto_agent;
	               //myedit end
                  $pro_tot1=$pro_tot1+$agent_perc;
  $pay_dvi1= $pay_dvi1+$total_itin_amt-$agent_perc;
  $tot_collst=$tot_collst+$row_mst_gt_sub['agnt_grand_tot'];
          }//for end
   
			
			?>
			<tr><td><strong style="color:#3F4E89"><?php echo $row_orders1['plan_id'];?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($tot_collst);?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($pay_dvi1);?></strong></td>
            <td><strong style="color:#3F4E89"><?php echo "Rs. ".round($pro_tot1);?></strong></td>
            <td><strong style="color:#3F4E89">
			   <?php 
			   $id_mas=substr($row_orders1['plan_id'],0,2);
															if($id_mas =='TH')
															{?>
														<a class="show_pdf btn btn-default" title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders1['plan_id']); ?>"><i class="fa fa-ticket"></i> Plan detail</a>
															<?php }else if($id_mas =='H#')
															{?>
																<a class="show_pdf btn btn-default "  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders1['plan_id']); ?>"><i class="fa fa-ticket"></i></i> Plan detail</a>
															<?php }else if($id_mas =='T#')
															{?>
																<a class="show_pdf btn btn-default "  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_orders1['plan_id']); ?>"><i class="fa fa-ticket"></i> Plan detail</a>
																
															<?php }
															?></strong></center></td></tr>
		<?php }
									 ?>
                                     </tbody>
                                     </table>
                                  <center> <a class="btn btn-default" id="less_det" onclick="hide_detail_div()">Hide Details</a></center>
                                     </div>
                                     
                                     
<?php
}?>

<?php //finding collection in month vis
if(isset($_GET['type']) && $_GET['type']==4)
{ 
    $pid=$_GET['ind']."#".$_GET['num'];
    $pro_tot2=0;$pay_dvi2=0;
    // for finding agent rejected itinerary 
    $mst = $conn->prepare("SELECT * FROM travel_master where plan_id=? and sub_paln_id!=''");
    $mst->execute(array($pid));
    $row_mst= $mst->fetch(PDO::FETCH_ASSOC);
    $tot_mst=$mst->rowCount();

   $sub_plan_arr=explode('-',$row_mst['sub_paln_id']);
   $tot_collst=0;
        foreach($sub_plan_arr as $splanid) 
        {
                // for finding admin approved itinerary
                $mst_gt_sub = $conn->prepare("SELECT * FROM  travel_master where plan_id=?");
                $mst_gt_sub->execute(array($splanid));
                $row_mst_gt_sub= $mst_gt_sub->fetch(PDO::FETCH_ASSOC);
                $tot_mst_gt_sub=$mst_gt_sub->rowCount();

            	//myedit
            	$agent_perc=round($row_mst_gt_sub['grand_tot']*($row_mst_gt_sub['agent_perc']/100));
            	$upto_agent=$row_mst_gt_sub['grand_tot']+$agent_perc;
            	$admin_perc=$upto_agent*($row_mst_gt_sub['agnt_adm_perc']/100);
            	$total_itin_amt=$admin_perc+$upto_agent;
            	
            	$pro_tot2=((int)$pro_tot2+(int)$agent_perc);
            	$pay_dvi2=$pay_dvi2+($total_itin_amt-$agent_perc);
              $tot_collst=$tot_collst+$row_mst_gt_sub['agnt_grand_tot'];
        }
	//myedit end
	//echo "ssss".$pro_tot2;
?>
<table width="100%">
                  <tr  height="30px" style="background-color:#33A8D3; color:#FFFFFF; font-size:16px; font-weight:600"><td  class="padclass" colspan="4"><center><?php echo $row_mst['tr_name']."&nbsp; (&nbsp;".$pid."&nbsp;)&nbsp; plan report "; ?></center></td></tr>
                                     
                    <tr><td class="padclass" width="10%"></td><td class="padclass" width="40%"><strong  style="color:#1F4979;">Traveller Name</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="40%"><strong style="color:#1F4979;"><?php echo $row_mst['tr_name']; ?></strong></td></tr>
                    <tr><td class="padclass" width="10%"></td><td class="padclass" width="40%"><strong  style="color:#1F4979;">Date Of Booking</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="40%"><strong style="color:#1F4979;"><?php echo date("d-M-Y h:i:s A",strtotime($row_mst['date_of_reg'])); ?></strong></td></tr>
                    <tr><td class="padclass" width="10%"></td><td class="padclass" width="40%"><strong  style="color:#1F4979;">Plan Amount</strong></td ><td class="padclass" width="10%">:</td><td class="padclass" width="40%"><strong style="color:#1F4979;"><?php echo $tot_collst."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr>
                    <tr><td class="padclass" width="10%"></td><td class="padclass" width="40%"><strong  style="color:#1F4979;">Payable To DVI</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="40%"><strong style="color:#1F4979;"><?php echo $pay_dvi2."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr>
                    <tr><td class="padclass" width="10%"></td><td class="padclass" width="40%"><strong  style="color:#1F4979;">Your Profit Amount</strong></td><td class="padclass" width="10%">:</td><td class="padclass" width="40%"><strong style="color:#1F4979;"><?php echo $pro_tot2."&nbsp;&nbsp; Rupee(s)"; ?></strong></td></tr>
                    <tr><td class="padclass" colspan="4"><center><strong style="color:#3F4E89">
			   <?php 
			   $id_mas=substr($row_mst['plan_id'],0,2);
															if($id_mas =='TH')
															{?>
							<a class="show_pdf btn btn-default" title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_mst['plan_id']); ?>"><i class="fa fa-ticket"></i> Plan detail</a>
															<?php }else if($id_mas =='H#')
															{?>
							<a class="show_pdf btn btn-default "  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_hotel.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_mst['plan_id']); ?>"><i class="fa fa-ticket"></i></i> Plan detail</a>
															<?php }else if($id_mas =='T#')
															{?>
							<a class="show_pdf btn btn-default "  title="Plan details" href="<?php echo $_SESSION['grp'];?>/itiner_trav.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&planid=<?php echo urlencode($row_mst['plan_id']); ?>"><i class="fa fa-ticket"></i> Plan detail</a>
																
															<?php }
															?></strong></center></td></tr>
                                     </table>
<?php 

}
?>