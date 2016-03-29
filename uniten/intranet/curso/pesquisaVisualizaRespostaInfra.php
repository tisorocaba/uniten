<?php
require_once '../util/config.php';
require_once '../dao/perguntaDao.php';
require_once '../dao/agendaCursoDao.php';
Security::admEcurso();
$agenda = new AgendaCurso();


$agenda->get($_SESSION['CODAGENDA']);
$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'pesquisaInfra', '',$_REQUEST);
$perguntaDao = new PerguntaDao();
$perguntas = $perguntaDao->listaPerguntas('A');

$protocolo = $perguntaDao->getProtocoloById($perguntaDao->escape($_REQUEST['cod']));

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'pesquisaVisualizaRespostaInfra', 'Visualizou: pesquisa do monitor',$_REQUEST,'','Protocolo gerado: '.$_SESSION['CODAGENDA'].'Q'.$_REQUEST['cod']);

?>
<link href="http://unite.sorocaba.sp.gov.br/intranet/intranet.css" rel="stylesheet" type="text/css">
<link href="http://unite.sorocaba.sp.gov.br/intranet/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="http://unite.sorocaba.sp.gov.br/intranet/js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="http://unite.sorocaba.sp.gov.br/intranet/js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="http://unite.sorocaba.sp.gov.br/intranet/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="http://unite.sorocaba.sp.gov.br/intranet/js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="http://unite.sorocaba.sp.gov.br/intranet/js/jquery.limite-char-1.0.js" type="text/javascript"></script>
<script src="http://unite.sorocaba.sp.gov.br/intranet/curso/scripts/pesquisaCadastro.js" type="text/javascript"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Pesquisa de Aluno :: Resposta</strong></p>
        </td>
    </tr>
    <tr>
        <td>
         
           
            
            <table width="100%" border="0" cellspacing="3" cellpadding="1">
                <tr>
                    <td colspan="2"><strong>Informações do Local</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td width="22%">Curso:</td>
                    <td width="78%"><?php echo $agenda->curso->nome?>
                    </td>
                </tr>
                <tr id="linhaDisciplinas">
                  <td>Local:</td>
                  <td>
                     <?php echo $agenda->local->local?>
                  </td>
                </tr>

                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Questionário</strong></td>
                </tr>
                <tr>
                  <td colspan="2" align="left"><hr /></td>
                </tr>
                <tr>
                    <td colspan="2" align="left"><table width="100%" border="0">
                      <tr>
                        <td colspan="2" bgcolor="#FFFFFF" ><table width="100%" border="0">
                          <tr>
                            <td width="8%" align="left"><strong>Aluno:</strong></td>
                            <td width="92%" align="left" style="text-transform:uppercase">
                               <?php 
                                
                                 if($protocolo['aluno']===0){
                                     echo "NÃO INFORMADO";
                                 }else{
                                     echo Aluno::staticGet($protocolo['aluno'])->nome ;
                                 }
                                 
                                         
                               ?>                      
                            </td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td width="55%" bgcolor="#CCCCCC" ><strong>PERGUNTAS</strong></td>
                        <td align="CENTER" bgcolor="#CCCCCC"><strong>RESPOSTAS</strong></td>
                      </tr>
                      <?php 
                          $cont = 0;
                          foreach ($perguntas as $pergunta) { 
                          
                           
                                     if ($cont === 0) {
                                            $linha = "listaClara";
                                            $cont = 1;
                                      } else {
                                            $linha = "listaEscura";
                                            $cont = 0;
                                      }
                          
                          ?>
                          
                      
                      <tr class="<?php echo $linha ?>">
                        <td  style="text-transform: uppercase;"><?php echo $pergunta->titulo?></td>
                        <td align="right">
                        <?php 
						$aDado = $perguntaDao->getResposta($_REQUEST['cod'], $pergunta->id);
						echo statusResposta($aDado['resposta']) ?>
                        </td>
                      </tr>
                      <?php }?>
                      <tr class="">
                        <td >&nbsp;</td>
                        <td align="right">&nbsp;</td>
                      </tr>
                     <?php 
					 $comentario = $perguntaDao->getComentario($_REQUEST['cod']);
					 if(!empty($comentario)){ ?>
                      <tr class="">
                        <td ><strong>Comentários</strong></td>
                        <td align="right">&nbsp;</td>
                      </tr>
                      <tr class="">
                        <td colspan="2" >
                           <?php echo $comentario?> 
                            
                        </td>
                      </tr>
                     <?php } ?> 
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="center">&nbsp;
                  <input name="btvoltar" value="voltar" type="button" onclick="history.go(-1)" /></td>
                </tr>
            </table>
         
           
        </td>
    </tr>
</table>
