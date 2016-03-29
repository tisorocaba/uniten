<?php 
require_once 'util/config.php';
$usuarios = new Usuario();
$usuarios->alias('a')->where('a.empresa = ?',$_REQUEST['empresa'])->order('nome ASC')->find();
if(empty($_REQUEST['log'])){
?>
<select name="usuario" id="usuario">
             <?php echo Lumine_Util::buildOptions($usuarios, 'login', 'nome', ''); ?>
</select>
<?php }else { ?>
<select name="usuario" id="usuario">
              <option value="">TODOS</option>
             <?php echo Lumine_Util::buildOptions($usuarios, 'login', 'nome', ''); ?>
</select>

<?php } ?>