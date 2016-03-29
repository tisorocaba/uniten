$(document).ready(function(){
    $(".logout").click(function () {
        if (!confirm("Tem certeza que deseja apagar?")){
            return false;
        }else{
            self.location='agendaCursoLogic.php?id='+this.id+"&acao=remover";
        }
    });

    $(".ativacao").click(function () {
        var aDados = this.id.split('|');
        self.location='agendaCursoLogic.php?id='+aDados[1]+"&ativo="+aDados[0]+"&acao=ativacao&busca="+$('#busca').val()+"&offset="+aDados[2]+"&local="+aDados[3];
    });

    $(".resultado").click(function () {
        var aDados = this.id.split('|');
        self.location='agendaCursoLogic.php?id='+aDados[1]+"&resultado="+aDados[0]+"&acao=resultado&busca="+$('#busca').val()+"&offset="+aDados[2]+"&local="+aDados[3];
    });
      
    $("#cbCursos").change(function () {
        self.location='principal.php?acao=agendacursos&curso='+this.value;
    })

    $(".cssCandidados").colorbox(
    {
        width:"80%",
        height:"80%",
        iframe:true
    }

);
	
    $(".cssLegenda").colorbox({
        width:"50%",
        height:"50%",
        iframe:true
    });
	 
    $(".cssMonitores").colorbox({
        width:"85%",
        height:"85%",
        iframe:true
    });
	
	$(".cssDiarios").colorbox({
        width:"85%",
        height:"85%",
        iframe:true
    });
    
    $("#cbLocal").change(function () {
            if($('#cbLocal').val()!=''){
                self.location='principal.php?acao=agendacursos&local='+$('#cbLocal').val();
            }
    });

    $("#btPesquisar").click(function () {
        if($('#busca').val()==''){
            alert('Por favor preencha o campo busca!');
            $('#busca').focus();
            return false;
        }else{
            self.location='principal.php?acao=agendacursos&busca='+$('#busca').val();
        }
    });


});



