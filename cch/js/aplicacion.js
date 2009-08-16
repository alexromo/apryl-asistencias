function actualizaCiclos() { new Ajax.Updater('lista','php/admin/obtenCiclosSS.php', { method: 'get' });}
function actualizaEncargados() { new Ajax.Updater('lista','php/admin/obtenEncargadosSS.php', { method: 'get' });}
function actualizaUsuarios() { new Ajax.Updater('lista','php/admin/obtenUsuarios.php', { method: 'get' });}
function actualizaProfesores() { new Ajax.Updater('lista','php/admin/obtenProfesoresSS.php', { method: 'get' });}
function actualizaSalones(building) { new Ajax.Updater('lista','php/admin/obtenSalonesSS.php', { method: 'get',parameters: {edificio: building} });}
function actualizaHorarios(term,teacher) { new Ajax.Updater('lista','php/admin/obtenHorariosSS.php', { method: 'get',parameters: {ciclo:term, profesor: teacher} });}
function actualizaRondines(stat) { new Ajax.Updater('lista','php/rondines/obtenRondinesSS.php', { method: 'get',parameters: {status:stat } });}
function actualizaJustificantes() { new Ajax.Updater('lista','php/rondines/obtenJustificantesSS.php', { method: 'get' });}  
function actualizaJustificantesxProfesor(teacher) { new Ajax.Updater('justificantesxprofesor','php/reportes/obtenJustificantesxProfesor.php', { method: 'get',parameters: {profesor:teacher } });} 
function actualizaDetalleJustificante(just) { new Ajax.Updater('lista','php/rondines/obtenDetalleJustificante.php', { method: 'get',parameters: {justificante:just } });} 
function actualizaFaltasJustificadas(justif) { new Ajax.Updater('lista','php/rondines/obtenFaltasJustificadas.php', { method: 'get',parameters: {justificante: justif} });}
function actualizaAsistenciasProfesor(teacher,semestre) { new Ajax.Updater('lista','php/reportes/obtenAsistenciasxProfesor.php', { method: 'get',parameters: {profesor: teacher,ciclo: semestre} });}
function actualizaAsistenciasArea(areaa,semestre) { new Ajax.Updater('lista','php/reportes/obtenAsistenciasxArea.php', { method: 'get',parameters: {area: areaa,ciclo: semestre} });} 
function imprimeCaptEdificio(building) { new Ajax.Updater('edificiofrm','php/rondines/formaCapturaEdificio.php', { method: 'get',parameters: {edificio: building} });} 
function imprimeRondinJF(rond) { new Ajax.Updater('lista','php/rondines/imprimeRondinJF.php', { method: 'get',parameters: {rondin: rond} });} 
function actualizaDetalleRondin(rond) { new Ajax.Updater('lista','php/rondines/imprimeDetalleRondin.php', { method: 'get',parameters: {rondin: rond} });}


function insertaCiclo(anio,semestre)
{
 var cicl = anio+"-"+semestre;

 new Ajax.Request('php/admin/insertaCicloSS.php',{
        method: 'get',
        parameters: {ciclo: cicl},
        onCreate: function(){
                $('status').update('');
                $('status').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $('status').update(response);
				actualizaCiclos();}
        });
}

function insertaEncargado(name)
{
 new Ajax.Request('php/admin/insertaEncargadoSS.php',{
        method: 'get',
        parameters: {nombre: name},
        onCreate: function(){
                $('status').update('');
                $('status').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $('status').update(response);
				actualizaEncargados();}
        });
}

function insertaUsuario(usern,passw,name,rol)
{
 new Ajax.Request('php/admin/insertaUsuario.php',{
        method: 'get',
        parameters: {username: usern, password: passw, nombre: name, role: rol},
        onCreate: function(){
                $('status').update('');
                $('status').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $('status').update(response);
				actualizaUsuarios();}
        });
}

function insertaProfesor(name)
{
 new Ajax.Request('php/admin/insertaProfesorSS.php',{
        method: 'get',
        parameters: {nombre: name},
        onCreate: function(){
                $('status').update('');
                $('status').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $('status').update(response);
				actualizaProfesores();}
        });
}

function insertaSalon(building,classroom)
{
 new Ajax.Request('php/admin/insertaSalonSS.php',{
        method: 'get',
        parameters: {edificio: building,salon: classroom},
        onCreate: function(){
                $('status').update('');
                $('status').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $('status').update(response);
				actualizaSalones(building);}
        });
}

function insertaHorario(cycle, professor, classroom, day, hour)
{
 new Ajax.Request('php/admin/insertaHorarioSS.php',{
        method: 'get',
        parameters: {ciclo: cycle,profesor: professor, salon: classroom, dia: day, hora: hour},
        onCreate: function(){
                $('status').update('');
                $('status').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $('status').update(response);
				actualizaHorarios(cycle,professor);}
        });
}

function insertaRondin(clerk)
{
 new Ajax.Request('php/rondines/insertaRondinSS.php',{
        method: 'get',
        parameters: {encargado: clerk},
        onCreate: function(){
                $('status').update('');
                $('status').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $('status').update(response);
				actualizaRondines();}
        }); 
}

function cierraRondin(rond)
{
 new Ajax.Request('php/rondines/cierraRondin.php',{
        method: 'get',
        parameters: {rondin: rond},
        onCreate: function(){
                $('status').update('');
                $('status').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $('status').update(response);
				actualizaRondines('P');}
        }); 
}

function insertaDropDown(table,container)
{
 new Ajax.Request('php/util/dropdown.php',{
        method: 'get',
        parameters: {tabla: table},
        onCreate: function(){
                $(container).update('');
                $(container).update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $(container).update(response);}
        });

}

function insertaDropDownFilter(table,container,column,value)
{
 new Ajax.Request('php/util/dropdown.php',{
        method: 'get',
        parameters: {tabla: table, columna: column, valor: value},
        onCreate: function(){
                $(container).update('');
                $(container).update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $(container).update(response);}
        });

}
  
function insertaOptions(container,date,justificante)
{
 new Ajax.Request('php/util/clasexfecha.php',{
        method: 'get',
        parameters: {just: justificante, fecha: date},
        onCreate: function(){
                $(container).update('');
                $(container).update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $(container).update(response);}
        });

}

function insertaOptions1(container,date,prof)
{
 new Ajax.Request('php/util/clasexfechaprof.php',{
        method: 'get',
        parameters: {profesor: prof, fecha: date},
        onCreate: function(){
                $(container).update('');
                $(container).update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $(container).update(response);}
        });

}

function insertaAsistencia(idrondin,idsalon,idstatus,container)
{
 new Ajax.Request('php/rondines/insertaAsistencia.php',{
        method: 'get',
        parameters: {rondin: idrondin, salon: idsalon, status: idstatus},
        onCreate: function(){
                $(container).update('');
                $(container).update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $(container).update(response);}
        });

}

function insertaFaltaJustificada(idjustificante,date,idpsalon,container)
{
 new Ajax.Request('php/rondines/insertaFaltaJustificada.php',{
        method: 'get',
        parameters: {justificante: idjustificante, fecha: date, psalon: idpsalon},
        onCreate: function(){
                $(container).update('');
                $(container).update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $(container).update(response);
                actualizaFaltasJustificadas(idjustificante);}
        });

}

function capturaRondin(idrondin)
{
 new Ajax.Request('php/rondines/capturaRondinSS.php',{
        method: 'get',
        parameters: {rondin: idrondin},
        onCreate: function(){
                $('lista').update('');
                $('lista').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;
                $('lista').update(response);}
        });

}       

function capturaJustificante(idciclo,idprofesor,justificacion)
{
 new Ajax.Request('php/rondines/capturaJustificacion.php',{
        asynchronous: 'false',
        method: 'get',
        parameters: {ciclo: idciclo, profesor: idprofesor, justif: justificacion },
        onCreate: function(){
                
                $('lista').update('<tr><td colspan="3"><center><img src="images/indicator.white.gif" /></center></td></tr>');},
        onSuccess: function(transport){
                var response = transport.responseText;  
                $('lista').update('');
                $('justificante').value = response;
                //actualizaJustificantes()
                $('info').show();}
        });

}
 

function boxes(checkgroup)
    { 
     var salida = "";   
     for (i=0; i<checkgroup.length; i++)
        {
            if (checkgroup[i].checked==true)
                 salida+=checkgroup[i].value+" ";  
        }
     return $w(salida);      
    } 
    
function oneboxchecked(checkgroup)
    {                              
     var checada = false;   
     for (i=0; i<checkgroup.length; i++)
        {
            if (checkgroup[i].checked==true)
                    checada = true;
        }                
     return checada;   
    }
