<?php

echo '<h2>'.$subsecciones[$seccion][$subseccion].'</h2>';
?>
<form name="altarondines">
<fieldset>
<legend>Alta de Rondines</legend>
<label for="encargado">Encargado :</label> 
<select name="encargado" id="encargado">  
</select>
<input type="button" value="Dar de Alta" name="altarondin" onclick="insertaRondin($F('encargado'))" />
<div id="status"></div>
</fieldset>
</form>
<br />
<div class="tabla" id="lista" >
</div>
<script type="text/javascript" charset="utf-8">
	insertaDropDown('usuarios','encargado');
	actualizaRondines('N');
</script>
