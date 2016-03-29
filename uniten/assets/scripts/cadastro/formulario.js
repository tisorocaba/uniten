$(document).ready(function(){

    /***** Acoes altomaticas *****/
    //$('#dataNascimento').mask('99/99/9999');
    //$('#cep').mask('99999-999');
    habilitaAutonomo();
    habilitaDesempregado();
    habilitaImovel();
    verificaBolsaFamilia();
    habilitaAutonomo();
    habilitaCondicaoEspecial();
    habilitaDeficiencia();




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
    
    $('#btPesquisarCep').click(function(){
        carregaCEP();
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



    $("#form1").validationEngine();




});


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
        $("#autonomo").val(1);
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
            type: "POST",
            url: "ajaxbuscacep",
            data: "cep="+document.getElementById('cep').value,
            success: function(msg){
                $('#lbCep').html("");
                if(msg!='ERRO'){
                    var aDados = msg.split("|");
                    document.getElementById('endereco').value = aDados[0] ;
                    document.getElementById('bairro').value   = aDados[1];
                    document.getElementById('cidade').value   = aDados[2];
                }
            //document.getElementById('estado').value   = aDados[3];

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

