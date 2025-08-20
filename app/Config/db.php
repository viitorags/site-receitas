<?php

/**
 * Classe de conexão com o banco
 *
 * @method PDOStatement query(string $query)
 * @method PDOStatement prepare(string $query, array $options = [])
 * @method int exec(string $statement)
 * @method string quote(string $string, int $parameter_type = PDO::PARAM_STR)
 */
class Database
{
    private $db;

    public function __construct()
    {
        $dbHost = getenv("DB_HOST");
        $dbPort = getenv("DB_PORT") ?: 3306;
        $dbName = getenv("DB_NAME");
        $dbUser = getenv("DB_USER");
        $dbPassword = getenv("DB_PASS");

        try {
            $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
            $this->db = new PDO($dsn, $dbUser, $dbPassword);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $err) {
            echo "Erro na conexão: " . $err->getMessage();
            $this->db = null;
            return;
        }
    }

    public function __call($method, $args)
    {
        if ($this->db === null) {
            throw new Exception("Banco de dados não conectado.");
        }
        return call_user_func_array([$this->db, $method], $args);
    }
}
