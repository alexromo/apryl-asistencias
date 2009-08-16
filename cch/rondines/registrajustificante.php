
<script src="js/rico.js"></script> 
    <script>
    Rico.loadModule("Calendar");
    var cal; 
    var hoy = '<?php echo date('d/m/Y')?>';
    Rico.onLoad( function()
    {
     $('fecha').value=hoy;
     cal = new Rico.CalendarControl("calendario");
     cal.atLoad();
     cal.returnValue=function(newVal) { var fechamex = newVal.split("-"); 
      		$('fecha').value=fechamex[2]+"/"+fechamex[1]+"/"+fechamex[0]; };
    }
    );
    function CalendarClick(e) {
      if (Element.visible(cal.container)) {
        cal.close();
      } else {
        RicoUtil.positionCtlOverIcon(cal.container,$('anchor1'));
        cal.open();
      }
      Event.stop(e);
    }
</script>
<form name="registrajustificante" >
<fieldset>
<h1>Registro de Justificantes</h1>  
<label for="fecha">Fecha :</label>  
<input type="text" name="fecha" id="fecha" size="10" readonly="readonly" /> 
<input type="button" name="anchor1" id="anchor1" value="Calendario"  onClick="CalendarClick(event);" />    
<br /><br />
<label for="profesor">Profesor :</label>
<select name="profesor" id="profesor"> 
</select> 
<br /><br /> 
<label for="justificacion">Justificaci&oacute;n :</label>
<select name="justificacion" id="justificacion" >  
</select> 
<br /> 
<label for="otra">Otra :</label>
<input type="checkbox" name="otra" id="otra" onchange="$('otraj').toggle();" />
<div id="otraj" style="display:none" >    
  <input type="text" name="otrajustificacion" value="" id="otrajustificacion" size="30" /> 
</div> 
<br />    
<input type="button" name="registra" value="Registrar" id="registra" onclick="var just=($('otra').checked)?$F('otrajustificacion'):$F('justificacion');capturaJustificante(<?php echo $_SESSION['ceid'];?>,$F('profesor'),just);" /> 
<div id="status"></div>
</fieldset>
</form>
<div class="tabla" id="lista">	
</div>
<script type="text/javascript" charset="utf-8">
    insertaDropDown('Profesor','profesor'); 
    insertaDropDown('Justificacion','justificacion');
    actualizaJustificantes();
</script>