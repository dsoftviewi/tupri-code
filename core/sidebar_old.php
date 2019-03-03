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

mysql_select_db($database_divdb, $divdb);
$query_mainmenu = "SELECT * FROM setting_mainmenu where grpid='".$_SESSION['grp']."' and status = 0 ORDER BY morder ASC";
$mainmenu = mysql_query($query_mainmenu, $divdb) or die(mysql_error());
$row_mainmenu = mysql_fetch_assoc($mainmenu);
$totalRows_mainmenu = mysql_num_rows($mainmenu);

?>

<div class="sidebar-left sidebar-nicescroller">
				<ul class="sidebar-menu">
					<li>
						<a href="dashboard.php">
							<i class="fa fa-dashboard icon-sidebar"></i>Dashboard
						</a>
					</li>
					<?php do{
						
mysql_select_db($database_divdb, $divdb);
$query_submenu = "SELECT * FROM setting_submenu where grpid='".$_SESSION['grp']."' and mid='".$row_mainmenu ['mid']."' and status = 0 ORDER BY sorder ASC";
$submenu = mysql_query($query_submenu, $divdb) or die(mysql_error());
$row_submenu = mysql_fetch_assoc($submenu);
$totalRows_submenu = mysql_num_rows($submenu);
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
							<?php do{?>
							<li <?php if ((isset($_GET['mm'])) && ($_GET['mm']==$row_mainmenu['mid'] )&&($_GET['sm']==$row_submenu['suid'] )){?>class="active selected"<?php }?>><a <?php if($row_submenu['suid']=='baa0ec655986c4353838201deb2a6e7e'){?>target="_blank"<?php }?> href="<?php echo $row_submenu['url']."?mm=".$row_mainmenu['mid']."&sm=".$row_submenu['suid'];?>"><?php echo $row_submenu['sublabel'];?></a></li>
                             <?php }while($row_submenu = mysql_fetch_assoc($submenu));?>
						</ul>
                       <?php }?>
					</li>
					<?php }while($row_mainmenu = mysql_fetch_assoc($mainmenu));?>
				</ul>
			</div>