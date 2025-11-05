<?php
require_once '../php/conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recebendo os dados do formulário
    $nome              = $_POST['nome'] ?? '';
    $nome_mae          = $_POST['mae'] ?? '';
    $cpf               = $_POST['cpf'] ?? '';
    $cep               = $_POST['cep'] ?? '';
    $email             = $_POST['email'] ?? '';
    $login             = $_POST['login'] ?? '';
    $senha             = $_POST['senha'] ?? '';
    $cell              = $_POST['telefone'] ?? '';
    $data_nascimento   = $_POST['data_nascimento'] ?? '';
    $sexo              = $_POST['sexo'] ?? '';
    $bairro            = $_POST['bairro'] ?? '';
    $endereco          = $_POST['endereco'] ?? '';

    // Criptografando a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);


    // Preparando a query
    $sql = "INSERT INTO usuario (
        nome, nome_mae, cpf, cep, email, login, senha, cell,
        data_nascimento, sexo, bairro, endereco, perfil
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $perfil = 'comum'; // padrão para novos usuários
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssssss",
        $nome,
        $nome_mae,
        $cpf,
        $cep,
        $email,
        $login,
        $senha_hash,
        $cell,
        $data_nascimento,
        $sexo,
        $bairro,
        $endereco,
        $perfil
    );

    if ($stmt->execute()) {
        // Redireciona para login após sucesso
        header("Location:../php/login.php");
        exit();
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
