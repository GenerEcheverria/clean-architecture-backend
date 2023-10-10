<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Setup extends Command
{
    protected $signature = 'setup';

    protected $description = 'Configuracion del entorno';

    public function handle()
    {
        $this->info('Copiando .env.example a .env...');
        copy('.env.example', '.env');
        $this->info('.env creado');

        $this->info('Generando clave de cifrado única...');
        Artisan::call('key:generate');
        $this->info('Clave creada');

        $this->info('Generando clave secreta JWT...');
        Artisan::call('jwt:secret');
        $this->info('Clave secreta creada');

        $this->info('Realizando migraciones de la base de datos...');
        Artisan::call('migrate');
        $this->info('Migración completada');

        $this->info('Iniciando el servidor de desarrollo de Laravel...');

        $descriptorspec = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $process = proc_open('php artisan serve', $descriptorspec, $pipes);

        if (is_resource($process)) {
            fclose($pipes[0]);

            while ($line = fgets($pipes[1])) {
                echo $line;
            }

            fclose($pipes[1]);
            fclose($pipes[2]);

            proc_close($process);
        }
    }
}
