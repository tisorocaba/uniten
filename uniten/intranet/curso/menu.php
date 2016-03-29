
<table width="100%" border="0" cellspacing="1" cellpadding="5">
      <tr class="bgMenu">
        <td>&#8226; <a href="principal.php" class="menuNavegacao">Relatórios de Classe</a></td>
      </tr>
  
      
   <?php if((int)$user->tipoLogin == 1){ ?>  
     <tr class="bgMenu">
        <td>&#8226; <a href="principal.php?acao=pendencias" class="menuNavegacao">Pendências</a></td>
      </tr>
       <tr class="bgMenu">
        <td>&#8226; <a href="principal.php?acao=gastos" class="menuNavegacao">Controle Financeiro</a></td>
      </tr>
   <?php } ?>
    
    <tr class="bgMenu">
        <td>&#8226; <a href="principal.php?acao=senhaCadastro" class="menuNavegacao">Alterar Senha</a></td>
      </tr>
     
    </table> 
