<p class="editoria">Resultados</p>

<div id=divList>
    <?php foreach($resultados as $resultado){?>
      <?php   
       if ($resultado['periodo']=='M') {
          $NomePeriodo = 'Manhã';
          }
       if ($resultado['periodo']=='T') {
          $NomePeriodo = 'Tarde';
          }
       if ($resultado['periodo']=='N') {
          $NomePeriodo = 'Noite';
          }
      ?>
        <ul>
            <li>
                <a href="<?php echo base_url('resultados/'.$resultado['id'].'/'. $this->slug->create_slug($resultado['curso']['nome'])); ?>" title="<?php echo $resultado['curso']['nome']?>">                                      
                    <h3>Local: <?php echo $resultado['local']['local']?></h3>
                    <h2>Curso: <?php echo $resultado['curso']['nome']?></h2>
                    <h4>Início: <?php echo dataBR($resultado['dataInicio']);?> - Período: <?php echo $NomePeriodo; ?></h4>
                </a>
            </li>     
        </ul>
       <hr>
    <?php } ?>
</div>
<div id="page_container">
<?php  if(!empty($resultado)){
    if(($total/LIMIT)>1){
        $config['uri_segment'] = 3;
        $config['total_rows'] = $total;
        $config['per_page'] = LIMIT;
        $config['base_url'] = site_url('resultados/index');
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        printf('%s',$this->pagination->create_links());
    }

}
?>
</div>