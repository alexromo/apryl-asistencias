<?php
# 
# Configuracion del conexion a la base de datos
#

include_once("adodb/adodb.inc.php");

#
# Tipo de Base de Datos. Solo implementadas MySQL y ADO MSSQL
#

$db = 'mysql';

//$driver = 'mysql'; $host = 'localhost'; $user = 'asistdbuser'; $pwd = 'asistencia'; $database = 'asistencia';
//ADOdb_Session::config($driver, $host, $user, $pwd, $database,$options=false);

if ($db == 'mysql')
     {
         $driver = $db; $host = 'localhost'; $user = 'asistdbuser'; $pwd = 'asistencia'; $database = 'asistencia';
         ADOdb_Session::config($driver, $host, $user, $pwd, $database,$options=false);
     }
if ($db == 'ado_mssql')
	{
	    $driver = $db; $host = 'localhost'; $user = 'sa'; $pwd = '456789'; $database = 'Asistencia';
         ADOdb_Session::config($driver, $host, $user, $pwd, $database,$options=false);
		//$myDSN="PROVIDER=MSDASQL;DRIVER={SQL Server};"
		//. "SERVER=APRYL_REAL;DATABASE=Asistencia;UID=sa;PWD=456789;"  ;
	}	 

?>
