<?php

function validarCampos($nome, $cpf, $cnpj, $cidade, $telefone, $email, $senha) {

	$msgErro = "";
	if ( empty($nome) ) {
		$msgErro = $msgErro . "Digite um nome.";
	}
	
	if ( validarCPFCNPJ($cpf, $cnpj) == false  ) {
		$msgErro = $msgErro . "Insira um documento válido.";
	}

	if ( empty($cidade) ) {
		$msgErro = $msgErro . "Cidade inválida.";
	}

    if ( empty($telefone) ) {
		$msgErro = $msgErro . "Telefone inválido.";
	}

    if ( empty($email) ) {
		$msgErro = $msgErro . "Email inválido.";
	}

	if ( strlen($senha) < 6 ) {
		$msgErro = $msgErro . "Sua senha deve conter 6 caracteres ou mais.";
	}


	return $msgErro;
}

function validarCPFCNPJ($cpf, $cnpj) {

    // Remove tudo que não for número
    $cpf = preg_replace('/\D/', '', $cpf);
    $cnpj = preg_replace('/\D/', '', $cnpj);

    // Se ambos forem vazios, erro
    if (empty($cpf) && empty($cnpj)) {
        return false;
    }

    // Se estiver usando CPF, ele deve ter 11 números
    if (!empty($cpf) && strlen($cpf) !== 11) {
        return false;
    }

    // Se estiver usando CNPJ, ele deve ter 14 números
    if (!empty($cnpj) && strlen($cnpj) !== 14) {
        return false;
    }

    return true;
}

function validarCamposFornecedor($cep, $rua, $bairro, $nEnd){
	$msgErro = "";
	if ( empty($cep) ) {
		$msgErro = $msgErro . "Cep inválido!. <br>";
	}

    if ( empty($rua) ) {
		$msgErro = $msgErro . "Digite a rua. <br>";
	}

	if ( empty($bairro) ) {
		$msgErro = $msgErro . "Digite o bairro. <br>";
	}

	if ( empty($nEnd) ) {
		$msgErro = $msgErro . "Digite o número. <br>";
	}

	return $msgErro;
}

?>