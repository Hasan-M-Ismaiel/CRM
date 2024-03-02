<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTodoListReqeust;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    


    public function updateTodos ()
    {
        //all skills from database to compare with 

        $checked_old_todos = request()->checked_old_todos;
        $new_todos = request()->new_todos;
        $new_todos_dates = request()->new_todos_dates;
        $user_id = request()->user_id;

        if($checked_old_todos!=null){
            foreach($checked_old_todos as $checked_old_todo){
                $todo = Todo::find($checked_old_todo);
                $todo->status="done";
                $todo->save();
            }
        }
        
        if($new_todos != null && $new_todos_dates != null && sizeof($new_todos) == sizeof($new_todos_dates)){
            for($i=0 ;  $i<sizeof($new_todos); $i++){
                if($new_todos_dates[$i]>now()){
                    Todo::create([
                        'user_id' => $user_id,
                        'description' => $new_todos[$i],
                        'status' => 'notDone',
                        'to_finish_at' => $new_todos_dates[$i],
                    ]);
                } else {
                    return json_encode(array('error'));
                }
            }
        }


        $todoes = Todo::where('user_id', $user_id)->get();
        $rendered ='';
        foreach($todoes as $todo){
            $rendered .='
            <li class="list-group-item" id="'. $todo->id .'">';
            if($todo->to_finish_at<now() && $todo->status=="notDone"){
                $rendered .='<div class="todo-indicator bg-danger"></div>';         
            }elseif($todo->status=="done"){
                $rendered .='<div class="todo-indicator bg-success"></div>';
            }else{
                $rendered .='<div class="todo-indicator bg-warning"></div>';         
            }
        $rendered .=' <div class="widget-content p-0">
            <div class="widget-content-wrapper">
                <div class="widget-content-left mr-2">
                    <div class="custom-checkbox custom-control">';
                if($todo->checkifFinished()){
                    $rendered .='<input class="checked_old_todos" type="checkbox" id="'.$todo->id.'" name="checked_old_todos[]" value="'.$todo->id.'" checked >';
                }else{
                    $rendered .='<input class="checked_old_todos" type="checkbox" id="'.$todo->id.'" name="checked_old_todos[]" value="'.$todo->id.'">';
                }
            $rendered .='</div>
                            </div>
                            <div class="widget-content-left">';
            $rendered .='<div class="widget-heading">'.$todo->description;
            $rendered .='</div>';
            $rendered .='<div class="widget-subheading"><i>finish it: '.$todo->to_finish_at.'</i></div>';
            $rendered .='</div>
                            <div class="widget-content-right">
                            <button class="border-0 btn-transition btn btn-outline-danger"  onclick="deleteTodo('."'". $todo->id ."'".')">
                            <i class="fa fa-trash"></i>
                            </button>
                            </div>
                            </div>
                            </div>
                        </li>';
            }
        return json_encode(array($rendered));
    }

    public function remove ()
    {
        $todo = Todo::find(request()->todoId);
        $todo->delete();
        return true;
    }
}
