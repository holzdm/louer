<?php 
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../pag-login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pag do produto</title>
</head>
<body>
    
<?php 
// if (!isset($_GET['idProduto'])){
//     header("Location: ../view-bonitinha/pag-inicial-cliente.php");
// }else{
//     header("Location: ../control/ProdutoController.php?acao='acessar'");
    // criar o clientecontroler no lugar do cadcliente e colocar as funcoes do cliente la
//     require_once '../model/UsuarioModel.php';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $acao = $_POST['acao'] ?? '';

//     switch ($acao) {
//         case 'cadastrar':
//             cadastrarUsuario($_POST);
//             break;

//         case 'editar':
//             editarUsuario($_POST);
//             break;

//         case 'excluir':
//             excluirUsuario($_POST['id']);
//             break;

//         default:
//             echo "Ação inválida.";
//             break;
//     }
// }

// // Funções do controller
// function cadastrarUsuario($dados) {
//     // Aqui você chama a função do model, por exemplo:
//     criarUsuario($dados['nome'], $dados['email']);
//     echo "Usuário cadastrado!";
// }

// function editarUsuario($dados) {
//     // lógica de edição
// }

// }

?>
</body>
</html>