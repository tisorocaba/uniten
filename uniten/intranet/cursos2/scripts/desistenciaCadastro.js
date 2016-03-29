$(document).ready(function(){

    habilitaCampos();
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

    $("#cbDesistencia").change(function(e){
        
        habilitaCampos();
    });




    $("#form1").validationEngine();

   


});


function habilitaCampos(){
     if($('#cbDesistencia').val()==1){
        $('#linhaDescricao').show('fast');
        $('#linhaMotivo').show('fast');
        $('#linhaAviso').hide('fast');
		$('#tipo').val(1);
		
    }else{
	    $('#linhaAviso').show('fast');
        $('#linhaDescricao').hide('fast');
        $('#linhaMotivo').hide('fast');
		$('#tipo').val(0);
     
    }
}