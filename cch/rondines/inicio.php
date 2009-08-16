<?php 

include_once('php/conf/dbconfig.php'); 

echo '<h2>Ciclo Escolar : '.$_SESSION['ciclo'].'</h2>';

echo '<form>';
echo '<fieldset>';
echo '<legend>Rondines Registrados</legend>'; 
$query = "SELECT COUNT(*) FROM Rondin";
$rs = $dbconn->Execute($query);
echo '<h3>Totales: '.$rs->fields[0].'</h3>';
echo '</fieldset>';

echo '<fieldset>';
echo '<legend>Rondines Capturados Completamente</legend>';
$query = "SELECT COUNT(*) FROM Rondin WHERE status='S'";
$rs = $dbconn->Execute($query);
echo '<h3>Totales: '.$rs->fields[0].'</h3>';
echo '</fieldset>';

echo '<fieldset>';
echo '<legend>Rondines Parcialmente Capturados</legend>';
$query = "SELECT COUNT(*) FROM Rondin WHERE status ='P'";
$rs = $dbconn->Execute($query);
echo '<h3>Totales: '.$rs->fields[0].'</h3>';
echo '</fieldset>';  

echo '<fieldset>';
echo '<legend>Justificantes Capturados</legend>';
$query = "SELECT COUNT(*) FROM Justificante ";
$rs = $dbconn->Execute($query);
echo '<h3>Totales: '.$rs->fields[0].'</h3>';
$query ="SELECT COUNT(*) FROM Justificante WHERE idCicloEscolar = ".$_SESSION['ceid'];
$rs = $dbconn->Execute($query);
echo '<h3>En este Ciclo Escolar: '.$rs->fields[0].'</h3>';
echo '</fieldset>';

echo '</form>';
?>