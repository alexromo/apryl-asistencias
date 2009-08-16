<?php
 include('../conf/dbconfig.php');
 
 echo '<table width="70%" cellspacing="1" >';
 echo '<thead><tr><th>&nbsp;</th><th>Nombre</th><th>username</th><th>rol</th></tr></thead><tbody>'; 
 $query = 'SELECT u.id,u.nombre,u.username,r.role '
          .' FROM usuarios u, roles r'
          .' WHERE u.role = r.id'
	      .' ORDER BY u.nombre';
  $rs = $dbconn->Execute($query);
  foreach ($rs as $k => $row)
    {
	    echo '<tr>'
    	    .'<td class="id">'.$row[0].'</td>'
    	    .'<td>'.$row[1].'</td>'
    	    .'<td>'.$row[2].'</td>'
    	    .'<td>'.$row[3].'</td>'
    	    .'</tr>';
    }
  echo '</tbody></table>';
?>