
<style type="text/css">
#gallery {
	position:relative;
	width:200px;
	height:182px; 
}
	#gallery a {
		float:left;
		position:absolute; 
	}
	
	#gallery a img {  
		border:none;
	}
	
	#gallery a.show {
		z-index:500;
	}

/* =Media Queries
-------------------------------------------------------------- */
@media all and (max-width: 900px) {
  	#gallery { width:100%;  }
}

</style>

<?php if ( !$this->mobile_detect->isMobile() ) { ?>
<div id="gallery">
	<a href="#" class="show"><img src="<?php echo base_url('assets/imgs/slideCabecalho1.png')?>" /></a>
	<a href="#"><img src="<?php echo base_url('assets/imgs/slideCabecalho2.png')?>"/></a>
</div>
<?php } ?>