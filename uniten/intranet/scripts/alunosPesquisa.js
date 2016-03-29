$(document).ready(function(){
    $(".remover").click(function () {
        if (!confirm("Tem certeza que deseja apagar?")){
            return false;
        }else{
            self.location='agendaCursoLogic.php?id='+this.id+"&acao=remover";
        }
    });

   
    $(".cssHistorico").colorbox(
    {
        width:"80%",
        height:"80%",
        iframe:true
    }

    );

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



