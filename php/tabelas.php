<?php
session_start();
require_once '../php/conexao.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] !== 'master') {
    header("Location: ../php/login.php");
    exit();
}

// Parâmetros de busca e paginação
$busca = $_GET['busca'] ?? '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 10;
$offset = ($pagina - 1) * $limite;

// SQL com filtro de 24h e busca
$sql = "SELECT * FROM usuario WHERE data_cadastro >= NOW() - INTERVAL 1 DAY";
$params = [];

if (!empty($busca)) {
    $sql .= " AND (nome LIKE ? OR cpf LIKE ?)";
    $params[] = "%$busca%";
    $params[] = "%$busca%";
}

$sql .= " ORDER BY data_cadastro DESC LIMIT $limite OFFSET $offset";

// Preparando a consulta
$stmt = $conn->prepare($sql);

// Adiciona parâmetros de busca, se houver
if (!empty($busca)) {
    $stmt->bind_param("ss", ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Contador total para paginação
$countSql = "SELECT COUNT(*) as total FROM usuario WHERE data_cadastro >= NOW() - INTERVAL 1 DAY";
if (!empty($busca)) {
    $countSql .= " AND (nome LIKE ? OR cpf LIKE ?)";
    $stmtCount = $conn->prepare($countSql);
    $stmtCount->bind_param("ss", ...$params);
    $stmtCount->execute();
    $total = $stmtCount->get_result()->fetch_assoc()['total'];
} else {
    $total = $conn->query($countSql)->fetch_assoc()['total'];
}

$totalPaginas = ceil($total / $limite);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Usuários Cadastrados</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffdf7;
      color: #333;
      padding: 20px;
    }
    h1 {
      text-align: center;
      color: #d33;
    }
    form.busca {
      margin-bottom: 20px;
      text-align: center;
    }
    form.busca input {
      padding: 8px;
      width: 250px;
    }
    form.busca button {
      padding: 8px 15px;
      background: #f8ad52;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 6px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
    }
    th {
      background-color: #f8ad52;
      color: #fff;
    }
    tr:nth-child(even) {
      background: #f9f9f9;
    }
    .paginacao {
      text-align: center;
      margin-top: 20px;
    }
    .paginacao a {
      margin: 0 5px;
      text-decoration: none;
      padding: 6px 12px;
      background: #f8ad52;
      color: white;
      border-radius: 5px;
    }
    .logout {
      position: absolute;
      top: 20px;
      right: 20px;
      background: #d33;
      color: white;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 6px;
    }
    .logout:hover {
      background: #b22;
    }
  </style>
</head>
<body>

<a href="logout.php" class="logout">Sair</a>
<h1>Usuários Cadastrados nas últimas 24h</h1>

<form class="busca" method="GET" action="tabelas.php">
  <input type="text" name="busca" placeholder="Buscar por nome ou CPF" value="<?= htmlspecialchars($busca) ?>">
  <button type="submit">Buscar</button>
</form>

<form action="gerar_pdf.php" method="post" style="text-align: center; margin-bottom: 20px;">
  <input type="hidden" name="busca" value="<?= htmlspecialchars($busca) ?>">
  <button type="submit" style="background: #4CAF50; color: white; padding: 8px 20px; border: none; border-radius: 6px;">📄 Baixar PDF</button>
</form>

<table>
  <thead>
    <tr>
      <th>Nome</th>
      <th>Mãe</th>
      <th>CPF</th>
      <th>CEP</th>
      <th>Email</th>
      <th>Telefone</th>
      <th>Login</th>
      <th>Data de Cadastro</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['nome']) ?></td>
        <td><?= htmlspecialchars($row['nome_mae']) ?></td>
        <td><?= htmlspecialchars($row['cpf']) ?></td>
        <td><?= htmlspecialchars($row['cep']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['cell']) ?></td>
        <td><?= htmlspecialchars($row['login']) ?></td>
        <td><?= date('d/m/Y H:i', strtotime($row['data_cadastro'])) ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<div class="paginacao">
  <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
    <a href="?pagina=<?= $i ?>&busca=<?= urlencode($busca) ?>"><?= $i ?></a>
  <?php endfor; ?>
</div>

</body>
</html>
