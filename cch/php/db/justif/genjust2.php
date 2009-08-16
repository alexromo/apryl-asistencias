<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Generador de SQL para migrar tabla de FaltasJustificadas</title>
	
</head>

<body>
<?php
setlocale(LC_ALL, 'en_US.UTF-8');
include('../../conf/dbconfig.php');


$select = "SELECT idFaltasJustificadas,idJustificante,idProfesorSalon,CONVERT(VARCHAR(20),Fecha, 120) FROM FaltasJustificadas ORDER BY idFaltasJustificadas";
$rs = $dbconn->Execute($select);  
foreach ($rs as $k => $row)
{    
  $fecha = strftime('%Y-%m-$d %H:%M:%S',strtotime($row[3]));  
  echo "INSERT INTO Justificante VALUES (".$row[0].",".$row[1].",".$row[2].",'".$fecha.");";
  echo "<br />";   
}    



?>
</body>
