<?php
  session_start();
  $perfil = $_SESSION['usuario']['perfil'] ?? null;
  $logado = isset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"><!-- Ícones do Font Awesome -->
        <link rel="stylesheet" href="../css/style.css"> 
        <title>Página Principal</title>
    </head>
    <body> <!-- Corpo do Site-->
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

        <main>
            <section class="hero">
                <div class="carousel">
                    <div class="carousel-inner">
                        <img src="../img/promo2-pizza.jpg" class="carousel-item" alt="Pizza Especial 1">
                        <img src="../img/promo-pizza.jpg" class="carousel-item active" alt="Pizza Especial 2">
                    </div>
                    <button class="carousel-control prev">❮</button>
                    <button class="carousel-control next">❯</button>
                </div>
                <div class="container hero-content">
                    <h2>Sabores que conquistam!</h2>
                    <p>Ingredientes selecionados, forno à lenha e muito amor. 🍕</p>
                    <a href="#menu-2" class="btn">Ver Cardápio</a>
                </div>
            </section>
            <!-- Pizzas mais pedidas -->
            <section id="menu" class="menu">
                <div class="container">
                    <br>
                    <h3>Pizzas mais Pedidas</h3>
                    <div class="grid">
                        <!-- Pizza 1 -->
                        <div class="pizza">
                            <img src="../img/margherita.png" alt="Pizza Margherita" class="imagem-pizzas">
                             <h4 class="h4-nome-pizzas">Margherita</h4>
                             <p>Molho de tomate, mussarela, manjericão.</p>
                             <div class="estrelas">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star-half-alt checked"></span>
                            </div>
                        </div>
                        <!-- Pizza 2 -->
                        <div class="pizza">
                            <img src="../img/calabresa.png" alt="Pizza Calabresa" class="imagem-pizzas">
                            <h4 class="h4-nome-pizzas">Calabresa</h4>
                            <p>Calabresa, cebola roxa e orégano.</p>
                            <div class="estrelas">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </div>
                        </div>
                        <!-- Pizza 3 -->
                        <div class="pizza">
                            <img src="../img/quatro-queijos.png" alt="Pizza Quatro Queijos" class="imagem-pizzas">
                            <h4 class="h4-nome-pizzas">Quatro Queijos</h4>
                            <p>Mussarela, gorgonzola, parmesão e catupiry.</p>
                            <div class="estrelas">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section> <br>
            <!-- Cardápio completo -->
            <section id="menu-2" class="menu-grid">
                <div class="container-cardapio">
                    <h3>Nosso Cardápio:</h3>
                    <h3>Pizzas Salgadas & Doces</h3>
                    <div class="grid">
                        <div class="pizza">
                            <h4 class="h4-nome-pizzas">Pizza de Calabresa</h4>
                            <img class="imagem-pizzas" src="../img/pizza-Calabresa.png" alt="Pizza de Calabresa">
                            <p class="p-precos">R$:23,00</p>
                            <div class="bebida-opcao">
                                <label class="label-bebida">Escolha uma bebida:</label>
                                <select class="select-bebida">
                                    <option value="">Selecione</option>
                                    <option>Coca-cola (2L)</option>
                                    <option>Pepsi (2L)</option>
                                    <option>Guaraná (2L)</option>
                                    <option>Fanta Uva (2L)</option>
                                </select>
                            </div>
                            <button class="botao-pedir">Pedir Pizza</button>
                        </div>
                        <!-- Mussarela -->
                        <div class="pizza">
                            <h4 class="h4-nome-pizzas">Pizza de Mussarela</h4>
                            <img class="imagem-pizzas" src="../img/pizza-Mussarela.png" alt="Pizza de Mussarela">
                            <p class="p-preços">R$:23,00</p>
                            <div class="bebida-opcao">
                                <label class="label-bebida">Escolha uma bebida:</label>
                                <select class="select-bebida">
                                    <option value="selecione">selecione</option>
                                    <option value="Coca-cola">Coca-cola(2L)</option>
                                    <option value="Pepsi">Pepsi(2L)</option>
                                    <option value="Guaraná">Guaraná(2L)</option>
                                    <option value="Fanta Uva">Fanta Uva(2L)</option>
                                </select>
                            </div>
                            <button class="botao-pedir">Pedir Pizza</button>
                        </div>
                        <!-- Portuguesa -->
                        <div class="pizza">
                            <h4 class="h4-nome-pizzas">Pizza Portuguesa</h4>
                            <img class="imagem-pizzas" src="../img/pizza-Portuguesa.png" alt="Pizza Portuguesa">
                            <p class="p-preços">R$:23,00</p>
                            <div class="bebida-opcao">
                                <label class="label-bebida">Escolha uma bebida:</label>
                                <select class="select-bebida">
                                    <option value="selecione">selecione</option>
                                    <option value="Coca-cola">Coca-cola(2L)</option>
                                    <option value="Pepsi">Pepsi(2L)</option>
                                    <option value="Guaraná">Guaraná(2L)</option>
                                    <option value="Fanta Uva">Fanta Uva(2L)</option>
                                </select>
                            </div>
                            <button class="botao-pedir">Pedir Pizza</button>
                        </div>
                        <!-- Vegana -->
                        <div class="pizza">
                            <h4 class="h4-nome-pizzas">Pizza Vegana</h4>
                            <img class="imagem-pizzas" src="../img/pizza-Vegana.png" alt="Pizza Vegana">
                            <p class="p-preços">R$:23,00</p>
                                <div class="bebida-opcao">
                                    <label class="label-bebida">Escolha uma bebida:</label>
                                    <select class="select-bebida">
                                        <option value="selecione">selecione</option>
                                        <option value="Coca-cola">Coca-cola(2L)</option>
                                        <option value="Pepsi">Pepsi(2L)</option>
                                        <option value="Guaraná">Guaraná(2L)</option>
                                        <option value="Fanta Uva">Fanta Uva(2L)</option>
                                    </select>
                                </div>
                                <button class="botao-pedir">Pedir Pizza</button>
                            </div>
                            <!-- Doces -->
                            <div class="pizza">
                                <h4 class="h4-nome-pizzas">Pizza de M&Ms</h4>
                                <img class="imagem-pizzas" src="../img/pizza-M&ms.png" alt="Pizza de M&Ms">
                                <p class="p-preços">R$:27,00</p>
                                <div class="bebida-opcao">
                                    <label class="label-bebida">Escolha uma bebida:</label>
                                    <select class="select-bebida">
                                        <option value="selecione">selecione</option>
                                        <option value="Coca-cola">Coca-cola(2L)</option>
                                        <option value="Pepsi">Pepsi(2L)</option>
                                        <option value="Guaraná">Guaraná(2L)</option>
                                        <option value="Fanta Uva">Fanta Uva(2L)</option>
                                    </select>
                                </div>
                                <button class="botao-pedir">Pedir Pizza</button>
                            </div>
                            <div class="pizza">
                                <h4 class="h4-nome-pizzas">Pizza de Brownie</h4>
                                    <img class="imagem-pizzas" src="../img/pizza-Brownie.png" alt="Pizza de Brownie">
                                    <p class="p-preços">R$:27,00</p>
                                    <div class="bebida-opcao">
                                        <label class="label-bebida">Escolha uma bebida:</label>
                                        <select class="select-bebida">
                                            <option value="selecione">selecione</option>
                                            <option value="Coca-cola">Coca-cola(2L)</option>
                                            <option value="Pepsi">Pepsi(2L)</option>
                                            <option value="Guaraná">Guaraná(2L)</option>
                                            <option value="Fanta Uva">Fanta Uva(2L)</option>
                                        </select>
                                    </div>
                                    <button class="botao-pedir">Pedir Pizza</button>
                                </div>
                                <div class="pizza">
                                    <h4 class="h4-nome-pizzas">Pizza de Oreo</h4>
                                    <img class="imagem-pizzas" src="../img/pizza-Oreo.png" alt="Pizza de Oreo">
                                    <p class="p-preços">R$:27,00</p>
                                    <div class="bebida-opcao">
                                        <label class="label-bebida">Escolha uma bebida:</label>
                                        <select class="select-bebida">
                                            <option value="selecione">selecione</option>
                                            <option value="Coca-cola">Coca-cola(2L)</option>
                                            <option value="Pepsi">Pepsi(2L)</option>
                                            <option value="Guaraná">Guaraná(2L)</option>
                                            <option value="Fanta Uva">Fanta Uva(2L)</option>
                                        </select>
                                    </div>
                                    <button class="botao-pedir">Pedir Pizza</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
    <br>
    <footer><!-- Rodapé -->
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
                            <p>Tradição e sabor há mais de 20 anos,<br>nossas pizzas são preparadas artesanalmente com os melhores ingredientes.</p>
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
            <div class="footer-bottom">
                <p>&copy; 2025 Pizzaria Bella. Todos os direitos reservados.</p>
            </div>
            <script src="../javascript/javascript.js"></script>
        </div>
    </footer>
</html>