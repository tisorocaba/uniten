$(document).ready(function(){

   
    
    
    
    
    $('#btPesquisarCep').click(function(){
        carregaCEP();
    });



    $("input").focus(function(e){
        $('.formError').fadeTo("fast", 0.3, function() {
            $(this).remove();
        });
    });

    $("input").keyup(function(e){
        c = e.which ? e.which : e.keyCode;
        if(c==13){
            $("#form1").validationEngine();
        }else{
           // $(this).val($(this).val().toUpperCase());
        }
    })


  

    $("#form1").validationEngine();




});




function carregaCEP(){

    if(document.getElementById('cep').value!=""){
        $('#lbCep').html("pesquisando...");
        $.ajax({
            contentType: 'application/json',
            url: 'http://api.sorocaba.sp.gov.br/comdata/endereco/pesquisarPorCep?cep=' + document.getElementById('cep').value,
            success: function(msg){
                $('#lbCep').html("");
                if(msg[0]){
                    var aDados = msg[0];
                    document.getElementById('endereco').value = aDados.tipoLogradouro + ' ' + aDados.logradouro;
                    document.getElementById('bairro').value   = aDados.bairro;
                    document.getElementById('cidade').value   = aDados.localidade;
                }else{
                     document.getElementById('endereco').value = '' ;
                     document.getElementById('bairro').value   = '';
                     document.getElementById('cidade').value   = '';
                     document.getElementById('numero').value   = '';
                     alert('CEP não localizado');
                }
            }
        });
    }else{
        alert('Por favor informe um cep!');
        document.getElementById('cep').focus();
    }

}
