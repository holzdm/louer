<?php

function validarCampos($nome, $cpf, $cnpj, $cidade, $telefone, $email, $senha) {

	$msgErro = "";
	if ( empty($nome) ) {
		$msgErro = $msgErro . "Digite um nome. <br>";
	}
	
	if ( validarCPFCNPJ($cpf, $cnpj) == false  ) {
		$msgErro = $msgErro . "Insira um CPF ou CNPJ!. <br>";
	}

	if ( empty($cidade) ) {
		$msgErro = $msgErro . "Cidade inválida!. <br>";
	}

    if ( empty($telefone) ) {
		$msgErro = $msgErro . "Telefone inválido!. <br>";
	}

    if ( empty($email) ) {
		$msgErro = $msgErro . "Email inválido!. <br>";
	}

	if ( strlen($senha) < 6 ) {
		$msgErro = $msgErro . "Senha inválida! Ela deve ter mais que 6 caracteres. <br>";
	}


	return $msgErro;
}

function validarCPFCNPJ($cpf, $cnpj) {

    if (empty($cpf) and empty($cnpj)){
        return false;
    }
    else{
        return true;
    }

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