var agenda;
$(document).ready(function(){
   agenda = $("#hdnAgenda").val();
  $("#btnMonitores").colorbox({
        width:"80%",
        height:"80%",
		href:"agendamonitores.php?agenda="+agenda,
        iframe:true
    });

	$("#btnGrade").colorbox({
        width:"80%",
        height:"80%",
		href:"gradeAgenda.php?agenda="+agenda,
        iframe:true
    });





});
