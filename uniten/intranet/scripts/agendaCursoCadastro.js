$(document).ready(function(){

    $('#dataInicio').mask('99/99/9999');
    $('#dataTermino').mask('99/99/9999');
	

    $('#dataInicioInscricao').mask('99/99/9999');
    $('#dataFinalInscricao').mask('99/99/9999');
    //$('#provaData').datepicker();



    $('#horarioInicial').mask('99:99');
    $('#horarioFinal').mask('99:99');
    $('#provaHorario').mask('99:99');


    /*var formated_value = $().numberFormat( $('#valor').val(), { decimalsLimit:5 } );
    $('#valor').val(formated_value);*/

    if($('#idAgenda').val()!=''){
        if($('#provaSim').is(':checked')==true){
            $("#linhaEmpresa").fadeIn('slow');
        }

        if($('#inscricaowebSim').is(':checked')==true){
            $("#linhaDataInicioInscricao").fadeIn('slow');
            $("#linhaDataFinalInscricao").fadeIn('slow');
        }
    }
    

    $(".rdProva").click(function(){

        if(this.value==1){
            $("#linhaProva").fadeIn('slow');
        }else{
            $("#linhaProva").fadeOut('slow');
        }
    })
    
    /*$(".rdInscricaoweb").click(function(){

        if(this.value==1){
            $("#linhaDataInicioInscricao").fadeIn('slow');
            $("#linhaDataFinalInscricao").fadeIn('slow');
			$("#linhaLocalInscricao").fadeIn('slow');
        }else{
            $("#linhaDataInicioInscricao").fadeOut('slow');
            $("#linhaDataFinalInscricao").fadeOut('slow');
			$("#linhaLocalInscricao").fadeOut('slow');
        }
    })*/


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

   


});
