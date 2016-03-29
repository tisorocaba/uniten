<?php
require_once 'util/config.php';
Security::admSecurity();
$cursos = new Curso();
//$cursos->alias('c')->where('c.ativo=1')->order('c.nome ASC')->find();
$cursos->alias('c')->order('c.nome ASC')->find();

$locais = new Local();
$locais->alias('l')->where('l.ativo=1')->order('l.local ASC')->find();

$empresas = new Empresa();
$empresas->alias('e')->where('e.ativo=1 and e.status = 1')->order('e.nome ASC')->find();

$empresasCurso = new Empresa();
$empresasCurso->alias('e')->where('e.ativo=1 and e.status = 2')->order('e.nome ASC')->find();

if(!empty($_GET['id']))
{
   $obj = new AgendaCurso();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   
   // verificanco se e o admin
   if($user->local != 1){
       // verificando se o usuario e do mesmo local do curso
       if($obj->local->id != $user->local){
           msg('ERRO: Você não tem permissão para alterar essa agenda');
           gotox('principal.php?acao=agendacursos');
       }
   }
   
   

   $_POST['dataInicio'] = data_br($_POST['dataInicio']);
   $_POST['dataTermino'] = data_br($_POST['dataTermino']);
   $_POST['dataInicioInscricao'] = data_br($_POST['dataInicioInscricao']);
   $_POST['dataFinalInscricao'] = data_br($_POST['dataFinalInscricao']);
   
   if(!empty($_POST['provaData'])){
      $_POST['provaData'] = data_br($_POST['provaData']);
   }

   $_POST['valor'] = converteFloatMoeda($_POST['valor']);
   $_POST['valorVale'] = converteFloatMoeda($_POST['valorVale']);

   
   $lbBotao = "Alterar";
   logDao::gravaLog($user->login, 'agendaCursoCadastro', 'Acessou: cadastro de agenda(alteracao) ', $_REQUEST,'','Agenda: '.$_GET['id']);
}else{
   $lbBotao = "Gravar";
   logDao::gravaLog($user->login, 'agendaCursoCadastro', 'Acessou: cadastro de curso(novo) ', $_REQUEST);
}
//var_dump($_POST['curso']['id']);
?>
<p><span class="titulo">Agenda de Cursos  &raquo; Cadastro</span><br> 
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<link href="css/datepicker.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/datepicker.js" type="application/javascript"></script>
<script src="js/datepicker-pt-BR.js" type="application/javascript"></script>
<script src="js/jquery.number_format.1.0.js"></script>
<script src="scripts/agendaCursoCadastro.js"></script>
</p>

<form name="form1" id="form1" method="post" action="agendaCursoLogic.php">
<input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
<table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td width="17%" valign="top"> Curso:</td>
          <td width="83%" align="left">
           <select name="curso" id="curso">
             <?php echo Lumine_Util::buildOptions($cursos,'id','nome', @$_POST['curso']['id']); ?>
           
           </select>
           *
           </td>
        </tr>
        <tr>
          <td valign="top"> Local:</td>
          <td align="left">
          <?php if($user->local == 1){ ?>
           <select name="local" id="local" >
            <?php echo Lumine_Util::buildOptions($locais,'id','local', @$_POST['local']['id']); ?>
           </select>
           <?php } else {  ?>
              <input type="text" name="localView" value="<?php echo Local::staticGet($user->local)->local ?>" readonly="readonly"/>
              <input type="hidden" name="local" value="<?php echo $user->local ?>" />
             
           <?php } ?>   
           *
           </td>
        </tr>
         <tr>
          <td valign="top"> Empresa responsável:</td>
          <td align="left">
           <select name="empresaCurso" id="empresaCurso">
            <?php echo Lumine_Util::buildOptions($empresasCurso,'id','fantasia', @$_POST['empresaCurso']); ?>
           </select>
           *
           </td>
        </tr>
        <tr>
          <td valign="top">Data de início:</td>
          <td><input name="dataInicio" type="text" id="dataInicio" size="10" value="<?php echo @$_POST['dataInicio']?>" maxlength="10" class="validate[required]" />
          *</td>
        </tr>
        <tr>
          <td valign="top">Data de término:</td>
          <td><input name="dataTermino" type="text" id="dataTermino" size="10" value="<?php echo @$_POST['dataTermino']?>" maxlength="10" class="validate[required]" />
          *</td>
        </tr>
        <tr>
          <td valign="top">Horário de início:</td>
          <td><input name="horarioInicial" type="text" id="horarioInicial" size="5" value="<?php echo @$_POST['horarioInicial']?>" maxlength="5" class="validate[required]"  />
          *</td>
        </tr>
        <tr>
          <td valign="top">Horário de término:</td>
          <td><input name="horarioFinal" type="text"  id="horarioFinal" size="5" value="<?php echo @$_POST['horarioFinal']?>" maxlength="5" class="validate[required]" />
          *</td>
        </tr>
        <tr>
          <td valign="top">Período: </td>
          <td>
          <select name="periodo">
             <option value="M" <?php if(@$_POST['periodo']=='M') echo "selected"?>>Manhã</option>
             <option value="T" <?php if(@$_POST['periodo']=='T') echo "selected"?>>Tarde</option>
             <option value="N" <?php if(@$_POST['periodo']=='N') echo "selected"?>>Noite</option>
          </select>
          </td>
        </tr>
        <tr>
          <td valign="top">Quantidade de vagas:</td>
          <td><input name="vagas" type="text"  onKeyPress="return sonumero(event)" id="vagas" size="4" value="<?php echo @$_POST['vagas']?>" maxlength="4" class="validate[required]" />
          *</td>
        </tr>
        <tr>
          <td valign="top">Aplicar prova:</td>
          <td>
             <input name="prova" type="radio" value="1" id="provaSim" class="rdProva" <?php if(@$_POST['prova']==1) echo "checked"; ?>/> Sim <input name="prova" type="radio"  id="provaNao" value="0" class="rdProva" <?php if(@$_POST['prova']==0 || empty($_POST['prova'])) echo "checked"; ?> /> Não
          </td>
        </tr>
        
         <tr   style="display:<?php if(@$_POST['prova']==1) echo ''; else echo 'none'?>"  id="linhaProva">
          <td colspan="2">
          
              <table width="1056">
                   <tr >
                  <td width="197" valign="top">Local da prova: </td>
                  <td width="847" align="left"><input name="provaLocal" type="text"   id="provaLocal" size="50" value="<?php echo @$_POST['provaLocal']?>" maxlength="150"  />
                    </td>
                </tr>
                <tr >
                  <td valign="top">Data da prova:</td>
                  <td align="left"><input name="provaData" type="text" id="provaData" size="10" value="<?php echo !empty($_POST['provaData']) ? @$_POST['provaData'] : '00/00/0000';?>" maxlength="10" class="validate[required]" />
                    *</td>
                </tr>
                <tr >
                  <td valign="top">Horário da prova:</td>
                  <td align="left"><input name="provaHorario" type="text" id="provaHorario" size="5" value="<?php echo @$_POST['provaHorario']?>" maxlength="5" class="validate[required]" />
                    *</td>
                </tr>
                <tr  >
                  <td valign="top"> Empresa que aplicará a prova:</td>
                  <td align="left">
                   <select name="empresaProva" id="empresaProva" class="validate[required]">
                       <option value="">selecione...</option>
                    <?php echo Lumine_Util::buildOptions($empresas,'id','fantasia', @$_POST['empresaProva']); ?>
                   </select>
                   *
                   </td>
                </tr>
      </table>
          
          
          </td>
         
        </tr>

       

        <tr>
          <td valign="top">Permite inscrição pela web:</td>
          <td><input name="inscricaoweb" type="radio" id="inscricaowebSim" value="1" class="rdInscricaoweb" <?php if(@$_POST['inscricaoweb']==1 || empty ($_POST['inscricaoweb'])) echo "checked"; ?> />
Sim
  <input name="inscricaoweb" type="radio" value="0"  id="inscricaowebNao" class="rdInscricaoweb" <?php if(@$_POST['inscricaoweb']==0) echo "checked"; ?> />
Não </td>
        </tr>
       
        <tr id="linhaDataInicioInscricao" >
          <td valign="top">Data inicial de inscrições:</td>
          <td><input name="dataInicioInscricao" type="text" id="dataInicioInscricao" size="10" value="<?php echo @$_POST['dataInicioInscricao']?>" maxlength="10" class="validate[required]" />
          *</td>
        </tr>
        <tr id="linhaDataFinalInscricao" >
          <td valign="top">Data final das inscrições:</td>
          <td><input name="dataFinalInscricao" type="text" id="dataFinalInscricao" size="10" value="<?php echo @$_POST['dataFinalInscricao']?>" maxlength="10" class="validate[required]" />
          *</td>
        </tr>
          <tr id="linhaLocalInscricao" >
                  <td width="17%" valign="top">Local das inscrições: </td>
                  <td width="83%" align="left">
                  <?php if(!empty($_POST['localInscricao'])){ ?>
                      <input name="localInscricao" type="text"   id="localInscricao" size="50" value="<?php echo @$_POST['localInscricao']?>" maxlength="170" class="validate[required]" />
                  <?php }else{ ?>
                      <input name="localInscricao" type="text"   id="localInscricao" size="50" value="Pelo Site" maxlength="170" class="validate[required]" />
                  <?php } ?>
                    *</td>
                </tr>
        <tr>
          <td valign="top">Valor estimado do curso:</td>
          <td><input name="valor" type="text" id="valor" size="12" value="<?php echo @$_POST['valor']?>" maxlength="12" class="validate[required]"  />
          * ex: 1.500,00</td>
        </tr>
        <tr>
          <td valign="top">Sala:</td>
          <td><input name="sala" type="text" id="sala" size="20" maxlength="20" value="<?php echo @$_POST['sala']?>"  />
            </td>
        </tr>
        <tr>
          <td valign="top">Idade mínima:</td>
          <td><input name="idade" type="text" id="idade" size="3" value="<?php echo @$_POST['idade']?>" maxlength="3" class="validate[required]" onKeyPress="return sonumero(event)"  />
            * Anos</td>
        </tr>
        <tr>
          <td valign="top">Valor do vale transporte:</td>
          <td><input name="valorVale" type="text" id="valorVale" size="12" value="<?php echo @$_POST['valorVale']?>" maxlength="12"  /> 
          preencher apenas para curso da UNIT Centro e UNIT Éden</td>
        </tr>
        <?php if(!empty($_REQUEST['id'])){ ?>
        <tr>
          <td valign="top">Situação do curso:</td>
          <td align="left">
            <input type="radio" name="status" id="radio" value="1" <?php if($_POST['status']==1) echo "checked"; ?>/>
            Andamento
              <input type="radio" name="status" id="status" value="2" <?php if($_POST['status']==2) echo "checked"; ?> /> 
            Finalizado
            <input type="radio" name="status" id="status" value="3" <?php if($_POST['status']==3) echo "checked"; ?> /> 
            Cancelado
            
             <input type="radio" name="status" id="status" value="4" <?php if($_POST['status']==4) echo "checked"; ?> /> 
            Programado
        </td>
        </tr>
        <?php }else{ ?>
          <tr>
          <td valign="top">Situação do curso:</td>
          <td align="left">
            <input type="radio" name="status" id="radio" value="1" checked="checked"/> 
            Andamento
            <input type="radio" name="status" id="status" value="4"/> Programado
            </td>
          </tr>
        <?php } ?>
        <tr>
          <td valign="top">Publicar no Site:</td>
          <td align="left">
            <select name="publicar" id="publicar">
              <option value="1" <?php if(@$_POST['publicar']==1) echo "selected"; ?>>Sim</option>
              <option value="0" <?php if(@$_POST['publicar']==0) echo "selected"; ?>>Não</option>
            </select>
            
            </td>
        </tr>
        <tr>
          <td valign="top">Gerar agendas automáticamente?</td>
          <td>
              <input type="checkbox" name="gerarAgendas" value="S"/>
              
          </td>
        </tr>
        <tr>
          <td valign="top">Observação:</td>
          <td><textarea name="obs" cols="65" rows="8"><?php echo @$_POST['obs']?></textarea></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">* campos obrigatórios</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">                                                                                                    
           <input type="hidden" name="acao" value="gravar">
           <input type="submit" name="btGravar" id="btGravar" value="<?php echo $lbBotao?>">
           <input name="id" id="idAgenda" type="hidden" value="<?php echo @$_POST['id']?>" />
           <input type="button" name="enviar2" id="" value="Voltar" onClick="self.location='principal.php?acao=<?php echo $_SESSION['ORIGEM']?>&offset=<?php echo $_SESSION['OFFSET']?>'">
          </td>
        </tr>
      </table>
</form>
