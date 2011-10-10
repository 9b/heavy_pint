<?php 

require('contact.class.php');

//Watermark generation based off random array value
$watermarks = array("CONFIDENTIAL","PAST DUE","CLASSIFIED","SENSITIVE","SECRET","TOP SECRET");
$waterindex = rand(0,5);
$watermark = $watermarks[$waterindex];

//Date generation for a given random 2-week period prior to the current day
$end = new DateTime('last Sunday');
$start = clone $end;
$start->sub(new DateInterval('P14D'));

foreach (new DatePeriod($start, new DateInterval('P1D'), $end) as $day) {
    $dates[] = $day->format('m/d/Y');
}

$invoice_date = $dates[rand(0,13)];

//Invoice number
$invoice_number = rand(1000000000,9999999999);

//SKU item number
$invoice_number = rand(10000,99999);


$icon = new Contact();
$d = gzcompress($icon->get_full_contact());
echo $icon->get_full_contact();

?>