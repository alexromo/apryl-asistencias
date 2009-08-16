<?php
 if (!isset($_REQUEST['rondin'])) 
{
	echo '<span class="error">Seleccione un Rondin y vuelvalo a intentar.</span>';
}
else 
{ 
 include('../conf/dbconfig.php');
 include('../conf/localeconf.php');
  
 $query = 'SELECT DISTINCT Edificio,Edificio FROM EdificioSalon ORDER BY 1';
 $edificios = $dbconn->GetAssoc($query);

 function createSelect($array,$id,$label,$action)
 {
   echo '<label for="'.$id.'">'.$label.'</label>';
   echo '<select name="'.$id.'" id="'.$id.'" '.$action.'>';
   echo '<option value="0" selected="selected" >Elija</option>';
   foreach ($array as $index => $value)
     {
       echo '<option value="'.$index.'">'.$value.'</option>';	 
     }
   echo '</select>';	
 }

 echo '<form name="captura" id="captura">';
 //echo '<input type="hidden" value="'.$_REQUEST['rondin'].'" id="rondin" />';
 createSelect($edificios,'edificio','Edificio :','onchange="imprimeCaptEdificio($F(\'edificio\'))"');
 echo '<br />';
 echo '<div id="edificiofrm">';
 echo '</div></form>';
}
?>