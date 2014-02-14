<div class="row-fluid">
	<div class="span12">
		<h1><?php echo $colecao->marker->nome; ?></h1>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<h3>Descrição</h3>
		<p><?php echo $colecao->marker->descricao; ?></p>
	</div>
	<div class="span6">
		<h3>Foto</h3>
		<div class="well">
			<img src="<?php $this->urlArquivo($colecao->marker->imagem); ?>" />
		</div>
	</div>
</div>
<div class="form-actions">
	<a class="btn btn-success" href="<?php $this->url('site/home'); ?>">Voltar ao Mapa</a>
</div>