<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        $role = Role::create(['name' => 'Administrator']);
        $role = Role::create(['name' => 'Estudiante']);

        // Creación del usuario administrador
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'administrador@admin.com',
            'password' => bcrypt('12345678')
        ]);
        $user->save();
        // Asignación del rol
        $user->assignRole('Administrator');
    }
}
