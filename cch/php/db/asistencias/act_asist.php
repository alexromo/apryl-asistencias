<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Generador de SQL para Actualizar Tabla AsistenciaProfesores con el idProfesorSalon</title>
	
</head>

<body>
<?php
setlocale(LC_ALL, 'en_US.UTF-8');
include('../../conf/dbconfig.php');

#$depurar = 'true' ;

# Seleccionar idRondin,FechaHora de la tabla Rondin 

if ($db == 'mysql')
    $selectrd = "SELECT idRondin,FechaHora FROM Rondin ORDER BY idRondin";
if ($db == 'ado_mssql')
   {
     $selectrd = "SELECT idRondin, CONVERT(VARCHAR(20), FechaHora, 120) FROM Rondin ORDER BY idRondin";
     if ($depurar)
       {
           echo 'USE Asistencia<br />';
           echo 'GO <br />';
       }
   }
$rsrd = $dbconn->Execute($selectrd);

foreach ($rsrd as $k => $row)
{
    # idRondin
    $idRondin = $row[0];
    
    # Calcular varios datos relacionados con la Fecha y Hora del Rondin
    
    $time = strtotime($row[1]);
    $day = date('N',$time);
    $hora = date('G',$time).':00'; 
    $year = date('Y',$time);
    $month = date('m',$time);
    $semestre = ($month <= 6)?'2':'1';  
    
    # Buscar el Ciclo Escolar de ese Rondin
    
    $cicloescolar = $year.'-'.$semestre;
    $selectce = "SELECT idCicloEscolar FROM CicloEscolar WHERE Ciclo ='".$cicloescolar."'";
    $rsce = $dbconn->Execute($selectce);
    $idCicloEscolar = $rsce->fields[0];
    
    # Buscar el idHorario de ese Rondin
    
    $selecthr = "SELECT idHorario FROM Horario WHERE Horario = '".$hora."'";
    $rshr = $dbconn->Execute($selecthr);
    $idHorario = $rshr->fields[0];
    
    # Buscar el idDia de ese Rondin
    
    $idDia = $day;
    
    
    $selectap = "SELECT idSalon FROM AsistenciaProfesores WHERE idRondin = ".$idRondin;
    $rsap = $dbconn->Execute($selectap);
    foreach ($rsap as $k => $row1)
    {
        $idSalon = $row1[0]; 
        $selectps ="SELECT idProfesorSalon "
                  ."FROM ProfesorSalon"
                  ." WHERE idSalon = ".$idSalon
                  ." AND idCicloEscolar = ".$idCicloEscolar
                  ." AND idHorario = ".$idHorario
                  ." AND idDia = ".$idDia;
                 
        $rsps = $dbconn->Execute($selectps);
        if ($rsps->fields)
        {
          #echo  $selectps.'<br />';     
          $idProfesorSalon = $rsps->fields[0];
        
          $updateap = "UPDATE AsistenciaProfesores SET idProfesorSalon = ".$idProfesorSalon." WHERE idRondin = ".$idRondin." AND idSalon = ".$idSalon;
          if (!$depurar) $rsupdt = $dbconn->Execute($updateap);
          
          echo $updateap.'<br />';
          echo 'GO <br />';
         }            
    }
                
    
    
    
     
}
?>
</body>