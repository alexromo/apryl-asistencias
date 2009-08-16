<?php
include('../conf/dbconfig.php');
include('../conf/localeconf.php');
 
 echo '<table width="70%" cellspacing="1" >';
 echo '<thead><tr><th>Rondin</th><th>Salon</th>'
     .'<th>Justificaci&oacute;n</th><th>&nbsp;</th></tr></thead><tbody>'; 
 
 if ($db == 'mysql')
    $fechahora ='FechaHora';
 if ($db == 'ado_mssql')
    $fechahora ='CONVERT(VARCHAR(20),FechaHora,120)';
 $query = "SELECT $fechahora FROM Rondin WHERE idRondin = ".$_REQUEST['rondin'];
 $result = $dbconn->Execute($query);
 
 $day = date('N',strtotime($result->fields[0]));
 $hora = date('G',strtotime($result->fields[0])).':00';
 $year = date('Y',strtotime($result->fields[0]));
 $month = date('m',strtotime($result->fields[0]));
 $semestre = ($month <= 6)
           ?  '2'
           :  '1';
 $cicloescolar = $year.'-'.$semestre;
 
 
 $select = "SELECT idHorario FROM Horario WHERE Horario ='".$hora."'";
 $rs = $dbconn->Execute($select);
 $hrid = $rs->fields[0];
 
 $select = "SELECT idCicloEscolar FROM CicloEscolar WHERE Ciclo ='".$cicloescolar."'";
 $rs = $dbconn->Execute($select);
 $ceid = $rs->fields[0];
     
 $query = "SELECT ap.idAsistencia, es.Edificio, es.Salon, ap.idJustificacion"
		  ." FROM AsistenciaProfesores ap, EdificioSalon es"
          ." WHERE ap.idSalon = es.idSalon"
          ." AND ap.idRondin = ".$_REQUEST['rondin']
          ." AND ap.idStatus = 2 "
          ." ORDER by es.ValorHoja";
  $rs = $dbconn->Execute($query);
  foreach ($rs as $k => $row)
    {
	    echo '<tr>'
    	    .'<td class="id">'.$_REQUEST['rondin'].'</td>'
    	    .'<td>'.$row[1].'-'.$row[2].'</td>'
    	    .'<td><textarea name="'.$row[0].'" rows="3" cols="20"></textarea></td>'
	        .'<td><input type="button" value="Justifica" onclick ="justificaFalta('.$row[0].')" /></td>'
    	    .'</tr>';
	}
  echo '</tbody></table>';
?>
