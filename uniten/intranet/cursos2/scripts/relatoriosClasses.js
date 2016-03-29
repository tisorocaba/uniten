$(document).ready(function(){
   
      
    $("#cbCursos").change(function () {
        self.location='principal.php?acao=agendacursos&curso='+this.value+'&status='+document.getElementById('status').value;
    })


  

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



