<?php
if (isset($_REQUEST['rondin']))
  {               
     include_once('../php/conf/dbconfig.php');  
     
     $update = "UPDATE Rondin set status = 'S' where idRondin =".$_REQUEST['rondin'];
     $rs = $dbconn->Execute($update);   
     
     echo "El rondin ".$_REQUEST['rondin']." se ha cerrado con exito.";
      
  }
else echo "Error";
?>