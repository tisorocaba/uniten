$(document).ready(function(){
    $(".cssConfirmacao").click(function () {
        if($(this).attr('checked')==true){
            alteraStatus(this.id,1);
        }else{
            alteraStatus(this.id,0);
        }
    });
    
    $(".remover").click(function () {
        if (!confirm("Tem certeza que deseja remover esse candidato dessa agenda?")){
            return false;
        }else{
            self.location='candidatoLogic.php?aluno='+this.id+"&acao=remover";
        }
    });


    $("#cbExportar").change(function () {
        
        if(this.value != ''){
            var url;
            if (this.value == 'i'){
                url = 'xls_candidatos.php?agenda='+$('#hdAgenda').val();
            
            }else{
                url='xls_alunos.php?agenda='+$('#hdAgenda').val();
            }
            self.location=url;
        } 
        
    });
   


});

function alteraStatus(aluno,status){
    $.ajax({
        type: "POST",
        url: "ajax_aluno_aula.php",
        data: "agenda="+$("#agenda").val()+"&aluno="+aluno+"&status="+status,
        success: function(msg){
        //alert( "Alterado para: " + msg );
        }
    });
}



