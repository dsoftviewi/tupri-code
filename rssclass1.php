<?php
 class rss {
     var $feed;
  function rss($feed) 
  {
    $this->feed = $feed;
  }

  function parse() 
  {
	  
	  function get_data($url) {

		  
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
 $returned_content = get_data('http://feeds.feedburner.com/latestnewsdvi');
	  
	  $rss = simplexml_load_string($returned_content);

	 
	//  ini_set('allow_url_fopen', 'on');
	  //$feed = file_get_contents('http://feeds.feedburner.com/gov/Dkbh');
   /// $rss = simplexml_load_file($this->feed);
	//    $rss = simplexml_load_file($this->feed);



    $rss_split = array();

    foreach ($rss as $item) {
      $title = (string) $item->title; // Title
      $link   = (string) $item->link; // Url Link
   	  $description = (string) $item->description; //Description
     	  
      $rss_split[] = '

          <div>
        <a href="'.$link.'" target="_blank" title="" >
            '.$title.' 
        </a>
			<hr>
          </div>
';
    }

    return $rss_split;
  }



  function display($numrows,$head) 
  {
    $rss_split = $this->parse();
    $i = 0;
    $rss_data = '
			 <div class="vas">
           <div class="title-head">
         '.$head.'
           </div>
         <div class="feeds-links">';

    while ( $i < $numrows ) 
	{
      $rss_data .= $rss_split[$i];
      $i++;
    }
    $trim = str_replace('', '',$this->feed);
    $user = str_replace('&lang=en-us&format=rss_200','',$trim);
    
	
	$rss_data.='</div></div>';
    
    return $rss_data;
  }
}
?>