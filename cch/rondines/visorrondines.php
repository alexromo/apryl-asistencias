
<form name="verrondin" >
<fieldset>
<h1>Visor de Rondines</h1>
<label for="ciclo">Ciclo Escolar :</label>
<select name="ciclo" id="ciclo" onchange="if  ($F('ciclo') != 0 )   { insertaDropDownFilter('Rondin_SP','rondin','idCicloEscolar',$F('ciclo')); }" > 
</select>
<br />                            
<label for="rondin">Rondin :</label>    
<select name="rondin" id="rondin" onchange="if  ($F('rondin') != 0 && $F('ciclo') != 0 )   { actualizaDetalleRondin($F('rondin'));}" > 
</select>
<br /><br />
<div class="tabla" id="clases">
</div>        
<div id="status"></div>   
</fieldset>
</form>  
<div class="tabla" id="lista">
</div>    
<script type="text/javascript" charset="utf-8">
    insertaDropDown('CicloEscolar','ciclo');   
</script>
