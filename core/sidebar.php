<?php 
require_once('Connections/divdb.php');
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$mainmenu = $conn->prepare("SELECT * FROM setting_mainmenu where grpid=? and status = 0 ORDER BY morder ASC");
$mainmenu->execute(array($_SESSION['grp']));
$row_mainmenu_main = $mainmenu->fetchAll();
$totalRows_mainmenu = $mainmenu->rowCount();

if($_SESSION['grp']!='ADMIN' && $_SESSION['grp']!='CMS')
{// for agent and distributor side
?>

<div class="sidebar-left sidebar-nicescroller">
				<ul class="sidebar-menu">
					<li>
						<a href="dashboard.php">
							<i class="fa fa-dashboard icon-sidebar"></i>Dashboard
						</a>
					</li>
					<?php foreach($row_mainmenu_main as $row_mainmenu) 
					
					{
					
						
$submenu = $conn->prepare("SELECT * FROM setting_submenu where grpid=? and mid=? and status = 0 ORDER BY sorder ASC");
$submenu->execute(array($_SESSION['grp'],$row_mainmenu['mid']));
$row_submenu = $submenu->fetch(PDO::FETCH_ASSOC);
$totalRows_submenu = $submenu->rowCount();
					?>
					<li <?php if ((isset($_GET['mm'])) && ($_GET['mm']==$row_mainmenu['mid'] ) ){?>class="active selected"<?php }?>>
						<a href="<?php echo $row_submenu['url']."?mm=".$row_mainmenu['mid']."&sm=".$row_submenu['suid'];?>">
							<i class="<?php echo $row_mainmenu['iconimg'];?> icon-sidebar"></i>
                            <?php if($row_mainmenu['smenu']==1){?>
							<?php } echo $row_mainmenu['mainlabel'];?>
							<!--<span class="badge badge-warning span-sidebar">7</span>-->
							</a>
                        
					</li>
					<?php } ?>
				</ul>
			</div>
<?php }else{//for admin side?>
			<div class="sidebar-left sidebar-nicescroller">
				<ul class="sidebar-menu">
					<li>
						<a href="dashboard.php">
							<i class="fa fa-dashboard icon-sidebar"></i>Dashboard
						</a>
					</li>
					<?php 
					foreach($row_mainmenu_main as $row_mainmenu){
						
$submenu = $conn->prepare("SELECT * FROM setting_submenu where grpid=? and mid=? and status = 0 ORDER BY sorder ASC");
$submenu->execute(array($_SESSION['grp'],$row_mainmenu['mid']));
$row_submenu_main = $submenu->fetchAll();
$totalRows_submenu = $submenu->rowCount();
					?>
					<li <?php if ((isset($_GET['mm'])) && ($_GET['mm']==$row_mainmenu['mid'] ) ){?>class="active selected"<?php }?>>
						<a <?php if($row_mainmenu['smenu']==0){?>href="<?php echo $row_mainmenu['url']."?mm=".$row_mainmenu['mid'];?>"<?php } else{?>href=""<?php }?>>
							<i class="<?php echo $row_mainmenu['iconimg'];?> icon-sidebar"></i>
                            <?php if($row_mainmenu['smenu']==1){?>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							<?php } echo $row_mainmenu['mainlabel'];?>
							<!--<span class="badge badge-warning span-sidebar">7</span>-->
							</a>
                            <?php if($row_mainmenu['smenu']==1){?>
						<ul class="submenu <?php if ((isset($_GET['mm'])) && ($_GET['mm']==$row_mainmenu['mid'])){?>visible<?php }?>">
							<?php foreach($row_submenu_main as $row_submenu){?>
							<li <?php if ((isset($_GET['mm'])) && ($_GET['mm']==$row_mainmenu['mid'] )&&($_GET['sm']==$row_submenu['suid'] )){?>class="active selected"<?php }?>><a <?php if($row_submenu['suid']=='baa0ec655986c4353838201deb2a6e7e'){?>target="_blank"<?php }?> href="<?php echo $row_submenu['url']."?mm=".$row_mainmenu['mid']."&sm=".$row_submenu['suid'];?>"><?php echo $row_submenu['sublabel'];?></a></li>
                            	  <?php }?>					
													</ul>
                       <?php }?>
					</li>
					<?php } ?>
									</ul>
			</div>
<?php }?>