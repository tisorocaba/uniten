<?php 
require_once '../util/config.php';
require '../dao/feriadoDao.php';

Security::cursoSecurity();
$user = unserialize($_SESSION['USER']);

if(empty($_GET['id']) && (int)$_GET['id']===0){
    gotox("principal.php?acao=diarios");
}

// verificando se o diario esta dentro do periodo de preenchimento

$obDataHoje   = new DateTime(date('Y-m-d'));
$obDataDiario = new DateTime(DiarioClasse::staticGet((int)$_GET['id'])->data);

// verificando se o usuário não esta tentando preencher uma agenda futura

if($obDataDiario->getTimestamp() > $obDataHoje->getTimestamp()){
    gotox("principal.php?acao=diarioMensagemProfessor&op=1");
}


$daoFeriado   = new FeriadoDao();
$total = 0;
while ($obDataDiario->getTimestamp() <= $obDataHoje->getTimestamp()){
    if( $daoFeriado->isFeriado($obDataDiario->format('Y-m-d')) < 0 || isDiaUtil($obDataDiario->format('Y-m-d'))===true){
        $total++;
    }
    $obDataDiario->modify('+1day');
}

if((int)$total > 2){
         gotox("principal.php?acao=diarioMensagemProfessor&op=2");
}
 
if((int)$user->tipoLogin == 2){
         gotox("principal.php?acao=diarioCadastroProfessor&id=".$_GET['id']);
}else{
         gotox("principal.php?acao=diarioCadastro&id=".$_GET['id']);
}