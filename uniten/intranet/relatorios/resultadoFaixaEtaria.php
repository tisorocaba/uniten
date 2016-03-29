<?php
require_once '../util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->id, 'resultadoAlunoGeral.php', 'Relatorio Resultado da Pesquisa Aluno Geral', $_REQUEST);



$inicio = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_inicio']));
$fim    = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_fim']));

logDao::gravaLog($user->login, 'resultadoFaixaEtaria', 'Visualizou: Resultado da pesquisa Perfil Por Faixa Etária ', $_REQUEST,' Periodo: '.$inicio.' a '.$fim);

$sexo = Aluno::staticGet(12)->escape($_REQUEST['sexo']);

if((int)$_POST['faixa']===15){
	$faixaInicio = 15;
	$faixaFinal  = 25;
	
}elseif((int)$_POST['faixa']===26){
	$faixaInicio = 26;
	$faixaFinal  = 36;
	
}elseif((int)$_POST['faixa']===37){
	$faixaInicio = 37;
	$faixaFinal  = 50;
	
}else{
	$faixaInicio = 51;
	$faixaFinal  = '150';
	
}

$sql = "

SELECT  
 count(id) as total,
(SELECT COUNT(id) FROM aluno  where  cor = 'Branco'     and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as corBranca,
(SELECT COUNT(id) FROM aluno  where  cor = 'Pardo'      and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as corParda,
(SELECT COUNT(id) FROM aluno  where  cor = 'Preto'      and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as corPreta,
(SELECT COUNT(id) FROM aluno  where  cor = 'Amarelo'    and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as corAmarela,
(SELECT COUNT(id) FROM aluno  where  cor = 'Indígena'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as corIndigena,

(SELECT COUNT(id) FROM aluno  where  escolaridade = 'EF'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as ensinoFundamental,
(SELECT COUNT(id) FROM aluno  where  escolaridade = 'EFI'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as ensinoFundamentalIncompleto,
(SELECT COUNT(id) FROM aluno  where  escolaridade = 'EM'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as ensinoMedio,
(SELECT COUNT(id) FROM aluno  where  escolaridade = 'EMI'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as ensinoMedioIncompleto,
(SELECT COUNT(id) FROM aluno  where  escolaridade = 'ES'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as ensinoSuperior,
(SELECT COUNT(id) FROM aluno  where  escolaridade = 'ESI'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as ensinoSuperiorIncompleto,


(SELECT COUNT(id) FROM aluno  where  desempregado = 1   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as empregadoNao,
(SELECT COUNT(id) FROM aluno  where  desempregado = 0   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as empregadoSim,

(SELECT COUNT(id) FROM aluno  where  desempregado = 1 and autonomo = 1   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as empregadoAutonomoSim,

(SELECT COUNT(id) FROM aluno  where  desempregado = 1 and autonomo = 0   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as empregadoAutonomoNao,


(SELECT COUNT(id) FROM aluno  where  estado_civil = 'S'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as solteiro,
(SELECT COUNT(id) FROM aluno  where  estado_civil = 'C'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as casado,
(SELECT COUNT(id) FROM aluno  where  estado_civil = 'D'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as divorciado,
(SELECT COUNT(id) FROM aluno  where  estado_civil = 'A'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as amasiado,
(SELECT COUNT(id) FROM aluno  where  estado_civil = 'V'   and data_cadastro >= '".$inicio."' and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as viuvo,

(SELECT COUNT(id) FROM aluno  where  renda = '1'   and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as renda0a3,
(SELECT COUNT(id) FROM aluno  where  renda = '2'   and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as renda3a5,
(SELECT COUNT(id) FROM aluno  where  renda = '3'   and data_cadastro <= '".$fim."' AND sexo = '".$sexo."' AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio." AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal." ) as renda5acima
From aluno
where data_cadastro >= '".$inicio."' 
AND data_cadastro <= '".$fim."'
AND sexo = '".$sexo."'
AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) >= ".$faixaInicio."
AND    (YEAR(CURDATE())-YEAR(data_nascimento))- (RIGHT(CURDATE(),5)<RIGHT(data_nascimento,5)) <= ".$faixaFinal."
LIMIT 1

";



$rs = Aluno::staticGet(12)->_getConnection()->executeSQL($sql);

$obj = mysql_fetch_object($rs);
$_SESSION['SQL'] = $sql;
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<link href="../js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="../js/css/ui.theme.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.6.2.min.js"></script>
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>

<script src="scripts/formAlunoGeral.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios &raquo; Perfil Por Faixa Etária</strong> </p>
        </td>
    </tr>
   
</table>


<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td colspan="3"><strong>Período Pesquisado: </strong><?php echo $_REQUEST['data_inicio'] ?> a <?php echo $_REQUEST['data_fim'] ?> </td>
    </tr>
    <tr class="listaClara">
      <td colspan="3"><strong>Sexo:</strong> <?php if($_REQUEST['sexo']=='M')  echo 'Masculino'; else echo 'Feminino'; ?></td>
    </tr>
    <tr class="listaClara">
      <td colspan="3"><strong>Faixa Etária:</strong> <?php echo $faixaInicio ?> a <?php echo $faixaFinal ?>  anos</td>
    </tr>
    <tr class="listaClara">
      <td colspan="3"><strong>Total de Alunos: <?php echo $obj->total ?> alunos</strong></td>
    </tr>
      


                    <tr class="">
                      <td colspan="2">&nbsp;</td>
            </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Cor</strong></td>
                      
                    </tr>
                    <tr class="">
                      <td width="89">&nbsp;</td>
                      <td width="1050"><table width="50%" border="0">
                        <tr>
                          <td width="51%">Branca:</td>
                          <td width="49%"><?php echo porcentagem($obj->total,$obj->corBranca)?>% - (<?php echo $obj->corBranca?>)</td>
                        </tr>
                        <tr>
                          <td>Parda:</td>
                          <td><?php echo porcentagem($obj->total,$obj->corParda)?>% - (<?php echo $obj->corParda?>)</td>
                        </tr>
                        <tr>
                          <td>Preta:</td>
                          <td><?php echo porcentagem($obj->total,$obj->corPreta)?>% - (<?php echo $obj->corPreta?>) </td>
                        </tr>
                        <tr>
                          <td>Amarela:</td>
                          <td><?php echo porcentagem($obj->total,$obj->corAmarela)?>% - (<?php echo $obj->corAmarela?>)</td>
                        </tr>
                        <tr>
                          <td>Indígena:</td>
                          <td><?php echo porcentagem($obj->total,$obj->corIndigena)?>% - (<?php echo $obj->corIndigena?>)</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Escolaridade</strong></td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td><table width="50%" border="0">
                        <tr>
                          <td width="51%">Ensino Fundamental:</td>
                          <td width="49%"><?php echo porcentagem($obj->total,$obj->ensinoFundamental)?>% - (<?php echo $obj->ensinoFundamental?>)</td>
                        </tr>
                        <tr>
                          <td>Ensino Fundamental Incompleto:</td>
                          <td><?php echo porcentagem($obj->total,$obj->ensinoFundamentalIncompleto)?>% - (<?php echo $obj->ensinoFundamentalIncompleto?>)</td>
                        </tr>
                        <tr>
                          <td>Ensino Médio:</td>
                          <td><?php echo porcentagem($obj->total,$obj->ensinoMedio)?>% - (<?php echo $obj->ensinoMedio?>) </td>
                        </tr>
                        <tr>
                          <td>Ensino Médio Incompleto:</td>
                          <td><?php echo porcentagem($obj->total,$obj->ensinoMedioIncompleto)?>% - (<?php echo $obj->ensinoMedioIncompleto?>)</td>
                        </tr>
                        <tr>
                          <td>Ensino Superior:</td>
                          <td><?php echo porcentagem($obj->total,$obj->ensinoSuperior)?>% - (<?php echo $obj->ensinoSuperior?>)</td>
                        </tr>
                        <tr>
                          <td>Ensino Superior Incompleto:</td>
                          <td><?php echo porcentagem($obj->total,$obj->ensinoSuperiorIncompleto)?>% - (<?php echo $obj->ensinoSuperiorIncompleto?>)</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Renda</strong></td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td><table width="50%" border="0">
                        <tr>
                          <td width="51%">0 a 3 Salários:</td>
                          <td width="49%"><?php echo porcentagem($obj->total,$obj->renda0a3)?>% - (<?php echo $obj->renda0a3?>)</td>
                        </tr>
                        <tr>
                          <td>3 a 5 Salários:</td>
                          <td> <?php echo porcentagem($obj->total, $obj->renda3a5)?>% - (<?php echo $obj->renda3a5?>)</td>
                        </tr>
                        <tr>
                          <td>Acima de 5 Salários:</td>
                          <td><?php echo porcentagem($obj->total,$obj->renda5acima)?>% - (<?php echo  $obj->renda5acima?>) </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Estado Cívil</strong></td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td><table width="50%" border="0">
                        <tr>
                          <td width="51%">Solteiro:</td>
                          <td width="49%"> <?php echo porcentagem($obj->total,$obj->solteiro)?>% - (<?php echo $obj->solteiro?>)</td>
                        </tr>
                        <tr>
                          <td>Casado:</td>
                          <td><?php echo porcentagem($obj->total, $obj->casado)?>% - (<?php echo $obj->casado?>)</td>
                        </tr>
                        <tr>
                          <td>Divorciado:</td>
                          <td> <?php echo porcentagem($obj->total,$obj->divorciado)?>% - (<?php echo  $obj->divorciado?>) </td>
                        </tr>
                        <tr>
                          <td>Amasiado:</td>
                          <td> <?php echo porcentagem($obj->total,$obj->amasiado)?>% - (<?php echo  $obj->amasiado?>) </td>
                        </tr>
                        <tr>
                          <td>Viúvo:</td>
                          <td> <?php echo porcentagem($obj->total, $obj->viuvo)?>% - (<?php echo  $obj->viuvo?>) </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Situação Profissional</strong></td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td><table width="50%" border="0">
                        <tr>
                          <td width="50%">Desempregados:</td>
                          <td width="50%"> <?php echo porcentagem($obj->total, $obj->empregadoNao)?>% - (<?php echo $obj->empregadoNao?>)</td>
                        </tr>
                        <tr>
                          <td>Empregados:</td>
                          <td><?php echo porcentagem($obj->total,$obj->empregadoSim)?>% - (<?php echo $obj->empregadoSim?>)</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr/></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Situação dos Desempregados</strong></td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td><table width="50%" border="0">
                        <tr>
                          <td width="50%">Autonomo: </td>
                          <td width="50%"> <?php echo porcentagem($obj->empregadoNao,$obj->empregadoAutonomoSim)?>% - (<?php echo $obj->empregadoAutonomoSim?>)</td>
                        </tr>
                        <tr>
                          <td>Sem ocupação: </td>
                          <td><?php echo porcentagem($obj->empregadoNao,$obj->empregadoAutonomoNao)?>%  - (<?php echo $obj->empregadoAutonomoNao?>)</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr class="">
                      <td colspan="2" align="center"><input type="button" name="button2" id="button3" value="voltar" onclick="history.go(-1)" />
                        <input type="button" name="button" id="button" value="imprimir" onclick="print();" />
                      <input type="button" name="button" id="button2" value="exportar" onclick="self.location='../xls_relatorios.php'" /></td>
                    </tr>



            </table>

<?php

function porcentagem($total,$valor){
    $x = @(($valor*100) / $total);
    return number_format($x,1);
}

?>