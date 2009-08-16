
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
<h1>Registro de Justificaci&oacute;n de Faltas</h1>
<h2>Profesor</h2>
<select name="profesor" id="profesor"> 
</select>  
<h2>Justificaci&oacute;n</h2>
<select name="justificacion" id="justificacion" >
</select>
<label for="otra">Otra</label>
<input type="checkbox" name="otra" id="otra" onchange="$('otrajustificacion').toggle();$('justificacion').toggle();" />
<input type="text" name="otrajustificacion" value="" id="otrajustificacion" size="30" style="display:none" /> 
<input type="button" name="registrajustificante" id="registrajustificante" value="Registra Justificante" onclick="var just=($('otra').checked)?$F('otrajustificacion'):$F('justificacion');capturaJustificante(<?php echo $_SESSION['ceid'];?>,$F('profesor'),just);$('registrajustificante').toggle();$('profesor').disable();$('justificacion').disable();$('otrajustificacion').disable();$('otra').disable();" />
<br />
<div id="info" style="display:none">
  <label for="justificante">Justificante :</label>
  <input type="text" name="justificante" value="" id="justificante" readonly="readonly" size="10" /> 
  <br />
  <label for="fecha">Fecha Falta:</label>  
  <input type="text" name="fecha" id="fecha" size="10" readonly="readonly" /> 
  <input type="button" name="anchor1" id="anchor1" value="Calendario"  onClick="CalendarClick(event);$('clases').innerHTML='';" />    
  <input type="button" name="checaClases" value="Agregar Clases ..." id="checaClases" onclick="if ($F('profesor') != 0) insertaOptions1('clases',$F('fecha'),$F('profesor'));" /> 
</div>
<div class="tabla" id="clases">
</div>
<div id="status"></div>
</fieldset>
</form>
<div class="tabla" id="lista">	
</div>
<div class="tabla" id="semana">
</div>    
<script type="text/javascript" charset="utf-8">
    insertaDropDown('Profesor','profesor'); 
    insertaDropDown('Justificacion','justificacion');
    //actualizaJustificantes();
</script>
