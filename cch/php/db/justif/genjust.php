<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Generador de SQL para migrar tabla de Justificantes</title>
	
</head>

<body>
<?php
setlocale(LC_ALL, 'en_US.UTF-8');
include('../../conf/dbconfig.php');

# Seleccionar idRondin,FechaHora de la tabla Rondin 
$select = "SELECT idJustificante,idProfesor,idCicloEscolar,CONVERT(VARCHAR(20),FechaAlta, 120),idJustificacion FROM Justificante ORDER BY idJustificante";
$rs = $dbconn->Execute($select);  
foreach ($rs as $k => $row)
{    
  $fecha = strftime('%Y-%m-$d %H:%M:%S',strtotime($row[3]));  
  echo "INSERT INTO Justificante VALUES (".$row[0].",".$row[1].",".$row[2].",'".$fecha."',".$row[4].");";
  echo "<br />";   
}    



?>
</body>
