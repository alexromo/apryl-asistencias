<?php
if (!isset($_REQUEST['profesor'])) 
{
    echo 'Error';
}
else
{
    include('../conf/dbconfig.php');
    
    $idProfesor = $_REQUEST['profesor'];
    
    echo '<table width="70%" cellspacing="1" >';
    echo '<thead><tr><th>Justificante</th><th>Fecha</th>'
         .'<th>Justificacion</th><th></th></tr></thead><tbody>';  
    
    if ($db == 'mysql')
        $fecha = 'jt.FechaAlta';
    if ($db == 'ado_mssql')
        $fecha = 'CONVERT(VARCHAR(20),jt.FechaAlta,120)';
    $select = "SELECT jt.idJustificante,$fecha,js.Justificacion"
            ." FROM Justificante jt, Justificacion js"
            ." WHERE jt.idProfesor =".$idProfesor
            ." AND jt.idJustificacion = js.idJustificacion"
            ." ORDER BY jt.idJustificante DESC"; 
            
    $rs = $dbconn->Execute($select);
    
    foreach ($rs as $k => $row)
        {
            echo '<tr><td class="id">'.$row[0].'</td><td>'.date('d/m/Y',strtotime($row[1])).'</td><td>'.$row[2].'</td><td><a href="javascript:void(0)" onclick="actualizaDetalleJustificante('.$row[0].');">Detalle</a></td></tr>';
        }
    echo '</tbody></table>';        
}
?>
