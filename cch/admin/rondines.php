
<form name="cierrarondines" >
<fieldset>
<h1>Cierre de Rondines</h1> 
<label for="rondin">Rondin :</label> 
<select name="rondin" id="rondin">
</select>
<input type="button" name="cierra" value="Cerrar Rond&iacute;n" id="cierra" onclick="cierraRondin($F('rondin'))" />       
<div id="status"></div>
</fieldset>
</form>
<div class="tabla" id="lista" >	
</div>
<script type="text/javascript" charset="utf-8">
    insertaDropDown('Rondin','rondin');
    actualizaRondines('P');
</script>