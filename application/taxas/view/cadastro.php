<div class="w-box">
	<div class="w-box-header"><h4><?php echo $this->titulo_pagina; ?></h4></div>
	<div class="w-box-content cnt_a"><?php echo $colecao->form; ?></div>
</div>

<script type="text/javascript">
    $(function(){
        $('#id_conta_contabil').change(function(){
            $.ajax({
                url: Url('contacontabil/getsubcontas'),
                type: 'POST',
                data: {'id_conta':$(this).val()},
                success: function(res){
                    $('#id_conta_contabil_sub').html(res).removeAttr('disabled');
                }
            })
        })
    })
</script>