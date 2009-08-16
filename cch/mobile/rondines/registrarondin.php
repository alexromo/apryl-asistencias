<?php
if (!isset($_REQUEST['encargado']))
{ 
    echo $_SESSION['hora'];     
?>
<form method="post" action="rondines.php?seccion=registrarondin" name="altarondines">
<fieldset>
<legend>Alta de Rondines</legend>
<label for="encargado">Encargado :</label> 
<input type="text" name="encargado" value="<?php echo $_SESSION['nombre']; ?>" id="encargado" readonly="readonly" />
<input type="submit" value="Registra Rond&iacute;n" name="altarondin"  />
<div id="status"></div>
</fieldset>
</form>
<?php
}
else
{
        include('../php/conf/dbconfig.php');
        
        #
        # Determina idCicloEscolar con la Fecha Actual del Sisitema
        #
        
        
        $day = date('N'); 
        $diasemana = date('w');
        $fecha = date('Y-m-d');
        $solofecha = date('Y-m-d H');
         
        $_SESSION['dia'] = $day; 
        $_SESSION['diasemana'] = $diasemana;
        $_SESSION['solofecha'] = $solofecha;
         
        $select = "SELECT idCicloEscolar,Ciclo FROM CicloEscolar WHERE ('".$fecha."' BETWEEN inicio AND fin )";
        $rs = $dbconn->Execute($select);

        if (!$rs->fields) echo "No existe el ciclo escolar contactar al Administrador.";
        else 
            {
             $idCicloEscolar = $rs->fields[0];         
             $_SESSION['ceid'] = $rs->fields[0];
             $cicloescolar =  $rs->fields[1]; 
             $_SESSION['ciclo'] = $rs->fields[1];
            }
            
        #
        # Determina si se registra el rondin en un horario valido
        # 
       
        $select = "SELECT idHorario FROM Horario WHERE Horario ='".$_SESSION['hora']."'";
    	$rs = $dbconn->Execute($select);
    	$select = "SELECT * FROM Rondin WHERE FechaHora LIKE '".$solofecha."%'";
    	$rs1 = $dbconn->Execute($select);

    	if (!$rs->fields) echo "No hay clases a esta hora,contactar al Administrador.";
    	if ($rs1->fields) echo "Ya hay un rondin capturado para esta fecha y hora.";
    	else
    	  {  
    	    $hrid = $rs->fields[0];  
    	    $_SESSION['hrid'] = $hrid;   
            $select = "SELECT COUNT(*) FROM Rondin WHERE idEncargado=".$_SESSION['uid']." AND status ='N'";
            $result = $dbconn->Execute($select);
            if ($result->fields[0] == 0)
                { 
                    $insert="INSERT INTO Rondin (idEncargado,FechaHora,status,idCicloEscolar) VALUES (".$_SESSION['uid'].",CURRENT_TIMESTAMP,'N',".$idCicloEscolar.")";
                    $result=$dbconn->Execute($insert);
                }     
  
            
	        $query = "SELECT idRondin FROM Rondin WHERE idEncargado = ".$_SESSION['uid']." AND status = 'N' AND idCicloEscolar = ".$idCicloEscolar;
	        $result = $dbconn->Execute($query); 
	        
	        $_SESSION['rondin'] =  $result->fields[0];	
	           
            
            // Registrar asistencia a todos en este dia y horario
            
            $select = "SELECT idProfesorSalon, idSalon,idProfesor FROM ProfesorSalon WHERE"
                       ." idCicloEscolar =".$idCicloEscolar
                       ." AND idHorario =".$hrid
                       ." AND idDia =".$day
                       ." AND idProfesor NOT IN (0,24,861)";
            $rs = $dbconn->Execute($select);
            
            foreach ($rs as $k => $row)
            {   
                // Busca algun Justificante de Falta
                $sel = "SELECT idJustificante FROM FaltasJustificadas WHERE idProfesorSalon = ".$row[0]." AND Fecha = '".$fecha."'";
                $res = $dbconn->Execute($sel);
                if ($res->fields)
                    {
                       $idJustificacion = $res->fields[0];
                       $idStatus = 2;
                    }
                else
                    {
                        $idJustificacion = 0;
                        $idStatus = 1;
                    }
               
                
                $insert = "INSERT INTO AsistenciaProfesores (idRondin,FechaHora,idStatus,idSalon,idJustificacion,idObservacion,Capturado,idProfesor,idProfesorSalon) VALUES (".$_SESSION['rondin'].",'".$solofecha.":00:00',".$idStatus.", ".$row[1].",".$idJustificacion." ,0, 0, ".$row[2].",".$row[0].")";
                $result = $dbconn->Execute($insert);              
            }
    	
?>

<form method="post" name="captura_rondin" action="rondines.php?seccion=capturarondin&amp;rondin=<?php echo $_SESSION['rondin']; ?>">
<fieldset>
<legend>Alta de Rondines</legend>
<label for="rondin1">Rondin :</label>    
<input type="text" name="rondin1" value="<?php echo $_SESSION['rondin']; ?>" id="rondin1" size="6" readonly="readonly" />   
<input type="submit" value="Captura Rond&iacute;n" name="btn_captrondin"  />
<div id="status"></div>
</fieldset>
</form>
<?php
   }
}
?>
