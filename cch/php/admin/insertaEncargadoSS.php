<?php
 if (!isset($_REQUEST['nombre']))
 {
  echo '<span class="error">Introduzca un Nombre y vuelvalo a intentar.</span>';
 }
 else
 {
  $nombre = trim($_REQUEST['nombre']);
  
  if ($nombre != '')
    {
     include('../conf/dbconfig.php');
	   
	 $select = "SELECT COUNT(*) "
	   ."FROM Encargado "
	   ."WHERE Nombre = '".$nombre."'";
	 $rs = $dbconn->Execute($select);
     
     if ($rs->fields[0] >= 1)
        {
         echo '<span class="error">Ese Encargado ya esta dado de alta.</span>';
        }
	 else
       {
	    $record['nombre'] = $_REQUEST['nombre'];
	    $dbconn->AutoExecute('Encargado',$record,'INSERT');
        echo '<span class="exito">Encargado Registrado con exito</span>';
       }
    }
  else 
     echo '<span class="error">Introduzca un Nombre y vuelvalo a intentar.</span>';
}  
?>