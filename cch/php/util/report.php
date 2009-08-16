<?php
 require('../fpdf/fpdf_html_table.php') ;
 
 $htmlTable = include 'http://localhost/cch/php/reportes/obtenAsistenciasxProfesor.php?ciclo=4&profesor=392&arch=1';
 
 $pdf=new PDF_HTML_Table();
 $pdf->AddPage();
 $pdf->SetFont('Arial','',10);
 $pdf->WriteHTML("Start of the HTML table.<BR>$htmlTable<BR>End of the table.");
 $pdf->Output();

?>
