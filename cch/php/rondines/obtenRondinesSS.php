<?php
 include('../conf/dbconfig.php'); 
 include('../conf/localeconf.php');
 
 echo '<table width="70%" cellspacing="1" >';
 echo '<thead><tr><th>Rondin</th><th>Encargado</th>'
     .'<th>Fecha/Hora</th></tr></thead><tbody>'; 
 
 $status = $_REQUEST['status'];     
 switch ($status) {
    case 'N': // No terminado
    case 'S': // Terminado
    case 'P': // Parcial o Cerrado
        $filtro = " AND status = '".$status."'";
        break;
    
    default:
        $filtro = '';
        break;
 }          
 
 if ($db == 'mysql')
    $fechahora = 'rd.FechaHora';
 if ($db == 'ado_mssql')
    $fechahora = 'CONVERT(VARCHAR(20),rd.FechaHora,120)';
     
 $query = "SELECT rd.idRondin, u.nombre, $fechahora"
		  ." FROM Rondin rd, usuarios u"
          ." WHERE rd.idEncargado = u.id"
          .$filtro
          ." ORDER by rd.FechaHora";
  $rs = $dbconn->Execute($query);
  while (!$rs->EOF) {
	echo '<tr>'
    	.'<td class="id">'.$rs->fields[0].'</td>'
    	.'<td>'.$rs->fields[1].'</td>'
	    .'<td>'.date('d/m/Y H:i:s',strtotime($rs->fields[2])).'</td>'
    	.'</tr>';
	$rs->MoveNext();
    }
  echo '</tbody></table>';
?>
