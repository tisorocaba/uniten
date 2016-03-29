$(document).ready(function(){
    
    
    CKEDITOR.replace('conhecimento', {
        //extraPlugins: 'magicline,filebrowser,popup', // Ensure that magicline plugin, which is required for this sample, is loaded.
        magicline_color: 'blue', // Blue line
        allowedContent: true,		// Switch off the ACF, so very complex content created to
        toolbar : 'Basic'
    });


    $('#cep').mask('99999-999');

    $("input").focus(function(e){
        $('.formError').fadeTo("fast", 0.3, function() {
            $(this).remove();
        });
    });

   $("input").keypress(function(e){
        c = e.which ? e.which : e.keyCode;
        if(c==13){
             $("#form1").validationEngine();
        }
    })



    $("#form1").validationEngine();

   


});
