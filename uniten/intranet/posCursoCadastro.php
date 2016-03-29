<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';

Security::admSecurity();

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);

$poscurso = new Poscurso();
$poscurso->alias('p')->where('p.agenda= ? and p.aluno = ?', $_SESSION['CODAGENDA'], $_REQUEST['aluno'])->find();
$aDados = $poscurso->allToArray();
//var_dump($aDados);
if (count($aDados) > 0) {
     $lbBotao = "Alterar";
     logDao::gravaLog($user->login, 'posCursoCadastro', 'Acessou: cadastro de poscurso(alterar)', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA'].' Aluno: '.$_REQUEST['aluno']);
} else {
    $lbBotao = "Incluir";
    logDao::gravaLog($user->login, 'posCursoCadastro', 'Acessou: cadastro de poscurso(novo)', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA'].' Aluno: '.$_REQUEST['aluno']);
}




?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/posCursoCadastro.js" type="text/javascript"></script>
<table width="95%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Pós - Curso :: Cadastro</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="posCursoLogic.php" method="post" id="form1">
                <input name="aluno" type="hidden" value="<?php echo @$_REQUEST['aluno'] ?>" />
                <input name="agenda" type="hidden" value="<?php echo @$_SESSION['CODAGENDA'] ?>" />

                <input name="id" type="hidden" value="<?php echo @$aDados[0]['id'];?>" />

                <input name="acao" type="hidden" value="gravar" />
                <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Dados do Aluno</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Aluno:</td>
                        <td width="70%" style="text-transform: uppercase">
                            <?php echo Aluno::staticGet($agenda->escape($_REQUEST['aluno']))->nome; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Curso:</td>
                        <td style="text-transform: uppercase">
                            <?php echo $agenda->curso->nome; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Dados da Pesquisa</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <tr>
                        <td>Trabalhando:</td>
                        <td>
                            <select name="trabalhando" id="cbTrabalhando">
                            <option value="0" <?php if(@$aDados[0]['trabalhando']==0) echo 'selected';?>>Não</option>
                                <option value="1" <?php if(@$aDados[0]['trabalhando']==1) echo 'selected';?> >Sim</option>
                                
                            </select>
                        </td>
                    </tr>


                    <tr id="linhaAutonomo" style="display:''" >
                      <td>Autonomo:</td>
                      <td>
                          <select name="autonomo" id="cbAutonomo" class="validate[required]">
                           <option value="0" <?php if(@$aDados[0]['autonomo']==0) echo 'selected';?>>Não</option>
                            <option value="1" <?php if(@(int)$aDados[0]['autonomo']===1) echo 'selected';?>>Sim</option>
                           
                          </select>
                        </td>
                    </tr>
                    <tr id="linhaRegistrado" style="display:''" >
                        <td>Registrado:</td>
                        <td><select name="registrado" id="registrado" class="validate[required]">
                         <!-- <option value="">Selecione...</option> -->
                                <option value="1" <?php if(@$aDados[0]['registrado']==1) echo 'selected';?>>Sim</option>
                                <option value="0" <?php if(@$aDados[0]['registrado']==0) echo 'selected';?>>Não</option>
                            </select>
                      </td>
                    </tr>
                    <tr id="linhaEmpresa" style="display:''" >
                        <td>Empresa:</td>
                        <td>
                           
                            <input name="empresa" type="text" id="empresa" value="<?php echo @$aDados[0]['empresa'];?>" size="50" maxlength="85" class="validate[required]" style="text-transform:uppercase" />
                            </td>
                    </tr>
                    <tr style="display:''" id="linhaFuncao">
                      <td>Função: </td>
                      <td><input name="funcao" type="text" id="funcao" size="50" value="<?php echo @$aDados[0]['funcao'];?>" maxlength="80" class="validate[required]" style="text-transform:uppercase" />
</td>
                    </tr>
                    <tr  >
                      <td>Estava empregado antes do curso: </td>
                      <td><select name="estavaEmpregado" id="cbEstavaEmpregado" class="validate[required]">
                        <option value="0" <?php if(@$aDados[0]['estavaEmpregado']==0) echo 'selected';?>>Não</option>
                        <option value="1" <?php if(@(int)$aDados[0]['estavaEmpregado']===1) echo 'selected';?>>Sim</option>
                      </select></td>
                    </tr>
                    <tr  style="display:''" id="linhaArea">
                      <td>Era na área referente ao curso: </td>
                      <td><select name="eraArea" id="cbArea" class="validate[required]">
                        <option value="0" <?php if(@$aDados[0]['eraArea']==0) echo 'selected';?>>Não</option>
                        <option value="1" <?php if(@(int)$aDados[0]['eraArea']===1) echo 'selected';?>>Sim</option>
                      </select></td>
                    </tr>
                    <tr  style="display:''" id="linhaCursoAjudou">
                      <td>O Curso ajudou ser admitido no emprego atual: </td>
                      <td><select name="cursoAjudou" id="cbCursoAjudou" class="validate[required]">
                        <option value="0" <?php if(@$aDados[0]['cursoAjudou']==0) echo 'selected';?>>Não</option>
                        <option value="1" <?php if(@(int)$aDados[0]['cursoAjudou']===1) echo 'selected';?>>Sim</option>
                      </select></td>
                    </tr>
                    <tr  style="display:''" id="linhaCursoAjudou2">
                      <td>Como foi o atendimento da secretaria da UNITEN: </td>
                      <td><select name="atendimento" id="atendimento" class="validate[required]">
                        <option value="1" <?php if(@(int)$aDados[0]['atendimento']==1) echo 'selected';?>>Regular</option>
                        <option value="2" <?php if(@(int)$aDados[0]['atendimento']==2) echo 'selected';?>>Bom</option>
                        <option value="3" <?php if(@(int)$aDados[0]['atendimento']==3) echo 'selected';?>>Ótimo</option>
                      </select></td>
                    </tr>
                    <tr  >
                        <td>Obs: </td>
                        <td>
                        <textarea name="obs" id="obs" cols="70" rows="3"><?php echo @$aDados[0]['obs']?></textarea></td>
                    </tr>

                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left"><input name="Continuar" type="submit" value="<?php echo $lbBotao ?>"  />
                        <input type="button" name="button" id="button" value="Voltar" onclick="history.go(-1)" />
                        <?php if(!isset($aDados[0]['id'])) { ?>
                        <input type="button" name="button" id="button" value="Registrar como Ausente" onclick="self.location='posCursoLogic.php?acao=ausente&aluno=<?php echo @$_REQUEST['aluno'] ?>&agenda=<?php echo @$_SESSION['CODAGENDA'] ?>'"  />
                        <?php }?>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
