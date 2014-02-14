<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<title>cityGo - Faça parte da sua cidade</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boostrap -->
	<link href="<?php $this->layoutPatch(); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php $this->layoutPatch(); ?>/css/bootstrap-responsive.min.css"	rel="stylesheet">
	<link href="<?php $this->layoutPatch(); ?>/css/estilo.css"	rel="stylesheet">
	
	<!-- Scripts -->
	<script src="<?php $this->layoutPatch(); ?>/js/jquery.min.js"></script>
	<script src="<?php $this->layoutPatch(); ?>/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
	<script src="<?php $this->layoutPatch(); ?>/js/jquery.gomap-1.3.2.min.js"></script>
	<script src="<?php $this->layoutPatch(); ?>/js/markerclusterer.js"></script>
	
	<script src="<?php $this->layoutPatch(); ?>/js/mask.js"></script>
	<script src="<?php $this->layoutPatch(); ?>/js/funcoes.js"></script>
	<script src="<?php $this->layoutPatch(); ?>/js/script.js"></script>
	
</head>

<body>
<!-- BASEURL DO SISTEMA -->
<div class="baseurl" style="display:none"><?php echo BASEURL; ?></div>
		<header>
			<div class="row-fluid">
				<!-- Navbar
				================================================== -->
				<div class="navbar navbar-inverse">
					<div class="navbar-inner">
						<div class="container">
							<a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar"> 
								<span class="icon-bar"></span> 
								<span class="icon-bar"></span> 
								<span class="icon-bar"></span>
							</a> 
							<a href="#" class="brand"><img src="<?php $this->layoutPatch(); ?>/img/logo.png" alt="cityGo"></a>
							<div class="nav-collapse collapse navbar-responsive-collapse">
								<ul class="nav pull-right" >
									<li><a href="<?php $this->url('site/home'); ?>">Home</a></li>
									<li><a href="<?php $this->url('site/paginas/como-funciona'); ?>">Como Funciona</a></li>
									<li><a href="<?php $this->url('site/paginas/enviar-foto'); ?>">Enviar Foto</a></li>
								</ul>
							</div><!-- /.nav-collapse -->
						</div> <!-- /.container -->
					</div> <!-- /.navbar-inner -->
				</div>
			</div>
		</header>
		<article>
			<div class="container">
				<?php
					Resultado::getResultado();
					Resultado::limpaResultado();
						
					include_once($pagina);
				?>
			</div>
		</article>
		<footer>
		</footer>
</body>
</html>
