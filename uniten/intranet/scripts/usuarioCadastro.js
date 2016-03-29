$(document).ready(function() {

    carregaEmpresa();
    carregaNiveis();

    if ($('#cbStatus').val() == 2) {
        $('#linhaTipoLogin').fadeIn('fast');
    } else {
        $('#linhaTipoLogin').fadeOut('fast');
    }


    if (document.getElementById('idLocal').value != '') {
        carregaLocalAlt();
    }

    if ($('#id').val() != '') {
        carregaMenus();
    }

    $("input").focus(function(e) {
        $('.formError').fadeTo("fast", 0.3, function() {
            $(this).remove();
        });
    });

    $("#nome").keyup(function(e) {
        $(this).val($(this).val().toUpperCase());
    })

    $("input").keypress(function(e) {
        c = e.which ? e.which : e.keyCode;
        if (c == 13) {
            $("#form1").validationEngine();
        }
    })

    $("#form1").validationEngine();


    $('#cbStatus').change(function() {
        carregaEmpresa();
        carregaNiveis();
        if ($('#cbStatus').val() == 2) {
            $('#linhaTipoLogin').fadeIn('fast');
        } else {
            $('#linhaTipoLogin').fadeOut('fast');
        }
    });



    $('#cbEmpresa').live('change', function() {
        carregaMenus();
        carregaLocal();

    });








});



function carregaMenus() {


    if ($('#cbStatus').val() == 1) {
        $('#linhaNivel-1').fadeIn('fast');
        $('#linhaNivel-2').fadeOut('fast');
        $('#linhaNivel-3').fadeOut('fast');
    } else if ($('#cbStatus').val() == 2) {
        $('#linhaNivel-1').fadeOut('fast');
        $('#linhaNivel-2').fadeIn('fast');
        $('#linhaNivel-3').fadeOut('fast');
    } else {
        $('#linhaNivel-1').fadeOut('fast');
        $('#linhaNivel-2').fadeOut('fast');
        $('#linhaNivel-3').fadeIn('fast');
    }
}

function carregaNiveis() {
    if ($('#cbStatus').val() == 3) {
        $.ajax({
            type: "POST",
            url: "ajax_usuario_nivel_acesso.php",
            data: "usuario=" + document.getElementById('id').value,
            success: function(msg) {
                $('#spNivel').html(msg);

            }
        });
    }else{
        $('#spNivel').html('');
    }


}



function carregaEmpresa() {

    if (document.getElementById('cbStatus').value != "") {
        $('#lbEmpresas').html("carregando a  lista de empresas aguarde...");

        $.ajax({
            type: "POST",
            url: "ajax_lista_empresa_tipo.php",
            data: "status=" + document.getElementById('cbStatus').value + "&empresa=" + document.getElementById('idEmpresa').value,
            success: function(msg) {
                $('#linhaEmpresa').fadeIn('fast');
                $('#spanEmpresa').html(msg);
                $('#lbEmpresas').html("");
            }
        });

    }

}

function carregaLocal() {

    if (document.getElementById('cbEmpresa').value == 1) {
        $('#lbLocal').html("carregando a lista de locias aguarde...");
        $.ajax({
            type: "POST",
            url: "ajax_lista_local.php",
            data: "local=" + document.getElementById('idLocal').value,
            success: function(msg) {
                $('#linhaLocal').fadeIn('fast');
                $('#spanLocal').html(msg);
                $('#lbLocal').html("");

            }
        });

    } else {
        $('#linhaLocal').fadeOut('fast');
    }



}


function carregaLocalAlt() {

    if (document.getElementById('idLocal').value != '') {
        $('#lbLocal').html("carregando a lista de locias aguarde...");
        $.ajax({
            type: "POST",
            url: "ajax_lista_local.php",
            data: "local=" + document.getElementById('idLocal').value,
            success: function(msg) {
                $('#linhaLocal').fadeIn('fast');
                $('#spanLocal').html(msg);
                $('#lbLocal').html("");

            }
        });

    } else {
        $('#linhaLocal').fadeOut('fast');
    }



}
