<?php
require_once "ConexaoBD.php";

function inserirCliente($nome, $cpf, $cnpj, $cidade, $telefone, $email, $senha) {    

    $conexao = conectarBD();


    // Montar SQL
    $sql = "INSERT INTO Usuario (nome, tipo, cpf, cnpj, cidade, telefone, email, senha) 
            VALUES ('$nome' , 'Cliente', '$cpf', '$cnpj', '$cidade', 
                    '$telefone', '$email','$senha')"; 
    
    mysqli_query($conexao, $sql);

    // Pega o código inserido
    $id = mysqli_insert_id($conexao);  
    return $id;
    
}

function pesquisarCliente($senha, $email){

    $conexao = conectarBD();

    $sql = "SELECT * FROM usuario WHERE email = ? AND senha = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows == 1){
        $dados = $res->fetch_assoc();
        return $dados;
    }
    else{
        return false;
    }
    
}

// ver se o email já existe
function existeEmail($email) {
    require_once "ConexaoBD.php";
    $conn = conectarBD();

    $sql = "SELECT COUNT(*) FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    return $total > 0;
}

function alterarDadosCliente($nome, $cidade, $telefone, $email, $senha, $id) {
    $conexao = conectarBD();

    // Montar SQL
    $sql = "UPDATE usuario 
            SET nome = ?, cidade = ?, telefone = ?, email = ?, senha = ?
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssi", $nome, $cidade, $telefone, $email, $senha, $id);
    $resultado = $stmt->execute();
    $stmt->close();
    $conexao->close();

    return $resultado;
}
// USAR O STMT?

function consultarCliente($idUsuario){
    $conexao = conectarBD();

    $sql = "SELECT * FROM Usuario WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $res = $stmt->get_result();


    if ($row = $res->fetch_assoc()) {

        return [
            "idUsuario" => $idUsuario,
            "nomeUsuario" => $row['nome'],
            "tipoUsuario" => $row['tipo'],
            "cpf" => $row['cpf'],
            "cnpj" => $row['cnpj'],
            "cidade" => $row['cidade'],
            "telefone" => $row['telefone'],
            "email" => $row['email'],
            "senha" => $row['senha'],
            "cep" => $row['cep'],
            "bairro" => $row['bairro'],
            "rua" => $row['rua'],
            "numero" => $row['numero'],
            "complemento" => $row['complemento'],
            "conta_ativa" => $row['conta_ativa'],

            
        ];
    }
    return null;
}

function excluirDadosCliente(){
    $conexao = conectarBD();

    // Montar SQL
    $sql = "DELETE FROM usuario WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $_SESSION['id']);
    $resultado = $stmt->execute();
    $stmt->close();
    $conexao->close();

    return $resultado;
}
?>

