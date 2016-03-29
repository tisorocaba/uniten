$(document).ready(function(){
    $(".logout").click(function () {
        if (!confirm("Tem certeza que deseja apagar?")){
            return false;
        }else{
            self.location='disciplinaLogic.php?id='+this.id+"&acao=remover";
        }
     });

      $(".ativacao").click(function () {
         var aDados = this.id.split('|');
         self.location='disciplinaLogic.php?id='+aDados[1]+"&ativo="+aDados[0]+"&acao=ativacao";
      });
      
      $("#btPesquisa").click(function () {
          if($('#pesquisa').val()==''){
              alert('Por favor informe um valor!');
              $('#pesquisa').focus();
          }else{
              self.location='principal.php?acao=disciplinas&pesquisa='+$('#pesquisa').val();
          }
           
      });




});



