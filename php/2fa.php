<?php
session_start();

// Se não estiver logado, redireciona para login
if (!isset($_SESSION['usuario'])) {
    header("Location:../php/login.php");
    exit();
}

$max_tentativas = 3;
$erro = "";

// Perguntas possíveis e a chave para buscar no $_SESSION['usuario']
$perguntas = [
    'nome_mae' => 'Qual é o nome da sua mãe?',
    'data_nascimento' => 'Qual é a sua data de nascimento? (YYYY-MM-DD)',
    'cep' => 'Qual é o seu CEP?',
];

// Se ainda não tem pergunta sorteada, sorteia uma e salva
if (!isset($_SESSION['2fa_pergunta'])) {
    $chaves = array_keys($perguntas);
    $indice_aleatorio = array_rand($chaves);
    $_SESSION['2fa_pergunta'] = $chaves[$indice_aleatorio];
}

$chave_pergunta = $_SESSION['2fa_pergunta'];
$texto_pergunta = $perguntas[$chave_pergunta];

// Inicializa o contador de tentativas se não existir
if (!isset($_SESSION['2fa_tentativas'])) {
    $_SESSION['2fa_tentativas'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resposta = trim($_POST['resposta'] ?? '');
    $esperado = $_SESSION['usuario'][$chave_pergunta] ?? '';

    // Normalizar para comparação
    if ($chave_pergunta === 'data_nascimento') {
        $resposta = date('Y-m-d', strtotime($resposta));
        $esperado = date('Y-m-d', strtotime($esperado));
    } else {
        $resposta = mb_strtolower($resposta);
        $esperado = mb_strtolower($esperado);
    }

    if ($resposta === $esperado) {
        // Passou no 2FA
        $_SESSION['2fa_acertou'] = true;
        // Limpa pergunta e tentativas
        unset($_SESSION['2fa_pergunta']);
        $_SESSION['2fa_tentativas'] = 0;

        // Redireciona para área restrita (ajuste o caminho conforme sua estrutura)
        header("Location:../php/index.php");
        exit();
    } else {
        $_SESSION['2fa_tentativas']++;

        if ($_SESSION['2fa_tentativas'] >= $max_tentativas) {
            // Destrói sessão e volta para login com erro
            session_destroy();
            header("Location: ../php/login.php?erro=2fa");
            exit();
        } else {
            $erro = "Resposta incorreta. Tentativa {$_SESSION['2fa_tentativas']} de $max_tentativas.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verificação 2FA - Bella Pizza</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        max-width: 450px;
        margin: 50px auto;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 12px rgba(0,0,0,0.1);
      }
      label, input, button {
        display: block;
        width: 100%;
        margin-bottom: 15px;
      }
      input {
        padding: 8px;
        font-size: 1rem;
      }
      button {
        padding: 10px;
        font-size: 1.1rem;
        background-color: #cc3300;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }
      button:hover {
        background-color: #b02a00;
      }
      .error {
        color: red;
        font-weight: bold;
        margin-bottom: 15px;
      }
    </style>
</head>
<body>

  <h1>Verificação de Segurança</h1>
  <p>Para continuar, responda a pergunta abaixo:</p>

  <form method="POST" action="">
    <label for="resposta"><?= htmlspecialchars($texto_pergunta) ?></label>
    <input type="text" id="resposta" name="resposta" required autofocus placeholder="Digite sua resposta aqui" />
    <button type="submit">Enviar</button>
  </form>

  <?php if (!empty($erro)): ?>
    <p class="error"><?= htmlspecialchars($erro) ?></p>
  <?php endif; ?>

</body>
</html>
