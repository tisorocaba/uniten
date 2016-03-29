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
    
    $("#nome").keyup(function(e){
        $(this).val($(this).val().toUpperCase());
    })



    $("#form1").validationEngine();


    $("#curso").change(function(){
        if(this.value!=''){
            carregaDisciplina();
        }

    });


});

function carregaDisciplina(){


    $('#disciplinas').html("carregando lista...");
    $.ajax({
        type: "POST",
        url: "ajax_disciplinas.php",
        data: "curso="+document.getElementById('curso').value+"&professor="+document.getElementById('id').value,
        success: function(ret){
            $('#disciplinas').html(ret);
        }
    });


}
