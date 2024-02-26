<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    
    public function store (Request $request)
    {
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('avatars/tmp/'. $folder, $filename);


            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);

            return $folder;
        }
        
        return '';
    }
}
