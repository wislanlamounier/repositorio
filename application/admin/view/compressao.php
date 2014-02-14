<div class="row-fluid">
	<div class="span12">
		<div class="w-box">
			<div class="w-box-header"><h4>Sistema de Compressão</h4></div>
			<div class="w-box-content cnt_a">
					<p>Para efetuar a compressão dinamica do sistema, insira a senha de usuário master no campo abaixo e clique em Efetuar.</p>
					<p><strong>Lembre-se Esse procedimento não pode ser revertido.</strong></p>
					<form name="compre" action="<?php $this->url('admin/comprimir');?>" method="post">
						<p><input name="codigo_validacao" placeholder="Senha Master" type="password"/></p>
						<p><input type="submit" value="Efetuar" class="btn btn-danger"/></p>
					</form>
			</div>
		</div>
	</div>
</div>
