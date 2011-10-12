Summary
=======
Using this tool you can create malicious PDF documents using known JavaScript exploits. These files can then be used in research and testing to further improve how PDF analysis is done. Releasing this library also means that it on the radar of tools that may be used by attackers to generate their documents. Knowing this, the security community can be more prepared and spend more time handling this issue rather than avoiding it. 

Important Files
===============
drop_invoice.php - uses the forms, lists and other information to produce an invoice packed with exploits
 - details need to be cleaned up
drop_news.php - uses RSS to produce PDF files with current news information packed with exploits
 - pulls several articles on the generation but can be adjusted to fit needs
drop_packed.php - takes in a directory of "good" PDF files and packs them with exploits
 - ran through the command line using ./caller.sh
 - rips through directory for files and trys to pack them
 - deletes files after attempting to pack, but could be adjusted to track progress

General Output
==============
- JavaScript is obfuscated using random variables
- Version is taken into account so that exploits are not fired if the reader is not vulnerable
- Files are encrypted using RC4
- Streams are dorked by adding a corrupt GZIP stream to the JavaScript object
- Metadata is left blank in versions

Inheritance Chain (from end to start)
=====================================
FPDF uses inheritance to achieve a full featureset. If you want more features, those features must then be included in the inheritance chain to be taken advantage of. These may not all be used, but by having them in the chain means you can activate them at the highest level of the construction (exploit generation). 

1. PDF_Exploit (pdf_exploit_generator.class.php => Provides exploit packing and building
2. FPDF_Protection (protection.class.php) => Provides encryption functionality
3. PDF_Invoice (invoice.class.php) => Provides JavaScript insert hook with dorked streams
4. concat_pdf (concat.class.php) => Provides the ability to concatenate two different PDF files (used in packing)
5. FPDI (fpdi.php) => Provides major functionality for generating documents

Using the Library in Existing Projects
======================================
Ensure all files are present at the root level and include pdf_exploit_generator.class.php.

Generating the document:

	$pdf = new PDF_Exploit( 'P', 'mm', 'A4' );

Setting encryption:

	$pdf->SetProtection(array('print'),'');

Adding an exploit (reference the class for methods):

	$pdf-><exploit_to_add>(<shellcode>);

Building the object with the exploits:

	$pdf->build_exploit();

Output the PDF:

	$pdf->Output();
