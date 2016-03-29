$(document).ready(function(){

 /*  habilitaCampos();
 
   habilitaEmpregoAnterior();
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

    $("#cbTrabalhando").change(function(e){
        habilitaCampos();
    });
    
     $("#cbAutonomo").change(function(e){
        habilitaAutonomo();
    });
    
     $("#cbEstavaEmpregado").change(function(e){
        habilitaEmpregoAnterior();
    });





    $("#form1").validationEngine();

   */


});


function habilitaCampos(){
	
    if($('#cbTrabalhando').val()==1){
      $('#linhaRegistrado').show('fast');
      $('#linhaEmpresa').show('fast');
      $('#linhaFuncao').show('fast');
      $('#linhaAutonomo').show('fast');
	  habilitaAutonomo();
    }else{
      $('#linhaRegistrado').hide('fast');
      $('#linhaEmpresa').hide('fast');
      $('#linhaFuncao').hide('fast');
      $('#linhaAutonomo').hide('fast');
    }
	  
}


function habilitaAutonomo(){
    if($('#cbAutonomo').val()==0){
      $('#linhaRegistrado').show('fast');
      $('#linhaEmpresa').show('fast');
      $('#linhaFuncao').show('fast');
     
    }else{
      $('#linhaRegistrado').hide('fast');
      $('#linhaEmpresa').hide('fast');
      $('#linhaFuncao').hide('fast');
     
    }
}

function habilitaEmpregoAnterior(){
    if($('#cbEstavaEmpregado').val()==1){
        $('#linhaArea').show('fast');
        $('#linhaCursoAjudou').show('fast');
    }else{
        $('#linhaArea').hide('fast');
        $('#linhaCursoAjudou').hide('fast');
    }
    
    
}
