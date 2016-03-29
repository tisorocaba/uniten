<p class="editoria"><?php echo $servico['secao']==1? 'Institucional':'Servicos' ?> &raquo; <?php echo  $servico['titulo']?></p>
<h1></h1>
<h5>
    <span style="text-align:justify">
	  <?php echo strip_word_html(str_replace('\\','',$servico['texto']),'<p><br><ul><li><a><b><i>'); ?>
    </span>
</h5>

