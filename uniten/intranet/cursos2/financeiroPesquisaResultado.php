<?php
require_once '../util/config.php';
Security::cursoSecurity();
$user = unserialize($_SESSION['USER']);

$rs = Empresa::staticGet(0)->_getConnection()->executeSQL($_SESSION['SQL'] )
?>
<script src="scripts/relatoriosClasses.js"></script>
<div class="row">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Financeiro :: Pesquisa</h3>

        </div>
        <div class="box-body">
            <table width="100%" border="0">
                <tr>
                    <td>
                        Empresa: <code> <?php echo Empresa::staticGet((int) $_SESSION['EMPRESACOD'])->fantasia; ?></code>

                    </td>
                    <td> 
                        Período: <code><?php echo $_SESSION['DATAINI'] ?> a <?php echo $_SESSION['DATAFINAL'] ?></code>
                    </td>
                </tr>

            </table>


        </div><!-- /.box-body -->

    </div><!-- /.box -->

</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box"><!-- /.box-header -->
            <div class="box-body table-responsive">


                <table id="example2" class="table table-bordered table-hover">

                    <thead>
                        <th width="308"><strong>Curso</strong></td>
                        <th width="320"><strong>Local</strong></td>
                        <th width="78"><strong>Início</strong></td>
                        <th width="50"><strong>Período</strong></td>
                        <th width="78"><strong>Valor  Curso</strong></td>
                        <th width="45"><strong>Carga </strong></td>
                        <th width="74" align="right"><strong>Valor hora</strong></td>
                        <th width="71" align="right"><strong>Aulas min.</strong></td>
                        <th width="95" align="right"><strong>Horas a pagar</strong></td>

                     </thead>
                <tbody>

                        <?php
                        $cont = 0;
                        $totalGeralCuros = 0;
                        $totalGeralCarga = 0;
                        $totalGeralHorasMinistradas = 0;
                        $totalGeralHorasPagar = 0;
                        $totalGeralVale = 0;
                        $totalGastoVale = 0;

                        while ($row = mysql_fetch_array($rs)) {

                            $totalGeralCuros += $row['valor'];
                            $totalGeralCarga += $row['carga'];
                            $totalGeralHorasMinistradas += $row['horas_completas'];
                            $totalGeralHorasPagar += converterHoraValor($row['horas_completas'], $row['valor_hora']);
                            $totalGastoVale += $row['gasto_vale'];
                            ?>
                            <tr>
                                <td><?php echo $row['curso'] ?></td>
                                <td><?php echo $row['local'] ?></td>
                                <td><?php echo data_br($row['inicio']) ?></td>
                                <td><?php echo periodoCurso($row['periodo']) ?></td>
                                <td>R$ <?php echo number_format($row['valor'], 2, ',', '.') ?></td>
                                <td><?php echo $row['carga'] ?></td>
                                <td align="right">R$ <?php echo number_format($row['valor_hora'], 2, ',', '.') ?></td>
                                <td align="right">
                                    <a href="principal.php?acao=diarios&agenda=<?php echo $row['id'] ?>&back=1" > <?php echo !empty($row['horas_completas'])? extraiSegundo($row['horas_completas']):0;  ?> </a>hs
                                </td>
                                <td align="right">R$ <?php echo number_format(converterHoraValor($row['horas_completas'], $row['valor_hora']), 2, ',', '.') ?></td>
                            </tr>
<?php } ?>  


                    </tbody>
                    <tfoot>
                                            <tr>
                                                <th colspan="9" align="center">
                                                <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="print();" class="btn btn-primary btn-sm" />
                                                  <input type="button" name="enviar" id="enviar2" value="Exportar" onclick="self.location='xls_financeiro.php'" class="btn btn-success btn-sm" />
                                                  <input type="button" name="enviar2" id="enviar" value="Voltar" onclick="self.location='principal.php?acao=financeiro'" class="btn btn-primary btn-sm" />                                                </th>
                                            </tr>
                                        </tfoot> 
                    

                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->


    </div>
</div>


