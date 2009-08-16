<?php
if ($_REQUEST['rondin'] == '0' )
{
  echo '<span class="error">Seleccione un Rond&iacute;n</span>';  
}
else
{
    include('../conf/dbconfig.php');
    
    $update = "UPDATE Rondin SET status = 'P' WHERE idRondin =".$_REQUEST['rondin'];
    $rs = $dbconn->Execute($update);
    
    echo '<span class="error">Rond&iacute;n cerrado con &eacute;xito</span>';
}
?>
