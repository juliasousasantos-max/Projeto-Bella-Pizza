document.addEventListener('DOMContentLoaded', function () {
  const emailForm = document.getElementById('form-email');
  const senhaForm = document.getElementById('form-senha');
  const boxEmail = document.getElementById('box-email');
  const boxSenha = document.getElementById('box-senha');
  const boxSucesso = document.getElementById('box-sucesso');

  emailForm.addEventListener('submit', function (e) {
    e.preventDefault();
    // Aqui você pode validar o email 
    boxEmail.classList.add('hidden');
    boxSenha.classList.remove('hidden');
  });

  senhaForm.addEventListener('submit', function (e) {
    e.preventDefault();
    // Aqui você pode validar a senha 
    boxSenha.classList.add('hidden');
    boxSucesso.classList.remove('hidden');
  });
});