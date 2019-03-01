<?php
session_start();
require_once('../Connections/divdb.php');

$agentpro = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$agentpro->execute(array($_SESSION['uid']));
$row_agentpro = $agentpro->fetch(PDO::FETCH_ASSOC);
$totalRows_agentpro = $agentpro->rowCount();

$session_id='1'; //$session id
$path = "../img_upload/agent_img/logo/";

		$valid_formats = array("jpg", "png", "gif", "bmp");
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			/*$files = glob('../img_upload/agent_img/logo/*'); // get all file names
			foreach($files as $file)
			{
				if(is_file($file))
				unlink($file); // delete file
			}*/
			
			$files = '../img_upload/agent_img/logo/'.$row_agentpro['comp_logo'];
			unlink($files);
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(1024*1024))
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
									
									$update_logo=$conn->prepare("UPDATE agent_pro SET comp_logo=? WHERE agent_id =?");
									$update_logo->execute(array($actual_image_name,$_SESSION['uid']));
									
									echo "<img src='img_upload/agent_img/logo/".$actual_image_name."'  class='preview' width='100px' height='100px'>";
									echo "<script>parent.location.reload();</script>";
									
								}
							else
								echo "failed";
						}
						else
						echo "Image file size max 1 MB";					
						}
						else
						echo "Invalid file format..";	
				}
				
			else
				echo "Please select image..!";
				
			exit;
		}
?>