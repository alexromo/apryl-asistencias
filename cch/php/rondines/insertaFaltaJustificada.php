<?php
#
# idjustificante,Fecha,idProfesorSalon
#


 if ( (!isset($_REQUEST['justificante'])) && (!isset($_REQUEST['fecha'])) && (!isset($_REQUEST['psalon'])) )
 {	
  echo '<span class="error">Error</span>';
 }
 else
 {   
     include('../conf/dbconfig.php');	
	 
	 $fecha = explode('/',$_REQUEST['fecha']); 
	 $date = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
	 $datetime = $date.' 00:00:00';       
	 
	 
	 // inserta justificante en la tabla de asistencia (AsistenciaProfesores) en caso de que ya hubiera un rondin 
	 // que haya capturado la falta
	 
	 $select = "SELECT hr.Horario, ps.idSalon"
               ." FROM ProfesorSalon ps, Horario hr"
               ." WHERE ps.idProfesorSalon =".$_REQUEST['psalon'] 
               ." AND ps.idHorario = hr.idHorario"; 
     $result = $dbconn->Execute($select);
     if ($result->fields)
        {
            
            $Horario = $result->fields[0];
            $idSalon = $result->fields[1];
            
            $Hora = explode(':',$Horario);
            $solohora = ($Hora[0] < 10)?'0'.$Hora[0]:$Hora[0];
            
            $FechaHoraAsistencia = $date.' '.$solohora;   
            
            $select = "SELECT idAsistencia FROM AsistenciaProfesores"
                     ." WHERE FechaHora LIKE '".$FechaHoraAsistencia."%'"
                     ." AND idSalon =".$idSalon
                     ." AND idJustificacion = 0";
                     
            $res = $dbconn->Execute($select);
            
            if ($res->fields)
                {
                    $idAsistencia = $res->fields[0];
                    $update = "UPDATE AsistenciaProfesores SET idStatus = 2 ,idJustificacion = ".$_REQUEST['justificante']." WHERE idAsistencia = ".$idAsistencia;
                    echo $update;
                    $res = $dbconn->Execute($update); 
                }
            
        }
               
	 // Inserta las Faltas Justificadas
	 
	 $select = "SELECT COUNT(*) " 
              ." FROM FaltasJustificadas " 
              ." WHERE idJustificante = ".$_REQUEST['justificante']
              ." AND idProfesorSalon = ".$_REQUEST['psalon']
              ." AND Fecha = '".$datetime."'";
     $result = $dbconn->Execute($select);
      
     if ($result->fields[0] == 0)
       {
        $insert = "INSERT INTO FaltasJustificadas (idJustificante,idProfesorSalon,Fecha) VALUES (".$_REQUEST['justificante'].",".$_REQUEST['psalon'].",'".$datetime."')";
        $result = $dbconn->Execute($insert);    
       }
}  
?>