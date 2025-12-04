<?php
session_start();



require_once "../model/ProdutoDao.php";
require_once "./FuncoesUteis.php";

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

switch ($acao) {
    case 'cadastrar':
        cadastrarProduto($_POST);
        break;

    case 'cadastrarEnd':
        cadastrarEnderecoProduto($_POST);
        break;

    case 'removerImg':
        removerImgProduto($_POST);
        break;

    case 'cadastrarProdutoFinal':
        cadastrarProdutoFinal($_FILES['images']);
        break;

    case 'cancelarCadastro':
        cancelarCadastro();
        break;

    case 'acessar':
        acessarProduto($_GET['id'] ?? null);
        break;

    case 'pesquisar':
        pesquisarProdutos($_POST);
        break;

    case 'acessarMeuProduto':
        acessarProdutoPraAlterar($_GET['id'] ?? null);
        break;

    case 'alterarDatas':
        alterarDatasProduto($_POST);
        break;

    case 'alterar':
        alterarDadosProduto($_POST);
        break;
    // case 'excluir':
    //     excluirCliente($_GET['id'] ?? null);
    //     break;
    case 'excluir':
        excluirProduto($_GET['id'] ?? null);
        break;

    case 'inserirFavorito':
        inserirFavorito($_POST);
        break;


    case 'excluirFavorito':
        excluirFavorito($_POST);
        break;

    case 'listarUmaImg':
        listarUmaImg($idProduto);
        break;

    default:
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view/pag-incial.php'));
        // header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view/pag-incial.php') . "?msgErro=" . urlencode("Ação inválida!"));
        break;
}



function cadastrarProduto($dadosPOST)
{
    $tipoProduto = $dadosPOST['tipoProduto'];
    $nomeProduto = $dadosPOST['nomeProduto'];
    $valorProduto = $dadosPOST['valorProduto'];
    $descricaoProduto = $dadosPOST['descricaoProduto'] ?? "";
    $diasDisponiveisProduto = $dadosPOST['diasDisponiveis'] ?? [];

    $msgErro = validarCamposProduto($nomeProduto, $valorProduto, $diasDisponiveisProduto);

    // $dadosPOST['diasDisponiveis'] = $_POST['diasDisponiveis'] ?? [];
    $tagsIds = $_POST['arrayTags'] ?? [];        // se nada selecionado, array vazio
    if (!is_array($tagsIds)) $tagsIds = [$tagsIds]; // segurança se vier só 1 valor
    $tagsIds = array_map('intval', $tagsIds);    // converte strings para inteiros

    $_SESSION['novoProduto']['tipoProduto'] = $tipoProduto;
    $_SESSION['novoProduto']['nomeProduto'] = $nomeProduto;
    $_SESSION['novoProduto']['valorProduto'] = $valorProduto;
    $_SESSION['novoProduto']['descricaoProduto'] = $descricaoProduto;

    $_SESSION['novoProduto']['diasDisponiveisProduto'] = $diasDisponiveisProduto;
    $_SESSION['novoProduto']['tagsProduto'] = $tagsIds;


    if (!empty($msgErro)) {
        header("Location:/louer/view/produto/pag-novo-produto.php?msgErro=$msgErro");
        exit;
    }

    if ($tipoProduto == 'Equipamento') {
        // header("Location:../view/fornecedor/pag-inicial-fornecedor0.php?msg=Produto $np adicionado com sucesso!"); adicionar essa depois de adicionar as fotos
        header("Location: /louer/view/produto/pag-novo-produto-img.php");
        exit;
    }
    header("Location: /louer/view/produto/pag-novo-produto-end.php");
    exit;
}


function cadastrarEnderecoProduto($dadosPOST)
{
    $cepProduto = $dadosPOST['cep'] ?? '';
    $cidadeProduto = $dadosPOST['cidade'] ?? '';
    $bairroProduto = $dadosPOST['bairro'] ?? '';
    $ruaProduto = $dadosPOST['rua'] ?? '';
    $numeroProduto = $dadosPOST['numero'] ?? '';



    $msgErro = validarCamposProduto($cepProduto, $cidadeProduto, $bairroProduto, $ruaProduto, $numeroProduto);

    $_SESSION['novoProduto']['cepProduto'] = $cepProduto;
    $_SESSION['novoProduto']['cidadeProduto'] = $cidadeProduto;
    $_SESSION['novoProduto']['bairroProduto'] = $bairroProduto;
    $_SESSION['novoProduto']['ruaProduto'] = $ruaProduto;
    $_SESSION['novoProduto']['numeroProduto'] = $numeroProduto;


    if (!empty($msgErro)) {
        header("Location:/louer/view/produto/pag-novo-produto-end.php?msgErro=$msgErro");
        exit;
    }

    header("Location: /louer/view/produto/pag-novo-produto-img.php");
}


function adicionarImgProduto($files, $idProduto)
{
    $MAX_FINAL_SIZE = 900 * 1024; // 900 KB limite para evitar erro no MySQL
    $ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    foreach ($files["tmp_name"] as $i => $tmpName) {

        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            header("Location: /louer/view/produto/pag-novo-produto-img.php?msgErro=Erro ao enviar imagem.");
            exit;
        }

        $type = mime_content_type($tmpName);

        if (!in_array($type, $ALLOWED_MIME)) {
            header("Location: /louer/view/produto/pag-novo-produto-img.php?msgErro=Tipo de imagem não permitido.");
            exit;
        }

        // Reduz / converte / comprime
        $arquivoReducao = redimensionarImagem($tmpName);

        if (!$arquivoReducao) {
            header("Location: /louer/view/produto/pag-novo-produto-img.php?msgErro=Falha ao processar imagem.");
            exit;
        }

        // Mede tamanho final
        $tamanhoFinal = filesize($arquivoReducao);

        if ($tamanhoFinal > $MAX_FINAL_SIZE) {
            unlink($arquivoReducao);
            header("Location: /louer/view/produto/pag-novo-produto-img.php?msgErro=Imagem muito grande mesmo após compressão. Use uma imagem menor.");
            exit;
        }

        // Conteúdo pronto para banco
        $conteudo = file_get_contents($arquivoReducao);
        unlink($arquivoReducao);

        // Insere
        inserirImgBlob($conteudo, $type, $idProduto);
    }
}




function cadastrarProdutoFinal($files)
{

    // Operação

    $idUsuario = $_SESSION['id'];
    $novoProduto = $_SESSION['novoProduto'];


    if (!empty($novoProduto)) {
        $tipoProduto = $novoProduto['tipoProduto'];
        $nomeProduto = $novoProduto['nomeProduto'];
        $valorProduto = $novoProduto['valorProduto'];
        $descricaoProduto = $novoProduto['descricaoProduto'] ?? '';
        $tagsIds = $novoProduto['tagsProduto'] ?? [];
        $diasDisponiveis = $novoProduto['diasDisponiveisProduto'] ?? [];
        $cep = $novoProduto['cepProduto'] ?? '';
        $cidade = $novoProduto['cidadeProduto'] ?? '';
        $bairro = $novoProduto['bairroProduto'] ?? '';
        $rua = $novoProduto['ruaProduto'] ?? '';
        $numero = $novoProduto['numeroProduto'] ?? '';
        $complemento = $novoProduto['complementoProduto'] ?? '';

        $np = inserirProduto($tipoProduto, $nomeProduto, $tagsIds, $idUsuario, $valorProduto, $descricaoProduto, $diasDisponiveis, $cep, $cidade, $bairro, $rua, $numero, $complemento);
        if ($np) {
            adicionarImgProduto($files, $np);

            unset($_SESSION['novoProduto']);
            header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?msg=Produto Adicionado");
            exit;
        }
        header("Location: /louer/view/produto/novo-produto-img.php?msgErro=Erro ao inserir produto.");
        exit;
    }
    header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?msgErro=Erro ao adicionar produto.");
    exit;
}


function acessarProduto($idProduto)
{

    if (!$idProduto) {

        header("Location: /louer/view/pag-inicial.php?msg=Produto inválido. (ProdutoController)");
        exit;
    }

    $dadosProduto = consultarProduto($idProduto);
    if (isset($dadosProduto)) {


        $_SESSION['Produto'] = $dadosProduto;
        header("Location: /louer/view/produto/pag-produto.php");
        exit;
    } else {

        header("Location: /louer/view/pag-inicial.php");
        exit;
    }
}

function cancelarCadastro()
{
    if (isset($_SESSION['novoProduto'])) {
        unset($_SESSION['novoProduto']);
    }
    header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php");
    exit;
}

function pesquisarProdutos($dadosPesquisa)
{

    $conteudoPesquisa = $dadosPesquisa['pesquisa'];

    $_SESSION['conteudoPesquisa'] = $conteudoPesquisa;
    header("Location: ../view/pag-inicial.php");
    exit;
}

function acessarProdutoPraAlterar($idProduto)
{
    if (!$idProduto) {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?msg=Produto inválido. (ProdutoController)");
        exit;
    }

    $dadosProduto = consultarProduto($idProduto);
    $_SESSION['Produto'] = $dadosProduto;

    if (isset($dadosProduto)) {
        header("Location: /louer/view/produto/pag-produto-alterar.php");
        exit;
    } else {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php");
        exit;
    }
}

function alterarDatasProduto($dadosPOST)
{
    $idProduto = $dadosPOST['idProduto'] ?? null;
    /**
     * Verifica se o método é POST.
     * Caso contrário, manda um erro
     */
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        die('Método não é POST.');
    }

    /**
     * Verifica se o parâmetro foi enviado
     * ou se está vazio
     */
    if (!isset($_POST["datas_selecionadas"]) || empty($_POST["datas_selecionadas"])) {
        http_response_code(400);
        die('Nenhuma data selecionada.');
    }

    /**
     * Seleciona a lista de datas como string
     */
    $datas_json = $_POST["datas_selecionadas"];
    /**
     * transformando a string
     * em lista normal de volta
     */
    $datas = json_decode($datas_json);

    /**
     * Verifica se a conversão aconteceu com sucesso
     */
    if ($datas === null || !is_array($datas)) {
        http_response_code(400);
        die('Formato de dados inválido.');
    }

    /**
     * Verifica se há pelo menos uma data
     */
    if (count($datas) === 0) {
        http_response_code(400);
        die('Nenhuma data válida foi encontrada.');
    }

    require_once "../model/ProdutoDao.php";
    excluirDatasAntigas($idProduto);

    foreach ($datas as $data) {
        var_dump($idProduto);
        updateDatasProduto($idProduto, $data);
    }
    header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?msg=Produto alterado com sucesso!");
    exit;
}

function alterarDadosProduto($dadosPOST)
{
    // recebe os dados do formulario de alteracao 
    $idProduto = $dadosPOST['idProduto'];
    $nomeProduto = $dadosPOST['nomeProduto'];
    $valorDia = $dadosPOST['valorDia'];
    $descricaoProduto = $dadosPOST['descricaoProduto'];
    $disponibilidadesFake = "aaa";
    //validar sem o cpf e cnpj
    $msgErro = validarCamposProduto($nomeProduto, $valorDia, $disponibilidadesFake);
    //alterando
    if (empty($msgErro)) {

        if (updateDadosProduto($nomeProduto, $valorDia, $descricaoProduto, $idProduto)) {
            //atualizando as variaveis de sessao
            $_SESSION['Produto']['nomeProduto'] = $nomeProduto;
            $_SESSION['Produto']['valorDia'] = $valorDia;
            $_SESSION['Produto']['descricaoProduto'] = $descricaoProduto;

            header("Location:/louer/view/produto/pag-produto-alterar.php?msg=Dados alterados com sucesso!");
            exit;
        }
        header("Location:/louer/view/produto/pag-produto-alterar.php?msgErro=Não foi possível alterar.");
        exit;
    }
}

function excluirProduto($idProduto)
{
    deleteProduto($idProduto);
    header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?msg=Produto excluído!&pagina=meus-produtos");
}

function removerImgProduto($nomeImg)
{
    if (!empty($_SESSION['novoProduto']['imagens'])) {
        foreach ($_SESSION['novoProduto']['imagens'] as $key => $img) {
            if ($img['nome'] === $nomeImg) {
                unset($_SESSION['novoProduto']['imagens'][$key]);
            }
        }
        // Reindexa array
        $_SESSION['novoProduto']['imagens'] = array_values($_SESSION['novoProduto']['imagens']);
    }
    echo json_encode(['status' => 'ok']);
    exit;
}

function inserirFavorito($dadosPOST)
{
    if (!isset($_SESSION['id'])) {
        header("Location: /louer/view/pag-inicial.php?msgErro=Você precisa estar logado para adicionar favoritos!");
        exit;
    }

    $id_produto = $dadosPOST['idProduto'];
    $id_usuario = $_SESSION['id'];
    if (inserirFavoritosDAO($id_usuario, $id_produto)) {
        header("Location: /louer/view/pag-inicial.php?msg=Produto adicionado aos favoritos!");
        exit;
    } else {
        header("Location: /louer/view/pag-inicial.php?msgErro=Erro ao adicionar produto aos favoritos!");
        exit;
    }
}
function excluirFavorito($dadosPOST)
{
    $id_produto = $dadosPOST['idProduto'];
    $retorno = $dadosPOST['retorno'];
    $id_usuario = $_SESSION['id'];

    if (excluirFavoritosDAO($id_usuario, $id_produto)) {

        header("Location: ../view/pag-inicial.php?msg=Produto removido dos favoritos!");
        exit;
    }
}

function redimensionarImagem($imagePath, $maxWidth = 1920, $maxHeight = 1920, $quality = 80)
{
    list($origWidth, $origHeight, $tipo) = getimagesize($imagePath);

    // Se já é pequena, retorna o próprio caminho
    if ($origWidth <= $maxWidth && $origHeight <= $maxHeight) {
        return $imagePath;
    }

    // Proporção
    $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);

    $newWidth = intval($origWidth * $ratio);
    $newHeight = intval($origHeight * $ratio);

    // Criar imagem original
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $origImg = imagecreatefromjpeg($imagePath);
            break;
        case IMAGETYPE_PNG:
            $origImg = imagecreatefrompng($imagePath);
            break;
        case IMAGETYPE_WEBP:
            $origImg = imagecreatefromwebp($imagePath);
            break;
        case IMAGETYPE_GIF:
            $origImg = imagecreatefromgif($imagePath);
            break;
        default:
            return $imagePath; // tipo não suportado
    }

    // Criar imagem reduzida
    $newImg = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImg, $origImg, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

    // Criar arquivo temporário comprimido
    $tempFile = tempnam(sys_get_temp_dir(), "img_") . ".jpg";

    // Salvar como JPEG comprimido
    imagejpeg($newImg, $tempFile, $quality);

    imagedestroy($origImg);
    imagedestroy($newImg);

    return $tempFile;
}