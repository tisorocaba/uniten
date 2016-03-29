$(document).ready(function(){


    $("#btLogar").click(function () {
        if($("#cnpj").val()==""){
            alert('Por favor informe o CNPJ!');
            $("#cnpj").focus();
            return false;
        }

        if($("#senha").val()==""){
            alert('Por favor informe a senha!');
            $("#senha").focus();
            return false;
        }


        $("#formLogin").submit();

    });
	
	 $("input").keypress(function(e){
        c = e.which ? e.which : e.keyCode;
        if(c==13){
            $("#formLogin").submit();
        }
    })


    $('#btRenviarSenha').click(function() {

        if($('#cnpj').val()==""){
            alert('Por favor, informe o CNPJ!');
            $('#cnpj').focus();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "empresaLogic.php",
            data: "cnpj="+$('#cnpj').val()+"&acao=reenviarsenha",
            success: function(dado){
                if(dado==1){
                    alert('OK: Uma nova senha foi enviada para o email informado no cadastro!');
                }else{
                    alert('ERRO: Não foi possível enviar a senha para o login informado');
                }

            }
        });


    });


   



});
