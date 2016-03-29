<?php
require_once '../util/config.php';
Security::cursoSecurity();
$aluno = new Aluno();
$aluno->get($aluno->escape($_REQUEST['cod']));
$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'aluno', 'Acessou: ficha do aluno',$_REQUEST,'','aluno: '.$_REQUEST['cod']);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Ficha do Aluno</strong></p>
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
                        <td width="28%">Nome:</td>
                        <td width="72%">
                            <?php echo $aluno->nome;?>
                        </td>
                        </tr>
                        <tr>
                          <td>CPF:</td>
                          <td>
                              <?php echo $aluno->cpf;?>
                          </td>
                        </tr>
                        <tr>
                            <td>RG:</td>
                            <td>
                                <?php echo $aluno->rg;?>
                            </td>
                        </tr>

                                    <tr>
                                        <td>Data de Nascimento:</td>
                                        <td>
                                            <?php echo data_br($aluno->dataNascimento);?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Estado Cívil:</td>
                                        <td>
                                            <?php
                                               echo retornaEstadoCivil($aluno->estadoCivil);
                                            ?>
                                         </td>
                                    </tr>
                                    <tr>
                                      <td>Carteira de trabalho - CTPS: </td>
                                      <td>
                                      <?php echo $aluno->ctps;?>
                                        
                                       - Série:
                                           <?php echo $aluno->serie;?></td>
                                    </tr>

                <tr>
                  <td>Está desempregado:</td>
                  <td>
                  <?php
				    if($aluno->desempregado=='1')
					  echo "Sim";
					else
					  echo "Não";
				   ?>
                  </td>
                </tr>
                <tr id="linhaAutonomo">
                  <td>É profissional autonômo:</td>
                  <td>
                  <?php 
				    if($aluno->autonomo=='1') 
					 echo "Sim";
					else
					  echo "Não";
				  
				  
				  ?>
                  </td>
                </tr>
                <?php if($aluno->desempregadoTempo!=''){ ?>
                <tr id="linhaDesempregadoTempo">
                  <td>Há quanto tempo está desempregado:</td>
                  <td>
                     <?php echo $aluno->desempregadoTempo?>
                  </td>
                </tr>
                <?php } ?>
                <tr >
                  <td>Possui Imóvel:</td>
                  <td>
                  <?php 
				      if($aluno->possuiImovel=='1') 
				         echo "Sim" ;
					  else 
					     echo "Não";
				    ?>
                  
                
                    *</td>
                </tr>
                <tr id="linhaPossuiImovel">
                  <td>Situação Habitacional:</td>
                  <td>
                  <?php echo situacaoHabitacional($aluno->situacaoHabitacional) ?>
                  </td>
                </tr>
                <tr>
                  <td>Escolaridade:</td>
                  <td>
                  <?php echo escolaridade($aluno->escolaridade) ?>
                 
                    </td>
                </tr>
                <?php if($aluno->bolsaFamilia!=''){ ?>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="chBolsaFamilia" id="chBolsaFamilia" type="checkbox" value="1" <?php if(!empty($aluno->bolsaFamilia)) echo "checked"?>  /> 
                    Quero concorrer às vagas reservadas para alunos de baixa renda.</td>
                </tr>
                <tr id="linhaBolsaFamilia">
                    <td>Cartão Bolsa Família:</td>
                    <td>
                    <?php echo $aluno->bolsaFamilia;?>
                    </td>
                </tr>
                <?php } ?>
               
                
                <tr>
                  <td>Permite Divulgação:</td>
                  <td>
                  <?php if($aluno->divulgacao==1) 
				             echo "Sim";
					    else
						    echo "Não"; 
				  ?>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><strong>Endereço</strong></td>
                </tr>
                <tr>
                  <td colspan="2"><hr /></td>
                </tr>
                <tr>
                  <td>CEP:</td>
                  <td> <?php echo $aluno->cep;?>
                  </td>
                </tr>
                <tr>
                  <td>Endereço:</td>
                  <td><?php echo $aluno->endereco?> 
                     Nº: <?php echo $aluno->numero?>  
                  </td>
                </tr>
                <?php if(!empty($aluno->complemento)){ ?>
                <tr>
                  <td>Complemento:</td>
                  <td>
                    <?php echo $aluno->complemento?>  
                  </td>
                </tr>
                <?php } ?>
                <tr>
                  <td>Bairro:</td>
                  <td>
                  <?php echo $aluno->bairro?>  
                  </td>
                </tr>
                <tr>
                  <td>Cidade:</td>
                  <td>
                  <?php echo $aluno->cidade?>  
                  </td>
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
                  <td><?php echo $aluno->email?>  </td>
                </tr>
                <tr>
                  <td>Telefone:</td>
                  <td>
				    <?php echo $aluno->ddd?>-<?php echo $aluno->telefone?>
                  </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;
                    
                     </td>
                </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                  <td align="left"><input name="voltar" type="button" value="voltar" onclick="history.go(-1)" />
&nbsp;&nbsp;&nbsp;
<input name="imprimir" type="button" value="imprimir"  onclick="print();" /></td>
                </tr>
            </table>

        </td>
    </tr>
</table>

<p>&nbsp;</p>
