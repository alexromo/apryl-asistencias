<?php
 if ( (!isset($_REQUEST['edificio'])) && (!isset($_REQUEST['salon'])) )
 {	
  echo '<span class="error">Introduzca un Edificio y Sal&oacute;n y vuelvalo a intentar.</span>';
 }
 else
 {
  $building = strtoupper(trim($_REQUEST['edificio']));
  $classroom = strtoupper(trim($_REQUEST['salon']));

  if ((strlen($building) != 0) && (strlen($classroom) != 0))
    {
     include('../conf/dbconfig.php');
 		
	 $select = "SELECT COUNT(*) " 
	           ."FROM EdificioSalon "
	           ."WHERE Edificio = '".$building."' " 
	           ."AND Salon='".$classroom."'";
 	 $rs = $dbconn->Execute($select);
     if ($rs->fields[0] >= 1)
        {
         echo '<span class="error">Ese Sal&oacute;n ya esta dado de alta.</span>';
        }
 	 else
       {
	    $record['edificio'] = $building;
	    $record['salon'] = $classroom;
		$dbconn->AutoExecute('EdificioSalon',$record,'INSERT');
        echo '<span class="exito">Sal&oacute;n Registrado con exito</span>';
       }
    }
  else 
    {
     echo '<span class="error">Introduzca un Edificio y Sal&oacute;n y vuelvalo a intentar.</span>';
    }
}  
?>