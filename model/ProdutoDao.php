<?php
require_once "ConexaoBD.php";

function inserirProduto($tipoProduto, $nomeProduto, $arrayTags, $idUsuario, $valorProduto, $descricaoProduto, $diasDisponiveis, $cep, $cidade, $bairro, $rua, $numero, $complemento)
{
    $conexao = conectarBD();

    $diasString = implode(',', $diasDisponiveis);

    if ($tipoProduto == 'Equipamento') {
        $sql = "INSERT INTO produto (tipo, nome, id_usuario, valor_dia, descricao, dias_disponiveis) VALUES (?, ?, ?, ?, ?, ?)";
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
        $sql = "INSERT INTO produto (tipo, nome, id_usuario, valor_dia, descricao, dias_disponiveis, cep, cidade, bairro, rua, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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


    mysqli_stmt_execute($stmt) or die('Erro no INSERT do produto: ' . mysqli_stmt_error($stmt));

    // Pega o código inserido
    $idProduto = mysqli_insert_id($conexao);


    // Insere as tags relacionadas
    if (!inserirTagsHasProduto($arrayTags, $idProduto)) {
        die('Erro ao inserir na tabela relacional: ' . mysqli_error($conexao));
    }

    if (!inserirDisponibilidades($diasDisponiveis, $idProduto)) {
        die('Erro ao inserir na tabela relacional: ' . mysqli_error($conexao));
    }


    return $idProduto;
}

function inserirImgBlob($conteudo, $type, $idProduto)
{
    $conexao = conectarBD();

    $sql = "INSERT INTO imagem (dados, tipo, produto_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);

    $null = NULL;

    mysqli_stmt_bind_param($stmt, "bsi", $null, $type, $idProduto);
    mysqli_stmt_send_long_data($stmt, 0, $conteudo);

    if (!mysqli_stmt_execute($stmt)) {
        die("Erro ao inserir imagem: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
}




// Função para inserir as tags relacionadas ao produto
function inserirTagsHasProduto($arrayTags, $idProduto)
{
    $conexao = conectarBD();
    $tagsIds = [];

    $stmtBusca = $conexao->prepare("SELECT id FROM tags WHERE nome = ?");
    $stmtInsertTag = $conexao->prepare("INSERT INTO tags (nome) VALUES (?)");
    $stmtRel = $conexao->prepare("INSERT INTO tags_has_produto (tags_id, produto_id) VALUES (?, ?)");

    foreach ($arrayTags as $tagName) {

        $tagName = trim($tagName);
        if ($tagName === "") continue;

        // 1. Verificar se já existe
        $stmtBusca->bind_param("s", $tagName);
        $stmtBusca->execute();
        $res = $stmtBusca->get_result();

        if ($row = $res->fetch_assoc()) {
            $idTag = $row['id'];
        } else {
            // 2. Criar a tag
            $stmtInsertTag->bind_param("s", $tagName);
            if (!$stmtInsertTag->execute()) {
                continue;
            }
            $idTag = $conexao->insert_id;
        }

        $tagsIds[] = $idTag;
    }

    // 3. Relacionar as tags ao produto
    foreach ($tagsIds as $idTag) {
        $stmtRel->bind_param("ii", $idTag, $idProduto);
        $stmtRel->execute();
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

    $sql = "SELECT * FROM produto WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();


    if ($row = $res->fetch_assoc()) {


        $idFornecedor = $row['id_usuario'];

        // pegar datas disponiveis
        $datasDisponiveis = buscarDatasDisponiveis($id);
        // pegar tags
        $tags = buscarTags($id);
        // pegar imagens
        $imgs = buscarImgs($id);

        return [
            "idProduto" => $id,
            "nomeProduto" => $row['nome'],
            "descricaoProduto" => $row['descricao'],
            "tipo" => $row['tipo'],
            "valorDia" => $row['valor_dia'],
            "idFornecedor" => $idFornecedor,
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

function updateDadosProduto($nomeProduto, $valorDia, $descricaoProduto, $idProduto, $tags)
{
    $conexao = conectarBD();

    $sql = "UPDATE produto 
            SET nome = ?, valor_dia = ?, descricao = ?
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sdsi", $nomeProduto, $valorDia, $descricaoProduto, $idProduto);
    // s = string, d = double (float), i = integer
    if ($res = $stmt->execute()) {
        $tagsArray = json_decode($tags, true);
        if (updateTagsProduto($tagsArray, $idProduto)) {
            return $res;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function updateTagsProduto($tagsArray, $idProduto)
{
    $conexao = conectarBD();
    $tagsIds = [];

    // 1. Preparar statements
    $stmtBusca = $conexao->prepare("SELECT id FROM tags WHERE nome = ?");
    $stmtInsert = $conexao->prepare("INSERT INTO tags (nome) VALUES (?)");

    foreach ($tagsArray as $tagName) {

        // --- BUSCA A TAG ---
        $stmtBusca->bind_param("s", $tagName);
        $stmtBusca->execute();
        $resultado = $stmtBusca->get_result();

        if ($resultado->num_rows > 0) {
            // Já existe → pegar ID
            $idTag = $resultado->fetch_assoc()['id'];
        } else {
            // Não existe → inserir
            $stmtInsert->bind_param("s", $tagName);

            if (!$stmtInsert->execute()) {
                continue; // evita travar se der erro em 1 tag
            }

            $idTag = $conexao->insert_id;
        }

        $tagsIds[] = $idTag;
    }

    // 2. Atualizar relação na tabela relacional
    if (!empty($tagsIds)) {
        // Primeiro limpar as antigas relações
        $sql = "DELETE FROM tags_has_produto WHERE produto_id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $idProduto);
        if (!$stmt->execute()) {
            return false;
        }
        $stmt->close();


        // Inserir novamente todas as relações válidas
        $stmtRel = $conexao->prepare(
            "INSERT INTO tags_has_produto (tags_id, produto_id) VALUES (?, ?)"
        );

        foreach ($tagsIds as $idTag) {
            $stmtRel->bind_param("ii", $idTag, $idProduto);
            $stmtRel->execute();
        }
    }

    return true;
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
    $sql = "SELECT id, dados, tipo FROM imagem WHERE produto_id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idProduto);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $imagens = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $imagens[] = [
            'id'    => $row['id'],                    // PEGANDO O ID
            'dados' => base64_encode($row['dados']),  // BLOB → base64
            'tipo'  => $row['tipo']
        ];
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);

    return $imagens;
}


function buscarQuatroImgs($idProduto)
{
    $conexao = conectarBD();
    $sql = "SELECT dados, tipo FROM imagem WHERE produto_id = ? LIMIT 4";
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

function inserirFavoritosDAO($idUsuario, $idProduto)
{

    $conexao = conectarBD(); // Função para conectar ao banco de dados
    if (!$conexao) {

        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    $sql = "INSERT IGNORE INTO favoritos (id_usuario, id_produto) VALUES (?, ?)";

    $stmt = $conexao->prepare($sql);

    if (!$stmt) {

        die("Erro ao preparar a inserção: " . $conexao->error);
    }

    $stmt->bind_param("ii", $idUsuario, $idProduto);
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
