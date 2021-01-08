<?php

  $AuthenReq = $resultSQL['Authentication'];
  $Arr_AccessQlo = array("2", "3", "4", "6", "9");

  if(isset($SesUserID) && trim($SesUserID) != NULL){
      if(!in_array($AuthenReq, $Arr_AccessQlo)){
          header("Location:index.php");
          exit();
      }
  }

?>
