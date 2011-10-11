<?php
$compressed   = gzcompress('This is a string');
//$compressed = $compressed[strlen($compressed)-1] = utf8_encode("\xC6\x92");
$uncompressed = gzuncompress($compressed);
echo $compressed;
?>
