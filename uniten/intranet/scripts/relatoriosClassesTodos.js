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
        self.location='agendaCursoLogic.php?id='+aDados[1]+"&ativo="+aDados[0]+"&acao=ativacao&busca="+$('#busca').val();
    });
      
    $("#cbCursos").change(function () {
        self.location='principal.php?acao=relatoriosClassesTodos&curso='+this.value;
    })

    $(".cssAlunos").colorbox(
    {
        width:"80%",
        height:"80%",
        iframe:true
    }

    );
        
    $("#cbLocal").change(function () {
        if($('#cbLocal').val()!=''){
            self.location='principal.php?acao=relatoriosClassesTodos&local='+$('#cbLocal').val();
        }
    });


  

    $("#btPesquisar").click(function () {
        if($('#busca').val()==''){
            alert('Por favor preencha o campo busca!');
            $('#busca').focus();
            return false;
        }else{
            self.location='principal.php?acao=relatoriosClassesTodos&busca='+$('#busca').val();
        }
    });


});



