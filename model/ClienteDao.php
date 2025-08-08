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


// USAR O STMT?
?>