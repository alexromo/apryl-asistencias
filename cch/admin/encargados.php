<?php

echo '<h2>'.$subsecciones[$seccion][$subseccion].'</h2>';
?>
<form name="altaencargados" >
<fieldset>
<legend>Alta de Encargados</legend>
<label for="nombre">Nombre :</label> 
<input type="text" size="30 " maxsize="30" name="nombre" id="nombre" />
<input type="button" value="Dar de Alta" name="altaencargado" onclick="insertaEncargado($F('nombre'))" />
<div id="status"></div>
</fieldset>
</form>
<br />
<div class="tabla" id="lista" >
</div>
<script type="text/javascript" charset="utf-8">
	actualizaEncargados();
</script>