<?php
include_once('../php/conf/dbconfig.php');
// login.php - performs validation 

// authenticate using form variables
$status = authenticate($_POST['username'], $_POST['password']);
// if  user/pass combination is correct

if (!is_numeric($status))
{  
	//include_once('adodb/session/adodb-session2.php');
	//include_once("../php/conf/dbsessionconfig.php");
    
    // iniciar sesion
    //adodb_sess_open(false,false,$connectMode=false);
	session_start();
	 
	$day = date('N');
    $hora = date('G:00'); 
    $diasemana = date('w');
    $fecha = date('Y-m-d');
    $solofecha = $fecha.' '.$hora;
    $_SESSION['solofecha'] = $solofecha;
    
    $select = "SELECT idCicloEscolar,Ciclo FROM CicloEscolar WHERE ('".$fecha."' BETWEEN inicio AND fin )";
    $rs = $dbconn->Execute($select);

    if (!$rs->fields) 
        { 
          $idCicloEscolar = 0;         
          $_SESSION['ceid'] = 0;    
          $cicloescolar =  'INTER';
          $_SESSION['ciclo'] = 'INTER';  
        }
    else 
        {
         $idCicloEscolar = $rs->fields[0];         
         $_SESSION['ceid'] = $rs->fields[0];
         $cicloescolar =  $rs->fields[1]; 
         $_SESSION['ciclo'] = $rs->fields[1];
        }
    
	
	// declarar unas variables de sesion
	$_SESSION['username'] = $_POST['username']; 
	$_SESSION['role'] = $status->fields[2]; 
	$_SESSION['nombre'] = $status->fields[1];
    $_SESSION['uid'] = $status->fields[0]; 
    $_SESSION['dia'] = $day; 
    $_SESSION['hora'] = $hora; 
    $_SESSION['diasemana'] = $diasemana;
   	
    $select = "SELECT idHorario FROM Horario WHERE Horario ='".$hora."'";
	$rs = $dbconn->Execute($select);

	if (!$rs->fields) 
	    {
	        echo "No hay clases a esta hora,contactar al Administrador.";  
	    }    
	else 
	    {
	        $_SESSION['hrid'] = $rs->fields[0]; 
	    }    
           
	if ($status->fields[2] == 2)      // Es encargado
	  {
	    if ($db == 'mysql')  
		    $query = "SELECT idRondin,FechaHora,idCicloEscolar FROM Rondin WHERE idEncargado = ".$status->fields[0]." AND status = 'N'";
		if ($db == 'ado_mssql')
		    $query = "SELECT idRondin,CONVERT(VARCHAR(20), FechaHora, 100),idCicloEscolar FROM Rondin WHERE idEncargado = ".$status->fields[0]." AND status = 'N'";
		$result = $dbconn->Execute($query);
		
		if (!$result->fields) 
		    {
		// redirect to protected page;
			    header("Location: rondines.php?seccion=registrarondin"); 
			}    
		else
		    {
		        $idRondin = $result->fields[0]; 
			    $_SESSION['rondin'] =  $result->fields[0];
            
                $time = strtotime($result->fields[1]);
                $_SESSION['ceid'] = $result->fields[2];
                
                $fecha = date('d/m/Y H:i',$time);
                $solofecha = date('Y-m-d H',$time);
                $day = date('N',$time);
                $diasemana = date('w',$time);
                $hora = date('G',$time).':00'; 
	
                $_SESSION['rfecha'] = $fecha;
                $_SESSION['solofecha'] = $solofecha; 
                $_SESSION['dia'] = $day;
                $_SESSION['diasemana'] = $diasemana;
                $_SESSION['hora'] = $hora;
            
                $select = "SELECT idHorario FROM Horario WHERE Horario ='".$hora."'";
        	    $rs = $dbconn->Execute($select);

        	    if (!$rs->fields) 
        	        {
        	            echo "No hay clases a esta hora,contactar al Administrador."; 
        	        }    
        	    else 
        	        {
        	            $_SESSION['hrid'] = $rs->fields[0]; 
        		    }
			
		    header("Location: rondines.php?seccion=capturarondin&rondin=".$idRondin);
		  }
	}
	
	else
	    {
		    header("Location: index.php");
		}     
	exit();
}
else
// username/password no son correctos
{
   	// redirige a la pagina inicial
	header("Location: index.php");
	exit();
}

function authenticate($user, $pass)
{
    global $dbconn,$db;
	
	if ( $db == 'mysql' )
	    $query = "SELECT id,nombre,role FROM usuarios WHERE username = '$user' AND password = PASSWORD('$pass') AND activo = 1";
	if ( $db == 'ado_mssql')
	    $query = "SELECT id,nombre,role FROM usuarios WHERE username = '$user' AND PwdCompare('$pass',password) = 1  AND activo = 1";
	$result = $dbconn->Execute($query);
	if (!$result->fields)
	{
     return 0;
	}
	else
	{
     return $result;
	}
}

?>
