<?php
require_once '../util/config.php';
Security::cursoSecurity();
$agenda = new AgendaCurso();
if (!empty($_REQUEST['agenda'])) {
    $_SESSION['CODAGENDA'] = $agenda->escape($_REQUEST['agenda']);
}
$agenda->get($_SESSION['CODAGENDA']);
$user = unserialize($_SESSION['USER']);

$diarios = new DiarioClasse();
if ((int) $user->tipoLogin == 2) {
    //$diarios->alias('d')->where('d.agenda=?  and data_aula <= CURRENT_DATE', $_SESSION['CODAGENDA'], $user->professor)->order('data DESC')->find();
    $diarios->alias('d')->where('d.agenda=?', $_SESSION['CODAGENDA'], $user->professor)->order('data ASC')->find();
} else {
    //$diarios->alias('d')->where('d.agenda=? and data_aula <= CURRENT_DATE',$_SESSION['CODAGENDA'])->order('data DESC')->find();
    $diarios->alias('d')->where('d.agenda=?', $_SESSION['CODAGENDA'])->order('data ASC')->find();
}
logDao::gravaLog($user->login, 'diarios', 'Acessou: diarios de classe', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA']);
?>

<!-- Widgets as boxes -->
<h4 class="page-header">
    Cursos :: Diários de Classe <small>
        Curso: <?php echo $agenda->curso->nome ?>
    </small>
</h4>

<?php
$totalMin = 0;
$contLinha = 0;
while ($diarios->fetch()) {
    //$totalMin += retornaMinutos($diarios->horas);
    $presencas = $diarios->presencasFaltas();
    list($ano, $mes, $dia) = explode('-', $diarios->data);
    if ($contLinha === 0) {
        echo '<div class="row">';
    }
    ?>
    <div class="col-md-4">
        <!-- Warning box -->
        <div class="<?php echo ($presencas > 0) ? 'box box-solid box-success' : 'box box-solid box-warning' ?>">
            <div class="box-header">
                <h3 class="box-title"><?php echo $dia . ' de ' . mostraMes($mes) ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-warning btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php if ($presencas > 0) { ?>
                    <table class="table table-bordered text-center">
                        <tr>

                            <th>Presença <code><?php echo $diarios->presencasFaltas(); ?></code></th>
                            <th>Faltas <code><?php echo $diarios->presencasFaltas(0); ?></code></th>
                            <th>Horas <code><?php echo $diarios->horas ?></code></th>

                        </tr>
                        <tr>
                            <td colspan="3">Professor: <code><?php echo $diarios->pegaProfessor() ?></code></td>
                        </tr>
                        <tr>
                            <td colspan="3">Professor: <code><?php echo $diarios->pegaDisciplina() ?></code></td>
                        </tr>
                        <tr>
                            <td colspan="3"><button class="btn btn-default" onclick="self.location = 'principal.php?acao=diarioVisualizar&id=<?php echo $diarios->id ?>'">Visualizar</button>

                                <?php if ((int) $user->tipoLogin == 2) { ?>
                                    <button class="btn btn-default" onclick="self.location = 'redirecionador.php?id=<?php echo $diarios->id ?>'">Alterar</button></td> <?php } ?>
                        </tr>
                    </table>
                <?php } else { ?>
                    <table class="table table-bordered text-center">

                        <tr>
                            <td colspan="3">
                                <?php if ((int) $user->tipoLogin == 2) { ?>
                                    <button class="btn btn-default" onclick="self.location = 'redirecionador.php?id=<?php echo $diarios->id ?>'">Incluir</button>
                                <?php }else{ ?>
                                <button class="btn btn-default" onclick="self.location = 'redirecionador.php?id=<?php echo $diarios->id ?>'" disabled="disabled">Somente professores</button>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                <?php } ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    
   

    <?php
    if ($contLinha === 2) {
        echo '</div> <!-- /.row -->';
        $contLinha = 0;
    } else {
        $contLinha++;
    }
  
   } 
   ?>
   
    <input type="button" name="enviar2" id="enviar" value="Voltar" onclick="self.location='<?php echo empty($_GET['back'])?  'principal.php': 'principal.php?acao=financeiroPesquisaResultado' ;?>'" class="btn btn-primary btn-sm" />
                    