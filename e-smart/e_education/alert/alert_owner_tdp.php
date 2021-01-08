<?php

  /*$AuthenReq = $resultSQL['Authentication'];
  $Arr_Access = array("6", "9");
  
  if(isset($SesUserID) && trim($SesUserID) != NULL){
      if(!in_array($Authen, $Arr_Access)){
          header("Location:index.php");
          exit();
      }
  }*/
  

  $Arr_SesUserID = array('10766', '10763', '10013', '11399', '10143', '10676', '10084', '10399', '10009', '11074', '11130', '11374');
  
  if(isset($SesUserID) && trim($SesUserID) != NULL){
      if(!in_array($SesUserID, $Arr_SesUserID)){
          header("Location:index.php");
          exit();
      }
  }


?>
