// ===============================
// 📋 Função principal de validação e envio
// ===============================
async function validarCadastro(event) {
  if (event) event.preventDefault(); // evita submit automático

  const form = document.getElementById("cadastroForm");
  const erro = document.getElementById("mensagem");
  erro.textContent = "";

  const campos = [
    "nome", "nascimento", "sexo", "nomeMaterno", "cpf", "email",
    "celular", "fixo", "cep", "endereco", "cidade", "estado",
    "login", "senha", "confirmarSenha"
  ];

  const valores = {};
  campos.forEach(c => valores[c] = document.getElementById(c)?.value.trim() || "");

  // === Validações ===
  if (valores.nome.length < 10) { erro.textContent = "Nome inválido."; return; }
  if (!valores.nascimento) { erro.textContent = "Data de nascimento inválida."; return; }
  if (!valores.sexo) { erro.textContent = "Selecione o gênero."; return; }
  if (valores.nomeMaterno.length < 10) { erro.textContent = "Nome materno inválido."; return; }

  const cpfNum = valores.cpf.replace(/\D/g, "");
  if (!validarCPF(cpfNum)) { erro.textContent = "CPF inválido."; return; }

  if (valores.senha.length < 6) {
    erro.textContent = "A senha deve ter pelo menos 6 caracteres.";
    return;
  }

  if (valores.senha !== valores.confirmarSenha) {
    erro.textContent = "As senhas não coincidem.";
    return;
  }

  // === Montar envio para o PHP ===
  const formData = new FormData();
  for (const campo in valores) {
    formData.append(campo, valores[campo]);
  }

  try {
    const resposta = await fetch("salvar_cadastro.php", {
      method: "POST",
      body: formData
    });

    const resultado = await resposta.text();

    if (resultado.includes("✅")) {
      alert("Cadastro realizado com sucesso!");
      form.reset();
      window.location.href = "login.html";
    } else {
      erro.textContent = resultado;
    }

  } catch (e) {
    erro.textContent = "Erro ao conectar com o servidor.";
  }
}

// ===============================
// ✅ Validação de CPF
// ===============================
function validarCPF(cpf) {
  cpf = cpf.replace(/\D/g, "");

  if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

  let soma = 0;
  for (let i = 0; i < 9; i++) soma += parseInt(cpf.charAt(i)) * (10 - i);
  let resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.charAt(9))) return false;

  soma = 0;
  for (let i = 0; i < 10; i++) soma += parseInt(cpf.charAt(i)) * (11 - i);
  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;

  return resto === parseInt(cpf.charAt(10));
}

// ===============================
// 🏠 Auto preenchimento de endereço pelo CEP
// ===============================
document.getElementById("cep")?.addEventListener("blur", async () => {
  const cep = document.getElementById("cep").value.replace(/\D/g, "");
  if (cep.length !== 8) return;

  try {
    const resposta = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
    const dados = await resposta.json();

    if (dados.erro) return;

    document.getElementById("endereco").value = dados.logradouro || "";
    document.getElementById("cidade").value = dados.localidade || "";
    document.getElementById("estado").value = dados.uf || "";

  } catch (e) {
    console.error("Erro ao buscar CEP:", e);
  }
});

// ===============================
// 🎭 Máscaras automáticas (sem alterar o design)
// ===============================
document.addEventListener("DOMContentLoaded", () => {
  const maskOptions = {
    showMaskOnHover: false,
    showMaskOnFocus: true,
    jitMasking: true,
    clearIncomplete: false,
    placeholder: "",
  };

  // CPF
  const cpfInput = document.getElementById("cpf");
  if (cpfInput) Inputmask("999.999.999-99", maskOptions).mask(cpfInput);

  // CEP
  const cepInput = document.getElementById("cep");
  if (cepInput) Inputmask("99999-999", maskOptions).mask(cepInput);

  // Celular
  const celularInput = document.getElementById("celular");
  if (celularInput) Inputmask("(99) 99999-9999", maskOptions).mask(celularInput);

  // Telefone fixo
  const fixoInput = document.getElementById("fixo");
  if (fixoInput) Inputmask("(99) 9999-9999", maskOptions).mask(fixoInput);
});
