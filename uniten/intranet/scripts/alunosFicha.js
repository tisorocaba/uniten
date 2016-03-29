$(document).ready(function(){
   
   
    $("#btnHistorico").colorbox(
		{
			href:"alunoHistorico.php?cod="+$("#hidAluno").val(),
			width:"80%",
			height:"80%",
			iframe:true
		}

    );


});



