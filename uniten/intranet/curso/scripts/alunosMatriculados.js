$(document).ready(function(){
    $(".cssConfirmacao").click(function () {
        if($(this).attr('checked')==true){
            alteraStatus(this.id,1);
        }else{
            alteraStatus(this.id,0);
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



