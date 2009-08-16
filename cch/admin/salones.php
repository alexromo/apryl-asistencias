<?php

echo '<h2>'.$subsecciones[$seccion][$subseccion].'</h2>';
?>
<form name="altasalones" >
<fieldset>
<legend>Alta de Edificios/Salones</legend>
<label for="edificio">Edificio :</label> 
<input type="text" size="8 " maxsize="8" name="edificio" id="edificio" />
<label for="salon">Sal&oacute;n :</label>
<input type="text" size="8 " maxsize="8" name="salon" id="salon" />
<input type="button" value="Dar de Alta" name="altasalon" onclick="insertaSalon($F('edificio'),$F('salon'))" />
<div id="status"></div>
</fieldset>
</form>
<br />
<form name="filtroEdificios">
<fieldset>
	<label for="selectEdificio">Edificio :</label>
	<select name="selectEdificio" id="selectEdificio" onchange="actualizaSalones($F('selectEdificio'));">
	</select>
<input type="button" value="Actualizar" onclick="actualizaSalones($F('selectEdificio'));" />
<br />
<br />
<div class="tabla" id="lista">
</div>
</fieldset>
</form>

<script type="text/javascript" charset="utf-8">
    insertaDropDown('EdificioSalonEdif','selectEdificio');
	actualizaSalones();
</script>