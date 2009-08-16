<?php 

include_once('php/conf/dbconfig.php'); 

echo '<h2>Ciclo Escolar : '.$_SESSION['ciclo'].'</h2>';

echo '<form>';
echo '<fieldset>';
echo '<legend>Ciclos Escolares Registrados</legend>'; 
$query = "SELECT COUNT(*) FROM CicloEscolar";
$rs = $dbconn->Execute($query);
echo '<h3>'.$rs->fields[0].'</h3>';
echo '</fieldset>';

echo '<fieldset>';
echo '<legend>Usuarios Registrados</legend>';
$query = "SELECT COUNT(*) FROM usuarios";
$rs = $dbconn->Execute($query);
echo '<h3>'.$rs->fields[0].'</h3>';
echo '</fieldset>';

echo '<fieldset>';
echo '<legend>Profesores Registrados</legend>';
$query = "SELECT COUNT(*) FROM Profesor";
$rs = $dbconn->Execute($query);
echo '<h3>'.$rs->fields[0].'</h3>';
echo '</fieldset>';

echo '<fieldset>';
echo '<legend>Salones Registrados</legend>';
$query = "SELECT COUNT(*) FROM EdificioSalon";
$rs = $dbconn->Execute($query);
echo '<h3>'.$rs->fields[0].'</h3>';
echo '</fieldset>';

echo '<fieldset>';
echo '<legend>Clases Asignadas</legend>';
$query = "SELECT COUNT(*) FROM ProfesorSalon WHERE idCicloEscolar =".$_SESSION['ceid'];
$rs = $dbconn->Execute($query);
echo '<h3>'.$rs->fields[0].'</h3>';
echo '</fieldset>';

echo '</form>';     
?>