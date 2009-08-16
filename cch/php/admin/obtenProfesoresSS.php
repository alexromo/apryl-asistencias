<?php
 include('../conf/dbconfig.php');
 
 echo '<table width="70%" cellspacing="1" >';
 echo '<thead><tr><th>&nbsp;</th><th>Profesores Registrados</th></tr></thead><tbody>'; 
 $query = 'SELECT * '
          .' FROM Profesor '
	      .' ORDER BY Nombre';
  $rs = $dbconn->Execute($query);
  foreach ($rs as $k => $row)
    {
	    echo '<tr>'
    	    .'<td class="id">'.$row[0].'</td>'
    	    .'<td>'.$rs->fields[1].'</td>'
    	    .'</tr>';
    }
  echo '</tbody></table>';
?>