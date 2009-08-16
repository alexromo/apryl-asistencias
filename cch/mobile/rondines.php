<?php
include_once('checasesion.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<title>CCH :: Asistencia Profesores::<?php echo $_SESSION['solofecha']; ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css" /> 
<script src="js/util.js"></script>
</head>

<body>
<div id="container">

<div id="menu">
    <div id="cierrarondin" >
 <?php
if (isset($_REQUEST['rondin']))
 
 
  echo '<input type="button" id="btn_crondin" value="Cerrar Rondin" onclick="location.href=\'rondines.php?seccion=cierrarondin&rondin='.$_REQUEST['rondin'].'\'" disabled="disabled" />';  
?>
    
    </div>
    <a href="logout.php">Salir</a>
</div>

<div id="header"><a href="#">Rondines [<?php echo date('d-m-Y H:i');echo " Ciclo:".$_SESSION['ciclo']; echo " Horario:".$_SESSION['hora'];  ?>]</a></div>

<div id="main">

<?php
if (!isset($_GET['seccion']))
{
 echo '<h2>Inicio</h2>';
}
else
{ 
  $seccion = $_GET['seccion'];	 
  include('rondines/'.$seccion.'.php');    
}
?>
<div class="clear"></div>
</div>

<div id="footer">&copy;2008 ASR &nbsp;<span class="separator">|</span> &nbsp;CCH</div>

</div>
</body>
</html>
