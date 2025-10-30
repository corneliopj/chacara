<?php namespace App\Models;

class Receita extends Model {
    protected $table = 'receitas';
    protected $fillable = ['valor', 'data', 'descricao', 'fonte', 'cultura_id', 'item_id'];

    public function save() {
        $pdo = $this->connect();
        $pdo->beginTransaction();

        try {
            // 1. Salva a receita
            $result = parent::save();
            
            // 2. Regra: Se Receita for 'producao', soma receitas_acumuladas na Cultura
            if ($result && $this->fonte === 'producao' && $this->cultura_id) {
                $sql = "UPDATE culturas SET receitas_acumuladas = receitas_acumuladas + :valor WHERE id = :cultura_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['valor' => $this->valor, 'cultura_id' => $this->cultura_id]);
            }
            
            $pdo->commit();
            return $result;

        } catch (\Exception $e) {
            $pdo->rollBack();
            // Em ambiente real, logar o erro
            // echo "Erro ao salvar receita: " . $e->getMessage();
            return false;
        }
    }
}