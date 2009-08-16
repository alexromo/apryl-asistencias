<?php
#
# Configuracion de los menus
# 
#

$secciones = array ('inicio' => 'Inicio', 
		    'reportes' => 'Reportes',
            	    'rondines' => 'Rondines',
            	    'admin' => 'Admin');
                
$subsecciones = array ( 'inicio' => array ( 'reportes' => 'Reportes',
					    'rondines' => 'Rondines',
					    'admin' => 'Admin'),
			'reportes' => array ( 'profesor' => 'Por Profesor',
					   'area' => 'Por Area',
					   'salon' => 'Por Salon',
					   'ciclo' => 'Por Ciclo Escolar',
					   'justificantes' => 'De Justificantes'),
		        'rondines' => array ( 'registrarondin' => 'Registra Rondin',
		    			      'capturarondin' => 'Captura Rondin',
		    			      'registrafaltas' => 'Registra Faltas',
		    			      'modificafaltas' => 'Modifica Faltas',
		    			      'visorrondines' => 'Visor de Rondines'),
		    	'admin' => array ( 'ciclos' => 'Ciclos Escolares',
		    			   'usuarios' => 'Usuarios' ,
		    			   'profesores' => 'Profesores' ,
		    			   'salones' => 'Salones' ,
		    			   'horarios' => 'Horarios',
		    			   'rondines' => 'Rondines')
			);
			
$imagenes = array ('reportes' => 'app_48.png',
		   'rondines' => 'globe_48.png',
		   'admin' => 'computer_48.png',
		   'profesor' => 'user_48.png',
		   'area' => 'table_48.png',
		   'salon' => 'home_48.png',
		   'ciclo' => 'tabs_48.png',
		   'registrarondin' => 'paper&pencil_48.png',
		   'capturarondin' => 'paper_content_pencil_48.png',
		   'ciclos' => 'clock_48.png',
		   'usuarios' => 'users_two_48.png',
		   'profesores' => 'coffee_mug.png',
		   'salones' => 'home_48.png',
		   'horarios' => 'table_48.png',
		    'modificafaltas' => 'cross_48.png',
		    'registrafaltas' =>  'paper&pencil_48.png',
		    'justificantes' => 'paper_content_chart_48.png',
		    'visorrondines' => 'search_48.png'
		     );			                    

?>
