<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;


// use ;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class RenderClientsTableService{

    protected $clients;

    public function __construct($clients) {
        $this->clients = $clients;
    }


    public function getTable ()
    {
        $var = '<table class="table table-striped mt-2 border">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" id="getSortedUsers" onclick="getSortedUsers()">
                    Name
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
                <th scope="col">VAT</th>
                <th scope="col"># Projects</th>
                <th scope="col">Address</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>';
        // $iterator = 1;  
        foreach ($this->clients as $client){
            $var .= '<tr>';
            $var .= '<th scope="row" class="align-middle">'.$client->id.'</th>';

            $var .= '<td class="align-middle"><a href="'. route('admin.users.show', $client->id).'" style="text-decoration: none;" >'. $client->name .'</a></td>';
            $var .= '<td class="align-middle">'. $client->VAT .'</td>';
            $var .= '<td class="align-middle">'. $client->numberOfProjects .'</td>';
           
            $var .= '<td class="align-middle">'.substr($client->address, 0, 15).'...</td>';


            $var .= '<td class="align-middle">';
            $var .= '<div style="display: flex;">';
            $var .= '<a type="button" class="btn btn-primary m-1" href="'. route('admin.clients.show', $client->id) .'" role="button">Show</a>';
            $var .= '<a type="button" class="btn btn-secondary m-1" href="'.route('admin.clients.edit', $client->id) .'" role="button">Edit</a>';
            
            $var .='<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill text-danger mt-2" viewBox="0 0 16 16"';
            $var .= 'onclick="if (confirm('."'Are you sure?'".') == true) {';
            $var .= 'document.getElementById('."'delete-item-".$client->id."').submit();";
            $var .= 'event.preventDefault();';
            $var .= '} else {';
            $var .= 'return;';
            $var .= '}">';
            $var .= '<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>';
            $var .= '</svg>';
           
            $var .= '<form id="delete-item-'.$client->id.'" action="'. route('admin.clients.destroy', $client).'" class="d-none" method="POST">';
            $var .= '<input type="hidden" name="_method" value="DELETE">';
            $var .= '<input type="hidden" name="_token" value="'. csrf_token() .'">';
            $var .= '</form>';
            $var .= '</div>';
            $var .= '</td>';
            $var .= '</tr>';
        }            

        $var .= '</tbody>';
        $var .= '</table>';

        return $var;
    }
}