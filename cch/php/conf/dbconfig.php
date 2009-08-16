<?php
# 
# Configuracion del conexion a la base de datos
#
include_once("adodb/adodb-exceptions.inc.php");
include_once("adodb/adodb.inc.php");


#
# Tipo de Base de Datos. Solo implementadas MySQL y ADO MSSQL
#
 


$db = 'mysql';
$base = 'asistencia';


try 
   {     
       $dbconn = NewADOConnection($db);
       if ($db == 'mysql')
         {
	       $dbconn->PConnect('localhost','asistdbuser','asistencia',$base);    
	       $query = $dbconn->Execute("SET NAMES 'utf8'"); 
	     } 
       if ($db == 'ado_mssql')
	     {
		    $myDSN="PROVIDER=MSDASQL;DRIVER={SQL Server};"
		        . "SERVER=APRYL_REAL;DATABASE=Asistencia;UID=sa;PWD=456789;"  ;
		    $dbconn->Connect($myDSN);
	     }	 
   }
catch (exception $e)
   {
       echo '<span class="error">Excepcion : '.$e->getMessage()."</span>\n"; 
   }

#$dbconn->debug='true';
?>
