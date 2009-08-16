<?php
 include('../conf/dbconfig.php');
 
  
if ($_REQUEST['edificio'] == '')
{
	$query = 'SELECT * '
       		.' FROM EdificioSalon '
			.' ORDER BY Edificio,Salon';
	}
else
{
 	$query = "SELECT *" 
      		." FROM EdificioSalon "
			." WHERE Edificio = '".$_REQUEST['edificio']."'"
  			." ORDER BY Salon";
}
  $rs = $dbconn->Execute($query);

echo '<table width="70%" cellspacing="1" >';
echo '<thead><tr><th>&nbsp;</th><th>Edificios</th><th>Salon</th></tr></thead><tbody>'; 


  foreach ($rs as $k => $row) 
    {
	    echo '<tr>'
    	     .'<td class="id">'.$row[0].'</td>'
    	     .'<td align="center">'.$row[1].'</td>'
             .'<td align="center">'.$row[2].'</td>'
    	     .'</tr>';
    }
  echo '</tbody></table>';
?>