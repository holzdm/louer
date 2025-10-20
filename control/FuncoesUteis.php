<?php

function validarCampos($nome, $cpf, $cnpj, $cidade, $telefone, $email, $senha)
{

	$msgErro = "";
	if (empty($nome)) {
		$msgErro = $msgErro . "Digite um nome.";
	}

	if (validarCPFCNPJ($cpf, $cnpj) == false) {
		$msgErro = $msgErro . "Insira um documento válido. ";
	}

	if (empty($cidade)) {
		$msgErro = $msgErro . "Cidade inválida. ";
	}

	if (empty($telefone)) {
		$msgErro = $msgErro . "Telefone inválido. ";
	}

	if (empty($email)) {
		$msgErro = $msgErro . "Email inválido. ";
	}

	if (existeEmail($email)) {
		$msgErro .= "Este email já está cadastrado. ";
	}

	if (strlen($senha) < 6) {
		$msgErro = $msgErro . "Sua senha deve conter 6 caracteres ou mais. ";
	}


	return $msgErro;
}

function validarCPFCNPJ($cpf, $cnpj)
{

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

function validarCamposFornecedor($cep, $rua, $bairro, $nEnd)
{
	$msgErro = "";
	if (empty($cep)) {
		$msgErro = $msgErro . "Cep inválido!. <br>";
	}

	if (empty($rua)) {
		$msgErro = $msgErro . "Digite a rua. <br>";
	}

	if (empty($bairro)) {
		$msgErro = $msgErro . "Digite o bairro. <br>";
	}

	if (empty($nEnd)) {
		$msgErro = $msgErro . "Digite o número. <br>";
	}

	return $msgErro;
}

function validarCamposProduto($nomeProduto, $valorProduto, $diasDisponiveis)
{
	$msgErro = "";

	if (empty($nomeProduto)) {
		$msgErro .= "Preencha o nome do seu produto.<br>";
	}
	if (empty($valorProduto)) {
		$msgErro .= "Preencha o valor do seu produto.<br>";
	}
	if (empty($diasDisponiveis)) {
		$msgErro .= "Escolha pelo menos um dia de disponibilidade.<br>";
	}
	return $msgErro;
}

function validarCamposProdutoEnd($cepProduto, $cidadeProduto, $bairroProduto, $ruaProduto, $numeroProduto)
{
	return null;
}

function validarCamposAlteracao($nome, $cidade, $telefone, $email, $senha, $emailAntigo)
{

	$msgErro = "";
	if (empty($nome)) {
		$msgErro = $msgErro . "Digite um nome.";
	}


	if (empty($cidade)) {
		$msgErro = $msgErro . "Cidade inválida. ";
	}

	if (empty($telefone)) {
		$msgErro = $msgErro . "Telefone inválido. ";
	}

	if (empty($email)) {
		$msgErro = $msgErro . "Email inválido. ";
	}

	if (existeEmail($email)) {
		if ($email != $emailAntigo) {
			$msgErro .= "Este email já está cadastrado. ";
		}
	}

	if (strlen($senha) < 6) {
		$msgErro = $msgErro . "Sua senha deve conter 6 caracteres ou mais. ";
	}


	return $msgErro;
}

function validarFavorito($idUsuario, $idProduto)
{
	// mexer com isso depois
}

function vealidarImagem($dadosImagem)
{
	$msgErro = "";
	// verificacao da imagem

	if ($dadosImagem['size'] > 1048576) {
		$msgErro .= 'Imagem muito grande.';
	}

	// Tipos permitidos
	$tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
	if (!in_array($dadosImagem['type'], $tiposPermitidos)) {
		$msgErro .= 'Formato de imagem não permitido. Use JPG, PNG ou GIF.';
	}
	return $msgErro;
}
