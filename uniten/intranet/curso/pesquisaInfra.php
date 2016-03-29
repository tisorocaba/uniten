<?php
require_once '../util/config.php';
require_once '../dao/perguntaDao.php';
Security::admEcurso();
$agenda = new AgendaCurso();

if(!empty($_REQUEST['agenda'])){
	$_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}


$agenda->get($_SESSION['CODAGENDA']);


$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'pesquisaInfra', 'Acessou: pesquisa do aluno ', $_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);

$perguntaDao = new PerguntaDao();
$respostas = $perguntaDao->listaRespostas($_SESSION['CODAGENDA']);

?>
<link href="http://www.sorocaba.sp.gov.br/uniten/intranet/intranet.css" rel="stylesheet" type="text/css">
<link href="http://www.sorocaba.sp.gov.br/uniten/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery.limite-char-1.0.js" type="text/javascript"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Pesquisa do Aluno</strong></p>
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
                    <td colspan="2"><table width="100%" border="0">
                      <tr>
                          <td width="84%"><strong>Lista de protocolos</strong></td>
                          <td width="16%"><a href="pesquisaCadastro.php">NOVA PESQUISA</a></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td colspan="2" align="left"><hr /></td>
                </tr>
                <tr>
                    <td colspan="2" align="left">
                    
                    <table width="100%" border="0">
                     
                      <?php 
                          $cont = 0;
						  $htmIni = "";
						  $htmFim = "";
                          foreach ($respostas as $resposta) { 
                          
                           
						   if($cont==0){
							  $cont = 1;
						 	  $htmIni = " <tr><td>";
						  	  $htmFim = "</td>";   
						   }elseif($cont==3){
							  $cont = 0;
						 	  $htmIni = " <td>";
						  	  $htmFim = "</td></tr>";
						   }else{
							  $cont ++;
						 	  $htmIni = " <td>";
						  	  $htmFim = "</td>";
							   
						   }
						   
                                   /*  if ($cont === 0) {
                                            $linha = "listaClara";
                                            $cont = 1;
                                      } else {
                                            $linha = "listaEscura";
                                            $cont = 0;
                                      }*/
                          
                          ?>
                          
                      
                        <?php echo $htmIni ?>
						  <a href="pesquisaVisualizaRespostaInfra.php?cod=<?php echo $resposta->id?>"> <?php echo $_SESSION['CODAGENDA']?>Q<?php echo $resposta->id?></a>
                        <?php echo $htmFim ?>
                      <?php }?>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="center">&nbsp;
                  <input name="imprimir" value="imprimir" type="button" onclick="print();" /></td>
                </tr>
            </table>
           
        </td>
    </tr>
</table>
