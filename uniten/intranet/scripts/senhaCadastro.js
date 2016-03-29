$(document).ready(function(){

    $('#cep').mask('99999-999');

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
