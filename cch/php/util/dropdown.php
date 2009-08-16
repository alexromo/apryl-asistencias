<?php
if (!isset($_REQUEST['tabla']))
{
 echo 'Error';	
}
else
{
	$tabla = $_REQUEST['tabla'];
	
	$filter = '';
	if (isset($_REQUEST['columna']) && isset($_REQUEST['valor'])) 
	    {
	        $columna = $_REQUEST['columna'];
            $valor = $_REQUEST['valor'];
    	    $filter = $columna." = ".$valor; 
	    }
	
	include_once ("../conf/dbconfig.php");
	include('../conf/localeconf.php');
	 
	if ($db == 'mysql') 
	    {
            $fechahora = 'r.FechaHora'; 
            $fechaalta = 'ju.FechaAlta';
        }   
    if ($db == 'ado_mssql')
        {
            $fechahora = 'CONVERT(VARCHAR(20),r.FechaHora,120)'; 
            $fechaalta = 'CONVERT(VARCHAR(20),ju.FechaAlta,120)';
	    }
	switch ($tabla)
	{
	case 'Rondin':
	    if ($filter != '') $filter = " AND ".$filter; 
		$select = "SELECT r.idRondin, u.nombre, $fechahora"
				  ." FROM Rondin r, usuarios u"
				  ." WHERE r.idEncargado = u.id"
				  ." AND r.status ='N'"
				  .$filter
				  ." ORDER BY r.idRondin"; 
		$option = '<option value="0" selected="selected" > Rondin ... </option>';		  
		break;
	case 'Rondin_S':
	    if ($filter != '') $filter = " AND ".$filter;
    	$select = "SELECT r.idRondin, u.nombre, $fechahora"
    			  ." FROM Rondin r, usuarios u"
    			  ." WHERE r.idEncargado = u.id"
    			  ." AND r.status ='S'"
    			  .$filter
    			  ." ORDER BY r.idRondin";   
    	$option = '<option value="0" selected="selected" > Rondin ... </option>';		  
    	break; 
    case 'Rondin_SP':
        if ($filter != '') $filter = " AND ".$filter;
        $select = "SELECT r.idRondin, u.nombre, $fechahora"
        		  ." FROM Rondin r, usuarios u"
        		  ." WHERE r.idEncargado = u.id"
        		  ." AND r.status <> 'N'"
        		  .$filter
        		  ." ORDER BY r.idRondin";   
        $option = '<option value="0" selected="selected" > Rondin ... </option>';		  
        break;   
    case 'Justificante':
        if ($filter != '') $filter = " AND ".$filter;
        $select = "SELECT ju.idJustificante, pr.Nombre, $fechaalta "
        		  ." FROM Justificante ju, Profesor pr"
        		  ." WHERE ju.idProfesor = pr.idProfesor"
        		  .$filter
        		  ." ORDER BY ju.idJustificante DESC";   
        $option = '<option value="0" selected="selected" > Justificante ... </option>';		  
        break;					
	case 'usuarios':
	    if ($filter != '') $filter = " AND ".$filter;
	    $filterencargado = (isset($_SESSION['uid']))?" AND id = ".$_SESSION['uid']." ":"";   
	    $select = "SELECT id,nombre FROM usuarios WHERE role = 2 ".$filterencargado.$filter." ORDER BY nombre";
	    $option = '<option value="0" selected="selected" > Usuario ... </option>';	
	    break;		
	case 'EdificioSalonEdif' :
	    if ($filter != '') $filter = " WHERE ".$filter;
	    $select = "SELECT DISTINCT Edificio"
	             ." FROM EdificioSalon"
	             .$filter
	             ." ORDER BY 1";	
	    break;
	case 'Profesor' :
	    if ($filter != '') $filter = " WHERE ".$filter;
    	$select = "SELECT * FROM $tabla"
    	        .$filter
    	        ." ORDER BY 2";
    	$option = '<option value="A" selected="selected" > Profesor ...</option>';	
    	break;
    case 'ProfesorJustificante' :
        if ($filter != '') $filter = " AND ".$filter;
      	$select = "SELECT DISTINCT jt.idProfesor, pr.Nombre"
                ." FROM Justificante jt, Profesor pr"
                ." WHERE jt.idProfesor = pr.idProfesor"
                .$filter
                ." ORDER BY 2";
       	$option = '<option value="0" selected="selected" > Profesor ...</option>';	
       	break;	
	case 'Justificacion' :
	    if ($filter != '') $filter = " AND ".$filter;
	    $select = "SELECT * FROM $tabla"
	            .$filter
	            ." ORDER BY 1";
		$option = '<option value="0" > Elija </option>';
		break;    
	default : 
	    if ($filter != '') $filter = " WHERE ".$filter;
		$select = "SELECT * FROM $tabla"
		        .$filter
		        ." ORDER BY 1";
		$option = '<option value="0" selected="selected" > Elija </option>';
		break;
	}			
	$rs = $dbconn->Execute($select);
	
	echo $option;
	foreach ($rs as $k => $row) 
	{   
		switch ($tabla)
		{
		case 'EdificioSalon':	
			echo '<option value="'.$row[0].'">'.$row[1].' - '.$row[2].'</option>';
			break;
		case 'Rondin' :
		case 'Rondin_S' :
		case 'Rondin_SP' :
		case 'Justificante':
		    echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].' - '.date('d/m/Y',strtotime($row[2])).'</option>';
		    break;
		case 'EdificioSalonEdif' :
			echo '<option value="'.$row[0].'">'.$row[0].'</option>';
			break;
		default :
	        echo '<option value="'.$row[0].'">'.$row[1].'</option>';
	        break;
        }
	  }
}
?>