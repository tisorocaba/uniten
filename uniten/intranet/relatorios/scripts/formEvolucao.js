$(document).ready(function(){

   
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

    $("input").keyup(function(e){
        $('#pesquisa').val($(this).val().toUpperCase());
    })


    $("#form1").validationEngine();

   
  
    


});

