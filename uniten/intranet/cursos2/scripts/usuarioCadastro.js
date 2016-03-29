$(document).ready(function(){

   


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

     
    $('#cbStatus').change(function() {
        carregaEmpresa();
    });

   

    $('#cbEmpresa').live('change', function() {
        carregaMenus();

    });






});

function carregaMenus(){
    if($('#cbStatus').val()==1){
            $('#linhaNivel-1').fadeIn('fast');
            $('#linhaNivel-2').fadeOut('fast');
            $('#linhaNivel-3').fadeOut('fast');
        }else if($('#cbStatus').val()==2){
            $('#linhaNivel-1').fadeOut('fast');
            $('#linhaNivel-2').fadeIn('fast');
            $('#linhaNivel-3').fadeOut('fast');
        }else{
            $('#linhaNivel-1').fadeOut('fast');
            $('#linhaNivel-2').fadeOut('fast');
            $('#linhaNivel-3').fadeIn('fast');
        }
}

function carregaEmpresa(){

    if(document.getElementById('cbStatus').value!=""){
        $('#lbEmpresas').html("consultando lista...");
        $.ajax({
            type: "POST",
            url: "ajax_lista_empresa_tipo.php",
            data: "status="+document.getElementById('cbStatus').value+"&empresa="+document.getElementById('idEmpresa').value,
            success: function(msg){
                $('#linhaEmpresa').fadeIn('fast');
                $('#spanEmpresa').html(msg);
                
            }
        });
        $('#lbEmpresas').html("");
    }

}
