<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // admin area
        // generate admin permissions
         $adminPermissions = [
            'user_create',
            'user_edit',
            'user_show',
            'user_delete',
            'user_access',
            'project_create',
            'project_edit',
            'project_show',
            'project_delete',
            'project_access',
            'client_create',
            'client_edit',
            'client_show',
            'client_delete',
            'client_access',
            'task_create',
            'task_edit',
            'task_show',
            'task_delete',
            'task_access',
        ];

        foreach ($adminPermissions as $adminPermission)   {
            Permission::create([
                'name' => $adminPermission
            ]);
        }

        //create admin role
        $adminRole = Role::create(['name' => 'admin']);

        //create user role 
        $adminUser = User::create([
            'name' => 'hasan',
            'email' => 'test@gmail.com',
            'password' => Hash::make('1234567890')
        ]);

        //assign permissions to the adminRole
        $adminPermissions = Permission::pluck('id', 'id')->all();
        $adminRole->syncPermissions($adminPermissions);
        
        //assing the role to the admin user
        $adminUser->assignRole([$adminRole->id]);

        // dd($adminUser->getRoleNames());
        //user area
        //generate user permissions
        $userPermissions = [
            'project_show',
            'task_create',
            'task_edit',
            'task_show',
            'task_delete',
            'task_access',
        ];
        
        //create user role
        $userRole = Role::create(['name' => 'user']);

        foreach ($userPermissions as $userPermission)   {
            $userRole->givePermissionTo($userPermission);
        }

        $users = User::factory()->times(10)->create();
        foreach ( $users as $user){
            $user->assignRole($userRole);
        }

        Project::factory()->times(10)->create();
        Task::factory()->times(10)->create();
        Client::factory()->times(10)->create();
        
    }
}
