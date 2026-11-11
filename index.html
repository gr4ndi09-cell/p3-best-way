<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chamada Eletrônica Web - Projeto Social Best Way</title>
  <style>
    /* Estilo Visual Claro + Glassmorphism */
    :root {
      --bg-gradient: linear-gradient(135deg, #eef2f3 0%, #8e9eab 100%);
      --glass-bg: rgba(255, 255, 255, 0.55);
      --glass-border: rgba(255, 255, 255, 0.8);
      --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.12);
      --primary-red: #d92525;
      --primary-blue: #1c3b68;
      --text-dark: #2c3e50;
      --success: #28a745;
      --warning: #ffc107;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    body {
      background: var(--bg-gradient);
      min-height: 100vh;
      color: var(--text-dark);
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
    }

    /* Container Principal */
    .container {
      width: 100%;
      max-width: 900px;
    }

    /* Header Glassmorphism */
    header {
      background: var(--glass-bg);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
      border-radius: 16px;
      padding: 20px;
      text-align: center;
      margin-bottom: 20px;
    }

    header h1 {
      color: var(--primary-red);
      font-size: 1.8rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    header p {
      color: var(--primary-blue);
      font-weight: 600;
      margin-top: 5px;
    }

    /* Status de Conexão */
    .status-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(8px);
      border-radius: 12px;
      padding: 10px 20px;
      margin-bottom: 20px;
      border: 1px solid var(--glass-border);
      font-size: 0.9rem;
    }

    .badge {
      padding: 5px 12px;
      border-radius: 20px;
      color: #fff;
      font-weight: bold;
    }

    .badge-online { background-color: var(--success); }
    .badge-offline { background-color: var(--primary-red); }

    /* Cards Glassmorphism */
    .glass-card {
      background: var(--glass-bg);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
      border-radius: 16px;
      padding: 24px;
      margin-bottom: 20px;
    }

    .card-title {
      color: var(--primary-blue);
      margin-bottom: 15px;
      font-size: 1.3rem;
      border-bottom: 2px solid var(--primary-red);
      padding-bottom: 5px;
      display: inline-block;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label { display: block; font-weight: bold; margin-bottom: 5px; color: var(--primary-blue); }

    select, input {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      background: rgba(255, 255, 255, 0.9);
      font-size: 1rem;
    }

    /* Tabela de Alunos */
    .table-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
    }

    th {
      background: rgba(28, 59, 104, 0.1);
      color: var(--primary-blue);
    }

    tr {
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    /* Botoes de Presença Customizados */
    .btn-group {
      display: flex;
      gap: 8px;
    }

    .btn-radio {
      padding: 8px 14px;
      border-radius: 6px;
      border: 1px solid #ccc;
      background: #fff;
      cursor: pointer;
      font-size: 0.85rem;
      font-weight: bold;
      transition: all 0.2s;
    }

    .btn-radio.selected-p { background: var(--success); color: #fff; border-color: var(--success); }
    .btn-radio.selected-a { background: var(--primary-red); color: #fff; border-color: var(--primary-red); }
    .btn-radio.selected-j { background: var(--warning); color: #333; border-color: var(--warning); }

    /* Botão Principal */
    .btn-submit {
      width: 100%;
      padding: 14px;
      background: var(--primary-blue);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 20px;
      transition: background 0.3s;
    }

    .btn-submit:hover {
      background: #122746;
    }

    @media (max-width: 600px) {
      .btn-group { flex-direction: column; }
    }
  </style>
</head>
<body>

<div class="container">
  <header>
    <h1>Best Way Jiu-Jitsu</h1>
    <p>Chamada Eletrônica Web — Formando Jovens de Caráter</p>
  </header>

  <div class="status-bar">
    <span>Status da Conexão: <span id="connection-status" class="badge badge-online">Online</span></span>
    <span>Pendências Offline: <strong id="pending-count">0</strong></span>
  </div>

  <section class="glass-card">
    <h2 class="card-title">1. Seleção da Turma</h2>
    <div class="form-group">
      <label for="select-turma">Turma / Polo:</label>
      <select id="select-turma">
        <option value="turma-001">Sede Itatinga — Jiu-Jitsu Infantil (09:00 - 10:30)</option>
      </select>
    </div>
    <div class="form-group">
      <label for="data-aula">Data da Aula:</label>
      <input type="datetime-local" id="data-aula">
    </div>
  </section>

  <section class="glass-card">
    <h2 class="card-title">2. Lista de Chamada</h2>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nome do Aluno</th>
            <th>Frequência</th>
          </tr>
        </thead>
        <tbody id="alunos-list">
          <!-- Alunos renderizados via JS -->
        </tbody>
      </table>
    </div>

    <button class="btn-submit" onclick="salvarChamada()">Finalizar e Salvar Chamada</button>
  </section>
</div>

<script>
  // Dados de simulação
  const alunosMock = [
    { id_matricula: 'mat-001', nome: 'Gabriel Santos' },
    { id_matricula: 'mat-002', nome: 'Lucas Silva' },
    { id_matricula: 'mat-003', nome: 'Beatriz Oliveira' }
  ];

  const chamadasEstado = {};

  // Inicialização da tela
  document.addEventListener('DOMContentLoaded', () => {
    // Seta data atual no input
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('data-aula').value = now.toISOString().slice(0, 16);

    renderizarAlunos();
    atualizarStatusRede();
    verificarPendencias();

    window.addEventListener('online', () => { atualizarStatusRede(); sincronizarPendencias(); });
    window.addEventListener('offline', () => { atualizarStatusRede(); });
  });

  function renderizarAlunos() {
    const tbody = document.getElementById('alunos-list');
    tbody.innerHTML = '';

    alunosMock.forEach(aluno => {
      chamadasEstado[aluno.id_matricula] = null; // Inicializa sem seleção

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td><strong>${aluno.nome}</strong></td>
        <td>
          <div class="btn-group">
            <button class="btn-radio" onclick="setPresenca('${aluno.id_matricula}', 'PRESENTE', this)">P</button>
            <button class="btn-radio" onclick="setPresenca('${aluno.id_matricula}', 'AUSENTE', this)">A</button>
            <button class="btn-radio" onclick="setPresenca('${aluno.id_matricula}', 'JUSTIFICADO', this)">J</button>
          </div>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  function setPresenca(idMatricula, situacao, btnElement) {
    chamadasEstado[idMatricula] = situacao;
    const parent = btnElement.parentElement;
    Array.from(parent.children).forEach(b => b.className = 'btn-radio');

    if (situacao === 'PRESENTE') btnElement.classList.add('selected-p');
    if (situacao === 'AUSENTE') btnElement.classList.add('selected-a');
    if (situacao === 'JUSTIFICADO') btnElement.classList.add('selected-j');
  }

  function salvarChamada() {
    // Validação de preenchimento completo (RF008)
    const pendentes = Object.values(chamadasEstado).some(val => val === null);
    if (pendentes) {
      alert('Por favor, marque a situação de todos os alunos antes de salvar.');
      return;
    }

    const payload = {
      id_turma: document.getElementById('select-turma').value,
      data_aula: document.getElementById('data-aula').value.replace('T', ' ') + ':00',
      presencas: Object.keys(chamadasEstado).map(id => ({
        id_matricula: id,
        situacao: chamadasEstado[id]
      }))
    };

    if (navigator.onLine) {
      enviarParaServidor(payload);
    } else {
      salvarOffline(payload);
    }
  }

  function enviarParaServidor(payload) {
    fetch('api_chamada.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
      if (data.sucesso) {
        alert(data.mensagem);
      } else {
        alert('Erro do Servidor: ' + data.mensagem);
        salvarOffline(payload);
      }
    })
    .catch(() => {
      salvarOffline(payload);
    });
  }

  function salvarOffline(payload) {
    const pendentes = JSON.parse(localStorage.getItem('chamadas_pendentes') || '[]');
    pendentes.push(payload);
    localStorage.setItem('chamadas_pendentes', JSON.stringify(pendentes));
    alert('Conexão instável! A chamada foi salva LOCALMENTE no dispositivo e será sincronizada assim que a conexão retornar.');
    verificarPendencias();
  }

  function verificarPendencias() {
    const pendentes = JSON.parse(localStorage.getItem('chamadas_pendentes') || '[]');
    document.getElementById('pending-count').innerText = pendentes.length;
  }

  function sincronizarPendencias() {
    const pendentes = JSON.parse(localStorage.getItem('chamadas_pendentes') || '[]');
    if (pendentes.length === 0) return;

    Promise.all(pendentes.map(item => {
      return fetch('api_chamada.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(item)
      }).then(r => r.json());
    })).then(() => {
      localStorage.removeItem('chamadas_pendentes');
      verificarPendencias();
      alert('Todas as chamadas pendentes salvas offline foram sincronizadas com sucesso!');
    });
  }

  function atualizarStatusRede() {
    const status = document.getElementById('connection-status');
    if (navigator.onLine) {
      status.innerText = 'Online';
      status.className = 'badge badge-online';
    } else {
      status.innerText = 'Offline';
      status.className = 'badge badge-offline';
    }
  }
</script>

</body>
</html>
