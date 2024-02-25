<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;


// use ;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class RenderSkillsTableService{

    protected $skills;

    public function __construct($skills) {
        $this->skills = $skills;
    }


    public function getTable ()
    {
        $var = '<table class="table table-striped border mt-2">
        <thead>
            <tr>
                <th scope="col" class="align-middle">#</th>
                <th scope="col" class="align-middle" class="align-middle"> 
                        <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" onclick="getSortedSkills()">
                            Name
                            <svg id="arrowkey" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                            </svg>
                        </span>
                    </th>
                <th scope="col" class="align-middle">Date</th>
                <th scope="col" class="align-middle">Action</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($this->skills as $skill){
            $var .= '<tr>';
            $var .= '<th scope="row" class="align-middle">'.$skill->id.'</th>';

            $var .= '<td class="align-middle"><a href="'. route('admin.skills.show', $skill->id) .'" style="text-decoration: none;"  >'. $skill->name .' </a></td>';
            $var .= '<td class="align-middle">'. $skill->created_at->diffForHumans() .'</td>';
            $var .= '<td class="align-middle">';
            $var .= ' <div style="display: flex;" class="d-flex">';
            $var .= '<a type="button" class="btn btn-primary m-1 d-flex justify-content-center " href="'. route('admin.skills.show', $skill->id) .'" role="button">Show</a>';
            $var .= '<a type="button" class="btn btn-secondary m-1 d-flex justify-content-center " href="'. route('admin.skills.edit', $skill->id) .'" role="button">Edit</a>';
            $var .='<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill text-danger mt-2" viewBox="0 0 16 16"';
            
            $var .= 'onclick="if (confirm('."'Are you sure?'".') == true) {';
            $var .= 'document.getElementById('."'delete-item-".$skill->id."').submit();";
            $var .= 'event.preventDefault();';
            $var .= '} else {';
            $var .= 'return;';
            $var .= '}">';
            $var .= '<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>';
            $var .= '</svg>';
           
            $var .= '<form id="delete-item-'.$skill->id.'" action="'. route('admin.skills.destroy', $skill).'" class="d-none" method="POST">';
            $var .= '<input type="hidden" name="_method" value="DELETE">';
            $var .= '<input type="hidden" name="_token" value="'. csrf_token() .'">';
            $var .= '</form>';

            $var .= '</tr>';
        }            
        $var .= '</tbody>';
        $var .= '</table>';

        return $var;
    }
}