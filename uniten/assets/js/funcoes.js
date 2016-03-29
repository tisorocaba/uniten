//-----------------------------------------------------
//Funcao: MascaraMoeda
//Sinopse: Mascara de preenchimento de moeda
//Parametro:
//   objTextBox : Objeto (TextBox)
//   SeparadorMilesimo : Caracter separador de milésimos
//   SeparadorDecimal : Caracter separador de decimais
//   e : Evento
//Retorno: Booleano
//Autor: Gabriel Fróes - www.codigofonte.com.br

//<input type="text" name="valor"  onKeyPress="return(MascaraMoeda(this,'.',',',event))" onkeyup="numbersOnly(this)">
//-----------------------------------------------------


function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13 || whichCode == 8) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
            objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}


/**************************************/
/**** Função para retornar só numeros */
/* <INPUT TYPE="text" NAME="numeric"  onKeyPress="return sonumero(event)"> */

function sonumero(evt) {
    evt = (evt) ? evt : window.event
    
    var charCode = (evt.which) ? evt.which : evt.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //alert('tecla: '+charCode)
        if((charCode >= 36 || charCode <= 41)){
            status = "This field accepts numbers only."
            return false
        }
        
    }
    status = ""
    return true
}


function FormataCNPJ(Campo, teclapres){

    if(window.event){
        var tecla = teclapres.keyCode;
    }else  tecla = teclapres.which;

    var vr = new String(Campo.value);
    vr = vr.replace(".", "");
    vr = vr.replace(".", "");
    vr = vr.replace("/", "");
    vr = vr.replace("-", "");

    tam = vr.length + 1;


    if (tecla != 9 && tecla != 8){
        if (tam > 2 && tam < 6)
            Campo.value = vr.substr(0, 2) + '.' + vr.substr(2, tam);
        if (tam >= 6 && tam < 9)
            Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,tam-5);
        if (tam >= 9 && tam < 13)
            Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,tam-8);
        if (tam >= 13 && tam < 15)
            Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,4)+ '-' + vr.substr(12,tam-12);
    }
}


function Mascara(tipo, campo, teclaPress) {
    if (window.event)
    {
        var tecla = teclaPress.keyCode;
    } else {
        tecla = teclaPress.which;
    }
		
    var s = new String(campo.value);
    // Remove todos os caracteres à seguir: ( ) / - . e espaço, para tratar a string denovo.
    s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');
		
    tam = s.length + 1;
		
    if ( tecla != 9 && tecla != 8 ) {
        switch (tipo)
        {
            case 'CPF' :
                if (tam > 3 && tam < 7)
                    campo.value = s.substr(0,3) + '.' + s.substr(3, tam);
                if (tam >= 7 && tam < 10)
                    campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,tam-6);
                if (tam >= 10 && tam < 12)
                    campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,3) + '-' + s.substr(9,tam-9);
                break;
		
            case 'CNPJ' :
		
                if (tam > 2 && tam < 6)
                    campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
                if (tam >= 6 && tam < 9)
                    campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
                if (tam >= 9 && tam < 13)
                    campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
                if (tam >= 13 && tam < 15)
                    campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
                break;
		
            case 'TEL' :
                if (tam > 2 && tam < 4)
                    campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
                if (tam >= 7 && tam < 11)
                    campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
                break;
		
            case 'DATA' :
                if (tam > 2 && tam < 4)
                    campo.value = s.substr(0,2) + '/' + s.substr(2, tam);
                if (tam > 4 && tam < 11)
                    campo.value = s.substr(0,2) + '/' + s.substr(2,2) + '/' + s.substr(4,tam-4);
                break;
				
            case 'CEP' :
                if (tam > 5 && tam < 7)
                    campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
                break;
        }
    }
}


function autoTab(cont, element, nextElement) {
    if (element.value.length >= cont) {
        nextElement.focus();
    }
}


function VerificaCPF (cpf) {
    if (vercpf(cpf.value)){
        return true;
    }else{
        errors="1";
        if (errors){
            alert('CPF N�O V�LIDO');
            return false;
        }
        document.retorno = (errors == '');
    }
}
function vercpf (cpf) 
{
    if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
        return false;
    add = 0;
    for (i=0; i < 9; i ++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    add = 0;
    for (i = 0; i < 10; i ++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    //alert('O CPF INFORMADO � V�LIDO.');
    return true;
}


/* <input type="text" name="valor" onKeyPress="return(FormataReais(this,'.',',',event))" value="" /> */

function dinheiro(f) {
    addEvento(f, "keypress", function(e) {
        var fld=e.target,milSep='',decSep='.';
        var tecla = (window.Event?e.which:e.keyCode);//Crossbrowser
        var sep = 0,key = '',i = j = 0,len = len2 = 0;
        var strCheck = '0123456789',aux = aux2 = '';
        e.preventDefault();

        if(e.keyCode == 46) {
            fld.value='';
            return false;
        }
        if (tecla == 46) fld.value='';
        key = String.fromCharCode(tecla);
        if (strCheck.indexOf(key) == -1)  return false;
        len = fld.value.length;
        for (i = 0; i < len; i++)
            if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break;
        aux = '';

        for (; i < len; i++)
            if (strCheck.indexOf(fld.value.charAt(i))!=-1)
                aux += fld.value.charAt(i);
        aux += key;
        len = aux.length;

        switch(len) {
            case 0:
                fld.value = '';
                break;
            case 1:
                fld.value = '0'+ decSep + '0' + aux;
                break;
            case 2:
                fld.value = '0'+ decSep + aux;
                break;
            default:
                aux2 = '';
                for (j = 0, i = len - 3; i >= 0; i--){
                    if (j == 3){
                        aux2 += milSep;
                        j = 0;
                    }
                    aux2 += aux.charAt(i);
                    j++;
                }

                fld.value = '';
                len2 = aux2.length;

                for (i = len2 - 1; i >= 0; i--)
                    fld.value += aux2.charAt(i);
                fld.value += decSep + aux.substr(len - 2, len);
                break;
        }
        fld.select();
        return false;
    });
}

function moeda(campo, e)  
{  
   var SeparadorDecimal = ","  
   var SeparadorMilesimo = "."  
   var sep = 0;  
   var key = '';  
   var i = j = 0;  
   var len = len2 = 0;  
   var strCheck = '0123456789';  
   var aux = aux2 = '';  
   var whichCode = (window.Event) ? e.which : e.keyCode;  
      
  
  
    
   if (whichCode == 13) return true;  
   key = String.fromCharCode(whichCode); // Valor para o código da Chave  
    
   if (strCheck.indexOf(key) == -1) return true; // Chave inválida  
   len = campo.value.length;  
   for(i = 0; i < len; i++)  
  
       if ((campo.value.charAt(i) != '0') && (campo.value.charAt(i) != SeparadorDecimal)) break;  
   aux = '';  
   for(; i < len; i++)  
  
       if (strCheck.indexOf(campo.value.charAt(i))!=-1) aux += campo.value.charAt(i);  
   aux += key;  
   len = aux.length;  
  
   if (len == 0) campo.value = '';  
   if (len == 1) campo.value = '0'+ SeparadorDecimal + '0' + aux;  
   if (len == 2) campo.value = '0'+ SeparadorDecimal + aux;  
   if (len > 2) {  
       aux2 = '';  
       for (j = 0, i = len - 3; i >= 0; i--) {  
           if (j == 3) {  
               aux2 += SeparadorMilesimo;  
               j = 0;  
           }  
           aux2 += aux.charAt(i);  
           j++;  
       }  
       campo.value = '';  
       len2 = aux2.length;  
       for (i = len2 - 1; i >= 0; i--)  
       campo.value += aux2.charAt(i);  
       campo.value += SeparadorDecimal + aux.substr(len - 2, len);  
}  
   return false;  
  
}

function mascaraGenerica(evt, campo, padrao) {
    //testa a tecla pressionada pelo usuario
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 8) return true; //tecla backspace permitida
    if (charCode != 46 && (charCode < 48 || charCode > 57)) return false; //apenas numeros
    campo.maxLength = padrao.length; //Define dinamicamente o tamanho maximo do campo de acordo com o padrao fornecido
    //aplica a mascara de acordo com o padrao fornecido
    entrada = campo.value;
    if (padrao.length > entrada.length && padrao.charAt(entrada.length) != '#') {
        campo.value = entrada + padrao.charAt(entrada.length);
    }
    return true;
}