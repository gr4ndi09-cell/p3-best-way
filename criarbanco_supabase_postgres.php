<?php
header('Content-Type: text/html; charset=utf-8');

// Credenciais obtidas no painel do Supabase: Project Settings > Database
$host = 'db.SEU_PROJETO_ID.supabase.co';
$db   = 'postgres'; // O banco de dados padrão no Supabase já vem criado como 'postgres'
$user = 'postgres';
$pass = 'SUA_SENHA_DO_SUPABASE';
$port = '5432';

$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Comandos DDL para criação das tabelas no PostgreSQL (Supabase)
    $sql = "
    CREATE EXTENSION IF NOT EXISTS \"uuid-ossp\";

    CREATE TABLE IF NOT EXISTS usuario (
        id_usuario UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha_hash VARCHAR(255) NOT NULL,
        perfil VARCHAR(20) NOT NULL CHECK (perfil IN ('ADMIN', 'PROFESSOR')),
        ativo BOOLEAN NOT NULL DEFAULT TRUE,
        criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS polo (
        id_polo UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        nome_polo VARCHAR(100) NOT NULL,
        endereco TEXT NOT NULL,
        ativo BOOLEAN NOT NULL DEFAULT TRUE
    );

    CREATE TABLE IF NOT EXISTS professor_polo (
        id_professor UUID NOT NULL REFERENCES usuario(id_usuario),
        id_polo UUID NOT NULL REFERENCES polo(id_polo),
        ativo BOOLEAN NOT NULL DEFAULT TRUE,
        vinculado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id_professor, id_polo)
    );

    CREATE TABLE IF NOT EXISTS turma (
        id_turma UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        id_polo UUID NOT NULL REFERENCES polo(id_polo),
        id_professor UUID NOT NULL REFERENCES usuario(id_usuario),
        nome_turma VARCHAR(100) NOT NULL,
        faixa_etaria VARCHAR(50) NOT NULL,
        horario VARCHAR(50) NOT NULL,
        ativo BOOLEAN NOT NULL DEFAULT TRUE
    );

    CREATE TABLE IF NOT EXISTS aluno (
        id_aluno UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        nome VARCHAR(100) NOT NULL,
        data_nascimento DATE NOT NULL,
        situacao VARCHAR(20) NOT NULL DEFAULT 'ATIVO' CHECK (situacao IN ('ATIVO', 'INATIVO')),
        cadastrado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS matricula_turma (
        id_matricula UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        id_aluno UUID NOT NULL REFERENCES aluno(id_aluno),
        id_turma UUID NOT NULL REFERENCES turma(id_turma),
        data_inicio DATE NOT NULL,
        data_fim DATE NULL,
        situacao VARCHAR(20) NOT NULL DEFAULT 'ATIVA' CHECK (situacao IN ('ATIVA', 'ENCERRADA'))
    );

    CREATE TABLE IF NOT EXISTS aula (
        id_aula UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        id_turma UUID NOT NULL REFERENCES turma(id_turma),
        inicio TIMESTAMP NOT NULL,
        situacao VARCHAR(20) NOT NULL DEFAULT 'PREVISTA' CHECK (situacao IN ('PREVISTA', 'EM_REGISTRO', 'CONCLUIDA', 'CANCELADA')),
        concluida_em TIMESTAMP NULL,
        CONSTRAINT uk_turma_inicio UNIQUE (id_turma, inicio)
    );

    CREATE TABLE IF NOT EXISTS registro_presenca (
        id_registro UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        id_aula UUID NOT NULL REFERENCES aula(id_aula),
        id_matricula UUID NOT NULL REFERENCES matricula_turma(id_matricula),
        id_registrado_por UUID NOT NULL REFERENCES usuario(id_usuario),
        situacao VARCHAR(20) NOT NULL CHECK (situacao IN ('PRESENTE', 'AUSENTE', 'JUSTIFICADO')),
        registrado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        versao INT NOT NULL DEFAULT 1,
        CONSTRAINT uk_aula_matricula UNIQUE (id_aula, id_matricula)
    );

    CREATE TABLE IF NOT EXISTS alteracao_presenca (
        id_alteracao UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        id_registro UUID NOT NULL REFERENCES registro_presenca(id_registro),
        id_autor UUID NOT NULL REFERENCES usuario(id_usuario),
        situacao_anterior VARCHAR(20) NOT NULL CHECK (situacao_anterior IN ('PRESENTE', 'AUSENTE', 'JUSTIFICADO')),
        situacao_nova VARCHAR(20) NOT NULL CHECK (situacao_nova IN ('PRESENTE', 'AUSENTE', 'JUSTIFICADO')),
        alterado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );
    ";

    $pdo->exec($sql);

    echo "<h2 style='color: green;'>Estrutura das tabelas criada com sucesso no Supabase!</h2>";

} catch (PDOException $e) {
    echo "<h2 style='color: red;'>Erro ao conectar ou criar tabelas no Supabase:</h2>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
?>
