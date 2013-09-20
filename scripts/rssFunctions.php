<?php

  $url=$_GET["url"];  

  function requestRSS($rssSource){
    $rssXmlObj = new DOMDocument();  
    $rssXmlObj->load($rssSource);

    $rssItems = $rssXmlObj->getElementsByTagName('item');

    for($i=5; $i!=0; $i--){
      $item_title = $rssItems->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue; 
      $item_link = $rssItems->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue; 
      $item_descrip = $rssItems->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue; 

      echo "</br>" . $item_title;
      echo "<a href='$item_link'>Link</a>";  
      echo "</br>" . $item_descrip;
    }
    
  }

  requestRSS($url);
  
?>
