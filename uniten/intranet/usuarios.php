<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new Usuario();
$empresas = new Empresa ();
$empresas->alias ('p')->where('p.ativo=1')->order ('p.nome ASC')->find ();

$cbemp = $obj->escape (@$_REQUEST['empresa']);
if (empty ($cbemp)) {
    
     if(empty($_REQUEST['busca'])){
         $obj->alias ('p')
            ->where('ativo = 1')
            ->order ('p.nome ASC')
            ->find ();
    }else{
       
        $busca = $obj->escape($_REQUEST['busca']);
        $obj->alias('p')
            ->where('ativo = 1 and (p.nome like ? or p.id like ?)',$busca,$busca)     
            ->order('p.nome ASC')
            ->find();
    }
    
           
} else {
      if(empty ($_REQUEST['local'])){
           $obj->alias ('p')
            ->where ('p.empresa=? and ativo = 1', $cbemp)
            ->order ('p.nome ASC')
            ->find ();
      }else{
           $obj->alias ('p')
            ->where ('p.empresa=? and p.ativo = 1 and p.local = ?', $cbemp,$_REQUEST['local'])
            ->order ('p.nome ASC')
            ->find ();
      }
           
}
   

$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'usuarios', 'Acessou: lista de usuarios',$_REQUEST);



?>
<script src="scripts/usuarios.js"></script>
<p><span class="titulo">Usuários</span><br>
</p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
          <td colspan="4"><strong>Filtrar por nome</strong>:
            <input type="text" name="busca" id="busca" value="<?php echo @$_REQUEST['busca']?>" />
          <input type="submit" name="button" id="btLocalizar" value="Localizar" /></td>
          <td colspan="3" rowspan="3" align="center"><a href="principal.php?acao=usuarioCadastro">NOVO USUÁRIO</a></td>
        </tr>
        <tr class="listaClara">
          <td colspan="4"><table width="100%" border="0">
            <tr>
                <td width="28%"><strong>Empresa</strong>:
                  <select name="empresa" id="cbEmpresas">
                    <option value="">Todos</option>
                    <?php echo Lumine_Util::buildOptions($empresas, 'id', 'fantasia', $cbemp); ?>
                </select></td>
                <td width="72%">
                <?php if((int)@$_REQUEST['empresa']===1) { 
				$locais = new Local ();
				$locais->alias ('l')->where('l.ativo=1')->order ('l.local ASC')->find ();
				?>
                
                
                <strong>Locais</strong>:
                  <select name="local" id="local" onchange="self.location='principal.php?acao=usuarios&empresa='+document.getElementById('cbEmpresas').value+'&local='+this.value">
                    <option value="">Todos</option>
                    <?php echo Lumine_Util::buildOptions($locais, 'id', 'local', @$_REQUEST['local']); ?>
                </select>
                <?php } ?>
                </td>
            </tr>
          </table></td>
        </tr>
       
        <tr class="listaClara">
          <td><strong>Empresa</strong></td>
          <?php if((int)@$_REQUEST['empresa']===1){ ?>
          <td><strong>Local</strong></td>
          <?php } ?>
          <td><strong>Login</strong></td>
          <td><strong>Usuários</strong></td>
          <td width="1" colspan="3" align="center"><a href="principal.php?acao=usuarioCadastro"></a></td>
        </tr>
        
        <?php
			$cont = 0;
			while ($obj->fetch()) {
			
				if ($cont === 0) {
					$linha = "listaClara";
					$cont = 1;
				} else {
					$linha = "listaEscura";
					$cont = 0;
				}
			?>
					
        <tr class="<?php echo $linha?>">
          <td width="134"><?php echo $obj->empresa->fantasia?></td>
          <?php if((int)@$_REQUEST['empresa']===1){ ?>
          <td width="116"><?php echo Local::staticGet($obj->local)->local?></td>
          <?php } ?>
          <td width="116"><?php echo $obj->login?></td>
          <td width="448"><?php echo $obj->nome?></td>
          <td width="129"><a href="principal.php?acao=senhaUsuarioCadastro&amp;id=<?php echo $obj->id?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />Alterar Senha</a></td>
          <td width="76">
              <a href="principal.php?acao=usuarioCadastro&id=<?php echo $obj->id?>">
                 <img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />Editar 
              </a>
          </td>
          <td width="94" align="right"> <a href="javascript:;" id="<?php echo $obj->id ?>"class="logout remover">
          <img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle">Apagar</a></td>
        </tr>
        <?php } ?>
      </table>
      <p>
      <?php
    @$paginas = $total / $limit;

    if ($paginas > 1) {
        echo "P&aacute;gina(s)";

        for ($i = 0; $i < $paginas; $i++) {

            $exibir = $i + 1;
            $start = $i * $limit;

            if (marcaPagina(@$_GET['offset'], $limit) == $i + 1) {
                printf('&nbsp;[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=usuarios&empresa=' . @$_GET['empresa'].'&local='.@$_REQUEST['local'], $start, $exibir);
            } else {
                printf('&nbsp;<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=usuarios&empresa=' . @$_GET['empresa'].'&local='.@$_REQUEST['local'], $start, $exibir);
            }
        }
    }
?>
</p>