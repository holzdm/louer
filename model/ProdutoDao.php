<?php
require_once "ConexaoBD.php";

function inserirProduto($tipoProduto, $nomeProduto, $tagsIds, $idUsuario, $valorProduto, $descricaoProduto) {
    $conexao = conectarBD();    

    $sql = "INSERT INTO Produto (tipo, nome, id_usuario, valor_hora, descricao) VALUES (?, ?, ?, ?, ?)"; 
    
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssids", $tipoProduto, $nomeProduto, $idUsuario, $valorProduto, $descricaoProduto);
    
    mysqli_stmt_execute($stmt) or die('Erro no INSERT do Produto: '.mysqli_stmt_error($stmt));
    
    // Pega o código inserido
    $idProduto = mysqli_insert_id($conexao); 

    // Insere as tags relacionadas
    if (!inserirTagsHasProduto($tagsIds, $idProduto)) {
        die('Erro ao inserir na tabela relacional: '.mysqli_error($conexao));
    } // fazer essa forma ou com "or die"?

    return $idProduto;
}

// Função para inserir as tags relacionadas ao produto
function inserirTagsHasProduto($tagsIds, $idProduto) {
    $conexao = conectarBD();

    $sql = "INSERT INTO tags_has_produto (tags_id, produto_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);

    foreach ($tagsIds as $idTag) {
        mysqli_stmt_bind_param($stmt, "ii", $idTag, $idProduto);
        if (!mysqli_stmt_execute($stmt)) {
            return false;
        }
    }

    return true;
}

// function listarProdutos(){

//     $conexao = conectarBD();

//     $sql = "SELECT * FROM produto";
//     $stmt = $conexao->prepare($sql);
//     $stmt->execute();
//     $res = $stmt->get_result();

//     $arrayProdutos = [];
//     $arrayCadaProduto = [];

//     if ($res) {
//         while ($row = mysqli_fetch_array($res)) {
//             $idProduto = $row['id'];
//             $nomeProduto = $row['nome'];
//             $descricao = $res["descricao"];
//             $valor_hora = $res["valor_hora"];
//             $arrayProdutos[$idProduto] = $nomeProduto;

//         }
//     }
//     return $arrayProdutos;
    
// }

function consultarProduto($id){

    $conexao = conectarBD();

    $sql = "SELECT * FROM Produto WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();


    if ($row = $res->fetch_assoc()) {

        require_once "FornecedorDao.php";

        $idFornecedor = $row['usuario_id'];
        $nomeFornecedor = pesquisarFornecedor($idFornecedor);

        return [
            "nome" => $row['nome'],
            "descricao" => $row['descricao'],
            "tipo" => $row['tipo'],
            "valor" => $row['valor_hora'],
            "nomeFornecedor" => $nomeFornecedor

        ];
    }
    echo "erro no if row";
    // return null;
}

function listarProdutos(){
    $conexao = conectarBD(); 
    $sql = "SELECT * FROM produto WHERE ativo = 1";
    return mysqli_query($conexao, $sql);
}



?>