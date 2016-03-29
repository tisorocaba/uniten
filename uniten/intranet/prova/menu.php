
<table width="100%" border="0" cellspacing="1" cellpadding="5">
      <tr class="bgMenu">
        <td>&#8226; <a href="principal.php" class="menuNavegacao">Home</a></td>
      </tr>
    <?php foreach ($user->getLink('menus') as $menu) {?>
       <tr class="bgMenu">
        <td>&#8226; <a href="principal.php?acao=<?php echo $menu->pag?>" class="menuNavegacao"><?php echo $menu->nome?></a></td>
      </tr>
    <? } ?>
    
    <tr class="bgMenu">
        <td>&#8226; <a href="principal.php?acao=senhaCadastro" class="menuNavegacao">Alterar Senha</a></td>
      </tr>
     
    </table>
