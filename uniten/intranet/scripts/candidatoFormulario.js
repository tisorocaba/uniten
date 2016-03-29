$(document).ready(function(){

    /***** Acoes altomaticas *****/
    $('#dataNascimento').mask('99/99/9999');
    $('#cep').mask('99999-999');
    habilitaAutonomo();
    habilitaDesempregado();
    habilitaImovel();
    verificaBolsaFamilia();
    habilitaAutonomo();
    habilitaCondicaoEspecial();
    habilitaDesistencia();
    habilitaDesistenciaMotivo();




    /***** Acoes por eventos *****/
    $('#desempregado').change(function(){
        habilitaAutonomo();
    });
    
    $('#condicaoEspecialProva').change(function(){
        habilitaCondicaoEspecial();
    });
    
    
    
    $('#possuiDeficiencia').change(function(){
        habilitaDeficiencia();
    });
    
    
	
    $('#autonomo').change(function(){
        habilitaDesempregado();
    });

    $('#possuiImovel').change(function(){
        habilitaImovel();
    });

    $('#chBolsaFamilia').click(function(){
        verificaBolsaFamilia();
    });
    
     $('#cbStatusAgenda').click(function(){
        habilitaDesistencia();
    });
    
    $('#cbDesistencia').click(function(){
        habilitaDesistenciaMotivo();
    });
    
    
    
    
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


function habilitaDesistencia(){
    if($("#cbStatusAgenda").val()==4){
        $("#linhaDesistencia").fadeIn('fast');
    }else{
        $("#linhaDesistencia").fadeOut('fast');
        $("#linhaMotivo").fadeOut('fast');
        
    }
}

function habilitaDesistenciaMotivo(){
    if($("#cbDesistencia").val()==1){
        $("#linhaMotivo").fadeIn('fast');
    }else{
        $("#linhaMotivo").fadeOut('fast');
        
    }
}

function habilitaDeficiencia(){
    if($("#possuiDeficiencia").val()=='S'){
        $("#linhatipoDeficiencia").fadeIn('fast');
    }else{
        $("#linhatipoDeficiencia").fadeOut('fast');
        
    }
}

function habilitaCondicaoEspecial(){
    if($("#condicaoEspecialProva").val()=='S'){
        $("#linhaCondicaoEspecialQual").fadeIn('fast');
    }else{
        $("#linhaCondicaoEspecialQual").fadeOut('fast');
        
    }
}

function habilitaAutonomo(){
    if($("#desempregado").val()==1){
        $("#linhaAutonomo").fadeIn('fast');
    }else{
        $("#autonomo").val(0);
        $("#linhaAutonomo").fadeOut('fast');
        $("#linhaDesempregadoTempo").fadeOut('fast');
        $("#desempregadoTempo").val('');
        
    }
}

function habilitaDesempregado(){
    if($("#autonomo").val()==1){
        $("#linhaDesempregadoTempo").fadeOut('fast');
    }else{
        $("#linhaDesempregadoTempo").fadeIn('fast');
    }
}


function habilitaImovel(){
    if($("#possuiImovel").val()==1){
        $("#linhaPossuiImovel").fadeOut('fast');
    }else{
        $("#linhaPossuiImovel").fadeIn('fast');
    }
}

function verificaBolsaFamilia(){
    if($("#chBolsaFamilia").is(':checked')==true){
        $("#linhaBolsaFamilia").fadeIn('fast');
    }else{
        $("#linhaBolsaFamilia").fadeOut('fast');
    }

}

function upperMe(field) {
  var upperCaseVersion = field.value.toUpperCase();
  field.value = upperCaseVersion;
}

function carregaCEP(){

    if(document.getElementById('cep').value!=""){
        $('#lbCep').html("pesquisando...");
        $.ajax({
            url: 'http://api.sorocaba.sp.gov.br/comdata/endereco/pesquisarPorCep?cep=' + document.getElementById('cep').value.replace('-',''),
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
            },
            error: function () {
                $('#lbCep').html("ocorreu um erro");
            }
        });
    }else{
        alert('Por favor informe um cep!');
        document.getElementById('cep').focus();
    }

}

function formataValor(campo) {
	campo.value = filtraCampo(campo);
	vr = campo.value;
	tam = vr.length;

	if ( tam <= 2 ){ 
 		campo.value = vr ; }
 	if ( (tam > 2) && (tam <= 5) ){
 		campo.value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ) ; }
 	if ( (tam >= 6) && (tam <= 8) ){
 		campo.value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ; }
 	if ( (tam >= 9) && (tam <= 11) ){
 		campo.value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ; }
 	if ( (tam >= 12) && (tam <= 14) ){
 		campo.value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ; }
 	if ( (tam >= 15) && (tam <= 18) ){
 		campo.value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ;}
 		
}

function formataNumerico(campo) {

	campo.value = filtraCampo(campo);
	vr = campo.value;
	tam = vr.length;
}

// limpa todos os caracteres especiais do campo solicitado
function filtraCampo(campo){
	var s = "";
	var cp = "";
	vr = campo.value;
	tam = vr.length;
	for (i = 0; i < tam ; i++) {  
		if (vr.substring(i,i + 1) != "/" && vr.substring(i,i + 1) != "-" && vr.substring(i,i + 1) != "."  && vr.substring(i,i + 1) != "," ){
		 	s = s + vr.substring(i,i + 1);}
	}
	campo.value = s;
	return cp = campo.value
}

