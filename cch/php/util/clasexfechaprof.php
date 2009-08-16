<?php
if ( !isset($_REQUEST['fecha']) && !isset($_REQUEST['profesor']) )
{
 echo 'Error';	
}
else
{   
    include_once("../conf/dbconfig.php"); 
    
    $fecha = $_REQUEST['fecha']; 
    $idProfesor = $_REQUEST['profesor'];
     
    $date = explode('/',$fecha);
    $isodate = $date[2].'-'.$date[1].'-'.$date[0];
    
    $time = strtotime($isodate); 
    $dia = date('N',$time);
    $year = date('Y',$time);
    $month = date('m',$time);
    $semestre = ($month <= 6)?'2':'1';

    $cicloescolar = $year.'-'.$semestre;
	
	$select = "SELECT idCicloEscolar FROM CicloEscolar WHERE Ciclo ='".$cicloescolar."'";
    $rs = $dbconn->Execute($select);

    if (!$rs->fields)
        { 
            echo "No existe el ciclo escolar contactar al Administrador.";  
        }    
    else
        { 
            $idCicloEscolar = $rs->fields[0];
            $_SESSION['jf_ceid'] = $rs->fields[0];
        }
	if ($db == 'mysql')
	    {
	        $orderby = ' ORDER BY CAST(h.Horario AS UNSIGNED)';
	    }   
	if ($db == 'ado_mssql')
	    {
	        $orderby ='' ;//' ORDER BY CONVERT(int,h.Horario)';
	    }
    $select = "SELECT ps.idProfesorSalon, es.Edificio,es.Salon, h.Horario"
            ." FROM ProfesorSalon ps, EdificioSalon es, Horario h"
            ." WHERE ps.idProfesor = ".$idProfesor
            ." AND ps.idCicloEscolar = ".$idCicloEscolar
            ." AND ps.idDia = ".$dia
            ." AND ps.idSalon = es.idSalon"
            ." AND ps.idHorario = h.idHorario".$orderby;
   			
	$rs = $dbconn->Execute($select);            
    if (!$rs->fields)
         echo '<br /><span class="error">No tiene clases asignadas ese d&iacute;a.</span><br />';
    else
         { 
	      echo '<h2>Elija a las clases que quiere justificarles falta</h2>'; 
	      echo '<table width="90%" cellpaddin="0" cellspacing="0" border="1">';
	      echo '<thead><tr><th>SALON</th><th>HORARIO</th><th>&nbsp;</th></tr></thead><tbody>';  
	      foreach ($rs as $k => $row)
	        {          
	           echo '<tr>'; 
	           echo '<td>'.$row[1].'-'.$row[2].'</td><td>'.$row[3].'</td><td><input type="button" value="Registra" onclick="insertaFaltaJustificada($F(\'justificante\'),$F(\'fecha\'),'.$row[0].',\'stat'.$row[0].'\');" /><div id="stat'.$row[0].'"></div></td>';
	           echo '</tr>'; 
	        }
	      echo '</tbody></table>';
	     }                
	     
}
?>