<?php if ( !$this->mobile_detect->isMobile() ) { ?>
<div id="divSlideHome">
 <link rel='stylesheet' id='camera-css'  href='<?php echo base_url('assets/plugins/camera/css/camera.css')?>' type='text/css' media='all'>
    <style>
		body {
			margin: 0;
			padding: 0;
		}
		a {
			color: #09f;
		}
		a:hover {
			text-decoration: none;
		}
		#back_to_camera {
			clear: both;
			display: block;
			height: 80px;
			line-height: 40px;
			padding: 20px;
		}
		.fluid_container {
			margin: 0 auto;
			max-width: 100%;
			width: 100%; /* tamanho da foto do slide: 1280px x 388px */
			height:388px;
		}
	</style>
    
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/camera/scripts/jquery.min.js')?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/camera/scripts/jquery.mobile.customized.min.js')?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/camera/scripts/jquery.easing.1.3.js')?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/camera/scripts/camera.min.js')?>'></script>
    
    <script>
		jQuery(function(){
			
			jQuery('#camera_wrap_1').camera({ 
				thumbnails: true,
				height: '388px'
			});

		});
	</script>

    
	<div class="fluid_container">
    
        <div class="camera_wrap camera_azure_skin" id="camera_wrap_1">
            <div data-thumb="<?php echo base_url('assets/imgs/banner2_thumb.jpg');?>" data-src="<?php echo base_url('assets/imgs/banner2.jpg');?>">

            </div>
            <div data-thumb="<?php echo base_url('assets/imgs/banner3_thumb.jpg');?>" data-src="<?php echo base_url('assets/imgs/banner3.jpg');?>">

            </div>
        </div><!-- #camera_wrap_1 -->

    
    </div><!-- .fluid_container -->
    
    <div style="clear:both; display:block; height:100px"></div>
    
</div>
<?php } ?>