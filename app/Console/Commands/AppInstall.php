<?php

namespace App\Console\Commands;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Console\Command;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->alert('Danger! Read carefully!');
        $this->comment('If you choose to continue, the database will be deleted (if it has filled) and new data will be recorded.');
        if (!$this->confirm('You wish to continue with that?', false)) {
            $this->alert('Canceled!');
            return 0;
        }

        $installationMode = $this->choice('Installation mode', ['development', 'production']);
        $this->comment('You are installing in ' . $installationMode . ' mode');

        $seeders = [
            \Database\Seeders\RoleAndPermissionSeeder::class
        ];

        $super = null;
        $admin = null;

        if ($installationMode == 'development') {
            if ($this->confirm('Generate fake users?', true)) {
                $seeders[] = \Database\Seeders\UsersSeeder::class;
            }
        }

        $this->comment('Installing...');
        $this->call('key:generate');
        $this->call('storage:link');
        $this->call('key:generate');
        $this->call('migrate');
        $this->call('migrate:fresh');
        $this->call('db:seed');

        $super = $this->getSuperuser($installationMode === 'production');
        $admin = $installationMode == 'development' ?
            $admin = $this->getAdminuser() :
            null;

        // Run seeders
        foreach ($seeders as $seeder) {
            $this->call('db:seed', [
                '--class' => $seeder
            ]);
        }

        // User roles
        $super->assignRole(RolesEnum::SUPERUSER->value);
        $admin ? $admin->assignRole(RolesEnum::ADMINUSER->value) : null;

        $this->info('Instalação concluída!');
    }

    /**
     * Get Superuser for production or development installation
     * @param bool $toProduction
     * @return User
     */
    private function getSuperuser(bool $toProduction = false): User
    {
        $data = [
            'first_name' => 'Super',
            'last_name' => 'User',
            'username' => 'superuser',
            'gender' => null,
            'email' => 'super@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        if ($toProduction) {
            $data['password'] = '';
            $data['email'] = $this->ask('Enter a valid e-mail');

            $validPass = false;
            do {
                $data['password'] = $this->secret('Passsword');
                $data['password_confirmation'] = $this->secret('Confirm your passsword');

                $validPass = $data['password'] === $data['password_confirmation'];
                if (!$validPass) {
                    $this->error('Password not match! Try again.');
                }
            } while (!$validPass);
        }

        unset($data['password_confirmation']);

        return User::create($data);
    }

    /**
     * Get adminuser
     * @return User
     */
    private function getAdminuser(): User
    {
        return User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'Admin User',
            'gender' => 'male',
            'email' => 'admin@mail.com',
            'password' => 'password'
        ]);
    }
}
