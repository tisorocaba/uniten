$(document).ready(function(){
    $(".remover").click(function () {
        if (!confirm("Tem certeza que deseja apagar?")){
            return false;
        }else{
            self.location='usuarioLogic.php?id='+this.id+"&acao=remover";
        }
     });

      $(".ativacao").click(function () {
         var aDados = this.id.split('|');
         self.location='usuarioLogic.php?id='+aDados[1]+"&ativo="+aDados[0]+"&acao=ativacao";
      });
      
      $("#cbEmpresas").change(function () {
           self.location='principal.php?acao=usuarios&empresa='+this.value;
      })


});



