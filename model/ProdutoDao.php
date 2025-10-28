<?php
require_once "ConexaoBD.php";

function inserirProduto($tipoProduto, $nomeProduto, $tagsIds, $idUsuario, $valorProduto, $descricaoProduto, $diasDisponiveis, $cep, $cidade, $bairro, $rua, $numero, $complemento)
{
    $conexao = conectarBD();

    $diasString = implode(',', $diasDisponiveis);

    if ($tipoProduto == 'Equipamento') {
        $sql = "INSERT INTO Produto (tipo, nome, id_usuario, valor_dia, descricao, dias_disponiveis) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssidss",
            $tipoProduto,
            $nomeProduto,
            $idUsuario,
            $valorProduto,
            $descricaoProduto,
            $diasString
        );
    } else {
        $sql = "INSERT INTO Produto (tipo, nome, id_usuario, valor_dia, descricao, dias_disponiveis, cep, cidade, bairro, rua, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssidssssssis",
            $tipoProduto,
            $nomeProduto,
            $idUsuario,
            $valorProduto,
            $descricaoProduto,
            $diasString,
            $cep,
            $cidade,
            $bairro,
            $rua,
            $numero,
            $complemento
        );
    }


    if ($stmt == false) {
        echo mysqli_error($conexao);
    }


    mysqli_stmt_execute($stmt) or die('Erro no INSERT do Produto: ' . mysqli_stmt_error($stmt));

    // Pega o código inserido
    $idProduto = mysqli_insert_id($conexao);


    // Insere as tags relacionadas
    if (!inserirTagsHasProduto($tagsIds, $idProduto)) {
        die('Erro ao inserir na tabela relacional: ' . mysqli_error($conexao));
    }

    if (!inserirDisponibilidades($diasDisponiveis, $idProduto)) {
        die('Erro ao inserir na tabela relacional: ' . mysqli_error($conexao));
    }


    return $idProduto;
}

function inserirImgs($destPath, $type, $idProduto)
{
    $conexao = conectarBD();

    $conteudo = file_get_contents($destPath);


    $sql = "INSERT INTO imagem (dados, tipo, produto_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        die("Erro no prepare: " . mysqli_error($conexao));
    }

    // o primeiro campo será "b" (BLOB)
    mysqli_stmt_bind_param($stmt, "bsi", $null, $type, $idProduto);

    // envia os dados binários
    mysqli_stmt_send_long_data($stmt, 0, $conteudo);

    // executa
    if (!mysqli_stmt_execute($stmt)) {
        die("Erro ao inserir imagem: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}



// Função para inserir as tags relacionadas ao produto
function inserirTagsHasProduto($tagsIds, $idProduto)
{
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

function inserirDisponibilidades($diasSelecionados, $idProduto)
{
    $conexao = conectarBD();

    // Mapear os dias da semana para número
    $mapaDias = [
        'Dom' => 0,
        'Seg' => 1,
        'Ter' => 2,
        'Qua' => 3,
        'Qui' => 4,
        'Sex' => 5,
        'Sab' => 6
    ];

    // Gerar próximas datas
    $dataAtual = new DateTime();
    $dataLimite = (new DateTime())->modify('+60 days');

    while ($dataAtual <= $dataLimite) {
        $diaSemana = (int)$dataAtual->format('w'); // 0 a 6

        // Se o dia da semana estiver na lista do produto
        foreach ($diasSelecionados as $dia) {
            if ($diaSemana === $mapaDias[$dia]) {
                $sql = "INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES (?, ?)";
                $stmt = mysqli_prepare($conexao, $sql);
                $dataStr = $dataAtual->format('Y-m-d');
                mysqli_stmt_bind_param($stmt, "is", $idProduto, $dataStr);
                if (!mysqli_stmt_execute($stmt)) {
                    return false;
                }
            }
        }

        // Avança 1 dia
        $dataAtual->modify('+1 day');
    }
    return true;
}

function consultarProduto($id)
{

    $conexao = conectarBD();

    $sql = "SELECT * FROM Produto WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();


    if ($row = $res->fetch_assoc()) {

        require_once "FornecedorDao.php";

        $idFornecedor = $row['id_usuario'];
        $nomeFornecedor = pesquisarFornecedor($idFornecedor);

        // pegar datas disponiveis
        $datasDisponiveis = buscarDatasDisponiveis($id);
        // pegar tags
        $tags = buscarTags($id);
        // pegar imagens
        $imgs = buscarImgs($id);

        return [
            "idProduto" => $id,
            "nome" => $row['nome'],
            "descricao" => $row['descricao'],
            "tipo" => $row['tipo'],
            "valor" => $row['valor_dia'],
            "nomeFornecedor" => $nomeFornecedor,
            "datas" => $datasDisponiveis,
            "imgsArray" => $imgs,
            "tagsArray" => $tags
        ];
    }
    return null;
}



function buscarDatasDisponiveis($idProduto)
{
    $conexao = conectarBD();

    $sql = "SELECT data_disponivel 
            FROM disponibilidades 
            WHERE id_produto = ? 
            ORDER BY data_disponivel ASC";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idProduto);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    $datas = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        // Converte de YYYY-mm-dd para dd/mm/YYYY
        $dataFormatada = date("d/m/Y", strtotime($row['data_disponivel']));
        $datas[] = $dataFormatada;
    }

    return $datas;
}

function buscarTags($idProduto)
{
    $conexao = conectarBD();

    $sql = "SELECT t.nome 
            FROM tags t
            INNER JOIN tags_has_produto thp ON t.id = thp.tags_id
            WHERE thp.produto_id = ?";

    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        die("Erro no prepare: " . mysqli_error($conexao));
    }

    mysqli_stmt_bind_param($stmt, "i", $idProduto);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $tags = [];
    while ($registro = mysqli_fetch_assoc($resultado)) {
        $tags[] = $registro['nome'];
    }

    return $tags; // retorna um array com os nomes das tags
}


function listarProdutos()
{
    $conexao = conectarBD();

    $conteudoPesquisa = $_SESSION['conteudoPesquisa'] ?? '';

    $sql = "SELECT * FROM produto 
    WHERE ativo = 1
    AND (nome LIKE ? OR descricao LIKE ?)";
    // como pesquisar pelas tags?? pensar nisso depois

    $pesquisa = "%" . $conteudoPesquisa . "%";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $pesquisa, $pesquisa);
    mysqli_stmt_execute($stmt);


    return mysqli_stmt_get_result($stmt);
}

function listarMeusProdutos()
{
    $conexao = conectarBD();

    $idUsuario = $_SESSION['id'] ?? '';

    $sql = "SELECT * FROM produto 
    WHERE id_usuario = $idUsuario";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function listarUmaImg($idProduto)
{
    $conexao = conectarBD();

    $sql = "SELECT dados, tipo FROM imagem WHERE produto_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idProduto);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return [
            'dados' => base64_encode($row['dados']), // <- converte o binário em base64
            'tipo' => $row['tipo']
        ];
    }

    return null;
}

function excluirDatasAntigas($idProduto)
{
    $conexao = conectarBD();
    $sqlDelete = "DELETE FROM disponibilidades WHERE id_produto = ?";
    $stmtDelete = mysqli_prepare($conexao, $sqlDelete);
    mysqli_stmt_bind_param($stmtDelete, "i", $idProduto);
    mysqli_stmt_execute($stmtDelete);
}
function updateDatasProduto($idProduto, $data)
{
    $conexao = conectarBD();

    // Insere as novas
    $sqlInsert = "INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES (?, ?)";
    $stmtInsert = mysqli_prepare($conexao, $sqlInsert);

    if (!$stmtInsert) {
        die("Erro na preparação da query de inserção: " . mysqli_error($conexao));
    }

    mysqli_stmt_bind_param($stmtInsert, "is", $idProduto, $data);

    if (mysqli_stmt_execute($stmtInsert)) {
        echo "Data inserida com sucesso: $data<br>";
    } else {
        echo "Erro ao inserir a data $data: " . mysqli_stmt_error($stmtInsert) . "<br>";
    }
}

function updateDadosProduto($nome, $valorHora, $descricaoProduto, $idProduto)
{
    $conexao = conectarBD();

    $sql = "UPDATE produto 
            SET nome = ?, valor_dia = ?, descricao = ?
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sdsi", $nome, $valorHora, $descricaoProduto, $idProduto);
    // s = string, d = double (float), i = integer

    return $stmt->execute();
}

function deleteProduto($idProduto)
{
    $conexao = conectarBD();

    $sql = "DELETE FROM produto WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . mysqli_error($conexao));
    }

    mysqli_stmt_bind_param($stmt, "i", $idProduto);

    if (!mysqli_stmt_execute($stmt)) {
        die("Erro ao excluir produto: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
}

function buscarImgs($idProduto)
{
    $conexao = conectarBD();
    $sql = "SELECT dados, tipo FROM imagem WHERE produto_id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idProduto);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $imagens = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $imagens[] = [
            'dados' => base64_encode($row['dados']), // converte o BLOB para base64
            'tipo' => $row['tipo']
        ];
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);

    return $imagens; // retorna um array com todas as imagens
}


function inserirFavoritosDAO($id_usuario, $id_produto)
{
    $conexao = conectarBD(); // Função para conectar ao banco de dados
    if (!$conexao) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO favoritos (id_usuario, id_produto) VALUES (?, ?)";

    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a inserção: " . $conexao->error);
    }

    $stmt->bind_param("ii", $id_usuario, $id_produto);
    return $stmt->execute();
}
function listarFavoritosDAO($idUsuario)
{
    $conexao = conectarBD(); // Função para conectar ao banco de dados
    if (!$conexao) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    $sql = "SELECT p.id, p.nome, p.valor_dia 
            FROM favoritos f
            INNER JOIN produto p ON f.id_produto = p.id
            WHERE f.id_usuario = ?";

    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conexao->error);
    }

    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    return $stmt->get_result();
}

function excluirFavoritosDAO($id_usuario, $id_produto)
{
    $conexao = conectarBD(); // Função para conectar ao banco de dados
    if (!$conexao) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM favoritos WHERE id_usuario = ? AND id_produto = ?";

    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a exclusão: " . $conexao->error);
    }

    $stmt->bind_param("ii", $id_usuario, $id_produto);

    return $stmt->execute();
    
}
