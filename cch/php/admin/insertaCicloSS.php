<?php

 if (!isset($_REQUEST['ciclo']))
 {
  echo '<span class="error">Introduzca un ciclo y vuelvalo a intentar.</span>';
 }
 else
 {
 include('../conf/dbconfig.php');
 
 $select = "SELECT COUNT(*) "
	     ."FROM CicloEscolar "
	     ."WHERE Ciclo = '".$_REQUEST['ciclo']."'";
 $rs = $dbconn->Execute($select);
 if ($rs->fields[0] >= 1)
 {
  echo '<span class="error">Ese Ciclo Escolar ya esta dado de alta.</span>';
 }
 else
 {
  $record['ciclo'] = $_REQUEST['ciclo'];
  $dbconn->AutoExecute('CicloEscolar',$record,'INSERT'); 	
  echo '<span class="exito">Ciclo Registrado con exito</span>';
 } 
}  
?>
