<div id="main">

<?php
if (!isset($_GET['seccion']))
{
 echo '<h2>Inicio</h2>';
}
else
{ 
  $seccion = $_GET['seccion'];	 
  if (!isset($_GET['subsec']))
    {     
      include($seccion.'/inicio.php');  
    }
 else
    {
     $subseccion = $_GET['subsec'];
     include($seccion.'/'.$subseccion.'.php');
    }    

}
?>
<div class="clear"></div>
</div>
