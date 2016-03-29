  $(function() {

    $("#horas").inputmask("9:99", {"placeholder": ""});
    $("#data").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    
    acionaDisciplinas();
    $("input").focus(function(e){
        $('.formError').fadeTo("fast", 0.3, function() {
            $(this).remove();
        });
    });

    $(".campDig").keypress(function(e){
        c = e.which ? e.which : e.keyCode;
        if(c==13){
            $("#form1").validationEngine();
        }
    })

    $("#cbProfessor").change(function(e){
        acionaDisciplinas();
    });


    $("#conteudo").limit(150, "#lbConteudo");

       $('#form1').validationEngine();
   
        
	 // desabilitado a pedido da Rosane 14/08
	 /*
         $('#form1').validationEngine('attach', {
		onValidationComplete: function(form, status){
			if (status == true) {  
			    var dataDif = diffData();
			    if(dataDif==0 || dataDif==1){
					//alert('dias:'+diffData())
					//form.validationEngine('showPrompt', 'This is an example', 'pass');
					form.validationEngine('detach');
					form.submit();
				}else{
					alert('AVISO: Prazo para inserção do diário de classe venceu, por favor entre em contato a UNITE')
				}
	
			}
		}           
	});
        */
       
        


});


function diffData(){

    var t1=document.getElementById('data').value;
    var t2=document.getElementById('datahoje').value;
    var one_day=1000*60*60*24; 
	
	var x=t1.split("/");     
    var y=t2.split("/");
	
	var date1=new Date(x[2],(x[1]-1),x[0]);  
    var date2=new Date(y[2],(y[1]-1),y[0]);
    var month1=x[1]-1;
    var month2=y[1]-1; 
	
	_Diff=Math.ceil((date2.getTime()-date1.getTime())/(one_day)); 

	return(_Diff);
}

function acionaDisciplinas(){

    if($("#cbProfessor").val()!=''){
        $.ajax({
            type: "POST",
            url: "../ajax_professor_disciplinas.php",
            data: "professor="+$("#cbProfessor").val()+"&disciplina="+$("#disciplina").val(),
            success: function(msg){
                $("#linhaDisciplinas").fadeIn('fast');
                $("#cbDisciplinas").html(msg);
            }
        });
    }else{
        $.ajax({
            type: "POST",
            url: "../ajax_professor_disciplinas.php",
            data: "professor=0",
            success: function(msg){
                $("#linhaDisciplinas").fadeIn('fast');
                $("#cbDisciplinas").html(msg);
            }
        });
    }
}
