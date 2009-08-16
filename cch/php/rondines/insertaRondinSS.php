<?php
 if ( (!isset($_REQUEST['encargado'])) || $_REQUEST['encargado'] == '0')
 {	
  echo '<span class="error">Seleccione un Encargado e intente de nuevo.</span>';
 }
 else
 {   
     include('../conf/dbconfig.php');
  	 
  	 $hora = date('G').':00';
     $select = "SELECT idHorario FROM Horario WHERE Horario ='".$hora."'";
 	 $rs = $dbconn->Execute($select);
  	 
  	 if (!$rs->fields) echo "<span class="error">No hay clases a esta hora,contactar al Administrador.</span>";
 	 else
 	  {  
 	    $hrid = $rs->fields[0];	 	
	    $select = "SELECT COUNT(*) FROM Rondin"
	            ." WHERE idEncargado =".$_REQUEST['encargado']
	            ." AND status = 'N'";
 	    $rs = $dbconn->Execute($select);
        if ($rs->fields[0] >= 1)
            {
                echo '<span class="error">El encargado tiene un rondin registrado sin finalizar.</span>';
            }
 	    else
            {
      
                $insert = "INSERT INTO Rondin (idEncargado,FechaHora,status) VALUES (".$_REQUEST['encargado'].",CURRENT_TIMESTAMP,'N')";
                $dbconn->Execute($insert);      

                $query = "SELECT idRondin,FechaHora FROM Rondin WHERE idEncargado = ".$_SESSION['uid']." AND status = 'N'";
    	        $result = $dbconn->Execute($query);
    	        $_SESSION['rondin'] =  $result->fields[0];
         
                $time = strtotime($result->fields[1]);
                $day = date('N',$time);
                $hora = date('G',$time).':00'; 
                $diasemana = date('w',$time);
                $year = date('Y',$time);
    	        $month = date('m',$time);
    	        $semestre = ($month <= 6)?'2':'1';
                $cicloescolar = $year.'-'.$semestre;

        
    	        $_SESSION['ciclo'] = $SESSION_CICLO;
                $_SESSION['dia'] = $SESSION_DIA;
                $_SESSION['hora'] = $SESSION_HORA;
                $_SESSION['diasemana'] = $diasemana;
                $select = "SELECT idHorario FROM Horario WHERE Horario ='".$hora."'";
                $rs = $dbconn->Execute($select);

                if (!$rs->fields) echo "No hay clases a esta hora,contactar al Administrador.";
                else 
        	        {
        		        $_SESSION['hrid'] = $hrid; 
        	        }
         
                $select = "SELECT idCicloEscolar FROM CicloEscolar WHERE Ciclo ='".$cicloescolar."'";
                $rs = $dbconn->Execute($select);

                if (!$rs->fields) 
                    {
                        echo "No existe el ciclo escolar contactar al Administrador.";
                    }    
                else 
                    {
        		        $_SESSION['ceid'] = $rs->fields[0];  
                    }
               

                // Registrar asistencia a todos en este dia y horario

                $select = "SELECT idSalon FROM ProfesorSalon WHERE"
                       ." idCicloEscolar =".$rs->fields[0]
                       ." AND idHorario =".$hrid
                       ." AND idDia =".$day
                       ." AND idProfesor NOT IN (0,24,861)";
                $rs = $dbconn->Execute($select);
                foreach ($rs as $k => $row)
                    {
                        $insert = "INSERT INTO AsistenciaProfesores (idRondin,FechaHora,idStatus,idSalon,idJustificacion,idObservacion,Capturado) VALUES (".$_SESSION['rondin'].",CURRENT_TIMESTAMP,1 ,".$row[0].",0 ,0, 0 )";
                        $result = $dbconn->Execute($insert);              
                    }		
                echo '<span class="exito">Rond&iacute;n Registrado con exito</span>';
      }
 }  
?>