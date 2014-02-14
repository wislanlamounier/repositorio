<div class="row-fluid">
	<div class="span6">
		<div class="w-box">
			<div class="w-box-header"><h4>Bem Vindo</h4></div>
			<div class="w-box-content cnt_a">
					<p>
						Olá, <strong><?php echo $_SESSION['admin']['nome']; ?></strong> você acabou de acessar o sistema de gerenciamento da 
						<strong><?php echo NOME_SISTEMA; ?></strong>, utilize o menu ao lado para navegar nas diversas funções do sistema.
					</p>
					<p>
						Não Esqueça de utilizar o menu de atalhos para gerenciar os seus links preferidos tanto para o sistema quando de navegação web.				
					</p>
					
					<p>
						Caso necessite de ajuda, no painel a direita você encontra informações e pode enviar um email direto para o desenvolvedor do sistema.
					</p>
					<p>
						Obrigado por utilizar nosso painel. <br /> <strong>Beta Desenvolvimento</strong>
					</p>
			</div>
		</div>
	</div>
	
	<div class="span6">
		<div class="w-box">
			<div class="w-box-header"><div class="pull-right"><i class="icon-question-sign icon-white"></i></div><h4>Ajuda e Suporte</h4></div>
			<div class="w-box-content cnt_a">
			   	<form class="" method="post" id="validate" action="<?php $this->url('admin/suporte'); ?>">
			   		<fieldset>
				   		<div class="control-group" style="margin-left:0 ">
				   			<div class="control-label">Assunto</div>
				   			<div class="controls"><input type="text" id="assunto" name="assunto" class="input-xlarge maskData validate[required]" /></div>
				   		</div>
				   		<div class="control-group" style="margin-left:0 ">
				   			<div class="control-label"></div>
				   			<div class="controls"><textarea name="conteudo" id="conteudo" class="input-xlarge validate[required]" style="height: 73px" /></textarea></div>
				   		</div>
				   		<div class="control-group">
				   			<div class="controls">
				   				<input type="submit" value="Enviar" class="btn" />
				   			</div>
				   		</div>
			   		</fieldset>
			   	</form>
			</div>
		</div>
	</div>
</div>
