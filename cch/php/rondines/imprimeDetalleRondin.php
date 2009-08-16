<?php
if ( !isset($_REQUEST['rondin']) || $_REQUEST['rondin'] == '0')  
    {
        echo '<span class="error">Proporcione un Rondin y Ciclo Escolar</span>';
    }
                                                                
else
    {
        include('../conf/dbconfig.php');
        include('../conf/localeconf.php');   
        
        $rondin = $_REQUEST['rondin'];

        echo '<table width="90%" cellspacing="1" >';
        echo '<thead><tr><th>Rondin</th><th>Usuario</th>'
             .'<th>Fecha/Hora</th><th>Status</th></tr></thead><tbody>';
        if ($db == 'mysql') 
            $fechahora = 'r.FechaHora';    
            
        if ($db == 'ado_mssql') 
            $fechahora = 'CONVERT(VARCHAR(20),r.FechaHora,120)';
        $select = "SELECT  u.nombre, $fechahora, r.status"
                ." FROM Rondin r, usuarios u"
                ." WHERE r.idEncargado = u.id"
                ." AND r.idRondin =".$rondin;
        $rs = $dbconn->Execute($select);
        if ($rs->fields)
          {                                   
              $status = ($rs->fields[2] == 'S')?'Finalizado':'Finalizado Parcialmente';
              
              echo '<tr><td>'.$rondin.'</td><td>'.$rs->fields[0].'</td><td>'.strftime('%a %e %b %Y %X',strtotime($rs->fields[1])).'</td><td>'.$status.'</td></tr>';
          }                                                                                              
        echo '</tbody></table><br />'; 
        
        $select = 'SELECT sc.Status, count(*)' 
                .' FROM AsistenciaProfesores ap, statusClase sc'
                .' WHERE ap.idStatus = sc.idStatus'
                .' AND ap.idRondin ='.$rondin
                .' GROUP BY sc.Status';
        $rs = $dbconn->Execute($select);
        echo '<table width="45%" cellspacing="1" >';
        foreach ($rs as $k => $row)
        {
            echo '<tr><th width="100">'.$row[0].'</th><td>'.$row[1].'</td></tr>';
        }
        echo '</table><br />'; 
         
        $select = 'SELECT COUNT(*)' 
                .' FROM AsistenciaProfesores' 
                .' WHERE idRondin ='.$rondin
                .' AND idJustificacion <> 0';
        $rs = $dbconn->Execute($select); 
        if ($rs->fields[0] != 0)
        {
            echo '<table width="45%" cellspacing="1" >';
            echo '<tr><th width="100">F. Justificadas</th><td>'.$rs->fields[0].'</td></tr>';
            echo '</table><br />'; 
        }
        echo '<table width="95%" cellspacing="1" >';
        echo '<thead><tr><th colspan="2">Sal&oacute;n</th><th>Profesor</th>'
             .'<th>Status</th><th>Observaci&oacute;n</th></tr></thead><tbody>'; 
        
        $select = ' SELECT es.Edificio, es.Salon, pf.Nombre, sc.Status, ap.idObservacion' 
                .' FROM AsistenciaProfesores ap, EdificioSalon es, statusClase sc, Profesor pf'
                .' WHERE ap.idRondin ='.$rondin
                .' AND es.idSalon = ap.idSalon'
                .' AND ap.idStatus = sc.idStatus'
                .' AND ap.idProfesor = pf.idProfesor'
                .' ORDER BY es.Edificio,ap.idSalon';
        
        $rs = $dbconn->Execute($select);
        
        foreach ($rs as $k => $row)
        {
            echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td></tr>';
        }
        echo '</tbody></table>';          
        
    }
?>
