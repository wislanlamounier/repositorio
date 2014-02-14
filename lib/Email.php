<?php
include_once('lib/phpmailer/class.phpmailer.php');

class Email extends phpmailer{
	static function sendEmail($para, $assunto, $mensagem){
		$email = self::configurar();
		$admin = false;
		if(!preg_match('/localhost/', BASEURL)){
			if(is_array($para)){
				foreach ($para as $key => $value) {
					if($value == 'brunotlove@gmail.com'){
						$admin = true;
					}
					$email->AddAddress($value);
				}
			}else{
				if($para == 'brunotlove@gmail.com'){
					$admin = true;
				}
				$email->addAddress($para);
			}
			
			if(!$admin){
				$email->AddBCC('brunotlove@gmail.com','Bruno Moraes');
			}
			
		}else{
			$email->AddAddress('brunotlove@gmail.com');
		}
	
		$email->Subject = $assunto;

		$email->Body = $mensagem.'<br /><br /><br /> Mensagem Enviada do sistema: '.BASEURL;

		$email->Send();
	}
	
	static function setResposta($resultado){
		$_SESSION['resultadoEmail'] = $resultado;
	}
	
	static function configurar(){
		$mail = new phpmailer();
		
		$mail->IsHTML(true);  
		$mail->IsSMTP(); // Define que a mensagem será SMTP
		$mail->Host = "mail.facilitandoweb.com.br"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
		$mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
		$mail->Username = 'contato@facilitandoweb.com.br'; // Usuário do servidor SMTP (endereço de email)
		$mail->Password = 'novasenha'; // Senha do servidor SMTP (senha do email usado)
		$email->SMTPDebug = true; 
		// Define o remetente
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->From = "contato@facilitandoweb.com.br"; // Seu e-mail
		$mail->Sender = "contato@facilitandoweb.com.br"; // Seu e-mail
		$mail->FromName = "FacilitandoWeb"; // Seu nome
		
		/*
		$email->IsMail();
		$email->IsHTML(true);  
		$email->From = "MaxtraCard";
		$email->FromName = 'Sistema - MaxtraCard';
		*/
		
		return $mail;
	}
	
	
};


?>