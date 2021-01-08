<?php

  $AuthenReq = $resultSQL['Authentication'];
  $AuthenQlo = $QloResult['Authentication'];

  $Arr_AccessQlo = array("4", "6", "9");

  if(isset($SesUserID) && trim($SesUserID) != NULL){
      if(!in_array($AuthenQlo, $Arr_AccessQlo)){
          header("Location:index.php");
          exit();
      }
  }

?>
