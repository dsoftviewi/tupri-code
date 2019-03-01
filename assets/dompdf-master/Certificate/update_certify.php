<?php
require_once("../Connections/exam.php");
$sno=$_GET['sno'];
include("../activitylog.php");
mysql_select_db($database_exam, $exam);
			$query_cerinfo= "SELECT * FROM setting_certificate where  sno='".$sno."' ";
			$cerinfo = mysql_query($query_cerinfo, $exam) or die(mysql_error());
			$row_cerinfo = mysql_fetch_assoc($cerinfo);
			$totalRows_cerinfo= mysql_num_rows($cerinfo);
?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_certify"])) && ($_POST["MM_certify"] == "insert_certify")) {
 
 $imges=$_FILES['cer_logo']['name'];
 $newname1="../Photos/Certificate/".$imges;
move_uploaded_file($_FILES["cer_logo"]["tmp_name"],$newname1);

 $imges=$_FILES['signs']['name'];
 $newname2="../Photos/Certificate/".$imges;
move_uploaded_file($_FILES["signs"]["tmp_name"],$newname2);
 
 $insertSQL = sprintf("UPDATE setting_certificate SET `title`='".$_POST['cer_title']."',certify_logo='".$newname1."',sub_title='".$_POST['sb_title']."',auth_desg='".$_POST['sb_title']."',signature='".$newname2."',line_one='".$_POST['lineone']."',line_two='".$_POST['linetwo']."',line_tre='".$_POST['linetre']."' where sno='".$sno."'");
 
  mysql_select_db($database_exam, $exam);
  $Result = mysql_query($insertSQL, $exam) or die(mysql_error());

 $msg = "The Certificate setup has been updated by the Admin";
  activity($msg,$database_exam, $exam, 'fa fa-pencil-square-o', 'completed', 'Updated', $_COOKIE['uid']);
 
 $s='setup';
 $ts='Certificate';
 echo "<script>parent.document.location.href='../admin_examsetting.php?mm=".$_GET['mm']."&sm=".$_GET['sm']."&alt=".md5(4)."&name=". $s."&t=".$ts."';</script>"; 
  echo "<script>parent.jQuery.magnificPopup.close(); </script>"; 
  }

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Certificate</title>
<link href="../assets/css/st.css" rel="stylesheet">
</head>
<style>


@font-face {
    font-family: 'sonoma_scriptregular';
 src: url('font/sonomascript-webfont.eot');
    src: url('font/sonomascript-webfont.eot?#iefix') format('embedded-opentype'),
         url('font/sonomascript-webfont.woff2') format('woff2'),
         url('font/sonomascript-webfont.woff') format('woff'),
         url('font/sonomascript-webfont.ttf') format('truetype'),
         url('font/sonomascript-webfont.svg#sonoma_scriptregular') format('svg');
    font-weight: normal;
    font-style: normal;

}


@font-face {
    font-family: 'robotoregular';
    src: url('font/roboto-regular-webfont.eot');
    src: url('font/roboto-regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('font/roboto-regular-webfont.woff2') format('woff2'),
         url('font/roboto-regular-webfont.woff') format('woff'),
         url('font/roboto-regular-webfont.ttf') format('truetype'),
         url('font/roboto-regular-webfont.svg#robotoregular') format('svg');
    font-weight: normal;
    font-style: normal;

}
@font-face {
    font-family: 'ScriptMTBoldRegular';
    src: url('font/scriptbl.eot');
    src: url('font/scriptbl.eot') format('embedded-opentype'),
         url('font/scriptbl.woff2') format('woff2'),
         url('font/scriptbl.woff') format('woff'),
         url('font/scriptbl.ttf') format('truetype'),
         url('font/scriptbl.svg#ScriptMTBoldRegular') format('svg');
}

</style>

<body>

 <form id="form" name="insert_certify" enctype="multipart/form-data" method="POST" action="<?php echo $editFormAction; ?>">
<div style="width:950px; height:550px; background-image:url(images/bg.png); margin:auto; 
 border-style:inset; border-width:20px; border-bottom-color:#000; border-left-color:#000;">

<div style="border-style:solid; margin:10px 10px 10px 10px;height:520px;">

<div align="center" style="padding-top:5px;" data-toggle="tooltip" title="Edit Title">
<input type="text" name="cer_title" value="<?php echo $row_cerinfo['title'];?>" style=" font-family:'robotoregular';font-size:24px;text-align:center;background-color:inherit;border:1px dashed  #FF0000; margin-right:-8%" data-validation="required" data-validation-error-msg="* Title required and can't be empty" />

<button type="submit" name="en_ceritfy" class="btn btn-xs " style=" float:right; background-color:#F88040; color:#FFF; margin-top:-0.5%; margin-right:-0%; border-radius:5px 0px 5px 0px;">Submit</button>
</div>

<div style="background-image:url(images/STAR.png); background-position:center; background-repeat:no-repeat; height:25px;">

</div>

<div style="font-family:'Lucida Console', Monaco, monospace; font-size:48px; text-align:center;">
CERTIFICATE

</div>

<div style="background-image:url(images/of.png); background-position:center; background-repeat:no-repeat; height:25px; padding-bottom:15px;" >

</div>

<div align="center"  style="background-image:url(images/red.png); background-position:center; background-repeat:no-repeat; height:50px; "data-toggle="tooltip" title="Edit Sub Title"> 

<input type="text" data-validation="required" data-validation-error-msg="* Title required and can't be empty"  value="<?php echo $row_cerinfo['sub_title'];?>" name="sb_title"  style="font-family:Arial, Helvetica, sans-serif; font-size:44px; color:#FFF; text-align:center; background-color:inherit;border:none;" />

</div>

<div align="center" data-toggle="tooltip" title="Edit content Line">
<input type="text" name="lineone" value="<?php echo $row_cerinfo['line_one'];?>" style="font-family:'ScriptMTBoldRegular'; font-size:24px; width:550px; text-align:center; margin-right:200px;
 margin-left:200px; padding-top:5px;background:inherit;border:1px dashed #FF0000" />
</div>

<div style="font-family:'robotoregular'; font-size:55px; text-align:center; padding-top:-5px; padding-bottom:5px;" >
STUDENT NAME
</div>

<div align="center" data-toggle="tooltip" title="Edit content Line">
<input type="text" name="linetwo" value="<?php echo $row_cerinfo['line_two'];?>" style="font-family:'ScriptMTBoldRegular'; font-size:22px; width:550px; text-align:center; margin-right:200px;
padding-bottom:5px; margin-left:200px;background:inherit;border:1px dashed #FF0000"" />


<div style="font-family:Segoe UI Symbol; font-size:24px; text-align:center;">
 - GRADE ' '
</div> 

<input type="text" name="linetre"  value="<?php echo $row_cerinfo['line_tre'];?>" style="font-family:'ScriptMTBoldRegular'; font-size:22px; width:550px; text-align:center; margin-right:200px;
padding-bottom:5px; margin-left:200px;background:inherit;border:1px dashed #FF0000"" />
</div>




<div style="font-family:'robotoregular'; font-size:18px; text-align:left; margin-left:20px; margin-top:30px; float:left;">
Exam Code: <br />
Certificate ID:654321
</div>


<div style="float:left; margin-left:210px; padding-top:20px;">
<img id="uploadPreview" src="<?php echo $row_cerinfo['certify_logo'];?>" style="width: 180px; height: 64px;" />
<input id="uploadImage" type="file" name="cer_logo" required="required" onchange="PreviewImage();" style="position:absolute;"/>
</div>



<div align="right" style="margin-right:20px; margin-top:18px;">
<input id="uploadsign" type="file" name="signs" required="required" onchange="PreviewImage1();" style="position:absolute;margin-left:-10%;margin-top:-2%;"/>
<div style="margin-left:115px;">
<img id="signPreview" src="<?php echo $row_cerinfo['signature'];?>" style="width: 134px; height:38px;" />

</div>
<div style="margin-right:25px;" data-toggle="tooltip" title="Edit Designations">
<input type="text" value="<?php echo $row_cerinfo['auth_desg'];?>" name="auth_desgs" style="font-family:'robotoregular'; font-size:18px; text-align:right; background:inherit;border:1px dashed #FF0000"/>
</div>
</div>

</div>

</div><br />

  <input type="hidden" name="MM_certify" value="insert_certify" />
</form>
</body>
</html>

<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>
<script type="text/javascript">

    function PreviewImage1() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadsign").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("signPreview").src = oFREvent.target.result;
        };
    };

</script>
<script type="text/javascript">

$(function () { $("[data-toggle='tooltip']").tooltip({html : true }); });
    $(function () { $("[data-toggle='popover']").popover({html : true,trigger :'hover' }); });

</script>

<!--External Validation Script  Start's Here--> 
<script src="../jQuery1/form-validator/jquery.form-validator.js"></script>
<script>
(function($, window) {

    var dev = '.dev'; //window.location.hash.indexOf('dev') > -1 ? '.dev' : '';

    // setup datepicker
    $("#datepicker").datepicker();

    // Add a new validator
    $.formUtils.addValidator({
        name : 'even_number',
        validatorFunction : function(value, $el, config, language, $form) {
            return parseInt(value, 10) % 2 === 0;
        },
        borderColorOnError : '',
        errorMessage : 'You have to give an even number',
        errorMessageKey: 'badEvenNumber'
    });

    window.applyValidation = function(validateOnBlur, forms, messagePosition) {
        if( !forms )
            forms = 'form';
        if( !messagePosition )
            messagePosition = 'top';

        $.validate({
            form : forms,
            language : {
                requiredFields: 'Required'
            },
            validateOnBlur : validateOnBlur,
            errorMessagePosition : messagePosition,
            scrollToTopOnError : true,
            borderColorOnError : 'red',
            modules : 'security'+dev+', location'+dev+', sweden'+dev+', html5'+dev+', file'+dev+', uk'+dev,
            onModulesLoaded: function() {
                $('#country-suggestions').suggestCountry();
                $('#swedish-county-suggestions').suggestSwedishCounty();
                $('#password').displayPasswordStrength();
            },
            onValidate : function($f) {

                console.log('about to validate form '+$f.attr('id'));

                var $callbackInput = $('#callback');
                if( $callbackInput.val() == 1 ) {
                    return {
                        element : $callbackInput,
                        message : 'This validation was made in a callback'
                    };
                }
            },
            onError : function($form) {
                if( !$.formUtils.haltValidation ) {
                  
                }
            },
            onSuccess : function($form) {
                
                return true;
            }
        });
    };

    $('#text-area').restrictLength($('#max-len'));

    window.applyValidation(true, '#form', 'element');
   

    // Load one module outside $.validate() even though you do not have to
    $.formUtils.loadModules('date'+dev+'.js', false, false);

    $('input')
        .on('zbeforeValidation', function() {
            console.log('About to validate input "'+this.name+'"');
        })
        .on('validationz', function(evt, isValid) {
            var validationResult = '';
            if( isValid === null ) {
                validationResult = 'not validated';
            } else if( isValid ) {
                validationResult = 'VALID';
            } else {
                validationResult = 'INVALID';
            }
            console.log('Input '+this.name+' is '+validationResult);
        });

})(jQuery, window);
</script>
<!--End Of Validation Script-->	