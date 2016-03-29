<?php 
require_once 'util/config.php';

$menuCol1 = new Menu();
$menuCol1->alias('m1')->order('m1.nome')->limit(0, 12)->find();

$menuCol2 = new Menu();
$menuCol2->alias('m2')->order('m2.nome')->limit(12, 13)->find();

$menus = array();
if(!empty($_REQUEST['usuario']))
{
  
   $obj = new Usuario();
   $obj->get($_REQUEST['usuario']);
   $i=0;
   foreach ($obj->getLink('menus') as $menu) {
       $menus[$i]= $menu->id;
       $i++;
   }

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="100%" cellpadding="3" cellspacing="1">
 <!-- <tr id="linhaNivel-1" style="display:none">
    <td height="91" colspan="2" valign="top"><table width="544" border="0">
      <tr>
        <td colspan="3" bgcolor="#CCCCCC"align="center">Nível de acesso </td>
      </tr>
      <tr>
        <td width="33%"><input name="menu[]" type="checkbox" class="validate[minCheckbox[1]]" id="menu11" value="5" <?php if(in_array("5", $menus)) echo 'checked';?>  />
          <label for="radio">Agenda de cursos</label></td>
        <td width="35%">&nbsp;</td>
        <td width="32%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr id="linhaNivel-2" style="display:none">
    <td height="93" colspan="2" valign="top"><table width="544" border="0">
      <tr>
        <td colspan="4" bgcolor="#CCCCCC" class="blackPopup" align="center">Nível de acesso </td>
      </tr>
      <tr>
        <td width="27%"><input name="menu" type="checkbox" class="validate[minCheckbox[1]]" id="menu21" value="5"  <?php if(in_array("5", $menus)) echo 'checked';?>/>
          <label for="radio">Agenda de cursos</label></td>
        <td width="24%"><input name="menu" type="checkbox" class="validate[minCheckbox[1]]" id="menu22" value="7" <?php if(in_array("7", $menus)) echo 'checked';?>/>
          Professores</td>
        <td width="30%"><input name="menu" type="checkbox" class="validate[minCheckbox[1]]" id="menu23" value="6" <?php if(in_array("6", $menus)) echo 'checked';?>/>
          <label for="radio4">Relatório de Classes</label></td>
        <td width="19%"><input name="menu" type="checkbox" class="validate[minCheckbox[1]]" id="menu24" value="16" <?php if(in_array("16", $menus)) echo 'checked';?> />
          Usuários</td>
      </tr>
    </table></td>
  </tr>-->
  <tr id="tr">
    <td colspan="2" valign="top"><table width="542" border="0">
      <tr>
        <td colspan="3" bgcolor="#CCCCCC" class="blackPopup" align="center">Nível de acesso </td>
      </tr>
      <tr>
        <td width="33%"><table width="100%" border="0">
              
              <?php while ($menuCol1->fetch()) { ?>
              <tr>
                <td width="17%"><input name="menu[]" type="checkbox" class="validate[minCheckbox[1]]" id="menu<?php echo $menuCol1->id?>" value="<?php echo $menuCol1->id?>" <?php if(in_array($menuCol1->id, $menus)) echo 'checked';?> /></td>
                <td width="83%"><?php echo $menuCol1->nome?></td>
              </tr>
             <?php } ?>
          </table></td>
        <td width="35%">&nbsp;</td>
        <td width="32%">
        
        <table width="100%" border="0">
              
              <?php while ($menuCol2->fetch()) { ?>
              <tr>
                <td width="17%"><input name="menu[]" type="checkbox" class="validate[minCheckbox[1]]" id="menu<?php echo $menuCol2->id?>" value="<?php echo $menuCol2->id?>" <?php if(in_array($menuCol2->id, $menus)) echo 'checked';?> /></td>
                <td width="83%"><?php echo $menuCol2->nome?></td>
              </tr>
             <?php } ?>
          </table>
        
        
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>