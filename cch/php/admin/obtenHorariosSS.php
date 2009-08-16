<?php
 include('../conf/dbconfig.php');
 
 echo '<table width="90%" cellspacing="1" >';
 echo '<thead><tr><th>Ciclo Escolar</th><th>Profesor</th>'
     .'<th>D&iacute;a</th><th>Hora</th><th>Sal&oacute;n</th></tr></thead><tbody>';

$filter1 = ' AND ps.idProfesor ='.$_REQUEST['profesor'];
$filter2 = ' AND ps.idCicloEscolar ='.$_REQUEST['ciclo'];
$suffix = ''; 
if ( ($_REQUEST['ciclo'] != 0) && ($_REQUEST['profesor'] != 'A') )
	$suffix = $filter2.$filter1.' ORDER BY d.idDia,h.Horario,es.Salon';
if ( ($_REQUEST['ciclo'] == 0) && ($_REQUEST['profesor'] != 'A') )
	$suffix = $filter1.' ORDER BY ce.ciclo,d.idDia,h.Horario,es.Salon';
if ( ($_REQUEST['ciclo'] != 0) && ($_REQUEST['profesor'] == 'A') )
	$suffix = $filter2.' ORDER BY d.idDia,h.Horario,es.Salon';

 $query = 'SELECT ce.ciclo, p.Nombre, es.Edificio, es.Salon, d.Dia, h.Horario'
		  .' FROM ProfesorSalon ps,'
          .'CicloEscolar ce,'
	      .'Profesor p,'
          .'EdificioSalon es,'
	      .'Dia d,'
	      .'Horario h'
          .' WHERE ps.idCicloEscolar = ce.idCicloEscolar'
		  .' AND ps.idProfesor = p.idProfesor'
		  .' AND ps.idSalon = es.idSalon' 
		  .' AND ps.idDia = d.idDia'
		  .' AND ps.idHorario = h.idHorario'.$suffix;
				
  $rs = $dbconn->Execute($query);
  foreach ($rs as $k => $row) 
    {
	    echo '<tr>'
    	     .'<td>'.$row[0].'</td>'
    	     .'<td>'.$row[1].'</td>'
			 
			 .'<td>'.$row[4].'</td>'
			 .'<td>'.$row[5].'</td>'
			 .'<td>'.$row[2].' - '.$row[3].'</td>'
    	     .'</tr>';
    }
  echo '</tbody></table>';
?>
