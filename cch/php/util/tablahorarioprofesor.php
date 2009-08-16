<?php
if ( !isset($_REQUEST['ciclo']) || !isset($_REQUEST['profesor']) )
{
 echo 'Error';	
}
else
{   
    include_once("../conf/dbconfig.php"); 
    
    $idProfesor = $_REQUEST['profesor']; 
    $idCicloEscolar = $_REQUEST['ciclo'];
     
    if ($db == 'mysql')
	    {
	        $orderby = ' ORDER BY CAST(Horario AS UNSIGNED)';
	    }   
	if ($db == 'ado_mssql')
	    {
	        $orderby = ' ORDER BY CAST(Horario AS int)';
	    } 
     
     
    $select = "SELECT * FROM Horario ".$orderby;
    $Horarios = $dbconn->GetAssoc($select);
    
    $select = "SELECT * FROM Dia WHERE Dia NOT IN ('Sabado','Domingo')";
    $Dias = $dbconn->GetAssoc($select); 
     
    $endl="\n";
    echo '<table width="90%" cellpaddin="0" cellspacing="0" border="1">'.$endl;
    echo '<thead>'.$endl;
    echo '<tr><th>Horario</th>';
    foreach ($Dias as $l => $row1) 
        {
            echo '<th>'.substr($row1,0,3).'</th>';
         }
    echo '</tr>'.$endl.'</thead>'.$endl.'<tbody>'.$endl;
            
    foreach ($Horarios as $k => $row)
        {     
            echo '<tr><th>'.$row.'</th>';
            foreach ($Dias as $l => $row1) 
                {
                    $select = "SELECT ps.idSalon, es.Edificio, es.Salon"
                            ." FROM ProfesorSalon ps, EdificioSalon es"
                            ." WHERE ps.idProfesor = ".$idProfesor
                            ." AND ps.idCicloEscolar = ".$idCicloEscolar
                            ." AND ps.idHorario = ".$k
                            ." AND ps.idDia = ".$l
                            ." AND ps.idSalon = es.idSalon";
                    $rs = $dbconn->Execute($select);
                    if ($rs->fields)
                        echo '<td><center>'.$rs->fields[1].'-'.$rs->fields[2].'</center></td>'; 
                    else
                        echo '<td>&nbsp;</td>';
                } 
             echo '</tr>'.$endl;   
        }
    echo '</tbody>'.$endl.'</table>'.$endl;    
}  
?>