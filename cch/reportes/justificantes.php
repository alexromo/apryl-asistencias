
<form name="reportejustificantes" >
<fieldset>
<h1>Reporte de Justificantes</h1>  
<label for="ciclo">Ciclo Escolar :</label>
<select name="ciclo" id="ciclo" onchange="if ($F('profesor') != 0 && $F('ciclo') != 0) {actualizaJustificantesxProfesor($F('profesor'));$('justificantesxprofesor').innerHTML='';$('lista').innerHTML='';}" > 
</select>
<br />
<label for="profesor">Profesor :</label>
<select name="profesor" id="profesor" onchange="if ($F('profesor') != 0 && $F('ciclo') != 0) {actualizaJustificantesxProfesor($F('profesor'));$('justificantesxprofesor').innerHTML='';$('lista').innerHTML='';}" > 
</select> 
<br /><br />
<div class="tabla" id="justificantesxprofesor">
</div>        
</fieldset>
</form>  
<div class="tabla" id="lista">
</div>
<script type="text/javascript" charset="utf-8">
insertaDropDown('CicloEscolar','ciclo');
insertaDropDown('ProfesorJustificante','profesor');   
</script>
