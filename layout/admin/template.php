<!DOCTYPE HTML>
<html lang="en-US">
    <head>

        <meta charset="UTF-8">
        <title><?php echo NOME_SISTEMA.' | Administração ';?></title>
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <link rel="icon" type="image/ico" href="favicon.ico">
        
    <!-- jQuery framework -->
            <script src="<?php $this->layoutPatch(); ?>/js/jquery.min.js"></script>
            
    <!-- common stylesheets-->
        <!-- bootstrap framework css -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/bootstrap/css/bootstrap-responsive.min.css">
        <!-- iconSweet2 icon pack (16x16) -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/img/icsw2_16/icsw2_16.css">
        <!-- splashy icon pack -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/img/splashy/splashy.css">
        <!-- flag icons -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/img/flags/flags.css">
        <!-- power tooltips -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/powertip/jquery.powertip.css">
        <!-- google web fonts 
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Abel">
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">
        -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/css/fonts.css">

    <!-- aditional stylesheets -->
		<!-- sticky notifications -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/sticky/sticky.css">
        <!-- jQuery UI theme -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/jquery-ui/css/Aristo/Aristo.css">
		<!-- 2 col multiselect -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/multi-select/css/multi-select.css">
        <!-- enchanced select box, tag handler -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/select2/select2.css">
        <!-- datepicker -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/bootstrap-datepicker/css/datepicker.css">
        <!-- timepicker -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/bootstrap-timepicker/css/timepicker.css">
        <!-- colorpicker -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/bootstrap-colorpicker/css/colorpicker.css">
        <!-- switch buttons -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/ibutton/css/jquery.ibutton.css">
        <!-- UI Spinners -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/jqamp-ui-spinner/css/jqamp-ui-spinner.css">
        <!-- multiupload -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/plupload/js/jquery.plupload.queue/css/plupload-beoro.css">
        <!-- datatables -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/datatables/css/datatables_beoro.css">
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/js/lib/datatables/extras/TableTools/media/css/TableTools.css">    
            
	    <!-- main stylesheet -->
            <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/css/beoro.css">
                    
        <!--[if lte IE 8]><link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/css/ie8.css"><![endif]-->
        <!--[if IE 9]><link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/css/ie9.css"><![endif]-->
            
        <!--[if lt IE 9]>
            <script src="<?php $this->layoutPatch(); ?>/js/ie/html5shiv.min.js"></script>
            <script src="<?php $this->layoutPatch(); ?>/js/ie/respond.min.js"></script>
            <script src="<?php $this->layoutPatch(); ?>/js/lib/flot-charts/excanvas.min.js"></script>
        <![endif]-->

    </head>
    <body class="bg_d">
    <div id="baseurl" style="display:none"><?php echo BASEURL; ?></div>
    <!-- main wrapper (without footer) -->    
        <div class="main-wrapper">
        <!-- top bar -->
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <div id="fade-menu" class="pull-left">
                        	<?php Menu::montarMenu(); ?>
                        </div>

                        <select id="selectnav1" class="selectnav">
                            <?php Menu::montarMenuResponsivo(); ?>
                        </select>
                    </div>
                </div>
            </div>

        <!-- header -->
            <header>
                <div class="container">
                    <div class="row">
                        <div class="span3">
                            <div class="main-logo"><a href="<?php $this->url('admin/home'); ?>"><img src="<?php $this->layoutPatch(); ?>/img/beoro_logo.png" alt="Beoro Admin"></a></div>
                        </div>
                        <div class="span5">
                            <nav class="nav-icons">
                             <ul>
                                    <li><a href="<?php $this->url('admin/home'); ?>" class="ptip_s" title="Home"><i class="icsw16-home"></i></a></li>
                                    <li><a href="<?php $this->url('mensagens/listar'); ?>" class="ptip_s" title="Mensagens"><i class="icsw16-mail"></i> <?php if($_SESSION['mensagens']){ echo '<span class="badge badge-info">'.$_SESSION['mensagens'].'</span>'; }?></a></li>
                                    <li class=""><span class="ptip_s" title="Statistics (active)"><i class="icsw16-graph"></i></span></li>
                                    <li><a href="<?php $this->url('admin/compressao'); ?>" class="ptip_s" title="Compressão"><i class="icon-refresh"></i></a></li>
                                    <li><a href="<?php $this->url('admin/sistema'); ?>" class="ptip_s" title="Configurações"><i class="icsw16-cog"></i></a></li>
                                </ul>
                             </nav>
                        </div>
                        <div class="span4">
                            <div class="user-box">
                                <div class="user-box-inner">
                                    <div class="user-info">
                                        Bem Vindo, <strong><?php echo $_SESSION['admin']['nome']; ?></strong>
                                        <ul class="unstyled">
                                            <li><a href="<?php $this->url('usuarios/dados'); ?>">Configurações</a></li>
                                            <li>&middot;</li>
                                            <li><a href="<?php $this->url('acesso/sair'); ?>">Sair</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

        <!-- breadcrumbs -->
            <div class="container">
                <ul id="breadcrumbs">
                    <?php $this->breadcrumbs(); ?>
                </ul>
            </div>
            
        <!-- main content -->
            <div class="container">
                <?php
					Resultado::getResultado();
					Resultado::limpaResultado();
					
					include_once($pagina);
				?>
            </div>
            <div class="footer_space"></div>
        </div> 

    <!-- footer --> 
        <footer>
            <!-- <div class="container">
                <div class="row">
                    <div class="span5">
                        <div>&copy; Your Company 2012</div>
                    </div>
                    <div class="span7">
                        <ul class="unstyled">
                            <li><a href="#">Rodapé</a></li>
                            <li>&middot;</li>
                            <li><a href="#">Second link</a></li>
                        </ul>
                    </div>
                </div>
            </div> -->
        </footer>
        
    <!-- Common JS -->
        <!-- bootstrap Framework plugins -->
            <script src="<?php $this->layoutPatch(); ?>/bootstrap/js/bootstrap.min.js"></script>
        <!-- top menu -->
            <script src="<?php $this->layoutPatch(); ?>/js/jquery.fademenu.js"></script>
        <!-- top mobile menu -->
            <script src="<?php $this->layoutPatch(); ?>/js/selectnav.min.js"></script>
        <!-- actual width/height of hidden DOM elements -->
            <script src="<?php $this->layoutPatch(); ?>/js/jquery.actual.min.js"></script>
        <!-- jquery easing animations -->
            <script src="<?php $this->layoutPatch(); ?>/js/jquery.easing.1.3.min.js"></script>
        <!-- power tooltips -->
            <script src="<?php $this->layoutPatch(); ?>/js/lib/powertip/jquery.powertip-1.1.0.min.js"></script>
        <!-- date library -->
            <script src="<?php $this->layoutPatch(); ?>/js/moment.min.js"></script>
        <!-- common functions -->
            <script src="<?php $this->layoutPatch(); ?>/js/beoro_common.js"></script>
		
	    <!-- sticky notifications -->
	        <script src="<?php $this->layoutPatch(); ?>/js/lib/sticky/sticky.min.js"></script>
	    <!-- bootbox -->
	        <script src="<?php $this->layoutPatch(); ?>/js/lib/bootbox/bootbox.min.js"></script> 
	        
	    <!-- jQuery UI -->
            <script src="<?php $this->layoutPatch(); ?>/js/lib/jquery-ui/jquery-ui-1.9.2.custom.min.js"></script>
        <!-- touch event support for jQuery UI -->
            <script src="<?php $this->layoutPatch(); ?>/js/lib/jquery-ui/jquery.ui.touch-punch.min.js"></script>
        <!-- masked inputs -->
            <script src="<?php $this->layoutPatch(); ?>/js/lib/jquery-inputmask/jquery.inputmask.min.js"></script>
            <script src="<?php $this->layoutPatch(); ?>/js/lib/jquery-inputmask/jquery.inputmask.extensions.js"></script>
            <script src="<?php $this->layoutPatch(); ?>/js/lib/jquery-inputmask/jquery.inputmask.date.extensions.js"></script>
        <!-- datepicker -->
            <script src="<?php $this->layoutPatch(); ?>/js/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <!-- metadata -->
            <script src="<?php $this->layoutPatch(); ?>/js/lib/ibutton/js/jquery.metadata.min.js"></script>
        <!-- switch buttons -->
            <script src="<?php $this->layoutPatch(); ?>/js/lib/ibutton/js/jquery.ibutton.beoro.min.js"></script>
        <!-- WYSIWG Editor -->
            <script src="<?php $this->layoutPatch(); ?>/js/lib/ckeditor/ckeditor.js"></script>    
		<!-- datatables -->
           <script src="<?php $this->layoutPatch(); ?>/js/lib/datatables/js/jquery.dataTables.min.js"></script>
        <!-- datatables bootstrap integration -->
           <script src="<?php $this->layoutPatch(); ?>/js/lib/datatables/js/jquery.dataTables.bootstrap.min.js"></script>	        
	    <!-- Validação formulario -->
           <script src="<?php $this->layoutPatch(); ?>/js/lib/jquery-validation/form_validation.js"></script>	  
        <!-- mascara de Real -->
           <script src="<?php $this->layoutPatch(); ?>/js/money.js"></script>        
	        
	    <!-- funcoes -->
	        <script src="<?php $this->layoutPatch(); ?>/js/funcoes.js"></script>  
    </body>
</html>