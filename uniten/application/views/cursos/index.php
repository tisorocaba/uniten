<p class="editoria">Cursos > Cursos Oferecidos  </p>
<div id="page-wrap">

    <h1></h1>

    <p></p>

    <table>
        <thead>
       
        </thead>
        <tbody>
        <?php if(!empty($cursos)){ ?>
            <?php
            foreach ($cursos as $curso) {

            ?>
            <tr>
                <td>
				<a href="<?php echo base_url('cursos/' . $curso['id'].'/'. (int)$this->uri->segment(3).'/'.$this->slug->create_slug($curso['nome']))?>"><?php echo $curso['nome']?></a>
			</td>
               
            </tr>
            <?php } ?>
        <?php }else{ ?>

            <tr>
                <td colspan="5">No momento não temos cursos cadastrados</td>

            </tr>

        <?php } ?>
        </tbody>
    </table>

</div>
<div id="page_container">
<?php  if(!empty($cursos)){
    if(($total/LIMIT)>1){
        $config['uri_segment'] = 3;
        $config['total_rows'] = $total;
        $config['per_page'] = LIMIT;
        $config['base_url'] = site_url('cursos/index');
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        printf('%s',$this->pagination->create_links());
    }

}
?>
</div>

<br><br>
