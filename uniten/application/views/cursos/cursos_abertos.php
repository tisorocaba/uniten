<p class="editoria">Cursos > Inscrições em Andamento  </p>
<div id="page-wrap">

    <h1>Cursos com Inscrições em Andamento</h1>

<?php if ( !$this->mobile_detect->isMobile() ) { ?>
    <p>Confira aqui a lista de  cursos que estão acontecendo na UNITEN e clique nos títulos dos cursos para maiores informações sobre localização, vagas, requisitos e inscrições.</p>
    <?php } ?>

    <br>

    <table>
        <thead>
        <tr>
            <th>Curso</th>
            <th>Local</th>
            <th>Vagas</th>
            <th>Início</th>
            <th>Inscrições</th>

        </tr>
        </thead>
        <tbody>
        <?php if(!empty($cursos)){ ?>
            
            <?php
            foreach ($cursos as $curso) {

            $inicioInscri = strtotime($curso['dataInicioInscricao']);
            $termininoInscri = strtotime($curso['dataFinalInscricao']);
            $dataatual = strtotime(date("Y-m-d"));
            ?>
            <tr>
                <td><?php echo anchor('cadastro/agenda/cod/' . $curso['id'], $curso['curso']['nome']); ?></td>
                <td><?php echo $curso['local']['local'] ?></td>
                <td><?php echo $curso['vagas'] ?></td>
                <td><?php echo dataBR($curso['dataInicio'])?></td>
                <td>
                    <?php if ($inicioInscri > $dataatual) { ?>
                        <?php echo date("d/m/Y", strtotime($curso['dataInicioInscricao'])) ?> à <?php echo date("d/m/Y", strtotime($curso['dataFinalInscricao'])) ?>
                    <?php } elseif ($dataatual > $termininoInscri) { ?>
                        Encerradas
                        <?php if($curso['resultado']==1) {  ?>
                                <?php echo anchor('cursos/resultado/cod/' . $curso['id'], 'Classificação',array('class' => 'cssCursos')); ?>

                        <?php } ?>
                    <?php } else { ?>
                        <?php echo anchor('cadastro/agenda/cod/' . $curso['id'], 'Inscreva-se'); ?>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>

        <?php }else{ ?>

            <tr>
                <td colspan="5">No momento não temos cursos com inscrições abertas</td>

            </tr>

        <?php } ?>
        </tbody>
    </table>

</div>

<br><br>
