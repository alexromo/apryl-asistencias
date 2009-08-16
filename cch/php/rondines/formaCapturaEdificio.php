<?php
if (!isset($_REQUEST['edificio']) || $_REQUEST['edificio'] == '0')
{
	echo '<span class="error">Selecciona un Edificio</span>';
}
else
{
	
	include('../conf/dbconfig.php');
	
	$edificio = $_REQUEST['edificio']; 
		
	$query = 'SELECT * FROM statusClase';
	$status = $dbconn->GetAssoc($query);
	
	
	$query2 = "SELECT * FROM EdificioSalon WHERE Edificio ='".$edificio."' ORDER BY valorHoja";
	$salon = $dbconn->Execute($query2);
	foreach ($salon as $k => $row) 
		 {
			echo '<fieldset>';
			echo '<legend>'.$edificio.' '.$row[2].'</legend>';
		
			echo '<label for="estado'.$edificio.$row[2].'">Estado :</label>';
		     foreach ($status as $index => $value)
			    {
		         echo '<input type="radio" name="estado'.$edificio.$row[2].'"  value="'.$index.'" onchange="	$(\'regsalon'.$edificio.$row[2]
				    .'\').enable()" />'.$value;	 
		        }
		
		
			echo '&nbsp;&nbsp;<input type="button" name="regsalon'.$edificio.$row[2]
			    .'"  id="regsalon'.$edificio.$row[2]
			    .'"  value="Registra" onclick="insertaAsistencia(\''
			    .$row[0].'\',$F(\'rondin\'),$(\'captura\').serialize().toQueryParams()[\'estado'
				.$edificio.$row[2].'\'],\''
			    .date('Y-m-d H:i:s').'\',\'check'
			    .$edificio.$row[2].'\');" disabled="disabled" />';
			echo '<div id="check'.$edificio.$row[2].'">&nbsp;</div>';
		    echo '</fieldset>';	
		 }

}

?>
