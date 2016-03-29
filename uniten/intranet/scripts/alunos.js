$(document).ready(function(){

   
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
	
	$( "#pesquisa" ).combogrid({
		url: 'ajax_pesquisa_aluno.php',
		debug:true,
    //replaceNull: true,
		colModel: [{'columnName':'name','width':'60','label':'Aluno'},{'columnName':'documento','width':'30','label':'CPJ'}],
		select: function( event, ui ) {
			self.location='principal.php?acao=alunoFicha&cod='+ui.item.id
			return false;
		}
	});

    
  
    


});

