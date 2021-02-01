<?php
	
  $AuthenIDReq = $resultSQL['Authentication'];

  if(trim($AuthenIDReq) == 9) {
	  
  }else {
      echo "<script type=text/javascript>alert('Only the Administrator!');javascript:history.back(1);</script>";
      exit();
  }
?>
