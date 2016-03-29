$(document).ready(function(){
    $(".logout").click(function () {
        if (!confirm("Tem certeza que deseja apagar?")){
            return false;
        }else{
            self.location='feriadoLogic.php?id='+this.id+"&acao=remover";
        }
     });

      $(".ativacao").click(function () {
         var aDados = this.id.split('|');
         self.location='feriadoLogic.php?id='+aDados[1]+"&ativo="+aDados[0]+"&acao=ativacao";
      });
      
     


});



