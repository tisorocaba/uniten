<link href="<?php echo base_url() ?>assets/css/form2.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>
<script src="<?php echo base_url() ?>assets/scripts/cadastro/formulario.js"></script>
<p class="editoria">Cursos > Formulário de Inscrição</p>

<?php echo form_open('cadastro/grava', array('id' => 'form1', 'class' => 'form')); ?>

<input type="hidden" name="id" value="<?php echo $aluno['id'] ?>"/>

<h1><?php echo $agenda['curso']['nome'] ?></h1>

<h2 class="section"><STRONG>DADOS PESSOAIS</STRONG></h2>

<div style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px">
    <?php echo validation_errors(); ?>
</div>
<div id="div-form" style="width: 100%">
    <div id="div-int">

        <div class="row-grid">
            <div class="span5 label">
                <span>Nome:*</span>
                <input  id="nome" name="nome" maxlength="95"
                        value="<?php echo @$aluno['nome']?>" size="12"
                         type="text" tabindex="1">
                         <span
                             style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px"><?php echo form_error('nome'); ?></span>

            </div>
        </div>

        <div class="row-grid">
            <div class="span3 label">
                <span>Data de Nascimento:*</span>
                <input  id="dataNascimento" name="dataNascimento" maxlength="10"
                        value="<?php echo @$aluno['dataNascimento']?>" size="12"
                        required readonly type="text" tabindex="2">
                         <span
                             style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px"><?php echo form_error('dataNascimento'); ?></span>

            </div>
        </div>

        <div class="row-grid">
            <div class="span2 label">
                <span>CPF:*</span>
                <input  id="cpf" name="cpf" maxlength="10"
                        value="<?php echo @set_value('cpf'); ?>" size="12"
                        required readonly type="text" tabindex="3">
                         <span
                             style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px"><?php echo form_error('cpf'); ?></span>

            </div>
        </div>

        <div class="row-grid">
            <div class="span2 label">
                <span>RG:*</span>
                <input  id="rg" name="rg" maxlength="20"
                        value="<?php echo @$aluno['rg']?>" size="12"
                        required  type="text" tabindex="4">
                         <span
                             style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px"><?php echo form_error('rg'); ?></span>

            </div>
        </div>

        <div class="row-grid">
            <div class="span2 label">
                <span>Sexo:*</span>

                <select name="sexo" id="sexom" required="required">
                    <option value="M" <?php if($aluno['sexo']=='M') echo 'checked' ?>>Masculino</option>
                    <option value="F" <?php if($aluno['sexo']=='F') echo 'checked' ?>>Feminino</option>
                </select>

            </div>
        </div>

        <div class="row-grid">
            <div class="span2 label">
                <span>Cor:*</span>
                <select name="cor" id="cor" required="required">
                    <option value="Branco" <?php if(@$aluno['cor']=='Branco') echo 'checked' ?>>Branco</option>
                    <option value="Pardo" <?php if(@$aluno['cor']=='Pardo') echo 'checked' ?>>Pardo</option>
                    <option value="Preto" <?php if(@$aluno['cor']=='Preto') echo 'checked' ?>>Preto</option>
                    <option value="Amarelo" <?php if(@$aluno['cor']=='Amarelo') echo 'checked' ?>>Amarelo</option>
                    <option value="Indigena" <?php if(@$aluno['cor']=='Indigena') echo 'checked' ?>>Indígena</option>
                </select>
            </div>
            <div class="span2 label">
                <span>Estado Cívil:*</span>
                <select name="estadoCivil" id="estadoCivil" required="required">
                    <option value="" >Selecione...</option>
                    <option value="S" <?php if(@$aluno['estadoCivil']=='S') echo "selected"?> >Solteiro</option>
                    <option value="C" <?php if(@$aluno['estadoCivil']=='C') echo "selected"?>>Casado</option>
                    <option value="D" <?php if(@$aluno['estadoCivil']=='D') echo "selected"?>>Divorciado</option>
                    <option value="A" <?php if(@$aluno['estadoCivil']=='A') echo "selected"?>>Amasiado</option>
                    <option value="V" <?php if(@$aluno['estadoCivil']=='V') echo "selected"?>>Viúvo</option>
                </select>
            </div>
        </div>



        <div class="row-grid">
            <div class="span2 label">
                <span>Carteira de Trabalho (CTPS):</span>
                <input id="ctps"  name="ctps" maxlength="25" size="14"
                       value="<?php echo @$aluno['ctps'] ?>"  type="text"
                       tabindex="2" placeholder="Informe o CTPS">

            </div>

            <div class="span2 label no-margin">
                <span>&nbsp;</span>
                <input id="serie" class="inputPequeno"  name="serie" maxlength="25" size="14"
                       value="<?php echo @$aluno['serie']?>"  type="text"
                       tabindex="2" placeholder="Informe o SÉRIE">

            </div>
        </div>


        <div class="row-grid">
            <div class="span2 label">
                <span>Está Desempregado:*</span>
                <select name="desempregado" id="desempregado" required="required">
                    <option value="0" <?php if(@$aluno['desempregado']=='0') echo "selected"?>>Não</option>
                    <option value="1" <?php if(@$aluno['desempregado']=='1') echo "selected"?>>Sim</option>

                </select>
            </div>

        </div>



        <div class="row-grid" id="linhaAutonomo">
            <div class="span2 label">
                <span>É profissional autonômo?</span>
                <select name="autonomo" id="autonomo">

                    <option value="1" <?php if(@$aluno['autonomo']=='1') echo "selected"?>>Sim</option>
                    <option value="0" <?php if(@$aluno['autonomo']=='0') echo "selected"?>>Não</option>

                </select>
            </div>

        </div>

        <div class="row-grid" id="linhaDesempregadoTempo">
            <div class="span4 label">
                <span>Há quanto tempo está desempregado?</span>
                <select name="desempregadoTempo" id="desempregadoTempo" >
                    <option value=""></option>
                    <?php foreach($tempoDesempregos as $tempo){?>
                        <option value="<?php echo $tempo['id']?>" <?php if(@$aluno['desempregadoTempo']== $tempo['id']) echo "selected"?>><?php echo $tempo['titulo']?></option>
                    <?php } ?>

                </select>
            </div>

        </div>

        <div class="row-grid" id="">
            <div class="span4 label">
                <span>Possui Imóvel?</span>
                <select name="possuiImovel" id="possuiImovel" >
                    <option value="1" <?php if(@$aluno['possuiImovel']=='1') echo "selected"?>>Sim</option>
                    <option value="0" <?php if(@$aluno['possuiImovel']=='0') echo "selected"?>>Não</option>
                </select>
            </div>
        </div>

        <div class="row-grid" id="linhaPossuiImovel">
            <div class="span4 label">
                <span>Situação habitacional:</span>
                <select name="situacaoHabitacional" id="situacaoHabitacional" class="validate[required]">
                    <option value="">Selecione</option>
                    <option value="A" <?php if(@$aluno['situacaoHabitacional']=='A') echo "selected"?>>Aluguel</option>
                    <option value="RP" <?php if(@$aluno['situacaoHabitacional']=='RP') echo "selected"?>>Reside com os pais</option>
                    <option value="RC" <?php if(@$aluno['situacaoHabitacional']=='RC') echo "selected"?>>Reside em imóvel cedido</option>
                    <option value="O" <?php if(@$aluno['situacaoHabitacional']=='O') echo "selected"?>>Outros</option>
                </select>
            </div>
        </div>

        <div class="row-grid" id="">
            <div class="span4 label">
                <span>Escolaridade?</span>
                <select name="escolaridade" id="escolaridade">
                    <option value="EF" <?php if(@$aluno['situacaoHabitacional']=='EF') echo "selected"?>>Ensino Fundamental</option>
                    <option value="EFI" <?php if(@$aluno['situacaoHabitacional']=='EFI') echo "selected"?>>Ensino Fundamental Incompleto</option>
                    <option value="EM" <?php if(@$aluno['situacaoHabitacional']=='EM') echo "selected"?>>Ensino Medio</option>
                    <option value="EMI" <?php if(@$aluno['situacaoHabitacional']=='EMI') echo "selected"?>>Ensino Medio Incompleto</option>
                    <option value="ES" <?php if(@$aluno['situacaoHabitacional']=='ES') echo "selected"?>>Ensino Superior</option>
                    <option value="ESI" <?php if(@$aluno['situacaoHabitacional']=='ESI') echo "selected"?>>Ensino Superior Incompleto</option>
                </select>
            </div>
        </div>


        <div class="row-grid" id="">
            <div class="span4 label">
                <span>Renda familiar?</span>
                <select name="renda" id="renda">
                    <option value="1" <?php if(@$aluno['renda']=='1') echo "selected"?>>0 a 3 salários</option>
                    <option value="2" <?php if(@$aluno['renda']=='2') echo "selected"?>>3 a 5 salários</option>
                    <option value="3" <?php if(@$aluno['renda']=='3') echo "selected"?>>5 ou mais salários</option>
                </select>
            </div>
        </div>


        <div class="row-grid">
            <div class="span2 label no-margin">
                <span>Pessoas na residência:</span>
                <input id="pessoasMoradia"  onKeyPress="return sonumero(event)"  name="pessoasMoradia" maxlength="4" size="4"
                       value="<?php echo @$aluno['pessoasMoradia'] ?>"  type="text"
                       tabindex="2" >
            </div>
        </div>


        <div class="row-grid">
            <div class="span2 label no-margin">
                <span>É portador de deficiência?</span>
                <select name="possuiDeficiencia" id="possuiDeficiencia">
                    <option value="N" <?php if(@$aluno['possuiDeficiencia']=='N') echo "selected"?>>Não</option>
                    <option value="S" <?php if(@$aluno['possuiDeficiencia']=='S') echo "selected"?>>Sim</option>
                </select>
            </div>

        </div>

        <div class="row-grid"  id="linhatipoDeficiencia" style="display:none">
            <div class="span2 label no-margin" >
                <span>Qual tipo de deficiência?</span>
                <input type="text" name="tipoDeficiencia" id="tipoDeficiencia" size="35" value="<?php echo @$aluno['tipoDeficiencia']?>" maxlength="85" />
            </div>
        </div>

        <?php if(@$agenda['prova']==1){ ?>


            <div class="row-grid" >
                <div class="span4 label ">
                    <span>Necessita de condições especias para realizar a prova?</span>
                    <select name="condicaoEspecialProva" id="condicaoEspecialProva">
                        <option value="N" <?php if(@$aluno['condicaoEspecialProva']=='N') echo "selected"?>>Não</option>
                        <option value="S" <?php if(@$aluno['condicaoEspecialProva']=='S') echo "selected"?>>Sim</option>
                    </select>
                </div>
            </div>

            <div class="row-grid" id="linhaCondicaoEspecialQual" style="display:none">
                <div class="span4 label no-margin">
                    <span>Informe Qual?</span>
                    <input type="text" name="condicaoEspecialQual" id="condicaoEspecialQual" value="<?php echo @$aluno['condicaoEspecialQual']?>" size="35" maxlength="150"  class="validate[required]"/>
                </div>
            </div>
            <div class="row-grid">
                <div class="span6 label no-margin">
                    <span></span>
                    <input name="chBolsaFamilia" id="chBolsaFamilia" type="checkbox" value="1" <?php if(!empty($aluno['bolsaFamilia'])) echo "checked"?>  />
                    Quero concorrer às vagas reservadas para alunos de baixa renda.
                </div>
            </div>
            <div class="row-grid" id="linhaBolsaFamilia">
                <div class="span3 label no-margin">
                    <span>Cartão Bolsa Família:</span>
                    <input name="bolsaFamilia" type="text" size="15" maxlength="15" id="bolsaFamilia" value="<?php echo @$aluno['bolsaFamilia']?>" class="validate[required]" />
                    <span style="color: red">Será obrigatório a apresentação do cartão bolsa família no dia da prova.</span>
                </div>
            </div>
        <?php } ?>

        <div class="row-grid">
            <div class="span6 label no-margin">
                <span></span>
                <input name="uniteemprega" id="uniteemprega" type="checkbox" value="1" <?php if(!empty($aluno['uniteemprega'])) echo "checked"?>  />
                Autorizo a UNITE divulgar os meus dados para as empresas do projeto <strong>UNITE Emprega</strong>.
            </div>
        </div>

        <div class="row-grid">
            <div class="span6 label no-margin">
                <span></span>
                <input name="divulgacao" id="divulgacao" type="checkbox" value="1" <?php if(!empty($aluno['divulgacao'])) echo "checked"?>  />
                Autorizo a divulgação das minhas imagens.
            </div>
        </div>
        <hr>

        <h2 class="section"><STRONG>ENDEREÇO</STRONG></h2>

        <div class="row-grid">
            <div class="span1 label no-margin">
                <span>CEP:*</span>
                <input name="cep" type="text" size="9" maxlength="9" id="cep" value="<?php echo @$aluno['cep']?>" required="required" onfocusout="carregaCEP()" /><span id="lbCep"></span>
            </div>
            <div class="span2">
                <span>&nbsp;&nbsp;</span>
                <a href="javascript:carregaCEP()"> <img src="<?php echo base_url()?>/assets/imgs/find.png"></a>
            </div>

        </div>

        <div class="row-grid">
            <div class="span4 label ">
                <span>Endereço:*</span>
                <input name="endereco" type="text" size="35" maxlength="120" id="endereco" value="<?php echo @$aluno['endereco']?>"  required="required"  />
            </div>
            <div class="span1 label ">
                <span>Número:*</span>
                <input name="numero" type="text" onKeyPress="return sonumero(event)" size="5" maxlength="5" id="numero" value="<?php echo @$aluno['numero']?>" required="required"  />
            </div>

        </div>


        <div class="row-grid">
            <div class="span2 label ">
                <span>Complemento:*</span>
                <input name="complemento" type="text" size="30" maxlength="45" id="complemento" value="<?php echo @$aluno['complemento']?>" />
            </div>
            <div class="span2 label ">
                <span>Bairro:*</span>
                <input name="bairro" type="text" size="40" maxlength="50" id="bairro" value="<?php echo @$aluno['bairro']?>" required="required" />
            </div>
        </div>

        <div class="row-grid">
            <div class="span3 label ">
                <span>Cidade:*</span>
                <input name="cidade" type="text" size="40" maxlength="50" id="cidade" value="<?php echo @$aluno['cidade']?>"  required="required"/>
            </div>

        </div>

        <hr>
        <h2 class="section"><STRONG>CONTATO</STRONG></h2>

        <div class="row-grid">
            <div class="span4 label ">
                <span>Email:</span>
                <input name="email" type="text" size="40" maxlength="110" id="email" value="<?php echo @$aluno['email']?>"  />
            </div>

        </div>

        <div class="row-grid">
            <div class="span0 label no-margin">
                <span>Tel.</span>
                <input name="ddd" type="text" size="2" maxlength="2" id="ddd"  value="<?php echo @$aluno['ddd']?>" required="required" />
            </div>
            <div class="span2 label ">
                <span>Principal:*</span>
                <input name="telefone" type="text" size="9" maxlength="9" id="telefone" value="<?php echo @$aluno['telefone']?>"  required="required" onKeyPress="return sonumero(event)" />
            </div>
        </div>

        <div class="row-grid">
            <div class="span0 label no-margin">
                <span>Tel.</span>
                <input name="dddContato" type="text" size="2" maxlength="2" id="ddd"  value="<?php echo @$aluno['dddContato']?>" onKeyPress="return sonumero(event)" />
            </div>
            <div class="span2 label ">
                <span>Contato:</span>
                <input name="telefoneContato" type="text" size="9" maxlength="9" id="telefone" value="<?php echo @$aluno['telefoneContato']?>"   onKeyPress="return sonumero(event)" />
            </div>
        </div>

        <div class="row-grid">
            <div class="span0 label no-margin">
                <span>Tel.</span>
                <input name="dddCelular" type="text" size="2" maxlength="2" id="ddd"  value="<?php echo @$aluno['dddCelular']?>" onKeyPress="return sonumero(event)"  />
            </div>
            <div class="span2 label ">
                <span>Celular:</span>
                <input name="celular" type="text" size="9" maxlength="10" id="telefone" value="<?php echo @$aluno['celular']?>"   onKeyPress="return sonumero(event)" />
            </div>
        </div>
        
        

        <div class="row-grid">
            <div class="span4 label">
                <input name="enviar" type="submit" value="Concluir a Inscrição"  />
            </div>
            <div class="span1 label ">
                <input name="voltar" type="button" value="Voltar" onclick="self.location='index'" />
            </div>
        </div>
        
        
        






    </div>
</div>
</form>
