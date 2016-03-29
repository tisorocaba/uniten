
<div id='cssmenu'>

<ul>
  
	<li><a href="<?php echo base_url(); ?>home" title="Home Page Uniten"><span>Home</span></a></li>
   
   <li class='has-sub'><a href='#'><span>Institucional</span></a>
      <ul>
      
        <?php foreach(PaginaModel::getInstance()->institucional() as $pagina){ ?>
          <li class='has-sub'><a href='<?php echo base_url(); ?>servicos/<?php echo $pagina['id']?>/<?php echo $this->slug->create_slug($pagina['titulo'])?>' title="Notícias"><span><?php echo $pagina['titulo']?></span></a></li>
        <?php } ?> 
        
      </ul>
   </li>
   
   
   <!-- <li><a href='<?php echo base_url('manual-do-aluno'); ?>'><span>Anuário</span></a></li> -->
   <li><a href='<?php echo base_url('anuario'); ?>'><span>Anuário</span></a></li>
   
   <li class='has-sub'><a href='#'><span>Cursos</span></a>
      <ul>
         <li class='has-sub'><a href='<?php echo base_url(); ?>cursos' title="Cursos Oferecidos"><span>Cursos Oferecidos</span></a></li>
         <li class='has-sub'><a href='<?php echo base_url(); ?>inscricoes-em-andamento' title="Inscrições em Andamento"><span>Inscrições em Andamento</span></a></li>
        
      </ul>
   </li>
  
    <li class='has-sub'><a href='#'><span>Serviços</span></a>
      <ul>
         <?php foreach(PaginaModel::getInstance()->servicos() as $pagina){ ?>
            <li class='has-sub'><a href='<?php echo base_url(); ?>servicos/<?php echo $pagina['id']?>/<?php echo $this->slug->create_slug($pagina['titulo'])?>' title="Notícias"><span><?php echo $pagina['titulo']?></span></a></li>
         <?php } ?>
         
      </ul>
   </li>
   
   <li class='has-sub'><a href='#'><span>Sala de Imprensa</span></a>
      <ul>
         <li class='has-sub'><a href='<?php echo base_url(); ?>noticias' title="Notícias"><span>Notícias</span></a></li>
         <li class='has-sub'><a href='<?php echo base_url(); ?>eventos' title="Eventos"><span>Eventos</span></a></li>
      </ul>
   </li>
   
   
   <li class='has-sub'><a href='#'><span>Contato</span></a>
      <ul>
         <li class='has-sub'><a href='<?php echo base_url(); ?>faleconosco' title="Fale Conosco"><span>Fale Conosco</span></a></li>
         <li class='has-sub'><a href='<?php echo base_url(); ?>localizacao' title="Localização"><span>Localização</span></a></li>
      </ul>
   </li>
   
</ul>

</div>