<?php

 /*---------------------Mvaayoo Configuration Start-----*/
 
function sms_func($receipientno,$msgtxt,$selectid)
{
require_once('../Connections/divdb.php');
$mobile=$receipientno; 
$strmsg=$msgtxt;
$smsdb = $conn->prepare("SELECT * FROM setting_sms WHERE sno =?");
$smsdb->execute(array($selectid));
$row_smsdb = $smsdb->fetch(PDO::FETCH_ASSOC);
$totalRows_smsdb = $smsdb->rowCount();

$ch = curl_init();
$user=$row_smsdb['userid'].":".$row_smsdb['password'];
$receipientno=$mobile;
$senderID=trim($row_smsdb['sendid']);
$msgtxt=$strmsg;
curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
$buffer = curl_exec($ch);
if(empty ($buffer))
{ 
return 0;
 }
else
{ 
return 1;
 }
curl_close($ch);
mysql_free_result($smsdb);
}

function sms_func1($receipientno,$msgtxt,$selectid)
{
	 
//include('RedZeus.php'); 
$mobile=$receipientno; 
$strmsg=$msgtxt;

$smsdb = $conn->prepare("SELECT * FROM setting_sms WHERE sno =?");
$smsdb->execute(array($selectid));
$row_smsdb = $smsdb->fetch(PDO::FETCH_ASSOC);
$totalRows_smsdb = $smsdb->rowCount();

$ch = curl_init();
$user=$row_smsdb['userid'].":".$row_smsdb['password'];
$admin=$row_smsdb['adminid'];
$receipientno=$mobile;

$senderID=$row_smsdb['sendid']; 
$msgtxt=$strmsg;
curl_setopt($ch,CURLOPT_URL,  "http://".$row_smsdb['ipadd']."/api/MessageCompose");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS,"admin=$admin&user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt&state=0");
$buffer = curl_exec($ch);
if(empty ($buffer))
{ 
return 0; }
else
{ 
return 1; }
curl_close($ch);
mysql_free_result($smsdb);
}


function send_mail($mailid,$sender,$sub,$content){
		ini_set('sendmail_from', 'user@domain.com'); 
        $to = $mailid; 
		//$to = $response[BillingEmail]; 
        $from =$sender; 
       $subject=$sub; 
$stringData=$content;
		
		if(@mail($to,$subject,$stringData,"From:$from\r\nReply-to: $from\r\nContent-type: text/html; charset=us-ascii") ) {
         
          return 1; 
         //setcookie("mailsuc1",1, time()+3600);
        }
        else { 
        
        return 1; 
         
        }	
}
/*-------------------Mvaayoo Configuration End------------------------*/
?>
