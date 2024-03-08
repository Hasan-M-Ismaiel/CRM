<header class="header header-sticky mb-4">
    <div class="container-fluid">

        <!--side menu icon-->
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
            </svg>
        </button>

        <!--logo-->
        <a class="header-brand d-md-none" href="{{route('home')}}">
            <svg width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="{{ asset('assets/brand/TeamWorkOKWhite.svg#full') }}"></use>
            </svg>
        </a>

        <!--pages links left-->
        <ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Dashboard</a></li>
            @can('user_access')<li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Users</a></li>@endcan
            @can('user_access')<li class="nav-item"><a class="nav-link" href="{{ route('admin.clients.index') }}">Clients</a></li>@endcan
           <li class="nav-item"><a class="nav-link" href="{{ route('admin.projects.index') }}">Projects</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ route('admin.tasks.index') }}">Tasks</a></li>
            @can('create', App\Models\Skill::class)<li class="nav-item"><a class="nav-link" href="{{ route('admin.skills.index') }}">Skills</a></li>@endcan
        </ul>
        <!--pages links icons right-->
        <ul class="header-nav ms-auto">
            <!--create project-->
            @can('create', App\Models\Project::class)
            <li class="nav-item">
                <a class="nav-link iconClass" href="{{ route('admin.projects.create') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="add new project">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                    </svg>
                </a>
            </li>
            @endcan 
            <!--create task-->
            @can('create', App\Models\Task::class)
            <li class="nav-item">
                <a class="nav-link iconClass" href="{{ route('admin.tasks.create') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="add new task">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clipboard-plus" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7"/>
                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                    </svg>
                </a>
            </li>
            @endcan 
            <!--# of notifications-->
            <li class="nav-item">
                <a class="nav-link iconClass" href="{{ route('admin.notifications.index') }}">
                    @if(auth()->user()->unreadNotifications->count()==0)
                        <!--dont show-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                        </svg>
                        <em id ="num_of_notification" class="badge bg-danger text-white px-2 rounded-4"></em>
                    @else 
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                        </svg>
                        <em id ="num_of_notification" class="badge bg-danger text-white px-2 rounded-4">{{ auth()->user()->unreadNotifications->count() }}</em>
                    @endif
                </a>
            </li>
            <!--# of tasks-->
            <li class="nav-item">
                <a class="nav-link iconClass" href="{{ route('admin.tasks.index') }}">
                    @if(auth()->user()->numberOfOpenedTasks==0)
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                    </svg>
                    <em id ="num_of_tasks" class="badge bg-danger text-white px-2 rounded-4"></em>
                    @else
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                    </svg>
                    <em id ="num_of_tasks" class="badge bg-danger text-white px-2 rounded-4">{{ auth()->user()->numberOfOpenedTasks }}</em>
                    @endif
                </a>
            </li>
        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <!--image-->
                <a class="nav-link py-0 imageParentClass" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="top" title="{{auth()->user()->name}}">
                    @if(Auth::user()->profile && Auth::user()->profile->getFirstMediaUrl("profiles"))
                        <div class="avatar avatar-md">
                            <img class="avatar-img border border-success shadow mb-1" src='{{ Auth::user()->profile->getFirstMediaUrl("profiles") }}' alt="" />
                        </div>
                        <span class="ms-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </span>
                    @elseif(Auth::user()->getFirstMediaUrl("users"))
                        <div class="avatar avatar-md"><img class="avatar-img border border-success shadow mb-1" src='{{ Auth::user()->getMedia("users")[0]->getUrl("thumb") }}' alt="" /></div>
                        <span class="ms-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </span>
                    @else 
                        <div class="avatar avatar-md"><img class="avatar-img border border-success shadow mb-1" src="{{ asset('images/avatar.png') }}" alt=""></div>
                        <span class="ms-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </span>
                    @endif
                </a>
                <!--drop down-->
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Account</div>
                    </div>
                    <!-- remove the text-muted class & the style to activate the linke-->
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
                        </svg> Updates<span class="badge badge-sm bg-info ms-2">42</span>
                    </a>
                    <!-- <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-envelope-open') }}"></use>
                        </svg> Messages<span class="badge badge-sm bg-success ms-2">42</span>
                    </a> -->

                    <!--tasks-->
                    <a class="dropdown-item" href="{{ route('admin.tasks.index') }}">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-task') }}"></use>
                        </svg> Tasks
                        <span id="headerTasksDropdown" class="badge badge-sm bg-danger ms-2">
                            @if(auth()->user()->hasRole('admin'))
                            <?php $tasks = App\Models\Task::all();$tasks->count();?>
                            {{$tasks->count()}}
                            @elseif(auth()->user()->teamleaderon()->count()>0)
                            {{auth()->user()->numberOfTasksForAllProjects}}
                            @else
                            {{auth()->user()->numberOfAssignedTasks}}
                            @endif
                        </span>
                    </a>
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Settings</div>
                    </div>
                    <!--account-->
                    <a class="dropdown-item" href="{{ route('admin.users.show', Auth::user()) }}">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                        </svg> Account
                    </a>
                    <!--profile-->
                    <a class="dropdown-item" href="{{ route('admin.profiles.show', Auth::user()) }}">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                        </svg> Profile
                    </a>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
                        </svg> Settings
                    </a>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-credit-card') }}"></use>
                        </svg> Payments<span class="badge badge-sm bg-secondary ms-2">
                            10
                        </span>
                    </a>
                    <!--projects-->
                    <a class="dropdown-item" href="{{ route('admin.projects.index') }}">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-file') }}"></use>
                        </svg> Projects
                        <span id="headerProjectsDropdown" class="badge badge-sm bg-primary ms-2">
                            {{auth()->user()->projects()->count()}}
                        </span>
                    </a>
                    <div class="dropdown-divider text-muted" style="pointer-events: none; cursor: default;"></div>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                        </svg> Lock Account
                    </a>
                    <!--logout-->
                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                        </svg> 
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <!-- if breadcrumb is single--><span>Hello, {{auth()->user()->name}}</span>
                </li>
                <li class="breadcrumb-item active">
                    <span> work today for tomorrow</span>
                </li>
            </ol>
        </nav>
    </div>
</header>