<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbCheckCommand extends Command
{
    protected $signature = 'db:check';

    protected $description = 'Verificar la conexión a la base de datos';

    public function handle()
    {
        try {
            DB::connection()->getPdo();
            $this->info('Conexión establecida satisfactoriamente.');
        } catch (\Exception $e) {
            $this->error('No se pudo conectar a la base de datos. Por favor, verifica tus credenciales y la configuración de la base de datos.');
        }
    }
}
