<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'user_create',  //create page
            'user_edit',    // edit page
            'user_show',    // show
            'user_delete',  // destroy method
            'user_access',  // index page - method
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
            'assign_project_to_user',
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
            'project_access',
            // 'task_create',
            // 'task_edit',
            'task_show',
            // 'task_delete',
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

        Client::factory()->times(10)->create();
        Project::factory()->times(10)->create();
        Task::factory()->times(10)->create();
        Profile::factory()->times(11)->create();

        //for the pivot table
        for ($i=0; $i < 10 ; $i++){
            DB::table('project_user')->insert([
                'user_id' => rand(1, 11),
                'project_id' => rand(1, 10),
            ]);
        }

        //if you done want to use factory
        Skill::create([
            'name' => 'java',
        ]);

        Skill::create([
            'name' => 'c++',
        ]);
        Skill::create([
            'name' => 'laravel',
        ]);
        Skill::create([
            'name' => 'php',
        ]);
        Skill::create([
            'name' => 'python',
        ]);
        Skill::create([
            'name' => 'english',
        ]);

        
    }
}
