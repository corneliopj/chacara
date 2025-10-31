<?php namespace App\Models;
// app/Models/Inventario.php
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    protected $fillable = ['item', 'quantidade', 'valor_unitario'];
}