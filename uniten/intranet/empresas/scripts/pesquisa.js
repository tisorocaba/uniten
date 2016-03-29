$(document).ready(function(){

    $.datepicker.setDefaults({dateFormat: 'dd/mm/yy',
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

    $("input").keyup(function(e){
        $('#pesquisa').val($(this).val().toUpperCase());
    })


    $("#form1").validationEngine();

    $("#inicio").datepicker();
    $("#fim").datepicker();
  
    


});

