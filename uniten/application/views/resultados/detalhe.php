
<p class="editoria">Cursos >  <?php echo $agenda['curso']['nome']?>  </p>
<div id="page-wrap">

    <h1>Resultado</h1>

   <br>

    <table>
        <thead>
        <tr>
            <th colspan="2">Classificados</th>
         </tr>
        <tr>
            <th>Nome</th>
            <th>Classificação</th>


        </tr>
        </thead>
        <tbody>
        <?php foreach ($aprovados as $aprovado) { ?>
                <tr>
                    <td><?php echo stripslashes($aprovado->nome)?></td>
                    <td><?php echo $aprovado->classificacao?>º</td>

                </tr>
        <?php } ?>

        </tbody>
    </table>

  
   
   <?php if(count($suplentes)>0){ ?>
    <p>
       <hr>
   </p>

    <table>
        <thead>
        <tr>
            <th colspan="2">Suplentes</th>
        </tr>
        <tr>
            <th>Nome</th>
            <th>Classificação</th>


        </tr>
        </thead>
        <tbody>
       <?php $i=1;
        foreach ($suplentes as $suplente) { ?>
        <tr>
                <td><?php echo $suplente->nome?></td>
                <td><?php echo $i?>º</td>
            </tr>
        <?php $i++;} ?>

        </tbody>
    </table>
 <?php } ?>
</div>

<br><br>

<div id="div-botton">
    <div align="center">
                    <input name="voltar" type="button" value="Voltar"
                     onclick="self.location='<?php echo !empty($_SESSION['RESULTADOS'])?  base_url('resultados'): base_url('home')  ?>'" />            
       
    </div>
</div>

<?php unset($_SESSION['RESULTADOS']) ?>