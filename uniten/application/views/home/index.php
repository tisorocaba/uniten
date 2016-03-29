<div id="divBoxNoticias">
    <p class="editoria">Notícias e Eventos</p>
    <div id=divList>
        <?php foreach($noticias as $noticia){?>
        <ul>
            <li>
                <a href="<?php echo base_url('noticias/'.$noticia['id'].'/'. $this->slug->create_slug($noticia['titulo'])); ?>" title="Leia Mais">
                    <img src="<?php echo !empty($noticia['foto1'])? base_url('files/'.$noticia['foto1']) : base_url('assets/imgs/fotoNoticiasHome1.jpg'); ?>" width="83" height="61" border="0" class="fotoTumb" align="left">
                    <h4><?php echo dataBR($noticia['data'])?></h4>
                    <p class="tituloNoticiasHome"><?php echo $noticia['titulo']?></p>
                </a>
            </li>

        </ul>
        <?php } ?>
		<hr />
        <?php foreach($eventos as $evento){?>
            <ul>
                <li>
                    <a href="<?php echo base_url('eventos/'.$evento['id'].'/'. $this->slug->create_slug($evento['titulo'])); ?>" title="Leia Mais">
                        <img src="<?php echo !empty($evento['foto'])? base_url('files/'.$evento['foto']) : base_url('assets/imgs/fotoNoticiasHome1.jpg'); ?>" width="83" height="61" border="0" class="fotoTumb" align="left">
                        <h4><?php echo dataBR($evento['data'])?></h4>
                        <p class="tituloNoticiasHome"><?php echo $evento['titulo']?></p>
                    </a>
                </li>

            </ul>
        <?php } ?>

    </div>
    <br />
</div>

<div id="divBoxCursos">

    <a href="javascript:;" class="alpha" title="Inscrições em Andamento"><img src="<?php echo base_url('assets/imgs/iconHomeCursos-InscricoesemAndamento.png'); ?>" /></a>
    <div id="menuCursos">
        <ul>
         <?php if(count($projetos)!=0){ ?>
            <?php foreach($projetos as $projeto){ ?>
            <li><a href="<?php echo base_url('cursos/projeto/'.$projeto['id'].'/'.$this->slug->create_slug($projeto['nome']))?>" class="alpha" title="Saiba mais"><?php echo $projeto['nome']?></a></li>
            <?php } ?>
          <?php }else{ ?>
                <li> Não existem cursos disponíveis nesse momento.</li>
           <?php } ?>

        </ul>
    </div>
    <div align="right">
        <?php  if(count($projetos)>=3){ ?><a href="<?php echo base_url('cursos')?>" class="alpha" title="Veja Mais"><img src="<?php echo base_url('assets/imgs/iconVejaMais.png'); ?>" /></a><?php } ?></div>
    <br />
    <br />


    <a href="javascript:;" class="alpha" title="Resultado das Inscrições"><img src="<?php echo base_url('assets/imgs/iconHomeCursos-ResultadosdasInscricoes.png'); ?>" /></a>
    <div id="menuCursos">
        <ul>
           <?php if(count($resultados)!=0){ ?>
                <?php foreach($resultados as $resultado){ ?>
                <li><a href="<?php echo base_url('resultados/'.$resultado['id'].'/'.$this->slug->create_slug($resultado['curso']['nome']))?>" class="alpha" title="<?php echo $resultado['curso']['nome']?>"><?php echo $resultado['curso']['nome']?></a></li>
                <?php } ?>
            <?php }else{ ?>
                <li> Não existem resultados disponíveis nesse momento.</li>
            <?php } ?>
        </ul>
    </div>
    <div align="right">
        <?php  if(count($resultados)>=3){ ?><a href="<?php echo base_url('resultados')?>" class="alpha" title="Veja Mais"><img src="<?php echo base_url('assets/imgs/iconVejaMais.png'); ?>" /></a><?php } ?></div>
    <br />
    <br />

 <a href="javascript:;" class="alpha" title="Cursos em destaque"><img src="<?php echo base_url('assets/imgs/iconHomeCursos-Destaque.png'); ?>" /></a>
    <div id="menuCursos">
        <?php foreach($cursos as $curso){ ?>
        <ul>
            <li><a href="<?php echo base_url('cursos/'.$curso['id'].'/0/'.$this->slug->create_slug($curso['nome']))?>" class="alpha" title="<?php echo $curso['nome']?>"><?php echo $curso['nome']?></a></li>

        </ul>
        <?php } ?>
    </div>
    <div align="right"><a href="<?php echo base_url('cursos')?>" class="alpha" title="Veja Mais"><img src="<?php echo base_url('assets/imgs/iconVejaMais.png'); ?>" /></a></div>

</div>


<div id="divBoxServicos">
    <div align="center"><img src="<?php echo base_url('assets/imgs/iconHome-ServicosSEDET.png'); ?>"/></div>
    <div id="menuServicos">
        <ul>
            <?php foreach($servicos as $servico){?>
                <li><a href="<?php echo base_url('servicos/'.$servico['id'].'/'. $this->slug->create_slug($servico['titulo']))?>" class="alpha" title="PAT"><?php echo strtoupper($servico['titulo'])?></a></li>
            <?php } ?>


        </ul>
    </div>
</div>