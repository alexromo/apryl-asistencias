<?php

if ((!isset($_REQUEST['ciclo'])) && (!isset($_REQUEST['profesor'])) && (!isset($_REQUEST['justif'])))
{
   echo 'Error'; 
}   
else
{     
   include_once("../conf/dbconfig.php"); 
   include('../conf/localeconf.php');
   
   //Da de alta la Justificacion si no existia
   //Obtiene el idJustificacion en cualquier caso 
   
   $idJustificacion = (int) $_REQUEST['justif'];
   
   if (!is_numeric($_REQUEST['justif']))
     {  
       $just = trim($_REQUEST['justif']);                
       $select = "SELECT * FROM Justificacion WHERE Justificacion = '".$just."'";
       $rs = $dbconn->Execute($select);
       if ($rs->fields) $idJustificacion = $rs->fields[0];   
       if (!$rs->fields) 
            {    
              $insert = "INSERT INTO Justificacion (Justificacion) VALUES ('".$just."')";
              $rs = $dbconn->Execute($insert);  
              $idJustificacion = $dbconn->Insert_ID();
            } 
             
     } 
   
       
     
   // Inserta el justificante con su justificacion
   //                                       
   $insert = 'INSERT INTO Justificante (idProfesor,idCicloEscolar,FechaAlta,idJustificacion) VALUES ('.$_REQUEST['profesor'].','.$_REQUEST['ciclo'].', CURRENT_TIMESTAMP,'.$idJustificacion.')';
   $rs = $dbconn->Execute($insert); 
   $idJustificante = $dbconn->Insert_ID();
   echo $idJustificante;   
}       
?>