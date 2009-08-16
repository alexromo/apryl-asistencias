<?php

include_once('../php/conf/dbconfig.php');

$rondinterminado = FALSE;
if ((isset($_REQUEST['edificio'])) && ($_REQUEST['edificio'] != '0'))
{
    
    if (isset($_REQUEST['salon']) && isset($_REQUEST['status']) && isset($_REQUEST['observacion']))
    {
	    $update = "UPDATE AsistenciaProfesores"
	              ." SET idStatus = ".$_REQUEST['status']." , idObservacion = ".$_REQUEST['observacion']
	              ." WHERE idRondin = ".$_SESSION['rondin']." AND idSalon = ".$_REQUEST['salon'];
	    $result = $dbconn->Execute($update);
    }
}    

$select = "SELECT COUNT(*) FROM ProfesorSalon"
          ." WHERE idCicloEscolar = ".$_SESSION['ceid']
          ." AND idDia = ".$_SESSION['diasemana']
          ." AND idHorario = ".$_SESSION['hrid']
          ." AND idProfesor NOT IN (0,24,861)";
$result = $dbconn->Execute($select);
$numsalones = $result->fields[0];

$select = "SELECT COUNT(*) FROM AsistenciaProfesores"
          ." WHERE idRondin = ".$_SESSION['rondin']
          ." AND Capturado = 1";
$result = $dbconn->Execute($select);
$numsalonescapturados = $result->fields[0];     

if ($numsalonescapturados == $numsalones)  
  {
     $rondinterminado = TRUE;
     echo "<script>document.getElementById('btn_crondin').disabled=false;</script>";  
  }
echo '<form name="capturarondines" action="rondines.php?seccion=capturarondin&rondin='.$_REQUEST['rondin'].'" method="post">';
?>
<fieldset>
<legend>Captura de Rondines</legend>
<label for="rondin">Rondin :</label> 
<input type="text" readonly="readonly" name="rondin" size="4" value="<?php echo $_SESSION['rondin']; ?>" />
<input type="text" readonly="readonly" size="20" value="<?php echo $_SESSION['nombre']; ?>" />
<label for="capturados">Cap :</label>
<input type="text" readonly="readonly" name="capturados" size="3" value="<?php echo $numsalonescapturados; ?>" />
/<input type="text" readonly="readonly" size="3" value="<?php echo $numsalones; ?>" />
<br />
<label for="edificio">Edificio :</label>
<select name="edificio" id="edificio">
<?php
include_once('../php/conf/dbconfig.php');
echo '<option value="0" selected="selected" > Elija </option>'; 
if (!isset($_SESSION['edificiosalon']))
{
    $select = 'SELECT DISTINCT Edificio FROM EdificioSalon ORDER BY 1';

    $rs = $dbconn->Execute($select); 
    foreach ($rs as $k => $row)
    {
       $selectns = " SELECT COUNT(*)" 
                  ." FROM AsistenciaProfesores ap, EdificioSalon es" 
                  ." WHERE ap.idRondin = ".$_REQUEST['rondin']
                  ." AND ap.idSalon = es.idSalon"
                  ." AND es.Edificio = '".$row[0]."'";
       $rsns = $dbconn->Execute($selectns);
       if ($rsns->fields[0] != 0) 
          {     
           $selected='';
       	   if (isset($_REQUEST['edificio']))
       	      $selected = ($_REQUEST['edificio'] == $row[0])
       	                ?  ' selected="selected"'
       	                :  '';

       	   $query = "SELECT COUNT(*) FROM AsistenciaProfesores ap, EdificioSalon es"
                   ." WHERE ap.idRondin = ".$_SESSION['rondin']
                   ." AND ap.idSalon = es.idSalon"
                   ." AND es.Edificio = '".$row[0]."'"
                   ." AND ap.Capturado = 1";
       	   $result = $dbconn->Execute($query);
       	   $capt = $result->fields[0];

       	   echo '<option value="'.$row[0].'"'.$selected.'>'.$row[0].' -> ('.$capt.')</option>';
           } 
    }                                  

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
  	include_once('../php/conf/dbconfig.php');
	
	$edificio = $_REQUEST['edificio']; 
	  
	$query = 'SELECT * FROM statusClase';
	$status = $dbconn->GetAssoc($query);
	$query = 'SELECT * FROM observacion';
	$observations = $dbconn->GetAssoc($query);
	
	if ($db == 'mysql')
	    {
	        $orderby = 'ORDER BY CAST(es.Salon AS UNSIGNED)';
	    }
	if ($db == 'ado_mssql')
	    {
	        $orderby = 'ORDER BY CONVERT(int,es.Salon)';
	    }
	
	$query2 = "SELECT es.idSalon, es.Salon"
             ." FROM ProfesorSalon ps, EdificioSalon es"
             ." WHERE ps.idSalon = es.idSalon"
             ." AND ps.idCicloEscolar =".$_SESSION['ceid']
             ." AND ps.idHorario =".$_SESSION['hrid']
             ." AND ps.idDia =".$_SESSION['dia'] 
             ." AND es.Edificio = '".$edificio."'"
             .$orderby;
	$salon = $dbconn->GetAssoc($query2);
	
	echo '<form name="capturasalones" >';
	 
	foreach ($salon as $idSalon => $nombre)
		 {   
		    
		    $select = "SELECT COUNT(*) FROM AsistenciaProfesores"
		              ." WHERE idRondin = ".$_SESSION['rondin']
		              ." AND idSalon = ".$idSalon
		              ." AND FechaHora = '".$_SESSION['solofecha'].":00:00'";
		    $fechahora = $dbconn->Execute($select);
		    
		    if ($fechahora->fields[0] == 1)
		       {          
		        $update = "UPDATE AsistenciaProfesores SET Capturado = 1, FechaHora = CURRENT_TIMESTAMP"
		                  ." WHERE idRondin = ".$_SESSION['rondin']
		                  ." AND idSalon = ".$idSalon; 
		        $rsupd = $dbconn->Execute($update);
		        
		       } 
			
			$selectprof = "SELECT pr.Nombre "
						  ." FROM AsistenciaProfesores ap, Profesor pr"
						  ." WHERE ap.idRondin = ".$_SESSION['rondin']
						  ." AND ap.idSalon = ".$idSalon
						  ." AND ap.idProfesor = pr.idProfesor"; 
			$rsprof = $dbconn->Execute($selectprof);
			if ($rsprof->fields)
				{ 
				 $faltajustificada = '';    
			     
			     if ($db == 'mysql')
	                 $query3 = "SELECT idStatus,FechaHora,idObservacion,idJustificacion FROM AsistenciaProfesores"
	                           ." WHERE idRondin = ".$_SESSION['rondin']
	                           ." AND idSalon = ".$idSalon;
	             if ($db == 'ado_mssql')   
	                 $query3 = "SELECT idStatus,CONVERT(VARCHAR(20), FechaHora, 120),idObservacion,idJustificacion"
	                         ." FROM AsistenciaProfesores"
	                         ." WHERE idRondin = ".$_SESSION['rondin']
	                         ." AND idSalon = ".$idSalon;
	             $state = $dbconn->Execute($query3);	
	             $stated = 0;
	             $observe = 0;
	             $justificante = 0;
	             if ($state->fields)
	                { 
	                    $stated = $state->fields[0];
	                    $observe = $state->fields[2];
	                    $justificante = $state->fields[3];
                    }
                 $faltajustificada = ($justificante != 0) 
                                   ?  ' <b>(FALTA JUSTIFICADA)</b>'
                                   :  '';
	             echo '<fieldset>';
    			 echo '<legend>'.$edificio.' '.$nombre.'</legend>';
    			 echo 'Prof: '.$rsprof->fields[0].$faltajustificada.'<br />';
	             $disablestatus = ($justificante != 0)?' disabled="disabled"':'';
		         foreach ($status as $index => $value)
			        {
			            $checked = ($index == $stated)?' checked="checked"':'';
		                echo '<input type="radio" name="radioestado'.$edificio.$nombre.'" value="'.$index.'" onchange="document.getElementById(\'regsalon'.$edificio.$nombre.'\').disabled=false" '.$checked.$disablestatus.' />'.$value;
		            }
	                   
		        echo '&nbsp;<select name="selectobservacion'.$edificio.$nombre.'" onchange="document.getElementById(\'regsalon'.$edificio.$nombre
 				            .'\').disabled=false" >';
		        echo '<option value="0" selected="selected">Sin Observaci&oacute;n</option>';
		        
 		        foreach ($observations as $index => $value)
 			        {
 			            $checked = ($index == $observe)?' selected="selected"':'';
 			            echo '<option value="'.$index.'"  '.$checked.'>'.$value.'</option>';
 			        }
 			    echo '</select>';         
		     
		        $buttonValue = (!$state->fields)?'Registra':'Actualiza';
                $disablestatus = ($justificante == 0)?' disabled="disabled"':''; 
			    echo '&nbsp;&nbsp;';
			    echo '<input type="button" name="regsalon'.$edificio.$nombre.'"'
			        .' id="regsalon'.$edificio.$nombre.'"'
			        .' value="'.$buttonValue.'"'
			        .' onclick=" state=getCheckedValue(document.capturasalones.radioestado'.$edificio.$nombre.'); var observe=document.capturasalones.selectobservacion'.$edificio.$nombre.'.value; location.href =\'rondines.php?seccion=capturarondin&rondin='.$_REQUEST['rondin'].'&edificio='.$edificio.'&salon='.$idSalon.'&observacion=\'+observe+\'&status=\'+state;" '.$disablestatus.' />'; 
			    $datetime = ($state->fields[1] == null)?'':date('d/m/Y H:i',strtotime($state->fields[1]));       
			    echo '&nbsp;<input type="text" value="'.$datetime.'" readonly="readonly" />';
		        echo '</fieldset>';
		       }		
		 }
	echo '</form>';	
   }

?>

<div id="tabla">	
</div>
