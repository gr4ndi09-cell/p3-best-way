<?php
require_once 'db.php';

// Recebe a chamada via requisição POST JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id_turma'], $data['data_aula'], $data['presencas'])) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos ou inválidos.']);
    exit;
}

$id_turma = $data['id_turma'];
$data_aula = $data['data_aula']; // Formato Y-m-d H:i:s
$presencas = $data['presencas']; // Array de [{ id_matricula, situacao }]
$id_usuario = $data['id_usuario'] ?? 'usr-002'; // ID do professor logado

try {
    $pdo->beginTransaction();

    // 1. Busca ou cria a Aula para a turma na data/horário especificado
    $stmtAula = $pdo->prepare("SELECT id_aula FROM aula WHERE id_turma = ? AND inicio = ?");
    $stmtAula->execute([$id_turma, $data_aula]);
    $aula = $stmtAula->fetch();

    if ($aula) {
        $id_aula = $aula['id_aula'];
    } else {
        $id_aula = 'aula-' . uniqid();
        $stmtNovaAula = $pdo->prepare("INSERT INTO aula (id_aula, id_turma, inicio, situacao) VALUES (?, ?, ?, 'EM_REGISTRO')");
        $stmtNovaAula->execute([$id_aula, $id_turma, $data_aula]);
    }

    // 2. Insere/Atualiza as presenças dos alunos
    $stmtPresenca = $pdo->prepare("
        INSERT INTO registro_presenca (id_registro, id_aula, id_matricula, id_registrado_por, situacao)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
            situacao = VALUES(situacao),
            id_registrado_por = VALUES(id_registrado_por),
            versao = versao + 1
    ");

    foreach ($presencas as $p) {
        $id_registro = 'reg-' . uniqid();
        $stmtPresenca->execute([
            $id_registro,
            $id_aula,
            $p['id_matricula'],
            $id_usuario,
            $p['situacao'] // PRESENTE, AUSENTE, JUSTIFICADO
        ]);
    }

    // 3. Atualiza estado da aula para CONCLUIDA
    $stmtConclui = $pdo->prepare("UPDATE aula SET situacao = 'CONCLUIDA', concluida_em = NOW() WHERE id_aula = ?");
    $stmtConclui->execute([$id_aula]);

    $pdo->commit();

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Chamada registrada e sincronizada com sucesso!',
        'id_aula' => $id_aula
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao salvar chamada: ' . $e->getMessage()]);
}
