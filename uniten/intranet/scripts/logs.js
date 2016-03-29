$(document).ready(function(){

    $.datepicker.setDefaults({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro', 'Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set', 'Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
   
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


    $('#cbEmpresas').change(function() {
     carregaUsuario();
     
    });


    $("#form1").validationEngine();

    $("#inicio").datepicker();
    $("#fim").datepicker();
  
    


});

function carregaUsuario(){

    if(document.getElementById('cbEmpresas').value!=""){
        $('#lbEmpresas').html("carregando a  lista de usuarios aguarde...");
     
        $.ajax({
            type: "POST",
            url: "ajax_usuario_empresa.php",
            data: "empresa="+document.getElementById('cbEmpresas').value+"&log=ok",
            success: function(msg){
                $('#linhaUsuario').fadeIn('fast');
                $('#spanUsuario').html(msg);
                $('#lbUsuarios').html("");
            }
        });
        
    }

}