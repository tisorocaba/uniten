
<p class="editoria">Notícias</p>

<h4><?php echo dataBR($noticia['data']) ?></h4>
<h1><?php echo $noticia['titulo'] ?></h1>
<h5>
    <?php if(!empty($noticia['foto1']) && file_exists('assets/files/'.$noticia['foto1'])){?>
       <img src="<?php echo  base_url('assets/files/noticias/'.$noticia['foto1']); ?>"  border="0"  align="left">
    <?php } ?>
    <?php echo strip_word_html(str_replace('\\','',nl2br($noticia['descricao'])),'<p><br>'); ?></h5>

<BR>
<span class="pubBorder"></span>
<h2><a href="<?php echo base_url('noticias')?>">Outras notícias</a> </h2>
