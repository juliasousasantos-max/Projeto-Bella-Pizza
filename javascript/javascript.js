document.addEventListener("DOMContentLoaded", function () {
  let currentSlide = 0;
  const slides = document.querySelectorAll('.carousel-item');

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.remove('active');
      if (i === index) {
        slide.classList.add('active');
      }
    });
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
  }

  // Inicia carrossel automático
  setInterval(nextSlide, 5000);

  // Botões do carrossel
  const prevBtn = document.querySelector('.carousel-control.prev');
  const nextBtn = document.querySelector('.carousel-control.next');

  if (prevBtn && nextBtn) {
    prevBtn.addEventListener('click', prevSlide);
    nextBtn.addEventListener('click', nextSlide);
  }

  // Mostrar slide inicial
  showSlide(currentSlide);

  // Função para pedidos
  const botoes = document.querySelectorAll(".botao-pedir");

  botoes.forEach(function (botao) {
    botao.addEventListener("click", function () {
      const pizzaDiv = botao.closest(".pizza");
      let nomePizza = pizzaDiv.querySelector(".h4-nome-pizzas");
      if (!nomePizza) nomePizza = pizzaDiv.querySelector("h4");
      const nome = nomePizza.innerText;

      const bebidaDiv = pizzaDiv.querySelector(".bebida-opcao");
      const selectBebida = pizzaDiv.querySelector(".select-bebida");
      const bebidaSelecionada = selectBebida.value;

      if (bebidaDiv.style.display !== "block") {
        bebidaDiv.style.display = "block";
        bebidaDiv.scrollIntoView({ behavior: "smooth", block: "center" });
        return;
      }

      if (bebidaSelecionada === "selecione") {
        alert("Por favor, selecione uma bebida para continuar.");
        return;
      }

      const mensagem = `Olá! Gostaria de pedir uma pizza de ${nome} com ${bebidaSelecionada}(2L).`;
      const numeroWhatsApp = "5521981091223";
      const url = `https://wa.me/${numeroWhatsApp}?text=${encodeURIComponent(mensagem)}`;

      window.open(url, "_blank");
    });
  });
});
