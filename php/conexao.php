<?php
$host = 'localhost';                
$usuario = 'root';                  
$senha = '';                        
$banco = 'modelo_bancodedados';      

// Criando a conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificando se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>
