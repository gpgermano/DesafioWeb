<?php
    namespace Desafio\InfraEstrutura\Persistencia;
    
    use PDO;
    use PDOException;

    class CriaConexao
    {
        public static function criarConexao(): PDO {
            $dsn = 'mysql:host=localhost;dbname=treinamento;charset=utf8';
            $user = 'root';
            $senha = '';
            try {
                $pdo = new PDO($dsn, $user, $senha);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $e) {
                echo ("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        }
    }
?>