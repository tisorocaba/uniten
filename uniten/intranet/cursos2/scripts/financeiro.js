$(document).ready(function(){

   $("#data_inicio").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
   $("#data_fim").inputmask("dd/mm/yyyy", {"placeholder": "mm/dd/yyyy"});
   
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

    $("#inicio").datepicker();
    $("#fim").datepicker();
  
    


});

