<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" />
<style>
img {
	padding: 5px;
}
</style>
<p class="editoria">Eventos</p>

<h4><?php echo dataBR($evento['data']) ?></h4>
<h1><?php echo $evento['titulo'] ?></h1>
<h5 >
    <div align="justify">
	<?php if(!empty($evento['foto'])){?>
    <img src="<?php echo  base_url('files/'.$evento['foto']); ?>"  border="0"  align="left" width="350" >
    <?php } ?>
    <?php echo nl2br(str_replace('\\','',strip_word_html($evento['descricao'],'<p><br>'))); ?></span>
    </div>
</h5>

<BR>
<span class="pubBorder"></span>
<div>
<?php if(!empty($evento['fotos']) && count($evento['fotos'])>1){?>
<hr />
<ul class="gallery clearfix">
    <h2>Imagens</h2>
    <?php foreach($evento['fotos'] as $foto){ ?>
    <div id="divImgList">
        <li>
            <div id="mousefollow-examples">
                <div title="<?php echo $evento['titulo']?>">
                    <a href="<?php echo base_url('files/'.$foto['foto'])?>" class="fancybox" data-fancybox-group="gallery"/>
                    <img src="<?php echo base_url('files/'.$foto['foto'])?>" width="180" border="0" />
                    </a>
                </div>
            </div>
        </li>
    </div>
    <?php } ?>
</ul>
<?php } ?>
</div>

<div class="clear"></div>
<h2><a href="<?php echo base_url('eventos')?>">Outros eventos</a> </h2>


<script type="text/javascript">
		$(document).ready(function(){
			$("a.fancybox").fancybox({
				'speedIn'		:	600, 
				'speedOut'	:	    200, 
				'overlayShow'	:	false
			});
		});
</script>

