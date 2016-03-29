<?php
require_once('../util/tcpdf/tcpdf.php');
require_once '../util/config.php';

$agenda = 537;

$curso['cod'] =  AgendaCurso::staticGet($agenda)->id;
$curso['curso']= AgendaCurso::staticGet($agenda)->curso->nome;
$curso['local'] = AgendaCurso::staticGet($agenda)->local->local;
$curso['perido'] = periodoCurso(AgendaCurso::staticGet($agenda)->periodo);
$curso['empresa'] = Empresa::staticGet(AgendaCurso::staticGet($agenda)->empresaCurso)->fantasia;
$curso['horarioInicial'] = AgendaCurso::staticGet($agenda)->horarioInicial;
$curso['horarioFinal']  = AgendaCurso::staticGet($agenda)->horarioFinal;
$curso['cargaHoraria'] = $_SESSION['AGENDA_CARGAHORARIA'];
$curso['professores'] = $_SESSION['AGENDA_PROFESSORES'];







class MyTCPDF extends TCPDF {

    private $cod;
    private $curso;
    private $local;
    private $perido;
    private $empresa;
    private $horarioInicial;
    private $horarioFinal;
    private $cargaHoraria;
    private $professores;
    
    
    function __construct($layout, $unit, $format, $true,$encode, $false,$curso) {
        parent::__construct($layout, $unit, $format, $true,$encode, $false);
        $this->cod = $curso['cod'];
        $this->curso = $curso['curso'];
        $this->local = $curso['local'];
        $this->perido = $curso['perido'];
        $this->empresa = $curso['empresa'];
        $this->horarioInicial = $curso['horarioInicial'];
        $this->horarioFinal = $curso['horarioFinal'];
        $this->cargaHoraria = $curso['cargaHoraria'];
        $this->professores = $curso['professores'];
    
    }

    public function Header() {

        $htm = '<style type="text/css">
                                        .comBordaSimples { border-collapse: collapse;   background: #FFFFF0;}
                                        .titulo2 {FONT-WEIGHT: bold; FONT-SIZE: 8px; COLOR: #522b2b; LINE-HEIGHT: 18px; FONT-FAMILY: Arial, Helvetica, sans-serif
                        }
                </style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 0px solid black" >
                        <tr >
                            <td width="10%" style="border: 0px solid black"><img src="http://www.sorocaba.sp.gov.br/uniten/images/logo_impressao.jpg" width="98" height="95"  />
                            </td>
                            <td width="69%" style="border: 0px solid black" align="center">
                          
                                       <strong>SECRETARIA DE RELAÇÕES DO TRABALHO</strong><BR><BR>
                                   
                                        <strong>RELAT&Oacute;RIO DE  CLASSE</strong>
                                        <BR>
                                   
                            </td>
                            <td width="21%" align="left">
                              <span >C&oacute;digo: A05.PR-UNITE-002</span><br><br>
                              <span >Revis&atilde;o: 01</span><br><br>
                              <span >Data: 04/05/2012</span>
                            </td>
                        </tr>
                        <tr >
                          <td colspan="3" style="border: 0px solid black"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="comBordaSimples">
                            <tr>
                              <td class="titulo2">Código: '.$this->cod.'</td>
                              <td class="titulo2">&nbsp;</td>
                              <td class="titulo2" >Horário: '.$this->horarioInicial.' às '.$this->horarioFinal.'</td>
                              <td class="titulo2">&nbsp;</td>
                            </tr>
                            <tr>
                              <td  class="titulo2">Curso: '.$this->curso.'</td>
                              <td  class="titulo2">&nbsp;</td>
                              <td  class="titulo2">Local: '.$this->local.'</td>
                              <td  class="titulo2">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class="titulo2" >Período: '.$this->perido.' </td>
                              <td class="titulo2" style="text-transform:uppercase">&nbsp;</td>
                              <td class="titulo2">Empresa: '.$this->empresa.'</td>
                              <td class="titulo2">&nbsp;</td>
                            </tr>
                            <tr>
                              <td><span class="titulo2">Carga Horária: '.$this->cargaHoraria.' horas</span></td>
                              <td><span class="titulo2"> </span></td>
                              <td><span class="titulo2">Monitores: '.$this->professores.'</span></td>
                              <td>&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                  
</table>

              ';


        $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $htm, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
    }

}

// create new PDF document
$pdf = new MyTCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false,$curso);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));
// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(2);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
// Set some content to print
/*$html = <<<EOD
<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
EOD;*/

// Print text using writeHTMLCell()
//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



$html = '
<div class="container">
<table width="100%" class="comBordaSimples">
                                    <tr>
                                        <td width="40" class="titulo2">NRº</td>
                                        <td width="230" class="titulo2">ALUNO</td>
                                        <td>
                                        
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td class="titulo2">Período de <span class="xl741529131">23/09/2013</span> a <span>29/11/2013</span></td>
                                                </tr>
                                            </table>
                                            
                                            <table cellspacing="0" cellpadding="0">
                                                <tr>

                                                   
														
                                                    <td class="internas_normal dias">
																										23                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										24                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										25                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										26                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										27                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										30                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										01                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										02                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										03                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										04                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										07                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										08                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										09                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										10                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										11                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										14                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										15                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										16                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										17                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										18                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										21                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										22                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										23                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										24                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										25                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										29                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										30                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										31                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										01                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										04                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										05                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										06                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										07                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										08                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										11                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										12                                                    </td>
                                                   
 													
                                                    <td class="internas_normal dias">
																										13                                                    </td>
                                                   
 																	


                                                </tr>
                                            </table>

                                        </td>
                                        <td width="50" class="titulo2">FALTAS</td>
                                        <td width="50" class="titulo2">NOTA</td>
                                    </tr>
                                                                            <tr class="internas_normal">
                                            <td>1</td>
                                            <td style="text-align:left;">&nbsp; Adriana Aparecida Miranda</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>4</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>2</td>
                                            <td style="text-align:left;">&nbsp; Agnes Ariane Ferreira Marcelino</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>6</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>3</td>
                                            <td style="text-align:left;">&nbsp; Ariane da Silva Torres</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>7</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>4</td>
                                            <td style="text-align:left;">&nbsp; Brenda Raiane da Silva Amorim</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>6</td>
                                            <td>7                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>5</td>
                                            <td style="text-align:left;">&nbsp; Bruna Paloma De Souza Cardozo</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>4</td>
                                            <td>8                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>6</td>
                                            <td style="text-align:left;">&nbsp; Cosme Henrique de Mello</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>3</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>7</td>
                                            <td style="text-align:left;">&nbsp; Edna Socorro Costa Carvalho</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>0</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>8</td>
                                            <td style="text-align:left;">&nbsp; EDSON LEANDRO GONZAGA</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>4</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>9</td>
                                            <td style="text-align:left;">&nbsp; Gislaine Cristina Mazuchi</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>3</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>10</td>
                                            <td style="text-align:left;">&nbsp; Gleiciane Fernanda do Amaral Mascarenhas</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>4</td>
                                            <td>10                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>11</td>
                                            <td style="text-align:left;">&nbsp; JANAINA DE OLIVEIRA</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>2</td>
                                            <td>8                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>12</td>
                                            <td style="text-align:left;">&nbsp; JANAINA PEREIRA MIRANDA</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>6</td>
                                            <td>8                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>13</td>
                                            <td style="text-align:left;">&nbsp; JESSICA NEVES DA SILVA TRAVA</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>4</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>14</td>
                                            <td style="text-align:left;">&nbsp; JOÃO CARLOS DAS NEVES</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>2</td>
                                            <td>8                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>15</td>
                                            <td style="text-align:left;">&nbsp; Judhy Cristina Campos Kulbert Machado</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>6</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>16</td>
                                            <td style="text-align:left;">&nbsp; Juliano Cesar Moreira dos Santos Andriozi</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>7</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>17</td>
                                            <td style="text-align:left;">&nbsp; LIDIANNI CRISTINA CAVERSAN</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>4</td>
                                            <td>8                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>18</td>
                                            <td style="text-align:left;">&nbsp; LILIAN APARECIDA BORGES FERREIRA</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>4</td>
                                            <td>10                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>19</td>
                                            <td style="text-align:left;">&nbsp; Marcelo Muniz</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>3</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>20</td>
                                            <td style="text-align:left;">&nbsp; MARCIANO FERREIRA</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>5</td>
                                            <td>8                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>21</td>
                                            <td style="text-align:left;">&nbsp; Maria Lucia Ventura</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>0</td>
                                            <td>7                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>22</td>
                                            <td style="text-align:left;">&nbsp; maria quiteria dos santos</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>3</td>
                                            <td>7                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>23</td>
                                            <td style="text-align:left;">&nbsp; Nicoli Stefani da Silva</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>5</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>24</td>
                                            <td style="text-align:left;">&nbsp; PAULA PAIVA VITORINO </td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>0</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>25</td>
                                            <td style="text-align:left;">&nbsp; Poliana de Souza Viana Ribeiro</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>4</td>
                                            <td>8                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>26</td>
                                            <td style="text-align:left;">&nbsp; Rafael Diego Svieck Fontoura</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>3</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>27</td>
                                            <td style="text-align:left;">&nbsp; rENATA cARLA fOGAÇA</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>7</td>
                                            <td>10                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>28</td>
                                            <td style="text-align:left;">&nbsp; Samuel  Ferreira de Campos</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>1</td>
                                            <td>9                                            </td>
                                                                                        <tr class="internas_normal">
                                            <td>29</td>
                                            <td style="text-align:left;">&nbsp; SERGIO PAULO LEME</td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        	
                                                        <td class="internas_normal"></td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">F</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                       	
                                                        <td class="internas_normal">P</td>
                                                        


                                                    </tr>
                                                </table></td>
                                            <td>6</td>
                                            <td>8                                            </td>
                                                </tr>

                                </table>
</div>';




$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+