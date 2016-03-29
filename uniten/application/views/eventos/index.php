<p class="editoria">Eventos</p>

<div id=divList>
    <?php foreach($eventos as $evento){?>
        <ul>
            <li>
                <a href="<?php echo base_url('eventos/'.$evento['id'].'/'. $this->slug->create_slug($evento['titulo'])); ?>" title="Leia Mais">
                    <img src="<?php echo !empty($evento['foto'])? base_url('files/'.$evento['foto']) : base_url('assets/imgs/fotoNoticiasHome1.jpg'); ?>" width="83" height="61" border="0" class="fotoTumb" align="left">
                    <h4><?php echo dataBR($evento['data'])?></h4>
                    <h2><?php echo $evento['titulo']?></h2>
                    <h5><?php echo cut($evento['descricao'],250) ?></h5>
                </a>
            </li>

        </ul>
       <span class="pubBorder"></span>
    <?php } ?>
</div>
<div id="page_container">
<?php  if(!empty($eventos)){
    if(($total/LIMIT)>1){
        $config['uri_segment'] = 3;
        $config['total_rows'] = $total;
        $config['per_page'] = LIMIT;
        $config['base_url'] = site_url('eventos/index');
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        printf('%s',$this->pagination->create_links());
    }

}
?>
</div>