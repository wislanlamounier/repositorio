<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Painel Administrativo | Beta Desenvolvimento</title>

		<?php
		$arrayLayoutCss = array('bootstrap/css/bootstrap.min', 'bootstrap/css/bootstrap-responsive.min', 'lib/jBreadcrumbs/css/BreadCrumb', 'lib/qtip2/jquery.qtip.min', 'lib/colorbox/colorbox', 'lib/google-code-prettify/prettify', 'lib/sticky/sticky', 'img/splashy/splashy', 'img/flags/flags', 'lib/fullcalendar/fullcalendar_gebo', );

		foreach ($arrayLayoutCss as $item) {
			$this -> layout($item, 'css');
		};

		$this -> css(array('style', 'blue', 'estilo'));
		?>

		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico" />

		<script>
			//* hide all elements & show preloader
			document.documentElement.className += 'js';
		</script>
	</head>
	<body class="login_page">
		
		<div class="login_box">
			
			<form action="<?php $this->url('acesso/acessar'); ?>" method="post" id="login_acessar">
				<div class="top_b">Acesso ao Sistema</div>    
				<?php 
					Resultado::getResultado();
					Resultado::limpaResultado(); 
				?>
				<div class="cnt_b">
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span><input type="text" id="username" name="login" placeholder="Usuário" />
						</div>
					</div>
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span><input type="password" id="password" name="senha" placeholder="Senha" />
						</div>
					</div>
					<div class="links_b links_btm clearfix">
						<span class="linkform"><a href="#" class="lembrar-senha">Esqueceu a senha?</a></span>
					</div>  
				</div>
				<div class="btm_b clearfix">
					<button class="btn btn-success pull-right" type="submit">Acessar</button>
				</div>  
			</form>
			
			<form action="<?php $this->url('acesso/lembrar-senha'); ?>" method="post" id="lembrar_senha" style="display:none">
				<div class="top_b">Lembrete de Senha</div>    
					<div class="alert alert-info alert-login hidden">
						Informe o seu email e estaremos enviando a senha para seu email.	
					</div>
				<div class="cnt_b">
					<div class="formRow clearfix">
						<div class="input-prepend">
							<span class="add-on">@</span><input type="text" name="email" placeholder="Email" />
						</div>
					</div>
				</div>
				<div class="btm_b tac">
					<a href="" class="btn cancelar-lembrete"> Cancelar </a>
					<input type="submit" class="btn btn-success" value="Solicitar Senha"/>
				</div>  
			</form>
			
		</div>
			<?php

			$arrayJs = array('jquery.min', 'jquery.debouncedresize.min', 'jquery.actual.min', 'jquery.cookie.min', 'ios-orientationchange-fix', 'gebo_common', 'forms/jquery.ui.touch-punch.min', 'jquery.imagesloaded.min', 'jquery.wookmark', 'jquery.mediaTable.min', 'jquery.peity.min', );

			foreach ($arrayJs as $js) {
				$this -> js($js);
			}

			$arrayLayoutJs = array('bootstrap/js/bootstrap.min', 'lib/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min', 'lib/colorbox/jquery.colorbox.min', 'lib/antiscroll/antiscroll', 'lib/antiscroll/jquery-mousewheel', 'lib/fullcalendar/fullcalendar.min', 'lib/list_js/list.min', 'lib/list_js/plugins/paging/list.paging.min');

			foreach ($arrayLayoutJs as $item) {
				$this -> layout($item, 'js');
			};
			?>

			<script>
				$(document).ready(function() {
					setTimeout('$("html").removeClass("js")', 1000);
				
					$('.lembrar-senha').click(function(event){
						event.preventDefault();
						
						$('form#lembrar_senha').show();
						$('form#login_acessar').hide();
					})
					
					$('.cancelar-lembrete').click(function(event){
						event.preventDefault();
						
						$('form#lembrar_senha').hide();
						$('form#login_acessar').show();
					})
				
				});
				
				
			</script>

		</div>
		
	</body>
</html>