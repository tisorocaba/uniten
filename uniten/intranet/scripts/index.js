$(document).ready(function(){


    $("#btLogar").click(function () {
        if($("#login").val()==""){
            alert('Por favor informe o login!');
            $("#login").focus();
            return false;
        }

        if($("#senha").val()==""){
            alert('Por favor informe a senha!');
            $("#senha").focus();
            return false;
        }


        $("#formLogin").submit();

    });

    $('#btEsqueciSenha').click(function() {

        if($('#login').val()==""){
            alert('Por favor, informe o login!');
            $('#login').focus();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "gestorLogic.php",
            data: "login="+$('#login').val()+"&acao=reenviarsenha",
            success: function(dado){
                if(dado==1){
                    alert('OK: Uma nova senha foi enviada para o email informado no cadastro!');
                }else{
                    alert('ERRO: Não foi possível enviar a senha para o login informado');
                }

            }
        });


    });


   $("#reenviaSenha").colorbox({
        width:"50%",
        height:"50%",
        iframe:true
    });



});
