<?php
header('Content-Type: text/html; charset=utf-8');

$host = 'localhost';
$user = 'root';
$pass = ''; // Senha padrão do XAMPP é vazia
$dbName = 'bestway_chamada';

try {
    // 1. Conecta ao servidor MySQL sem selecionar banco específico para criá-lo
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // 2. Cria o banco de dados e seleciona
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `$dbName`;");

    // 3. Comandos DDL para criação das tabelas
    $sql = "
    CREATE TABLE IF NOT EXISTS usuario (
        id_usuario VARCHAR(36) PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha_hash VARCHAR(255) NOT NULL,
        perfil ENUM('ADMIN', 'PROFESSOR') NOT NULL,
        ativo BOOLEAN NOT NULL DEFAULT TRUE,
        criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;

    CREATE TABLE IF NOT EXISTS polo (
        id_polo VARCHAR(36) PRIMARY KEY,
        nome_polo VARCHAR(100) NOT NULL,
        endereco TEXT NOT NULL,
        ativo BOOLEAN NOT NULL DEFAULT TRUE
    ) ENGINE=InnoDB;

    CREATE TABLE IF NOT EXISTS professor_polo (
        id_professor VARCHAR(36) NOT NULL,
        id_polo VARCHAR(36) NOT NULL,
        ativo BOOLEAN NOT NULL DEFAULT TRUE,
        vinculado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id_professor, id_polo),
        FOREIGN KEY (id_professor) REFERENCES usuario(id_usuario),
        FOREIGN KEY (id_polo) REFERENCES polo(id_polo)
    ) ENGINE=InnoDB;

    CREATE TABLE IF NOT EXISTS turma (
        id_turma VARCHAR(36) PRIMARY KEY,
        id_polo VARCHAR(36) NOT NULL,
        id_professor VARCHAR(36) NOT NULL,
        nome_turma VARCHAR(100) NOT NULL,
        faixa_etaria VARCHAR(50) NOT NULL,
        horario VARCHAR(50) NOT NULL,
        ativo BOOLEAN NOT NULL DEFAULT TRUE,
        FOREIGN KEY (id_polo) REFERENCES polo(id_polo),
        FOREIGN KEY (id_professor) REFERENCES usuario(id_usuario)
    ) ENGINE=InnoDB;

    CREATE TABLE IF NOT EXISTS aluno (
        id_aluno VARCHAR(36) PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        data_nascimento DATE NOT NULL,
        situacao ENUM('ATIVO', 'INATIVO') NOT NULL DEFAULT 'ATIVO',
        cadastrado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;

    CREATE TABLE IF NOT EXISTS matricula_turma (
        id_matricula VARCHAR(36) PRIMARY KEY,
        id_aluno VARCHAR(36) NOT NULL,
        id_turma VARCHAR(36) NOT NULL,
        data_inicio DATE NOT NULL,
        data_fim DATE NULL,
        situacao ENUM('ATIVA', 'ENCERRADA') NOT NULL DEFAULT 'ATIVA',
        FOREIGN KEY (id_aluno) REFERENCES aluno(id_aluno),
        FOREIGN KEY (id_turma) REFERENCES turma(id_turma)
    ) ENGINE=InnoDB;

    CREATE TABLE IF NOT EXISTS aula (
        id_aula VARCHAR(36) PRIMARY KEY,
        id_turma VARCHAR(36) NOT NULL,
        inicio DATETIME NOT NULL,
        situacao ENUM('PREVISTA', 'EM_REGISTRO', 'CONCLUIDA', 'CANCELADA') NOT NULL DEFAULT 'PREVISTA',
        concluida_em DATETIME NULL,
        UNIQUE KEY uk_turma_inicio (id_turma, inicio),
        FOREIGN KEY (id_turma) REFERENCES turma(id_turma)
    ) ENGINE=InnoDB;

    CREATE TABLE IF NOT EXISTS registro_presenca (
        id_registro VARCHAR(36) PRIMARY KEY,
        id_aula VARCHAR(36) NOT NULL,
        id_matricula VARCHAR(36) NOT NULL,
        id_registrado_por VARCHAR(36) NOT NULL,
        situacao ENUM('PRESENTE', 'AUSENTE', 'JUSTIFICADO') NOT NULL,
        registrado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        versao INT NOT NULL DEFAULT 1,
        UNIQUE KEY uk_aula_matricula (id_aula, id_matricula),
        FOREIGN KEY (id_aula) REFERENCES aula(id_aula),
        FOREIGN KEY (id_matricula) REFERENCES matricula_turma(id_matricula),
        FOREIGN KEY (id_registrado_por) REFERENCES usuario(id_usuario)
    ) ENGINE=InnoDB;

    CREATE TABLE IF NOT EXISTS alteracao_presenca (
        id_alteracao VARCHAR(36) PRIMARY KEY,
        id_registro VARCHAR(36) NOT NULL,
        id_autor VARCHAR(36) NOT NULL,
        situacao_anterior ENUM('PRESENTE', 'AUSENTE', 'JUSTIFICADO') NOT NULL,
        situacao_nova ENUM('PRESENTE', 'AUSENTE', 'JUSTIFICADO') NOT NULL,
        alterado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_registro) REFERENCES registro_presenca(id_registro),
        FOREIGN KEY (id_autor) REFERENCES usuario(id_usuario)
    ) ENGINE=InnoDB;
    ";

    $pdo->exec($sql);

    // 4. Carga inicial (INSERT IGNORE evita erro se o script for rodado mais de uma vez)
    $senhaPadrao = password_hash('admin123', PASSWORD_DEFAULT);

    $seed = "
    INSERT IGNORE INTO usuario (id_usuario, nome, email, senha_hash, perfil) VALUES 
    ('usr-001', 'Coordenação Best Way', 'admin@bestway.org', '$senhaPadrao', 'ADMIN'),
    ('usr-002', 'Mestre Roberto', 'prof.roberto@bestway.org', '$senhaPadrao', 'PROFESSOR');

    INSERT IGNORE INTO polo (id_polo, nome_polo, endereco) VALUES 
    ('polo-001', 'Sede Itatinga', 'Rua Benedito Pedro dos Santos, nº 310, Itatinga'),
    ('polo-002', 'Núcleo Boraceia', 'Comunidade de Boraceia'),
    ('polo-003', 'Núcleo Barequeçaba', 'Comunidade de Barequeçaba'),
    ('polo-004', 'Núcleo Morro do Abrigo', 'Comunidade Morro do Abrigo'),
    ('polo-005', 'Núcleo Enseada', 'Comunidade da Enseada');

    INSERT IGNORE INTO professor_polo (id_professor, id_polo) VALUES 
    ('usr-002', 'polo-001');

    INSERT IGNORE INTO turma (id_turma, id_polo, id_professor, nome_turma, faixa_etaria, horario) VALUES 
    ('turma-001', 'polo-001', 'usr-002', 'Jiu-Jitsu Infantil - Manhã', '6 a 12 anos', '09:00 - 10:30');

    INSERT IGNORE INTO aluno (id_aluno, nome, data_nascimento) VALUES 
    ('aln-001', 'Gabriel Santos', '2014-05-12'),
    ('aln-002', 'Lucas Silva', '2015-08-20'),
    ('aln-003', 'Beatriz Oliveira', '2013-11-03');

    INSERT IGNORE INTO matricula_turma (id_matricula, id_aluno, id_turma, data_inicio) VALUES 
    ('mat-001', 'aln-001', 'turma-001', '2026-02-01'),
    ('mat-002', 'aln-002', 'turma-001', '2026-02-01'),
    ('mat-003', 'aln-003', 'turma-001', '2026-02-01');
    ";

    $pdo->exec($seed);

    echo "<h2 style='color: green;'>Banco de dados Localhost ($dbName) e tabelas criados com sucesso!</h2>";
    echo "<p>Login de teste: <strong>admin@bestway.org</strong> | Senha: <strong>admin123</strong></p>";

} catch (PDOException $e) {
    echo "<h2 style='color: red;'>Erro ao criar banco Localhost:</h2>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
?>
