
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
<form name="justificafaltas" >
<fieldset>
<h1>Modificaci&oacute;n de Faltas</h1>  

<label for="justificante">Justificante :</label>
<select name="justificante" id="justificante" onchange="if ($F('justificante') != 0) {actualizaFaltasJustificadas($F('justificante'));$('clases').innerHTML='';}" > 
</select> 
<br /><br />
<label for="fecha">Fecha :</label>  
<input type="text" name="fecha" id="fecha" size="10" readonly="readonly" /> 
<input type="button" name="anchor1" id="anchor1" value="Calendario"  onClick="CalendarClick(event);$('clases').innerHTML='';" />    
<input type="button" name="checaClases" value="Agregar Clases ..." id="checaClases" onclick="if ($F('justificante') != 0) insertaOptions('clases',$F('fecha'),$F('justificante'));" /> 
<div class="tabla" id="clases">
</div>        
<div id="status"></div>
<div id="botones" style="display:none" >
    <input type="button" name="altafaltas" value="Registrar" onclick="alert('Justificante: '+$F('justificante')+' Fecha: '+$F('fecha')+' Clases: '+boxes(document.justificafaltas.idProfesorSalon));" />
</div>    
</fieldset>
</form>  
<div class="tabla" id="lista">
</div>    
<script type="text/javascript" charset="utf-8">
    insertaDropDown('Profesor','profesor'); 
    insertaDropDown('Justificante','justificante');   
</script>