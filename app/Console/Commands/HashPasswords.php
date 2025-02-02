<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HashPasswords extends Command
{
    protected $signature = 'hash:passwords';
    protected $description = 'Criptografar senhas existentes no banco de dados';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            if (!Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password);
                $user->save();
                $this->info("Senha do usuário {$user->email} atualizada.");
            }
        }

        $this->info('Todas as senhas foram criptografadas com sucesso.');
    }
}
