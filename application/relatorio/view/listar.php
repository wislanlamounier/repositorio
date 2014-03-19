<?php
    $meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
?>
<div class="w-box">
    <div class="w-box-header"><h4>Relatório</h4></div>
    <div class="w-box-content cnt_a">
        <form enctype="multipart/form-data" method="post" action="<?=$this->url('relatorio/dados')?>" name="form" id="validate">

                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Selecione o tipo de relatório: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <select name="tipoRelatorio" id="tipoRelatorio">
                                <option value="geral">Geral</option>

<!--                                <option value="periodo">Periodo</option>-->
                                <option value="conciliacao">Conciliação Bancária</option>
                                <option value="contas_pagar">Contas a Pagar</option>
                                <option value="contas_receber">Contas a Receber</option>
                               <option value="centroCusto">Centro de Custo</option>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            <fieldset class="geral">
                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Mês: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <select name="mes" class="validate[required]">
                                <?php foreach($meses as $key => $mes){ ?>
                                    <option value="<?=$key?>"><?=$mes?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Ano: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="text" name="ano" maxlength="4" class="validate[required]"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="contas_pagar" style="display: none">
                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Data Inicial: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="text" name="contas_pagar[dataInicial]" class="validate[required] maskData"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Data Final: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="text" name="contas_pagar[dataFinal]" class="validate[required] maskData"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Fornecedor: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <select name="contas_pagar[fornecedor]" class="validate[required]">
                                <option value="">Todos</option>
                                <?php foreach($colecao->fornecedor as $item){ ?>
                                    <option value="<?=$item->id?>"><?=$item->nome?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Baixados: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="radio" name="contas_pagar[baixados]" class="" checked value="1"/> Sim <br />
                            <input type="radio" name="contas_pagar[baixados]" class="" value="2"/> Não <br />
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="contas_receber" style="display: none">
                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Data Inicial: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="text" name="contas_receber[dataInicial]" class="validate[required] maskData"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Data Final: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="text" name="contas_receber[dataFinal]" class="validate[required] maskData"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Cliente: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <select name="contas_receber[cliente]" class="validate[required]">
                                <option value="">Todos</option>
                                <?php foreach($colecao->fornecedor as $item){ ?>
                                    <option value="<?=$item->id?>"><?=$item->nome?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Tipo de Comissão: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <select name="contas_receber[tipo_comissao]" class="validate[required]">
                                <option value="">Todos</option>
                                <?php foreach($colecao->tipoComissao as $item){ ?>
                                    <option value="<?=$item->id?>"><?=$item->nome?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="periodo" style="display: none">
                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Data Inicial: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="text" name="periodo[dataInicial]" class="validate[required] maskData"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Data Final: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="text" name="periodo[dataFinal]" class="validate[required] maskData"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="conciliacao" style="display: none">
                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Conta Corrente: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <select name="contaCorrente">
                                <?php foreach($colecao->contasCorrente as $item){ ?>
                                    <option value="<?=$item->id?>"><?=$item->nome?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Data Inicial: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="text" name="conciliacao[dataInicial]" class="validate[required] maskData"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label"><label>Data Final: <span class="f_req">*</span></label></div>
                        <div class="controls">
                            <input type="text" name="conciliacao[dataFinal]" class="validate[required] maskData"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </fieldset>

             <fieldset class="centroCusto" style="display: none">
                <div class="formSep">
                    <div class="control-group">
                        <div class="control-label">
                            <label>Centro de Custo: <span class="f_req">*</span></label>
                        </div>
                        <div class="controls">
                            <select name="centroCusto">
                            <?php foreach($colecao->centrosCusto as $item){ ?>
                            <option value="<?=$item->id?>"><?=$item->nome?></option>
                            <?php }; ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="formSep">
                        <div class="control-group">
                            <div class="control-label"><label>Data Inicial: <span class="f_req">*</span></label></div>
                            <div class="controls">
                                <input type="text" name="dataCusto[dataInicial]" class="validate[required] maskData"/>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="formSep">
                        <div class="control-group">
                            <div class="control-label"><label>Data Final: <span class="f_req">*</span></label></div>
                            <div class="controls">
                                <input type="text" name="dataCusto[dataFinal]" class="validate[required] maskData"/>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
            </fieldset>


            <div class="form-actions">
                <input type="submit" class="btn btn-success" value="Salvar">
                <a onclick="javascript:window.history.go(-1);" class="btn botao-voltar-form">Voltar</a>
            </div>
        </form>

    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#tipoRelatorio').change(function(){
            var exibir = $(this).val();

            $('form fieldset').hide();

            $('.'+exibir).show();
        })
    })
</script>