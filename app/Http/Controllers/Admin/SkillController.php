<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillStoreRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::all();

        return view('admin.skills.index', [
            'skills' => $skills,
            'page' => 'Skills List',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.skills.create', [
            'page' => 'Creating skill',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkillStoreRequest $request)
    {
        foreach ($request->get('names') as $name) {
            Skill::create([
                'name' => $name
            ]);
        }

        return redirect()->route('admin.skills.index')->with('message', 'the skill/skills has been created sucessfully');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return view('admin.skills.show', [
            'page' => 'Showing skill',
            'skill' => $skill,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', [
            'page'        => 'Editing skill',
            'skill'       => $skill,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkillUpdateRequest $request, Skill $skill)
    {
        $skill->update($request->validated());

        return redirect()->route('admin.skills.index')->with('message', 'the skill has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        $skills = Skill::all();
        if ($skills == null){
            return redirect()->route('admin.skills.create')->with('message','the database does not have any skills please add atleast one');
        }
        return redirect()->route('admin.skills.index')->with('message','the skill has been deleted successfully');
    }
}
