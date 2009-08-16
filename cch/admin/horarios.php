<?php

echo '<h2>'.$subsecciones[$seccion][$subseccion].'</h2>';
?>
<form name="altahorarios">
<fieldset>
<legend>Alta de Horarios de Profesores</legend>
<label for="ciclo">Ciclo Escolar :</label> 
<select name="ciclo" id="ciclo">  
</select>
<br />
<label for="profesor">Profesor :</label>
<select name="profesor" id="profesor">
</select>
<br />
<label for="salon">Salon :</label>
<select name="salon" id="salon">
</select>
<br />
<label for="dia">D&iacute;a :</label>
<select name="dia" id="dia">
</select>
<br />
<label for="horario">Horario :</label>
<select name="horario" id="horario">
</select>
<br />
<input type="button" value="Dar de Alta" name="altahorario" onclick="insertaHorario($F('ciclo'), $F('profesor'), $F('salon'), $F('dia'), $F('horario'))" />
<div id="status"></div>
</fieldset>
</form>
<br />
<form name="filtroHorarios">
<fieldset>
	<label for="selectCiclo">Ciclo :</label>
	<select name="selectCiclo" id="selectCiclo" onchange="actualizaHorarios($F('selectCiclo'),$F('selectProfesor'));">
	</select>
	<label for="selectProfesor">Profesor :</label>
	<select name="selectProfesor" id="selectProfesor" onchange="actualizaHorarios($F('selectCiclo'),$F('selectProfesor'));">
	</select>
<input type="button" value="Actualizar" onclick="actualizaHorarios($F('selectCiclo'),$F('selectProfesor'));" />
<br />
<br />
<div class="tabla" id="lista" >
</div>
</fieldset>
<script type="text/javascript" charset="utf-8">
	insertaDropDown('CicloEscolar','ciclo');
	insertaDropDown('EdificioSalon','salon');
	insertaDropDown('Profesor','profesor');
	insertaDropDown('Dia','dia');
	insertaDropDown('Horario','horario');
	insertaDropDown('CicloEscolar','selectCiclo');
	insertaDropDown('Profesor','selectProfesor');
	//actualizaHorarios(0,0);
</script>
