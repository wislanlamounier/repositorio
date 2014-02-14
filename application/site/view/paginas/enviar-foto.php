<script type="text/javascript">
	$(function() { 
	 navigator.geolocation.getCurrentPosition(showpos);

     function showpos(position){
         lat=position.coords.latitude
         lon=position.coords.longitude

         $('input[name="latitude"]').val(lat);
         $('input[name="longitude"]').val(lon);
     }
     
	});
</script>

<div class="row-fluid">
	<div class="span12">
		<h1>Envie sua Foto</h1>
	</div>
</div>
<div class="row-fluid">
	<div class="span10">
		<form action="<?php $this->url('site/salvar-foto'); ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="latitude" />
			<input type="hidden" name="longitude" />
			<div class="control-group">
				<label class="control-label" for="nome">Titulo</label>
				<div class="controls">
					<input type="text" id="nome" name="nome" placeholder="Titulo">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="email">Email</label>
				<div class="controls">
					<input type="email" id="email" name="email" placeholder="Email">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="imagem">Imagem</label>
				<div class="controls">
					<input type="file" required id="imagem" name="imagem">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="descricao">Descrição</label>
				<div class="controls">
					<textarea name="descricao"></textarea>
				</div>
			</div>
			<div class="form-actions">
			    <button type="submit" class="btn btn-primary">Enviar</button>
			    <button type="button" class="btn">Cancelar</button>
		    </div>
		</form>

	</div>
	<div class="span2">
		<div class="well">Teste</div>
	</div>
</div>
