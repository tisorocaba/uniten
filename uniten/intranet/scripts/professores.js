$(document).ready(function(){
    $(".logout").click(function () {
        if (!confirm("Tem certeza que deseja apagar?")){
            return false;
        }else{
            self.location='professorLogic.php?id='+this.id+"&acao=remover";
        }
     });

      $(".ativacao").click(function () {
         var aDados = this.id.split('|');
         self.location='professorLogic.php?id='+aDados[1]+"&ativo="+aDados[0]+"&acao=ativacao";
      });
      
      $("#cbEmpresas").change(function () {
           self.location='principal.php?acao=professores&empresa='+this.value;
      })
      
      $("#btLocalizar").click(function () {
          self.location='principal.php?acao=professores&busca='+$('#busca').val()+'&cbEmpresas='+$('#empresa').val();
      });
	  
	   
    $(".cssHistorico").colorbox(
    {
        width:"80%",
        height:"80%",
        iframe:true
    }

    );



});



