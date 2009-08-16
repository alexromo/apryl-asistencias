<?php
#
# idrondin,idsalon,idstatus
#


 if (!isset($_REQUEST['status']))
 {	
  echo '<span class="error">-></span>';
 }
 else
 {   
     include('../conf/dbconfig.php');	
	 
	 $select = "SELECT COUNT(*) FROM AsistenciaProfesores WHERE idRondin = ".$_REQUEST['rondin']." AND idSalon =".$_REQUEST['salon'];
     $result = $dbconn->Execute($select);
      
     if ($result->fields[0] == 0)
       {
        $insert = "INSERT INTO AsistenciaProfesores (idRondin,FechaHora,idStatus,idSalon,idJustificacion) VALUES (".$_REQUEST['rondin'].",CURRENT_TIMESTAMP,".$_REQUEST['status'].",".$_REQUEST['salon'].",0)";
        $result = $dbconn->Execute($insert);
       }
     else
		  {
			$update = "UPDATE AsistenciaProfesores SET idStatus = ".$_REQUEST['status']." WHERE idRondin = ".$_REQUEST['rondin']." AND idSalon = ".$_REQUEST['salon'];
	        $result = $dbconn->Execute($update);
		  }    
        
        echo '<span class="exito">'.$date('d/m/Y H:i').'</span>';
       }
}  
?>
