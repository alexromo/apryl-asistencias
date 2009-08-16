<?php
  if (!isset($_REQUEST['username']) && !isset($_REQUEST['password']) && !isset($_REQUEST['nombre']) && ($_REQUEST['role'] == '0'))
  {
   echo '<span class="error">Verifique los datos que introdujo y vuelvalo a intentar.</span>';
  }
  else
  {
   $nombre = trim($_REQUEST['nombre']);
   $username = trim($_REQUEST['username']);
   $password = trim($_REQUEST['password']);

   if (($nombre != '') && ($password != '') && ($username != ''))
     {
      include('../conf/dbconfig.php');

 	 $select = "SELECT COUNT(*) "
 	         ."FROM usuarios "
 	         ."WHERE username = '".$username."'";
  	 $rs = $dbconn->Execute($select);

      if ($rs->fields[0] >= 1)
         {
          echo '<span class="error">Ese username ya esta dado de alta.</span>';
         }
  	 else
        {
 	        if ($db == 'ado_mssql')
 	    	    $insert = "INSERT INTO usuarios (username,password,nombre,role,activo) VALUES ('$username',PwdEncrypt('$password'),'$nombre',".$_REQUEST['role'].",1)";
 	        if ($db == 'mysql')
 	    	    $insert = "INSERT INTO usuarios (username,password,nombre,role,activo) VALUES ('$username',PASSWORD('$password'),'$nombre',".$_REQUEST['role'].",1)";	
 	        $dbconn->Execute($insert);

            echo '<span class="exito">Encargado Registrado con exito</span>';
        }
     }
   else 
      echo '<span class="error">Verifique los datos que introdujo y vuelvalo a intentar.</span>';
 }  
 
?>