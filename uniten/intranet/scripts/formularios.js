$(document).ready(function(){
    $(".excluir").click(function () {
        if (!confirm("Tem certeza que deseja apagar?")){
            return false;
        }else{
            self.location='formularioLogic.php?id='+this.id+"&acao=remover";
        }
    });

    $("input").focus(function(e){
        $('.formError').fadeTo("fast", 0.3, function() {
            $(this).remove();
        });
    });

    $("input").keypress(function(e){
        c = e.which ? e.which : e.keyCode;
        if(c==13){
            $("#form1").validationEngine();
        }
    })

   
    $("#form1").validationEngine();
      
     


});



