<?php
//===================12-08-2016 by junior Developer A Ganeshkumar=============
include('../Connections/divdb.php');

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
 $today=date("d_M_Y_H_i_s");
 $his=date("His");
  
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
if($_GET['type']==1)
{ 
  $pack_inc=$_GET['pack_inc'];
  ?>
                <div id="pack_div<?php echo $pack_inc;?>">
                                 <fieldset class="scheduler-border">
                   <legend class="scheduler-border">Package
                    <button type="button" class="btn btn-info btn-sm btn_splus" onclick="add_pack('<?php echo $pack_inc;?>')" id="pack_pulse<?php echo $pack_inc;?>" style="padding:0px 1px;">
                  <i class=" fa fa-plus"></i>     
                  </button> 
                  <button type="button" class="btn btn-sm btn-warning btn_splus" id="pack_min<?php echo $pack_inc;?>" style="padding:0px 1px;" onclick="remove_pack('<?php echo $pack_inc;?>');">
                    <i class="fa fa-minus"></i>
                  </button></legend>
                  <div class="col-sm-12">
                                    <div class="row">
                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
                    <label for="Day Title">Days : </label>
                    </div><strong id="err_msg_day<?php echo $pack_inc;?>" style="font-size:13px;color:red;float:right;"></strong>
                        </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="day_name<?php echo $pack_inc;?>" id="day_name<?php echo $pack_inc;?>" class="form-control" placeholder="Days Title" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="margin-top:5px;">
                                    <div class="row">
                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left">
                    <label for="pack_locat">Location Name</label>
                    </div><strong id="err_msg_locat<?php echo $pack_inc;?>" style="font-size:13px;color:red;float:right"></strong>
                        </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="pack_locat<?php echo $pack_inc;?>" id="pack_locat<?php echo $pack_inc;?>" class="form-control" placeholder="Place Name" />
                                        </div>
                                    </div>
                                </div>
                  <div class="col-sm-12" style="margin-top:5px;">
                                    <div class="row">
                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
                    <label for="pack_desc">Pack - Short Description</label>
                    </div><strong id="err_msg_desc<?php echo $pack_inc;?>" style="font-size:13px;color:red;float:right;"></strong>
                        </div>
                                        </div>
                                        <div class="col-sm-9">
                        <textarea name="pack_desc<?php echo $pack_inc;?>" id="pack_desc<?php echo $pack_inc;?>" style="overflow-y:scroll; height:90px; width:100%; resize:none"></textarea>
                                        </div>
                                    </div>
                                </div>
              <div class="col-sm-12" style="margin-top:5px;">
                                    <div class="row">
                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
                    <label for="pack_img">Location Img :</label>
                    <br><small style="color : rgb(240, 9, 9);font-size: 11px;font-weight: 600;">[ Image file only ]</small>
                    </div> <strong id="err_msg_img<?php echo $pack_inc;?>" style="font-size:13px;color:red;float:right"></strong>
                        </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="file" name="pack_img<?php echo $pack_inc;?>" id="pack_img<?php echo $pack_inc;?>" class="" placeholder="Img" />
                        <input type="hidden" id="img_hidd<?php echo $pack_inc;?>" name="img_hidd<?php echo $pack_inc;?>" value="" />
                        <strong id="perr<?php echo $pack_inc;?>" class="flashit pull-left" style="display:none">* Please Enter All Required Fields</strong>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
<?php 
}
if($_GET['type']==2)
{ 
  $pack_inc=$_GET['pack_inc'];
  $title=$_GET['title'];
  $img=$_GET['img'];
  $desc=$_GET['desc'];
  $dl=$_GET['dl'];

?>  <div class="col-sm-12">
                <div id="pack_div<?php echo $pack_inc;?>">
                                 <fieldset class="scheduler-border">
                   <legend class="scheduler-border">Package
                    <button type="button" class="btn btn-info btn-sm btn_splus" onclick="add_pack('<?php echo $pack_inc;?>')" id="pack_pulse<?php echo $pack_inc;?>" style="padding:0px 1px;">
                  <i class=" fa fa-plus"></i>     
                  </button> 
                  <button type="button" class="btn btn-sm btn-warning btn_splus" id="pack_min<?php echo $pack_inc;?>" style="padding:0px 1px;" onclick="remove_pack('<?php echo $pack_inc;?>');">
                    <i class="fa fa-minus"></i>
                  </button></legend>
                  <div class="col-sm-12">
                                    <div class="row">
                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
                    <label for="Day Title">Days : </label>
                    </div><strong id="err_msg_day<?php echo $pack_inc;?>" style="font-size:13px;color:red;float:right;"></strong>
                        </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="day_name<?php echo $pack_inc;?>" id="day_name<?php echo $pack_inc;?>" class="form-control" placeholder="Days Title" value="<?php if($title!="undefined"){ echo $title; } ?>" />
                                        </div>
                                    </div>
                                </div>
                                  <div class="col-sm-12" style="margin-top:5px;">
                                    <div class="row">
                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left">
                    <label for="pack_locat">Location Name</label>
                    </div><strong id="err_msg_locat<?php echo $pack_inc;?>" style="font-size:13px;color:red;float:right"></strong>
                        </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="pack_locat<?php echo $pack_inc;?>" id="pack_locat<?php echo $pack_inc;?>" class="form-control" placeholder="Place Name" value="<?php if($dl!="undefined"){ echo $dl; } ?>" />
                                        </div>
                                    </div>
                                </div>
                  <div class="col-sm-12" style="margin-top:5px;">
                                    <div class="row">
                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
                    <label for="pack_desc">Pack - Short Description</label>
                    </div><strong id="err_msg_desc<?php echo $pack_inc;?>" style="font-size:13px;color:red;float:right;"></strong>
                        </div>
                                        </div>
                                        <div class="col-sm-9">
                        <textarea name="pack_desc<?php echo $pack_inc;?>" id="pack_desc<?php if($pack_inc!="undefined"){echo $pack_inc;} ?>" style="overflow-y:scroll; height:90px; width:100%; resize:none"><?php  if($desc!="undefined"){echo $desc; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
              <div class="col-sm-12" style="margin-top:5px;">
                                    <div class="row">
                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
                    <label for="pack_img">Location Img :</label>
                    <br><small style="color : rgb(240, 9, 9);font-size: 11px;font-weight: 600;">[ Image file only ]</small>
                    </div> <strong id="err_msg_img<?php echo $pack_inc;?>" style="font-size:13px;color:red;float:right"></strong>
                        </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="file" name="pack_img<?php echo $pack_inc;?>" id="pack_img<?php echo $pack_inc;?>" class="" placeholder="Img" />
                        <input type="hidden" id="img_hidd<?php echo $pack_inc;?>" name="img_hidd<?php echo $pack_inc;?>" value="<?php if($img!="undefined"){ echo $img;} ?>" />
                        <strong id="perr<?php echo $pack_inc;?>" class="flashit pull-left" style="display:none">* Please Enter All Required Fields</strong>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        </div>
  <?php
}
?>
