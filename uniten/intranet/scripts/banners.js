$(document).ready(function(){
    $(".remover").click(function () {
        if (!confirm("Tem certeza que deseja apagar?")){
            return false;
        }else{
            self.location='bannerLogic.php?id='+this.id+"&acao=remover";
        }
     });

     
      
     


});



