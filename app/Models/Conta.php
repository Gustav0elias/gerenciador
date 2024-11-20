<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;
    protected $fillable = [
        'descricao',
        'valor',
        'data_vencimento',
        'status',
        'tipo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function atualizarStatusSeVencido()
    {
        if ($this->data_vencimento->isPast() && $this->status === 'Pendente') {
            $this->status = 'Atrasado';
            $this->save();
        }
    }
}
