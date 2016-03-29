<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
require_once '../dao/diarioClasseDao.php';
require_once '../dao/agendaDisciplinaProfessorDao.php';

$agendaDao = new AgendaCursoDao();
$agenda = $agendaDao->escape($_SESSION['CODAGENDA']);
$alunos = $agendaDao->listaAlunoAgenda($agenda);

$qtalunos = count($alunos);



$diarioDao = new DiarioClasseDao();
$aDatas = $diarioDao->listaDatasDiario($agenda);

// total de aulas 
$diarios = new DiarioClasse();
$diarios->alias('d')->where('d.agenda=?', $_SESSION['CODAGENDA'])->order('d.data DESC')->find();
$total = $diarios->count();

$totalfolha = ceil($total/37); 



if(empty($_REQUEST['folha']) || (int)$_REQUEST['folha']===1 ){
  $q0 = 0;
  $qf = 36;	
}else{
  $q0  =  37;
  $qf  = 92;
}


// recuperando os professores
$professorDao = new AgendaDisciplinaProfessorDao();
$professores = $professorDao->listaProfessorAgendaAgrupado($agenda);
$profs = '';
foreach ($professores as $professor) {
    $profs .= $professor->professor . "/";
	
}
$_SESSION['AGENDA_PROFESSORES'] = $profs;
// recuperando as disciplinas
$cargahoraria = 0;
foreach (AgendaCurso::staticGet($agenda)->curso->disciplinas as $diciplina) {
    $cargahoraria += $diciplina->cargaHoraria;
	
}
$_SESSION['AGENDA_CARGAHORARIA'] = $cargahoraria;

function montaDia($aDatas='', $pos) {

    $aDados = @$aDatas[$pos];
    $data = explode('-', $aDados['data']);
    return $data[2];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Formulário ISO</title>
        <style>


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
				border-style: 2px solid; 
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

    <body >


        <div id="header">

        </div>


        <table width="1040" border="0">
            <tr>
                <td>
                
                     <table width="100%" border="0" style="border: 0px solid black" height="96">
                        <tr >
                            <td width="10%" style="border: 1px solid black"><span ><img src="http://www.sorocaba.sp.gov.br/uniten/images/logo_impressao.jpg" width="98" height="95"  /></span></td>
                            <td width="69%" style="border: 1px solid black"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr style="border: 1px solid black">
                                        <td align="center"><strong>SECRETARIA DE DESENVOLVIMENTO ECONÔMICO E TRABALHO</strong></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong><span class="xl7115291" style="width:154pt">RELAT&Oacute;RIO DE  CLASSE</span></strong></td>
                                    </tr>
                                </table></td>
                            <td width="21%" align="center">
                            <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid black">
                                    <tr>
                                        <td><span >C&oacute;digo: A02.PR-UNITEN-002</span></td>
                                    </tr>
                                    <tr>
                                        <td><span >Revis&atilde;o: 00</span></td>
                                    </tr>
                                    <tr>
                                        <td><span >Data: 09/02/2015</span></td>
                                    </tr>
                          </table></td>
                        </tr>
                    </table>
                    
                    
                    </td>
            </tr>
            <tr>
                <td><table width="100%" border="0">
                        <tr>
                            <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="comBordaSimples">
                                    <tr>
                                      <td class="titulo2">Código:</td>
                                      <td class="titulo2"><?php echo AgendaCurso::staticGet($agenda)->id; ?></td>
                                      <td class="titulo2">Horário:</td>
                                      <td class="titulo2"><?php echo AgendaCurso::staticGet($agenda)->horarioInicial ?> às <?php echo AgendaCurso::staticGet($agenda)->horarioFinal; ?></td> 
                                     
                                    </tr>
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
                                        <td class="titulo2"><?php echo Empresa::staticGet(AgendaCurso::staticGet($agenda)->empresaCurso)->fantasia ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="titulo2">Carga Horária:</span></td>
                                        <td><span class="titulo2"><?php echo $cargahoraria; ?> horas</span></td>
                                        <td><span class="titulo2">Monitores:</span></td>
                                        <td><span class="titulo2">
                                            <?php
                                            
                                            echo substr($profs, 0, -1); 
                                            ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td><table width="100%" class="comBordaSimples" border="1">
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

                                                   
												<?php for($k=$q0;$k<=$qf;$k++){  ?>		
                                                    <td class="internas_normal dias">
													<?php if (array_key_exists($k, $aDatas)) { ?>
													<?php echo montaDia($aDatas, $k); ?><?php } ?>
                                                    </td>
                                                   
 											<?php } ?>						


                                                </tr>
                                            </table>

                                        </td>
                                        <td width="50" class="titulo2">FALTAS</td>
                                        <td width="50" class="titulo2">NOTA</td>
                                    </tr>
                                    <?php
                                    if(!empty($_REQUEST['offset'])){
                                       $i = (int)$_REQUEST['offset']; 
                                       $posini = ($i-1)*23;
                                       $posfim = $i*23;
                                       
                                       $alunos = array_slice ($alunos,$posini,$posfim,true);
                                       if((int)$_REQUEST['offset']===1){
                                          $i = 1; 
                                       }else{
                                          $i = $posini+1;  
                                       }
                                       
                                    }else{
                                        $i = 1;
                                    }
                                    
                                    
                                    
                                    foreach ($alunos as $aluno) {
                                    ?>
                                        <tr class="internas_normal">
                                            <td><?php echo $i ?></td>
                                            <td style="text-align:left;">&nbsp; <?php echo reduzirNome($aluno->aluno,32) ?></td>
                                            <!-- <td style="text-align:left;">&nbsp; <?php echo reduzirNome($aluno->aluno,23) ?></td> -->
                                            <td><table cellspacing="0" cellpadding="0" >
                                                    <tr>
                                                        <?php for($k=$q0;$k<=$qf;$k++){  ?>	
                                                        <td class="internas_normal"><?php echo $diarioDao->isPresenca(@$aDatas[$k]['id'], $aluno->id) ?>&nbsp;</td>
                                                       <?php }?> 


                                                    </tr>
                                                </table></td>
                                            <td><?php echo $diarioDao->totalFaltas($agenda, $aluno->id); ?></td>
                                            <td><?php
                                            if ((int) $aluno->status !== 4) {
                                                if((int)$agendaDao->getAgendaAluno($agenda, $aluno->id)->nota >0){
                                                    echo $agendaDao->getAgendaAluno($agenda, $aluno->id)->nota;
                                                }

                                            }
                                            ?>
                                            </td>
                                                <?php $i++;
                                            } ?></tr>

                          </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
        <table width="95%" border="0">
                      <tr>
                       <?php for($i=1;$i<=ceil($qtalunos/20);$i++){?>
                        <td width="1024" align="center"><table width="100%" border="0">
                          <tr>
                            <td width="12%">Página. 
                             
                              <select name="paginacao" id="paginacao" onchange="ativaPaginacao();" style="size:12px">
                                 <?php for($i=1;$i<=ceil($qtalunos/20);$i++){?>
                                     <option value="<?php echo $i;?>" <?php if(@$_GET['offset']==$i) echo 'selected' ?>>
								       <?php echo $i;?>
                                     </option>
                                   <?php } ?>
                              </select>
                            
                            </td>
                            <td width="17%" align="left">Período.
                              <select name="paginacaofolha" id="folha" onchange="ativaPaginacao();" style="size:12px">
                              
                                <?php for($f=1;$f<=$totalfolha;$f++){?>
                                <option value="<?php echo $f;?>" <?php if(@$_GET['folha']==$f) echo 'selected' ?>><?php echo $f;?></option>
                                <?php } ?>
                            </select></td>
                            <td width="71%" align="left">
                            <a href="javascript:print()">
                            	<img src="../imagens/icon_print.png" width="16" height="16" border="0" />
                            </a>
                            </td>
                          </tr>
                        </table></td>
                       <?php } ?>
                      </tr>
       </table>

    </body>
</html>

<script>
function ativaPaginacao(){
	var pagina = document.getElementById('paginacao').value;
	var folha  = document.getElementById('folha').value;
	self.location='relatorio-classe21.php?offset='+pagina+'&folha='+folha;
}
</script>
