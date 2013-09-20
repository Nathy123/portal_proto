<?php

  function parseFile($filePath) {
         $homep_content = fopen($filePath, "r");
         while(($line=fgets($homep_content)) != FALSE )
           echo $line;
  }


?>
