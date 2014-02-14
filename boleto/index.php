<?php



session_start();

//print_r($_SESSION);die;

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 7;
$taxa_boleto = 2.80;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $_SESSION['dados_boleto']['valor_normal']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $_SESSION['dados_boleto']['nosso_numero'];  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = DMA($_SESSION['dados_boleto']['data_emissao']); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $_SESSION['dados_cliente']['nome'];
$dadosboleto["endereco1"] = $_SESSION['dados_cliente']['logradouro'];
$dadosboleto["endereco2"] = $_SESSION['dados_cliente']['cidade_nome']. ' - '.$_SESSION['dados_cliente']['uf']. ' - '.$_SESSION['dados_cliente']['cep'];

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Cartão Maxtracard ".$_SESSION['dados_boleto']['tipo_cartao'];
$dadosboleto["demonstrativo2"] = "Referente a adesão do Cartão Maxtracard <br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "MaxtraCard - http://www.maxtracard.com.br";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, não receber após o vencimento;";
$dadosboleto["instrucoes2"] = "- Em caso de dúvidas entre em contato conosco: financeiro@maxtracard.com.br";
$dadosboleto["instrucoes3"] = "&nbsp; Emitido pelo sistema MaxtradCard - www.maxtracard.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = "484"; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = "7"; // Digito do Num da agencia
$dadosboleto["conta"] = "129560"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "8"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = "129560"; // ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"] = "8"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "25";  // Código da Carteira: pode ser 06 ou 03

// SEUS DADOS
$dadosboleto["identificacao"] = "MaxtraCard Administradora de Cartões LTDA";
$dadosboleto["cpf_cnpj"] = "37.155.892/0002-90";
$dadosboleto["endereco"] = "Setor Bancário Sul, QD 2 Bl. E Ed Prime Sobreloja SL 206 CEP: 70.070-120";
$dadosboleto["cidade_uf"] = "Brasília - DF";
$dadosboleto["cedente"] = " MaxtraCard Administradora de Cartões LTDA";

// NÃO ALTERAR!
include("include/funcoes_bradesco.php"); 
include("include/layout_bradesco.php");

function DMA($data){
	$dia = substr($data, 8, 2);
	$mes = substr($data, 5, 2);
	$ano = substr($data, 0, 4);

	$newDate = $dia.'/'.$mes.'/'.$ano;
	return $newDate;
}
?>
