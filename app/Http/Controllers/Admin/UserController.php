<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //make it paginated
        // $users = User::with('category','tags')->get();
        $users = User::all();

        return view('admin.users.index', [
            'users' => $users,
            'page' => 'Users List'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = DB::select('select name, id from roles');
        // foreach ($roles as $role){
        //     var_dump($role->name);
        //     dd($role->id);
        // }
        return view('admin.users.create', [
            'page' => 'Creating user',
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ]);
        
        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('users');
        } 

        $role = Role::findById($request->role_id, 'web');
        $user->assignRole($role);
        
        return redirect()->route('admin.users.index')->with('message', 'the user has been created sucessfully');;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->with('projects');
        return view('admin.users.show', [
            'user' => $user,
            'page' => 'Showing User'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = DB::select('select name, id from roles');
        return view('admin.users.edit', [
            'page' => 'Editing user',
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if(!Hash::check($request->old_password, $user->password)){
            return back()->with("message", "old Password Doesn't match!");
        }

        $user->update([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ]);
        
        if ($request->hasFile('image')) {
                $user->clearMediaCollection('articles');
                $user->addMediaFromRequest('image')->toMediaCollection('articles');
        }

        return redirect()->route('admin.users.index')->with('message', 'the user has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('message','the user has been deleted successfully');
    }
}
