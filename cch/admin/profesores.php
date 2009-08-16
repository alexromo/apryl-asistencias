<?php

echo '<h2>'.$subsecciones[$seccion][$subseccion].'</h2>';
?>
<form name="altaprofesores" >
<fieldset>
<legend>Alta de Profesores</legend>
<label for="nombre">Nombre :</label> 
<input type="text" size="30 " maxsize="30" name="nombre" id="nombre" />
<input type="button" value="Dar de Alta" name="altaprofesor" onclick="insertaProfesor($F('nombre'))" />
<div id="status"></div>
</fieldset>
</form>
<br />
<div class="tabla" id="lista" >
</div>
<script type="text/javascript" charset="utf-8">
	actualizaProfesores();
</script>