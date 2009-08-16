<script src="js/rico.js"></script> 
<script>
    Rico.loadModule("Calendar");
    var cal1.cal2; 
    var hoy = '<?php echo date('d/m/Y')?>';
    
    Rico.onLoad( function()
    {
     $('inicio').value=hoy;
     $('fin').value=hoy;
     cal1 = new Rico.CalendarControl("calendario");
     cal1.atLoad();
     
     cal1.returnValue=function(newVal) { var fechamex = newVal.split("-"); 
      		$('inicio').value=fechamex[2]+"/"+fechamex[1]+"/"+fechamex[0]; };
      		
     cal2 = new Rico.CalendarControl("calendario");
     cal2.atLoad();
     cal2.returnValue=function(newVal) { var fechamex = newVal.split("-"); 
             $('fin').value=fechamex[2]+"/"+fechamex[1]+"/"+fechamex[0]; }; 		
    }
    );
    function CalendarClick(e) {
      if (Element.visible(cal1.container)) {
        cal1.close();
      } else {
        RicoUtil.positionCtlOverIcon(cal1.container,$('anchor1'));
        cal1.open();
      }
      Event.stop(e);
    }
</script>

<?php
echo '<h2>'.$subsecciones[$seccion][$subseccion].'</h2>';
?>

<form name="altaciclos">
<fieldset>
<legend>Alta de Ciclos Escolares</legend>
<div>
<label for="anio">Ciclo Escolar :</label> 
<select name="anio" id="anio">
    <option value="2011" selected="selected">2011</option>
	<option value="2012">2012</option>
</select>
<select name="semestre" id="semestre">
    <option value="2" selected="selected">2</option>
    <option value="1">1</option>
</select>
<br />
<label for="inicio">Inicia:</label>  
<input type="text" name="inicio" id="inicio" size="10" readonly="readonly" /> 
<input type="button" name="anchor1" id="anchor1" value="Calendario"  onclick="CalendarClick(event);" />
<br />
<label for="fin">Finaliza:</label>  
<input type="text" name="fin" id="fin" size="10" readonly="readonly" /> 
<input type="button" name="anchor2" id="anchor2" value="Calendario"  onclick="CalendarClick(event);" />
<br />
<input type="button" value="Dar de Alta" name="altaciclo" onclick="insertaCiclo($F('anio'),$F('semestre'))" />
<div id="status"></div>
</div>
</fieldset>
</form>

<br />
<div class="tabla" id="lista" >
</div>
<script type="text/javascript" charset="utf-8">
	actualizaCiclos();
</script>