<?php
require_once '../util/config.php';
require_once '../dao/diarioClasseDao.php';
Security::admEcurso();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'pesquisaProtocolo', 'Visualizou: protocolo de confirmacao',$_REQUEST,'','Protocolo gerado: '.$_SESSION['CODAGENDA'].'Q'.$_SESSION['PROTOCOLOQUESTIONARIO']);
?>
<link href="http://unite.sorocaba.sp.gov.br/intranet/intranet.css" rel="stylesheet" type="text/css">
<link href="http://unite.sorocaba.sp.gov.br/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="http://unite.sorocaba.sp.gov.br/js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="http://unite.sorocaba.sp.gov.br/js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="http://unite.sorocaba.sp.gov.br/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="http://unite.sorocaba.sp.gov.br/js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="http://unite.sorocaba.sp.gov.br/js/jquery.limite-char-1.0.js" type="text/javascript"></script>

<table width="95%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Pesquisa do Aluno :: Protocolo</strong></p>
        </td>
    </tr>
    <tr>
        <td>
         
            <table width="100%" border="0" cellspacing="3" cellpadding="1">
                <tr>
                    <td colspan="2" align="center"><strong>Cadastro realizado com sucesso</strong></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td width="22%">&nbsp;</td>
                    <td width="78%">&nbsp;</td>
                </tr>
                <tr id="linhaDisciplinas">
                  <td colspan="2" align="center"><font color="#FF0000">ATENÇÃO <br />
                    Anote o protocolo abaixo na ficha do formulário que você acabou de preencher.</font><br />
                    <br />
                     <font color="#000099" size="+3"><?php echo $_SESSION['CODAGENDA']?>Q<?php echo $_SESSION['PROTOCOLOQUESTIONARIO']?>                  </font><br /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="center">
                  <input name="alterar" value="preencher outro formulário" type="button" onclick="self.location='pesquisaCadastro.php'" />
                    &nbsp;
                  <input name="finalizar" value="finalizar" type="button" onclick="self.location='pesquisaInfra.php'" /></td>
                </tr>
            </table>
           
        </td>
    </tr>
</table>
<?php unset($_SESSION['PROTOCOLOQUESTIONARIO']);?>