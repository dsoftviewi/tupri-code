<?php
require_once('../../Connections/divdb.php');
$getimg = $_GET['cluster'];
?>
<div class="photo-gallery" id="photo-gallery1" data-animation="slide" data-sync="#image-carousel1">
    <ul class="slides">
    <?php
	//foreach($getimg as $img)
	{
	?>
        <li><img src="packages/images/<?php echo $getimg; ?>" alt="" width="500px" height="500px" /></li>
     <?php
	}
	?>
    </ul>
</div>