<?php

echo '<h2>'.$subsecciones[$seccion][$subseccion].'</h2>';
?>
<form name="altausuarios" >
<fieldset>
<legend>Alta de Usuarios</legend>
<label for="username">username :</label> 
<input type="text" size="30 " maxsize="30" name="username" id="username" />
<br />
<label for="password">password :</label> 
<input type="text" size="16 " maxsize="16" name="password" id="password" />
<br />
<label for="nombre">Nombre :</label> 
<input type="text" size="16 " maxsize="16" name="nombre" id="nombre" />
<select id="role" name="role">
</select>    
<input type="button" value="Dar de Alta" name="altaencargado" onclick="insertaUsuario($F('username'),$F('password'),$F('nombre'),$F('role'))" />
<div id="status"></div>
</fieldset>
</form>
<br />
<div class="tabla" id="lista" ></div>
<script type="text/javascript" charset="utf-8">
    insertaDropDown('roles','role');
	actualizaUsuarios();
</script>