<?php
// login.php - performs validation  
include_once('php/conf/dbconfig.php');

// autenticar 
$status = authenticate($_POST['username'], $_POST['password']);

// si el username y password son correctos
if (!is_numeric($status))
{	
	//include_once('adodb/session/adodb-session2.php');
	//include_once("php/conf/dbsessionconfig.php");
	
	// iniciar una sesion
    //adodb_sess_open(false,false,$connectMode=false);
	session_start();
	 
	$userid = $status->fields[0]; 
	$nombre = $status->fields[1];
	$role = $status->fields[2];
	
	// Calcula valores relacionados con la fecha actual
	$day = date('N');
    $hora = date('G').':00'; 
    $diasemana = date('w');
    $fecha = date('Y-m-d');
     
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
	
	// registro de algunas variables de sesion   
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['role'] = $role;
	$_SESSION['nombre'] = $nombre;
	$_SESSION['uid'] = $userid; 
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
    
    $select = "SELECT idCicloEscolar FROM CicloEscolar WHERE Ciclo ='".$cicloescolar."'";
	$rs = $dbconn->Execute($select);

    if (!$rs->fields)
        { 
           echo "No existe el ciclo escolar contactar al Administrador.";  
        }    
    else
        { 
           $_SESSION['ceid'] = $rs->fields[0];
  	    }	 
    	
    	
    if ($status->fields[2] == 2)  // Es encargado
      {
          if ($db == 'mysql')  
  		    $query = "SELECT idRondin,FechaHora,idCicloEscolar FROM Rondin WHERE idEncargado = ".$status->fields[0]." AND status = 'N'";
  		if ($db == 'ado_mssql')
  		    $query = "SELECT idRondin,CONVERT(VARCHAR(20), FechaHora, 100),idCicloEscolar FROM Rondin WHERE idEncargado = ".$status->fields[0]." AND status = 'N'";
  		$result = $dbconn->Execute($query);
  		
  		if ($result->fields)
  		  {
    	      $_SESSION['rondin'] =  $result->fields[0];

              $time = strtotime($result->fields[1]);
              $_SESSION['ceid'] = $result->fields[2];
              $fecha = date('d/m/Y H:i',$time);
              $day = date('N',$time);
              $hora = date('G',$time).':00'; 
              $diasemana = date('w',$time);
              $year = date('Y',$time);
    	      $month = date('m',$time);
    	      $semestre = ($month <= 6)
    	                ?  '2'
    	                :  '1';

              $cicloescolar = $year.'-'.$semestre;

              $_SESSION['rfecha'] = $fecha;
      	      $_SESSION['ciclo'] = $cicloescolar;
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
 	      }
      }
    	
    header("Location: aplicacion.php");
    exit();
    }
else
// user/pass check failed
{
   	// redirect to error page
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
