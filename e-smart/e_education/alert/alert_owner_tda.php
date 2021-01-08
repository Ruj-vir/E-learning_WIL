<?php

  /*$AuthenReq = $resultSQL['Authentication'];
  $Arr_Access = array("6", "9");
  
  if(isset($SesUserID) && trim($SesUserID) != NULL){
      if(!in_array($Authen, $Arr_Access)){
          header("Location:index.php");
          exit();
      }
  }*/
  

  $Arr_SesUserID = array('10164', '10082', '10007', '10072', '11393', '10645', '10406', '10037', '10076', '10659',
  '10032', '10972', '10730', '10923', '10394', '10009', '10167', '10686', '10705', '11297', '10627', '11130', '11374');
  
  if(isset($SesUserID) && trim($SesUserID) != NULL){
      if(!in_array($SesUserID, $Arr_SesUserID)){
          header("Location:index.php");
          exit();
      }
  }


?>
