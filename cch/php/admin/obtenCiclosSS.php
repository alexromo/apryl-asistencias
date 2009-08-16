
<?php
 include('../conf/dbconfig.php');
 
 echo '<table  width="70%" cellspacing="1" >';
 echo '<thead><tr><th>id</th><th>Ciclos Escolares Registrados</th><th>Inicia</th><th>Finaliza</th></tr></thead><tbody>'; 
 $query = 'SELECT * '
        .' FROM CicloEscolar '
	    .' ORDER BY Ciclo';
  $rs = $dbconn->Execute($query);
  foreach ($rs as $k => $row) 
      {
	    echo '<tr>'
    	     .'<td class="id">'.$row[0].'</td>'
    	     .'<td>'.$row[1].'</td>'
    	     .'<td>'.strftime('%d/%m/%Y',strtotime($row[2])).'</td>'
    	     .'<td>'.strftime('%d/%m/%Y',strtotime($row[3])).'</td>'
    	     .'</tr>';
      }
  echo '</tbody></table>';
?>
