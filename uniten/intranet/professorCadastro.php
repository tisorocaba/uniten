<?php
require_once 'util/config.php';
Security::admSecurity();
$empresas = new Empresa();
 $empresas->alias('p')->where('p.ativo=1 and status >=2')->order('p.nome ASC')->find();

$disciplina = new Disciplina();
$disciplina->alias('d')->where('d.ativo=1')->order('d.nome ASC')->find();

$totalGeral = $disciplina->count();
$div = ceil($totalGeral/2);
$disciplina->limit(0, $div)->find();

$disciplinacol2 = new Disciplina();
$disciplinacol2->alias('d')->where('d.ativo=1')->order('d.nome ASC')->find();
$disciplinacol2->limit($div,($totalGeral+10))->find();





$cursos = new Curso();
$cursos->alias('c')->where('c.ativo=1')->order('c.nome ASC')->find();

if (!empty($_GET['id'])) {
    $obj = new Professor();
    $obj->get($_GET['id']);
    $_POST = $obj->toArray();
    $lbBotao = "Alterar";
    $list = $obj->getLink('disciplinas');
    $empresa = $_POST['empresa'];
    foreach ($list as $item) {
        $_POST['disciplinas'][] = $item->id;
    }
    logDao::gravaLog($user->login, 'professorCadastro', 'Acessou: cadastro de professor(alteracao) ', $_REQUEST,'','Professor: '.$_GET['id']);

} else {
    $empresa = @$_REQUEST['empresa'];
    $lbBotao = "Gravar";
    logDao::gravaLog($user->login, 'professorCadastro', 'Acessou: cadastro de professor(novo) ', $_REQUEST);

}

?>
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css"/>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript"  src="scripts/professorCadastro.js"></script>
<p><span class="titulo">Professor &raquo; Cadastro</span><br>

</p>
<form name="form1" id="form1" method="post" action="professorLogic.php">
    <input type="hidden" id="id" name="id" value="<?php echo @$_GET['id']?>">
    <table width="100%" cellpadding="3" cellspacing="1">
        <tr>
            <td valign="top">Empresa: </td>
            <td align="left">
              
                    <select name="empresa" id="cbEmpresas" class="validate[required]">
                        <option value="">Selecione...</option>
                    <?php echo Lumine_Util::buildOptions($empresas, 'id', 'fantasia', $empresa); ?>
                </select>
                
            *</td>
        </tr>
        <tr>
            <td width="17%" valign="top">Nome:</td>
            <td width="83%"><input name="nome" type="text" id="nome" value="<?php echo @$_POST['nome'] ?>" size="50" maxlength="85" class="validate[required]">
              *</td>
        </tr>
        <tr>
            <td valign="top">Email:</td>
            <td><input name="email" type="text" id="email"  value="<?php echo @$_POST['email'] ?>" size="50" maxlength="120" class="validate[required,custom[email]]" />
              *</td>
        </tr>
        <tr>
            <td valign="top">CPF:</td>
            <td><input name="cpf" type="text" id="cpf" value="<?php echo @$_POST['cpf'] ?>" size="11" maxlength="11" class="validate[required]" onKeyPress="return sonumero(event)" />
              *</td>
        </tr>
        <tr>
            <td valign="top">Telefone:</td>
            <td><input name="foneDDD" type="text" id="foneDDD" onKeyPress="return sonumero(event)"  value="<?php echo @$_POST['foneDDD'] ?>" size="2" maxlength="2" class="validate[required]" />
                -
                <input name="foneNumero" type="text" id="foneNumero" onKeyPress="return sonumero(event)"  value="<?php echo @$_POST['foneNumero'] ?>" size="9" maxlength="9" class="validate[required]" />
                *</td>
        </tr>
        <tr>
            <td valign="top">Celular:</td>
            <td><input name="celDDD" type="text" id="celDDD" size="2" onKeyPress="return sonumero(event)"  value="<?php echo @$_POST['celDDD'] ?>" />
                -            <input name="celNumero" type="text" id="celNumero" onKeyPress="return sonumero(event)"  value="<?php echo @$_POST['celNumero'] ?>"  size="9" maxlength="9"  /></td>
        </tr>
        <tr style="display:none">
          <td valign="top">Cursos:</td>
          <td align="left">
          <select name="curso" id="curso" class="validate[required]">
            <option value="">Selecione</option>
            <?php echo Lumine_Util::buildOptions($cursos, 'id', 'nome', $cursos); ?>
          </select></td>
        </tr>
        <tr>
            <td valign="top">Disciplinas:</td>
            <td align="left">
              <span id="disciplinas"></span>
              
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 
                   
                   <tr>
                       <td class="normal" width="50%" >
                          <?php while($disciplina->fetch() ){ ?>
                           
                           <?php 
                              printf('<input type="checkbox" name="disciplinas[]" class="validate[minCheckbox[1]]" id="disciplinas" value="%d" %s  /> %s <br />',
                            $disciplina->id,
                            !empty($_POST['disciplinas']) && in_array($disciplina->id, $_POST['disciplinas']) ? 'checked="checked"' : '',
                            $disciplina->nome);
                          ?>

                 
                           
                          <?php } ?>
                           
                       </td>
                       <td class="normal" width="50%" >
                           
                           <?php while($disciplinacol2->fetch() ){ ?>
                           
                           <?php 
                              printf('<input type="checkbox" name="disciplinas[]" class="validate[minCheckbox[1]]" id="disciplinas" value="%d" %s  /> %s <br />',$disciplinacol2->id,
                              !empty($_POST['disciplinas']) && in_array($disciplinacol2->id, $_POST['disciplinas']) ? 'checked="checked"' : '',$disciplinacol2->nome);
                            ?>

                 
                           
                          <?php } ?>
                           
                       </td>
                   </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td valign="top">&nbsp;</td>
            <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">* campos obrigatórios</td>
        </tr>
        <tr>
            <td valign="top">&nbsp;</td>
            <td align="left">


                <input type="hidden" name="acao" value="gravar">
                <input type="submit" name="btGravar" id="btGravar" value="<?php echo $lbBotao ?>">
                <input name="id" type="hidden" value="<?php echo @$_POST['id'] ?>" />
                <input type="button" name="enviar2" id="" value="Voltar" onClick="self.location='principal.php?acao=professores'">



            </td>
        </tr>
    </table>
</form>
