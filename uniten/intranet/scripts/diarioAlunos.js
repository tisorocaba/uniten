$(document).ready(function(){
    $(".cssFalta").click(function () {
        incluirPresenca(this.id,$(this).val());
    });

   $(".cssVale").click(function () {
        incluirVale(this.id,$(this).val());
    });

    $("input").focus(function(e){
        $('.formError').fadeTo("fast", 0.3, function() {
            $(this).remove();
        });
    });

    $("input").keypress(function(e){
        c = e.which ? e.which : e.keyCode;
        if(c==13){
            $("#form2").validationEngine();
        }
    })
   
    $("#form2").validationEngine();

});

function incluirPresenca(aluno,presenca){
    var aDado = aluno.split('-');
    $.ajax({
        type: "POST",
        url: "ajax_aluno_presenca.php",
        data: "aluno="+aDado[1]+"&presenca="+presenca+"&diario="+$('#diario').val(),
        success: function(msg){
            //alert( "Alterado para: " + msg );
        }
    });
}

function incluirVale(aluno,vale){
    var aDado = aluno.split('-');
    $.ajax({
        type: "POST",
        url: "ajax_aluno_vale.php",
        data: "aluno="+aDado[1]+"&vale="+vale+"&diario="+$('#diario').val(),
        success: function(msg){
            //alert( "vale para: " + msg );
        }
    });
}



