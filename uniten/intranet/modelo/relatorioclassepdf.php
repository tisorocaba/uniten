<?php
ini_set('memory_limit', '100M');
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
require_once '../dao/diarioClasseDao.php';

$agendaDao = new AgendaCursoDao();
$agenda = $agendaDao->escape($_REQUEST['agenda']);
$alunos = $agendaDao->listaAlunoAgenda($agenda);

$diarioDao = new DiarioClasseDao();
$aDatas = $diarioDao->listaDatasDiario($agenda);



function montaDia($aDatas='', $pos='') {
    
        $aDados = @$aDatas[$pos];
        $data = explode('-', $aDados['data']);
        return $data[2];
    
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
        <style>
		
		
@page {
	margin: 2cm;
}

body {
  font-family: sans-serif;
	margin: 0.5cm 0;
	text-align: justify;
}

#header,
#footer {
  position: fixed;
  left: 0;
	right: 0;
	color: #aaa;
	font-size: 0.9em;
}

#header {
  top: 0;
	border-bottom: 0.1pt solid #aaa;
}

#footer {
  bottom: 0;
  border-top: 0.1pt solid #aaa;
}

#header table,
#footer table {
	width: 100%;
	border-collapse: collapse;
	border: none;
}

#header td,
#footer td {
  padding: 0;
	width: 50%;
}

.page-number {
  text-align: center;
}

.page-number:before {
  content: "Page " counter(page);
}

hr {
  page-break-after: always;
  border: 0;
}

.container {
	width:100%;
	margin:0px auto;
	margin-top:115px;
	text-align:center;
	font-size:12px;
	line-height:13px;
 }
            .comBordaSimples {
                border-collapse: collapse; /* CSS2 */
                background: #FFFFF0;
            }

            .comBordaSimples td {
                border: 1px solid black;
                text-align: center;
            }
            .internas_normal {
                FONT-SIZE: 11px;
				COLOR: #666666;
				FONT-FAMILY: Arial, Helvetica, sans-serif; 
				TEXT-DECORATION: none;
				text-transform:uppercase;
				margin: 0px;
				width: 15px;
            }
			.dias {
                FONT-SIZE: 8px;
            }
            .titulo2 {
                FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #522b2b; LINE-HEIGHT: 18px; FONT-FAMILY: Arial, Helvetica, sans-serif
            }

        </style>
    </head>

    <body onload="javascript:print();">
    
    
    <div id="header">
    
    </div>
    
    
    <table width="1040" border="0">
            <tr>
                <td><table width="100%" border="0" style="border: 0px solid black">
                        <tr >
                            <td width="16%" style="border: 1px solid black"><span ><img src="http://www.sorocaba.sp.gov.br/images/logo_sorocaba.gif" width="129" height="124" /></span></td>
                            <td width="63%" style="border: 1px solid black"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr style="border: 1px solid black">
                                        <td align="center"><strong>SECRETARIA DE RELAÇÕES DO TRABALHO</strong></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong><span class="xl7115291" style="width:154pt">RELAT&Oacute;RIO DE  CLASSE</span></strong></td>
                                    </tr>
                                </table></td>
                            <td width="21%" align="center"><table width="100%" border="0" height="125" style="border: 1px solid black">
                                    <tr>
                                        <td><span >C&oacute;digo: A05.PR-UNITEN-002</span></td>
                                    </tr>
                                    <tr>
                                        <td><span >Revis&atilde;o: 00</span></td>
                                    </tr>
                                    <tr>
                                        <td><span >Data: 23/02/2012</span></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td><table width="100%" border="0">
                        <tr>
                            <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="comBordaSimples">
                                    <tr>
                                        <td width="15%" class="titulo2">Curso:</td>
                                        <td width="35%" class="titulo2"><span ><?php echo AgendaCurso::staticGet($agenda)->curso->nome ?></span></td>
                                        <td width="14%" class="titulo2">Local:</td>
                                        <td width="36%" class="titulo2"><?php echo AgendaCurso::staticGet($agenda)->local->local ?></td>
                                    </tr>
                                    <tr>
                                        <td class="titulo2">Período:</td>
                                        <td class="titulo2" style="text-transform:uppercase"><?php echo periodoCurso(AgendaCurso::staticGet($agenda)->periodo) ?></td>
                                        <td class="titulo2">Empresa:</td>
                                        <td class="titulo2"><?php echo Empresa::staticGet(AgendaCurso::staticGet($agenda)->empresaCurso )->fantasia ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td><table width="100%" class="comBordaSimples">
                                    <tr>
                                        <td width="40" class="titulo2">NRº</td>
                                        <td width="230" class="titulo2">ALUNO</td>
                                        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td class="titulo2">Período de <span class="xl741529131"><?php echo data_br(AgendaCurso::staticGet($agenda)->dataInicio) ?></span> a <span><?php echo data_br(AgendaCurso::staticGet($agenda)->dataTermino) ?></span></td>
                                                </tr>
                                            </table>
                                            <table cellspacing="0" cellpadding="0">
                                                            <tr>
																
                                                         <td class="internas_normal dias"><?php if (array_key_exists(0, $aDatas)) { ?><?php echo montaDia($aDatas, 0); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(1, $aDatas)) { ?><?php echo montaDia($aDatas, 1); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(2, $aDatas)) { ?><?php echo montaDia($aDatas, 2); ?><?php } ?></td>
                                                        <td class="internas_normal dias"><?php if (array_key_exists(3, $aDatas)) { ?><?php echo montaDia($aDatas, 3); ?> <?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(4, $aDatas)) { ?><?php echo montaDia($aDatas, 4); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(5, $aDatas)) { ?><?php echo montaDia($aDatas, 5); ?><?php } ?></td>
                                                        <td class="internas_normal dias"><?php if (array_key_exists(6, $aDatas)) { ?><?php echo montaDia($aDatas, 6); ?><?php } ?></td>
                                                        <td class="internas_normal dias"><?php if (array_key_exists(7, $aDatas)) { ?><?php echo montaDia($aDatas, 7); ?><?php } ?></td>  
                                                        <td class="internas_normal dias"><?php if (array_key_exists(8, $aDatas)) { ?><?php echo montaDia($aDatas, 8); ?> <?php } ?></td>
                                                        <td class="internas_normal dias"><?php if (array_key_exists(9, $aDatas)) { ?><?php echo montaDia($aDatas, 9); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(10, $aDatas)) { ?><?php echo montaDia($aDatas, 10); ?><?php } ?></td>
                                                        <td class="internas_normal dias"><?php if (array_key_exists(11, $aDatas)) { ?><?php echo montaDia($aDatas, 11); ?><?php } ?></td>
                                                        <td class="internas_normal dias"><?php if (array_key_exists(12, $aDatas)) { ?><?php echo montaDia($aDatas, 12); ?> <?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(13, $aDatas)) { ?><?php echo montaDia($aDatas, 13); ?> <?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(14, $aDatas)) { ?><?php echo montaDia($aDatas, 14); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(15, $aDatas)) { ?><?php echo montaDia($aDatas, 15); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(16, $aDatas)) { ?><?php echo montaDia($aDatas, 16); ?> <?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(17, $aDatas)) { ?><?php echo montaDia($aDatas, 17); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(18, $aDatas)) { ?><?php echo montaDia($aDatas, 18); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(19, $aDatas)) { ?><?php echo montaDia($aDatas, 19); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(20, $aDatas)) { ?><?php echo montaDia($aDatas, 20); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(21, $aDatas)) { ?><?php echo montaDia($aDatas, 21); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(22, $aDatas)) { ?><?php echo montaDia($aDatas, 22); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(23, $aDatas)) { ?><?php echo montaDia($aDatas, 23); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(24, $aDatas)) { ?><?php echo montaDia($aDatas, 24); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(25, $aDatas)) { ?><?php echo montaDia($aDatas, 25); ?><?php } ?></td>
                                                         <td class="internas_normal dias"><?php if (array_key_exists(26, $aDatas)) { ?><?php echo montaDia($aDatas, 26); ?><?php } ?></td>
                                                            <td class="internas_normal dias"><?php if (array_key_exists(27, $aDatas)) { ?><?php echo montaDia($aDatas, 27); ?><?php } ?></td>
                                                            <td class="internas_normal dias"><?php if (array_key_exists(28, $aDatas)) { ?><?php echo montaDia($aDatas, 28); ?> <?php } ?></td>
                                                            <td class="internas_normal dias"><?php if (array_key_exists(29, $aDatas)) { ?><?php echo montaDia($aDatas, 29); ?><?php } ?></td>
                                                            <td class="internas_normal dias"><?php if (array_key_exists(30, $aDatas)) { ?><?php echo montaDia($aDatas, 30); ?><?php } ?></td>
                                                            <td class="internas_normal dias"><?php if (array_key_exists(31, $aDatas)) { ?><?php echo montaDia($aDatas, 31); ?><?php } ?></td>
                                                            <td class="internas_normal dias"><?php if (array_key_exists(32, $aDatas)) { ?><?php echo montaDia($aDatas, 32); ?><?php } ?></td>		                                                            <td class="internas_normal dias"><?php if (array_key_exists(33, $aDatas)) { ?><?php echo montaDia($aDatas, 33); ?><?php } ?></td>
                                                            <td class="internas_normal dias"><?php if (array_key_exists(34, $aDatas)) { ?><?php echo montaDia($aDatas, 34); ?><?php } ?></td>
                                                            <td class="internas_normal dias"><?php if (array_key_exists(35, $aDatas)) { ?><?php echo montaDia($aDatas, 35); ?><?php } ?></td>                                                            <td class="internas_normal dias"><?php if (array_key_exists(36, $aDatas)) { ?><?php echo montaDia($aDatas, 36); ?><?php } ?></td>
                                                                


                                                            </tr>
                                                        </table>
                                            
                                            </td>
                                        <td width="50" class="titulo2">FALTAS</td>
                                        <td width="50" class="titulo2">NOTA</td>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    foreach ($alunos as $aluno) {
                                        ?>
                                        <tr class="internas_normal">
                                            <td><?php echo $i ?></td>
                                            <td style="text-align:left;">&nbsp; <?php echo $aluno->aluno ?></td>
                                            <td><table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                     
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[0]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[1]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[2]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[3]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[4]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[5]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[6]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[7]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[8]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[9]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[10]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[11]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[12]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[13]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[14]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[15]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[16]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[17]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[18]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[19]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[20]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[21]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[22]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[23]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[24]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[25]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[26]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[27]['id'], $aluno->id) ?></td>   
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[28]['id'], $aluno->id) ?></td>
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[29]['id'], $aluno->id) ?></td>   
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[30]['id'], $aluno->id) ?></td>   
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[31]['id'], $aluno->id) ?></td>   
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[32]['id'], $aluno->id) ?></td>   
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[33]['id'], $aluno->id) ?></td>   
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[34]['id'], $aluno->id) ?></td>   
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[35]['id'], $aluno->id) ?></td>   
                                                            <td class="internas_normal"><?php  echo $diarioDao->isPresenca(@$aDatas[36]['id'], $aluno->id) ?></td>   
                                                        
                                                              
                                                    </tr>
                                                </table></td>
                                            <td><?php echo $diarioDao->totalFaltas($agenda,$aluno->id);?></td>
                                            <td><?php echo $agendaDao->getAgendaAluno($agenda,$aluno->id)->nota?></td>
                                            <?php $i++;
                                        } ?></tr>

                                </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
        
    </body>
</html>
