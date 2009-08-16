<?php
if (!isset($_REQUEST['area']) || ($_REQUEST['area'] == 0) ||
    !isset($_REQUEST['ciclo']) || ($_REQUEST['ciclo'] == 0)
   )
    {
        echo '<span class="error">Debe seleccionar una area.</span>';
    }
else
    {
        include('../conf/dbconfig.php'); 
        include('../conf/localeconf.php');
        
        $idArea = $_REQUEST['area']; 
        $idCicloEscolar = $_REQUEST['ciclo'];
        $table = '';
        $table1 = '';
        $table2 = '';
        $asistencias = $faltas = 0; 

        
        # Tabla Resumen
        $query = "SELECT  ap.idStatus,count(*)"
                ." FROM AsistenciaProfesores ap, Rondin rd, ProfesorSalon ps, Materia ma, Area ar" 
                ." WHERE ap.idRondin = rd.idRondin"
                ." AND rd.status = 'S'"
                ." AND rd.idCicloEscolar = ".$idCicloEscolar
                ." AND ap.idProfesorSalon = ps.idProfesorSalon"
                ." AND ps.idMateria = ma.idMateria" 
                ." AND ma.idArea = ar.idArea"
                ." AND ar.idArea = ".$idArea
                ." GROUP BY ar.idArea,ap.idStatus";
        
        $rs = $dbconn->Execute($query);
        
        if (!$rs->fields) $table = '<div class="error">No hay Registros</div>';
        else {
                $table =  '<table width="95%" cellspacing="1" >'
                         .'<thead><tr><th colspan="2">RESUMEN</th></tr></thead>'
                         .'<tbody>';
                $asistencias=$faltas=$faltasjustificadas=0;         
                foreach ($rs as $k => $row)
                    {    
                        if ($row[0] == 1)
                            $asistencias = $row[1];
                        if ($row[0] == 2)
                            $faltas = $row[1];
                        if ($row[0] == 3)
                            $faltasjustificadas = $row[1];
                    }
                    $table .= '<tr><th width="150">ASISTENCIAS</th><td><b>'.$asistencias.'</b> ('.sprintf("%01.2f",($asistencias/($faltas+$faltasjustificadas+$asistencias)*100)).'%)</td></tr>'; 
                    $table .= '<tr><th width="150">FALTAS</th><td><b>'.$faltas.'</b> ('.sprintf("%01.2f",($faltas/($faltas+$faltasjustificadas+$asistencias)*100)).'%)</td></tr>';
                    $table .= '<tr><th width="150">FALTAS JUSTIFICADAS</th><td><b>'.$faltasjustificadas.'</b> ('.sprintf("%01.2f",($faltasjustificadas/($faltas+$faltasjustificadas+$asistencias)*100)).'%)</td></tr>';   
                $table .= '</tbody></table><br />';
               $js = '<script>DrawPieChart('.$asistencias.','.$faltas.','.$faltasjustificadas.');</script><input type="button" value="Muestra/Oculta Grafica " onclick="DrawPieChart('.$asistencias.','.$faltas.','.$faltasjustificadas.');$(\'graphcontainer\').toggle();" />';
                
                # Asistencias Detalle
                
                $query = "SELECT  ma.idMateria,ma.Materia,count(*)"
                        ." FROM AsistenciaProfesores ap, Rondin rd, ProfesorSalon ps, Materia ma, Area ar" 
                        ." WHERE ap.idRondin = rd.idRondin"
                        ." AND rd.status = 'S'"
                        ." AND rd.idCicloEscolar = ".$idCicloEscolar
                        ." AND ap.idStatus = 1"
                        ." AND ap.idProfesorSalon = ps.idProfesorSalon"
                        ." AND ps.idMateria = ma.idMateria"
                        ." AND ma.idArea = ar.idArea"
                        ." AND ar.idArea = ".$idArea
                        ." GROUP BY ma.idMateria,ma.Materia";   
                
                $rs = $dbconn->Execute($query);

                if (!$rs->fields) $table1 = '<div class="error">No hay Asistencias Registradas</div>';
                else {
                        $table1 = '<table width="95%" cellspacing="1" >'
                                 .'<thead><tr><th colspan="5">ASISTENCIAS</th></tr><tr><th>id</th><th>Materia</th><th>Asistencias</th></thead>'
                                 .'<tbody>';
                        foreach ($rs as $k => $row)
                            {
                                $table1 .= "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td>";
                            }
                        $table1 .= '</tbody></table><br />';
                }

                # Faltas Detalle

                $query = "SELECT  ma.idMateria,ma.Materia,SUM(IF (ap.idStatus = 2,1,0)),SUM(IF (ap.idStatus = 3,1,0)),COUNT(*)"
                        ." FROM AsistenciaProfesores ap, Rondin rd, ProfesorSalon ps, Materia ma, Area ar" 
                        ." WHERE ap.idRondin = rd.idRondin"
                        ." AND rd.status = 'S'"
                        ." AND rd.idCicloEscolar = ".$idCicloEscolar
                        ." AND ap.idStatus in  (2,3)"
                        ." AND ap.idProfesorSalon = ps.idProfesorSalon"
                        ." AND ps.idMateria = ma.idMateria"
                        ." AND ma.idArea = ar.idArea"
                        ." AND ar.idArea = ".$idArea
                        ." GROUP BY ma.idMateria,ma.Materia";
                $rs = $dbconn->Execute($query);

                if (!$rs->fields) $table2 = '<div class="error">No hay Faltas Registradas</div>';
                else {
                        $table2 = '<table width="95%" cellspacing="1" >'
                                 .'<thead><tr><th colspan="5">FALTAS</th></tr><tr><th>id</th><th>Materia</th><th>Faltas</th><th>F. Just.</th><th>Total</th></thead>'
                                 .'<tbody>';
                        foreach ($rs as $k => $row)
                            {
                                $table2 .= "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
                            }
                        $table2 .= '</tbody></table><br />';
                }
        }
        if (!isset($_REQUEST['arch']))
            {
                echo $js.$table.$table1.$table2 ;
                
             }
        else
                return $table.$table1.$table2;
                
        
    }
    
?>
