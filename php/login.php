<?php
session_start();
require_once '../php/conexao.php';
function registrarLog($conn, $login, $status) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt = $conn->prepare("INSERT INTO logs_acesso (login, status, id_usuario) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $login, $status, $id_usuario);
    $stmt->execute();
}

// Exibe erros para ajudar no debug (remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST['nome'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($login) || empty($senha)) {
        $erro = "Preencha os campos de login e senha.";
    } else {
        if (!$conn) {
            die("Erro de conexão com o banco.");
        }

        $stmt = $conn->prepare("SELECT * FROM usuario WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario'] = [
                    'id_usuario'          => $usuario['id_usuario'],
                    'login'       => $usuario['login'],
                    'perfil'      => $usuario['perfil'],
                    'nome_mae'    => $usuario['nome_mae'],
                    'data_nascimento' => $usuario['data_nascimento'],
                    'cep'         => $usuario['cep']
                ];
                $_SESSION['2fa_acertou'] = false;
                $_SESSION['2fa_tentativas'] = 0;

                header("Location: 2fa.php");
                exit();
            } else {
                $erro = "Login ou senha incorretos.";
            }
        } else {
            $erro = "Login ou senha incorretos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Login - Bella Pizza</title>
    <link rel="stylesheet" href="../css/login.css" />
  </head>
  <body>
    <!-- Fundo com triangulinhos (fatias de pizza) -->
    <div class="pizza-background">
      <div class="slice"></div><div class="slice"></div><div class="slice"></div>
      <div class="slice"></div><div class="slice"></div><div class="slice"></div>
      <div class="slice"></div><div class="slice"></div><div class="slice"></div>
      <div class="slice"></div><div class="slice"></div><div class="slice"></div>
      <div class="slice"></div><div class="slice"></div><div class="slice"></div>
      <div class="slice"></div><div class="slice"></div><div class="slice"></div> 
    </div>
    <!-- Cabeçalho -->
    <header> 
      <div class="header-content">
        <h1 class="logo">
          <a href="../php/index.php" class="logo-link">
            <img src="../img/logo-bella2.png" alt="Logo Bella Pizza" class="logo-img" />
            Bella Pizza
          </a>
        </h1>
        <nav>
          <ul>
            <li><a href="../html/cadastro.html">Cadastro</a></li>
            <li><a href="../php/login.php">Login</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <!-- Login -->
    <main class="container">
      <section class="login-box">
        <h1>Bem-vindo à Bella Pizza</h1>
        <p class="subtitulo">Acesse sua conta para continuar</p>
        <?php if (!empty($erro)): ?>
          <p style="color:red; text-align:center;"><?= $erro ?></p>
        <?php endif; ?>
        
        <form method="POST" action="">
          <div class="input-group">
            <label for="nome">Usuário</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome de usuário" required/>
          </div> 
          
          <div class="input-group">
            <label for="senha">Senha</label>
            <div class="senha-wrapper">
              <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required />
            </div>
          </div>

          <div class="botoes">
            <button type="submit" class="btn-login">Entrar</button>
            <button type="reset" class="btn-reset">Limpar</button>
          </div>

          <div style="text-align:right; margin-bottom:10px;">
            <a href="../html/esqueceu_senha.html" style="color:#ff7c2b;">Esqueceu a senha?</a>
          </div>
        </form>
      </section>
    </main>
    <!-- Rodapé -->
    <footer>
      <div class="container footer-content">
        <div class="footer-links">
          <div>
            <h4>Cardápio</h4>
            <ul>
              <li><a href="#menu-2">Nossas Pizzas</a></li>
              <li><a href="#menu">Sabores Especiais</a></li>
            </ul>
          </div>
        <div>
          <h4>Sobre Nós</h4>
          <ul>
            <li>
              <p>Tradição e sabor há mais de 20 anos,<br />nossas pizzas são preparadas artesanalmente<br />com os melhores ingredientes.</p>
            </li>
          </ul>
        </div>
        <div>
          <h4>Contato</h4>
          <ul>
            <li>(21) 4002-8922</li>
            <li>Avenida dos Sabores, 456 - RJ</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Pizzaria Bella. Todos os direitos reservados.</p>
    </div>
    <script>
  const senhaInput = document.getElementById("senha");
  const toggleSenha = document.getElementById("toggleSenha");
  const iconeOlho = document.getElementById("iconeOlho");

  toggleSenha.addEventListener("click", function() {
    if (senhaInput.type === "password") {
      senhaInput.type = "text";
      iconeOlho.classList.remove("bi-eye-slash");
      iconeOlho.classList.add("bi-eye");
    } else {
      senhaInput.type = "password";
      iconeOlho.classList.remove("bi-eye");
      iconeOlho.classList.add("bi-eye-slash");
    }
  });
   </script>
   
  </footer>
</body>
</html>
