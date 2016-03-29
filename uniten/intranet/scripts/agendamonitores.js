$(document).ready(function(){
    $(".cssAlteraProfessorAgenda").click(function () {
        $aInfo = this.value.split('|');
        alteraProfessorAgenda($aInfo[0],$aInfo[1])
    });
    
 

   


});

function alteraProfessorAgenda(disciplina,professor){
    $.ajax({
        type: "POST",
        url: "ajax_agenda_professor_disciplina.php",
        data: "professor="+professor+"&disciplina="+disciplina,
        success: function(msg){
        //alert( "Alterado para: " + msg );
        }
    });
}



