<div id="sidebar">
<?php
if (!isset($_GET['seccion']))
 {
   foreach ($subsecciones['inicio'] as $sec => $titulo )
    echo '<div class="project"><a href="aplicacion.php?seccion='.$sec.'"><img src="images/'.$imagenes[$sec].'" /><br />'.$titulo.'</a></div>';
 }
else
 {
  $sec = $_GET['seccion'];
  $count = 0;
  foreach ($subsecciones[$sec] as $subsec => $titulo ) 
   {
    echo '<div class="project"><a href="aplicacion.php?seccion='.$sec.'&subsec='.$subsec.'"><img src="images/'.$imagenes[$subsec].'" /><br />'.$titulo.'</a></div>';
    $count++;
   }
  if ($count < 4)
   {
     for ($i=1; $i<(4-$count);$i++)
       echo '<div class="project">&nbsp;</div>';	
   }
}     
?>
</div>


