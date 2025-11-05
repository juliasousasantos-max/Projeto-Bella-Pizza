document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');

  const nome = document.getElementById('nome');
  const mae = document.getElementById('mae');
  const cpf = document.getElementById('cpf');
  const email = document.getElementById('email');
  const login = document.getElementById('login');
  const senha = document.getElementById('senha');
  const confirmarSenha = document.getElementById('confirmar_senha');
  const contato = document.getElementById('contato');
  const dataNascimento = document.getElementById('data_nascimento');
  const cep = document.getElementById('cep');
  const endereco = document.getElementById('endereco');
  const bairro = document.getElementById('bairro');
  const radiosGenero = document.getElementsByName('sexo');

  // Máscara telefone
  function aplicarMascaraTelefone(value) {
    let numero = value.replace(/\D/g, '');
    if (numero.length > 11) numero = numero.slice(0, 11);
    if (numero.length > 6) {
      return `(${numero.slice(0, 2)}) ${numero.slice(2, 7)}-${numero.slice(7)}`;
    } else if (numero.length > 2) {
      return `(${numero.slice(0, 2)}) ${numero.slice(2)}`;
    } else if (numero.length > 0) {
      return `(${numero}`;
    }
    return '';
  }

  contato.addEventListener('input', (e) => {
    e.target.value = aplicarMascaraTelefone(e.target.value);
  });

  // Máscara e validação de CPF
  function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

    let soma = 0;
    for (let i = 0; i < 9; i++) soma += parseInt(cpf.charAt(i)) * (10 - i);
    let resto = 11 - (soma % 11);
    let dig1 = resto >= 10 ? 0 : resto;

    soma = 0;
    for (let i = 0; i < 10; i++) soma += parseInt(cpf.charAt(i)) * (11 - i);
    resto = 11 - (soma % 11);
    let dig2 = resto >= 10 ? 0 : resto;

    return dig1 === parseInt(cpf.charAt(9)) && dig2 === parseInt(cpf.charAt(10));
  }

  cpf.addEventListener('input', (e) => {
    let valor = e.target.value;
    valor = valor.replace(/\D/g, '').slice(0, 11);
    valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
    valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
    valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = valor;
  });

  // Máscara para CEP: 00000-000
  cep.addEventListener('input', (e) => {
    let valor = e.target.value.replace(/\D/g, '');
    if (valor.length > 8) valor = valor.slice(0, 8);
    valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
    e.target.value = valor;
  });

  // Buscar endereço via CEP e preencher endereço + bairro
  cep.addEventListener('blur', () => {
    const valorCep = cep.value.replace(/\D/g, '');
    if (valorCep.length === 8) {
      fetch(`https://viacep.com.br/ws/${valorCep}/json/`)
        .then(res => res.json())
        .then(data => {
          if (!data.erro) {
            endereco.value = data.logradouro || '';

            let bairroEncontrado = data.bairro;
            let encontrado = false;

            for (let option of bairro.options) {
              if (option.value.toLowerCase() === bairroEncontrado.toLowerCase()) {
                bairro.value = option.value;
                encontrado = true;
                break;
              }
            }

            if (!encontrado) bairro.value = '';
          } else {
            endereco.value = '';
            bairro.value = '';
          }
        })
        .catch(() => {
          // falha silenciosa
        });
    }
  });

  function generoSelecionado() {
    return Array.from(radiosGenero).some(radio => radio.checked);
  }

  // Validação geral no envio
  form.addEventListener('submit', (e) => {
    let erros = [];

    if (!nome.value.trim() || nome.value.trim().length < 3) {
      erros.push('Nome completo inválido.');
      nome.style.borderColor = 'red';
    } else {
      nome.style.borderColor = 'green';
    }

    if (!mae.value.trim() || mae.value.trim().length < 3) {
      erros.push('Nome da mãe inválido.');
      mae.style.borderColor = 'red';
    } else {
      mae.style.borderColor = 'green';
    }

    const cpfLimpo = cpf.value.replace(/\D/g, '');
    if (!validarCPF(cpfLimpo)) {
      erros.push('CPF inválido.');
      cpf.style.borderColor = 'red';
    } else {
      cpf.style.borderColor = 'green';
    }

    if (!email.value.trim() || !email.value.includes('@') || !email.value.includes('.')) {
      erros.push('Email inválido.');
      email.style.borderColor = 'red';
    } else {
      email.style.borderColor = 'green';
    }
    
    if (!login.value.trim() || login.value.length < 4) {
    erros.push('Login deve ter pelo menos 4 caracteres.');
    login.style.borderColor = 'red';
    } else {
    login.style.borderColor = 'green';
    }

    if (senha.value.length < 6) {
      erros.push('A senha deve ter no mínimo 6 caracteres.');
      senha.style.borderColor = 'red';
    } else {
      senha.style.borderColor = 'green';
    }

    if (senha.value !== confirmarSenha.value) {
      erros.push('As senhas não conferem.');
      confirmarSenha.style.borderColor = 'red';
    } else {
      confirmarSenha.style.borderColor = 'green';
    }

    const telNumeros = contato.value.replace(/\D/g, '');
    if (telNumeros.length < 10) {
      erros.push('Telefone inválido.');
      contato.style.borderColor = 'red';
    } else {
      contato.style.borderColor = 'green';
    }

    if (!dataNascimento.value) {
      erros.push('Data de nascimento é obrigatória.');
      dataNascimento.style.borderColor = 'red';
    } else {
      const hoje = new Date();
      const dataNasc = new Date(dataNascimento.value);
      if (dataNasc > hoje) {
        erros.push('Data de nascimento não pode ser no futuro.');
        dataNascimento.style.borderColor = 'red';
      } else {
        dataNascimento.style.borderColor = 'green';
      }
    }

    const cepNumeros = cep.value.replace(/\D/g, '');
    if (!cep.value.trim()) {
      cep.style.borderColor = 'red';
    } else {
      cep.style.borderColor = 'green';
    }

    if (!bairro.value.trim()) {
      erros.push('Selecione um bairro.');
      bairro.style.borderColor = 'red';
    } else {
      bairro.style.borderColor = 'green';
    }

    if (!generoSelecionado()) {
      erros.push('Selecione seu gênero.');
    }

    if (!endereco.value.trim()) {
      erros.push('Endereço obrigatório.');
      endereco.style.borderColor = 'red';
    } else {
      endereco.style.borderColor = 'green';
    }

    if (erros.length > 0) {
      e.preventDefault();
      alert(erros.join('\n'));
    }
  });
});
