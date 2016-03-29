$(document).ready(function(){

   $("#btGravar").click(function () {
            envia();
    });

    $("input").keypress(function(e){
        c = e.which ? e.which : e.keyCode;
        if(c==13){
             envia();
        }
    })
    
    $("input").keyup(function(e){
        $(this).val($(this).val().toUpperCase());
    })


});

function envia(){

    if($("#nome").val()==""){
        alert('Por favor informe o nome!');
        $("#nome").focus();
        return false;
    }

    $("#form").submit();

}