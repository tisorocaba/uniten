<?php
require_once 'util/config.php';
Security::admSecurity();

$motivo = new DesistenciaMotivo();
$motivo->find();

if (!empty($_GET['id'])) {
    $obj = new Aluno();
    $obj->get($_GET['id']);
    
    $obj->nome = str_replace("\\", "",$obj->nome);
    
    $obj->dataNascimento = data_br($obj->dataNascimento);
    @$aluno = $obj->toArray();



} else {
    $aluno['cpf'] = $_REQUEST['cpf'];
}

logDao::gravaLog($user->id, 'alunoFormulario', 'formulario do aluno', $_REQUEST);
?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/candidatoFormulario.js"></script>
<form action="alunoLogic.php" name="form" id="form1" method="post" enctype="multipart/form-data">
<?php if (!empty($_GET['id'])) { ?>
        <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'] ?>">
<?php } ?>

    
    <input type="hidden" name="op" id="op" value="<?php echo $_GET['acao'] ?>">


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="intranet.css" rel="stylesheet" type="text/css">
    <table width="100%" border="0" cellspacing="0" cellpadding="15">
        <tr>
            <td valign="top" style="text-align:justify;">
                <p><strong class="titulo">Candidato &raquo;  Cadastro</strong></p>
            </td>
        </tr>
        <tr>
            <td>

                <table width="100%" border="0" cellspacing="3" cellpadding="1">

                    <tr>
                        <td colspan="2"><strong>Dados Pessoais</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td width="27%">Nome:</td>
                        <td width="73%"><input name="nome" type="text" value="<?php echo @$aluno['nome'] ?>" size="55" maxlength="95" id="nome" class="validate[required]" />
                            *</td>
                    </tr>
                    <tr>
                        <td>CPF:</td>
                        <td><input name="cpf" type="text" size="12" value="<?php echo @$aluno['cpf'] ?>" maxlength="12"  readonly="readonly"/>
                            *</td>
                    </tr>
                    <tr>
                        <td>RG:</td>
                        <td><input name="rg" type="text" size="12" maxlength="12" id="rg" value="<?php echo @$aluno['rg'] ?>" class="validate[required]"  />
                            *</td>
                    </tr>

                    <tr>
                        <td>Sexo:</td>
                        <td><input type="radio" name="sexo" id="sexom" class="validate[required]" value="M" <?php if (@$aluno['sexo'] == 'M')
    echo 'checked' ?> />
                            <label for="radio">Masculino 
                                <input type="radio" name="sexo" id="sexof" class="validate[required]" value="F" <?php if (@$aluno['sexo'] == 'F')
    echo 'checked' ?> />
                                Feminino </label></td>
                    </tr>
                    <tr>
                        <td>Cor:</td>
                        <td>




                            <select name="cor" id="cor">
                                <option value="Branco">Branco</option>
                                <option value="Pardo">Pardo</option>
                                <option value="Preto">Preto</option>
                                <option value="Amarelo">Amarelo</option>
                                <option value="Indígena">Indígena</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Data de nascimento:</td>
                        <td>
                            <input name="dataNascimento" type="text" size="10" maxlength="10" id="dataNascimento"  value="<?php echo @$aluno['dataNascimento'] ?>" class="validate[required]"/>
                            *</td>
                    </tr>
                    <tr>
                        <td>Estado cívil:</td>
                        <td><select name="estadoCivil" id="estadoCivil">
                                <option value="S" <?php if (@$aluno['estadoCivil'] == 'S')
    echo "selected" ?> >Solteiro</option>
                                <option value="C" <?php if (@$aluno['estadoCivil'] == 'C')
    echo "selected" ?>>Casado</option>
                                <option value="D" <?php if (@$aluno['estadoCivil'] == 'D')
    echo "selected" ?>>Divorciado</option>
                                <option value="A" <?php if (@$aluno['estadoCivil'] == 'A')
    echo "selected" ?>>Amasiado</option>
                                <option value="V" <?php if (@$aluno['estadoCivil'] == 'V')
    echo "selected" ?>>Viúvo</option>
                            </select></td>
                    </tr>
                    <!--
                    <tr>
                        <td>Carteira de trabalho - CTPS: </td>
                        <td><input name="ctps" id="ctps" type="text" size="15" maxlength="25" value="<?php echo @$aluno['ctps'] ?>" />

                            Série:
                            <input name="serie" id="serie" type="text" size="15" maxlength="25" value="<?php echo @$aluno['serie'] ?>" /></td>
                    </tr>
                    -->

                    <tr>
                        <td>Está desempregado?</td>
                        <td><select name="desempregado" id="desempregado">
                                <option value="1" <?php if (@$aluno['desempregado'] == '1')
    echo "selected" ?>>Sim</option>
                                <option value="0" <?php if (@$aluno['desempregado'] == '0')
    echo "selected" ?>>Não</option>
                            </select>
                            *</td>
                    </tr>

                    
                    <tr id="linhaAutonomo">
                        <td>É profissional autonômo?</td>
                        <td><select name="autonomo" id="autonomo">
                                <option value="1" <?php if (@$aluno['autonomo'] == '1')
    echo "selected" ?>>Sim</option>
                                <option value="0" <?php if (@$aluno['autonomo'] == '0')
    echo "selected" ?>>Não</option>
                            </select></td>
                    </tr>
                    <tr id="linhaDesempregadoTempo">
                        <td>Há quanto tempo está desempregado?</td>
                        
                        
                        <td>
                            
                               
                          <?php   
                          $tempoDesempregos = new TempoDesemprego();
                          $tempoDesempregos->find();
                          $options = Lumine_Util::buildOptions( $tempoDesempregos, 'id', 'titulo', @$aluno['desempregadoTempo']); ?>

                            <select name="desempregadoTempo" id="desempregadoTempo" class="validate[required]">
                                <option value="">selecione...</option>
                                    <?php echo $options ?> 
                            </select>
                             *</td>
                    </tr>
                    
                    <tr >
                        <td>Possui imóvel:</td>
                        <td><select name="possuiImovel" id="possuiImovel">
                                <option value="1" <?php if (@$aluno['possuiImovel'] == '1')
    echo "selected" ?>>Sim</option>
                                <option value="0" <?php if (@$aluno['possuiImovel'] == '0')
    echo "selected" ?>>Não</option>
                            </select>
                            *</td>
                    </tr>
                    <tr id="linhaPossuiImovel">
                        <td>Situação habitacional:</td>
                        <td><select name="situacaoHabitacional" id="situacaoHabitacional">
                                <option value="A" <?php if (@$aluno['situacaoHabitacional'] == 'A')
    echo "selected" ?>>Aluguel</option>
                                <option value="RP" <?php if (@$aluno['situacaoHabitacional'] == 'RP')
    echo "selected" ?>>Reside com os pais</option>
                                <option value="RC" <?php if (@$aluno['situacaoHabitacional'] == 'RC')
    echo "selected" ?>>Reside em imóvel cedido</option>
                                <option value="O" <?php if (@$aluno['situacaoHabitacional'] == 'O')
    echo "selected" ?>>Outros</option>
                            </select>
                            *</td>
                    </tr>
                    <tr>
                    

                        <td>Escolaridade:</td>
                        <td>
                            <select name="escolaridade" id="escolaridade">
                                <option value="EF" <?php if (@$aluno['escolaridade'] == 'EF')
    echo "selected" ?>>Ensino Fundamental</option>
                                <option value="EFI" <?php if (@$aluno['escolaridade'] == 'EFI')
    echo "selected" ?>>Ensino Fundamental Incompleto</option>
                                <option value="EM" <?php if (@$aluno['escolaridade'] == 'EM')
    echo "selected" ?>>Ensino Medio</option>
                                <option value="EMI" <?php if (@$aluno['escolaridade'] == 'EMI')
    echo "selected" ?>>Ensino Medio Incompleto</option>
                                <option value="ES" <?php if (@$aluno['escolaridade'] == 'ES')
    echo "selected" ?>>Ensino Superior</option>
                                <option value="ESI" <?php if (@$aluno['escolaridade'] == 'ESI')
    echo "selected" ?>>Ensino Superior Incompleto</option>
                            </select>
                            *</td>
                    </tr>

                    
                    <tr>
                        <td>Renda familiar:</td>
                        <td>
                          <select name="renda" id="renda">
                            <option value="1" <?php if(@$aluno['renda']=='1') echo "selected"?>>0 a 3 salários</option>
                            <option value="2" <?php if(@$aluno['renda']=='2') echo "selected"?>>3 a 5 salários</option>
                            <option value="3" <?php if(@$aluno['renda']=='3') echo "selected"?>>5 ou mais salários</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td>Pessoas na residência:</td>
                        <td><input name="pessoasMoradia" type="text" size="3" maxlength="3" id="pessoasMoradia" value="<?php echo @$aluno['pessoasMoradia'] ?>"   /></td>
                    </tr>
                    

                    <tr>
                        <td>É portador de deficiência?</td>
                        <td><select name="possuiDeficiencia" id="possuiDeficiencia">
                                <option value="N" <?php if (@$aluno['possuiDeficiencia'] == 'N')
    echo "selected" ?>>Não</option>
                                <option value="S" <?php if (@$aluno['possuiDeficiencia'] == 'S')
    echo "selected" ?>>Sim</option>
                            </select></td>
                    </tr>
                    <tr id="linhatipoDeficiencia" style="display:none">
                        <td>Qual tipo de deficiência?</td>
                        <td><label for="tipoDeficiencia"></label>
                            <input type="text" name="tipoDeficiencia" id="tipoDeficiencia" size="35" value="<?php echo @$aluno['tipoDeficiencia'] ?>" maxlength="85" class="validate[required]"/>
                            *</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>

                    
                        <tr>
                            <td>Necessita de condições especias para realizar a prova?</td>
                            <td><select name="condicaoEspecialProva" id="condicaoEspecialProva">
                                    <option value="N" <?php if (@$aluno['condicaoEspecialProva'] == 'N')
        echo "selected" ?>>Não</option>
                                    <option value="S" <?php if (@$aluno['condicaoEspecialProva'] == 'S')
        echo "selected" ?>>Sim</option>
                                </select></td>
                        </tr>

                        <tr id="linhaCondicaoEspecialQual" style="display:none">
                            <td>Informe Qual?</td>
                            <td><input type="text" name="condicaoEspecialQual" id="condicaoEspecialQual" value="<?php echo @$aluno['condicaoEspecialQual'] ?>" size="35" maxlength="150"  class="validate[required]"/>
                                *</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input name="chBolsaFamilia" id="chBolsaFamilia" type="checkbox" value="1" <?php if (!empty($aluno['bolsaFamilia']))
        echo "checked" ?>  />
                                Quero concorrer às vagas reservadas para alunos de baixa renda.</td>
                        </tr>
                        <tr id="linhaBolsaFamilia">
                            <td>Cartão Bolsa Família:</td>
                            <td><input name="bolsaFamilia" type="text" size="15" maxlength="15" id="bolsaFamilia" value="<?php echo @$aluno['bolsaFamilia'] ?>" class="validate[required]" />
                                * 
                                <br /><font color="#FF0000" size="-2">Será obrigatório a apresentação do cartão bolsa família no dia da prova.</font></td>
                        </tr>
                    
                    <tr>
                        <td>&nbsp;</td>
                        <td><input name="divulgacao" id="divulgacao" type="checkbox" value="1" <?php if (!empty($aluno['divulgacao']))
    echo "checked" ?>  />
                            Autorizo a divulgação das minhas imagens.</td>
                    </tr>
                    
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td colspan="2"><strong>Endereço</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <tr>
                        <td>CEP:</td>
                        <td><input name="cep" type="text" size="9" maxlength="9" id="cep" value="<?php echo @$aluno['cep'] ?>"  />
                            <input name="btPesquisarCep" type="button" id="btPesquisarCep" value="Consultar CEP"  />
                            <span id="lbCep"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Endereço:</td>
                        <td><input name="endereco" type="text" size="35" maxlength="120" id="endereco" value="<?php echo @$aluno['endereco'] ?>" class="validate[required]" />
                            * Nº: 
                            <input name="numero" type="text" onKeyPress="return sonumero(event)" size="5" maxlength="5" id="numero" value="<?php echo @$aluno['numero'] ?>" class="validate[required]" />
                            *</td>
                    </tr>
                    <tr>
                        <td>Complemento:</td>
                        <td><input name="complemento" type="text" size="30" maxlength="45" id="complemento" value="<?php echo @$aluno['complemento'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>Bairro:</td>
                        <td><input name="bairro" type="text" size="40" maxlength="50" id="bairro" value="<?php echo @$aluno['bairro'] ?>" class="validate[required]" />
                            *</td>
                    </tr>
                    <tr>
                        <td>Cidade:</td>
                        <td><input name="cidade" type="text" size="40" maxlength="50" id="cidade" value="<?php echo @$aluno['cidade'] ?>"  class="validate[required]"/>
                            *</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Contato</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input name="email" type="text" size="40" maxlength="110" id="email" value="<?php echo @$aluno['email'] ?>" />
                          *</td>
                    </tr>
                    <tr>
                      <td>Telefone Residêncial:</td>
                      <td><input name="ddd" type="text" size="2" maxlength="2" id="ddd"  value="<?php echo @$aluno['ddd'] ?>" class="validate[required]"/>
                        -
                          <input name="telefone" type="text" size="9" maxlength="9" id="telefone" value="<?php echo @$aluno['telefone'] ?>"  class="validate[required]"/>
*</td>
                    </tr>
                    <tr>
                      <td>Telefone Contato:</td>
                      <td>
                      <input name="dddContato" type="text" size="2" maxlength="2" id="dddContato"  value="<?php echo @$aluno['dddContato'] ?>" />
                        -
                      <input name="telefoneContato" type="text" size="9" maxlength="9" id="telefoneContato" value="<?php echo @$aluno['telefoneContato'] ?>" />
</td>
                    </tr>
                    <tr>
                      <td>Celular:</td>
                      <td>
                      <input name="dddCelular" type="text" size="2" maxlength="2" id="dddCelular"  value="<?php echo @$aluno['dddCelular'] ?>" />
                        -
                      <input name="celular" type="text" size="9" maxlength="9" id="celular" value="<?php echo @$aluno['celular'] ?>"  /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Observação:</td>
                      <td>
                      <textarea name="obs" id="obs" cols="70" rows="7"><?php echo @$aluno['obs'] ?></textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;

                        </td>
                    </tr>

                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left">* Campo de preenchimento obrigatório</td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left">
                            <input type="hidden" value="gravar" name="acao" />
                            <input name="enviar" type="submit" value="Concluir Inscrição"  />
                            <input name="voltar" type="button" value="Voltar" onclick="history.go(-1)" />
                            &nbsp;&nbsp;&nbsp;</td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</form>
<p>&nbsp;</p>
