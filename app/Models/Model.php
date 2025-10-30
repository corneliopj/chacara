<?php namespace App\Models;

abstract class Model {
    protected $table;
    protected $fillable = [];
    public $attributes = [];

    protected function connect() {
        try {
            return new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        } catch (\PDOException $e) {
            die("Erro de Conexão: " . $e->getMessage());
        }
    }

    public function __construct(array $data = []) {
        $this->attributes = $data;
    }

    public function __set($name, $value) {
        $this->attributes[$name] = $value;
    }

    public function __get($name) {
        return $this->attributes[$name] ?? null;
    }

    public static function all() {
        $instance = new static();
        $pdo = $instance->connect();
        $stmt = $pdo->prepare("SELECT * FROM {$instance->table}");
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Converte resultados para objetos do Model
        return array_map(function($data) {
            return new static($data);
        }, $results);
    }
    
    public static function find($id) {
        $instance = new static();
        $pdo = $instance->connect();
        $stmt = $pdo->prepare("SELECT * FROM {$instance->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $data ? new static($data) : null;
    }

    public function save() {
        $pdo = $this->connect();
        $fields = array_intersect_key($this->attributes, array_flip($this->fillable));
        
        if (isset($this->attributes['id']) && $this->attributes['id']) {
            // Update
            $set_clauses = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($fields)));
            $sql = "UPDATE {$this->table} SET {$set_clauses} WHERE id = :id";
            $fields['id'] = $this->attributes['id'];
        } else {
            // Insert
            $keys = implode(', ', array_keys($fields));
            $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($fields)));
            $sql = "INSERT INTO {$this->table} ({$keys}) VALUES ({$placeholders})";
        }

        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($fields);

        if ($result && !isset($this->attributes['id'])) {
            $this->attributes['id'] = $pdo->lastInsertId();
        }
        return $result;
    }
    
    // Método update: no Laravel é o mesmo que save() após a modificação das propriedades, 
    // mas aqui o save() já faz o trabalho de INSERT/UPDATE.
    public function update(array $data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this->save();
    }
    
    // Adiciona um método genérico para consultas complexas (necessário para os Controllers)
    public static function query($sql, $params = []) {
        $instance = new static();
        $pdo = $instance->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}