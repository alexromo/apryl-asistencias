<?php
 include('../conf/dbconfig.php');
 include('../conf/localeconf.php');
 
 if (!isset($_REQUEST['justificante']))
   {
      echo 'Error'; 
   }
 else 
    {
        if ($db == 'mysql')
            $fecha = 'fj.Fecha';
        if ($db == 'ado_mssql')
            $fecha = 'CONVERT(VARCHAR(20),fj.Fecha,120)';
        
        $query = "SELECT fj.idJustificante, es.Edificio, es.Salon, hr.Horario, $fecha "
                ."FROM FaltasJustificadas fj, ProfesorSalon ps, EdificioSalon es, Horario hr "
                ."WHERE fj.idProfesorSalon = ps.idProfesorSalon "
                ."AND ps.idSalon = es.idSalon "
                ."AND ps.idHorario = hr.idHorario "
                ."AND fj.idJustificante =".$_REQUEST['justificante'];
                        
        $rs = $dbconn->Execute($query);
        if ($rs->fields)
            { 
                echo '<table width="95%" cellspacing="1" >'
                    .'<thead><tr><th>id</th><th>Salon/Horario</th>'
                    .'<th>Fecha Justificada</th></tr></thead><tbody>';   
                foreach ($rs as $k => $row)
                    {
                        echo '<tr>'
    	                    .'<td class="id">'.$row[0].'</td>'
                            .'<td align="center">'.$row[1].'-'.$row[2].' '.$row[3].'</td>'
	                        .'<td align="center">'.date('d/m/Y',strtotime($row[4])).'</td>'
                            .'</tr>';
                    }
                echo '</tbody></table>'; 
            }
         else
            {
                echo '<span> No hay registros.</span>';  
            }
    }   
?>