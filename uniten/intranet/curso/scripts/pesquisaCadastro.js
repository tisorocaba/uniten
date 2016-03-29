$(document).ready(function(){

 
    $("input").focus(function(e){
        $('.formError').fadeTo("fast", 0.3, function() {
            $(this).remove();
        });
    });

   $('#form1').validationEngine();
   

});

