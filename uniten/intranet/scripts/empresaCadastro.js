$(document).ready(function(){

   // $('#cep').mask('99999-999');
   // $('#telefone').mask('9999-9999');


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

    $('#btPesquisar').click(function() {
        carregaCEP();
     });

     $('#cep').focusout(function() {
        carregaCEP();
     });
     
      $("input").keyup(function(e){
        $(this).val($(this).val().toUpperCase());
    })



});

function carregaCEP(){

    if(document.getElementById('cep').value!=""){
        $('#lbCep').html("consultando correios...");
        $.ajax({
            type: "POST",
            url: "ajax_busca_cep.php",
            data: "cep="+document.getElementById('cep').value,
            success: function(msg){
                $('#lbCep').html("");
                var aDados = msg.split("|");
                document.getElementById('endereco').value = aDados[0] ;
                document.getElementById('bairro').value   = aDados[1];
                document.getElementById('cidade').value   = aDados[2];
                document.getElementById('estado').value   = aDados[3];

                if(aDados[0]==""){
                    document.getElementById('endereco').focus();
                }else{
                    document.getElementById('numero').focus();
                }
            //document.getElementById('estado').value   = aDados[3];

            }
        });
    }else{
        alert('Por favor informe um cep!');
        document.getElementById('cep').focus();
    }

}
