<?php
 if ( ($_REQUEST['ciclo'] == '0') && 
	  ($_REQUEST['profesor'] == 'A') && 
	  ($_REQUEST['salon'] == '0') && 
	  ($_REQUEST['dia'] == '0') && 
	  ($_REQUEST['hora'] == '0' ) )
 {	
  echo '<span class="error">Seleccion el dato que le falta y vuelvalo a intentar.</span>';
 }
 else
 {

     include('../conf/dbconfig.php');
# Checar que no se haya asignado ese horario a ese salon en el mismo ciclo escolar
 		
	 $select = "SELECT COUNT(*)" 
	         ." FROM ProfesorSalon"
	         ." WHERE idSalon =".$_REQUEST['salon']
			 ." AND idCicloEscolar=".$_REQUEST['ciclo']
			 ." AND idHorario=".$_REQUEST['hora']
			 ." AND idDia=".$_REQUEST['dia'];
			
 	 $rs = $dbconn->Execute($select);
     if ($rs->fields[0] >= 1)
        {
         echo '<span class="error">Ese Sal&oacute;n a ese horario ya fue asignado.</span>';
        }
 	 else
       {
	    $record['idsalon']=$_REQUEST['salon'];
	    $record['idprofesor']=$_REQUEST['profesor'];
	    $record['idcicloescolar']=$_REQUEST['ciclo'];
	    $record['idhorario']=$_REQUEST['hora'];
	    $record['iddia']=$_REQUEST['dia'];
	
		$dbconn->AutoExecute('ProfesorSalon',$record,'INSERT');
        echo '<span class="exito">Horario Registrado con exito</span>';
       }
}  
?>