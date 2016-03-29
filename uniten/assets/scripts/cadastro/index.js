$(document).ready(function(){

    $('#cpf').mask('999.999.999-99');
	$('#dataNascimento').mask('99/99/9999');

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

   $("a[rel='acaolink']").colorbox({
        width:"80%", height:"80%", iframe:true
    });



});
