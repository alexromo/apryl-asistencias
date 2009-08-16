<?php
 include('../conf/dbconfig.php');
 include('../conf/localeconf.php');
 
 if ($db == 'mysql')
    $fechaalta = 'ju.FechaAlta';
 if ($db == 'ado_mssql')
    $fechaalta = 'CONVERT(VARCHAR(20),ju.FechaAlta,120)';
  
 $query = "SELECT ju.idJustificante, $fechaalta, pr.Nombre, jt.Justificacion "
         ."FROM Justificante ju, Justificacion jt, Profesor pr "
         ."WHERE ju.idJustificacion = jt.idJustificacion "
         ."AND ju.idProfesor = pr.idProfesor ";
                        
 $rs = $dbconn->Execute($query);
 if ($rs->fields)
   { 
    echo '<table width="95%" cellspacing="1" >'
         .'<thead><tr><th>id</th><th>Fecha Alta</th>'
         .'<th>Profesor</th><th>Motivo</th></tr></thead><tbody>';   
    foreach ($rs as $k => $row)
        {
          echo '<tr>'
    	      .'<td class="id">'.$row[0].'</td>'
              .'<td>'.date('d/m/Y H:i:s',strtotime($row[1])).'</td>'
	          .'<td>'.$row[2].'</td>'
	          .'<td>'.$row[3].'</td>'
              .'</tr>';
        }
     echo '</tbody></table>'; 
   }
 else
   {
     echo '<span> No hay registros.</span>';  
   }    
?>
