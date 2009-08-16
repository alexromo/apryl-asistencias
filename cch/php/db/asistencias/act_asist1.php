<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Generador de SQL para Actualizar Tabla AsistenciaProfesores con el idProfesor</title>
	
</head>

<body>    
<?php
setlocale(LC_ALL, 'en_US.UTF-8');
include('../../conf/dbconfig.php');

#$depurar = 'true' ;
 
 

echo '<form name="forma1" method="post" action="'.$_SERVER['PHP_SELF'].'">';
$selectrd = "SELECT idRondin FROM Rondin ORDER BY idRondin";
     
$rsrd = $dbconn->Execute($selectrd);  
echo '<select name="rondin">';
foreach ($rsrd as $k => $row)
      {
        echo '<option value="'.$row[0].'">'.$row[0].'</option>';
      }   
echo '</select>'; 
echo '<input type="submit" value="Generar INSERTs" />';
echo '</form>'; 
   
if (isset($_POST['rondin']))
{


# Seleccionar idRondin,FechaHora de la tabla Rondin 
 if ($db == 'mysql')
     $selectrd = "SELECT FechaHora FROM Rondin WHERE idRondin = ".$_POST['rondin'];
 if ($db == 'ado_mssql')
   {
     $selectrd = "SELECT CONVERT(VARCHAR(20), FechaHora, 100) FROM Rondin WHERE idRondin = ".$_POST['rondin'];
     if ($depurar)
       {
           echo 'USE Asistencia<br />';
           echo 'GO <br />';
       }
   }
 $rsrd = $dbconn->Execute($selectrd);

 
 
    # idRondin
    $idRondin = $_POST['rondin'];
    echo '<h3> Rondin '.$idRondin.'.</h3>';
    
    # Calcular varios datos relacionados con la Fecha y Hora del Rondin
    
    $time = strtotime($rsrd->fields[0]);
    $day = date('N',$time);
    $hora = date('G',$time).':00'; 
    $year = date('Y',$time);
    $month = date('m',$time);
    $semestre = ($month <= 6)?'2':'1'; 
    
    
    # Buscar el Ciclo Escolar de ese Rondin
    
    $cicloescolar = $year.'-'.$semestre; 
    echo 'Ciclo Escolar: '.$cicloescolar.'<br />'; 
    $selectce = "SELECT idCicloEscolar FROM CicloEscolar WHERE Ciclo ='".$cicloescolar."'";
    $rsce = $dbconn->Execute($selectce);
    $idCicloEscolar = $rsce->fields[0];
    echo 'idCicloEscolar: '.$idCicloEscolar.'<br />'; 
    # Buscar el idHorario de ese Rondin
    
    $selecthr = "SELECT idHorario FROM Horario WHERE Horario = '".$hora."'";
    $rshr = $dbconn->Execute($selecthr);
    $idHorario = $rshr->fields[0];
    echo 'idHorario: '.$idHorario.'<br />'; 
    # Buscar el idDia de ese Rondin
    
    $idDia = $day;
    echo 'idDia: '.$idDia.'<br />'; 
    
    $selectap = "SELECT idSalon,idProfesor FROM AsistenciaProfesores WHERE idRondin = ".$idRondin; 
    echo $selectap.'<br />'; 
    $rsap = $dbconn->Execute($selectap);
    foreach ($rsap as $k => $row1)
    {
        $idSalon = $row1[0];
        $idProfesorActual = $row1[1]; 
        $selectps ="SELECT idProfesor"
                  ." FROM ProfesorSalon"
                  ." WHERE idSalon = ".$idSalon
                  ." AND idCicloEscolar = ".$idCicloEscolar
                  ." AND idHorario = ".$idHorario
                  ." AND idDia = ".$idDia;
        echo '{'.($k+1).'} '.$selectps.'<br />';         
        $rsps = $dbconn->Execute($selectps);
        if ($rsps->fields)
        {
          #echo  $selectps.'<br />';     
          $idProfesor = $rsps->fields[0];
           echo '<b>idProfesor (Actual): '.$rsps->fields[0].'</b><br />'; 
           echo '<b>idProfesor (calculado): '.$rsps->fields[0].'</b><br />';
          $updateap = "UPDATE AsistenciaProfesores SET idProfesor = ".$idProfesor." WHERE idRondin = ".$idRondin." AND idSalon = ".$idSalon;
          //if (!$depurar) $rsupdt = $dbconn->Execute($updateap);
          
          echo '['.($k+1).'] '.$updateap.'<br />';
          echo 'GO <br />';
         }            
    }    
  
}
?>
</body>