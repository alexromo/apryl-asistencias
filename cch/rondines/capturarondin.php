<?php

echo '<form name="capturarondines" action="aplicacion.php?seccion=rondines&subsec=capturarondin&rondin='.$_REQUEST['rondin'].'" method="post">';
?>
<fieldset>
<h1>Captura de Rondines</h1>
<label for="rondin">Rondin :</label> 
<input type="text" readonly="readonly" name="rondin" size="4" value="<?php echo $_SESSION['rondin']; ?>" />
<input type="text" readonly="readonly" size="20" value="<?php echo $_SESSION['nombre']; ?>" />
<input type="text" readonly="readonly" size="17" value="<?php echo $_SESSION['rfecha']; ?>" />
<br />
<label for="edificio">Edificio :</label>
<select name="edificio" id="edificio">
<?php
include('php/conf/dbconfig.php');

$select = 'SELECT DISTINCT Edificio FROM EdificioSalon ORDER BY 1';

$rs = $dbconn->Execute($select);
echo '<option value="0" selected="selected" > Elija </option>'; 
foreach ($rs as $k => $row)
{
    $selected = '';
    if ((isset($_REQUEST['edificio'])) && ($_REQUEST['edificio'] != '0'))
        $selected = ($_REQUEST['edificio'] == $row[0])
                  ?  ' selected = "selected" '
                  :  '';
    echo '<option value="'.$row[0].'"'.$selected.'>'.$row[0].'</option>';
}
	
?>
</select>
<input type="submit" name="cambiaedificio" value="Captura" />
<div id="status"></div>
</fieldset>
</form>
<?php
if ((isset($_REQUEST['edificio'])) && ($_REQUEST['edificio'] != '0'))
{
	echo '<form name="capturasalones" >';
  	include('php/conf/dbconfig.php');
	
	$edificio = $_REQUEST['edificio']; 
		
	$query = 'SELECT * FROM statusClase';
	$status = $dbconn->GetAssoc($query);
	
	
	$query2 = "SELECT * FROM EdificioSalon WHERE Edificio ='".$edificio."' ORDER BY idSalon";
	$salon = $dbconn->Execute($query2);
	foreach ($salon as $k => $row) 
		 {
			echo '<fieldset>';
			echo '<h1> Sal&oacute;n '.$edificio.' '.$row[2].'</h1>';
			
			$selectprof = "SELECT pr.Nombre"
						  ." FROM ProfesorSalon ps, Profesor pr"
						  ." WHERE ps.idProfesor = pr.idProfesor"
						  ." AND ps.idSalon = ".$row[0]
						  ." AND ps.idCicloEscolar = ".$_SESSION['ceid']
						  ." AND ps.idHorario = ".$_SESSION['hrid']
						  ." AND ps.idDia =".$_SESSION['dia']; 
			$rsprof = $dbconn->Execute($selectprof);
		    
		    echo "<b>Prof. <em>".$rsprof->fields[0]."</em></b><br />";
		    
		    if ($db == 'mysql')
	           $query3 = "SELECT idStatus,FechaHora FROM AsistenciaProfesores WHERE idRondin = ".$_SESSION['rondin']." AND idSalon = ".$row[0];
	        if ($db == 'ado_mssql')   
	           $query3 = "SELECT idStatus,CONVERT(VARCHAR(20), FechaHora, 100) FROM AsistenciaProfesores WHERE idRondin = ".$_SESSION['rondin']." AND idSalon = ".$row[0];
 	        $state = $dbconn->Execute($query3);	
 	        $stated = 0;
 	        if ($state->fields) $stated = $state->fields[0];
 	        $checked='';
		     foreach ($status as $index => $value)
			    {
			     $checked = ($index == $stated)?' checked="checked"':'';    
		         echo '<input type="radio" name="estado'.$edificio.$row[2]
					  .'"  value="'.$index.'" onchange="document.getElementById(\'regsalon'.$edificio.$row[2]
				      .'\').enable()"'.$checked.' />'.$value;	 
		        }
		    
		    $buttonValue = (!$state->fields)?'Registra':'Actualiza';
		     
			echo '&nbsp;&nbsp;<input type="button" name="regsalon'.$edificio.$row[2]
			    .'"  id="regsalon'.$edificio.$row[2]
			    .'"  value="'.$buttonValue.'" onclick="insertaAsistencia(\''.$_SESSION['rondin'].'\',\''
			    .$row[0].'\',$(\'captura\').serialize().toQueryParams()[\'estado'
				.$edificio.$row[2].'\'],\'check'
			    .$edificio.$row[2].'\');" disabled="disabled" />';
			$idate = ($stated != 0)?date('d/m/Y H:i',strtotime($state->fields[1])):' ';    
			echo '&nbsp;<span style="background-color:#fff;border:1px solid #ddd;padding:0.5em;" id="check'
		    .$edificio.$row[2].'">'.$idate.'</span>';
		    echo '</fieldset>';	
		 }
	echo '</form>';	
}
?>

<div class="tabla" id="lista" >	
</div>
