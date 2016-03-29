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
							 
							 
	 $("#fim").datepicker();
	
	
	
    acionaDisciplinas();
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

    $("#cbProfessor").change(function(e){
        acionaDisciplinas();
    });


    $("#conteudo").limit(150, "#lbConteudo");






    $("#form1").validationEngine();

   


});

function acionaDisciplinas(){

    if($("#cbProfessor").val()!=''){
        $.ajax({
            type: "POST",
            url: "ajax_professor_disciplinas.php",
            data: "professor="+$("#cbProfessor").val()+"&disciplina="+$("#disciplina").val(),
            success: function(msg){
                $("#linhaDisciplinas").fadeIn('fast');
                $("#cbDisciplinas").html(msg);
            }
        });
    }else{
        $.ajax({
            type: "POST",
            url: "ajax_professor_disciplinas.php",
            data: "professor=0",
            success: function(msg){
                $("#linhaDisciplinas").fadeIn('fast');
                $("#cbDisciplinas").html(msg);
            }
        });
    }
}
