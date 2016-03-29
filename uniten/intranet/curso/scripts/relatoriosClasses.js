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
        self.location='principal.php?acao=agendacursos&curso='+this.value+'&status='+document.getElementById('status').value;
    })

    $(".cssAlunos").colorbox(
    {
        width:"85%",
        height:"90%",
        iframe:true
    }

    );

  

    $("#btPesquisar").click(function () {
        if($('#busca').val()==''){
            alert('Por favor preencha o campo busca!');
            $('#busca').focus();
            return false;
        }else{
            self.location='principal.php?acao=relatoriosClasses&busca='+$('#busca').val()+'&status='+document.getElementById('status').value;
        }
    });


});



