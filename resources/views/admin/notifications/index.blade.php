@extends('layouts.app')

@section('content')
<div class="card p-5">
  <div class="container-fluid border my-3  ">
    <div class="row justify-content-center">
      <div class="card-create-project pt-4 my-3 mx-5 px-5">
        <h2 id="heading">{{ $page }}</h2>
        <p id="pcreateProject">dashboard to manage all created</p>
        <span id="ringing_bell" class="bi bi-bell-fill"></span>
        <div class="">
          <div class="row">
            <div class="">
              <div class="box shadow-sm rounded bg-white mb-3">
                <!--title-->
                <div class="box-title border-bottom p-3">
                    <h6 class="text-secondary"></h6>
                </div>
                <!--notification items-->
                <div class="box-body p-0">
                  @forelse ($notifications as $notification)
                    @if($notification->type == 'App\Notifications\TaskAssigned')
                      <!--notification item-->
                      <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">TASK: ASSINGED</div>
                              <!--message-->
                              <div class="small">There is a new task for you in project <strong>{{ $notification->data['project_title'] }}</strong>, be productive and finish it up, if you need any help contact with the teamleader</div>
                              <!--show task button-->
                              <a href="{{route('admin.tasks.show', $notification->data['task_id'])}}" style="text-decoration: none;" type="button" class="btn btn-outline-success btn-sm">View Task</a>
                              <!--task chat button-->
                              <a type="button" class="m-1" href="{{ route('admin.tasks.showTaskChat', $notification->data['task_id']) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat with teamleader">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                      <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                      <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                  </svg>
                              </a>
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @elseif ($notification->type == 'App\Notifications\TaskUnAssigned')
                       <!--notification item-->
                       <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">TASK: UN/ASSINGED</div>
                              <!--message-->
                              <div class="small">The task <strong>{{ $notification->data['task_title'] }}</strong> in the project <strong>{{ $notification->data['project_title'] }}</strong> is not assigned to you any more , wait for other tasks</div>
                              <!--show task button-->
                              <!--removed-->
                              <!--task chat button-->
                              <!--removed-->
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @elseif ($notification->type == 'App\Notifications\ProjectAssigned')
                      <!--notification item-->
                      <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">PROJECT: ASSINGED</div>
                              <!--message-->
                              <div class="small">There is a new project, you are now a team memeber of  <strong>{{ $notification->data['project_title'] }}</strong> project, be productive and collaborative with your team mates, if you need any help contact with the teamleader and your team mates on chat</div>
                              <!--show task button-->
                              <a href="{{route('admin.projects.show', $notification->data['project_id'])}}" style="text-decoration: none;" type="button" class="btn btn-outline-success btn-sm">View Project</a>
                              <!--task chat button-->
                              <a type="button" class="m-1" href="{{ route('admin.teams.show', $notification->data['project_id']) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat with team mates">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                      <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                      <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                  </svg>
                              </a>
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @elseif ($notification->type == 'App\Notifications\ProjectUnAssigned')
                      <!--notification item-->
                      <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">PROJECT: UN/ASSINGED</div>
                              <!--message-->
                              <div class="small">Now you are not a member in the project <strong>{{ $notification->data['project_title'] }}</strong>, wait for other projects to be in. GOOD LUCK</div>
                              <!--show task button-->
                              <!--removed-->
                              <!--task chat button-->
                              <!--removed-->
                              
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @elseif ($notification->type == 'App\Notifications\TaskWaitingNotification')
                      <!--notification item-->
                      <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">TASK: WAITING FOR ACCEPT</div>
                              <!--message-->
                              <div class="small">There is a task waiting for you to check it out. <strong>{{ $notification->data['task_title'] }}</strong>, be productive and check it out, if you need any clarification contact with the user who take this task</div>
                              <!--show task button-->
                              <a href="{{route('admin.tasks.show', $notification->data['task_id'])}}" style="text-decoration: none;" type="button" class="btn btn-outline-success btn-sm">View Task</a>
                              <!--task chat button-->
                              <a type="button" class="m-1" href="{{ route('admin.tasks.showTaskChat', $notification->data['task_id']) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat teamleader">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                      <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                      <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                  </svg>
                              </a>
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @elseif ($notification->type == 'App\Notifications\TeamleaderRoleAssigned')
                      <!--notification item-->
                      <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">PROJECT: TEAMLEADER</div>
                              <!--message-->
                              <div class="small">YOU are now a team leader for <strong>{{ $notification->data['project_title'] }}</strong> project, be productive and collaborate with your team, if you need to contact with your team member do it now !</div>
                              <!--show task button-->
                              <a href="{{route('admin.projects.show', $notification->data['project_id'])}}" style="text-decoration: none;" type="button" class="btn btn-outline-success btn-sm">View Project</a>
                              <!--task chat button-->
                              <a type="button" class="m-1" href="{{ route('admin.teams.show', $notification->data['project_id']) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat teamleader">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                      <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                      <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                  </svg>
                              </a>
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @elseif ($notification->type == 'App\Notifications\TeamleaderRoleUnAssigned')
                      <!--notification item-->
                      <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">PROJECT: NOT/TEAMLEADER</div>
                              <!--message-->
                              <div class="small">YOU are not a team leader for  <strong>{{ $notification->data['project_title'] }}</strong> project, wait for other responsbilities !</div>
                              <!--show task button-->
                              <!--removed-->
                              <!--task chat button-->
                              <!--removed-->
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @elseif ($notification->type == 'App\Notifications\ProjectDeleted')
                      <!--notification item-->
                      <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">PROJECT: DELETED</div>
                              <!--message-->
                              <div class="small">The project <strong>{{ $notification->data['project_title'] }}</strong> was removed, wait for other projects & tasks!</div>
                              <!--show task button-->
                              <!--removed-->
                              <!--task chat button-->
                              <!--removed-->
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @elseif ($notification->type == 'App\Notifications\TaskDeleted')
                      <!--notification item-->
                      <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">TASK: DELETED</div>
                              <!--message-->
                              <div class="small">The task <strong>{{ $notification->data['task_title'] }}</strong> from project <strong>{{ $notification->data['project_title'] }}</strong>, has been deleted, if there are any question, contact with the teamleader</div>
                              <!--show task button-->
                              <a href="{{route('admin.projects.show', $notification->data['project_id'])}}" style="text-decoration: none;" type="button" class="btn btn-outline-success btn-sm">View Project</a>
                              <!--task chat button-->
                              <a type="button" class="m-1" href="{{ route('admin.tasks.showTaskChat', $notification->data['task_id']) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat teamleader">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                      <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                      <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                  </svg>
                              </a>
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @elseif ($notification->type == 'App\Notifications\TaskMissed')
                      <!--notification item-->
                      <div class="selector p-3 d-flex align-items-center bg-light border-bottom osahan-post-header" id="{{ $notification->id }}">
                          <!--notification image-->
                          <div class="dropdown-list-image-notification mr-3">
                              <img class="rounded-circle" src="{{asset('assets/brand/teamwork_.jpg')}}" alt="TeamWork" />
                          </div>
                          <div class="font-weight-bold mr-3">
                              <!--title-->
                              <div class="text-truncate">TASK: MISSED</div>
                              <!--message-->
                              <div class="small">There is an old task <strong>{{ $notification->data['task_title'] }}</strong> waiting for you to finish it, in the project <strong>{{ $notification->data['project_title'] }}</strong>, be productive and finish it up, if you need any help contact with the teamleader, the time is important.</div>
                              <!--show task button-->
                              <a href="{{route('admin.tasks.show', $notification->data['task_id'])}}" style="text-decoration: none;" type="button" class="btn btn-outline-success btn-sm">View Task</a>
                              <!--task chat button-->
                              <a type="button" class="m-1" href="{{ route('admin.tasks.showTaskChat', $notification->data['task_id']) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat teamleader">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                      <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                      <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                  </svg>
                              </a>
                          </div>
                          <span class="ml-auto mb-auto">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-light-notification btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical"></i>
                                  </button>
                                  <!--delete notificaiton-->
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <button class="dropdown-item" type="button" onclick="marknotificationasread('{{ $notification->id }}')" data-id="{{ $notification->id }}"><i class="mdi mdi-delete"></i> Mard As Readed</button>
                                  </div>
                              </div>
                              <br />
                              <!--notification date-->
                              <div class="text-right text-muted pt-1">{{ $notification->created_at->diffForHumans() }}</div>
                          </span>
                      </div>
                    @endif 

                    @if ($loop->last)
                      <a id="mark_all" class=" btn text-secondary" onclick="markallread()">Mark all as read</a>
                    @endif
                    
                  @empty
                    <!-- <strong id="no_notifications" class="text-gray-600">No new notifications</strong> -->
                    <h5 class="text-center"> <span class="badge m-1" style="background: #673AB7;"  id="no_notifications">There is no projects in the company</span> </h5>
                  @endforelse
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--marknotificationasread / markallread-->
<script>
  function marknotificationasread(notificationId){
    axios.post("{{ route('admin.notifications.markNotification') }}" , {'notificationId': notificationId})
      .then(response => {
          //remove element
          document.getElementById(notificationId).remove();
          
          if(window.NumberOfNotifications - 1 == 0){
            $("#num_of_notification").remove();
          } else {
            $("#num_of_notification").html(window.NumberOfNotifications - 1); //  is in the app.blade layout file
            window.NumberOfNotifications = window.NumberOfNotifications - 1;
          }
      })
      .catch(errors => {
          if (errors.response.status == 401) {
      }});
  }

  function markallread(){
    axios.post("{{ route('admin.notifications.markNotification') }}")
      .then(response => {
          //remove elements
          const alerts = document.querySelectorAll('.selector');

          alerts.forEach(alert => {
          alert.remove();
          });
        $("#num_of_notification").remove();
        $("#mark_all").remove();
        $("#no_notifications").html("your notificaitons are readed");

      })
      .catch(errors => {
        if (errors.response.status == 401) {
      }});
  }
</script>

@endsection

