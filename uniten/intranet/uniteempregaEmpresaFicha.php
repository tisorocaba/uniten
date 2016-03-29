<?php
require_once 'util/config.php';
Security::admSecurity();
$empresa = new UniteEmprega();


$empresa->get($empresa->escape($_REQUEST['cod']));

 
 logDao::gravaLog($user->id, 'alunoFicha', 'Ficha do Aluno', $_REQUEST);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">UNITE Emprega &raquo; Empresa &raquo; Ficha</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Dados da Empresa</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td width="28%">Razão Social:</td>
                        <td width="72%">
                            <?php echo $empresa->razao;?>
                        </td>
                        </tr>
                        <tr>
                          <td>Nome Fantasia:</td>
                          <td>
                              <?php echo $empresa->fantasia;?>
                          </td>
                        </tr>
                        <tr>
                            <td>CNPJ:</td>
                            <td>
                                <?php echo $empresa->cnpj;?>
                            </td>
                        </tr>

                                    <tr>
                                      <td>Ramo de Atividade:</td>
                                      <td style="text-transform:uppercase"><?php echo ramoAtividade($empresa->atividade)?>
                                     </td>
                                    </tr>
                                    <tr >
                                      <td>Porte da Empresa:</td>
                                      <td style="text-transform:uppercase">
                                        <?php echo porteEmpresa($empresa->porte)?>
                                      </td>
                                    </tr>
               
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2"><strong>Endereço</strong></td>
                </tr>
                <tr>
                  <td colspan="2"><hr /></td>
                </tr>
                <tr>
                  <td>CEP:</td>
                  <td style="text-transform:uppercase"> <?php echo $empresa->cep;?>
                  </td>
                </tr>
                <tr>
                  <td>Endereço:</td>
                  <td style="text-transform:uppercase"><?php echo $empresa->endereco?> 
                     Nº: <?php echo $empresa->numero?>  
                  </td>
                </tr>
                <?php if(!empty($empresa->complemento)){ ?>
                <tr>
                  <td>Complemento:</td>
                  <td style="text-transform:uppercase">
                    <?php echo $empresa->complemento?>  
                  </td>
                </tr>
                <?php } ?>
                <tr>
                  <td>Bairro:</td>
                  <td style="text-transform:uppercase">
                  <?php echo $empresa->bairro?>  
                  </td>
                </tr>
                <tr>
                  <td>Cidade:</td>
                  <td style="text-transform:uppercase">
                  <?php echo $empresa->cidade?>  
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
                  <td>Responsável:</td>
                  <td style="text-transform:uppercase"><?php echo $empresa->responsavel?></td>
                </tr>
                <tr>
                  <td>Email:</td>
                  <td style="text-transform:uppercase"><?php echo $empresa->email?>  </td>
                </tr>
                <tr>
                  <td>Telefone:</td>
                  <td style="text-transform:uppercase"><?php echo $empresa->ddd?>-<?php echo $empresa->telefone?></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;
                    
                     </td>
                </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                  <td align="left"><input type="button" name="button" id="button" value="voltar" onclick="self.location='principal.php?acao=uniteemprega'" />
&nbsp;&nbsp;&nbsp;
<input name="imprimir" type="button" value="imprimir"  onclick="print();" />
&nbsp;&nbsp;&nbsp;
<input name="alterar dados" type="button" value="alterar dados" onclick="self.location='principal.php?acao=uniteempregaEmpresaCadastro&cod=<?php echo $empresa->id?>'" /></td>
                </tr>
            </table>

        </td>
    </tr>
</table>

<p>&nbsp;</p>
