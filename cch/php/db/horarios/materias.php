<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Generador de Tabla de Materias</title>
	
</head>

<body>
<?php
#
#  Lee un archivo de datos separados por comas con los siguientes datos por renglon
#
#  Grupo, Asignatura, idProfesor, Profesor,	Horarios
#

setlocale(LC_ALL, 'en_US.UTF-8');
include('../../conf/dbconfig.php');

#$depurar = 'true' ;

$archivo = 'horarios.csv';
$cicloescolar = '2009-2';

$select = "SELECT idCicloEscolar FROM CicloEscolar WHERE Ciclo = '$cicloescolar'";
$result = $dbconn->Execute($select);
$idCicloEscolar = $result->fields[0];

$campos = array('GRUPO','ASIGNATURA','IDPROFESOR','PROFESOR','HORARIOS');
$dias = array('1' => 'Lunes', '2' => 'Martes', '3' => 'Miercoles', '4' => 'Jueves', '5' => 'Viernes' ,'6' => 'Sabado', '7' => 'Domingo' );

$renglon = 1;
$handle = fopen($archivo, "r");
echo 'USE Asistencia<br />';
echo 'GO <br />';
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);
    //echo "<h3>DATOS</h3>";
    //echo "<p> $num campos en el renglon $renglon: <br /></p>\n";
    $renglon++;
    for ($c=0; $c < $num; $c++) {
        //echo "<em>".$campos[$c]." : </em>".$data[$c] . "<br />\n";
        if ($c == 1) $idMateria = trim($data[$c]);
        if ($c == 2) $idProfesor = trim($data[$c]);
        if ($c == 3) $Nombre = trim($data[$c]);
        if ($c == 4) 
          {
            $clases = trim($data[$c]);
            
            $materias = str_split($clases,7);
            
            $numclases = count($materias);
            //echo "CLASES ASIGNADAS : $numclases <br />";
                for ($d=0; $d < $numclases ; $d++) {
                    $clase = trim($materias[$d]);
                    //echo "<em>CLASE ".($d+1)." : </em> $clase <br />";
                    
                    $Edificio = substr($clase,0,1);
                    $Salon = trim(substr($clase,1,2));
                    if (!is_numeric($Salon))
                        {
                         $Edificio = $Edificio.$Salon;
                         $Salon = '1';
                        } 
                    $Hora = ltrim(substr($clase,3,2),'0').":00";
                    $Dia = $dias[substr($clase,5,1)];
                    
                    //echo "Edifico : $Edificio , Salon : $Salon, Hora : $Hora, Dia : $Dia </br>";
                    
                    $select1 = "SELECT idSalon FROM EdificioSalon WHERE Edificio = '".$Edificio."' AND Salon = '".$Salon."' ";
                    $result = $dbconn->Execute($select1);
                    $idSalon=$result->fields[0];
                    $select2 = "SELECT idHorario FROM Horario WHERE Horario = '".$Hora."'";
                    $result = $dbconn->Execute($select2);
                    $idHorario=$result->fields[0];
                    $select3 = "SELECT idDia FROM Dia WHERE Dia = '".$Dia."'";
                    $result = $dbconn->Execute($select3);
                    $idDia=$result->fields[0];
                    $sel[$d] = "SELECT COUNT(*) FROM ProfesorSalon WHERE idSalon = $idSalon AND idProfesor = $idProfesor AND idHorario = $idHorario AND idDia = $idDia";
                    //$insert[$d] = "INSERT INTO ProfesorSalon (idSalon,idProfesor,idCicloEscolar,idHorario,idDia) "
                    //              ." VALUES ($idSalon,$idProfesor,$idCicloEscolar,$idHorario,$idDia) "; 
                    if ($idSalon == '')  $update[$d] = '';
                    else 
                       $update[$d] = "UPDATE ProfesorSalon SET idMateria = ".$idMateria
                                  ." WHERE idSalon = ".$idSalon
                                  ." AND idProfesor = ".$idProfesor
                                  ." AND idCicloEscolar = ".$idCicloEscolar
                                  ." AND idHorario = ".$idHorario
                                  ." AND idDia = ".$idDia;
                            
                                  
                    
                }
         
          }    
        
    }
    $checamateria ="SELECT COUNT(*) FROM Materia WHERE idMateria =".$idMateria;
    $insertamateria = "INSERT INTO Materia (idMateria) VALUES (".$idMateria.")";
    //$checaprofesor = "SELECT COUNT(*) FROM Profesor WHERE idProfesor = ".$idProfesor." AND Nombre = '".$Nombre."'";
    //$insertaprofesor = "INSERT INTO Profesor (idProfesor,Nombre) VALUES (".$idProfesor.",'".$Nombre."')";
    
    //echo "<h3>SQL</h3>"; 
    echo "Renglon = ".$renglon."</br>";
    echo "IF (".$checamateria.") = 0<br />";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;".$insertamateria."<br />";
    echo 'GO <br />';
    //echo "IF (".$checaprofesor.") = 0<br />";
    //echo "&nbsp;&nbsp;&nbsp;&nbsp;".$insertaprofesor."<br />";
    //echo 'GO <br />';
    if (!$depurar) 
      {
        $resultado = $dbconn->Execute($checamateria);
        if ($resultado->fields[0] == 0)
            $result = $dbconn->Execute($insertamateria);
        
        //$resultado = $dbconn->Execute($checaprofesor);
        //if ($resultado->fields[0] == 0)
        //    $result = $dbconn->Execute($insertaprofesor);
      }
    
    
    //$numinserts = count($insert);
    $numupdates = count($update);
    for ($i=0; $i < $numupdates; $i++) 
      {
        echo "IF (".$sel[$i].") = 0<br />";
        //echo "&nbsp;&nbsp;&nbsp;&nbsp;".$insert[$i]."<br />";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;".$update[$i]."<br />";
        echo 'GO <br />';
        if (!$depurar) 
          {
            //$rs = $dbconn->Execute($sel[$i]);
            //if ($rs->fields[0] == 0)
                //$resultado = $dbconn->Execute($insert[$i]); 
                if ($update[$i] != '')
                    $resultado = $dbconn->Execute($update[$i]);   
          }
     }
}
fclose($handle);
echo "Finalizado!";
?>
</body>