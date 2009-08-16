
<!--[if IE]>
			<script type="text/javascript" src="js/flotr/lib/excanvas.js"></script>
			<script type="text/javascript" src="js/flotr/lib/base64.js"></script>
<![endif]-->
<script type="text/javascript" src="js/flotr/lib/canvas2image.js"></script>
<script type="text/javascript" src="js/flotr/lib/canvastext.js"></script>
<script type="text/javascript" src="js/flotr/flotr-0.2.0-alpha.js"></script> 
<script type="text/javascript" charset="utf-8">
function DrawPieChart(dato1,dato2)
{
 var d1 = [[0, dato1]];
 var d2 = [[0, dato2]];
 var f = Flotr.draw($('graphcontainer'), [ 
    {data:d1, label: "Asistencias"}, 
    {data:d2, label: "Faltas"} 
    ], { 
        HtmlText: false, 
        grid: {
            outlineWidth: 0,
            verticalLines: false, 
            horizontalLines: false
        },
        xaxis: {showLabels: false},
        yaxis: {showLabels: false}, 
        pie: {show: true},
        legend:{
            position: "se",
            backgroundColor: "#D2E8FF"
        }
    }); 
}
</script> 
<form name="reportexarea" >
<fieldset>
<h1>Reporte de Asistencia por Area</h1>  
<label for="ciclo">Ciclo Escolar :</label>
<select name="ciclo" id="ciclo" onchange="if ($F('area') != 0 && $F('ciclo') != 0) {$('graphcontainer').setStyle({'display':'none'});actualizaAsistenciasProfesor($F('profesor'),$F('ciclo'));}" > 
</select>
<br />
<label for="area">Area :</label>
<select name="area" id="area" onchange="if ($F('area') != 0 && $F('ciclo') != 0) {$('graphcontainer').setStyle({'display':'none'});actualizaAsistenciasArea($F('area'),$F('ciclo'));}" > 
</select> 
<br /><br />
<div class="tabla" id="asistenciasxarea">
</div>
</fieldset>
</form> 
<div id="graphcontainer" style="width:500px;height:200px;display:none;"></div>
<div class="tabla" id="lista"> 
    
</div> 

<script type="text/javascript" charset="utf-8">
    insertaDropDown('CicloEscolar','ciclo');
    insertaDropDown('Area','area'); 
     
              
</script>
