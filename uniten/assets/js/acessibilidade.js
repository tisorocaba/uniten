// desenvolvido por Bernard De Luna - www.bernarddeluna.com  / @bernarddeluna
$(document).ready(function() {
	
	// aumentando a fonte
	$(".inc-font").click(function () {
		var size = $("body").css('font-size');
		
		size = size.replace('px', '');
		size = parseInt(size) + 2.4;
		
		$("body").animate({'font-size' : size + 'px'});
	});
	
	//diminuindo a fonte
	$(".dec-font").click(function () {
		var size = $("body").css('font-size');
		
		size = size.replace('px', '');
		size = parseInt(size) - 2.4;
		
		$("body").animate({'font-size' : size + 'px'});
	});
	
	// resetando a fonte
	$(".res-font").click(function () {		
		$("body").animate({'font-size' : '20px'});
	});

}); 
