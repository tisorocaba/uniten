$(document).ready(function(){
   

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
            self.location='principal.php?acao=relatoriosClassesProfessor&busca='+$('#busca').val();
        }
    });


});



