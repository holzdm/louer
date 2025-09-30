<?php
require_once "ConexaoBD.php";

function inserirProduto($tipoProduto, $nomeProduto, $imagensValidadas, $tagsIds, $idUsuario, $valorProduto, $descricaoProduto, $diasDisponiveis, $cep, $cidade, $bairro, $rua, $numero, $complemento)
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
        $sql = "INSERT INTO Produto (tipo, nome, id_usuario, valor_dia, descricao, dias_disponiveis, cep, cidade, bairro, rua, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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

    inserirImgs($idProduto, $imagensValidadas);

    // Insere as tags relacionadas
    if (!inserirTagsHasProduto($tagsIds, $idProduto)) {
        die('Erro ao inserir na tabela relacional: ' . mysqli_error($conexao));
    } // fazer essa forma ou com "or die"?

    if (!inserirDisponibilidades($diasDisponiveis, $idProduto)) {
        die('Erro ao inserir na tabela relacional: ' . mysqli_error($conexao));
    }


    return $idProduto;
}

function inserirImgs($idProduto, $imagensValidadas)
{

    $conexao = conectarBD();


    foreach ($imagensValidadas as $imagem) {
        // gera um nome único para evitar sobrescrever
        $nomeArquivo = uniqid() . '_' . basename($imagem['name']);
        $caminhoDestino = "../a-uploads/$nomeArquivo";

        // move arquivo para a pasta uploads
        if (move_uploaded_file($imagem['tmp_name'], $caminhoDestino)) {
            // insere caminho no banco
            $sql = "INSERT INTO imagem (url_img, produto_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, "si", $caminhoDestino, $idProduto);
            mysqli_stmt_execute($stmt) or die("Erro ao inserir imagem: " . mysqli_stmt_error($stmt));
        } else {
            die("Erro ao enviar a imagem {$imagem['name']}");
        }
    }
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

        return [
            "idProduto" => $id,
            "nome" => $row['nome'],
            "descricao" => $row['descricao'],
            "tipo" => $row['tipo'],
            "valor" => $row['valor_dia'],
            "nomeFornecedor" => $nomeFornecedor,
            "datas" => $datasDisponiveis
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
        $datas[] = $row['data_disponivel'];
    }

    return $datas;
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


    // Prepara a query
    $sql = "SELECT url_img FROM imagem WHERE produto_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . mysqli_error($conexao));
    }

    mysqli_stmt_bind_param($stmt, "i", $idProduto);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($registro = mysqli_fetch_assoc($resultado)) {
        return $registro; // ['url_img' => ...]
    } else {
        return null; // não encontrou imagem
    }
}

function excluirDatasAntigas($idProduto){
    $conexao = conectarBD();
    $sqlDelete = "DELETE FROM disponibilidades WHERE id_produto = ?";
    $stmtDelete = mysqli_prepare($conexao, $sqlDelete);
    mysqli_stmt_bind_param($stmtDelete, "i", $idProduto);
    mysqli_stmt_execute($stmtDelete);
}
function alterarDatasProduto($idProduto, $data) {
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

function deleteProduto($idProduto) {
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
