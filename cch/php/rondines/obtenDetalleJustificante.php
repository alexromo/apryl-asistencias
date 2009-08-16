<?php
if (!isset($_REQUEST['justificante'])) 
{
    echo 'Error';
}
else
{
    include('../conf/dbconfig.php');
    include('../conf/localeconf.php');  
    
    $idJustificante = $_REQUEST['justificante'];
    
    echo '<table width="70%" cellspacing="1" >';
    echo '<thead><tr><th>Justificante</th><th>Salon</th>'
         .'<th>Dia</th><th>Horario</th><th>Fecha</th></tr></thead><tbody>';  
    if ($db == 'mysql')
        $fecha = 'fj.Fecha';
    if ($db == 'ado_mssql')
        $fecha = 'CONVERT(VARCHAR(20),fj.Fecha,120)';
    $select = " SELECT fj.idFaltasJustificadas, es.Edificio,es.Salon,dd.Dia,hh.Horario,$fecha"
            ." FROM FaltasJustificadas fj, ProfesorSalon ps, EdificioSalon es, Dia dd, Horario hh" 
            ." WHERE fj.idJustificante =".$idJustificante
            ." AND fj.idProfesorSalon = ps.idProfesorSalon"
            ." AND ps.idSalon = es.idSalon"
            ." AND ps.idDia = dd.idDia"
            ." AND ps.idHorario = hh.idHorario";
            
    $rs = $dbconn->Execute($select);
    
    foreach ($rs as $k => $row)
        {
            echo '<tr><td class="id">'.$idJustificante.'</td><td>'.$row[1].'-'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.date('d/m/Y',strtotime($row[5])).'</td></tr>';
        }
    echo '</tbody></table>';        
}
?>
