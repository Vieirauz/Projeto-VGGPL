// ------------------
// Validação e envio
// ------------------
async function validarCadastro(event) {
  event?.preventDefault();

  const form = document.getElementById("cadastroForm");
  const erro = document.getElementById("mensagem");
  erro.textContent = "";

  const campos = [
    "nome", "nascimento", "sexo", "nomeMaterno", "cpf", "email",
    "celular", "fixo", "cep", "endereco", "cidade", "estado",
    "login", "senha", "confirmarSenha"
  ];

  const valores = Object.fromEntries(
    campos.map(c => [c, document.getElementById(c)?.value.trim() || ""])
  );

  if (valores.nome.length < 10) return erro.textContent = "Nome inválido.";
  if (!valores.nascimento) return erro.textContent = "Data de nascimento inválida.";
  if (!valores.sexo) return erro.textContent = "Selecione o gênero.";
  if (valores.nomeMaterno.length < 10) return erro.textContent = "Nome materno inválido.";

  if (!validarCPF(valores.cpf.replace(/\D/g, "")))
    return erro.textContent = "CPF inválido.";

  if (valores.senha.length < 6)
    return erro.textContent = "A senha deve ter pelo menos 6 caracteres.";

  if (valores.senha !== valores.confirmarSenha)
    return erro.textContent = "As senhas não coincidem.";

  const formData = new FormData();
  for (const c in valores) formData.append(c, valores[c]);

  try {
    const res = await fetch("salvar_cadastro.php", { method: "POST", body: formData });
    const r = await res.text();

    if (r.includes("✅")) {
      alert("Cadastro realizado com sucesso!");
      form.reset();
      location.href = "login.html";
    } else erro.textContent = r;

  } catch {
    erro.textContent = "Erro ao conectar com o servidor.";
  }
}

// ------------------
// Validação CPF
// ------------------
function validarCPF(cpf) {
  if (!/^\d{11}$/.test(cpf) || /^(\d)\1+$/.test(cpf)) return false;

  const calc = (len) => {
    let soma = 0;
    for (let i = 0; i < len; i++) soma += parseInt(cpf[i]) * (len + 1 - i);
    let r = (soma * 10) % 11;
    return r === 10 ? 0 : r;
  };

  return calc(9) === +cpf[9] && calc(10) === +cpf[10];
}

// ------------------
// Auto CEP
// ------------------
document.getElementById("cep")?.addEventListener("blur", async () => {
  const cep = document.getElementById("cep").value.replace(/\D/g, "");
  if (cep.length !== 8) return;

  try {
    const r = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
    const d = await r.json();
    if (d.erro) return;

    document.getElementById("endereco").value = d.logradouro || "";
    document.getElementById("cidade").value = d.localidade || "";
    document.getElementById("estado").value = d.uf || "";
  } catch {}
});

// ------------------
// Máscaras
// ------------------
document.addEventListener("DOMContentLoaded", () => {
  const opt = { showMaskOnHover: false, showMaskOnFocus: true, jitMasking: true };

  const masks = [
    ["cpf", "999.999.999-99"],
    ["cep", "99999-999"],
    ["celular", "(99) 99999-9999"],
    ["fixo", "(99) 9999-9999"],
  ];

  masks.forEach(([id, mask]) => {
    const el = document.getElementById(id);
    if (el) Inputmask(mask, opt).mask(el);
  });
});
