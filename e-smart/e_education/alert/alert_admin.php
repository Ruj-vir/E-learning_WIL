<?php

  $AuthenReq = $resultSQL['Authentication'];

  $Arr_Access = array("9");

  if(isset($SesUserID) && trim($SesUserID) != NULL){
      if(!in_array($AuthenReq, $Arr_Access)){
          header("Location:index.php");
          exit();
      }
  }

?>
