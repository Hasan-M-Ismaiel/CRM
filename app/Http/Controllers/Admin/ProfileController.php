<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Integer;

use function PHPUnit\Framework\throwException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //not nessesary now you should throw exception
    public function index()
    {
        // $this->authorize('viewAny', User::class);
        abort(404);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create', User::class);

        if(auth()->user()->profile == null){
            return view('admin.profiles.create', [
                'page' => 'Creating profile',
            ]);
        } else {
            return redirect()->route('admin.profiles.show', auth()->user())->with('message', 'you are already have profile you can edite it');;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileStoreRequest $request)
    {
        //the authorization is in the form request 

        // store the new profile in the database
        $profile = auth()->user()->profile()->create($request->validated());

        //if the user choose image then save it in the database media table
        if ($request->hasFile('image')) {
            $profile->addMediaFromRequest('profileImage')->toMediaCollection('profiles');
        } else {
            //copy the image file from the basic images folder to the folder "avatars" that the media library take from - this because the library delete the image after using it 
            File::copy(public_path('assets/avatars_basic/'.$request->avatar_image.'.jpg'), public_path('assets/avatars/'.$request->avatar_image.'.jpg'));
            
            $pathToFile=public_path('assets/avatars/'.$request->avatar_image.'.jpg');
            $profile->addMedia($pathToFile)->toMediaCollection('profiles');
        }

        return redirect()->route('admin.profiles.show', $profile->user)->with('message', 'the profile has been created sucessfully');;
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        // $this->authorize('view', $user);
        $user = User::findOrFail($id);
        if($user->profile != null){
            $profile = $user->profile()->get()->first();

            return view('admin.profiles.show', [
                'page' => 'Showing Profile',
                'profile' => $profile,
            ]);
        } else {
            return view('admin.profiles.create', [
                'page' => 'You Dont have profile, Create one',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        // $this->authorize('update', $user);
        
        return view('admin.profiles.edit', [
            'page'       => 'Editing profile',
            'profile'    => $profile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        //the authorization is in the form request 
        // store the new profile in the database
        $updatedProfile = $profile->update($request->validated());
        //if the user choose image then save it in the database media table
        if ($request->hasFile('image')) {
            $profile->addMediaFromRequest('profileImage')->toMediaCollection('profiles');
        } else {
            //copy the image file from the basic images folder to the folder "avatars" that the media library take from - this because the library delete the image after using it 
            File::copy(public_path('assets/avatars_basic/'.$request->avatar_image.'.jpg'), public_path('assets/avatars/'.$request->avatar_image.'.jpg'));

            $pathToFile=public_path('assets/avatars/'.$request->avatar_image.'.jpg');
            $profile->clearMediaCollection('profiles');
            $profile->addMedia($pathToFile)->toMediaCollection('profiles');
        }

        return redirect()->route('admin.profiles.show', $profile->user)->with('message', 'the profile has been updated sucessfully');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        // $this->authorize('delete');

        $profile->delete();
        return redirect()->route('admin.profiles.create')->with('message','the profile has been deleted successfully');
    }
}
