<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Conta;

class AtualizarStatusContas extends Command
{
    protected $signature = 'contas:atualizar-status';
    protected $description = 'Atualiza o status das contas vencidas para "Atrasado"';

    public function handle()
    {
        $contas = Conta::where('status', 'Pendente')->get();

        foreach ($contas as $conta) {
            $conta->atualizarStatusSeVencido();
        }

        $this->info('Status das contas vencidas atualizado com sucesso.');
    }
}
