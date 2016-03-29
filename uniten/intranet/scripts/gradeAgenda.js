var dataInicio;
var dataTermino;
$(document).ready(function() {
    dataInicio = new Date($("#anoIni").val(), $("#mesIni").val() - 1, $("#diaIni").val());
    dataTermino = new Date($("#anoFim").val(), $("#mesFim").val() - 1, $("#diaFim").val());
  
    adicionaGrade();
    
    $.datepicker.setDefaults(
            {
                dateFormat: 'dd/mm/yy',
                minDate: dataInicio,
                maxDate: dataTermino,
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
                dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                nextText: 'Próximo',
                prevText: 'Anterior'
            });
    $("#data").datepicker();
    $("#cbProfessor").change(function(e) {
        acionaDisciplinas();
    });
    $("#btnGravar").click(function(e) {
        if ($("#cbProfessor").val() == "") {
            alert('Informe o professor');
        } else if ($("#disciplina").val() == "") {
            alert('Informe a disciplina');
        } else if ($("#data").val() == "") {
            alert('Informe a data');
        } else {
            $("#spnGravando").fadeIn('fast');
            adicionaGrade();
        }

    });
     
     $( ".cssRemove" ).live( "click", function() {
        removerGrade(this.id);
     });
    
    



});

function adicionaGrade() {
    $.ajax({
        type: "POST",
        url: "ajax_grade_agenda.php",
        data: "disciplina=" + $("#disciplina").val() + "&data=" + $("#data").val(),
        success: function(msg) {
            $("#spnGravando").fadeOut('fast');
            $("#divLista").html(msg);
        }
    });
}

function removerGrade(id) {
    $.ajax({
        type: "POST",
        url: "ajax_grade_agenda_remover.php",
        data: "grade="+id,
        success: function(msg) {
            var aDados = msg.split("|");
            if(aDados[1]==1){
               var linha = "#linha"+aDados[0];
               $(linha).fadeOut('fast'); 
            }else{
               alert(aDados[2]); 
            }
            
        }
    });
}

function acionaDisciplinas() {
    if ($("#cbProfessor").val() != '') {
        $("#spnBuscando").fadeIn('fast');
        $.ajax({
            type: "POST",
            url: "ajax_professor_disciplinas.php",
            data: "professor=" + $("#cbProfessor").val() + "&disciplina=" + $("#disciplina").val(),
            success: function(msg) {
                $("#spnBuscando").fadeOut('fast');
                $("#spnDisciplinas").html(msg);
            }
        });
    }
}
