$(document).ready(function(){
    $(".logout").click(function () {
        if (!confirm("Tem certeza que deseja apagar?")){
            return false;
        }else{
            self.location='agendaCursoLogic.php?id='+this.id+"&acao=remover";
        }
    });

   

    $(".cssCandidados").colorbox(
		{
			width:"80%",
			height:"80%",
			iframe:true
		}

	);
      $(".cssHistorico").colorbox(
		{
			width:"50%",
			height:"60%",
			iframe:true
		}

	);      
            
    
	



});



