<?php

  $AuthenReq = $resultSQL['Authentication'];

  $Arr_Access = array("9");

  if(isset($SesUserID) && trim($SesUserID) != NULL){
      if(!in_array($AuthenReq, $Arr_Access)){
        echo "<script type=text/javascript>javascript:history.back(1);</script>";
        exit();
      }
  }else {
    header("Location:../index.php");
    exit();
  }

?>
