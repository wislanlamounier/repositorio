<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <link rel="icon" type="image/ico" href="favicon.ico">
    <title><?php echo NOME_SISTEMA.' | Administrator'; ?></title>
    <link rel="stylesheet" href="<?php $this->layoutPatch(); ?>/css/login.css">
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet'>
    <!-- jQuery framework -->
        <script src="<?php $this->layoutPatch(); ?>/js/jquery.min.js"></script>
    <!-- validation -->
        <script src="<?php $this->layoutPatch(); ?>/js/lib/jquery-validation/jquery.validate.js"></script>
    <script type="text/javascript">
        (function(a){a.fn.vAlign=function(){return this.each(function(){var b=a(this).height(),c=a(this).outerHeight(),b=(b+(c-b))/2;a(this).css("margin-top","-"+b+"px");a(this).css("top","50%");a(this).css("position","absolute")})}})(jQuery);(function(a){a.fn.hAlign=function(){return this.each(function(){var b=a(this).width(),c=a(this).outerWidth(),b=(b+(c-b))/2;a(this).css("margin-left","-"+b+"px");a(this).css("left","50%");a(this).css("position","absolute")})}})(jQuery);
        $(document).ready(function() {
            if($('#login-wrapper').length) {
                $("#login-wrapper").vAlign().hAlign()
            };
            if($('#login-validate').length) {
                $('#login-validate').validate({
                    onkeyup: false,
                    errorClass: 'error',
                    rules: {
                        login_name: { required: true },
                        login_password: { required: true }
                    }
                })
            }
            if($('#forgot-validate').length) {
                $('#forgot-validate').validate({
                    onkeyup: false,
                    errorClass: 'error',
                    rules: {
                        forgot_email: { required: true, email: true }
                    }
                })
            }
            $('#pass_login').click(function() {
                $('.panel:visible').slideUp('200',function() {
                    $('.panel').not($(this)).slideDown('200');
                });
                $(this).children('span').toggle();
            });
        });
    </script>
</head>
<body>
    <div id="login-wrapper" class="clearfix">
    	<?php 
            Resultado::getResultado();
            Resultado::limpaResultado();
        ?>
        
        <div class="main-col">
            <img src="<?php $this->layoutPatch(); ?>/img/beoro.png" alt="" class="logo_img" />
            <div class="panel">
                <p class="heading_main">Acesso ao Sistema</p>
                <form id="login-validate" action="<?php $this->url('acesso/acessar'); ?>" method="post">
                    <label for="login_name">Login</label>
                    <input type="text" id="login_name" name="login" value="" />
                    <label for="login_password">Senha</label>
                    <input type="password" id="login_password" name="senha" value="" />
                    <div class="submit_sect">
                        <button type="submit" class="btn btn-beoro-3">Acessar</button>
                    </div>
                </form>
            </div>
            <div class="panel" style="display:none">
                <p class="heading_main">Esqueceu a Senha?</p>
                <form id="forgot-validate" action="<?php $this->url('acesso/lembrar-senha'); ?>" method="post">
                    <label for="forgot_email">Digite seu email:</label>
                    <input type="text" id="forgot_email" name="email" />
                    <div class="submit_sect">
                        <button type="submit" class="btn btn-beoro-3">Solicitar nova senha</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="login_links">
            <a href="javascript:void(0)" id="pass_login"><span>Esqueceu a senha?</span><span style="display:none">Tela de Login</span></a>
        </div>
    </div>
</body>
</html>