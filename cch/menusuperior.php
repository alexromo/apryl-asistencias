<div id="menu">
<?php

foreach ( $secciones as $seccion => $titulo ) {
    if ($seccion == 'inicio') 
	echo '<a href="aplicacion.php">'.$titulo.'</a> &nbsp; &nbsp; &nbsp; &nbsp;';
    else
	echo '<a href="aplicacion.php?seccion='.$seccion.'">'.$titulo.'</a> &nbsp; &nbsp; &nbsp; &nbsp;';
}

?>
<a href="logout.php">Salir</a> &nbsp; &nbsp; &nbsp; &nbsp;
</div>
<div id="header">
<a href="#">Asistencias <?= $sec ?></a>
<div id="logged">
Conectado como : <?php echo $_SESSION['nombre'];  ?> <br />
Ciclo Escolar :  <?php echo $_SESSION['ciclo'];  ?><br />
[<?php echo date('d/m/Y H:i');  ?>]
</div>
</div>
