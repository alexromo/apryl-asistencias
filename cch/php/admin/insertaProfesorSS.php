<?php
 if (!isset($_REQUEST['nombre']))
 {	
  echo '<span class="error">1-Introduzca un Nombre y vuelvalo a intentar.</span>';
 }
 else
 {
  $name = trim($_REQUEST['nombre']);
  
  if (strlen($name) != 0)
    {
     include('../conf/dbconfig.php');
 		
	 $select = "SELECT COUNT(*) " 
	         ."FROM Profesor "
	         ."WHERE Nombre = '".$name."'";
 	 $rs = $dbconn->Execute($select);
     if ($rs->fields[0] >= 1)
        {
         echo '<span class="error">Ese Profesor ya esta dado de alta.</span>';
        }
 	 else
       {
	    $record['nombre'] = $name;
	    $dbconn->AutoExecute('Profesor',$record,'INSERT');
        echo '<span class="exito">Profesor Registrado con exito</span>';
       }
    }
  else 
    {
     echo '<span class="error">2-Introduzca un Nombre y vuelvalo a intentar.</span>';
    }
}  
?>