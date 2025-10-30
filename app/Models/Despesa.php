<?php namespace App\Models;

class Despesa extends Model {
    protected $table = 'despesas';
    protected $fillable = ['valor', 'data', 'descricao', 'tipo', 'cultura_id'];
    
    public function save() {
        $pdo = $this->connect();
        $pdo->beginTransaction();

        try {
            // 1. Salva a despesa
            $result = parent::save();
            
            // 2. Regra: Se Despesa for tipo 'cultura', soma gastos_acumulados na Cultura
            if ($result && $this->tipo === 'cultura' && $this->cultura_id) {
                // A despesa geral já deve ter sido criada antes do save, mas aqui vamos simular
                // a lógica de atualização da cultura. No Controller a despesa geral será inserida.
                
                $sql = "UPDATE culturas SET gastos_acumulados = gastos_acumulados + :valor WHERE id = :cultura_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['valor' => $this->valor, 'cultura_id' => $this->cultura_id]);
            }
            
            $pdo->commit();
            return $result;

        } catch (\Exception $e) {
            $pdo->rollBack();
            // Em ambiente real, logar o erro
            // echo "Erro ao salvar despesa: " . $e->getMessage();
            return false;
        }
    }
    // ... (demais métodos do Model Base)
}