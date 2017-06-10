<?php
//error_reporting(0);
//ini_set("display_errors", 0);
$this->layout = '';
App::uses('xtcpdf', 'Vendor');
//App::import('Documents.Vendor','xtcpdf'); 
$tcpdf = new xtcpdf();
$tcpdf->SetCreator(PDF_CREATOR);
$tcpdf->setHeaderText($artigo['Caderno']['nome']);
$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans'
$tcpdf->SetAuthor(Configure::read('Settings.title') . ' at ' . Configure::read('Settings.domain'));
//$tcpdf->SetAutoPageBreak(false);
//set auto page breaks
//$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$tcpdf->SetAutoPageBreak(TRUE, 10);
//initialize document
$tcpdf->getAliasNbPages();
$tcpdf->AddPage();
//$tcpdf->Image(IMAGES.'santander.png', 12, 117, 40, 8, '', 'http://'. Configure::read('Settings.domain'), '', null, 0);
$tcpdf->SetTopMargin(25);
//$tcpdf->SetBottonMargin(30);

$tcpdf->setImageScale(1.9);
//$tcpdf->LN(15);

$title = $artigo['Artigo']['titulo'];
$content = $artigo['Artigo']['texto'];



$html = <<<EOT
<style>
.texto{
  text-align: justify;
}

</style>     
   <body>     
  <p align="center"><strong> $title </strong></p>    
<span class="texto">$content

    </span>    
        </body>
EOT;



$tcpdf->writeHTML($html, true, false, true, true, '');
echo $tcpdf->Output('artigoCNW'.'.pdf', 'I');
//echo $tcpdf->Close();
