<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CCH :: Sistema de Asistencias :: Login</title>
<link rel="stylesheet" type="text/css" href="css/login.css" />
<script src="js/prototype.js"></script>
</head>
<body onload="$('username').focus()">

<div id="logcont">
<center><h3>CCH :: Sistema de Asistencias</h3></center>
<table cellpadding="5" width="90%">
<form method="post" action="login.php">	
<tr>
<td align="right"><legend for="username">usuario:</legend></td>
<td><input type="text" name="username" id="username" size="10" maxsize="12" tabindex="1" /></td>
</tr>
<tr>
<td align="right"><legend for="password">contrase&ntilde;a:</legend></td>
<td><input type="password" name="password" id="password" size="10" maxsize="12" tabindex="2" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="submitok" value="Entrar" tabindex="3" /></td>
</tr>
</form>
</table>  
</div>
</div>

</body>
</html>
