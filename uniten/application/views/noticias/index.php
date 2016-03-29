<p class="editoria">Notícias</p>

<div id=divList>
    <?php foreach($noticias as $noticia){
        $texto = $noticia['descricao'];
        ?>
        <ul>
            <li>
                <a href="<?php echo base_url('noticias/'.$noticia['id'].'/'. $this->slug->create_slug($noticia['titulo'])); ?>" title="Leia Mais">
                    <img src="<?php echo !empty($noticia['foto1'])? base_url('files/'.$noticia['foto1']) : base_url('assets/imgs/fotoNoticiasHome1.jpg'); ?>" width="83" height="61" border="0" class="fotoTumb" align="left">
                    <h4><?php echo dataBR($noticia['data'])?></h4>
                    <h2><?php echo $noticia['titulo']?></h2>
                    <h5><?php echo cut($texto,250) ?></h5>
                </a>
            </li>

        </ul>
       <span class="pubBorder"></span>
    <?php } ?>
</div>
<div id="page_container">
<?php  if(!empty($noticias)){
    if(($total/LIMIT)>1){
        $config['uri_segment'] = 3;
        $config['total_rows'] = $total;
        $config['per_page'] = LIMIT;
        $config['base_url'] = site_url('noticias/index');
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        printf('%s',$this->pagination->create_links());
    }

}
?>
</div>