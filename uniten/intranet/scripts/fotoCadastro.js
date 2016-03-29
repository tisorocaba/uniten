$(document).ready(function(){
	
		
	$("#btGravar").click(function () {
       if($("#foto").val()==""){
		   alert('Por favor selecione uma foto!');
		   $("#foto").focus();
		   return false;
	   }
	   
	  
	  
	   
	   
	   $("#form").submit();
	   
	 });
	
	
	$(".destaque").click(function () {
      
	  
		  
		  $.ajax({
			   type: "POST",
			   url: "fotoLogic.php",
			   data: "foto="+this.id+"&acao=destacar&evento="+$("#galeria").val(),
			   success: function(msg){
				 
			   }
				   
		 });
		
	
	
     });
	
	
	$(".remover").click(function () {
      
	      var id = this.id;
		  
		  $.ajax({
			   type: "POST",
			   url: "fotoLogic.php",
			   data: "foto="+id+"&acao=excluirfoto&evento="+$("#galeria").val(),
			   success: function(msg){
				   var div = "#caixa"+msg;
				   $(div).fadeOut("slow");   
			   }
				   
		 });
		
	
	
     });

	
	
	
	 
	
});